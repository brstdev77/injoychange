<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_leadership_dailyinspiration".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $points
 * @property string $comment
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontLeadershipDailyinspiration extends \yii\db\ActiveRecord {

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_leadership_dailyinspiration';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['game_id', 'user_id', 'company_id', 'points', 'created', 'updated'], 'required'],
      [['game_id', 'user_id', 'company_id', 'points', 'week_no', 'created', 'updated'], 'integer'],
      [['comment', 'dayset'], 'string', 'max' => 255],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'game_id' => 'Game ID',
      'user_id' => 'User ID',
      'company_id' => 'Company ID',
      'points' => 'Points',
      'week_no' => 'Week No',
      'comment' => 'Comment',
      'dayset' => 'Dayset',
      'created' => 'Created',
      'updated' => 'Updated',
    ];
  }

}
