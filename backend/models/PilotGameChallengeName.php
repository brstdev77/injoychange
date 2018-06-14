<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_create_game_challenge".
 *
 * @property integer $id
 * @property string $challenge_name
 * @property string $challenge_abbr_name
 */
class PilotGameChallengeName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_game_challenge_name';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['challenge_name', 'challenge_abbr_name'], 'required'],
            [['challenge_name', 'challenge_abbr_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'challenge_name' => 'Challenge Name',
            'challenge_abbr_name' => 'Challenge Abbr Name',
        ];
    }
}
