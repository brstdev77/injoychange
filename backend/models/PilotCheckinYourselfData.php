<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_checkin_yourself_data".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $question_label
 * @property string $placeholder_text
 * @property string $core_value
 * @property integer $user_id
 * @property integer $created
 * @property integer $updated
 */
class PilotCheckinYourselfData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_checkin_yourself_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'user_id', 'created', 'updated','question_label', 'placeholder_text', 'select_option_text'], 'required'],
            [['category_id', 'user_id', 'created', 'updated'], 'integer'],
            [['question_label', 'placeholder_text', 'core_value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'question_label' => 'Question Label',
            'placeholder_text' => 'Placeholder Text',
            'core_value' => 'Core Value',
            'select_option_text' => 'Select Default Option Text',
            'user_id' => 'User ID',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
    
    public static function getRecords($id){
        $model = PilotCheckinYourselfData::find()->where(['category_id' => $id])->all();
        return count($model);
    }
}
