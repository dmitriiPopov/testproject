<?php

namespace common\models;

use common\components\behaviors\CreatedAtUpdatedAtBehavior;
use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $id
 * @property string $title
 * @property integer $enabled
 * @property integer $display
 * @property string $created_at
 * @property string $updated_at
 *
 *
 * @property News[] $news
 * @property News[] $publishedNews
 */
class Category extends \yii\db\ActiveRecord
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
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enabled', 'display'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'title'      => 'Category Name',
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
    public function getNews()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     *
     * TODO REMOVE AFTER CHECKING
     */
    /*public function getPublishedNews()
    {
        return $this->getNews()
            ->alias('publishedNews')
            ->onCondition(['publishedNews.display' => News::DISPLAY_ON]);
    }*/

    /**
     * @return integer Articles count in Category
     *
     * TODO REFACTOR WITH DIMA (LATER)
     */
    public function getArticlesCount()
    {
        return $this->getNews()->andWhere(['status' => News::STATUS_PUBLISHED])->count();
    }

    /**
     * @param bool $insert
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

}
