<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_todayslesson_question".
 *
 * @property integer $id
 * @property integer $corner_id
 * @property string $question
 * @property string $answer
 * @property string $Correct
 * @property integer $created
 * @property integer $updated
 */
class PilotTodayslessonQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_todayslesson_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           // [['secondary_question', 'answer'], 'required'],
            [['corner_id', 'created', 'updated'], 'integer'],
            [['secondary_question', 'answer', 'Correct'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'corner_id' => 'Corner ID',
            'secondary_question' => 'Secondary Question',
            'answer' => 'Answer',
            'Correct' => 'Correct',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
