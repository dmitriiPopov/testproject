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
use frontend\components\helpers\StopWordsHelper;
use Yii;

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
            ['name', 'findWord'],
            ['content', 'findWord'],
            [['name'], 'trim'],
            [['name', 'content'], 'required'],
            [['name'], 'string', 'min' =>1, 'max' => 30, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['content'], 'string', 'min' =>1, 'max' => 200, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
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

    /**
     * Finding "BAD" words in the string
     * If isn't found "BAD" words in the string
     */
    public function findWord($attribute)
    {
        //include array with "BAD" words
        $words = StopWordsHelper::getCensuredWords();
        //var_dump($words);die;
        foreach ($words as $item) {

            //check if there is a "BAD" word in the string
            if (preg_match("/\b".$item."\b/i", $this->$attribute)){
                //if there is
                $this->addError($this->$attribute,'Censured word!');
            }

        }

    }
}