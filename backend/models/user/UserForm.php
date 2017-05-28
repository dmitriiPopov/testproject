<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 27.05.17
 * Time: 17:19
 */

namespace backend\models\user;

use common\components\BaseForm;
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
     * @return array
     */
    public function rules()
    {
        return [
            [['username','password','email'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['username', 'password'], 'string', 'max' => 255, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['email'], 'email', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
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

        //save AR model
        if (!$this->model->save($runValidation, $attributeNames)) {

            //get AR model errors and set it to form
            $this->addErrors($this->model->errors);

            return false;
        }

        return true;
    }

}