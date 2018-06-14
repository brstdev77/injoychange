<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "cron_reports".
 *
 * @property integer $id
 * @property integer $game_id
 * @property integer $company_id
 * @property integer $week_no
 * @property string $filepath
 * @property string $created
 */
class CronReports extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cron_reports';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['game_id', 'company_id', 'week_no', 'filepath'], 'required'],
            [['game_id', 'company_id', 'week_no'], 'integer'],
            [['created'], 'safe'],
            [['filepath'], 'string', 'max' => 255],
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
            'company_id' => 'Company ID',
            'week_no' => 'Week No',
            'filepath' => 'Filepath',
            'created' => 'Created',
        ];
    }
}
