<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 02.05.18
 * Time: 18:48
 */

namespace backend\models\comments;

use common\components\BaseForm;


/**
 * Class CommentForm
 * @package backend\models\comments
 *
 * @property \common\models\Comment $model
 *
 * Business logic for updating user via backend
 */
class CommentForm extends BaseForm
{
    /*
     * @var integer
     */
    public $user_id;
    /*
     * @var integer
     */
    public $news_id;
    /*
     * @var string
     */
    public $name;
    /*
     * @var string
     */
    public $content;
    /*
     * @var integer
     */
    public $enabled;


    public function rules()
    {
        return [
            [['user_id', 'news_id', 'enabled'], 'integer', 'on' => [self::SCENARIO_UPDATE]],
            [['content'], 'string', 'max' => 200, 'on' => [self::SCENARIO_UPDATE]],
            [['name'], 'string', 'max' => 50, 'on' => [self::SCENARIO_UPDATE]],
            [['name', 'content'], 'required']
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User',
            'news_id' => 'Article',
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