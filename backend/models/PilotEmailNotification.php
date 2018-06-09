<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_email_notification".
 *
 * @property integer $id
 * @property integer $date
 * @property string $subject
 * @property integer $game_id
 */
class PilotEmailNotification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_email_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'date', 'subject', 'game_id'], 'required'],
            [['id', 'date', 'game_id'], 'integer'],
            [['subject'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'subject' => 'Subject',
            'game_id' => 'Game ID',
            'active' => 'active',
            
        ];
    }
}
