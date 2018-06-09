<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontPeakTotalPoints;

/**
 * PilotFrontPeakTotalPointsSearch represents the model behind the search form about `frontend\models\PilotFrontPeakTotalPoints`.
 */
class PilotFrontPeakTotalPointsSearch extends PilotFrontPeakTotalPoints {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'game_id', 'user_id', 'company_id', 'team_id', 'total_points', 'total_core_values', 'total_raffle_entry', 'total_game_actions', 'created', 'updated'], 'integer'],
         [['username','emailaddress'], 'safe'],
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
        $query = PilotFrontPeakTotalPoints::find();

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
            'game_id' => $this->game_id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'team_id' => $this->team_id,
            'total_points' => $this->total_points,
            'total_core_values' => $this->total_core_values,
            'total_raffle_entry' => $this->total_raffle_entry,
            'total_game_actions' => $this->total_game_actions,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        return $dataProvider;
    }

    /*
     * this  function call from backend pilotcreategamecontroller of action activeuser
     */

    public function searchbackend($params, $id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challengename = $challenge_obj->challenge_abbr_name;
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //share a win
        $model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
        $query = $model_scorepoints::find()->where(['game_id' => $challid, 'pilot_front_'.$challengename.'_total_points.company_id' => $cid])
                ->andWhere(['between', 'pilot_front_'.$challengename.'_total_points.created',  $gamemodel->challenge_start_date,  $gamemodel->challenge_end_date])
                ->andWhere(['and', "total_points>0"]);
		$query->joinWith(['userinfo'])->orderBy(['username' => SORT_ASC]);
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
            'game_id' => $this->game_id,
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'team_id' => $this->team_id,
            'total_points' => $this->total_points,
            'total_core_values' => $this->total_core_values,
            'total_raffle_entry' => $this->total_raffle_entry,
            'total_game_actions' => $this->total_game_actions,
            'created' => $this->created,
            'updated' => $this->updated,
        ])
                ->andFilterWhere(['like', 'pilot_front_user.username', $this->username])
                ->andFilterWhere(['like', 'pilot_front_user.emailaddress', $this->emailaddress]);
        
               

        return $dataProvider;
    }

}
