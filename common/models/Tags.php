<?php

namespace common\models;

use Yii;
use common\components\behaviors\CreatedAtUpdatedAtBehavior;

/**
 * This is the model class for table "tags".
 *
 * @property integer $id
 * @property string $name
 * @property integer $enabled
 * @property integer $display
 * @property string $created_at
 * @property string $updated_at
 *
 * @property NewsTags[] $newsTags
 */
class Tags extends \yii\db\ActiveRecord
{
    const ENABLED_ON  = 1;
    const ENABLED_OFF = 0;

    const DISPLAY_ON  = 1;
    const DISPLAY_OFF = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enabled', 'display'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 127],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Name',
            'enabled'    => 'Enabled',
            'display'    => 'Display',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
    public function getNewsTags()
    {
        return $this->hasMany(NewsTags::className(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::className(), ['id' => 'news_id'])
            ->viaTable('news_tags', ['tag_id' => 'id']);
    }

    /**
     * @param bool $insert
     * @return boolean
     */
    public function beforeSave($insert)
    {
        if ($this->enabled == self::ENABLED_ON) {
            $this->display = self::DISPLAY_ON;
        } else {
            $this->display = self::DISPLAY_OFF;
        }

        return true;
    }

    /**
     * Method get count all news with the tag
     * @return int
     */
    public function getCountNews()
    {
        return $this->getNews()->count();
    }

    /**
     * Method get array all tags names for select2 widget
     * (if tag is disabled then name of tag -'tagName'-disabled)
     * @return array
     */
    public static function getAllTags()
    {
        $allTags = Tags::find()->all();
        //init data is array
        $data = array();
        foreach ($allTags as $tag) {
            //set array
            $data[$tag->name] = ($tag->enabled == 1 ? $tag->name : $tag->name.' (disabled)');
        }
        return $data;
    }
}
