<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_gettoknow_corner".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $week
 * @property string $question
 * @property string $first_user
 * @property string $first_user_description
 * @property integer $first_user_answer
 * @property string $first_user_profile
 * @property string $second_user
 * @property string $second_user_description
 * @property integer $second_user_answer
 * @property string $second_user_profile
 * @property string $third_user
 * @property string $third_user_description
 * @property integer $third_user_answer
 * @property string $third_user_profile
 * @property integer $created
 * @property integer $updated
 */
class PilotGettoknowCorner extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_gettoknow_corner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'week', 'question', 'first_user', 'first_user_description', 'first_user_answer', 'second_user', 'second_user_description', 'second_user_answer', 'third_user', 'third_user_description', 'third_user_answer', 'created', 'updated'], 'required', 'on' => 'create'],
            [['category_id', 'week', 'question', 'first_user', 'first_user_description', 'first_user_answer', 'second_user', 'second_user_description', 'second_user_answer', 'third_user', 'third_user_description', 'third_user_answer', 'created', 'updated'], 'required', 'on' => 'update'],
            [['category_id', 'first_user_answer', 'second_user_answer', 'third_user_answer', 'created', 'updated'], 'integer'],
            [['week', 'question', 'first_user','second_user','third_user'], 'string', 'max' => 255],
          
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
            'week' => 'Week',
            'question' => 'Question',
            'first_user' => 'First User',
            'first_user_description' => 'First User Description',
            'first_user_answer' => 'First User Answer',
            'first_user_profile' => 'First User Profile',
            'second_user' => 'Second User',
            'second_user_description' => 'Second User Description',
            'second_user_answer' => 'Second User Answer',
            'second_user_profile' => 'Second User Profile',
            'third_user' => 'Third User',
            'third_user_description' => 'Third User Description',
            'third_user_answer' => 'Third User Answer',
            'third_user_profile' => 'Third User Profile',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
    public static function getUpdated($id, $uid) {
        $models = PilotGettoknowCorner::find()->where(['id' => $id])->one();
        $user = PilotInhouseUser::find()->where(['id' => $uid])->one();
        $updated = $models->updated;
        return 'by ' . ucfirst($user->firstname) . ' ' . ucfirst($user->lastname) . '<br>' . date("M d, Y", $updated);
    }
    
    public function checkWeek($attribute, $params) {
        $this->addError($attribute, 'Already exist!');
        return false;
    }

    public static function getRecords($id) {
        $model = PilotGettoknowCorner::find()->where(['category_id' => $id])->all();
        return count($model);
    }
}
