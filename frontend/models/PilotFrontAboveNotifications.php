<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_above_notifications".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $notif_type_id
 * @property string $notif_type
 * @property string $notif_value
 * @property integer $activity_user_id
 * @property string $notif_status
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontAboveNotifications extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_above_notifications';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'company_id', 'notif_type_id', 'notif_type', 'notif_value', 'activity_user_id', 'notif_status', 'dayset', 'created', 'updated'], 'required'],
            [['game_id', 'user_id', 'company_id', 'notif_type_id', 'activity_user_id', 'created', 'updated'], 'integer'],
            [['notif_type', 'notif_status', 'dayset'], 'string', 'max' => 255],
            [['notif_value'], 'string', 'max' => 2000],
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
            'notif_type_id' => 'Notif Type ID',
            'notif_type' => 'Notif Type',
            'notif_value' => 'Notif Value',
            'activity_user_id' => 'Activity User ID',
            'notif_status' => 'Notif Status',
            'dayset' => 'Dayset',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
