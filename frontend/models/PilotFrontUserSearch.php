<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontUser;

/**
 * PilotFrontUserSearch represents the model behind the search form about `frontend\models\PilotFrontUser`.
 */
class PilotFrontUserSearch extends PilotFrontUser {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'last_access_time', 'created', 'updated', 'status'], 'integer'],
            [['username', 'emailaddress', 'password', 'role', 'company_id','team_id', 'last_login_id', 'firstname', 'lastname', 'profile_pic', 'dob', 'ip_address', 'address','device'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = PilotFrontUser::find()->orderBy(['id' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 50,
            ],
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
            'last_access_time' => $this->last_access_time,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'emailaddress', $this->emailaddress])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'role', $this->role])
                ->andFilterWhere(['like', 'company_id', $this->company_id])
                ->andFilterWhere(['like', 'team_id', $this->team_id])
                ->andFilterWhere(['like', 'last_login_id', $this->last_login_id])
                ->andFilterWhere(['like', 'firstname', $this->firstname])
                ->andFilterWhere(['like', 'lastname', $this->lastname])
                ->andFilterWhere(['like', 'profile_pic', $this->profile_pic])
                ->andFilterWhere(['like', 'dob', $this->dob])
                ->andFilterWhere(['like', 'ip_address', $this->ip_address])
                ->andFilterWhere(['like', 'address', $this->address])
                ->andFilterWhere(['like', 'device', $this->device]); 

        return $dataProvider;
    }

    /*
     * this function call from backend create game controller
     */

    public function searchbackend($params, $id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $query = PilotFrontUser::find()->where(['company_id' => $cid,'challenge_id' => $challid])
						->orderBy(['username' => SORT_ASC]);
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
            'last_access_time' => $this->last_access_time,
            'created' => $this->created,
            'updated' => $this->updated,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'emailaddress', $this->emailaddress]);
          

        return $dataProvider;
    }
  

}
