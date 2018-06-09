<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_intentional_email".
 *
 * @property integer $id
 * @property string $email_id
 * @property string $message
 * @property string $attachment
 * @property integer $created
 */
class PilotFrontIntentionalEmail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_intentional_email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email_id', 'message', 'attachment', 'created'], 'required'],
            [['message'], 'string'],
            [['created'], 'integer'],
            [['email_id', 'attachment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email_id' => 'Email ID',
            'message' => 'Message',
            'attachment' => 'Attachment',
            'created' => 'Created',
        ];
    }
}
