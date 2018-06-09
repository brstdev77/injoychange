<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_prizes_category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $user_id
 * @property integer $created
 * @property integer $updated
 */
class PilotPrizesCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_prizes_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'user_id', 'created', 'updated'], 'required'],
            [['user_id', 'created', 'updated'], 'integer'],
            [['category_name'], 'string', 'max' => 255],
            [['prize_content'], 'string']
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
            'prize_content' => 'Prize Content',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
