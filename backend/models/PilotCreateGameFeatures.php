<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_create_game_features".
 *
 * @property integer $id
 * @property string $name
 * @property string $font_awesome_class
 */
class PilotCreateGameFeatures extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_create_game_features';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'name', 'font_awesome_class'], 'required'],
            [['id'], 'integer'],
            [['name', 'font_awesome_class'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'font_awesome_class' => 'Font Awesome Class',
        ];
    }
}
