<?php

namespace common\models;

use Yii;
use common\components\behaviors\CreatedAtUpdatedAtBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "news".
 *
 * @property integer $id
 * @property string $imagefile
 * @property integer $category_id
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $status
 * @property integer $enabled
 * @property integer $display
 * @property string $created_at
 * @property string $updated_at
 * @property string $public_at
 * @property string $published_at
 *
 * @property Category[] $category
 * @property Tags[]     $tags
 */
class News extends \yii\db\ActiveRecord
{
    //variables of `status`
    const STATUS_NEW       = 'new';
    const STATUS_PUBLICATE = 'publicate';
    const STATUS_PUBLISHED = 'published';

    const ENABLED_ON  = 1;
    const ENABLED_OFF = 0;

    const DISPLAY_ON  = 1;
    const DISPLAY_OFF = 0;

    //TODO: удали это одинокое непонятное свойство. Почему?  См. todo ниже по классу
    //variable for tag
    public $tagsArr;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'required'],
            [['category_id', 'enabled', 'display'], 'integer'],
            [['content', 'status'], 'string'],
            [['created_at', 'updated_at', 'public_at', 'published_at'], 'safe'],
            [['imagefile', 'description'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 127],

            [['imagefile'], 'default', 'value' => ''],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'imagefile'    => 'Imagefile',
            'category_id'  => 'Category',
            'title'        => 'Title',
            'description'  => 'Description',
            'content'      => 'Content',
            'status'       => 'Status',
            'enabled'      => 'Enabled',
            'display'      => 'Display',
            'created_at'   => 'Created At',
            'updated_at'   => 'Updated At',
            'public_at'    => 'Public At',
            'published_at' => 'Published At',
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [

            'createdAtUpdatedAtBehavior' => [
                'class' => CreatedAtUpdatedAtBehavior::className(),
            ]
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'tag_id'])
            ->viaTable('news_tags', ['news_id' => 'id']);
    }

    /**
     * Return statuses with labels
     * @param array $params
     * @return array
     */
    public static function getStatuses($params = [])
    {
        return [
            self::STATUS_NEW       => Yii::t('app', 'New'),
            self::STATUS_PUBLICATE => Yii::t('app', 'Publicate'),
            self::STATUS_PUBLISHED => Yii::t('app', 'Published'),
        ];
    }

    /**
     * @param bool $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //CHECK 'enabled' and 'status' for DISPLAY news
            if ($this->enabled == self::ENABLED_ON && $this->status == self::STATUS_PUBLISHED) {
                $this->display = self::DISPLAY_ON;
            } else {
                $this->display = self::DISPLAY_OFF;
            }

            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            //delete all records belonging to the identifier from News_tags table
            NewsTags::deleteAll(['news_id' => $this->id]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * TODO: нет tagsArr - не должно быть и метода
     * TODO: в этом методе должна быть логика, которая еще не реализована в ActiveRecord и нужна абсолютно всегда при поиске записи в бвзе даных.
     */
    public function afterFind()
    {
        //set 'tags' field in model
        //TODO: форматирвоание данных нужно чаще всего делать там, где оно непосредственно нужно.
        //TODO: это удалишь
        $this->tagsArr = ArrayHelper::map($this->tags, 'name', 'name');
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);


        // TODO: попробуй использовать NewsTags::addTagsToNewsByTagsIds() прямо в классе формы после сохранения Новости. Вынеси в класс формы логику ниже.
        // TODO: из бавиться от tagsArr в модели ... я уже это свойство удалил и надеюсь оно не появится тут:)
        if(is_array($this->tagsArr)){
            //set tags similar to news
            $oldTags = ArrayHelper::map($this->tags, 'name', 'id');

            foreach ($this->tagsArr as $newTag){
                //check new tag in old_tags array
                if (isset($oldTags[$newTag])){
                    //remove from old_tags array
                    unset($oldTags[$newTag]);
                }else{
                    //create new tag
                    if($this->addTag($newTag)){
                        // TODO: нет инкапсуляции
                        // TODO: все что связано с сессия и куками должно быть вне классов форм и моделей.
                        // TODO: только контроллеры, отображения или как исклечения - классы, которые используются только для веб-юзера
                        // TODO: вынести
                        Yii::$app->session->addFlash('error', 'The Tags for the news '.$this->title.' has not been added');
                    }
                }
            }
            //delete all records from News_tags table where not use old tags
            NewsTags::deleteAll(['and', ['news_id' => $this->id], ['tag_id' => $oldTags]]);
        }else{
            //delete all records belonging to the identifier from News_tags table
            NewsTags::deleteAll(['news_id' => $this->id]);
        }
    }

    /**
     * @param $newTag
     * @return bool
     *
     * TODO: этот метод удалить и использовать NewsTags::addTagsToNewsByTagsIds(). Вынеси в него эту логику.
     * TODO: есть такой термин в программирование - "Высокое зацепление" - это значит что класс должен выполнять логически присущие ему вещи.
     * TODO: например, в случае новой функции в классе овтечающим за связь, появляется метод который эту связь и создает. Все логично и взаимосвязано по смыслу :)
     * TODO: больше информации по "высокому зацеплению" гугли по аббревматуре - SOLID. Если нагуглишь, но после первого прочтения будет непонятно, то не закрывай и не читай дальше. Обсудим потом))))
     */
    public function createAddTag($newTag){
        //if newTag not found in Tags table
        if(!$tag = Tags::find()->andWhere(['name' => $newTag])->one()){
            //create new tag
            $tag          = new Tags();
            //set name new tag
            $tag->name    = $newTag;
            $tag->enabled = self::ENABLED_ON;
            //save new tag
            if(!$tag->save()){
                $tag = null;
                // TODO: нет инкапсуляции
                // TODO: все что связано с сессия и куками должно быть вне классов форм и моделей.
                // TODO: только контроллеры, отображения или как исключения - классы, которые используются только для веб-юзера
                // TODO: вынести
                Yii::$app->session->addFlash('error', 'Tag '.$newTag.' has not been added');
            }else{
                Yii::$app->session->addFlash('success', 'Add new Tag '.$newTag);
            }
        }
        //check instance
        if ($tag instanceof Tags){
            //var_dump($tag);die;
            //create new record in news_tags table
            $newsTags          = new NewsTags();
            //set params
            $newsTags->news_id = $this->id;
            $newsTags->tag_id  = $tag->id;
            //save record
            if ($newsTags->save()){
                return true;
            }
        }
        return false;
    }
}
