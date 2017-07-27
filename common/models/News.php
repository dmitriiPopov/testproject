<?php

namespace common\models;

use Yii;
use common\components\behaviors\CreatedAtUpdatedAtBehavior;

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
            'imagefile' => 'Imagefile',
            'category_id' => 'Category',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'status' => 'Status',
            'enabled' => 'Enabled',
            'display' => 'Display',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'public_at' => 'Public At',
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
     * Return statuses with labels
     * @param array $params
     * @return array
     */
    public static function getStatuses($params = [])
    {
        return [
            self::STATUS_NEW       => Yii::t('app', 'New'),
            self::STATUS_PUBLICATE => Yii::t('app', 'publicate'),
            self::STATUS_PUBLISHED => Yii::t('app', 'published'),
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
}
