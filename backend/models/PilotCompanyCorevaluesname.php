<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_company_corevaluesname".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $core_values_name
 */
class PilotCompanyCorevaluesname extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_company_corevaluesname';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'vission_msg'], 'required'],
            [['company_id', 'created'], 'integer'],
            [['core_values_name', 'popup_heading'], 'string', 'max' => 255],
            [['definition'], 'string', 'max' => 500],
            [['vission_msg'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'core_values_name' => 'Core Values Name',
            'vission_msg' => 'Vission Message',
            'definition' => 'Definition',
            'popup_heading' => 'Heading',
            'created' => 'Created',
        ];
    }
}
