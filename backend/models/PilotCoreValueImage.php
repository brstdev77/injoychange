<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_core_value_image".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $image_name
 * @property integer $order_number
 */
class PilotCoreValueImage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_core_value_image';
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
    public static function getRecords($id){
        $model = PilotCoreValueImage::find()->where(['category_id'=>$id])->all(); 
        return count($model);
    }
}
