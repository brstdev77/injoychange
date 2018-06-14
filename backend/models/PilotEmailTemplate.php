<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_email_template".
 *
 * @property integer $id
 * @property string $subject
 * @property string $content
 */
class PilotEmailTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_email_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['subject', 'content'], 'required'],
            [['subject', 'content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'content' => 'Content',
        ];
    }
}
