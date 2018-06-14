<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_how_it_work".
 *
 * @property integer $id
 * @property string $category_name
 * @property resource $how_it_work_content
 * @property integer $user_id
 * @property integer $created
 * @property integer $updated
 */
class PilotHowItWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_how_it_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name', 'how_it_work_content', 'user_id', 'created', 'updated'], 'required'],
            [['how_it_work_content'], 'string'],
            [['user_id', 'created', 'updated'], 'integer'],
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
            'how_it_work_content' => 'How It Work Content',
            'user_id' => 'User ID',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
