<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 18.06.17
 * Time: 15:55
 */

namespace backend\models\news;


use common\components\BaseForm;
use common\models\News;

/**
 * Class NewsForm
 * @package backend\models\news
 *
 * @property \common\models\News $model
 *
 * Business logic for creating/updating user via backend CRUD
 */

class NewsForm extends BaseForm
{
    /**
     * @var string
     */
    //public $imagefile;

    /**
     * @var integer
     */
    public $category_id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $description;

    /**
     * @var string
     */
    public $content;

    /**
     * @var string
     */
    public $status;

    /**
     * @var integer
     */
    public $enabled;

    /**
     * @var integer
     */
    public $display;

    /**
     * @var string
     */
    public $public_at;

    /**
     * @var array
     */
    public $tagsArr;


    public function rules()
    {
        return [
            [['category_id', 'title', 'description', 'content', 'status'], 'required', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['title', 'description', 'content', 'public_at'], 'string', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            [['category_id', 'enabled', 'display'], 'integer', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]],
            array('tagsArr', 'safe', 'on' => [self::SCENARIO_CREATE, self::SCENARIO_UPDATE]),
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category',
            'tagsArr'     => 'Tags'
        ];
    }

    //EXAMPLE
    /*public function setModel($model, $setAttributes = false)
    {
        parent::setModel($model, $setAttributes);

        //check $setAttributes flag
        if ($setAttributes) {
            //set model attributes to form attributes with another names
            $this->setAttributes([
                'specificFormAttributeNameFuck' => $this->model->exampleField1,
            ]);
        }
    }*/

    public function save($runValidation = true, $attributeNames = null)
    {

        if ($runValidation) {
            //validate form attributes. If attributes aren't valid then to break saving and return false
            if (!$this->validate($attributeNames)) {
                return false;
            }
        }

        //set attributes to AR model
        $this->model->setAttributes($this->attributes);

        //check selected scenario and do appropriated operations below...
        if (in_array($this->scenario, [self::SCENARIO_CREATE, self::SCENARIO_UPDATE])) {

            //check status `PUBLICATE` and do appropriated operations
            if ($this->status == News::STATUS_PUBLICATE) {
                //instead of this logic add field with calendar on view
                //if data is set -> set that date to field public_at
                //if date isn't set -> add default current date (date('Y-m-d H:i:s', time());)
                $this->model->public_at = ($this->public_at) ? $this->public_at : date('Y-m-d H:i:s');
            } else {
                //reset public_at date
                $this->model->public_at = null;
            }

            //check status `PUBLISHED` and do appropriated operations
            if ($this->status == News::STATUS_PUBLISHED && empty($this->model->published_at)) {
                //set current `published_at` date
                $this->model->published_at = date('Y-m-d H:i:s');
                //check status NOT `PUBLISHED` and do appropriated operations
            } elseif ($this->status != News::STATUS_PUBLISHED ) {
                //reset `published_at` date
                $this->model->published_at = null;
            }
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