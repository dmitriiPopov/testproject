<?php
namespace frontend\models;


use common\models\Category;
use common\models\News;
use common\models\Tags;
use yii\data\ActiveDataProvider;

/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 09.12.17
 * Time: 20:43
 */
class NewsFinder
{

    /**
     * @var Category
     */
    public $category = null;

    /**
     * @var Tags
     */
    public $tag = null;

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function getDataProvider()
    {

        //set default query for getting News
        $mainQuery = News::find()
            ->andWhere(['display' => News::DISPLAY_ON])
            ->orderBy('published_at DESC');
        // set default selected category
        $selectedCategory = null;
        // set default selected tag
        $selectedTag      = null;


        //check tag if it's set
        if ($this->tag) {

            $tagId = $this->tag->id;

            $mainQuery->joinWith([
                'newsTags' => function(\yii\db\ActiveQuery $query) use ($tagId) {
                    $query->andWhere(['news_tags.tag_id' => $tagId]);
                }
            ]);
        }

        //check category if it's set
        if ($this->category) {
            // add conditions with category ID
            $mainQuery->andWhere(['category_id' => $this->category->id]);
        }
        //var_dump(111);
        //print($mainQuery->createCommand()->rawSql); die();


        //List of news
        $dataProvider = new ActiveDataProvider([
            'query'      => $mainQuery,
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        return $dataProvider;
    }
}