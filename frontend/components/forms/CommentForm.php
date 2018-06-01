<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 09.05.18
 * Time: 21:20
 */

namespace frontend\components\forms;


use common\components\BaseForm;
use common\models\Comment;

/**
 * Class CommentForm
 * @package frontend\components\forms
 *
 * @property \common\models\Comment $model
 *
 * Business logic for create and updating user via frontend
 */
class CommentForm extends BaseForm
{
    /*
     * @var string
     */
    public $name;
    /*
     * @var string
     */
    public $content;


    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name', 'content'], 'required'],
            [['name'], 'string', 'max' => 30, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['content'], 'string', 'max' => 200, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
        ];
    }

    /*
     * @param integer $articleId
     */
    public function save($articleId, $runValidation = true, $attributeNames = null)
    {
        //set attributes to AR model
        $this->model->setAttributes($this->attributes);

        //set other attributes
        $this->model->user_id = \Yii::$app->user->id;
        $this->model->news_id = $articleId;
        $this->model->enabled = Comment::ENABLED_ON;

        //save AR model
        if (!$this->model->save($runValidation, $attributeNames)) {

            //get AR model errors and set it to form
            $this->addErrors($this->model->errors);
            return false;
        }

        return true;
    }
}