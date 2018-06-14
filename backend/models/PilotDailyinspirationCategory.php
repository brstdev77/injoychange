<?php

namespace backend\models;

use Yii;
use backend\models\PilotInhouseUser;
/**
 * This is the model class for table "pilot_dailyinspiration_category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $user_id
 * @property integer $created
 * @property integer $updated
 */
class PilotDailyinspirationCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_dailyinspiration_category';
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
    
    /*
     * get the username and phone number from PilotInhouseUser model
     * and date from PilotDailyinspirationCategory model
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */
    public static function getUpdated($id,$uid){
        $model = PilotDailyinspirationCategory::find()->where(['id'=>$id])->one();
        $user = PilotInhouseUser::find()->where(['id'=>$uid])->one();
        $updated = $model->updated;
        return ucfirst($user->firstname).' '.ucfirst($user->lastname).'<br>'.date("M d, Y", $updated);
    }
}
