<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotCreateGame;
use backend\models\Company;
use backend\models\PilotCompanyTeams;
use backend\models\PilotGameChallengeName;
use backend\models\CronReports;
use frontend\models\PilotFrontServiceTotalPoints;
use frontend\models\PilotFrontUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**

 * PilotManageGameController implements the CRUD actions for PilotManageGame model.

 */
class CronController extends Controller {
    /*

     * enable csrf validation for ajax hit

     */

    public function beforeAction($action) {

        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**

     * @inheritdoc

     */
    public function behaviors() {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionCurrentgame() {

        $gamemodel = PilotCreateGame::find()->all();

        foreach ($gamemodel as $model) {

            $challenge = Company::find()->where(['id' => $model->challenge_company_id])->one();

            if (!empty($challenge->timezone)):

                date_default_timezone_set($challenge->timezone);

            endif;

            $current_time = time();

            $currentdate = date("m-d-Y", $current_time);

            $end_date = strtotime("+1 days", $model->challenge_end_date);

            if ($model->challenge_start_date > $current_time) {



                $model->status = 0; //for upcoming
            }

            if (($model->challenge_start_date <= $current_time) && ($current_time <= $end_date)) {



                $model->status = 1; // for ongoing
            }

            if ($end_date < $current_time) {

                $model->status = 2; // for completed
            }

            $model->save(false);
        }

        echo 'data updated according to the date';
    }

    /*     * ****************************************DOWNLOAD CODE START HERE****************************************************** */

    /*

     * downloading of active user listing

     */

    public function actionCronReports() {

        $value1 = [1, 2];

        $game_obj1 = PilotCreateGame::find()->where(['status' => 1])->all();

        if (!empty($game_obj1)):

            foreach ($game_obj1 as $game_obj):

                $game_id = $game_obj->id;

                $game = $game_obj->challenge_id;

                $comp_id = $game_obj->challenge_company_id;

                $game_start_date_timestamp = $game_obj->challenge_start_date;

                $game_end_date_timestamp = $game_obj->challenge_end_date;

                $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();

                $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

                //Dynamically declare the Challenge Models

                if ($game != 7 && $game != 8 && $game != 11):

                    $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';

                    $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';

                    $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';

                    $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';

                    $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';

                    $share_a_win_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';

                else:

                    $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';

                    $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';

                    $audio_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';

                    $did_you_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Knowcorner';

                    $question_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Question';

                endif;

                //$steps_api_model = '\frontend\\models\\PilotFront' . $challenge_abr . 'StepsApiData';
                //Get Total Users for Challenge Company

                $company_users = \frontend\models\PilotFrontUser::find()->where(['company_id' => $comp_id, 'challenge_id' => $game])->all();

                $users_weekly_points = [];

                $week = PilotFrontUser::getGameWeek($game_obj);

                if ($week == 0) {

                    $days = PilotFrontUser::datediff($game_start_date_timestamp, $game_end_date_timestamp);

                    $week1 = $days / 7;

                    $weekarray = explode('.', $week1);

                    $week = $weekarray[0] + 1;
                } else {

                    $week = $week - 1;
                }
                //echo $week;die;

                $weekfolder = 'week' . $week;

                if (!file_exists(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id)) {

                    mkdir(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id, 0777, true);
                }

                if (!file_exists(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id . '/' . $weekfolder)) {

                    mkdir(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id . '/' . $weekfolder, 0777, true);
                }

                if (!empty($game_obj->challenge_teams)):

                    $teams[] = explode(',', $game_obj->challenge_teams);

                    foreach ($teams as $value):

                        foreach ($value as $id):

                            $users_weekly_points1 = [];

                            $company_users1 = \frontend\models\PilotFrontUser::find()->where(['company_id' => $comp_id, 'challenge_id' => $game, 'team_id' => $id])->all();
                            if ($game == 7 || $game == 8 || $game == 11):

//Get the Total Points for Each User

                                foreach ($company_users as $user):

                                    if ($user->id !== 601): //Test User for Injoy

                                        $users_weekly_points1[$user->id] = \frontend\models\PilotFrontUser::getlearningUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week);

                                    endif;

                                endforeach;
                                //echo '<pre>';print_r($users_weekly_points1);die;
                                $user_arr1 = [];
                                //Sort Array in Decending order as per Total Points of Users

                                arsort($users_weekly_points1);

                                foreach ($users_weekly_points1 as $user_id => $total_points):

                                    $user_obj = \frontend\models\PilotFrontUser::findIdentity($user_id);



                                    $updated_arr1 = [];

                                    //Total Daily Inspiration

                                    $daily_actions = count($daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                                    ->andWhere(['<=', 'week_no', $week])
                                                    ->all());



                                    $daily_actions_data = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->andWhere(['!=', 'points', 0])
                                            ->orderBy(['updated' => SORT_DESC])
                                            ->one();

                                    $updated_arr1[] = $daily_actions_data->updated;

                                    //echo "<pre>";print_r($daily_actions_data);die;
                                    //Total Get to Know the team

                                    $corner_tips_actions = count($question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                                    ->andWhere(['<=', 'week_no', $week])
                                                    ->all());

                                    $corner_tips_data = $question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->andWhere(['!=', 'points', 0])
                                            ->orderBy(['updated' => SORT_DESC])
                                            ->one();

                                    $updated_arr1[] = $corner_tips_data->updated;

                                    //Total today's lesson

                                    $weekly_actions = count($audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                                    ->andWhere(['<=', 'week_no', $week])
                                                    ->all());

                                    $weekly_actions_data = $audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->andWhere(['!=', 'points', 0])
                                            ->orderBy(['updated' => SORT_DESC])
                                            ->one();

                                    $updated_arr1[] = $weekly_actions_data->updated;

                                    //Total High Fives

                                    $digital_hfs = count($high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])
                                                    ->andWhere(['<=', 'week_no', $week])
                                                    ->all());

                                    $digital_hfs_data = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->andWhere(['!=', 'points', 0])
                                            ->orderBy(['updated' => SORT_DESC])
                                            ->one();

                                    $updated_arr1[] = $digital_hfs_data->updated;

                                    //Total didyouknow

                                    $share_a_wins = count($did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                                    ->andWhere(['<=', 'week_no', $week])
                                                    ->all());

                                    $share_a_wins_data = $did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->andWhere(['!=', 'points', 0])
                                            ->orderBy(['updated' => SORT_DESC])
                                            ->one();

                                    $updated_arr1[] = $share_a_wins_data->updated;


                                    $updated1 = max($updated_arr1);

                                    //Total Actions

                                    $total_actions = \frontend\models\PilotFrontUser::getlearningWeeklyActions($user_id, $challenge_obj, $game, $comp_id, $week);



                                    //Total Raffle Tickets

                                    $raffle_ticket = floor($total_points / 100);



                                    $user_arr1[] = [
                                        'id' => $user_id,
                                        'firstname' => $user_obj->firstname,
                                        'lastname' => $user_obj->lastname,
                                        'email' => $user_obj->emailaddress,
                                        'daily_actions' => $daily_actions,
                                        'shout_out' => $digital_hfs,
                                        'leadership_corner' => $corner_tips_actions,
                                        'weekly_video' => $weekly_actions,
                                        'share_a_wins' => $share_a_wins,
                                        'total_actions' => $total_actions,
                                        'total_points' => $total_points,
                                        'raffle_ticket' => $raffle_ticket,
                                        'updated1' => $updated1,
                                    ];

                                    //echo '<pre>';print_r($user_arr1);die;
                                endforeach;

                            else:

                                if (!empty($company_users1)):

                                    foreach ($company_users1 as $user):

                                        if ($user->id !== 196): //Test User for Injoy

                                            $users_weekly_points1[$user->id] = \frontend\models\PilotFrontUser::getUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week);

                                        endif;

                                    endforeach;



                                    //Sort Array in Decending order as per Total Points of Users

                                    arsort($users_weekly_points1);

                                    //User Array for Report Generation
                                    //echo "<pre>";print_r($users_weekly_points1);die;

                                    $user_arr1 = [];

                                    foreach ($users_weekly_points1 as $user_id => $total_points):

                                        $user_obj = \frontend\models\PilotFrontUser::findIdentity($user_id);

                                        $updated_arr1 = [];

                                        //Total Daily Inspiration

                                        $daily_actions = count($daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                        ->andWhere(['<=', 'week_no', $week])
                                                        ->all());



                                        $daily_actions_data = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week])
                                                ->andWhere(['!=', 'points', 0])
                                                ->orderBy(['updated' => SORT_DESC])
                                                ->one();

                                        $updated_arr1[] = $daily_actions_data->updated;

                                        //echo "<pre>";print_r($daily_actions_data);die;
                                        //Total Leadership Corner

                                        $corner_tips_actions = count($corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                        ->andWhere(['<=', 'week_no', $week])
                                                        ->all());

                                        $corner_tips_data = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week])
                                                ->andWhere(['!=', 'points', 0])
                                                ->orderBy(['updated' => SORT_DESC])
                                                ->one();

                                        $updated_arr1[] = $corner_tips_data->updated;

                                        //Total Weekly Entries

                                        $weekly_actions = count($weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                        ->andWhere(['<=', 'week_no', $week])
                                                        ->all());

                                        $weekly_actions_data = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week])
                                                ->andWhere(['!=', 'points', 0])
                                                ->orderBy(['updated' => SORT_DESC])
                                                ->one();

                                        $updated_arr1[] = $weekly_actions_data->updated;

                                        //Total High Fives

                                        $subQuery1 = $high_five_model_name::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');

                                        $query1 = $high_five_model_name::find()->where(['in', 'id', $subQuery1])->andwhere(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week]);

                                        $digital_images = $query1->count();

                                        $query2 = $high_five_model_name::find()->where(['not in', 'id', $subQuery1])->andwhere(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week]);

                                        $digital_hfs = $query2->count();

                                        $digital_hfs_data = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week])
                                                ->andWhere(['!=', 'points', 0])
                                                ->orderBy(['updated' => SORT_DESC])
                                                ->one();



                                        $updated_arr1[] = $digital_hfs_data->updated;

                                        //Total Core Values

                                        $core_values = count($check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => 'core_values_popup', 'challenge_id' => $game_id])
                                                        ->andWhere(['<=', 'week_no', $week])
                                                        ->all());

                                        $core_values_data = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => 'core_values_popup', 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week])
                                                ->andWhere(['!=', 'points', 0])
                                                ->orderBy(['updated' => SORT_DESC])
                                                ->one();

                                        $updated_arr1[] = $core_values_data->updated;

                                        //Total Check Ins

                                        $chek_in_actions = count($check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                        ->andWhere(['<=', 'week_no', $week])
                                                        ->andWhere(['!=', 'label', 'core_values_popup'])
                                                        ->all());

                                        $chek_in_data = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week])
                                                ->andWhere(['!=', 'points', 0])
                                                ->orderBy(['updated' => SORT_DESC])
                                                ->one();

                                        $updated_arr1[] = $chek_in_data->updated;

                                        //Total Share a wins

                                        $share_a_wins = count($share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                        ->andWhere(['<=', 'week_no', $week])
                                                        ->all());

                                        $share_a_wins_data = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                                ->andWhere(['<=', 'week_no', $week])
                                                ->andWhere(['!=', 'points', 0])
                                                ->orderBy(['updated' => SORT_DESC])
                                                ->one();

                                        $updated_arr1[] = $share_a_wins_data->updated;


                                        $updated1 = max($updated_arr1);



                                        //Total Actions

                                        $total_actions = \frontend\models\PilotFrontUser::getUserWeeklyActions($user_id, $challenge_obj, $game, $comp_id, $week);



                                        //Total Raffle Tickets

                                        $raffle_ticket = floor($total_points / 100);



                                        $user_arr1[] = [
                                            'id' => $user_id,
                                            'firstname' => $user_obj->firstname,
                                            'lastname' => $user_obj->lastname,
                                            'email' => $user_obj->emailaddress,
                                            'daily_actions' => $daily_actions,
                                            'core_values' => $core_values,
                                            'check_in' => $chek_in_actions,
                                            'shout_outonly' => $digital_hfs,
                                            'shout_outimages' => $digital_images,
                                            'leadership_corner' => $corner_tips_actions,
                                            'weekly_video' => $weekly_actions,
                                            'share_a_wins' => $share_a_wins,
                                            'total_actions' => $total_actions,
                                            //'total_steps' => $total_steps,
                                            'total_points' => $total_points,
                                            'raffle_ticket' => $raffle_ticket,
                                            'updated1' => $updated1,
                                        ];

                                    endforeach;
                                endif;
                            endif;
                            $sort = array();
                            foreach ($user_arr1 as $key => $row) {

                                $sort['total_points'][$key] = $row['total_points'];

                                $sort['updated1'][$key] = $row['updated1'];
                            }

                            array_multisort($sort['total_points'], SORT_DESC, $sort['updated1'], SORT_DESC, $user_arr1);

                            $response = $this->generateExcelTeam($game, $game_obj, $comp_id, $challenge_obj, $week, $user_arr1, $id);
//                            echo $response;
//                            die;

                            if ($response == '1'):

                                $cron = new CronReports();

                                $cron->game_id = $game_obj->id;

                                $cron->week_no = $week;

                                $cron->team_id = $id;

                                $cron->filepath = 'weekly-reports/' . $game_obj->id . '/' . $weekfolder . '/' . $id . '.xls';

                                $cron->created = time();

                                $cron->updated = time();

                                $cron->save(false);

                            endif;


                        endforeach;

                    endforeach;

                endif;

                //Get the Total Points for Each User

                /* foreach ($company_users as $user):

                  if ($user->id !== 196): //Test User for Injoy

                  $users_weekly_points[$user->id] = \frontend\models\PilotFrontUser::getUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week);

                  endif;

                  endforeach; */

                //Sort Array in Decending order as per Total Points of Users
                //  arsort($users_weekly_points);
                //User Array for Report Generation 

                $user_arr = [];

                if ($game == 7 || $game == 8 || $game == 11):

//Get the Total Points for Each User

                    foreach ($company_users as $user):

                        if ($user->id !== 196): //Test User for Injoy

                            $users_weekly_points[$user->id] = \frontend\models\PilotFrontUser::getlearningUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week);

                        endif;

                    endforeach;

                    //Sort Array in Decending order as per Total Points of Users

                    arsort($users_weekly_points);

                    foreach ($users_weekly_points as $user_id => $total_points):

                        $user_obj = \frontend\models\PilotFrontUser::findIdentity($user_id);



                        $updated_arr = [];

                        //Total Daily Inspiration

                        $daily_actions = count($daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                        ->andWhere(['<=', 'week_no', $week])
                                        ->all());



                        $daily_actions_data = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                ->andWhere(['<=', 'week_no', $week])
                                ->andWhere(['!=', 'points', 0])
                                ->orderBy(['updated' => SORT_DESC])
                                ->one();

                        $updated_arr[] = $daily_actions_data->updated;

                        //echo "<pre>";print_r($daily_actions_data);die;
                        //Total Get to Know the team

                        $corner_tips_actions = count($question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                        ->andWhere(['<=', 'week_no', $week])
                                        ->all());

                        $corner_tips_data = $question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                ->andWhere(['<=', 'week_no', $week])
                                ->andWhere(['!=', 'points', 0])
                                ->orderBy(['updated' => SORT_DESC])
                                ->one();

                        $updated_arr[] = $corner_tips_data->updated;

                        //Total today's lesson

                        $weekly_actions = count($audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                        ->andWhere(['<=', 'week_no', $week])
                                        ->all());

                        $weekly_actions_data = $audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                ->andWhere(['<=', 'week_no', $week])
                                ->andWhere(['!=', 'points', 0])
                                ->orderBy(['updated' => SORT_DESC])
                                ->one();

                        $updated_arr[] = $weekly_actions_data->updated;

                        //Total High Fives

                        $digital_hfs = count($high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])
                                        ->andWhere(['<=', 'week_no', $week])
                                        ->all());

                        $digital_hfs_data = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                ->andWhere(['<=', 'week_no', $week])
                                ->andWhere(['!=', 'points', 0])
                                ->orderBy(['updated' => SORT_DESC])
                                ->one();

                        $updated_arr[] = $digital_hfs_data->updated;

                        //Total didyouknow

                        $share_a_wins = count($did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                        ->andWhere(['<=', 'week_no', $week])
                                        ->all());

                        $share_a_wins_data = $did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                                ->andWhere(['<=', 'week_no', $week])
                                ->andWhere(['!=', 'points', 0])
                                ->orderBy(['updated' => SORT_DESC])
                                ->one();

                        $updated_arr[] = $share_a_wins_data->updated;

                        //Total points
//                    $updates = PilotFrontServiceTotalPoints::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
//                            ->one();



                        $updated = max($updated_arr);

                        //Total Steps
//                   $total_steps = 0;
//                    $steps_sum = $steps_api_model::find()->where(['user_id' => $user_id])
//                            ->andWhere(['<=', 'week_no', $week])
//                            ->sum('steps');
//                    if (!empty($steps_sum)):
//                        $total_steps = $steps_sum;
//                    endif;
                        //Total Actions

                        $total_actions = \frontend\models\PilotFrontUser::getlearningWeeklyActions($user_id, $challenge_obj, $game, $comp_id, $week);



                        //Total Raffle Tickets

                        $raffle_ticket = floor($total_points / 100);



                        $user_arr[] = [
                            'id' => $user_id,
                            'firstname' => $user_obj->firstname,
                            'lastname' => $user_obj->lastname,
                            'email' => $user_obj->emailaddress,
                            'daily_actions' => $daily_actions,
                            'shout_out' => $digital_hfs,
                            'leadership_corner' => $corner_tips_actions,
                            'weekly_video' => $weekly_actions,
                            'share_a_wins' => $share_a_wins,
                            'total_actions' => $total_actions,
                            //'total_steps' => $total_steps,
                            'total_points' => $total_points,
                            'raffle_ticket' => $raffle_ticket,
                            'updated' => $updated,
                        ];

                    endforeach;

                else:

                    foreach ($company_users as $user):

                        if ($user->id !== 196): //Test User for Injoy

                            $users_weekly_points[$user->id] = \frontend\models\PilotFrontUser::getUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week);

                        endif;

                    endforeach;

                    foreach ($users_weekly_points as $user_id => $total_points):

                        if ($total_points != 0):

                            $user_obj = \frontend\models\PilotFrontUser::findIdentity($user_id);



                            $updated_arr = [];

                            //Total Daily Inspiration

                            $daily_actions = count($daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->all());



                            $daily_actions_data = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week])
                                    ->andWhere(['!=', 'points', 0])
                                    ->orderBy(['updated' => SORT_DESC])
                                    ->one();

                            $updated_arr[] = $daily_actions_data->updated;

                            //echo "<pre>";print_r($daily_actions_data);die;
                            //Total Leadership Corner

                            $corner_tips_actions = count($corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->all());

                            $corner_tips_data = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week])
                                    ->andWhere(['!=', 'points', 0])
                                    ->orderBy(['updated' => SORT_DESC])
                                    ->one();

                            $updated_arr[] = $corner_tips_data->updated;

                            //Total Weekly Entries

                            $weekly_actions = count($weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->all());

                            $weekly_actions_data = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week])
                                    ->andWhere(['!=', 'points', 0])
                                    ->orderBy(['updated' => SORT_DESC])
                                    ->one();

                            $updated_arr[] = $weekly_actions_data->updated;

                            //Total High Fives

                            $subQuery1 = $high_five_model_name::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');

                            $query1 = $high_five_model_name::find()->where(['in', 'id', $subQuery1])->andwhere(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week]);

                            $digital_images = $query1->count();

                            $query2 = $high_five_model_name::find()->where(['not in', 'id', $subQuery1])->andwhere(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week]);

                            $digital_hfs = $query2->count();

                            $digital_hfs_data = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week])
                                    ->andWhere(['!=', 'points', 0])
                                    ->orderBy(['updated' => SORT_DESC])
                                    ->one();

                            $updated_arr[] = $digital_hfs_data->updated;

                            //Total Core Values

                            $core_values = count($check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => 'core_values_popup', 'challenge_id' => $game_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->all());

                            $core_values_data = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => 'core_values_popup', 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week])
                                    ->andWhere(['!=', 'points', 0])
                                    ->orderBy(['updated' => SORT_DESC])
                                    ->one();

                            $updated_arr[] = $core_values_data->updated;

                            //Total Check Ins

                            $chek_in_actions = count($check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->andWhere(['!=', 'label', 'core_values_popup'])
                                            ->all());

                            $chek_in_data = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week])
                                    ->andWhere(['!=', 'points', 0])
                                    ->orderBy(['updated' => SORT_DESC])
                                    ->one();

                            $updated_arr[] = $chek_in_data->updated;

                            //Total Share a wins

                            $share_a_wins = count($share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                            ->andWhere(['<=', 'week_no', $week])
                                            ->all());

                            $share_a_wins_data = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                    ->andWhere(['<=', 'week_no', $week])
                                    ->andWhere(['!=', 'points', 0])
                                    ->orderBy(['updated' => SORT_DESC])
                                    ->one();

                            $updated_arr[] = $share_a_wins_data->updated;

                            //Total points
//                    $updates = PilotFrontServiceTotalPoints::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
//                            ->one();



                            $updated = max($updated_arr);

                            //Total Steps
//                   $total_steps = 0;
//                    $steps_sum = $steps_api_model::find()->where(['user_id' => $user_id])
//                            ->andWhere(['<=', 'week_no', $week])
//                            ->sum('steps');
//                    if (!empty($steps_sum)):
//                        $total_steps = $steps_sum;
//                    endif;
                            //Total Actions

                            $total_actions = \frontend\models\PilotFrontUser::getUserWeeklyActions($user_id, $challenge_obj, $game, $comp_id, $week);



                            //Total Raffle Tickets

                            $raffle_ticket = floor($total_points / 100);



                            $user_arr[] = [
                                'id' => $user_id,
                                'firstname' => $user_obj->firstname,
                                'lastname' => $user_obj->lastname,
                                'email' => $user_obj->emailaddress,
                                'daily_actions' => $daily_actions,
                                'core_values' => $core_values,
                                'check_in' => $chek_in_actions,
                                'shout_outonly' => $digital_hfs,
                                'shout_outimages' => $digital_images,
                                'leadership_corner' => $corner_tips_actions,
                                'weekly_video' => $weekly_actions,
                                'share_a_wins' => $share_a_wins,
                                'total_actions' => $total_actions,
                                //'total_steps' => $total_steps,
                                'total_points' => $total_points,
                                'raffle_ticket' => $raffle_ticket,
                                'updated' => $updated,
                            ];

                        endif;

                    endforeach;

                endif;

                $sort = array();

                foreach ($user_arr as $key => $row) {

                    $sort['total_points'][$key] = $row['total_points'];

                    $sort['updated'][$key] = $row['updated'];
                }

                array_multisort($sort['total_points'], SORT_DESC, $sort['updated'], SORT_DESC, $user_arr);

                //array_multisort($updated, SORT_DESC, $user_arr);
                //echo "<pre>";print_r($user_arr);die;
                //usort($user_arr, "updated");
//                echo "<pre>";
//                print_r($user_arr);
//                die; 

                $response = $this->generateExcel1($game, $game_obj, $comp_id, $challenge_obj, $week, $user_arr);

                if ($response == '1'):

                    $cron = new CronReports();

                    $cron->game_id = $game_obj->id;

                    $cron->week_no = $week;

                    $cron->filepath = 'weekly-reports/' . $game_obj->id . '/' . $weekfolder . '/' . $weekfolder . '.xls';

                    $cron->created = time();

                    $cron->updated = time();

                    $cron->save(false);

                endif;

            endforeach;

        endif;
    }

    public function generateExcel1($game, $game_obj, $comp_id, $challenge_obj, $week, $user_arr) {

        //ob_start();

        $company = Company::find()->where(['id' => $comp_id])->one();

        $comp_name = str_replace(' ', '-', strtolower($company->company_name));

        $challenge_name = strtolower($game_obj->banner_text_1) . ' ' . strtolower($game_obj->banner_text_2);

        $company_logo = '/backend/web/img/uploads/' . $company->image;

        $game_start = date('F Y', $game_obj->challenge_start_date);

        $week_title = 'All Users - Week' . $week . ' - ' . $game_start;

        $weekfolder = 'week' . $week;

        // Create new PHPExcel object

        $objPHPExcel = new \PHPExcel();

        //Define Format of Excel Sheet

        $style_bold = [
            'font' => [
                'bold' => true,
            ],
        ];

        $style_align = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ]
        ];

        $style_border = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );

        $objPHPExcel->setActiveSheetIndex(0);

        //Merge Cells for Logo Display

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->mergeCells('A1:K4');

        else:

            $objPHPExcel->getActiveSheet()->mergeCells('A1:N4');

        endif;

        /* ADD LOGO */

        $objDrawing = new \PHPExcel_Worksheet_Drawing();

        $objDrawing->setName('Logo');

        $objDrawing->setDescription('Logo');

        $objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . $company_logo);

        $objDrawing->setCoordinates('A1');

        // set resize to false first

        $objDrawing->setResizeProportional(false);

        // set width later

        $objDrawing->setWidth(100);

        $objDrawing->setHeight(80);

        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        //$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);

        /* END LOGO */



        //Merge Cells for Challenge Name

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->mergeCells('A5:K6');

        else:

            $objPHPExcel->getActiveSheet()->mergeCells('A5:N6');

        endif;

        //Challenge Name Display

        $objPHPExcel->getActiveSheet()->setCellValue('A5', ucwords($challenge_obj->challenge_name));

//Merge Cells for Week Title

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->mergeCells('A7:K8');

        else:

            $objPHPExcel->getActiveSheet()->mergeCells('A7:N8');

        endif;

//Week Title Display

        $objPHPExcel->getActiveSheet()->setCellValue('A7', $week_title);



//Columns Header

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->setCellValue('A9', "#")
                    ->setCellValue('B9', "First Name")
                    ->setCellValue('C9', "Last Name")
                    ->setCellValue('D9', "Email Id")
                    ->setCellValue('E9', "Daily Inspiration")
                    ->setCellValue('F9', "Shout Out")
                    ->setCellValue('G9', "Today's Lesson")
                    ->setCellValue('H9', "Did You Know")
                    ->setCellValue('I9', "Your Voice Matters")
                    ->setCellValue('J9', "Overall Points")
                    ->setCellValue('K9', "Raffle Tickets");



// Add data

            $i = 10;

            $sno = 1;

            foreach ($user_arr as $user):

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno)
                        ->setCellValue('B' . $i, ucwords($user["firstname"]))
                        ->setCellValue('C' . $i, ucwords($user["lastname"]))
                        ->setCellValue('D' . $i, $user["email"])
                        ->setCellValue('E' . $i, $user["daily_actions"])
                        ->setCellValue('F' . $i, $user["shout_out"])
                        ->setCellValue('G' . $i, $user["weekly_video"])
                        ->setCellValue('H' . $i, $user["share_a_wins"])
                        ->setCellValue('I' . $i, $user["leadership_corner"])
                        ->setCellValue('J' . $i, $user["total_points"])
                        ->setCellValue('K' . $i, $user["raffle_ticket"]);

                $i++;

                $sno++;

            endforeach;

        else:

            $objPHPExcel->getActiveSheet()->setCellValue('A9', "#")
                    ->setCellValue('B9', "First Name")
                    ->setCellValue('C9', "Last Name")
                    ->setCellValue('D9', "Email Id")
                    ->setCellValue('E9', "Daily Inspiration")
                    ->setCellValue('F9', "Core Value")
                    ->setCellValue('G9', "Check in with yourself")
                    ->setCellValue('H9', "Shout Outs")
                    ->setCellValue('I9', "Appreciation In Action")
                    ->setCellValue('J9', "Leadership Corner")
                    ->setCellValue('K9', "Weekly Video")
                    ->setCellValue('L9', "Share A Win")
                    ->setCellValue('M9', "Overall Points")
                    ->setCellValue('N9', "Raffle Tickets");



// Add data

            $i = 10;

            $sno = 1;

            foreach ($user_arr as $user):

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno)
                        ->setCellValue('B' . $i, ucwords($user["firstname"]))
                        ->setCellValue('C' . $i, ucwords($user["lastname"]))
                        ->setCellValue('D' . $i, $user["email"])
                        ->setCellValue('E' . $i, $user["daily_actions"])
                        ->setCellValue('F' . $i, $user["core_values"])
                        ->setCellValue('G' . $i, $user["check_in"])
                        ->setCellValue('H' . $i, $user["shout_outonly"])
                        ->setCellValue('I' . $i, $user["shout_outimages"])
                        ->setCellValue('J' . $i, $user["leadership_corner"])
                        ->setCellValue('K' . $i, $user["weekly_video"])
                        ->setCellValue('L' . $i, $user["share_a_wins"])
                        ->setCellValue('M' . $i, $user["total_points"])
                        ->setCellValue('N' . $i, $user["raffle_ticket"]);

                $i++;

                $sno++;

            endforeach;

        endif;



//Wrap Text

        $objPHPExcel->getDefaultStyle()->applyFromArray($style_align)->getAlignment()->setWrapText(true);

//Bold Text & Font Size

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->getStyle('A5:K6')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A5:K6')->getFont()->setSize(18);

            $objPHPExcel->getActiveSheet()->getStyle('A7:K8')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:K9')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:K9')->getFont()->setSize(12);

//Border

            $lastcell = $i - 1;

            $objPHPExcel->getActiveSheet()->getStyle('A1:K' . $lastcell)->applyFromArray($style_border);

        else:

            $objPHPExcel->getActiveSheet()->getStyle('A5:N6')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A5:N6')->getFont()->setSize(18);

            $objPHPExcel->getActiveSheet()->getStyle('A7:N8')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:N9')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:N9')->getFont()->setSize(12);

//Border

            $lastcell = $i - 1;

            $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $lastcell)->applyFromArray($style_border);

        endif;

//Setting Width of Columns

        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(13);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

//Setting Height of Rows

        $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);

        $objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);

        $objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(15);

        $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(15);

        $objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(40);

        for ($j = 10; $j <= $lastcell; $j++):

            $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(30);

        endfor;



// Rename worksheet



        $objPHPExcel->getActiveSheet()->setTitle('Weekly Report');



// Set active sheet index to the first sheet, so Excel opens this as the first sheet

        $objPHPExcel->setActiveSheetIndex(0);



//Report Name

        $file_name = 'week' . $week . '.xls';





        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        if (!file_exists(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id . '/' . $weekfolder . '/' . $file_name)):

            $objWriter->save(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id . '/' . $weekfolder . '/' . $file_name);

            return true;

        endif;

        return false;
    }

    public function generateExcelTeam($game, $game_obj, $comp_id, $challenge_obj, $week, $user_arr1, $id) {

        //ob_start();

        $company = Company::find()->where(['id' => $comp_id])->one();

        $company_team = PilotCompanyTeams::find()->where(['id' => $id])->one();

        $team_name = $company_team->team_name;

        $comp_name = str_replace(' ', '-', strtolower($company->company_name));

        $challenge_name = strtolower($game_obj->banner_text_1) . ' ' . strtolower($game_obj->banner_text_2);

        $company_logo = '/backend/web/img/uploads/' . $company->image;

        $game_start = date('F Y', $game_obj->challenge_start_date);

        $week_title = 'All Users - Week' . $week . ' - ' . $game_start;

        $weekfolder = 'week' . $week;

        $title = $team_name . ' Report';

        // Create new PHPExcel object

        $objPHPExcel = new \PHPExcel();

        //Define Format of Excel Sheet

        $style_bold = [
            'font' => [
                'bold' => true,
            ],
        ];

        $style_align = [
            'alignment' => [
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => \PHPExcel_Style_Alignment::VERTICAL_CENTER,
            ]
        ];

        $style_border = array(
            'borders' => array(
                'outline' => array(
                    'style' => \PHPExcel_Style_Border::BORDER_THIN,
                ),
            ),
        );

        $objPHPExcel->setActiveSheetIndex(0);

        //Merge Cells for Logo Display

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->mergeCells('A1:K4');

        else:

            $objPHPExcel->getActiveSheet()->mergeCells('A1:N4');

        endif;

        /* ADD LOGO */

        $objDrawing = new \PHPExcel_Worksheet_Drawing();

        $objDrawing->setName('Logo');

        $objDrawing->setDescription('Logo');

        $objDrawing->setPath($_SERVER["DOCUMENT_ROOT"] . $company_logo);

        $objDrawing->setCoordinates('A1');

        // set resize to false first

        $objDrawing->setResizeProportional(false);

        // set width later

        $objDrawing->setWidth(100);

        $objDrawing->setHeight(80);

        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());

        //$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(50);

        /* END LOGO */



        //Merge Cells for Challenge Name

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->mergeCells('A5:K6');

        else:

            $objPHPExcel->getActiveSheet()->mergeCells('A5:N6');

        endif;

        //Challenge Name Display

        $objPHPExcel->getActiveSheet()->setCellValue('A5', ucwords($title));

//Merge Cells for Week Title

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->mergeCells('A7:K8');

        else:

            $objPHPExcel->getActiveSheet()->mergeCells('A7:N8');

        endif;

//Week Title Display

        $objPHPExcel->getActiveSheet()->setCellValue('A7', $week_title);



//Columns Header

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->setCellValue('A9', "#")
                    ->setCellValue('B9', "First Name")
                    ->setCellValue('C9', "Last Name")
                    ->setCellValue('D9', "Email Id")
                    ->setCellValue('E9', "Daily Inspiration")
                    ->setCellValue('F9', "Shout Out")
                    ->setCellValue('G9', "Today's Lesson")
                    ->setCellValue('H9', "Did You Know")
                    ->setCellValue('I9', "Your Voice Matters")
                    ->setCellValue('J9', "Overall Points")
                    ->setCellValue('K9', "Raffle Tickets");



// Add data

            $i = 10;

            $sno = 1;

            foreach ($user_arr1 as $user):

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno)
                        ->setCellValue('B' . $i, ucwords($user["firstname"]))
                        ->setCellValue('C' . $i, ucwords($user["lastname"]))
                        ->setCellValue('D' . $i, $user["email"])
                        ->setCellValue('E' . $i, $user["daily_actions"])
                        ->setCellValue('F' . $i, $user["shout_out"])
                        ->setCellValue('G' . $i, $user["weekly_video"])
                        ->setCellValue('H' . $i, $user["share_a_wins"])
                        ->setCellValue('I' . $i, $user["leadership_corner"])
                        ->setCellValue('J' . $i, $user["total_points"])
                        ->setCellValue('K' . $i, $user["raffle_ticket"]);

                $i++;

                $sno++;

            endforeach;

        else:

            $objPHPExcel->getActiveSheet()->setCellValue('A9', "#")
                    ->setCellValue('B9', "First Name")
                    ->setCellValue('C9', "Last Name")
                    ->setCellValue('D9', "Email Id")
                    ->setCellValue('E9', "Daily Inspiration")
                    ->setCellValue('F9', "Core Value")
                    ->setCellValue('G9', "Check in with yourself")
                    ->setCellValue('H9', "Shout Out Appreciation")
                    ->setCellValue('I9', "Shout out 5S In Action")
                    ->setCellValue('J9', "Leadership Corner")
                    ->setCellValue('K9', "Weekly Video")
                    ->setCellValue('L9', "Share A Win")
                    ->setCellValue('M9', "Overall Points")
                    ->setCellValue('N9', "Raffle Tickets");



// Add data

            $i = 10;

            $sno = 1;

            foreach ($user_arr1 as $user):

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $sno)
                        ->setCellValue('B' . $i, ucwords($user["firstname"]))
                        ->setCellValue('C' . $i, ucwords($user["lastname"]))
                        ->setCellValue('D' . $i, $user["email"])
                        ->setCellValue('E' . $i, $user["daily_actions"])
                        ->setCellValue('F' . $i, $user["core_values"])
                        ->setCellValue('G' . $i, $user["check_in"])
                        ->setCellValue('H' . $i, $user["shout_outonly"])
                        ->setCellValue('I' . $i, $user["shout_outimages"])
                        ->setCellValue('J' . $i, $user["leadership_corner"])
                        ->setCellValue('K' . $i, $user["weekly_video"])
                        ->setCellValue('L' . $i, $user["share_a_wins"])

                        //->setCellValue('L' . $i, $user["total_steps"])
                        ->setCellValue('M' . $i, $user["total_points"])
                        ->setCellValue('N' . $i, $user["raffle_ticket"]);

                $i++;

                $sno++;

            endforeach;

        endif;



//Wrap Text

        $objPHPExcel->getDefaultStyle()->applyFromArray($style_align)->getAlignment()->setWrapText(true);

//Bold Text & Font Size

        if ($game == 7 || $game == 8 || $game == 11):

            $objPHPExcel->getActiveSheet()->getStyle('A5:K6')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A5:K6')->getFont()->setSize(18);

            $objPHPExcel->getActiveSheet()->getStyle('A7:K8')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:K9')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:K9')->getFont()->setSize(12);

//Border

            $lastcell = $i - 1;

            $objPHPExcel->getActiveSheet()->getStyle('A1:K' . $lastcell)->applyFromArray($style_border);

        else:

            $objPHPExcel->getActiveSheet()->getStyle('A5:N6')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A5:N6')->getFont()->setSize(18);

            $objPHPExcel->getActiveSheet()->getStyle('A7:N8')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:N9')->applyFromArray($style_bold);

            $objPHPExcel->getActiveSheet()->getStyle('A9:N9')->getFont()->setSize(12);

//Border

            $lastcell = $i - 1;

            $objPHPExcel->getActiveSheet()->getStyle('A1:N' . $lastcell)->applyFromArray($style_border);

        endif;

//Setting Width of Columns

        $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(13);

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);

        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

//Setting Height of Rows

        $objPHPExcel->getActiveSheet()->getRowDimension(5)->setRowHeight(20);

        $objPHPExcel->getActiveSheet()->getRowDimension(6)->setRowHeight(20);

        $objPHPExcel->getActiveSheet()->getRowDimension(7)->setRowHeight(15);

        $objPHPExcel->getActiveSheet()->getRowDimension(8)->setRowHeight(15);

        $objPHPExcel->getActiveSheet()->getRowDimension(9)->setRowHeight(40);

        for ($j = 10; $j <= $lastcell; $j++):

            $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(30);

        endfor;



// Rename worksheet



        $objPHPExcel->getActiveSheet()->setTitle('Weekly Team Report');



// Set active sheet index to the first sheet, so Excel opens this as the first sheet

        $objPHPExcel->setActiveSheetIndex(0);



//Report Name

        $file_name = $id . '.xls';

        //echo Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id . '/' . $id . '/' . $weekfolder . '/' . $file_name;die;



        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        if (!file_exists(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id . '/' . $weekfolder . '/' . $file_name)):

            $objWriter->save(Yii::getAlias('@webroot') . '/weekly-reports/' . $game_obj->id . '/' . $weekfolder . '/' . $file_name);

            return true;

        endif;

        return false;
    }

    public function actionPointsCron() {

        $games = PilotCreateGame::find()->where(['status' => 1])->all();

        if (!empty($games)):

            foreach ($games as $game_obj):

                if ($game_obj->challenge_id != 7 && $game_obj->challenge_id != 8 && $game_obj->challenge_id != 11):

                    $comp_id = $game_obj->challenge_company_id;

                    $game = $game_obj->challenge_id;

                    $challenge_obj = PilotGameChallengeName::find()->where(['id' => $game_obj->challenge_id])->one();

                    $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

                    $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';

                    $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';

                    $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';

                    $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';

                    $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';

                    $share_a_win_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';

                    $total_points_table = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';

                    $users = PilotFrontUser::find()->where(['challenge_id' => $game, 'company_id' => $comp_id])->all();

                    foreach ($users as $user):

                        $total_points = 0;

                        $total_actions = 0;

                        $daily_points = 0;

                        $check_in_points = 0;

                        $high_five_points = 0;

                        $corner_tips_points = 0;

                        $weekly_points = 0;

                        $share_a_win_points = 0;

                        $daily_actions = 0;

                        $check_in_actions = 0;

                        $high_five_actions = 0;

                        $corner_tips_actions = 0;

                        $weekly_actions = 0;

                        $share_a_win_actions = 0;

                        $raffle_entry = 0;

                        $user_id = $user->id;

                        $team_id = $user->team_id;

                        //Points of Daily Inspiration Section

                        $daily_points = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->sum('points');



                        //Points of Check In Section

                        $check_in_points = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->sum('points');



                        //Points of High Five Section

                        $high_five_points = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->sum('points');



                        //Points of Corner Tips Section

                        $corner_tips_points = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->sum('points');



                        //Points of Weekly Challenge Section

                        $weekly_points = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->sum('points');



                        //Points of Share A Win Section

                        $share_a_win_points = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->sum('points');

                        $daily_actions = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->all();



                        //Actions of Check In Section

                        $check_in_actions = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->all();



                        //Actions of High Five Section

                        $high_five_actions = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->all();



                        //Actions of Corner Tips Section

                        $corner_tips_actions = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->all();



                        //Actions of Weekly Challenge Section

                        $weekly_actions = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->all();



                        //Actions of Share A Win Section

                        $share_a_win_actions = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                ->all();

                        $total_core_values = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                                        ->andWhere(['!=', 'label', 'core_values_popup'])
                                        ->orderBy(['created' => SORT_DESC])->all();

                        $check_entry = $total_points_table::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])->one();

                        $total_points = $daily_points + $check_in_points + $high_five_points + $corner_tips_points + $weekly_points + $share_a_win_points;

                        $total_actions = count($daily_actions) + count($check_in_actions) + count($high_five_actions) + count($corner_tips_actions) + count($weekly_actions) + count($share_a_win_actions);

                        $raffle_entry = floor($total_points / 100);

                        if (empty($check_entry)):

                            $model = new $total_points_table;

                            $model->game_id = $game;

                            $model->challenge_id = $game_obj->id;

                            $model->user_id = $user_id;

                            $model->company_id = $comp_id;

                            $model->team_id = $team_id;

                            $model->total_points = $total_points;

                            $model->total_core_values = count($total_core_values);

                            $model->total_raffle_entry = $raffle_entry;

                            $model->total_game_actions = $total_actions;

                            $model->created = time();

                            $model->updated = time();

                            $model->save(false);

                        else:

                            if ($check_entry->total_points != $total_points):

                                $check_entry->total_points = $total_points;

                                $check_entry->total_core_values = count($total_core_values);

                                $check_entry->total_raffle_entry = $raffle_entry;

                                $check_entry->total_game_actions = $total_actions;

                                $check_entry->updated = time();

                                $check_entry->save(false);

                            endif;

                        endif;

                    endforeach;

                endif;

            endforeach;

            echo 'points updated';

        else:

            echo 'no game activated';

        endif;
    }

}
