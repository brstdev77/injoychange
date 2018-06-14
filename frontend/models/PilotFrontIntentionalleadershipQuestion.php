<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_intentionalleadership_question".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $challenge_id
 * @property integer $points
 * @property string $comment
 * @property integer $week_no
 * @property string $dayset
 * @property string $tip_pos
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontIntentionalleadershipQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_intentionalleadership_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'company_id', 'challenge_id', 'points', 'week_no', 'dayset', 'created', 'updated','comment'], 'required'],
            [['game_id', 'user_id', 'company_id', 'challenge_id', 'points', 'week_no', 'created', 'updated'], 'integer'],
            [['dayset','comment'], 'string', 'max' => 255],
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
            'comment' => 'Comment',
            'week_no' => 'Week No',
            'dayset' => 'Dayset',
            'tip_pos' => 'Tip Pos',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
