<?php

namespace common\models;

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
 */
class Category extends \yii\db\ActiveRecord
{
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
            'id' => 'ID',
            'title' => 'Category Name',
            'enabled' => 'Enabled',
            'display' => 'Display',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategory()
    {
        return $this->hasMany(News::className(), ['category_id' => 'id']);
    }

    /*
     * @return Articles count in Category
     */
    public function getArticlesCount()
    {
        return $this->getNewsCategory()->andWhere(['status' => 'published'])->count();
    }

    /**
     * Build a DB query to get all categories
     * @param int $display
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAll($display = 1)
    {
        return Category::find()->andWhere(['display' => $display])->all();
    }
}
