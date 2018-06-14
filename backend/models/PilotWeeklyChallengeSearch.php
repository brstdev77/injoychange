<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PilotWeeklyChallenge;

/**
 * PilotWeeklyChallengeSearch represents the model behind the search form about `backend\models\PilotWeeklyChallenge`.
 */
class PilotWeeklyChallengeSearch extends PilotWeeklyChallenge
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['week', 'video_title', 'video_link'], 'safe'],
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
        $query = PilotWeeklyChallenge::find();

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
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'week', $this->week])
            ->andFilterWhere(['like', 'video_title', $this->video_title])
            ->andFilterWhere(['like', 'video_link', $this->video_link]);

        return $dataProvider;
    }
}
