<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "5s_toggle".
 *
 * @property integer $id
 * @property integer $game_id
 * @property string $Button_text
 * @property integer $created
 * @property integer $updated
 */
class ButtonToggle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '5s_toggle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['game_id', 'Button_text', 'created', 'updated'], 'required'],
            [['game_id', 'created', 'updated'], 'integer'],
            [['Button_text'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'game_id' => 'Game ID',
            'Button_text' => 'Button Text',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
