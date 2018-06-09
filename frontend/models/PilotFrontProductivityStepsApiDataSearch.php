<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontProductivityStepsApiData;

/**
 * PilotFrontProductivityStepsApiDataSearch represents the model behind the search form about `frontend\models\PilotFrontProductivityStepsApiData`.
 */
class PilotFrontProductivityStepsApiDataSearch extends PilotFrontProductivityStepsApiData {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'user_id'], 'integer'],
            [['steps', 'calories', 'sleephr', 'distance', 'date', 'time'], 'safe'],
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
        $query = PilotFrontProductivityStepsApiData::find();

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
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'steps', $this->steps])
                ->andFilterWhere(['like', 'calories', $this->calories])
                ->andFilterWhere(['like', 'sleephr', $this->sleephr])
                ->andFilterWhere(['like', 'distance', $this->distance])
                ->andFilterWhere(['like', 'date', $this->date])
                ->andFilterWhere(['like', 'time', $this->time]);

        return $dataProvider;
    }

}
