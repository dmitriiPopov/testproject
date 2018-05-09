<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 07.11.17
 * Time: 20:07
 */

namespace backend\models\tags;

use common\components\BaseForm;

/**
 * Class TagsForm
 * @package backend\models\tags
 *
 * @property \common\models\Tags $model
 *
 * Business logic for creating/updating user via backend CRUD
 */
class TagsForm extends BaseForm
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $enabled;

    /**
     * @var integer
     */
    public $display;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['name'], 'string', 'max' => 127, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['enabled', 'display'], 'integer', 'max'=>1, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        //set attributes to AR model
        $this->model->setAttributes($this->attributes);

        //save AR model
        if (!$this->model->save($runValidation, $attributeNames)) {

            //get AR model errors and set it to form
            $this->addErrors($this->model->errors);

            return false;
        }

        return true;
    }

}