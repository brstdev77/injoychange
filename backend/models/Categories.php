<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "Categories".
 *
 * @property integer $id
 * @property string $Category_name
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Categories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'Category_name'], 'required'],
            [['id'], 'integer'],
            [['Category_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Category_name' => 'Category Name',
        ];
    }
}
