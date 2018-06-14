<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontServiceHighfive;

/**
 * PilotFrontServiceHighfiveSearch represents the model behind the search form about `frontend\models\PilotFrontServiceHighfive`.
 */
class PilotFrontServiceHighfiveSearch extends PilotFrontServiceHighfive {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'game_id', 'user_id', 'company_id', 'feature_serial', 'linked_feature_id', 'points', 'created', 'updated'], 'integer'],
            [['feature_label', 'feature_value', 'dayset'], 'safe'],
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
        //$query = PilotFrontServiceHighfive::find();
//        $userIdSearched = '';
//        if(!empty($params['PilotFrontServiceHighfiveSearch']['user_id'])){
//
//            $userIdSearched = trim($params['PilotFrontServiceHighfiveSearch']['user_id']);
//        }

        $game = 2;
        $comp_id = 1;
        $query = PilotFrontServiceHighfive::find()
                ->where(['game_id' => $game, 'pilot_front_service_highfive.company_id' => $comp_id, 'feature_label' => 'highfiveComment',])
                ->joinWith('userinfo')
                ->orderBy(['id' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);


        // add conditions that should always apply here
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);

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
            //       'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'feature_serial' => $this->feature_serial,
            'linked_feature_id' => $this->linked_feature_id,
            'points' => $this->points,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

//         echo "<pre>";
//            print_r($this->user_id);
//            die; 
//         
        $query->andFilterWhere(['like', 'feature_label', $this->feature_label])
                ->andFilterWhere(['like', 'feature_value', $this->feature_value])
                ->andFilterWhere(['like', 'pilot_front_user.username', $this->user_id])
                ->andFilterWhere(['like', 'dayset', $this->dayset]);

        return $dataProvider;
    }

}
