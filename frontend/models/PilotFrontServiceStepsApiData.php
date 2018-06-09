<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_service_steps_api_data".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $steps
 * @property string $calories
 * @property string $sleephr
 * @property string $distance
 * @property string $date
 * @property string $time
 */
class PilotFrontServiceStepsApiData extends \yii\db\ActiveRecord {

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_service_steps_api_data';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['user_id', 'company_id', 'team_id'], 'integer'],
      [['steps', 'calories', 'sleephr', 'distance', 'week_no', 'date', 'time'], 'string'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'user_id' => 'User ID',
      'company_id' => 'Compant ID',
      'team_id' => 'Team ID',
      'steps' => 'Steps',
      'calories' => 'Calories',
      'sleephr' => 'Sleephr',
      'distance' => 'Distance',
      'week_no' => 'Week No',
      'date' => 'Date',
      'time' => 'Time',
    ];
  }

   public static function getUserSteps($user_id) {
    $dayset = date('d/m/Y');
    $get_rec = PilotFrontServiceStepsApiData::find()->where(['user_id' => $user_id, 'date' => $dayset])->one();
    $total_steps = 0;
    if (!empty($get_rec)):
      $total_steps = $get_rec->steps;
    endif;
    return $total_steps;
  }

   public static function getUserStepsforchallenge($user_id) {
    $total_steps = PilotFrontServiceStepsApiData::find()->where(['user_id' => $user_id])->sum('steps');
    if (empty($total_steps)):
      $total_steps = 0;
    endif;

    return $total_steps;
  }

   public static function getAllUsersStepsforchallenge() {
    $company_id = Yii::$app->user->identity->company_id;
    $team_id = Yii::$app->user->identity->team_id;
    $users = PilotFrontServiceStepsApiData::find()->select(['user_id'])->where(['company_id' => $company_id, 'team_id' => $team_id])->groupBy(['user_id'])->All();
    $users_steps_arr = [];
    foreach ($users as $user):
      $uid = $user->user_id;
      $user_total_steps = PilotFrontServiceStepsApiData::find()->where(['user_id' => $uid])->sum('steps');
      $users_steps_arr[$uid] = $user_total_steps;
    endforeach;

    return $users_steps_arr;
  }

}
