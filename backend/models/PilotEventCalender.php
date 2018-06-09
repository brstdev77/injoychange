<?php

namespace backend\models;

use Yii;
use backend\models\Company;
use backend\models\PilotInhouseUser;

/**
 * This is the model class for table "pilot_event_calender".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $event_name
 * @property integer $start_date
 * @property string $end_date
 * @property string $updated
 * @property string $created
 */
class PilotEventCalender extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_event_calender';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'event_name', 'start_date', 'end_date', 'updated', 'created', 'company_id', 'challenge_id'], 'required'],
            [['user_id'], 'integer'],
            [['event_name', 'updated', 'created'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'event_name' => 'Event Name',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'updated' => 'Updated',
            'created' => 'Created',
            'color' => 'Color',
            'company_id' => 'Select Company',
            'challenge_id' => 'Select Challenge',
            'assign' => 'Assign Users',
        ];
    }

    /*
     * Retrive user name how create the event
     * @params $id integer
     * @return mixed
     */

    public static function getusername($id) {
        $models = PilotInhouseUser::find()->where(['id' => $id])->one();
        $name = ucfirst($models->firstname) . ' ' . ucfirst($models->lastname);
        if (empty($models->firstname)) {
            return $models->username;
        } else {
            return $name;
        }
    }

    /*
     * Retrive user name how create the event
     * @params $id integer
     * @return mixed
     */

    public static function getupdatedate($id) {
        $model = PilotEventCalender::find()->where(['id' => $id])->one();

        if (!empty($model->updated)) {
            return date('M d, Y', $model->updated);
        } else {
            return false;
        }
    }

    /*
     * Retrive user name how create the event
     * @params $id integer
     * @return mixed
     */

    public static function getcampanyname($id) {
        $model = Company::find()->where(['id' => $id])->one();
        return ucfirst($model->company_name);
    }

    /*
     * Retrive user name how create the event
     * @params $id integer
     * @return mixed
     */

    public static function geteventname($id) {
        $model = PilotEventCalender::find()->where(['id' => $id])->one();
        return ucfirst($model->event_name);
    }

    /*
     * Retrive start date of event
     * @params $id integer
     * @return mixed
     */

    public static function getstartdate($id) {
        $model = PilotEventCalender::find()->where(['id' => $id])->one();

        if (!empty($model->start_date)) {
            return date('M d, Y', $model->start_date);
        } else {
            return false;
        }
    }

    /*
     * Retrive End date of event
     * @params $id integer
     * @return mixed
     */

    public static function getenddate($id) {
        $model = PilotEventCalender::find()->where(['id' => $id])->one();

        if (!empty($model->end_date)) {
            return date('M d, Y', $model->end_date);
        } else {
            return false;
        }
    }

    /*
     * Retrive Challenge Name
     * @params $id integer
     * @return mixed
     */

    public static function getchallengename($challenge_id) {
        $challenge_name = '';
        if ($challenge_id == '1') {
            $challenge_name = '30-day teamwork challenge';
        }
        if ($challenge_id == '2') {
            $challenge_name = '30-day customer service challenge';
        }
        if ($challenge_id == '3') {
            $challenge_name = '30-day productivity challenge';
        }
        if ($challenge_id == '4') {
            $challenge_name = '30-day leadership challenge';
        }
        if ($challenge_id == '5') {
            $challenge_name = '30-day leadership challenge';
        }

        return $challenge_name;
    }

    /**
     * Retrive color of upcomming event listing
     * @params $id integer
     * @return mixed
     */
    public function getupcommingevents($id) {
        $model = PilotEventCalender::findOne($id);
        if (!empty($model)) {
            if ($model->start_date != $model->end_date) {
                $start_date = date('M d', $model->start_date);
                $end_date = date('M d, Y', $model->end_date);
                $date = $start_date . ' - ' . $end_date;
            } else {
                $date = date('d M, Y', $model->start_date);
            }
            return "<div class='external-event'><div style='background-color:$model->color;' class='event-color'></div>" . ucfirst($model->event_name) . "<br /><span style='padding-left: 16px;'>$date</span></div>";
        }
        return false;
    }

    /**
     * check edit or delete button will show to user or not permission 
     * @params $id integer
     * @return mixed
     */
    public static function getcheckbuttonpermission($model) {
        if (Yii::$app->user->identity->id == $model->user_id || Yii::$app->user->identity->role == '1') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * create the calender event
     * @params $event_name varchar
     * @params $user_id integer
     * @params $company_id integer
     * @params $challenge_id integer
     * @params $start_date varchar
     * @params $start_date varchar
     * @return mixed
     */
    public function save_calender_event($id, $user_id, $company_id, $challenge_id, $register_date, $start_date, $makeupdays, $surveydate, $end_date) {
        $event = \backend\models\PilotGameChallengeName::findOne($challenge_id);
        $event_name = $event->challenge_name;
        $color_array = array('rgb(57, 204, 204)', 'rgb(221, 75, 57)', 'rgb(96, 92, 168)', 'rgb(255, 133, 27)', 'rgb(243, 156, 18)', 'rgb(240, 18, 190)',
            'rgb(57, 204, 204)', 'rgb(255, 133, 27)', 'rgb(0, 31, 63)', '	rgb(0, 192, 239)', 'rgb(0, 115, 183)', 'rgb(60, 141, 188)', 'rgb(0, 166, 90)', 'rgb(1, 255, 112)', 'rgb(114, 175, 210)');

        $rand = rand(0, 15);
        $color = $color_array[$rand];

        if (empty($color)) {
            $color = $color_array[7];
        }
        //save register event
        $model = new PilotEventCalender();
        $model->game_id = $id;
        $model->event_name = 'Registration start ' . $event_name;
        $model->event_id = 1; //for game registration start
        $model->user_id = $user_id;
        $model->company_id = $company_id;
        $model->challenge_id = $challenge_id;
        $model->start_date = $register_date;
        $model->color = $color;
        $model->end_date = $register_date;
        $model->updated = time();
        $model->created = time();
        $model->save(false);
        // save game start and end date event
        $model = new PilotEventCalender();
        $model->game_id = $id;
        $model->event_name = $event_name;
        $model->event_id = 0; //for game start and end events
        $model->user_id = $user_id;
        $model->company_id = $company_id;
        $model->challenge_id = $challenge_id;
        $model->start_date = $start_date;
        $model->color = $color;
        $model->end_date = $end_date;
        $model->updated = time();
        $model->created = time();
        $model->save(false);
        //save nakeup day event
        $model = new PilotEventCalender();
        $model->game_id = $id;
        $model->event_name = 'Makeup Days';
        $model->event_id = 2; //for makeup days
        $model->user_id = $user_id;
        $model->company_id = $company_id;
        $model->challenge_id = $challenge_id;
        $model->start_date = $makeupdays;
        $model->color = $color;
        $model->end_date = $end_date;
        $model->updated = time();
        $model->created = time();
        $model->save(false);
        return $model->id;
        Yii::$app->session->setFlash('custom_message', 'Event has been created successfully!');
    }

    public function save_surveydates_event($event_id, $id, $user_id, $company_id, $challenge_id, $start_date, $end_date) {
        $model1 = PilotEventCalender::find()->where(['id' => $event_id, 'game_id' => $id])->one();
        $event_name = \backend\models\PilotCreateGame::getchallengename($id);
        $color_array = array('rgb(57, 204, 204)', 'rgb(221, 75, 57)', 'rgb(96, 92, 168)', 'rgb(255, 133, 27)', 'rgb(243, 156, 18)', 'rgb(240, 18, 190)',
            'rgb(57, 204, 204)', 'rgb(255, 133, 27)', 'rgb(0, 31, 63)', '	rgb(0, 192, 239)', 'rgb(0, 115, 183)', 'rgb(60, 141, 188)', 'rgb(0, 166, 90)', 'rgb(1, 255, 112)', 'rgb(114, 175, 210)');

        $rand = rand(0, 15);
        $color = $color_array[$rand];

        if (empty($color)) {
            $color = $color_array[7];
        }

        $model = new PilotEventCalender();
        $model->game_id = $id;
        $model->event_name = 'Survey Dates';
        $model->event_id = 3; //for survey
        $model->user_id = $user_id;
        $model->company_id = $company_id;
        $model->challenge_id = $challenge_id;
        $model->start_date = $start_date;
        $model->color = $model1->color;
        $model->end_date = $end_date;
        $model->updated = time();
        $model->created = time();
        $model->save(false);
        Yii::$app->session->setFlash('custom_message', 'Event has been created successfully!');
    }

    public function update_calender_event($id, $start_date, $end_date, $event_id) {
        $event_name = \backend\models\PilotCreateGame::getchallengename($id);
        $model = PilotEventCalender::find()->where(['game_id' => $id, 'event_id' => $event_id])->one();
        if (!empty($model)):
            if ($event_id == 1):
                $model->event_name = 'Registration Start ' . $event_name;
            endif;
            if ($event_id == 0):
                $model->event_name = $event_name;
            endif;
            if ($event_id == 2):
                $model->event_name = 'Makeup Days';
            endif;
            $model->start_date = $start_date;
            $model->end_date = $end_date;
            $model->updated = time();
            $model->save(false);
            Yii::$app->session->setFlash('custom_message', 'Event has been updated successfully!');
        endif;
    }

    public function update_survey_event($event_id, $id, $user_id, $company_id, $challenge_id, $start_date, $end_date) {
        $model = PilotEventCalender::find()->where(['game_id' => $id, 'event_id' => $event_id])->one();
        if (!empty($model)):
            if ($event_id == 3):
                $model->event_name = 'Survey Dates';
            endif;
            $model->start_date = $start_date;
            $model->end_date = $end_date;
            $model->updated = time();
            $model->save(false);
        else:
            $model1 = PilotEventCalender::find()->where(['game_id' => $id])->one();
            $model = new PilotEventCalender();
            $model->game_id = $id;
            $model->event_name = 'Survey Dates';
            $model->event_id = $event_id; //for survey
            $model->user_id = $user_id;
            $model->company_id = $company_id;
            $model->challenge_id = $challenge_id;
            $model->start_date = $start_date;
            $model->color = $model1->color;
            $model->end_date = $end_date;
            $model->updated = time();
            $model->created = time();
            $model->save(false);
        endif;
    }

}
