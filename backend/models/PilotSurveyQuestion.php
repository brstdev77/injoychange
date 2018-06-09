<?php

namespace backend\models;

use Yii;
use backend\models\PilotInhouseUser;

/**
 * This is the model class for table "pilot_survey_question".
 *
 * @property integer $id
 * @property string $question
 */
class PilotSurveyQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_survey_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question'], 'required'],
            [['type'], 'required','message'=>'selection type cannot be blank'],
            [['question'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'user_id' => 'user_id',
            'created' => 'created',
            'type'=>'type',
        ];
    }
    
     public static function getcreated($id) {
        $model = PilotSurveyQuestion::find()->where(['id' => $id])->one();
        $user = PilotInhouseUser::find()->where(['id' => $model->user_id])->one();
        $final = date("M  d, Y", $model->created);
        return $user->username . '<br />' . $final;
    }
}
