<?php

namespace common\models;

use Yii;
use yii\data\Pagination;

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
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Build a DB query to get all articles and
     * create a pagination object with the total count
     * @param int $display
     * @param $status
     * @param int $pageSize
     * @return array
     */
    public static function getAll($display = 1, $status = 'published', $pageSize = 2)
    {
        // build a DB query to get all articles with display = 1
        $query = News::find()->andWhere(['display' => $display])->andWhere(['status' => $status])->orderBy(['published_at' => SORT_DESC]);

        // get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

        // limit the query using the pagination and retrieve the articles
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $data['articles'] = $articles;
        $data['pagination'] = $pagination;

        return $data;
    }

    /**
     * Find all articles at category
     * @param $id
     * @param $status
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findAtCategory($id, $status = 'published')
    {
        return News::find()->andWhere(['category_id' => $id])->andWhere(['status' => $status])->all();
    }
}
