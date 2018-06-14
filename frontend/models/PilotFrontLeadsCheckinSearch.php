<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontLeadsCheckin;

/**
 * PilotFrontServiceCheckinSearch represents the model behind the search form about `frontend\models\PilotFrontServiceCheckin`.
 */
class PilotFrontLeadsCheckinSearch extends PilotFrontLeadsCheckin {

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['id', 'game_id', 'user_id', 'company_id', 'serial', 'points', 'week_no', 'created', 'updated'], 'integer'],
      [['label', 'comment', 'dayset', 'username'], 'safe'],
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
    $query = PilotFrontLeadsCheckin::find();

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
      'serial' => $this->serial,
      'points' => $this->points,
      'week_no' => $this->week_no,
      'created' => $this->created,
      'updated' => $this->updated,
    ]);

    $query->andFilterWhere(['like', 'label', $this->label])
        ->andFilterWhere(['like', 'comment', $this->comment])
        ->andFilterWhere(['like', 'dayset', $this->dayset]);

    return $dataProvider;
  }

  /*
   * using  for backend listing search
   */

  public function searchbackend($params, $id) {
    $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
    $cid = $gamemodel->challenge_company_id;
    $challid = $gamemodel->challenge_id;
    $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
    $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
    $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';

    $query = $model_highfive::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_checkin.company_id' => $cid])
        ->andWhere(['!=', 'label', 'core_values_popup'])
        ->andWhere(['between', 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_checkin.created', $gamemodel->challenge_start_date, $gamemodel->challenge_end_date])
		->orderBy(['dayset' => SORT_DESC]);

    $query->joinWith(['userinfo']);
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
      'serial' => $this->serial,
      'points' => $this->points,
      'week_no' => $this->week_no,
      'created' => $this->created,
      'updated' => $this->updated,
    ]);

    $query->andFilterWhere(['like', 'label', $this->label])
        ->andFilterWhere(['like', 'comment', $this->comment])
        ->andFilterWhere(['like', 'pilot_front_user.username', $this->username])
        ->andFilterWhere(['like', 'dayset', $this->dayset]);

    return $dataProvider;
  }

}
