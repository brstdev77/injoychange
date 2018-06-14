<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_leadership_tech_support".
 *
 * @property integer $ticket_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $team_id
 * @property integer $challenge_id
 * @property string $email
 * @property string $subject
 * @property string $message
 * @property string $priority
 * @property string $attachment
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontLeadershipTechSupport extends \yii\db\ActiveRecord {

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_leadership_tech_support';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['user_id', 'challenge_id', 'email', 'subject', 'message', 'priority', 'created', 'updated'], 'required'],
      [['user_id', 'challenge_id', 'created', 'updated'], 'integer'],
      [['message'], 'string'],
      [['email', 'subject', 'priority', 'attachment'], 'string', 'max' => 255],
      [['attachment'], 'file', 'extensions' => 'png, jpg, jpeg, gif'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'ticket_id' => 'Ticket ID',
      'user_id' => 'User ID',
      'challenge_id' => 'Challenge ID',
      'email' => 'Email',
      'subject' => 'Subject',
      'message' => 'Message',
      'priority' => 'Priority',
      'attachment' => 'Attachment',
      'created' => 'Created',
      'updated' => 'Updated',
    ];
  }


}
