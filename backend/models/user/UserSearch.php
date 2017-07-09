<?php

namespace backend\models\user;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use \common\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\user\User`.
 */
class UserSearch extends \common\models\User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'created_at', 'updated_at'], 'safe'],
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
     * Create date interval at UNIX time
     *
     * @param $searchDate
     *
     * @return array
     */
    public function dateFilter($searchDate)
    {
        // date to search
        $date = \DateTime::createFromFormat('Y-m-d', $searchDate);
        $date->setTime(0,0,0);

        // set lowest date value
        $unixDateStart = $date->getTimestamp();

        // add 1 day and substract 1 second
        $date->add(new \DateInterval('P1D'));
        $date->sub(new \DateInterval('PT1S'));

        // set highest date value
        $unixDateEnd = $date->getTimeStamp();

        return array($unixDateStart, $unixDateEnd);
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
        $query = User::find();

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
            'id' => $this->id,
            'status' => $this->status,
        ]);

        //if create and update date filtering
        if($this->created_at || $this->updated_at) {

            if ($this->created_at && $this->updated_at) {
                //set date at UNIX time
                $unixDateCreate = $this->dateFilter($this->created_at);
                $unixDateUpdate = $this->dateFilter($this->updated_at);

                $query->andFilterWhere(['between', 'created_at', $unixDateCreate[0], $unixDateCreate[1]])
                    ->andFilterWhere(['between', 'updated_at', $unixDateUpdate[0], $unixDateUpdate[1]]);

            } elseif (!$this->updated_at) {

                //set date at UNIX time
                $unixDateCreate = $this->dateFilter($this->created_at);

                $query->andFilterWhere(['between', 'created_at', $unixDateCreate[0], $unixDateCreate[1]]);

            } elseif (!$this->created_at) {

                //set date at UNIX time
                $unixDateUpdate = $this->dateFilter($this->updated_at);

                $query->andFilterWhere(['between', 'updated_at', $unixDateUpdate[0], $unixDateUpdate[1]]);
            }
        }

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);



        return $dataProvider;
    }
}
