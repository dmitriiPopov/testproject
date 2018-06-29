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
use common\models\News;
use frontend\components\helpers\StopWordsHelper;

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
    /**
     * @var integer
     */
    public $id;

    /**
     * Article which is commented by selected comment
     * @var int
     */
    public $articleId;

    /**
     * User which is commented by selected comment
     * @var int
     */
    public $userId;

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
        // Валидаторы и фильтры выполняются в указанном порядке
        return [
            [['name'], 'trim'],
            // сначала валидируем на заполненность
            [['name', 'content', 'articleId', 'userId'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['name'], 'string', 'min' =>1, 'max' => 20, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['content'], 'string', 'min' =>1, 'max' => 200, 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            //а потом уже на плохие слова, так как нет смысла валидировать на плохие слова, если данные не пришли из формы
            [['name', 'content'], 'censureWordsValidator', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
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

    public function save($runValidation = true, $attributeNames = null)
    {
        // validate form if it's set
        if ($runValidation && !$this->validate($attributeNames))
        {
            return false;
        }

        //set attributes to AR model
        $this->model->setAttributes($this->attributes);

        //set other attributes
        $this->model->user_id = $this->userId;
        $this->model->news_id = $this->articleId;
        //$this->model->enabled = Comment::ENABLED_ON;

        //save AR model
        if (!$this->model->save($runValidation, $attributeNames)) {

            //get AR model errors and set it to form
            $this->addErrors($this->model->errors);
            return false;
        }

        return true;
    }

    /**
     * @param $model Comment
     * @param boolean $setAttributes
     * @return void
     */
    public function setModel($model, $setAttributes = false)
    {
        //call parent function
        parent::setModel($model, $setAttributes);

        //check scenario Update
        if ($this->getScenario() == self::SCENARIO_UPDATE) {
            //set article id
            $this->articleId = $model->news_id;
            //set user id
            $this->userId    = $model->user_id;
            // set comment id if it exists (primary key)
            $this->id        = $model->id;
        }
    }

    /**
     * Finding "BAD" words in the string
     * @param $attribute
     */
    public function censureWordsValidator($attribute)
    {
        //include array with "BAD" words
        $words = StopWordsHelper::getCensuredWords();
        //var_dump($words);die;
        foreach ($words as $item) {

            //check if there is a "BAD" word in the string
            if (preg_match("/\b".$item."\b/i", $this->$attribute)){
                //if there is
                $this->addError($attribute,'Censured word!');
            }

        }

    }

    /**
     * Set article id
     * @param $articleModel News
     *
     * @return void
     */
    public function setArticleModel($articleModel)
    {
        if (isset($articleModel)) {
            $this->articleId = $articleModel->id;
        }
    }
}