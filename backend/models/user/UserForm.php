<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.05.17
 * Time: 17:19
 */

namespace backend\models\user;

use common\components\BaseForm;
use common\components\UploadedFile;
use common\models\Markers;
use Yii;
use yii\base\NotSupportedException;

/**
 * Class UserForm
 * @package backend\models\user
 *
 * @property \common\models\User $model
 *
 * Business logic for creating/updating user via backend CRUD
 */
class UserForm extends BaseForm
{
    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $status;

    /**
     * @var
     */
    public $avatar;

    /**
     * @var double
     */
    public $latitude;

    /**
     * @var double
     */
    public $longitude;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username','email'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['password'], 'required', 'on' => [self::SCENARIO_CREATE]],
            [['username', 'password'], 'string', 'max' => 255, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['email'], 'email', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['status'], 'string', 'on' => [self::SCENARIO_UPDATE]],
            [['avatar'], 'image', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['latitude', 'longitude'], 'double', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]]
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('app', 'Password'),
        ];
    }

    /**
     * @param bool|true $runValidation
     * @param array|null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        //set attributes to AR model
        $this->model->setAttributes($this->attributes);

        //do operations for CREATE scenario
        if (in_array($this->scenario, [self::SCENARIO_CREATE])) {
            //generate specific attributes
            $this->model->generateAuthKey();
            $this->model->generatePasswordResetToken();
        }

        //set new password
        //ATTENTION: in view file this field must be empty at form input
        if (!empty($this->password)) {
            $this->model->setPassword($this->password);
        }

        //get the instance of uploaded file
        $this->avatar = UploadedFile::getInstance($this, 'avatar');

        //if file uploaded
        if($this->avatar) {
            //set the name of avatar for database
            $this->model->imagefile = md5(uniqid() . time()) . '.' . $this->avatar->extension;

            //save avatar
            $this->avatar->saveAs(
                \Yii::$app->params['absoluteStaticBasePath'] . '/'
                . \Yii::$app->params['staticPathUserAvatar'] . '/'
                . $this->model->imagefile
            );
        }

        //check isset 'longitude' and 'latitude'
        if ($this->longitude && $this->latitude) {
            //check if marker at User model isn't found
            if (!$this->model->marker_id) {
                //create marker
                $marker            = new Markers();
                //set marker's attributes
                $marker->longitude = $this->longitude;
                $marker->latitude  = $this->latitude;
            } else {
                //search marker by id
                $marker            = Markers::findOne(['id' => $this->model->marker_id]);
                //set marker's attributes
                $marker->longitude = $this->longitude;
                $marker->latitude  = $this->latitude;
            }
            //save marker to DB
            $marker->save();
            //set marker_id at User model
            $this->model->marker_id = $marker->id;
        };

        //save AR model
        if (!$this->model->save($runValidation, $attributeNames)) {

            //get AR model errors and set it to form
            $this->addErrors($this->model->errors);

            return false;
        }

        return true;
    }

}