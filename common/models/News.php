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
 * @property Category   $category
 * @property Tags[]     $tags
 * @property NewsTags[] $newsTags
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
            'title'        => 'Article Title',
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
     * @return \yii\db\ActiveQuery
     */
    public function getNewsTags()
    {
        return $this->hasMany(NewsTags::className(), ['news_id' => 'id']);
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
     * @param array $tagsIds
     * @return bool
     */
    public function addTagsByTagsIds($tagsIds = [])
    {
        return NewsTags::addTagsToNewsByTagsIds($this, $tagsIds);
    }
}
