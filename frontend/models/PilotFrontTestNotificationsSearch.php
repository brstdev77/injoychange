<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\PilotFrontTestNotifications;

/**
 * PilotFrontTestNotificationsSearch represents the model behind the search form about `frontend\models\PilotFrontTestNotifications`.
 */
class PilotFrontTestNotificationsSearch extends PilotFrontTestNotifications
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'game_id', 'user_id', 'company_id', 'notif_type_id', 'activity_user_id', 'created', 'updated'], 'integer'],
            [['notif_type', 'notif_value', 'notif_status', 'dayset'], 'safe'],
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
        $query = PilotFrontTestNotifications::find();

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
            'notif_type_id' => $this->notif_type_id,
            'activity_user_id' => $this->activity_user_id,
            'created' => $this->created,
            'updated' => $this->updated,
        ]);

        $query->andFilterWhere(['like', 'notif_type', $this->notif_type])
            ->andFilterWhere(['like', 'notif_value', $this->notif_value])
            ->andFilterWhere(['like', 'notif_status', $this->notif_status])
            ->andFilterWhere(['like', 'dayset', $this->dayset]);

        return $dataProvider;
    }
}
