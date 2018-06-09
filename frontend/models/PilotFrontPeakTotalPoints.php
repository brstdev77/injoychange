<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_core_total_points".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $team_id
 * @property integer $total_points
 * @property integer $total_core_values
 * @property integer $total_raffle_entry
 * @property integer $total_game_actions
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontPeakTotalPoints extends \yii\db\ActiveRecord
{
    public $username;
    public $emailaddress;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_peak_total_points';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'company_id', 'team_id', 'total_points', 'total_core_values', 'total_raffle_entry', 'total_game_actions', 'created', 'updated'], 'required'],
            [['game_id', 'user_id', 'company_id', 'team_id', 'total_points', 'total_core_values', 'total_raffle_entry', 'total_game_actions', 'created', 'updated'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'team_id' => 'Team ID',
            'total_points' => 'Total Points',
            'total_core_values' => 'Total Core Values',
            'total_raffle_entry' => 'Total Raffle Entry',
            'total_game_actions' => 'Total Game Actions',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
    public function getUserinfo() {
    return $this->hasOne(PilotFrontUser::className(), ['id' => 'user_id']);
  }
}
