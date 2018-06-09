<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_peak_rating".
 *
 * @property integer $id
 * @property integer $challenge_id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $value
 * @property integer $week_no
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontPeakRating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_peak_rating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['challenge_id', 'game_id', 'user_id', 'company_id', 'value', 'week_no', 'dayset', 'created', 'updated'], 'required'],
            [['challenge_id', 'game_id', 'user_id', 'company_id', 'value', 'week_no', 'created', 'updated'], 'integer'],
            [['dayset'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'challenge_id' => 'Challenge ID',
            'game_id' => 'Game ID',
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'value' => 'Value',
            'week_no' => 'Week No',
            'dayset' => 'Dayset',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
