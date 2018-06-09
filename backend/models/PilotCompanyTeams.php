<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_company_teams".
 *
 * @property integer $id
 * @property integer $company_id
 * @property string $team_name
 */
class PilotCompanyTeams extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_company_teams';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
           [['company_id'], 'required'],
            [['company_id'], 'integer'],
            [['team_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'team_name' => 'Team Name',
        ];
    }

}
