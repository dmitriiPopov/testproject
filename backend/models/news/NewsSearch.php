<?php

namespace backend\models\news;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\News;

/**
 * NewsSearch represents the model behind the search form about `common\models\News`.
 */
class NewsSearch extends News
{

    public $tag_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'tag_id'], 'integer'],
            [['imagefile', 'title', 'description', 'content', 'status', 'enabled', 'display', 'created_at', 'updated_at', 'public_at', 'published_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = News::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('category');

        // grid filtering conditions
        $query->andFilterWhere([
            //TODO: а айдишник кстати в админках на разных роектах всегда присутсвует в фильтре - это очень удобно
            //'id'           => $this->id,
            'category_id' => $this->category_id,
        ]);

        if (!empty($this->created_at)) {
            //  TODO: between условие быстрее всего работает с датами в диапазонах и учитывает индекс (тут конечно индекса нет на этом поле, но это тебе инфа на будущее)
            $query->andFilterWhere([
                'between',
                'news.created_at',
                sprintf('%s 00:00:00', $this->created_at),// `created_at` has 'Y-m-d' format
                sprintf('%s 23:59:59', $this->created_at)// `created_at` has 'Y-m-d' format

            ]);
        }

        if (!empty($this->tag_id)) {

            $tagId = $this->tag_id;

            $query->joinWith([
                'newsTags' => function(\yii\db\ActiveQuery $query) use ($tagId) {
                    $query->andWhere(['news_tags.tag_id' => $tagId]);
                }
            ]);
        }

        //TODO: убрал неиспользуемые фильтры
        $query->andFilterWhere(['like', 'news.title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'news.display', $this->display]);

        return $dataProvider;
    }
}
