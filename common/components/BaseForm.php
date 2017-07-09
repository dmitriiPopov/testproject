<?php
namespace common\components;

/**
 * Class BaseForm
 * @package common\components
 */
class BaseForm extends \yii\base\Model
{
    const SCENARIO_CREATE  = 'create';
    const SCENARIO_UPDATE  = 'update';

    /**
     * @var \yii\db\ActiveRecord
     */
    protected $model;

    /**
     * @param \yii\db\ActiveRecord $model
     * @param boolean $setAttributes
     * @return void
     */
    public function setModel($model, $setAttributes = false)
    {
        $this->model = $model;
        //check input parameter $setAttributes
        //if $setAttributes is true then form attributes will be replaced by the same $model attributes
        if ($setAttributes) {
            //set model attributes to form attributes
            $this->setAttributes($this->model->attributes);
        }
    }

    /**
     * @return \yii\db\ActiveRecord | null
     */
    public function getModel()
    {
        return $this->model;
    }

}