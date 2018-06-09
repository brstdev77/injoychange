<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontProductivityHighfive;
use frontend\models\PilotFrontUser;

/**
 * PilotFrontProductivityHighfiveSearch represents the model behind the search form about `frontend\models\PilotFrontProductivityHighfive`.
 */
class PilotFrontProductivityHighfiveSearch extends PilotFrontProductivityHighfive {

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['id', 'game_id', 'user_id', 'company_id', 'team_id', 'feature_serial', 'linked_feature_id', 'points', 'week_no', 'created', 'updated'], 'integer'],
      [['feature_label', 'feature_value', 'dayset', 'username'], 'safe'],
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

    $game = PilotFrontUser::getGameID('productivity');
    $comp_id = Yii::$app->user->identity->company_id;
    $query = PilotFrontProductivityHighfive::find()
        ->where(['game_id' => $game, 'pilot_front_productivity_highfive.company_id' => $comp_id, 'feature_label' => 'highfiveComment',])
        ->joinWith('userinfo')
        ->orderBy(['id' => SORT_DESC]);
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
      'pagination' => [
        'pageSize' => 30,
      ],
    ]);


    $this->load($params);


//    if (!$this->validate()) {
//      return $dataProvider;
//    }
    // grid filtering conditions
    $query->andFilterWhere([
      'id' => $this->id,
      'game_id' => $this->game_id,
      'company_id' => $this->company_id,
      'team_id' => $this->team_id,
      'feature_serial' => $this->feature_serial,
      'linked_feature_id' => $this->linked_feature_id,
      'points' => $this->points,
      'week_no' => $this->week_no,
      'created' => $this->created,
      'updated' => $this->updated,
    ]);

    $query->andFilterWhere(['like', 'feature_label', $this->feature_label])
        ->andFilterWhere(['like', 'feature_value', $this->feature_value])
        ->andFilterWhere(['like', 'pilot_front_user.username', $this->user_id])
        ->andFilterWhere(['like', 'dayset', $this->dayset]);

    return $dataProvider;
  }

  /*
   * search using for backend on report section of challenge listing
   */

  public function searchbackend($params, $id) {
    $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
    $cid = $gamemodel->challenge_company_id;
    $challid = $gamemodel->challenge_id;
    $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
    $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
    $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';

    $query = $model_highfive::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_highfive.company_id' => $cid])
        ->andWhere(['feature_label' => 'highfiveComment'])
        ->andWhere(['between', 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_highfive.created', $gamemodel->challenge_start_date, $gamemodel->challenge_end_date])
		->orderBy(['dayset' => SORT_DESC]);

    $query->joinWith(['userinfo']);
    $dataProvider = new ActiveDataProvider([
      'query' => $query,
    ]);
//echo '<pre>';print_r($this->user_id);die;
    $this->load($params);

    if (!$this->validate()) {
      return $dataProvider;
    }

    // grid filtering conditions
    $query->andFilterWhere([
      'id' => $this->id,
      'game_id' => $this->game_id,
      //'company_id' => $this->company_id,
//      'team_id' => $this->team_id,
      'feature_serial' => $this->feature_serial,
      'linked_feature_id' => $this->linked_feature_id,
      'points' => $this->points,
      'week_no' => $this->week_no,
      'created' => $this->created,
      'updated' => $this->updated,
    ]);

    $query->andFilterWhere(['like', 'feature_label', $this->feature_label])
        ->andFilterWhere(['like', 'feature_value', $this->feature_value])
        ->andFilterWhere(['like', 'pilot_front_user.username', $this->username])
        ->andFilterWhere(['like', 'dayset', $this->dayset]);

    return $dataProvider;
  }

}
