<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_user_notifications_settings".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $notif_type
 * @property string $notif_delivery_method
 * @property string $notif_frequency
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontUserNotificationsSettings extends \yii\db\ActiveRecord {

  /**
   * @inheritdoc
   */
  public static function tableName() {
    return 'pilot_front_user_notifications_settings';
  }

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      [['user_id', 'created', 'updated'], 'integer'],
      [['notif_type', 'notif_delivery_method', 'notif_frequency'], 'string', 'max' => 255],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'id' => 'ID',
      'user_id' => 'User ID',
      'notif_type' => 'Notification Type',
      'notif_delivery_method' => 'Notification Delivery Method',
      'notif_frequency' => 'Notification Frequency',
      'created' => 'Created',
      'updated' => 'Updated',
    ];
  }

}
