<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "PIlot_front_leads_highfive_type".
 *
 * @property integer $id
 * @property integer $type
 */
class PllotFrontLeadsHighfiveType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'PIlot_front_leads_highfive_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
        ];
    }
}
