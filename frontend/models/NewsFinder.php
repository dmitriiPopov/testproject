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
     * @var Tags []
     */
    public $tags = [];

    /**
     * @return \yii\data\ActiveDataProvider
     */
    public function getDataProvider()
    {

        //set default query for getting News
        $mainQuery = News::find()
            ->andWhere(['display' => News::DISPLAY_ON])
            ->orderBy('published_at DESC');

        //check category if it's set
        if ($this->category) {
            // add conditions with category ID
            $mainQuery->andWhere(['category_id' => $this->category->id]);
        }

        //check tag if it's set
        if ($this->tags) {

            $mainQuery->joinWith([
                'newsTags' => function (\yii\db\ActiveQuery $query) {
                    $query->andWhere(['in', 'news_tags.tag_id', $this->tags]);
                }
            ]);
            //condition for sampling 'AND'
            $mainQuery->groupBy('news_tags.news_id')
                //TODO: зачем здесь HAVING ???
                ->andHaving("COUNT(*) = :count", [":count" => count($this->tags)])
            ;
        }

//        print($mainQuery->createCommand()->rawSql); die();

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