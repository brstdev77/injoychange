<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_customer_question".
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
class PilotFrontCustomerQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_customer_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'company_id','team_id', 'challenge_id', 'points', 'week_no', 'dayset', 'created', 'updated','comment'], 'required'],
            [['game_id', 'user_id', 'company_id','team_id', 'challenge_id', 'points', 'week_no', 'created', 'updated'], 'integer'],
            [['dayset'], 'string', 'max' => 255],
            ['comment', 'string','max' => 1000],
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
