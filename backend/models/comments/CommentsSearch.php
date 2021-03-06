<?php

namespace backend\models\comments;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comment;

/**
 * CommentsSearch represents the model behind the search form of `common\models\Comment`.
 */
class CommentsSearch extends Comment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'news_id', 'enabled'], 'integer'],
            [['name', 'content', 'created_at', 'updated_at'], 'safe'],
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
        $query = Comment::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'news_id'    => $this->news_id,
            'enabled'    => $this->enabled,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ]);

        if (!empty($this->created_at)) {
            $query->andFilterWhere([
                'between',
                'comments.created_at',
                sprintf('%s 00:00:00', $this->created_at),// `created_at` has 'Y-m-d' format
                sprintf('%s 23:59:59', $this->created_at)// `created_at` has 'Y-m-d' format

            ]);
        }

        $query->andFilterWhere(['like', 'content', $this->content]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
