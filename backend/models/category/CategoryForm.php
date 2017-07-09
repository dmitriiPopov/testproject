<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 09.06.17
 * Time: 16:35
 */

namespace backend\models\category;

use common\components\BaseForm;
use Yii;

/**
 * Class CategoryForm
 * @package backend\models\category
 *
 * @property \common\models\Category $model
 *
 * Business logic for creating/updating user via backend CRUD
 */

class CategoryForm extends BaseForm
{
    /**
     * @var string
     */
    public $title;

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
            [['title'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['title'], 'string', 'max' => 255, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['enabled', 'display'], 'integer', 'max'=>1, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
        ];
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        //set attributes to AR model
        $this->model->setAttributes($this->attributes);

        //do operations for CREATE scenario
        if (in_array($this->scenario, [self::SCENARIO_CREATE])) {
            //generate date attributes
            //@TODO: move to behavior
            $this->model->created_at = date('Y-m-d H:i:s', time());
        }

        //do operations for UPDATE scenario
        if (in_array($this->scenario, [self::SCENARIO_UPDATE])) {
            //generate date attributes
            //@TODO: move to behavior
            $this->model->updated_at = date('Y-m-d H:i:s', time());
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