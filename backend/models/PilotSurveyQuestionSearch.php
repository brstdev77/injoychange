<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PilotSurveyQuestion;
use yii\db\Expression;

/**
 * PilotSurveyQuestionSearch represents the model behind the search form about `backend\models\PilotSurveyQuestion`.
 */
class PilotSurveyQuestionSearch extends PilotSurveyQuestion {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created'], 'integer'],
            [['question', 'type', 'tag_id'], 'safe'],
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
        $query = PilotSurveyQuestion::find();

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
            'created' => $this->created,
        ]);
        $tag_list = [];
        if (!empty($this->tag_id)):
            $tag_ids = PilotTags::find()->where(['like', 'tags', $this->tag_id])->all();
            if (!empty($tag_ids)):
                foreach ($tag_ids as $tags => $tag_value):
                    $tag_list[] = $tag_value['id'];
                endforeach;
            endif;
        endif;
        if (!empty($tag_list)):
            foreach ($tag_list as $value):
                $query->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
            endforeach;
        else:
            $query->andFilterWhere(['like', 'tag_id', $this->tag_id]);
        endif;
        $query->andFilterWhere(['like', 'question', $this->question])
                ->andFilterWhere(['like', 'type', $this->type]);
        $query->all();
        return $dataProvider;
    }

}
