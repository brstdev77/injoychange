<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_support".
 *
 * @property integer $id
 * @property string $email
 * @property string $subject
 * @property string $image
 * @property string $description
 */
class PilotSupport extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_support';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['email', 'subject', 'image', 'description'], 'required'],
            [['email', 'subject', 'image', 'description','reply'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'subject' => 'Subject',
            'image' => 'Image',
            'description' => 'Description',
            'reply' => 'Reply',
        ];
    }
}
