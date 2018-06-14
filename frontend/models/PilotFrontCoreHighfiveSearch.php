<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontCoreHighfive;
use frontend\models\PilotFrontUser;
use backend\models\PilotCreateGame;

/**
 * PilotFrontCoreHighfiveSearch represents the model behind the search form about `frontend\models\PilotFrontCoreHighfive`.
 */
class PilotFrontCoreHighfiveSearch extends PilotFrontCoreHighfive {

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

        if ($params['shouttype'] == 1):

            $game = PilotFrontUser::getGameID('core');
            $comp_id = Yii::$app->user->identity->company_id;
            $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
            $game_id = $game_obj->id;
            $feature_array = explode(',', $game_obj->features);
            if (in_array(11, $feature_array)):
                $subQuery = PilotFrontCoreHighfive::find()->where(['feature_label' => 'highfiveCommentImage'])->select('linked_feature_id');
                $query = PilotFrontCoreHighfive::find()
                        ->where(['not in', 'pilot_front_core_highfive.id', $subQuery])
                        ->andWhere(['game_id' => $game, 'pilot_front_core_highfive.company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'pilot_front_core_highfive.challenge_id' => $game_id])
                        ->andWhere(['!=','feature_value','null'])
                        ->joinWith('userinfo')
                        ->orderBy(['dayset' => SORT_DESC, 'id' => SORT_DESC]);
            else:
                $query = PilotFrontCoreHighfive::find()
                        ->where(['game_id' => $game, 'pilot_front_core_highfive.company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'pilot_front_core_highfive.challenge_id' => $game_id])
                        ->andWhere(['!=','feature_value','null'])
                        ->joinWith('userinfo')
                        ->orderBy(['dayset' => SORT_DESC, 'id' => SORT_DESC]);

            endif;
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 30,
                ],
            ]);
            $username = $params['PilotFrontCoreHighfiveSearch']['user_id'];
            $user = PilotFrontUser::find()->where(['username' => $username, 'company_id' => $comp_id, 'challenge_id' => $game])->orderBy(['last_access_time' => SORT_DESC])->one();
//            $dataxls = array();
//            foreach ($user as $high) {
//                //$user = PilotFrontUser::find()->where(['id' => $high->user_id])->one();
//                $dataxls[] = array('id' => $high->id,'last_access_time' => $high->last_access_time);
//            }
//            usort($dataxls, function($a, $b) {
//                return (strtotime($a['last_access_time']) < strtotime($b['last_access_time']));
//            });
//            echo '<pre>';print_r($dataxls);die;
//            $user->id = $dataxls[0]['id'];
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
                    ->andFilterWhere(['like', 'feature_value', 'data-uid=\"' . $user->id . '\"'])
                    ->andFilterWhere(['like', 'dayset', $this->dayset]);

            return $dataProvider;
        else:
            $game = PilotFrontUser::getGameID('core');
            $comp_id = Yii::$app->user->identity->company_id;
            $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
            $game_id = $game_obj->id;
            $feature_array = explode(',', $game_obj->features);
            if (in_array(11, $feature_array)):
                $subQuery = PilotFrontCoreHighfive::find()->where(['feature_label' => 'highfiveCommentImage'])->select('linked_feature_id');
                $query = PilotFrontCoreHighfive::find()
                        ->where(['not in', 'pilot_front_core_highfive.id', $subQuery])
                        ->andWhere(['game_id' => $game, 'pilot_front_core_highfive.company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'pilot_front_core_highfive.challenge_id' => $game_id])
                        ->andWhere(['!=','feature_value','null'])
                        ->joinWith('userinfo')
                        ->orderBy(['dayset' => SORT_DESC, 'id' => SORT_DESC]);
            else:
                $query = PilotFrontCoreHighfive::find()
                        ->where(['game_id' => $game, 'pilot_front_core_highfive.company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'pilot_front_core_highfive.challenge_id' => $game_id])
                        ->andWhere(['!=','feature_value','null'])
                        ->joinWith('userinfo')
                        ->orderBy(['dayset' => SORT_DESC, 'id' => SORT_DESC]);

            endif;
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
        endif;
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
