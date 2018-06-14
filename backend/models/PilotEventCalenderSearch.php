<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PilotEventCalender;
use yii\db\Expression;

/**
 * PilotEventCalenderSearch represents the model behind the search form about `backend\models\PilotEventCalender`.
 */
class PilotEventCalenderSearch extends PilotEventCalender {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'user_id'], 'integer'],
            [['event_name', 'updated', 'created'], 'safe'],
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

        //check user if admin or manager
        if (Yii::$app->user->identity->role != '1') {
            $query = PilotEventCalender::find()->Where(['OR', ['user_id' => Yii::$app->user->identity->id], (new Expression('FIND_IN_SET(:uid, assign)'))])->addParams([':uid' => Yii::$app->user->identity->id]);
        } else {
            $query = PilotEventCalender::find();
        }


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['created' => SORT_DESC]]
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

        $query->andFilterWhere(['like', 'event_name', $this->event_name])
                ->andFilterWhere(['like', 'updated', $this->updated])
                ->andFilterWhere(['like', 'created', $this->created]);

        return $dataProvider;
    }

}
