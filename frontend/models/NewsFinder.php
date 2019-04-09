<?php
namespace frontend\models;


use common\models\Category;
use common\models\News;
use common\models\Tags;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\sphinx\Query;

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
     * @var array List of news_tags.id
     */
    public $tags = [];

    /**
     * @var string
     */
    public $searchQuery = '';

    /**
     * @return \yii\data\BaseDataProvider
     */
    public function getDataProvider()
    {
        $newsIds = $dataQuery = [];

        // если есть запрос ищем в сфинксе
        if (!empty($this->searchQuery)) {
            $query     = new Query();
            $dataQuery = $query->from('news','news_delta')
                ->match($this->searchQuery)
                ->all();
        }

        // нашли айдишки
        if (!empty($dataQuery)) {

            //array_map - нужна еще функция + данные которые нужны $item['id'] находятся не в виде массива
            foreach ($dataQuery as $item) {
                if ($item['id']) {
                    array_push($newsIds, $item['id']);
                }
            }
        }

        // если есть запрос,но данные не найдены в индексе сфинкса, то считаем, что ничего не найдено
        // и проверка категории и тегов ниже не актуальна и ее не нужно делать
        if (!empty($this->searchQuery) && empty($dataQuery)){
            return new ArrayDataProvider([]);
        }

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
                //TODO: ЭТО просто работает! Но потом подумать почему так
                ->andHaving("COUNT(*) = :count", [":count" => count($this->tags)])
            ;
        }

        if (!empty($newsIds)) {
            $mainQuery->andWhere(['in', 'news.id', $newsIds]);
        }

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