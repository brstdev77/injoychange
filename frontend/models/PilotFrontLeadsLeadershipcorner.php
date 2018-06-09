<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pilot_front_service_leadershipcorner".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $user_id
 * @property integer $company_id
 * @property integer $week_no
 * @property string $tip_pos
 * @property integer $points
 * @property string $comment
 * @property string $dayset
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontLeadsLeadershipcorner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pilot_front_leads_leadershipcorner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'user_id', 'company_id', 'week_no', 'tip_pos', 'points', 'dayset', 'created', 'updated'], 'required'],
            [['game_id', 'user_id', 'company_id', 'week_no', 'points', 'created', 'updated'], 'integer'],
            [['tip_pos', 'comment', 'dayset'], 'string', 'max' => 255],
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
            'week_no' => 'Week No',
            'tip_pos' => 'Tip Pos',
            'points' => 'Points',
            'comment' => 'Comment',
            'dayset' => 'Dayset',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
