<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PilotInhouseUser;

/**
 * PilotInhouseUserSearch represents the model behind the search form about `backend\models\PilotInhouseUser`.
 */
class PilotInhouseUserSearch extends PilotInhouseUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'role'], 'integer'],
            [['username', 'emailaddress', 'password', 'last_login_id', 'last_access_time', 'firstname', 'lastname'], 'safe'],
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
        $query = PilotInhouseUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
              'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'role' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'emailaddress', $this->emailaddress])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'last_login_id', $this->last_login_id])
            ->andFilterWhere(['like', 'last_access_time', $this->last_access_time])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname]);

        return $dataProvider;
    }
}
