<?php

namespace common\models;

use yii\behaviors\TimestampBehavior;
use Yii;
use common\models\Marker;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $imagefile
 * @property integer $marker_id
 *
 * @property Marker $marker
 */
class User extends \yii\db\ActiveRecord
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE  = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['status', 'marker_id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'imagefile', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['email'], 'email'],



            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'username'             => 'Username',
            'imagefile'            => 'Image',
            'auth_key'             => 'Auth Key',
            'password_hash'        => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email'                => 'Email',
            'status'               => 'Status',
            'marker_id'            => 'Marker',
            'created_at'           => 'Created At',
            'updated_at'           => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarker()
    {
        return $this->hasOne(Marker::className(), ['id' => 'marker_id']);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * @return string
     */
    public function getImageFileLink()
    {
        return ($this->imagefile && file_exists($this->getImageFileAbsolutePath()))
            ? sprintf('%s/%s/%s',  Yii::$app->params['staticBaseUrl'],  Yii::$app->params['staticPathUserAvatar'], $this->imagefile)
            : sprintf('%s/%s',  Yii::$app->params['staticHost'],  Yii::$app->params['staticUserAvatarDefault']);
    }

    /**
     * @return string
     */
    public function getImageFileAbsolutePath()
    {
        return sprintf('%s/%s/%s',  Yii::$app->params['absoluteStaticBasePath'],  Yii::$app->params['staticPathUserAvatar'], $this->imagefile);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        foreach ($changedAttributes as $attribute => $value){
            //check old attribute 'imagefile'
            if($attribute == 'imagefile' && !empty($value)){
                //set absolute path with old image
                $oldImage = sprintf('%s/%s/%s',  Yii::$app->params['absoluteStaticBasePath'],  Yii::$app->params['staticPathUserAvatar'], $value);
                //check image on server
                if(file_exists($oldImage) && is_file($oldImage)){
                    //delete image
                    unlink($oldImage);
                }
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool
     * @throws \Exception
     * @throws \Throwable
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        //if user model delete and marker id is set
        if ($this->marker) {
            //delete marker from DB
            $this->marker->delete();
        }

        return true;
    }
}
