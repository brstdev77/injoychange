<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_intentionalleadership_weeklychallenge".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $challenge_id
 * @property integer $points
 * @property integer $week_no
 * @property string $comment
 * @property string $dayset
 * @property string $tip_pos
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontIntentionalleadershipWeeklychallenge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName() 
    {
        return 'pilot_front_intentionalleadership_weeklychallenge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'company_id', 'challenge_id', 'points', 'week_no', 'comment', 'dayset', 'tip_pos', 'created', 'updated'], 'required'],
            [['game_id', 'user_id', 'company_id', 'challenge_id', 'points', 'week_no', 'created', 'updated','correct_id'], 'integer'],
            [['comment', 'dayset', 'tip_pos'], 'string', 'max' => 255],
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
            'user_id' => 'User ID',
            'company_id' => 'Company ID',
            'challenge_id' => 'Challenge ID',
            'points' => 'Points',
            'week_no' => 'Week No',
            'comment' => 'Comment',
            'dayset' => 'Dayset',
            'tip_pos' => 'Tip Pos',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
