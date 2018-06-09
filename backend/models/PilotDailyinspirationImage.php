<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_dailyinspiration_image".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $image_name
 * @property integer $order_number
 */
class PilotDailyinspirationImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_dailyinspiration_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'image_name', 'order_number'], 'required'],
            [['category_id', 'order_number'], 'integer'],
            [['image_name'], 'string', 'max' => 255],
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
            'image_name' => 'Image Name',
            'order_number' => 'Order Number',
        ];
    }
    
    
     /*
     * get the count according to the category  from PilotDailyinspirationImage model
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */
    public static function getRecords($id){
        $model = PilotDailyinspirationImage::find()->where(['category_id'=>$id])->all();              
        return count($model);
    }
}
