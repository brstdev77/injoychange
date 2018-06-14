<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_testce_highfive".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $team_id
 * @property string $feature_label
 * @property string $feature_value
 * @property integer $feature_serial
 * @property integer $linked_feature_id
 * @property integer $points
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontTestHighfive extends \yii\db\ActiveRecord {

  public $username;

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_test_highfive';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['game_id', 'user_id', 'company_id', 'team_id', 'points', 'created', 'updated'], 'required'],
      [['game_id', 'user_id', 'company_id', 'team_id', 'feature_serial', 'linked_feature_id', 'points', 'week_no', 'created', 'updated'], 'integer'],
      [['feature_label', 'dayset'], 'string', 'max' => 255],
      [['feature_value'], 'string', 'max' => 1000],
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
      'feature_label' => 'Feature Label',
      'feature_value' => 'Feature Value',
      'feature_serial' => 'Feature Serial',
      'linked_feature_id' => 'Linked Feature ID',
      'points' => 'Points',
      'week_no' => 'Week No',
      'dayset' => 'Dayset',
      'created' => 'Created',
      'updated' => 'Updated',
    ];
  }

  public function getUserinfo() {
    return $this->hasOne(PilotFrontUser::className(), ['id' => 'user_id']);
  }

}
