<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_leadership_category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $user_id
 * @property integer $created
 * @property integer $updated
 */
class PilotTodayslessonCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_todayslesson_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_name', 'user_id', 'created', 'updated'], 'required'],
            [['id', 'user_id', 'created', 'updated'], 'integer'],
            [['category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'user_id' => 'User ID',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
     public static function getUpdated($id,$uid){
        $model = PilotTodayslessonCategory::find()->where(['id'=>$id])->one();
        $user = PilotInhouseUser::find()->where(['id'=>$uid])->one();
        $updated = $model->updated;
        return ucfirst($user->firstname).' '.ucfirst($user->lastname).'<br>'.date("M d, Y", $updated); 
    }
}
