<?php

namespace backend\models;

use Yii;
use backend\models\PilotInhouseUser;

/**
 * This is the model class for table "pilot_core_values_image_category".
 *
 * @property integer $id
 * @property string $category_name
 * @property string $tag_id
 * @property integer $user_id
 * @property integer $created
 * @property integer $updated
 */
class PilotCoreValuesImageCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_core_values_image_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'tag_id', 'user_id', 'created', 'updated'], 'required'],
            [['user_id', 'created', 'updated'], 'integer'],
            [['category_name', 'tag_id'], 'string', 'max' => 255],
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
            'tag_id' => 'Tag ID',
            'user_id' => 'User ID',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
     public static function getUpdated($id,$uid){
        $model = PilotCoreValuesImageCategory::find()->where(['id'=>$id])->one();
        $user = PilotInhouseUser::find()->where(['id'=>$uid])->one();
        $updated = $model->updated;
        return ucfirst($user->firstname).' '.ucfirst($user->lastname).'<br>'.date("M d, Y", $updated);
    }
}
