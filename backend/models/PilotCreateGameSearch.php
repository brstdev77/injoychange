<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PilotCreateGame;
use backend\models\PilotGameChallengeName;
use backend\models\Company;
use backend\models\PilotInhouseUser;
use yii\db\Expression;

/**
 * PilotManageGameSearch represents the model behind the search form about `backend\models\PilotManageGame`.
 */
class PilotCreateGameSearch extends PilotCreateGame {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['challenge_company_id', 'challenge_id', 'challenge_start_date', 'challenge_end_date', 'created_user_id', 'status', 'manager','category_id'], 'safe'],
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
        $query = PilotCreateGame::find();
        //$query->joinWith(['userinfo']);
        // $query->joinWith(['companyinfo']);

        $query->joinWith(['managerinfo']);


        //echo '<pre>';print_r($params['PilotCreateGameSearch']);die;
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
        ]);


        //$query->andFilterWhere(['like', 'pilot_game_challenge_name.challenge_name', $this->challenge_id])
        // ->andFilterWhere(['like', 'challenge_start_date', $search_start_date])
        // ->andFilterWhere(['like', 'challenge_end_date', $search_end_date])
        // ->andFilterWhere(['or', ['like', 'pilot_inhouse_user.firstname', $this->created_user_id], ['like', 'pilot_inhouse_user.lastname', $this->created_user_id]])
        // ->andFilterWhere(['like', 'pilot_company.company_name', $this->challenge_company_id])
        if ($this->manager) {
            $query->andFilterWhere(['=', 'pilot_create_game.status', $this->status])
                    ->andFilterWhere(['like', 'challenge_company_id', $this->challenge_company_id])
                    ->andFilterWhere(['like', 'challenge_id', $this->challenge_id])
                    ->andFilterWhere(['or', ['pilot_company.user_id' => $this->manager], new Expression('FIND_IN_SET(:manager, pilot_company.manager)')])->addParams([':manager' => $this->manager]);
        } else {
            $query->andFilterWhere(['=', 'pilot_create_game.status', $this->status])
                    ->andFilterWhere(['like', 'challenge_company_id', $this->challenge_company_id])
                    ->andFilterWhere(['like', 'challenge_id', $this->challenge_id]);
        }

        //echo "<pre>"; print_r($dataProvider); die();
        return $dataProvider;
    }

}
