<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontSurveyData;

/**
 * PilotFrontSurveyDataSearch represents the model behind the search form about `frontend\models\PilotFrontSurveyData`.
 */
class PilotFrontSurveyDataSearch extends PilotFrontSurveyData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'challenge_id', 'user_id', 'survey_question_id', 'created', 'updated'], 'integer'],
            [['survey_filled', 'survey_response', 'dayset'], 'safe'],
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
        $query = PilotFrontSurveyData::find();

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
            'challenge_id' => $this->challenge_id,
            'user_id' => $this->user_id,
            'survey_question_id' => $this->survey_question_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'survey_filled', $this->survey_filled])
            ->andFilterWhere(['like', 'survey_response', $this->survey_response])
            ->andFilterWhere(['like', 'dayset', $this->dayset]);

        return $dataProvider;
    }
}
