<?php

namespace common\models;

use common\components\behaviors\CreatedAtUpdatedAtBehavior;
use Yii;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property int $user_id
 * @property int $news_id
 * @property string $name
 * @property string $content
 * @property int $enabled
 * @property string $created_at
 * @property string $updated_at
 *
 * @property News $news
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    const ENABLED_ON  = 1;
    const ENABLED_OFF = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'news_id'], 'required'],
            [['id', 'user_id', 'news_id', 'enabled'], 'integer'],
            [['name'], 'string', 'max' => 50],
            [['content'], 'string'],
            [['id'], 'unique'],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            ['enabled', 'default', 'value' => self::ENABLED_ON],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'user_id'    => 'User',
            'news_id'    => 'Article',
            'name'       => 'Name',
            'content'    => 'Content',
            'enabled'    => 'Enabled',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'createdAtUpdatedAtBehavior' => [
                'class' => CreatedAtUpdatedAtBehavior::className(),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
