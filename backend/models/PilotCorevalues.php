<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_corevalues".
 *
 * @property integer $id
 * @property string $core_values_name
 */
class PilotCorevalues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_corevalues';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],
            [['core_values_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'core_values_name' => 'Core Values Name',
            'company_id' => 'Company Name',
        ];
    }
}
