<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pilot_weekly_challenge".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $week
 * @property string $video_title
 * @property string $video_link
 */
class PilotActionmattersChallenge extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_actionmatters_challenge';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'week','question'], 'required'],
            [['category_id'], 'integer'],
            [['question'], 'unique'],
            [['week'], 'string', 'max' => 255],
            [['question'], 'string', 'max' => 1000],
                //  ['video_title', 'match', 'pattern' => '/^([a-zA-Z]+\s)*[a-zA-Z]+$/'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'week' => 'Week',
        ];
    }

    /*
     * get the Week from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getWeek($id) {
        $model = PilotActionmattersChallenge::find()->where(['id' => $id])->one();
        return 'Week ' . $model->week;
    }

    /*
     * get the Video link from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    

    /*
     * get the Records from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getRecords($id) {
        $model = PilotActionmattersChallenge::find()->where(['category_id' => $id])->all();
        return count($model);
    }

    /*
     * get the Weektitle from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getWeektitle($id) {
        $model = PilotActionmattersChallenge::find()->where(['id' => $id])->one();
        return $model->question;
    }

}
