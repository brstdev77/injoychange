<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_intentional_survey_data".
 *
 * @property integer $id
 * @property integer $challenge_id
 * @property integer $user_id
 * @property string $survey_filled
 * @property integer $survey_question_id
 * @property string $survey_response
 * @property string $permission_use_data
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontIntentionalSurveyData extends \yii\db\ActiveRecord {

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_intentional_survey_data';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['challenge_id', 'user_id', 'survey_response', 'permission_use_data', 'dayset', 'created', 'updated'], 'required'],
      [['challenge_id', 'user_id', 'survey_question_id', 'week_no', 'created', 'updated'], 'integer'],
      [['survey_filled', 'survey_response', 'permission_use_data', 'dayset'], 'string', 'max' => 255],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'challenge_id' => 'Challenge ID',
      'user_id' => 'User ID',
      'survey_filled' => 'Survey Filled',
      'survey_question_id' => 'Survey Question ID',
      'survey_response' => 'Response',
      'permission_use_data' => 'Permission',
      'week_no' => 'Week No',
      'dayset' => 'Dayset',
      'created' => 'Created',
      'updated' => 'Updated',
    ];
  }

}
