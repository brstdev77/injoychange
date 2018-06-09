<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PilotCheckinYourselfData;

/**
 * PilotCheckinYourselfDataSearch represents the model behind the search form about `backend\models\PilotCheckinYourselfData`.
 */
class PilotCheckinYourselfDataSearch extends PilotCheckinYourselfData
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'user_id', 'created', 'updated'], 'integer'],
            [['question_label', 'placeholder_text', 'core_value'], 'safe'],
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
        $query = PilotCheckinYourselfData::find()->orderBy(['created' => SORT_ASC]);

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
            'user_id' => $this->user_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'question_label', $this->question_label])
            ->andFilterWhere(['like', 'placeholder_text', $this->placeholder_text])
            ->andFilterWhere(['like', 'core_value', $this->core_value]);

        return $dataProvider;
    }
}
