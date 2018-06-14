<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_core_shareawin".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $team_id
 * @property integer $points
 * @property string $comment
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontCoreShareawin extends \yii\db\ActiveRecord {

  public $username;

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_core_shareawin';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['game_id', 'user_id', 'company_id', 'team_id', 'points', 'created', 'updated'], 'required'],
      [['game_id', 'user_id', 'company_id', 'team_id', 'points', 'week_no', 'created', 'updated'], 'integer'],
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
      'team_id' => 'Team ID',
      'points' => 'Points',
      'week_no' => 'Week No',
      'comment' => 'Comment',
      'dayset' => 'Dayset',
      'created' => 'Created',
      'updated' => 'Updated',
    ];
  }

  public function getUserinfo() {
    return $this->hasOne(PilotFrontUser::className(), ['id' => 'user_id']);
  }

}
