<?php

namespace backend\models;

use Yii;
use backend\models\PilotInhouseUser;
use backend\models\Company;
use backend\models\Categories;
use backend\models\PilotCompanyTeams;
use backend\models\PilotGameChallengeName;

/**
 * This is the model class for table "pilot_manage_game".
 *
 * @property integer $id
 * @property string $company_name
 * @property string $challenge_start_date
 * @property string $challenge_team
 * @property string $winner_posted_date
 * @property string $survey_date
 * @property string $zodiac_1st_email
 * @property string $zodiac_2nd_email
 * @property string $zodiac_3rd_email
 * @property string $injoyglobal_1st_email
 * @property string $injoyglobal_2nd_email
 * @property string $injoyglobal_3rd_email
 */
class PilotCreateGame extends \yii\db\ActiveRecord {

    public $manager;
    //public $banner_image1;
    public $companynamecustom;
    public $categoryexpreess;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_create_game';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['challenge_id', 'challenge_start_date', 'challenge_end_date', 'challenge_registration_date', 'challenge_survey_date', 'challenge_company_id', 'features',
            'executive_email_1', 'inhouse_email_1', 'corners', 'daily_inspiration_content', 'makeup_days', 'howitwork_content', 'welcome_msg', 'thankyou_msg', 'highfive_heading', 'highfive_placeholder', 'scorecard_bottom', 'left_corner_heading', 'right_corner_heading', 'left_corner_type'], 'required'],
            [['executive_email_1', 'executive_email_2', 'executive_email_3', 'inhouse_email_1', 'inhouse_email_2', 'inhouse_email_3'], 'email'],
            [['challenge_teams'], 'integer'],
            [['leadership_corner_content', 'weekly_challenge_content', 'daily_inspiration_content', 'checkin_yourself_content', 'core_value_content', 'banner_image', 'getstarted', 'core_heading', 'get_to_know_content', 'did_you_know_content','howitwork_content','voicematters_content','todays_lesson_content'], 'string', 'max' => 255],
            [['banner_image1'], 'file', 'extensions' => 'png, jpg'],
            [['core_image'], 'image', 'extensions' => 'png, jpg'],
            [['welcome_msg', 'thankyou_msg', 'highfive_heading', 'highfive_placeholder', 'scorecard_bottom'], 'string', 'max' => 1000],
            [['prize_content', 'banner_text_1', 'banner_text_2'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'challenge_id' => 'Challenge Name',
            'banner_text_1' => 'Banner Text 1',
            'banner_text_1' => 'Banner Text 2',
            'challenge_start_date' => "Challenge Start Date",
            'challenge_end_date' => 'Challenge End Date',
            'makeup_days' => 'Makeup Days',
            'challenge_registration_date' => 'Challenge Registration Start From',
            'challenge_survey_date' => 'Survey Start On',
            'challenge_company_id' => 'Challenge Company Name',
            'challenge_teams' => 'Select Team',
            'daily_inspiration_content' => 'Daily Inspiration Content',
            'weekly_challenge_content' => 'Weekly Challenge Content',
            'leadership_corner_content' => 'Leadership Corner Content',
            'checkin_yourself_content' => 'Checkin Yourself Content',
            'welcome_msg' => 'Welcome Message',
            'thankyou_msg' => 'Thankyou Message',
            'features' => 'Features',
            'survey' => 'survey',
            'survey_questions' => 'Survey Questions',
            'executive_email_1' => 'Email 1',
            'executive_email_2' => 'Email 2',
            'executive_email_3' => 'Email 3',
            'inhouse_email_1' => 'Email 1',
            'inhouse_email_2' => 'Email 2',
            'inhouse_email_3' => 'Email 3',
            'banner_image' => 'Banner Image',
            'thankyou_image' => 'Thankyou',
            'highfive_heading' => 'ShoutOut Heading',
            'highfive_placeholder' => 'ShoutOut Placeholder',
            'scorecard_bottom' => 'Scorecard Bottom',
            'prize_content' => 'Prize Content',
            'howitwork_content' => 'How It Work Content',
            'core_image' => 'Core Image',
            'core_heading' => 'Core Heading',
            'corners' => 'corners',
            'status' => 'status',
            'created' => 'created',
            'updated' => 'updated',
            'created_user_id' => 'created_user_id',
            'manager' => 'manager',
            'getstarted' => 'getstarted',
        ];
    }

    /*
     * get the challengename from PilotCreateGame model
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getchallengename($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $event = \backend\models\PilotGameChallengeName::findOne($model->challenge_id);
        if ($event):
            $challenge_name = $event->challenge_name;
            if (!empty($model->banner_text_1)):
                $challenge_name = $model->banner_text_1 . ' ' . $model->banner_text_2;
            endif;
        endif;
        return $challenge_name;
    }

    public static function getbannertext($id) {
        // echo $id;die;
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        // $event = \backend\models\PilotGameChallengeName::findOne($model->challenge_id);
        $challenge_name = $model->banner_text_1 . ' ' . $model->banner_text_2;

        return $challenge_name;
    }

    /*
     * get the created username  from PilotInhouseUser model
     * corresponding to the PilotCreateGame created
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getcreated($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $user = PilotInhouseUser::find()->where(['id' => $model->created_user_id])->one();
        $final = date("M  d, Y", $model->created);
        return $user->username . '<br />' . $final;
    }

    public static function getupdated($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $user = PilotInhouseUser::find()->where(['id' => $model->created_user_id])->one();
        $final = date("M  d, Y", $model->updated);
        return $user->username . '<br />' . $final;
    }

    /*
     * get the enddate from PilotCreateGame model
     * add 1 month to the start date
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getenddate($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $time = $model->challenge_end_date;
        $final = date("M  d, Y", $time);
        return "<i class='fa fa-calendar' style='margin-right: 8px;' ></i>" . $final;
    }

    /*
     * get the startdate from PilotCreateGame model
     * for gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getstartdate($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $time = $model->challenge_start_date;
        $final = date("M  d, Y", $time);
        return "<i class='fa fa-calendar' style='margin-right: 8px;'></i>" . $final;
    }

    /*
     * get the companyname from Company model
     * for gridview listing page
     * @params $id integer
     * @params $cid integer
     * @return mixed
     */

    public static function getcompanyname($cid, $id) {
        $model = Company::find()->where(['id' => $cid])->one();
        $game = PilotCreateGame::find()->where(['id' => $id])->one();

        $selected_teams = array();
        if (!empty($game->challenge_teams)) {
            $selected_teams = explode(',', $game->challenge_teams);
        }
        $teamsNames = array();
        foreach ($selected_teams as $value) {
            $team = PilotCompanyTeams::find()->where(['id' => $value])->one();
            $teamsNames[] = $team->team_name;
        }
        if (!empty($teamsNames)) {
            $teamsNames = implode(', ', $teamsNames);
        } else {
            $teamsNames = '';
        }
        $image = $model->image;
        if (empty($image)) {
            $image = 'trans.gif.jpg';
        }

        return '<div class="image-wrapper"><img width="100" alt="" src="/backend/web/img/uploads/' . $image . '"></div>' . $model->company_name . '<br/><span class="small">' . $teamsNames . '</span>';
    }

    /*
     * make relation with PilotGameChallengeName model for searching
     * on gridview listing page
     * @return mixed
     */

    public function getManagerinfo() {
        return $this->hasMany(Company::className(), ['id' => 'challenge_company_id']);
    }

    /*
     * get the status from PilotCreateGame
     * on gridview listing page
     * @params $id integer
     * @return mixed
     */

    public static function getstatus($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $status = $model->status;
        /* if ($status == 0) {
          return 'Upcoming';
          }
          if ($status == 1) {
          return 'Ongoing';
          }
          if ($status == 2) {
          return 'Old';
          } */
        if ($status == 0) {
            return '<img src="' . Yii::$app->homeUrl . '/img/stop.png"> Upcoming';
        }
        if ($status == 1) {
            return '<img src="' . Yii::$app->homeUrl . '/img/inprogress.png"> Ongoing';
        }
        if ($status == 2) {
            return '<img src="' . Yii::$app->homeUrl . '/img/check.png"> Completed';
        }
    }

    public static function getcurrentgame($id) {
        $model = PilotCreateGame::find()->where(['challenge_company_id' => $id, 'status' => 1])->one();
        if (($model->status) == 1) {
            $challengename = PilotGameChallengeName::find()->where(['id' => $model->challenge_id])->one();

            if (!empty($model->banner_text_1) && !empty($model->banner_text_2)) {
                $challenge_name = strtolower($model->banner_text_1) . ' ' . strtolower($model->banner_text_2);
            } else {
                $challenge_name = $challengename->challenge_name;
            }
            return $challenge_name;
        } else {
            return 'NA';
        }
    }

    /*
     * get the Name of manger
     * on gridview listing page
     * @params $cid integer company id
     * @return mixed
     */

    public static function getManager($cid) {

        $res = '';
        $n = 1;
        $companyManager = Company::find()->where(['id' => $cid])->one();
        $cid = explode(',', $companyManager->manager);
        $count = count($cid);
        foreach ($cid as $id) {
            $model = PilotInhouseUser::find()->where(['id' => $id])->one();
            if ($n != $count) {
                $res .= $model->username . ',<br />';
            } else {
                $res .= $model->username;
            }
            $n++;
        }

        return $res;
        //return $count;
    }

    public static function getnumofdays($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $start = $model->challenge_start_date;
        $end = $model->challenge_end_date;
        $diff = $end - $start;
        $nodays = ($diff / 60 / 60 / 24) + 1;
        return round($nodays) . ' Days';
    }

    public static function getmakeupdays($id) {
        $model = PilotCreateGame::find()->where(['id' => $id])->one();
        $end = $model->challenge_end_date;
        $makeup = $model->makeup_days;
        if (!empty($makeup)) {
            $diff = $end - $makeup;
            $nodays = ($diff / 60 / 60 / 24) + 1;

            return round($nodays) . ' Days';
        } else {
            return '0 Days';
        }
    }
    
     public static function getcategoryname($cid, $id) {
        $model = Categories::find()->where(['id' => $cid])->one();
        $game = PilotCreateGame::find()->where(['id' => $id])->one();
        if (!empty($model)):
            return  $model->Category_name;
        else:
            return 'NA';
        endif;
    }
}
