<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_core_checkin".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property string $label
 * @property string $comment
 * @property integer $serial
 * @property integer $points
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontCoreCheckin extends \yii\db\ActiveRecord {

  public $username;

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_core_checkin';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['game_id', 'user_id', 'company_id', 'label', 'comment', 'serial', 'points', 'dayset', 'created', 'updated'], 'required'],
      [['game_id', 'user_id', 'company_id', 'serial', 'points', 'week_no', 'created', 'updated'], 'integer'],
      [['label', 'comment', 'dayset'], 'string', 'max' => 255],
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
      'label' => 'Label',
      'comment' => 'Comment',
      'serial' => 'Serial',
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
