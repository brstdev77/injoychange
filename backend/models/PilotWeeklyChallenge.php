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
class PilotWeeklyChallenge extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_weekly_challenge';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['category_id', 'week', 'video_title', 'video_link'], 'required'],
            [['category_id'], 'integer'],
            [['week', 'video_title'], 'string', 'max' => 255],
            [['video_link'], 'string', 'max' => 500],
            ['video_link', 'url'],
            ['image', 'image']
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
            'video_title' => 'Video Title',
            'image' => 'Video Image',
            'video_link' => 'Video Link',
        ];
    }

    /*
     * get the Week from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getWeek($id) {
        $model = PilotWeeklyChallenge::find()->where(['id' => $id])->one();
        return 'Week ' . $model->week;
    }

    /*
     * get the Video link from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getVideo($id) {
        $model = PilotWeeklyChallenge::find()->where(['id' => $id])->one();
        $link = explode('?v=', $model->video_link);
        $embedlink = 'https://www.youtube.com/embed/' . $link[1];
        $str = str_replace('&list','?list',$embedlink);
        if ($link[1]) {
            return $str;
        } else {
            return $model->video_link;
        }
    }

    /*
     * get the Records from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getRecords($id) {
        $model = PilotWeeklyChallenge::find()->where(['category_id' => $id])->all();
        return count($model);
    }

    /*
     * get the Weektitle from PilotWeeklyChallenge
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getWeektitle($id) {
        $model = PilotWeeklyChallenge::find()->where(['id' => $id])->one();
        return $model->video_title;
    }

}
