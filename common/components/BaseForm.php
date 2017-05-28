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
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return \yii\db\ActiveRecord | null
     */
    public function getModel()
    {
        return $this->model;
    }

}