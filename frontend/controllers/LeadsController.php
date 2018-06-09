<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Request;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;
use yii\imagine\Image;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use frontend\models\PilotFrontLeadsDailyinspiration;
use frontend\models\PilotFrontLeadsLeadershipcorner;
use frontend\models\PilotFrontLeadsWeeklychallenge;
use frontend\models\PilotFrontLeadsShareawin;
use frontend\models\PilotFrontLeadsHighfive;
use frontend\models\PilotFrontLeadsHighfiveType;
use frontend\models\PilotFrontLeadsHighfiveSearch;
use frontend\models\PilotFrontLeadsCheckin;
use frontend\models\PilotFrontUser;
use frontend\models\PilotFrontLeadsNotifications;
use frontend\models\PilotFrontLeadsTotalPoints;
use frontend\models\PilotFrontLeadsSurveyData;
use frontend\models\PilotFrontLeadsStepsApiData;
use frontend\models\PilotFrontLeadsStepsApiDataSearch;
use frontend\models\PilotFrontLeadsStepsModal;
use frontend\models\PilotFrontLeadsTechSupport;
use frontend\models\PilotFrontLeadsRating;
use backend\models\Company;
use backend\models\PilotCreateGame;
use backend\models\PilotDailyinspirationImage;
use backend\models\PilotWeeklyChallenge;
use backend\models\PilotLeadershipCorner;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\PilotSurveyQuestion;
use yii\filters\auth\HttpBasicAuth;
use frontend\models\PilotFrontLeadsEmail;
use kartik\rating\StarRating;

/**
 * LeadsController implements the CRUD actions for Leads model.
 */
class LeadsController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index', 'view', 'create', 'update', 'delete', 'dashboard', 'daily-modal', 'leadership-modal', 'weekly-modal', 'share-a-win-mmodal', 'highfive-like', 'core-values-modal', 'check-in', 'tag-list', 'checkin', 'share-a-win', 'high-five', 'highfive-usercomment-modal', 'get-notifications', 'notification-status', 'highfive-image-upload', 'highfive-image-zoom-modal', 'get-user-points', 'get-company-users-points', 'leaderboard-points-modal', 'calendar', 'get-cal-record', 'welcome', 'toolbox', 'skip-survey', 'leaderboard', 'fitness-steps', 'api-login-token', 'post-api-data', 'total-steps-modal', 'read-congrats', 'tech-support', 'set-notifications-status', 'see-all', 'thankyou', 'daily-email', 'save-rating', 'high-fiveimages', 'tag-list1', 'how-it-work', 'load-highfive-images', 'save-highfive-image-comment', 'loadmore-highfive-images','weekly','more-hf-comments', 'share-data', 'core-data', 'save-highfive-comment','clear-session'],
                'rules' => [
                    [
                        'actions' => ['signup', 'index', 'api-login-token', 'post-api-data'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'dashboard', 'daily-modal', 'leadership-modal', 'weekly-modal', 'share-a-win-mmodal', 'highfive-like', 'core-values-modal', 'check-in', 'tag-list', 'logout', 'checkin', 'share-a-win', 'high-five', 'highfive-usercomment-modal', 'get-notifications', 'notification-status', 'highfive-image-upload', 'highfive-image-zoom-modal', 'get-user-points', 'get-company-users-points', 'leaderboard-points-modal', 'calendar', 'get-cal-record', 'welcome', 'toolbox', 'skip-survey', 'leaderboard', 'fitness-steps', 'api-login-token', 'post-api-data', 'total-steps-modal', 'read-congrats', 'tech-support', 'set-notifications-status', 'see-all', 'thankyou', 'daily-email', 'save-rating', 'high-fiveimages', 'tag-list1', 'how-it-work', 'load-highfive-images', 'save-highfive-image-comment', 'loadmore-highfive-images','weekly','more-hf-comments', 'share-data', 'core-data', 'save-highfive-comment','clear-session'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     *    * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'leads';
        return $this->render('index');
    }

    //display dashboard page

    public function actionDashboard() {
        $challenge_id = Yii::$app->user->identity->challenge_id;
        $check_challenge = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => Yii::$app->user->identity->company_id, 'status' => [0, 1]])->one();
        // echo '<pre>';print_r($challenge_id);die;
        if (empty($check_challenge)):
            $current_challenge = PilotCreateGame::find()->where(['challenge_company_id' => Yii::$app->user->identity->company_id, 'status' => [0, 1]])->one();
            if ($challenge_id != $current_challenge->challenge_id):
                $model_update = PilotFrontUser::findOne(Yii::$app->user->identity->id);
                if ($model_update):
                    $model_update->challenge_id = $current_challenge->challenge_id;
                    $model_update->save(false);
                endif;
            endif;
        endif;
        $challenge_id = Yii::$app->user->identity->challenge_id;
        if (isset($challenge_id)) {
            if ($challenge_id != '6' && $challenge_id != 0) {
                $comp = $_SESSION['company_name'];
                return $this->redirect(Url::to(['/']));
            }
        }
        //check user are registred with same company
        $loggedin_user_compId = Yii::$app->user->identity->company_id;
        $company_obj = Company::find()->where(['id' => $loggedin_user_compId])->one();
        $check_comp = str_replace(' ', '-', strtolower($company_obj->company_name));

        //get compamy name from url
        $curentUrl = Yii::$app->request->hostInfo;
        $url = parse_url($curentUrl, PHP_URL_HOST);
        $explodedUrl = explode('.', $url);
        $comp_check = $explodedUrl[0];
        $all_highfivecomment = [];
        $all_highfiveImage = [];
        if ($check_comp != $comp_check):
//            $session->set('company_logo', $company_obj->image);
//            $session->set('company_name', $check_comp);
//            $session->set('comp_name', $company_obj->company_name);
//            $session->set('company_id', $company_obj->id);
        //return $this->redirect('http://' . $check_comp . '.injoymore.com/leads/dashboard');
        endif;

        $this->layout = 'leads';
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //User Team ID
        $team_id = Yii::$app->user->identity->team_id;
        $timezone = Yii::$app->user->identity->timezone;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        if (empty($game_obj)): //If there is No Ongoing Challenge but upcoming
            //Fetch the Most Recent Upcoming Challenge
            $upcoming_challenge = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 0])
                    ->orderBy(['challenge_start_date' => SORT_ASC])
                    ->one();
            if (!empty($upcoming_challenge)):
                $challenge_teams = explode(',', $upcoming_challenge->challenge_teams);
                if (in_array($team_id, $challenge_teams)):
                    //Upcoming Challenge Redirection for User
                    $upcoming_challenge_id = $upcoming_challenge->challenge_id;
                    return $this->redirect(Url::to(['/leads/welcome']));
                else:
                    return $this->redirect(Url::to(['/leads/thankyou']));
                    return $this->goBack();
                endif;
            else:
                return $this->redirect(Url::to(['/leads/thankyou']));
                return $this->goBack();
            endif;
        else: //If there is Ongoing Challenge
            $week_no = PilotFrontUser::getGameWeek($game_obj);
            $feature_array = explode(',', $game_obj->features);
            $game_id = $game_obj->id;
            $game_start_date_timestamp = $game_obj->challenge_start_date;
            $game_end_date_timestamp = $game_obj->challenge_end_date;
            //date_default_timezone_set($timezone);
            //date_default_timezone_set('America/Los_Angeles');
            $dayset = date('Y-m-d');
            //Daily Inspiration
            $daily_entry = PilotFrontLeadsDailyinspiration::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            //Core Values
            $valuesLabel_obj = PilotCompanyCorevaluesname::find()->where(['company_id' => $game_obj->core_value_content])->orderBy(['id' => SORT_ASC])->all();
            $valuesLabel = ArrayHelper::map($valuesLabel_obj, 'core_values_name', 'core_values_name');

            $corevalues_entry = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => 'core_values_popup', 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            $prev_today_values_currentday = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])
                            ->andWhere(['!=', 'label', 'core_values_popup'])->orderBy(['created' => SORT_DESC])->all();
            $tv_points = 20;
            $count_tv = 0;
            if (!empty($prev_today_values_currentday)):
                $count_tv = count($prev_today_values_currentday);
                if ($count_tv < 2):
                    $tv_points = 20;
                else:
                    $tv_points = 0;
                endif;
            endif;

            //Game Points 5 Days Per Week - Check In Section
            $sum_week_points = 0;
            $week_entries_points = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])
                    ->andWhere(['!=', 'label', 'core_values_popup'])
                    ->sum(points);
            if (!empty($week_entries_points)):
                $sum_week_points = $week_entries_points;
            endif;
            if ($sum_week_points >= 200):
                $tv_points = 0;
            endif;

            //Makeup Days entry for check in section
            $total_weeks_entries_points = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->andWhere(['!=', 'label', 'core_values_popup'])
                    ->sum(points);
            if (!empty($total_weeks_entries_points) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $totalweek = $total_gameday / 7;
                $exactWeek = explode('.', $totalweek);
                $total_game_points = $exactWeek[0] * 5 * 40;
                if ($total_weeks_entries_points >= $total_game_points):
                    $tv_points = 0;
                endif;
            endif;
            //end here

            $today_valuesModel = new PilotFrontLeadsCheckin;
            if (Yii::$app->request->post()):
                $label = $_POST['label'];
                $comment = $_POST['comment'];
                $serial = $_POST['serial'];
                $checkModel = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => $label, 'serial' => $serial, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
                if (empty($checkModel)):
                    $model = new PilotFrontLeadsCheckin;
                    $model->game_id = $game;
                    $model->challenge_id = $game_id;
                    $model->user_id = $user_id;
                    $model->company_id = $comp_id;
                    $model->label = $label;
                    $model->comment = json_encode($comment);
                    $model->serial = $serial;
                    $model->points = $tv_points;
                    $model->week_no = $week_no;
                    $model->dayset = $dayset;
                    $model->created = time();
                    $model->updated = time();
                    if ($model->save(false)):
                        return 'Saved Successfully';
                    endif;
                endif;
            endif;
            // fetching High Five comments using foreach . 
            $all_highfives = array();

            $label = array('highfivelike', 'highfiveUserComment', 'highfiveComment');
            if (in_array(11, $feature_array)):
                $subQuery = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
                $query = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $subQuery])->andWhere(['challenge_id' => $game_id])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit(10);
                $all_highfivecomment = $query->all();
                $sub_Query = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
                $Query = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $sub_Query])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id])->andWhere(['dayset' => $dayset])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
                $prev_highfives_currentday = $Query->all();
                $hf_points = 10;
                $count_hf = 0;
                if (!empty($prev_highfives_currentday)):
                    $count_hf = count($prev_highfives_currentday);
                    if ($count_hf < 3):
                        $hf_points = 10;
                    else:
                        $hf_points = 0;
                    endif;
                endif;
                //Game Points 5 Days Per Week - Shout Out Section
                $sum_week_points = 0;
                $sub_Query1 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'week_no' => $week_no, 'challenge_id' => $game_id])->select('linked_feature_id');
                $Query1 = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $sub_Query1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
                $week_entries_points = $Query1->sum('points');
                if (!empty($week_entries_points)):
                    $sum_week_points = $week_entries_points;
                endif;
                if ($sum_week_points >= 150):
                    $hf_points = 0;
                endif;

                //Makeup Days entry  
                $subQuery5 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
                $query5 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery5])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id]);
                $total_points_highfive = $query5->sum('points');
                if (!empty($total_points_highfive) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                    $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                    //echo $total_gameday;
                    $totalweek = $total_gameday / 7;
                    $exactWeek = explode('.', $totalweek);
                    $total_game_points = $exactWeek[0] * 5 * 30;
                    if ($total_points_highfive >= $total_game_points):
                        $hf_points = 0;
                    endif;
                endif;
                //end here
                //Game points for 5s in action
                $subQuery2 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
                $query2 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery2])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['week_no' => $week_no])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
                $all_highfiveImage1 = $query2->all();
                if (empty($all_highfiveImage1)):
                    $pointsimage = 30;
                else:
                    $pointsimage = 0;
                endif;
                //Makeup day entry for 5s in action
                //Makeup Days entry            
                $subQuery4 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
                $query4 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery4])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id]);
                $total_points_highfiveimage = $query4->sum('points');
                if (!empty($total_points_highfiveimage) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                    $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                    $totalweek = $total_gameday / 7;
                    $exactWeek = explode('.', $totalweek);
                    $total_game_points = $exactWeek[0] * 30;
                    if ($total_points_highfiveimage >= $total_game_points):
                        $pointsimage = 0;
                    endif;
                endif;
            else:
                //High Five 
                $all_highfives = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'challenge_id' => $game_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit(40)->all();
                $prev_highfives_currentday = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset, 'challenge_id' => $game_id])->orderBy(['created' => SORT_ASC])->all();
                $hf_points = 10;
                $count_hf = 0;
                if (!empty($prev_highfives_currentday)):
                    $count_hf = count($prev_highfives_currentday);
                    if ($count_hf < 3):
                        $hf_points = 10;
                    else:
                        $hf_points = 0;
                    endif;
                endif;
                //Game Points 5 Days Per Week - Shout Out Section
                $sum_week_points = 0;
                $week_entries_points = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])
                        ->sum('points');
                if (!empty($week_entries_points)):
                    $sum_week_points = $week_entries_points;
                endif;
                if ($sum_week_points >= 150):
                    $hf_points = 0;
                endif;

                //Makeup Days entry           
                $total_points_highfive = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                        ->sum('points');
                if (!empty($total_points_highfive) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                    $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                    //echo $total_gameday;
                    $totalweek = $total_gameday / 7;
                    $exactWeek = explode('.', $totalweek);
                    $total_game_points = $exactWeek[0] * 5 * 30;
                    if ($total_points_highfive >= $total_game_points):
                        $hf_points = 0;
                    endif;
                endif;
            endif;
            //end here
            // $session = Yii::$app->session;
            $highfiveModel = new PilotFrontLeadsHighfive;
            if (Yii::$app->request->post('PilotFrontLeadsHighfive')):
                $feature_label = Yii::$app->request->post('PilotFrontLeadsHighfive')['feature_label'];
                $feature_value = Yii::$app->request->post('PilotFrontLeadsHighfive')['feature_value'];
                $feature_serial = Yii::$app->request->post('PilotFrontLeadsHighfive')['feature_serial'];
                $linked_feature_id = Yii::$app->request->post('PilotFrontLeadsHighfive')['linked_feature_id'];
                $checkModel = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'feature_serial' => $feature_serial, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
                if (empty($checkModel)):
                    $model = new PilotFrontLeadsHighfive;
                    $model->game_id = $game;
                    $model->challenge_id = $game_id;
                    $model->user_id = $user_id;
                    $model->company_id = $comp_id;
                    $model->team_id = $team_id;
                    $model->feature_label = $feature_label;
                    $model->feature_value = json_encode($feature_value);
                    $model->feature_serial = $feature_serial;
                    $model->linked_feature_id = $linked_feature_id;
//                    if (Yii::$app->request->post('hf_image_status')):
//                        $type = PilotFrontLeadsHighfiveType::find()->where(['id' => 2])->one();
//                        $type->type = 1;
//                        $type->created = time();
//                        $type->save(false);
//                        $model->points = $pointsimage;
//                    else:
//                        $type = PilotFrontLeadsHighfiveType::find()->where(['id' => 2])->one();
//                        $type->type = 0;
//                        $type->created = time();
                    //   $type->save(false);
                    $model->points = $hf_points;
                    // endif;
                    $model->week_no = $week_no;
                    $model->dayset = $dayset;
                    $model->created = time();
                    $model->updated = time();
                    $model->save(false);
                    $savedmodel_id = $model->id;
                    //Save Image Uploaded with Comment
                    if (Yii::$app->request->post('hf_image_status')):
                        if (isset($_SESSION['hf_cmnt_img'])):
                            $image_model = new PilotFrontLeadsHighfive;
                            $image_model->game_id = $game;
                            $image_model->challenge_id = $game_id;
                            $image_model->user_id = $user_id;
                            $image_model->company_id = $comp_id;
                            $image_model->team_id = $team_id;
                            $image_model->feature_label = 'highfiveCommentImage';
                            $image_model->feature_value = $_SESSION['hf_cmnt_img'];
                            $image_model->feature_serial = '1';
                            $image_model->linked_feature_id = $savedmodel_id;
                            $image_model->points = 0;
                            $image_model->week_no = $week_no;
                            $image_model->dayset = $dayset;
                            $image_model->created = time();
                            $image_model->updated = time();
                            $image_model->save(false);
                        //$session->set('image_uploaded', '1');
                        endif;
                    endif;
                    //Save Notification for User in pilot_front_notifications Table
                    $cmnt = $feature_value;
                    preg_match_all("/data-uid=\"(.*?)\"/i", $cmnt, $matches);

                    if (!empty($matches)):
                        foreach ($matches[1] as $key => $tagged_uid):
                            $cmnt_val = json_encode($feature_value);
//              echo $cmnt_val;echo '<br>';
                            $comment_val = json_decode($cmnt_val);
                            $max_length = 25;
//              echo $comment_val;echo '<br>';
//              if (strlen($comment_val) > $max_length):
//                $offset = ($max_length - 3) - strlen($comment_val);
//                $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
//              endif;
//              echo $comment_val;echo '<br>';
                            // $comment_val = str_replace("<br>", " ", $comment_val);
//              echo $comment_val;echo '<br>';
//              die;
                            $tagged_user = PilotFrontUser::findIdentity($tagged_uid);

                            $hf_comment_user = PilotFrontUser::findIdentity($user_id);
                            $hf_comment_userName = $hf_comment_user->username;

                            $notif_value = json_encode('<b>' . $hf_comment_userName . '</b> has tagged you in a comment <a href="javascript:void(0)">' . $comment_val . '</a>');
                            //Save Other Users Activity not Own
                            if ($tagged_uid != $user_id):
                                $notif_model = new PilotFrontLeadsNotifications;
                                $notif_model->game_id = $game;
                                $notif_model->challenge_id = $game_id;
                                $notif_model->user_id = $tagged_uid;
                                $notif_model->company_id = $comp_id;
                                $notif_model->notif_type_id = $savedmodel_id;
                                $notif_model->notif_type = 'highfiveComment';
                                $notif_model->notif_value = $notif_value;
                                $notif_model->activity_user_id = $user_id;
                                $notif_model->notif_status = 1;
                                $notif_model->dayset = $dayset;
                                $notif_model->created = time();
                                $notif_model->updated = time();
                                $notif_model->save(false);
                            endif;
                        endforeach;
                    endif;
                endif;
                Yii::$app->session->setFlash('success', 'Saved Successfully.');
                return $this->redirect(['dashboard']);
                Yii::$app->end();
            endif;
            //Leadership Corner
            $leadership_entry_weekly = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->all();
            $leadership_entry_currentday = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            $leadership_entry_first = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'first', 'challenge_id' => $game_id])->one();
            $leadership_entry_sec = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'second', 'challenge_id' => $game_id])->one();
            $leadership_entry_third = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'third', 'challenge_id' => $game_id])->one();

            //Weekly Challenge
            $weekly_entry = PilotFrontLeadsWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->one();
            //Fetch the Video & Title for Current Week - Weekly Challenge
            $game_current_week_no = $week_no;
            $weekly_category_id = $game_obj->weekly_challenge_content;
            $weekly_challenge_obj = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_category_id, 'week' => $game_current_week_no])->one();
            if (empty($weekly_challenge_obj)):
                $weeks = PilotFrontUser::numofweeks($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $weekly_challenge_count = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_category_id])->count();
                $game_current_week_no = PilotFrontUser::getvideoweek($week_no, $weekly_challenge_count);
                $weekly_challenge_obj = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_category_id, 'week' => $game_current_week_no])->one();
            endif;
            $weekly_video_link = $weekly_challenge_obj->video_link;
            $weekly_title = $weekly_challenge_obj->video_title;
            $weekly_image = $weekly_challenge_obj->image;
            if (empty($weekly_image)):
                $weekly_video_image = PilotFrontUser::getYoutubeImage($weekly_video_link);
            else:
                $weekly_video_image = Yii::getAlias('@back_end') . '/img/weekly-challenge-images/' . $weekly_image;
            endif;
            //Share A Win 
            $shareawin_entry = PilotFrontLeadsShareawin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])->all();
            //$shareawins_all = PilotFrontLeadsShareawin::find()->where(['game_id' => $game, 'company_id' => $comp_id])->joinWith('userinfo')->orderBy(['created' => SORT_DESC])->all();

            $shareawins_all = PilotFrontLeadsShareawin::find()
                            ->where(['game_id' => $game, 'pilot_front_leads_shareawin.company_id' => $comp_id, 'pilot_front_leads_shareawin.challenge_id' => $game_id])
                            ->joinWith('userinfo')
                            ->orderBy(['id' => SORT_DESC])->limit(5)->all();

            //Enable - Disable the features of Dashboard as per the values in Session $_SESSION['core_Template']['features']
            $email_reminder = '';
            $sms_reminder = '';
            $comment_option = '';
            $email_notifs = '';
            $sms_notifs = '';
            $image_upload_shout = '';
            if (isset($_SESSION['core_Template']['features'])):
                $session_features = $_SESSION['core_Template']['features'];
                $comment_option = $this->search_features_array($session_features, 'Comment Option on Shout');
                $image_upload_shout = $this->search_features_array($session_features, 'Shout Image Upload');
            else: //Re-Enable Session if its Expired!!
                $session = Yii::$app->session;
                $challenge_features = explode(',', $game_obj->features);
                //Define Active Challenge Template - Features
                foreach ($challenge_features as $key => $val):
                    $feature = \backend\models\PilotCreateGameFeatures::find()->where(['id' => $val])->one();
                    $fea[] = [
                        'feature_id' => $feature->id,
                        'feature_name' => $feature->name
                    ];
                endforeach;
                $session['core_Template'] = [
                    'features' => $fea
                ];
                $session_features = $_SESSION['core_Template']['features'];
                $comment_option = $this->search_features_array($session_features, 'Comment Option on Shout');
                $image_upload_shout = $this->search_features_array($session_features, 'Shout Image Upload');
            endif;

            //All Users Points - Company & Team Wise
            if (!empty($team_id)):
                $users_points_obj = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $team_id, 'challenge_id' => $game_id])
                                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                                ->orderBy(['total_points' => SORT_DESC])->all();
            else:
                $users_points_obj = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                                ->orderBy(['total_points' => SORT_DESC])->all();
            endif;

            $count_top_list_users = 0;
            foreach ($users_points_obj as $user_points_obj):
                $user_points = $user_points_obj->total_points;
                if ($user_points > 0):
                    $count_top_list_users++;
                endif;
            endforeach;

            //SURVEY SECTION
            $survey_questions_arr = [];
            $show_survey = 'false';
            //Check if Survey is enabled for the Challenge
            $check_survey_active = $game_obj->survey;
            if ($check_survey_active == 1):
                //Get the Survey Live Date
                $survey_live_date = date('Y-m-d', $game_obj->challenge_survey_date);
                if (date('Y-m-d') >= $survey_live_date):
                    //Check whelther User has already filled the Feedback Survey or not
                    $feedback_given = PilotFrontLeadsSurveyData::find()->where(['challenge_id' => $game_obj->id, 'user_id' => $user_id, 'survey_filled' => 'Yes'])->all();
                    if (empty($feedback_given)):
                        //Check whelther User has skipped the Feedback Survey Form for Current Day
                        $feedback_skipped = PilotFrontLeadsSurveyData::find()->where(['challenge_id' => $game_obj->id, 'user_id' => $user_id, 'survey_filled' => 'No', 'dayset' => $dayset])->one();
                        if (empty($feedback_skipped)):
                            $show_survey = 'true';
                            if ($show_survey == 'true'):
                                //Get the Survey Question Ids for the Challenge
                                $survey_questions_ids = explode(',', $game_obj->survey_questions);
                                //Get the Survey Question & Option Type
                                foreach ($survey_questions_ids as $key => $val):
                                    $sur_ques = PilotSurveyQuestion::find()->where(['id' => $val])->one();
                                    $survey_questions_arr[] = [
                                        'id' => $val,
                                        'text' => $sur_ques->question,
                                        'type' => $sur_ques->type,
                                    ];
                                endforeach;
                            endif;
                        endif;
                    endif;
                endif;
            endif;

            //Save the Feedback Survey Data
            if (Yii::$app->request->post('PilotFrontLeadsSurveyData')):
                $skipped_entry = PilotFrontLeadsSurveyData::find()->where(['challenge_id' => $game_obj->id, 'user_id' => $user_id, 'survey_filled' => 'No'])->one();
                if (!empty($skipped_entry)):
                    $skipped_entry->delete();
                endif;
                $surveyPostedData = Yii::$app->request->post('PilotFrontLeadsSurveyData');
                $survey_posted_questions = $surveyPostedData['survey_question_id'];
                $survey_posted_responses = $surveyPostedData['survey_response'];
                $survey_permission = $surveyPostedData['permission_use_data'];
                foreach ($survey_posted_questions as $key => $q_id):
                    $surveyModel = new PilotFrontLeadsSurveyData();
                    $surveyModel->challenge_id = $game_obj->id;
                    $surveyModel->user_id = $user_id;
                    $surveyModel->survey_filled = 'Yes';
                    $surveyModel->survey_question_id = $q_id;
                    if (!empty($survey_posted_responses[$key])):
                        $surveyModel->survey_response = json_encode($survey_posted_responses[$key]);
                    else:
                        $surveyModel->survey_response = json_encode($_POST['option' . $key]);
                    endif;
                    $surveyModel->permission_use_data = $survey_permission;
                    $surveyModel->week_no = $week_no;
                    $surveyModel->dayset = $dayset;
                    $surveyModel->created = time();
                    $surveyModel->updated = time();
                    $surveyModel->save(false);
                endforeach;
                Yii::$app->session->setFlash('success', 'Feedback Survey Data Saved Successfully.');
                return $this->redirect(['dashboard']);
                Yii::$app->end();
            endif;

            //Fitness Activity Data Fetch
            $convrtd_date = date('d/m/Y', strtotime($dayset));
            $fitness_data = PilotFrontLeadsStepsApiData::find()->where(['user_id' => $user_id, 'date' => $convrtd_date])->one();

            //Congratulation Modal Show on 10K Steps reach per day..
            $show_10k_congrats = 'false';
            $steps_obj = PilotFrontLeadsStepsApiData::find()->where(['user_id' => $user_id, 'date' => $convrtd_date])->one();
            if (!empty($steps_obj)):
                $total_stepsofday = $steps_obj->steps;
                if ($total_stepsofday >= 10000):
                    $check_already_readforday = PilotFrontLeadsStepsModal::find()->where(['user_id' => $user_id, 'dayset' => $dayset, 'modal_read' => 'Yes'])->one();
                    if (empty($check_already_readforday)):
                        $show_10k_congrats = 'true';
                    endif;
                endif;
            endif;
            $ratingmodel = new PilotFrontLeadsRating;
            return $this->render('dashboard', [
                        'daily_entry' => $daily_entry,
                        'valuesLabel' => $valuesLabel,
                        'corevalues_entry' => $corevalues_entry,
                        'today_valuesModel' => $today_valuesModel,
                        'prev_today_values_currentday' => $prev_today_values_currentday,
                        'count_tv' => $count_tv,
                        'all_highfives' => $all_highfives,
                        // 'all_highfiveImage' => $all_highfiveImage,
                        'all_highfivecomment' => $all_highfivecomment,
                        'highfiveModel' => $highfiveModel,
                        'prev_highfives_currentday' => $prev_highfives_currentday,
                        'count_hf' => $count_hf,
                        'leadership_entry_weekly' => $leadership_entry_weekly,
                        'leadership_entry_currentday' => $leadership_entry_currentday,
                        'leadership_entry_first' => $leadership_entry_first,
                        'leadership_entry_sec' => $leadership_entry_sec,
                        'leadership_entry_third' => $leadership_entry_third,
                        'weekly_entry' => $weekly_entry,
                        'weekly_video_image' => $weekly_video_image,
                        'weekly_title' => $weekly_title,
                        'shareawin_entry' => $shareawin_entry,
                        'shareawins_all' => $shareawins_all,
                        'comment_option' => $comment_option,
                        'image_upload_shout' => $image_upload_shout,
                        'count_top_list_users' => $count_top_list_users,
                        'show_survey' => $show_survey,
                        'survey_questions_arr' => $survey_questions_arr,
                        'fitness_data' => $fitness_data,
                        'show_10k_congrats' => $show_10k_congrats,
                        'ratingmodel' => $ratingmodel,
                            //'lastupdated' => $lastupdated,
//                        'total_points_data' => $total_points_data,
//                        'team_core_values_count' => $team_core_values_count,
//                        'total_actions_count' => $total_actions_count,
                            // 'html_table' => $html_table
            ]);
        endif;
    }

    public function actionDailyInspiration() {
        $this->layout = 'leads';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        //Fetch the Image for Current Day - Daily Inspiration Challenge
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_current_day_no = PilotFrontUser::getGameDay($game_obj);
        $daily_category_id = $game_obj->daily_inspiration_content;
        $daily_inspiration_obj = PilotDailyinspirationImage::find()->where(['category_id' => $daily_category_id])
                ->andWhere(['<=', 'order_number', $game_current_day_no])
                ->orderBy(['order_number' => SORT_DESC])
                ->all();
        return $this->render('daily', [
                    'daily_inspiration_obj' => $daily_inspiration_obj,
        ]);
    }

    public function actionCheckin() {
        $this->layout = 'leads';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $shareawins_all = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                        ->andWhere(['!=', 'label', 'core_values_popup'])->orderBy(['dayset' => SORT_DESC, 'id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $shareawins_all,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        return $this->render('checkin', [
                    'shareawins_all' => $dataProvider,
        ]);
    }

    public function actionHighFive() {
        $this->layout = 'leads';
        $comp_id = Yii::$app->user->identity->company_id;
        $query = PilotFrontUser::find()->where(['company_id' => $comp_id])->all();
        $userData = ArrayHelper::map($query, 'id', 'username');
        $searchModel = new PilotFrontLeadsHighfiveSearch();
        $game = PilotFrontUser::getGameID('leads');
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        //echo '<pre>';print_r(Yii::$app->request->queryParams);die;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (!empty($_GET)) {
            $html = $this->renderAjax('highfiveusersearch', [
                'model' => $searchModel,
                'shareawins_all' => $dataProvider,
                'userData' => $userData,
            ]);
            return $html;
        }
        return $this->render('highfive', [
                    'model' => $searchModel,
                    'shareawins_all' => $dataProvider,
                    'userData' => $userData,
                    'game_obj' => $game_obj
        ]);
    }

    public function actionToolbox() {
        $this->layout = 'leads';
        $game = PilotFrontUser::getGameID('leads');
        $user_id = Yii::$app->user->identity->id;
        $comp_id = Yii::$app->user->identity->company_id;
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);

        //Current Week Tips Variables
        $week_leadership = 'Week ' . $week_no;
        $tip_no1 = $week_leadership . '-one';
        $tip_no2 = $week_leadership . '-two';
        $tip_no3 = $week_leadership . '-three';
        $week_pattern = $week_leadership . '%';

        $leadership_tips_id = $game_obj->leadership_corner_content;

        $leadership_tips = PilotLeadershipCorner::find()->where(['category_id' => $leadership_tips_id])
                ->andFilterWhere(['not like', 'week', $week_leadership])
                ->orderBy(['created' => SORT_DESC])
                ->all();

        //Leadership Corner
        $leadership_entry_weekly = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->all();
        $leadership_entry_currentday = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
        $leadership_entry_first = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'first', 'challenge_id' => $game_id])->one();
        $leadership_entry_sec = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'second', 'challenge_id' => $game_id])->one();
        $leadership_entry_third = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'third', 'challenge_id' => $game_id])->one();



        if (empty($leadership_entry_weekly)):
            $current_week_leadership_tips = PilotLeadershipCorner::find()->where(['category_id' => $leadership_tips_id])
                    ->andWhere(['=', 'week', $tip_no1])
                    ->orderBy(['created' => SORT_DESC])
                    ->all();
        endif;

        if (!empty($leadership_entry_first)):

            if (empty($leadership_entry_currentday)):
                $current_week_leadership_tips = PilotLeadershipCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['week' => [$tip_no1, $tip_no2]])
                        ->andWhere(['!=', 'week', $tip_no3])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();

            else:
                $current_week_leadership_tips = PilotLeadershipCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['=', 'week', $tip_no1])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            endif;
        endif;


        if (!empty($leadership_entry_sec)):
            if (empty($leadership_entry_currentday)):
                $current_week_leadership_tips = PilotLeadershipCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['week' => [$tip_no1, $tip_no2, $tip_no3]])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            else:
                $current_week_leadership_tips = PilotLeadershipCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['week' => [$tip_no1, $tip_no2]])
                        ->andWhere(['!=', 'week', $tip_no3])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            endif;
        endif;
        //All Three Tips
        if (!empty($leadership_entry_third)):
            $current_week_leadership_tips = PilotLeadershipCorner::find()->where(['category_id' => $leadership_tips_id])
                    ->andWhere(['week' => [$tip_no1, $tip_no2, $tip_no3]])
                    ->orderBy(['created' => SORT_DESC])
                    ->all();
        endif;

        return $this->render('toolbox', [
                    'leadership_tips' => $leadership_tips,
                    'current_week_leadership_tips' => $current_week_leadership_tips,
                    'week_no' => $week_no,
                    'game_obj' => $game_objs
        ]);
    }

    public function actionShareAWin() {
        $this->layout = 'leads';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $shareawins_all = PilotFrontLeadsShareawin::find()
                ->where(['game_id' => $game, 'pilot_front_leads_shareawin.company_id' => $comp_id, 'pilot_front_leads_shareawin.challenge_id' => $game_id])
                ->joinWith('userinfo')
                ->orderBy(['dayset' => SORT_DESC, 'id' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $shareawins_all,
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        return $this->render('sharewin', [
                    'shareawins_all' => $dataProvider,
                    'game_obj' => $game_obj
        ]);
    }

    public function actionHowItWork() {
        $this->layout = 'leads';
        return $this->render('howitwork');
    }

    public function actionLeaderboard() {
        $this->layout = 'leads';
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //User Team ID
        $user_team_id = Yii::$app->user->identity->team_id;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        //Challenge Teams
        $teams = explode(',', $game_obj->challenge_teams);

        $teams_points_obj_arr = [];
        foreach ($teams as $key => $team_id):
            //All Users Points - Company & Team Wise
            if (!empty($team_id)):
                $points_obj = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $team_id, 'challenge_id' => $game_id])
                        ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                        ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                        ->limit(10)
                        ->all();

                $teams_points_obj_arr[$team_id] = $points_obj;
            endif;
        endforeach;
        if (empty($teams[0])) {
            $points_obj = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                    ->limit(10)
                    ->all();
            $teams_points_obj_arr[] = $points_obj;
        }
        //Login User Team Total Actions
        if (!empty($user_team_id)):
            $login_user_team_actions = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id, 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->sum('total_game_actions');
        else:
            $login_user_team_actions = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->sum('total_game_actions');
        endif;

        //Login User Team Total Leads Values
        if (!empty($user_team_id)):
            $login_user_team_core_values = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id, 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->sum('total_core_values');
        else:
            $login_user_team_core_values = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->sum('total_core_values');
        endif;
        if (empty($login_user_team_core_values)):
            $login_user_team_core_values = 0;
        endif;

        //Login User Team Total Wins
        if (!empty($user_team_id)):
            $login_user_team_wins = PilotFrontLeadsShareawin::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id, 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->count('id');
        else:
            $login_user_team_wins = PilotFrontLeadsShareawin::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->count('id');
        endif;

        //Login User Team High 5s
        if (!empty($user_team_id)):
            $login_user_team_high5s = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id, 'feature_label' => 'highfiveComment', 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->count('id');
        else:
            $login_user_team_high5s = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'challenge_id' => $game_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->count('id');
        endif;

        return $this->render('leaderboard', [
                    'game_obj' => $game_obj,
                    'teams_points_obj_arr' => $teams_points_obj_arr,
                    'login_user_team_actions' => $login_user_team_actions,
                    'login_user_team_core_values' => $login_user_team_core_values,
                    'login_user_team_wins' => $login_user_team_wins,
                    'login_user_team_high5s' => $login_user_team_high5s,
        ]);
    }

    /**
     * 
     * @return Daily Inspiration Modal
     */
    public function actionDailyModal() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $message = 'Saved Successfully.';
        $dayset = date('Y-m-d');
        //Game Points 5 Days Per Week
        $count_week_entr = 0;
        $points = 10;
        $week_entries = PilotFrontLeadsDailyinspiration::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->all();
        $count_week_entr = count($week_entries);
        if ($count_week_entr >= 5):
            $points = 0;
            $message = "Saved Successfully. But you don't get any points as you had already taken maximum points for this week for daily inspiration section.";
        endif;

        //Makeup Days entry
        $total_points_dailyInsp = PilotFrontLeadsDailyinspiration::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->sum('points');
        if (!empty($total_points_dailyInsp) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
            $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
            $totalweek = $total_gameday / 7;
            $exactWeek = explode('.', $totalweek);
            $total_game_points = $exactWeek[0] * 5 * 10;
            if ($total_points_dailyInsp >= $total_game_points):
                $points = 0;
                $message = "Saved Successfully. But you don't get any points as you had already taken maximum points for daily inspiration section.";
            endif;
        endif;
        //end here

        $daily_model = new PilotFrontLeadsDailyinspiration;
        $daily_email = new PilotFrontLeadsEmail;
        $daily_entry = PilotFrontLeadsDailyinspiration::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
        if (Yii::$app->request->post()):
            $user_id = $_POST['user_id'];
            $dayset = $_POST['dayset'];
            $checkModel = PilotFrontLeadsDailyinspiration::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            if (empty($checkModel)):
                $model = new PilotFrontLeadsDailyinspiration;
                $model->game_id = $game;
                $model->challenge_id = $game_id;
                $model->user_id = $user_id;
                $model->company_id = $comp_id;
                $model->points = $points;
                $model->week_no = $week_no;
                $model->dayset = $dayset;
                $model->created = time();
                $model->updated = time();
                if ($model->save()):
                    return 'Saved Successfully';
                endif;
            endif;
        else:
            //Fetch the Image for Current Day - Daily Inspiration Challenge
            $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
            $game_current_day_no = PilotFrontUser::getGameDay($game_obj);
            $daily_category_id = $game_obj->daily_inspiration_content;
            $daily_inspiration_obj = PilotDailyinspirationImage::find()->where(['category_id' => $daily_category_id, 'order_number' => $game_current_day_no])->one();
            if (empty($daily_inspiration_obj)):
                $numberofdays = PilotCreateGame::getnumofdays($game_obj->id);
                $daily_inspiration_count = PilotDailyinspirationImage::find()->where(['category_id' => $daily_category_id])->count();
                $game_current_day_no1 = PilotFrontUser::getdays($game_current_day_no, $daily_inspiration_count);
                $daily_inspiration_obj = PilotDailyinspirationImage::find()->where(['category_id' => $daily_category_id, 'order_number' => $game_current_day_no1])->one();
            endif;
            $daily_image_path = Yii::getAlias('@back_end') . '/img/daily-inspiration-images/' . $daily_inspiration_obj->image_name;
            $html = $this->renderAjax('game_modals', [
                'daily_model' => $daily_model,
                'daily_entry' => $daily_entry,
                'daily_image_path' => $daily_image_path,
                'daily_email' => $daily_email,
            ]);
            return $html;
        endif;
    }

    /**
     * 
     * @return Core Values Modal
     */
    public function actionCoreValuesModal() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $label = 'core_values_popup';
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $game_id = $game_obj->id;
        $core_id = $game_obj->core_value_content;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        //Game Points 5 Days Per Week
        $count_week_entr = 0;
        $points = 5;
        $week_entries = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'label' => $label, 'week_no' => $week_no, 'challenge_id' => $game_id])->all();
        $count_week_entr = count($week_entries);
        if ($count_week_entr >= 5):
            $points = 0;
        endif;

        //Makeup Days entry
        $total_points_corevalue = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'label' => $label, 'challenge_id' => $game_id])
                ->sum('points');
        if (!empty($total_points_corevalue) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
            $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
            $totalweek = $total_gameday / 7;
            $exactWeek = explode('.', $totalweek);
            $total_game_points = $exactWeek[0] * 5 * 5;
            if ($total_points_corevalue >= $total_game_points):
                $points = 0;
            endif;
        endif;
        //end here

        $corevalues_model = new PilotFrontLeadsCheckin;
        $corevalues_entry = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'label' => $label, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
        if (Yii::$app->request->post()):
            $user_id = $_POST['user_id'];
            $checkModel = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => $label, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            if (empty($checkModel)):
                $model = new PilotFrontLeadsCheckin;
                $model->game_id = $game;
                $model->challenge_id = $game_id;
                $model->user_id = $user_id;
                $model->company_id = $comp_id;
                $model->label = $label;
                $model->comment = 'Read';
                $model->serial = 1;
                $model->points = $points;
                $model->week_no = $week_no;
                $model->dayset = $dayset;
                $model->created = time();
                $model->updated = time();
                if ($model->save()):
                    return 'Saved Successfully';
                endif;
            endif;
        else:
            $html = $this->renderAjax('game_modals', [
                'corevalues_model' => $corevalues_model,
                'corevalues_entry' => $corevalues_entry,
                'core_id' => $core_id,
            ]);
            return $html;
        endif;
    }

    /**
     * 
     * @return Check In With Yourself Modal
     */
    public function actionCheckInModal() {
        $user_id = Yii::$app->user->identity->id;
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $message = "Saved Successfully.";
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');

        $valuesLabel_obj = PilotCompanyCorevaluesname::find()->where(['company_id' => $game_obj->core_value_content])->orderBy(['id' => SORT_ASC])->all();
        $valuesLabel = ArrayHelper::map($valuesLabel_obj, 'core_values_name', 'core_values_name');

        $today_valuesModel = new PilotFrontLeadsCheckin;
        $prev_today_values_currentday = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])
                ->andWhere(['!=', 'label', 'core_values_popup'])
                ->orderBy(['serial' => SORT_ASC])
                ->all();
        $tv_points = 20;
        $count_tv = 0;
        if (!empty($prev_today_values_currentday)):
            $count_tv = count($prev_today_values_currentday);
            if ($count_tv < 2):
                $tv_points = 20;
            else:
                $tv_points = 0;
            endif;
        endif;


        //Game Points 5 Days Per Week
        $sum_week_points = 0;
        $week_entries_points = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])
                ->andWhere(['!=', 'label', 'core_values_popup'])
                ->sum('points');

        if (!empty($week_entries_points)):
            $sum_week_points = $week_entries_points;
        endif;
        if ($sum_week_points >= 200):
            $tv_points = 0;
            $message = "Saved Successfully. But you don't get any points as you had already taken maximum points for this week for check in section.";
        endif;

        //Makeup Days entry for check in section
        $total_weeks_entries_points = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['!=', 'label', 'core_values_popup'])
                ->sum(points);
        if (!empty($total_weeks_entries_points) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
            $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
            $totalweek = $total_gameday / 7;
            $exactWeek = explode('.', $totalweek);
            $total_game_points = $exactWeek[0] * 5 * 40;
            if ($total_weeks_entries_points >= $total_game_points):
                $tv_points = 0;
            endif;
        endif;
        //end here

        if (Yii::$app->request->post()):
            $label = $_POST['label'];
            $comment = $_POST['comment'];
            $serial = $_POST['serial'];
            $checkModel = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => $label, 'serial' => $serial, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            if (empty($checkModel)):
                $model = new PilotFrontLeadsCheckin;
                $model->challenge_id = $game_id;
                $model->game_id = $game;
                $model->user_id = $user_id;
                $model->company_id = $comp_id;
                $model->label = $label;
                $model->comment = json_encode($comment);
                $model->serial = $serial;
                $model->points = $tv_points;
                $model->week_no = $week_no;
                $model->dayset = $dayset;
                $model->created = time();
                $model->updated = time();
                if ($model->save(false)):
                    return 'saved successfully';
                endif;
            endif;
//            Yii::$app->session->setFlash('success', $message);
//            return $this->redirect(['dashboard']);
//            Yii::$app->end();
        else:
            $html = $this->renderAjax('game_modals', [
                'valuesLabel' => $valuesLabel,
                'today_valuesModel' => $today_valuesModel,
                'prev_today_values_currentday' => $prev_today_values_currentday,
                'count_tv' => $count_tv,
                'game_obj' => $game_obj,
            ]);
            return $html;
        endif;
    }

    /**
     * 
     * @return Leadership Modal
     */
    public function actionLeadershipModal() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 10;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $tip_pos = Yii::$app->request->get()['tip'];
        $leadership_model = new PilotFrontLeadsLeadershipcorner;
        $leadership_entry = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos, 'challenge_id' => $game_id])->one();
        if (Yii::$app->request->post()):
            $user_id = $_POST['user_id'];
            $tip_pos = $_POST['tip_pos'];
            //$dayset = Yii::$app->request->post('PilotFrontLeadsLeadershipcorner')['dayset'];
            $checkModel = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos, 'challenge_id' => $game_id])->one();

            //Makeup Days entry            
            $total_points_leadership = PilotFrontLeadsLeadershipcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->sum('points');
            if (!empty($total_points_leadership) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $totalweek = $total_gameday / 7;
                $exactWeek = explode('.', $totalweek);
                $total_game_points = $exactWeek[0] * 30;
                if ($total_points_leadership >= $total_game_points):
                    $points = 0;
                endif;
            endif;
            //end here

            if (empty($checkModel)):
                $model = new PilotFrontLeadsLeadershipcorner;
                $model->challenge_id = $game_id;
                $model->game_id = $game;
                $model->user_id = $user_id;
                $model->company_id = $comp_id;
                $model->week_no = $week_no;
                $model->tip_pos = $tip_pos;
                $model->points = $points;
                $model->dayset = $dayset;
                $model->created = time();
                $model->updated = time();
                if ($model->save()):
                    return 'Saved Successfully';
                endif;
            endif;
//            Yii::$app->session->setFlash('success', 'Saved Successfully.');
//            return $this->redirect(['dashboard']);
//            Yii::$app->end();
        else:

            $week_leadership = 'Week ' . $week_no;
            if ($tip_pos == 'first'):
                $tip_no = $week_leadership . '-one';
            elseif ($tip_pos == 'second'):
                $tip_no = $week_leadership . '-two';
            elseif ($tip_pos == 'third'):
                $tip_no = $week_leadership . '-three';
            endif;
            $leadership_category_id = $game_obj->leadership_corner_content;
            $leadership_tip_obj = PilotLeadershipCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
            if (empty($leadership_tip_obj)):
                $leadership_challenge1 = PilotLeadershipCorner::find()->where(['category_id' => $leadership_category_id])->count();
                $weeks = PilotFrontUser::numofweeks($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $total_weeks_data = $leadership_challenge1;
                $week_no = PilotFrontUser::getweek($week_no, $total_weeks_data);
                $week_leadership = 'Week ' . $week_no;
                if ($week_no < 0):
                    $week_leadership = 'Week ' . 1;
                endif;
                if ($tip_pos == 'first'):
                    $tip_no = $week_leadership . '-one';
                elseif ($tip_pos == 'second'):
                    $tip_no = $week_leadership . '-two';
                elseif ($tip_pos == 'third'):
                    $tip_no = $week_leadership . '-three';
                endif;
                $leadership_tip_obj = PilotLeadershipCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
            endif;

            $html = $this->renderAjax('game_modals', [
                'leadership_model' => $leadership_model,
                'leadership_entry' => $leadership_entry,
                'leadership_tip_obj' => $leadership_tip_obj,
                'tip_pos' => $tip_pos,
            ]);
            return $html;
        endif;
    }

    /**
     * 
     * @return Weekly Challenge Modal
     */
    public function actionWeeklyModal() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 40;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $weekly_entry = PilotFrontLeadsWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->one();
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset1 = date('Y-m-d');
        if (empty($weekly_entry)):
            $weekly_model = new PilotFrontLeadsWeeklychallenge;
        else:
            $weekly_model = $weekly_entry;
        endif;
        if (Yii::$app->request->post()):
            $user_id = Yii::$app->user->identity->id;
            $dayset = date('Y-m-d');
            $comment = $_POST['comment'];
            $checkModel = PilotFrontLeadsWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->one();

            //Makeup Days entry            
            $total_points_weeklyvideo = PilotFrontLeadsWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->sum('points');
            if (!empty($total_points_weeklyvideo) && $dayset1 >= date('Y-m-d', $game_obj->makeup_days)):
                $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $totalweek = $total_gameday / 7;
                $exactWeek = explode('.', $totalweek);
                $total_game_points = $exactWeek[0] * 40;
                if ($total_points_weeklyvideo >= $total_game_points):
                    $points = 0;
                endif;
            endif;
            //end here

            if (empty($checkModel)):
                $model = new PilotFrontLeadsWeeklychallenge;
                $model->game_id = $game;
                $model->challenge_id = $game_id;
                $model->user_id = $user_id;
                $model->company_id = $comp_id;
                $model->points = $points;
                $model->week_no = $week_no;
                $model->comment = json_encode($comment);
                $model->dayset = $dayset;
                $model->created = time();
                $model->updated = time();
                if ($model->save()):
                    return 'Saved Successfully';
                endif;
            else:
                $checkModel->comment = json_encode($comment);
                $checkModel->updated = time();
                if ($checkModel->save()):
                    return 'Updated Successfully';
                endif;
            endif;
        else:
            //Fetch the Video & Title for Current Week - Weekly Challenge
            $game_current_week_no = $week_no;
            $weekly_category_id = $game_obj->weekly_challenge_content;
            $weekly_challenge_obj = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_category_id, 'week' => $game_current_week_no])->one();
            if (empty($weekly_challenge_obj)):
                $weeks = PilotFrontUser::numofweeks($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $weekly_challenge_count = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_category_id])->count();
                $game_current_week_no = PilotFrontUser::getvideoweek($week_no, $weekly_challenge_count);
                $weekly_challenge_obj = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_category_id, 'week' => $game_current_week_no])->one();
            endif;
            $weekly_video_link = $weekly_challenge_obj->video_link;
            $weekly_title = $weekly_challenge_obj->video_title;

            $html = $this->renderAjax('game_modals', [
                'weekly_model' => $weekly_model,
                'weekly_entry' => $weekly_entry,
                'weekly_video_link' => $weekly_video_link,
                'weekly_title' => $weekly_title,
            ]);
            return $html;
        endif;
    }

    /**
     * 
     * @return Weekly Challenge Modal
     */
    public function actionShareABinModal() {
        $user_id = Yii::$app->user->identity->id;
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $team_id = Yii::$app->user->identity->team_id;
        $message = "Saved Successfully.";
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $prev_entry_currentday = PilotFrontLeadsShareawin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])
                        ->orderBy(['created' => SORT_DESC])->all();
        $points = 10;
        $count = 0;
        if (!empty($prev_entry_currentday)):
            $count = count($prev_entry_currentday);
            if ($count >= 1):
                $points = 0;
            endif;
        endif;

        //Game Points 5 Days Per Week
        $sum_week_points = 0;
        $week_entries_points = PilotFrontLeadsShareawin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])
                ->sum('points');
        if (!empty($week_entries_points)):
            $sum_week_points = $week_entries_points;
        endif;
        if ($sum_week_points >= 50):
            $points = 0;
            $message = "Saved Successfully. But you don't get any points as you had already taken maximum points for this week for share a win section.";
        endif;

        //Makeup Days entry       
        $total_points_shareawin = PilotFrontLeadsShareawin::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->sum('points');
        if (!empty($total_points_shareawin) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
            $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
            $totalweek = $total_gameday / 7;
            $exactWeek = explode('.', $totalweek);
            $total_game_points = $exactWeek[0] * 5 * 10;
            if ($total_points_shareawin >= $total_game_points):
                $points = 0;
            endif;
        endif;
        //end here
        $shareawin_model = new PilotFrontLeadsShareawin;
        if (Yii::$app->request->post()):
            $comment = $_POST['comment'];
            $user_id = Yii::$app->user->identity->id;
            $model = new PilotFrontLeadsShareawin;
            $model->challenge_id = $game_id;
            $model->game_id = $game;
            $model->user_id = $user_id;
            $model->company_id = $comp_id;
            $model->team_id = $team_id;
            $model->points = $points;
            $model->comment = json_encode($comment);
            $model->week_no = $week_no;
            $model->dayset = $dayset;
            $model->created = time();
            $model->updated = time();
            if ($model->save(false)):
                return 'Saved Successfully';
            endif;
//            $savedmodel_id = $model->id;
//            $cmnt = $comment;
//            preg_match_all("/data-uid=\"(.*?)\"/i", $cmnt, $matches);
//
//            if (!empty($matches)):
//                foreach ($matches[1] as $key => $tagged_uid):
//                    $cmnt_val = json_encode($comment);
////              echo $cmnt_val;echo '<br>';
//                    $comment_val = json_decode($cmnt_val);
//                    $max_length = 25;
////              echo $comment_val;echo '<br>';
////              if (strlen($comment_val) > $max_length):
////                $offset = ($max_length - 3) - strlen($comment_val);
////                $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
////              endif;
////              echo $comment_val;echo '<br>';
//                    // $comment_val = str_replace("<br>", " ", $comment_val);
////              echo $comment_val;echo '<br>';
////              die;
//                    $tagged_user = PilotFrontUser::findIdentity($tagged_uid);
//
//                    $hf_comment_user = PilotFrontUser::findIdentity($user_id);
//                    $hf_comment_userName = $hf_comment_user->username;
//
//                    $notif_value = json_encode('<b>' . $hf_comment_userName . '</b> has tagged you in a comment <a href="javascript:void(0)">' . $comment_val . '</a>');
//                    //Save Other Users Activity not Own
//                    if ($tagged_uid != $user_id):
//                        $notif_model = new PilotFrontLeadsNotifications;
//                        $notif_model->game_id = $game;
//                        $notif_model->challenge_id = $game_id;
//                        $notif_model->user_id = $tagged_uid;
//                        $notif_model->company_id = $comp_id;
//                        $notif_model->notif_type_id = $savedmodel_id;
//                        $notif_model->notif_type = 'shareawin';
//                        $notif_model->notif_value = $notif_value;
//                        $notif_model->activity_user_id = $user_id;
//                        $notif_model->notif_status = 1;
//                        $notif_model->dayset = $dayset;
//                        $notif_model->created = time();
//                        $notif_model->updated = time();
//                        $notif_model->save(false);
//                    endif;
//                endforeach;
//            endif;
//            Yii::$app->session->setFlash('success', $message);
//            return $this->redirect(['dashboard']);
//            Yii::$app->end();
        else:
            $html = $this->renderAjax('game_modals', [
                'shareawin_model' => $shareawin_model,
            ]);
            return $html;
        endif;
    }

    /**
     * 
     * Implements High five Likes
     */
    public function actionHighfiveLike() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $team_id = Yii::$app->user->identity->team_id;
        $points = 0;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $user_id = $_POST['user_id'];
        $feature_label = $_POST['feature_label'];
        $linked_feature_id = $_POST['comment_id'];
        $checkModel = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'linked_feature_id' => $linked_feature_id, 'challenge_id' => $game_id])->one();
        if (empty($checkModel)):
            $model = new PilotFrontLeadsHighfive;
            $model->challenge_id = $game_id;
            $model->game_id = $game;
            $model->user_id = $user_id;
            $model->company_id = $comp_id;
            $model->team_id = $team_id;
            $model->feature_label = $feature_label;
            $model->feature_value = 1;
            $model->feature_serial = 1;
            $model->linked_feature_id = $linked_feature_id;
            $model->week_no = $week_no;
            $model->points = $points;
            $model->dayset = $dayset;
            $model->created = time();
            $model->updated = time();
            $model->save(false);
            //Save Notification for User in pilot_front_notifications Table
            $linked_feature_user_model = PilotFrontLeadsHighfive::find()->where(['id' => $linked_feature_id])->one();
            $comment_val = json_decode($linked_feature_user_model->feature_value);
            $max_length = 25;
            /* if (strlen($comment_val) > $max_length):
              $offset = ($max_length - 3) - strlen($comment_val);
              $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
              endif; */
            $comment_val = str_replace("<br>", " ", $comment_val);
            $linked_feature_user = PilotFrontUser::findIdentity($linked_feature_user_model->user_id);
            $hf_like_user = PilotFrontUser::findIdentity($user_id);
            $hf_like_userName = $hf_like_user->username;
            $checkModel1 = PilotFrontLeadsHighfive::find()->where(['feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $linked_feature_id, 'challenge_id' => $game_id])->one();
            if (empty($checkModel1)):
                $notif_value = '<b>' . $hf_like_userName . '</b> high fived your comment <a href="javascript:void(0)">' . $comment_val . '</a>';
            else:
                $notif_value = '<b>' . $hf_like_userName . '</b> high fived your Image <a href="javascript:void(0)">' . $comment_val . '</a>';
            endif;
            //Save Other Users Activity not Own
            if ($linked_feature_user->id != $user_id):
                $notif_model = new PilotFrontLeadsNotifications;
                $notif_model->challenge_id = $game_id;
                $notif_model->game_id = $game;
                $notif_model->user_id = $linked_feature_user->id;
                $notif_model->company_id = $comp_id;
                $notif_model->notif_type_id = $linked_feature_id;
                $notif_model->notif_type = 'highfiveLike';
                $notif_model->notif_value = json_encode($notif_value);
                $notif_model->activity_user_id = $user_id;
                $notif_model->notif_status = 1;
                $notif_model->dayset = $dayset;
                $notif_model->created = time();
                $notif_model->updated = time();
                $notif_model->save(false);
            endif;
        endif;
        $total_likes = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $linked_feature_id, 'challenge_id' => $game_id])->all();
        echo json_encode(['status' => 'success', 'likes' => count($total_likes), 'hand_img' => 'hand.png']);
        exit();
    }

    /**
     * Returns Tagged Users List
     */
    public function actionTagList() {
        $baseurl = Yii::$app->request->baseurl;
        if ($_POST) {
            $q = $_POST['searchword'];
            if (strpos($q, '@') !== false) {
                $q = str_replace("@", "", $q);
            } else if (strpos($q, '#') !== false) {
                $q = str_replace("#", "", $q);
            }
            /** Adding Wildcard Character * */
            $attachment = '%';
            $count = strlen($q);
            $pos = $count;
            $newstr = substr_replace($q, $attachment, $pos);
            /** End * */
            /** Query Database Table to Fetch the Users who need to Tag * */
            $company_id = Yii::$app->user->identity->company_id;
            $challenge_id = Yii::$app->user->identity->challenge_id;
            $query = "SELECT * FROM pilot_front_user where company_id = '$company_id' and challenge_id = '$challenge_id' and firstname LIKE '$newstr'";
            $find_tagged_users = PilotFrontUser::findBySql($query)->all();

            /** End * */
            if (empty($find_tagged_users)) {
                $h = '32px';
                $htm = ' <div class="display_box" align="left">
                  No Such User<br/>
                 </div>';
            } else {
                $no_u = count($find_tagged_users);
                $h = 'auto';
                $htm = "";
                $i = 1;
                foreach ($find_tagged_users as $tagged_user) {
                    $userID = $tagged_user['id'];
                    $fname = ucfirst($tagged_user['firstname']);
                    $lname = ucfirst($tagged_user['lastname']);
                    $prof_image = $tagged_user['profile_pic'];
                    if ($prof_image == ''):
                        $prof_image_path = '../images/default-user.png';
                    else:
                        $prof_image_path = $baseurl . '/uploads/thumb_' . $prof_image;
                    endif;
                    $htm .= '<div class="display_box" align="left" onclick="append_data(this)" >';
                    $htm .= '<img src="' . $prof_image_path . ' " class="tag-user-img"/>';
                    $htm .= '<a href="javascript:void(0)" class="addname" title=' . $fname . '&nbsp;' . $lname . ' user-id=' . $userID . '> ' . $fname . '&nbsp;' . $lname . ' </a><br/>';
                    $htm .= '</div>';
                    $i++;
                }
            }
            echo json_encode(array('htm' => $htm, 'height_dis' => $h));
        }
    }

    /**
     * 
     * @return High five Image Zoom Modal 
     */
    public function actionHighfiveImageZoomModal() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $img_id = Yii::$app->request->get('img_id');
        $feature_label = 'highfiveCommentImage';
        $zoomImage = PilotFrontLeadsHighfive::find()->where(['id' => $img_id])->one();
        $html = $this->renderAjax('game_modals', [
            'zoomImage' => $zoomImage,
        ]);
        return $html;
    }

    /**
     * 
     * @return High five Users Comment Modal 
     */
    public function actionHighfiveUsercommentModal() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 10;
        $usercomment_model = new PilotFrontLeadsHighfive;
        $user_id = Yii::$app->request->get()['uid'];
        $comment_id = Yii::$app->request->get()['cid'];
        $feature_label = 'highfiveComment';
        $commentValue = PilotFrontLeadsHighfive::find()->where(['id' => $comment_id])->one();
        $commentImages = PilotFrontLeadsHighfive::find()->where(['feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $comment_id])->all();
        $userComments = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $comment_id])
                ->orderBy(['created' => SORT_ASC])
                ->all();
        $html = $this->renderAjax('game_modals', [
            'usercomment_model' => $usercomment_model,
            'commentValue' => $commentValue,
            'commentImages' => $commentImages,
            'userComments' => $userComments,
        ]);
        return $html;
    }

    /**
     * 
     * Saves High five User Comment 
     */
    public function actionSaveHighfiveUsercomment() {
        $baseurl = Yii::$app->request->baseurl;
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $team_id = Yii::$app->user->identity->team_id;
        $cmnt_points = 0;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $feature_label = 'highfiveUserComment';
        $feature_value = $_POST['cmnt'];
        $feature_serial = $_POST['cmnt_serial'];
        $linked_feature_id = $_POST['linked_hf_cmnt'];
        $checkModel = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'feature_serial' => $feature_serial, 'linked_feature_id' => $linked_feature_id, 'challenge_id' => $game_id])->one();
        $html = '';
        if (empty($checkModel)):
            $model = new PilotFrontLeadsHighfive;
            $model->challenge_id = $game_id;
            $model->game_id = $game;
            $model->user_id = $user_id;
            $model->company_id = $comp_id;
            $model->team_id = $team_id;
            $model->feature_label = $feature_label;
            $model->feature_value = json_encode($feature_value);
            $model->feature_serial = $feature_serial;
            $model->linked_feature_id = $linked_feature_id;
            $model->week_no = $week_no;
            $model->points = $cmnt_points;
            $model->dayset = $dayset;
            $model->created = time();
            $model->updated = time();
            $model->save(false);
            //Save Notification for User in pilot_front_notifications Table
            $linked_feature_user_model = PilotFrontLeadsHighfive::find()->where(['id' => $linked_feature_id])->one();
            $comment_val = json_decode($linked_feature_user_model->feature_value);
            $max_length = 25;
            /* if (strlen($comment_val) > $max_length):
              $offset = ($max_length - 3) - strlen($comment_val);
              $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
              endif; */
            $comment_val = str_replace("<br>", " ", $comment_val);
            $linked_feature_user = PilotFrontUser::findIdentity($linked_feature_user_model->user_id);
            $hf_comment_user = PilotFrontUser::findIdentity($user_id);
            $hf_comment_userName = $hf_comment_user->username;
            $notif_value = '<b>' . $hf_comment_userName . '</b> has commented on your comment <a href="javascript:void(0)">' . $comment_val . '</a>';
            //Save Other Users Activity not Own
            if ($linked_feature_user->id != $user_id):
                $notif_model = new PilotFrontLeadsNotifications;
                $notif_model->game_id = $game;
                $notif_model->challenge_id = $game_id;
                $notif_model->user_id = $linked_feature_user->id;
                $notif_model->company_id = $comp_id;
                $notif_model->notif_type_id = $linked_feature_id;
                $notif_model->notif_type = 'highfiveUserComment';
                $notif_model->notif_value = json_encode($notif_value);
                $notif_model->activity_user_id = $user_id;
                $notif_model->notif_status = 1;
                $notif_model->dayset = $dayset;
                $notif_model->created = time();
                $notif_model->updated = time();
                $notif_model->save(false);
            endif;
        endif;
        //Comments Display Under Appreciation Comment
        $allComments = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'linked_feature_id' => $linked_feature_id, 'challenge_id' => $game_id])
                        ->orderBy(['created' => SORT_ASC])->all();
        $i = 1;
        if (!empty($allComments)):
            foreach ($allComments as $comment):
                $cmnt_user = PilotFrontUser::findIdentity($comment->user_id);
                $cmnt_userName = $cmnt_user->username;
                $cmnt_userImage = $cmnt_user->profile_pic;
                $cmnt = json_decode($comment->feature_value);
                if ($cmnt_userImage == ''):
                    $cmnt_userImagePath = '../images/user_icon.png';
                else:
                    $cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $cmnt_userImage;
                endif;
                if ($i % 2 == 0):
                    $row_cls = '';
                else:
                    $row_cls = 'w';
                endif;
                $created = $comment->created;
                $cmnt_time = date('M d, Y h:i A', $created);
                $html .= '<div class="user-record High-5 ' . $row_cls . '">
                          <div class="user">
                              <img alt="user" src="' . $cmnt_userImagePath . '">
                          </div>
                          <div class="right_info">
                              <ul class="user-info">
                                  <li> <h5>' . $cmnt_userName . '</h5><p class="time1">' . $cmnt_time . '</p></li>
                                  <li> <p> ' . $cmnt . '</p> </li>
                              </ul>
                          </div> 
                      </div>';
                $i++;
                $serial = $comment->feature_serial;
            endforeach;
            $cmnt_serial = $serial + 1;
        else:
            $cmnt_serial = 1;
        endif;

        //Total Comments
        if (!empty($team_id)):
            $total_comments = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $team_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $linked_feature_id, 'challenge_id' => $game_id])->all();
        else:
            $total_comments = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $linked_feature_id, 'challenge_id' => $game_id])->all();
        endif;

        echo json_encode(array('html' => $html, 'cmnt_serial' => $cmnt_serial, 'total_comments' => count($total_comments), 'status' => 'success'));
    }

    /**
     * 
     * Fetch the Notifications 
     */
    public function actionGetNotifications() {
        $baseurl = Yii::$app->request->baseurl;
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $cmnt_points = 0;
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $user_notifs = PilotFrontLeadsNotifications::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])->orderBy(['id' => SORT_DESC])->all();
        $notif_html = '';
        if (!empty($user_notifs)):
            foreach ($user_notifs as $user_notif) :
                $notif_type_id = $user_notif->notif_type_id;
                $notif_type = $user_notif->notif_type;
                $notif_value = $user_notif->notif_value;
                $notif_status = $user_notif->notif_status;
                $notif_activity_user_id = $user_notif->activity_user_id;
                $notif_activity_user = PilotFrontUser::findIdentity($notif_activity_user_id);
                $notif_activity_userName = $notif_activity_user->username;
                if ($notif_activity_user->profile_pic):
                    $imagePath = Yii::$app->request->baseurl . '/uploads/thumb_' . $notif_activity_user->profile_pic;
                else:
                    $imagePath = Yii::$app->request->baseurl . '/images/user_icon.png';
                endif;

                if ($notif_status == 1):
                    $read_cls = 'w';
                else:
                    $read_cls = '';
                endif;

                $notif_html .= '<div id="' . $user_notif->id . '" class="user-notify ' . $read_cls . '" data-uid="' . $user_id . '" data-cid="' . $notif_type_id . '">'
                        . '<div class="user-img">'
                        . '<img src=' . $imagePath . ' height="50px" width="50px">'
                        . '</div>'
                        . '<div class="user-detail">'
                        . '' . json_decode($notif_value) . ''
                        . '</div>'
                        . '</div>';
            endforeach;
        else:
            $notif_html .= '<div class="no-noification"><b>No Notifications found</b></div> ';
        endif;
        echo json_encode(array('notif_html' => $notif_html));
    }

    /**
     * 
     * Set the Status of Notifications 
     */
    public function actionSetNotificationsStatus() {
        $baseurl = Yii::$app->request->baseurl;
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $cmnt_points = 0;
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $user_notifs = PilotFrontLeadsNotifications::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])->orderBy(['id' => SORT_DESC])->all();
        if (!empty($user_notifs)):
            foreach ($user_notifs as $user_notif) :
                $user_notif->notif_status = 0;
                $user_notif->save(false);
            endforeach;
        endif;
        echo json_encode(array('status' => 'sucess'));
    }

    public function actionNotificationStatus() {
        $notif_id = $_GET['nid'];
        $notif_model = PilotFrontLeadsNotifications::find()->where(['id' => $notif_id])->one();
        if (!empty($notif_model)):
            $notif_model->notif_status = 0;
            $notif_model->save(false);
        endif;
        return 'success';
    }

    public function actionHighfiveImageUpload() {
        $session = Yii::$app->session;
        $name = $_FILES['hf_cmnt_img']['name'];
        $tmpName = $_FILES['hf_cmnt_img']['tmp_name'];
        $error = $_FILES['hf_cmnt_img']['error'];
        $size = $_FILES['hf_cmnt_img']['size'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);

        $uniqueid = uniqid();
        $hf_image_name = 'hf_' . $uniqueid . '_' . $name;
        $targetPath = Yii::getAlias('@uploads/high_five/') . $hf_image_name;
        $up = move_uploaded_file($tmpName, $targetPath);

        $hf_image_name_new = 'hf_new_' . $uniqueid . '_' . $name;
        $targetPathNew = Yii::getAlias('@uploads/high_five/') . $hf_image_name_new;

        // Get the Image Orientation
        $image_obj = imagecreatefromstring(file_get_contents($targetPath));
        $exif = @exif_read_data($targetPath);
        $orientation = $exif['Orientation'];
        if (!empty($exif['Orientation'])):
            switch ($exif['Orientation']):
                case 8:
                    $image = imagerotate($image_obj, 90, 0);
                    break;
                case 3:
                    $image = imagerotate($image_obj, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($image_obj, -90, 0);
                    break;
                default:
                    $image = $image_obj;
            endswitch;

            if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG' || $ext == 'JPEG'):
                $a = imagejpeg($image, $targetPathNew);
            endif;
            if ($ext == 'png' || $ext == 'PNG'):
                $a = imagepng($image, $targetPathNew);
            endif;
            if ($ext == 'gif' || $ext == 'GIF'):
                $a = imagegif($image, $targetPathNew);
            endif;
            imagedestroy($image);

            //Thumbnail Code
            $thumb_hf_image_name = Image::thumbnail(Yii::getAlias('@uploads/high_five/' . $hf_image_name_new), 71, 71)
                    ->save(Yii::getAlias('@uploads/high_five/thumb_' . $hf_image_name_new), ['quality' => 75]);
            $session->set('hf_cmnt_img', $hf_image_name_new);
            echo json_encode(array('image_upload' => 'success'));

            //remove first copy of file
            unlink($targetPath);

        else:
            //Thumbnail Code
            $thumb_hf_image_name = Image::thumbnail(Yii::getAlias('@uploads/high_five/' . $hf_image_name), 71, 71)
                    ->save(Yii::getAlias('@uploads/high_five/thumb_' . $hf_image_name), ['quality' => 75]);
            $session->set('hf_cmnt_img', $hf_image_name);
            echo json_encode(array('image_upload' => 'success'));

        endif;
    }

    /**
     * Game Points of User
     */
    public function actionGetUserPoints() {
        $total_points = '';
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //Team ID
        $team_id = Yii::$app->user->identity->team_id;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->select('id')->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
//        $game_start_date_timestamp = $game_obj->challenge_start_date;
//        $game_end_date_timestamp = $game_obj->challenge_end_date;
//        $game_end_date_timestamp = strtotime('+1 day', $game_end_date_timestamp);
        // $game_end_date_timestamp = 1512806400;
        //Count the Total Leads Values of the User
//        $total_core_values = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
//                        ->andWhere(['!=', 'label', 'core_values_popup'])
//                        ->orderBy(['created' => SORT_DESC])->all();
//
//        $digits_count = strlen(count($total_core_values));
        $total_points_data = PilotFrontLeadsTotalPoints::find()->select('total_points,total_raffle_entry')->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])->one();
        $total_points = $total_points_data->total_points;
        if ($total_points == '') {
            $total_points = 0;
        }
        $raffle_entry = $total_points_data->total_raffle_entry;
        if ($raffle_entry == '') {
            $raffle_entry = 0;
        }
        echo json_encode(array('total_points' => $total_points, 'raffle_entry' => $raffle_entry, 'status' => 'success'));
    }

    /**
     * Company Users Points
     */
    public function actionGetCompanyUsersPoints() {
        $baseurl = Yii::$app->request->baseurl;
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //Team ID
        $team_id = Yii::$app->user->identity->team_id;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->select('id')->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
//        $game_start_date_timestamp = $game_obj->challenge_start_date;
//        $game_end_date_timestamp = $game_obj->challenge_end_date;
//        $game_end_date_timestamp = strtotime('+1 day', $game_end_date_timestamp);
        // $game_end_date_timestamp = 1512806400;
        $users_points_obj = PilotFrontLeadsTotalPoints::find()->select('user_id,total_points')->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                ->limit(5)
                ->all();
        $html = '';
        $rank = 0;
        foreach ($users_points_obj as $user_points_obj):
            $user_points = $user_points_obj->total_points;

            if ($user_points > 0):
                $rank++;
                if ($rank % 2 == 0):
                    $row_cls = 'even';
                else:
                    $row_cls = 'odd';
                endif;

                //Get User Features
                $uid = $user_points_obj->user_id;
                $user_obj = PilotFrontUser::find()->select('username,profile_pic')->where(['id' => $uid])->one();
                $user_name_complt = $user_obj->username;
                $pieces_uname = explode(" ", $user_name_complt);
                $user_name = $pieces_uname[0] . ' ' . $pieces_uname[1];
                if ($user_obj->profile_pic) {
                    $user_imagePath = $baseurl . '/uploads/thumb_' . $user_obj->profile_pic;
                } else {
                    $user_imagePath = $baseurl . '/images/user_icon.png';
                }
                if ($rank <= 5):
                    //HTML for Leaderboard Points Section
                    $html .= ' <tr class=' . $row_cls . '>
                    <td class=oned>' . $rank . '</td>
                    <td class=twod> <img alt=people src="' . $user_imagePath . '" height=50 width=50></td>
                    <td class=tn>' . $user_name_complt . '</td>
                    <td class=fourd>' . $user_points . '</td>
                </tr>';
                endif;
            endif;
        endforeach;

        $total_actions_count = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                ->sum('total_game_actions');
        if (empty($total_actions_count)):
            $total_actions_count = 0;
        endif;

        echo json_encode(array('leaderboard_html' => $html, 'total_actions_count' => $total_actions_count, 'status' => 'success'));
    }

    /**
     * Leaderboard Points Modal - Top 20 Users's Points
     */
    public function actionLeaderboardPointsModal() {
        $baseurl = Yii::$app->request->baseurl;
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //Team ID
        $team_id = Yii::$app->user->identity->team_id;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;

        //All Users Points - Company & Team Wise
        if (!empty($team_id)):
            $users_points_obj = PilotFrontLeadsTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $team_id, 'challenge_id' => $game_obj->id])
                    ->andWhere(['>', 'total_points', 0])
                    ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                    ->limit(20)
                    ->all();
        else:
            $users_points_obj = PilotFrontLeadsTotalPoints::find()->select('user_id,total_points')->where(['game_id' => $game, 'company_id' => $comp_id, 'challenge_id' => $game_obj->id])
                    ->andWhere(['>', 'total_points', 0])
                    ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                    ->limit(20)
                    ->all();
        endif;
        $html = '';
        $rank = 0;
        if (count($users_points_obj) <= 10):
            $html .= '<div class="container-fluid padding-0">
                <div class="row table-points">
                    <div class="leaderboard col-lg-12 col-md-12 col-sm-12 col-xs-12 padding-0">
                      <div class="headingss heading-left padding-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="main-header">
                              <div class="header">RANK</div>
                              <div class="header">PROF. PIC</div>
                              <div class="header">NAME</div>
                              <div class="header">POINTS</div>
                          </div> </div>';
            foreach ($users_points_obj as $user_points_obj):
                $user_points = $user_points_obj->total_points;

                if ($user_points > 0):
                    $rank++;
                    if ($rank % 2 == 0):
                        $row_cls = 'even';
                    else:
                        $row_cls = 'odd';
                    endif;

                    //Get User Features
                    $uid = $user_points_obj->user_id;
                    $user_obj = PilotFrontUser::findIdentity($uid);
                    $user_name = $user_obj->username;
                    // breake the user name after 25 character
                    $user_name = (strlen($user_name) > 25) ? substr($user_name, 0, 25) . '...' : $user_name;

                    if ($user_obj->profile_pic):
                        $user_imagePath = $baseurl . '/uploads/thumb_' . $user_obj->profile_pic;
                    else:
                        $user_imagePath = $baseurl . '/images/user_icon.png';
                    endif;

                    //HTML for Leaderboard Points Section
                    $html .= '<div class="points-data record-tr ' . $row_cls . '">
            <div class="rank record-td">' . $rank . '</div>
            <div class="pic record-td"><img alt="Image" title="Image" src="' . $user_imagePath . '" class="" width="50px" height="50px"></div>
            <div class="name record-td">' . $user_name . '</div>
            <div class="points record-td">' . $user_points . '</div>
        </div>';

                endif;
            endforeach;

            $html .= '</div>
                  </div>
             </div>';
        else:
            $html .= '<div class="container-fluid padding-0">
                <div class="row table-points">
                    <div class="leaderboard-left col-lg-6 col-md-6 col-sm-12 col-xs-12 padding-0">
                      <div class="headingss heading-left padding-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="main-header">
                              <div class="header">RANK</div>
                              <div class="header">PROF. PIC</div>
                              <div class="header">NAME</div>
                              <div class="header">POINTS</div>
                          </div> </div>';
            foreach ($users_points_obj as $user_points_obj):
                $user_points = $user_points_obj->total_points;

                if ($user_points > 0):
                    $rank++;
                    if ($rank % 2 == 0):
                        $row_cls = 'even';
                    else:
                        $row_cls = 'odd';
                    endif;

                    //Get User Features
                    $uid = $user_points_obj->user_id;
                    $user_obj = PilotFrontUser::findIdentity($uid);
                    $user_name = $user_obj->username;
                    // breake the user name after 25 character
                    $user_name = (strlen($user_name) > 25) ? substr($user_name, 0, 25) . '...' : $user_name;

                    if ($user_obj->profile_pic):
                        $user_imagePath = $baseurl . '/uploads/thumb_' . $user_obj->profile_pic;
                    else:
                        $user_imagePath = $baseurl . '/images/user_icon.png';
                    endif;
                    if ($rank <= 10):
                        //HTML for Leaderboard Points Section
                        $html .= '<div class="points-data record-tr ' . $row_cls . '">
            <div class="rank record-td">' . $rank . '</div>
            <div class="pic record-td"><img alt="Image" title="Image" src="' . $user_imagePath . '" class="" width="50px" height="50px"></div>
            <div class="name record-td">' . $user_name . '</div>
            <div class="points record-td">' . $user_points . '</div>
        </div>';
                    endif;
                endif;
            endforeach;
            $rank = 0;
            $html .= '</div>
        <div class="leaderboard-right col-lg-6 col-md-6 col-sm-12 col-xs-12 padding-0">
                      <div class="headingss heading-right padding-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                          <div class="main-header">
                              <div class="header">RANK</div>
                              <div class="header">PROF. PIC</div>
                              <div class="header">NAME</div>
                              <div class="header">POINTS</div>
                          </div> </div>';
            foreach ($users_points_obj as $user_points_obj):
                $user_points = $user_points_obj->total_points;

                if ($user_points > 0):
                    $rank++;
                    if ($rank % 2 == 0):
                        $row_cls = 'even';
                    else:
                        $row_cls = 'odd';
                    endif;

                    //Get User Features
                    $uid = $user_points_obj->user_id;
                    $user_obj = PilotFrontUser::findIdentity($uid);
                    $user_name = $user_obj->username;
                    // breake the user name after 25 character
                    $user_name = (strlen($user_name) > 25) ? substr($user_name, 0, 25) . '...' : $user_name;

                    if ($user_obj->profile_pic):
                        $user_imagePath = $baseurl . '/uploads/thumb_' . $user_obj->profile_pic;
                    else:
                        $user_imagePath = $baseurl . '/images/user_icon.png';
                    endif;
                    if ($rank > 10):
                        //HTML for Leaderboard Points Section
                        $html .= '<div class="points-data record-tr ' . $row_cls . '">
                        <div class="rank record-td">' . $rank . '</div>
                        <div class="pic record-td"><img alt="Image" title="Image" src="' . $user_imagePath . '" class="" width="50px" height="50px"></div>
                        <div class="name record-td">' . $user_name . '</div>
                        <div class="points record-td">' . $user_points . '</div>
                    </div>';
                    endif;
                endif;
            endforeach;

            $html .= '</div>
             </div>';

        endif;
        return $html;
    }

    /**
     * Calendar - Check-in Section
     */
    public function actionCalendar() {
        $this->layout = 'leads';
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //Team ID
        $team_id = Yii::$app->user->identity->team_id;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        $game_start_date = date('Y-m-d', $game_start_date_timestamp);
        $game_end_date = date('Y-m-d', $game_end_date_timestamp);
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        //Dates of Game Challenge
        $gameDates = PilotFrontUser::GetDateListDateRange($game_start_date, $game_end_date);
        $pointsArr = [];
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $current_date = date('Y-m-d');
        //Explode to fetch the month & year 
        $exp_game_strt = explode('-', $game_start_date);
        $exp_game_end = explode('-', $game_end_date);
        $game_month = '';

        // Fetching the Other Dates of Month in which the Game starts & ends
        if ($exp_game_strt[1] == $exp_game_end[1]): //Case 1 : if Game Starts & Ends in Same Month
            $game_month = 'same';
            $list_dates = array();
            $year = $exp_game_strt[0];
            $month = $exp_game_strt[1];
            for ($d = 1; $d <= 31; $d++) {
                $time = mktime(12, 0, 0, $month, $d, $year);
                if (date('m', $time) == $month)
                    $list_dates[] = date('Y-m-d', $time);
            }
        else: //Case 2 : Game's Start & End Months are differ
            $game_month = 'differ';
//            $list_start_dates = array();
//            $list_end_dates = array();
            $list_dates = array();
//
//            //Month dates in which Game Starts
//            $year1 = $exp_game_strt[0];
//            $month1 = $exp_game_strt[1];
//            for ($d1 = 1; $d1 <= 31; $d1++) {
//                $time1 = mktime(12, 0, 0, $month1, $d1, $year1);
//                if (date('m', $time1) == $month1)
//                    $list_start_dates[] = date('Y-m-d', $time1);
//            }
//            //Month dates in which Game Ends
//            $year2 = $exp_game_end[0];
//            $month2 = $exp_game_end[1];
//            for ($d2 = 1; $d2 <= 31; $d2++) {
//                $time2 = mktime(12, 0, 0, $month2, $d2, $year2);
//                if (date('m', $time2) == $month2)
//                    $list_end_dates[] = date('Y-m-d', $time2);
//            }
//
//            $list_dates = array_merge($list_start_dates, $list_end_dates);
            for ($i = $game_start_date_timestamp; $i <= $game_end_date_timestamp; $i += 86400) {
                $list_dates[] = date("Y-m-d", $i);
            }
        endif;

        foreach ($list_dates as $index => $val):
            $pointsArr[$val] = '';
            //Get the Points of Check In Section as per the Game Challenge Start Date
            foreach ($pointsArr as $date => $value):
                if (in_array($date, $gameDates)):
                    $check_in_points = 0;
                    //Calculate Check in Section points
                    $check_in_points_res = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $date, 'challenge_id' => $game_id])
                            ->andWhere(['!=', 'label', 'core_values_popup'])
                            ->sum('points');
                    if (!empty($check_in_points_res)):
                        $check_in_points = $check_in_points_res;
                        $pointsArr[$date] = $check_in_points;
                    else:
                        if ($date <= $current_date):
                            $pointsArr[$date] = 0;
                        else:
                            $pointsArr[$date] = 'enabled';
                        endif;
                    endif;
                else:
                    $pointsArr[$date] = 'disabled';
                endif;
            endforeach;
        endforeach;

        //Check In Modal Submitted - Calendar Page
        if (Yii::$app->request->post('PilotFrontLeadsCheckin')):
            $label = Yii::$app->request->post('PilotFrontLeadsCheckin')['label'];
            $comment = Yii::$app->request->post('PilotFrontLeadsCheckin')['comment'];
            $serial = Yii::$app->request->post('PilotFrontLeadsCheckin')['serial'];
            $dayset = Yii::$app->request->post('PilotFrontLeadsCheckin')['dayset'];
            $week_asper_date = PilotFrontUser::getGameWeekAsPerDate($game_obj, $dayset);
            $prev_today_values_currentday = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])
                    ->andWhere(['!=', 'label', 'core_values_popup'])
                    ->orderBy(['serial' => SORT_ASC])
                    ->all();
            $tv_points = 20;
            $count_tv = 0;
            if (!empty($prev_today_values_currentday)):
                $count_tv = count($prev_today_values_currentday);
                if ($count_tv < 2):
                    $tv_points = 20;
                else:
                    $tv_points = 0;
                endif;
            endif;

            //Game Points 5 Days Per Week
            $sum_week_points = 0;
            $week_entries_points = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_asper_date, 'challenge_id' => $game_id])
                    ->andWhere(['!=', 'label', 'core_values_popup'])
                    ->sum('points');
            if (!empty($week_entries_points)):
                $sum_week_points = $week_entries_points;
            endif;
            if ($sum_week_points >= 200):
                $tv_points = 0;
            endif;
            //endhere week entries
            //Makeup Days entry for check in section
            $total_weeks_entries_points = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->andWhere(['!=', 'label', 'core_values_popup'])
                    ->sum(points);
            if (!empty($total_weeks_entries_points) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $totalweek = $total_gameday / 7;
                $exactWeek = explode('.', $totalweek);
                $total_game_points = $exactWeek[0] * 5 * 40;
                if ($total_weeks_entries_points >= $total_game_points):
                    $tv_points = 0;
                endif;
            endif;
            //end here
            $checkModel = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => $label, 'serial' => $serial, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            if (empty($checkModel)):
                $model = new PilotFrontLeadsCheckin;
                $model->game_id = $game;
                $model->challenge_id = $game_id;
                $model->user_id = $user_id;
                $model->company_id = $comp_id;
                $model->label = $label;
                $model->comment = json_encode($comment);
                $model->serial = $serial;
                $model->week_no = $week_asper_date;
                $model->points = $tv_points;
                $model->dayset = $dayset;
                $model->created = time();
                $model->updated = time();
                $model->save(false);
            endif;
            Yii::$app->session->setFlash('success', 'Saved Successfully.');
            return $this->redirect('calendar');
            Yii::$app->end();
        endif;
        //End
        return $this->render('calendar', ['pointsArr' => $pointsArr, 'game_month' => $game_month, 'game_start_month' => $exp_game_strt[1], 'game_end_month' => $exp_game_end[1]]);
    }

    /**
     * Get the Check-In Section Record as per Calendar Date
     */
    public function actionGetCalRecord() {
        if (Yii::$app->request->isAjax == true) {
            $data = Yii::$app->request->post();
            $user_id = Yii::$app->user->identity->id;
            $timezone = Yii::$app->user->identity->timezone;
            date_default_timezone_set($timezone);
            $game = PilotFrontUser::getGameID('leads');
            $comp_id = Yii::$app->user->identity->company_id;
            $points = 5;
            $dayset = $data['date'];
            $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
            $game_id = $game_obj->id;
            $valuesLabel_obj = PilotCompanyCorevaluesname::find()->where(['company_id' => $game_obj->core_value_content])->orderBy(['id' => SORT_ASC])->all();
            $valuesLabel = ArrayHelper::map($valuesLabel_obj, 'core_values_name', 'core_values_name');
            $today_valuesModel = new PilotFrontLeadsCheckin;
            $prev_values_currentday = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])
                    ->andWhere(['!=', 'label', 'core_values_popup'])
                    ->orderBy(['serial' => SORT_DESC])
                    ->all();

            $prev_today_values_currentday = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset, 'challenge_id' => $game_id])
                    ->andWhere(['!=', 'label', 'core_values_popup'])
                    ->orderBy(['serial' => SORT_ASC])
                    ->all();

            $count_tv = count($prev_values_currentday);

            $html = $this->renderAjax('game_modals', [
                'valuesLabel' => $valuesLabel,
                'today_valuesModel' => $today_valuesModel,
                'prev_values_currentday' => $prev_values_currentday,
                'prev_today_values_currentday' => $prev_today_values_currentday,
                'count_tv' => $count_tv,
                'action' => 'calendar',
                'dayset' => $dayset,
                'game_obj' => $game_obj,
            ]);
            return $html;
        }
    }

    /**
     * Welcome Page of the Challenge for the User - if Challenge is in Upcoming Status
     */
    public function actionWelcome() {
        $this->layout = 'leads';
        $company_id = Yii::$app->user->identity->company_id;
        $challenge_id = Yii::$app->user->identity->challenge_id;
        //$company = Company::find()->where(['id' => $company_id])->one();
        $current_time = time();
        $currentdate = date("m-d-Y", $current_time);
        $gamemodel = PilotCreateGame::find()->where(['challenge_company_id' => $company_id, 'challenge_id' => $challenge_id, 'status' => 1])->one();
        if (!empty($gamemodel)):
            if (((date("m-d-Y", $gamemodel->challenge_start_date)) <= $currentdate)) {
                return $this->redirect(Url::to(['/leads/dashboard']));
            }
        endif;
        return $this->render('welcome');
    }

    /**
     * Thanku Page of the Challenge for the User - if Challenge is completed
     */
    public function actionThankyou() {
        $this->layout = 'leads';
        $company_id = Yii::$app->user->identity->company_id;
        $challenge_id = Yii::$app->user->identity->challenge_id;
        //$company = Company::find()->where(['id' => $company_id])->one();
        $current_time = time();
        $currentdate = date("m-d-Y", $current_time);
        $gamemodel = PilotCreateGame::find()->where(['challenge_company_id' => $company_id, 'challenge_id' => $challenge_id, 'status' => 1])->one();
        if (!empty($gamemodel)):
            if (((date("m-d-Y", $gamemodel->challenge_end_date)) >= $currentdate)) {
                return $this->redirect(Url::to(['/leads/dashboard']));
            }
        endif;
        return $this->render('thankyou');
    }

    /**
     * Skip the Survey for Current day
     */
    public function actionSkipSurvey() {
        $user_id = $_POST['user_id'];
        $challenge_id = $_POST['challenge_id'];
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        //Check whelther User has already Skipped the Survey 
        $check_already_skipped = PilotFrontLeadsSurveyData::find()->where(['challenge_id' => $challenge_id, 'user_id' => $user_id, 'survey_filled' => 'No'])->one();
        //Save the Entry : Skipped the Survey for Current Day
        if (empty($check_already_skipped)):
            $surveyModel = new PilotFrontLeadsSurveyData();
            $surveyModel->challenge_id = $challenge_id;
            $surveyModel->user_id = $user_id;
            $surveyModel->survey_filled = 'No';
            $surveyModel->week_no = $week_no;
            $surveyModel->dayset = $dayset;
            $surveyModel->created = time();
            $surveyModel->updated = time();
            $surveyModel->save(false);
        else: //Update the previous skipped entry and overwrite with current day
            $check_already_skipped->dayset = $dayset;
            $check_already_skipped->updated = time();
            $check_already_skipped->save(false);
        endif;
        return 'success';
    }

    /**
     * Listing of Fitness Band Data
     */
    public function actionFitnessSteps() {

        $this->layout = 'leads';
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //User Team ID
        $team_id = Yii::$app->user->identity->team_id;

        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();

        $game_start_date = date('Y-m-d', $game_obj->challenge_start_date);
        $game_end_date = date('Y-m-d', $game_obj->challenge_end_date);
        $gamedates_array = PilotFrontUser::GetDateListDateRange($game_start_date, $game_end_date);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $current_date = date('d/m/Y');

        $fitness_data_arr = [];

        foreach ($gamedates_array as $key => $gamedate):
            $originalDate = $gamedate;
            $tmstmp = strtotime($originalDate);
            $convrtd_date = date("d/m/Y", $tmstmp);

            $fetch_data = PilotFrontLeadsStepsApiData::find()->where(['user_id' => $user_id, 'date' => $convrtd_date])->one();
            if (!empty($fetch_data)):
                $fitness_data_arr[$tmstmp] = [
                    $convrtd_date => $fetch_data
                ];
            else:
                $fitness_data_arr[$tmstmp] = [
                    $convrtd_date => 0
                ];
            endif;
            //Stop the Loop if Current Date reached in Game Dates Range
            if ($current_date == $convrtd_date):
                break;
            endif;

        endforeach;

        // create a pagination object with the total count
        $pages = new Pagination(['totalCount' => count($fitness_data_arr), 'defaultPageSize' => 30]);
        $rcrd_start = $pages->offset + 1;
        $rcrd_end = $pages->offset + 30;

        return $this->render('fitness_steps', [
                    'fitness_data_arr' => $fitness_data_arr,
                    'pages' => $pages,
                    'rcrd_start' => $rcrd_start,
                    'rcrd_end' => $rcrd_end
        ]);
    }

    /**
     * Login API Action
     */
    public function actionApiLoginToken() {

        if (isset(Yii::$app->user->identity)):
            $access_token = Yii::$app->user->identity->auth_key;
            $refresh_token = Yii::$app->user->identity->auth_key;
            $expires_in = '1500';
            $uid = Yii::$app->user->identity->id;
            $fullname = Yii::$app->user->identity->username;
            $gender = Yii::$app->user->identity->gender;
            $height = Yii::$app->user->identity->height;
            $weight = Yii::$app->user->identity->weight;
            $stride = Yii::$app->user->identity->stride;
            if (Yii::$app->user->identity->profile_pic):
                $profile_pic = Yii::$app->user->identity->profile_pic;
                $profile_picture = 'http://root.injoymore.com/uploads/' . $profile_pic;
            else:
                $profile_picture = '';
            endif;

            //Save or Update User Information
            $getdata = PilotFrontUser::find()->where(['id' => $uid])->one();
            if (empty($getdata)):
                $api_model = new PilotFrontUser();
                $api_model->id = $uid;
                $api_model->username = $fullname;
                $api_model->access_token = $access_token;
                $api_model->refresh_token = $refresh_token;
                $api_model->expires_in = $expires_in;
                $api_model->gender = $gender;
                $api_model->height = $height;
                $api_model->weight = $weight;
                $api_model->stride = $stride;
                $api_model->created = time();
                $api_model->updated = time();
                $api_model->save(false);
            else:
                $getdata->username = $fullname;
                $getdata->access_token = $access_token;
                $getdata->refresh_token = $refresh_token;
                $getdata->expires_in = $expires_in;
                $getdata->gender = $gender;
                $getdata->height = $height;
                $getdata->weight = $weight;
                $getdata->stride = $stride;
                $getdata->updated = time();
                $getdata->save(false);
            endif;
            $profile = array('fullname' => $fullname, 'uid' => $uid, 'gender' => $gender, 'height' => $height, 'weight' => $weight, 'stride' => $stride, 'profile_pic' => $profile_picture);
            $status = "200";
            $jsonarray = array('status' => $status, 'access_token' => $access_token, 'refresh_token' => $refresh_token, 'expires_in' => $expires_in, 'profile' => $profile);
            echo json_encode($jsonarray);
            exit();
        else:
            $getdataarray = 'Authentication failed.';
            $status = "400";
            $jsonarray = array('status' => $status, 'data' => $getdataarray);
            echo json_encode($jsonarray);
            exit();
        endif;
    }

    /**
     * Steps API Action
     */
    public function actionPostApiData() {

        if (isset($_REQUEST['uid']) && isset($_REQUEST['date']) && isset($_REQUEST['steps']) && isset($_REQUEST['calories']) && isset($_REQUEST['sleephr']) && isset($_REQUEST['distance'])):
            $uid = $_REQUEST['uid'];
            $date = $_REQUEST['date'];
            $steps = $_REQUEST['steps'];
            $cal = $_REQUEST['calories'];
            $sleep = $_REQUEST['sleephr'];
            $distance = $_REQUEST['distance'];
            $result_uid = PilotFrontUser::findIdentity($uid);

            $ruid = $result_uid->id;
            if (!empty($result_uid) && ($ruid > 0)):
                $getdata = PilotFrontLeadsStepsApiData::find()->where(['user_id' => $uid, 'date' => $date])->one();
                //Get the Challenge(Game) ID
                $game = PilotFrontUser::getGameID('leads');
                //User Company ID
                $comp_id = $result_uid->company_id;
                //Active Challenge Object (Start Date & End Date) 
                $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
                $dayset = date('Y-m-d', time());
                $week_asper_date = PilotFrontUser::getGameWeekAsPerDate($game_obj, $dayset);
                if (empty($getdata)):
                    $api_model = new PilotFrontLeadsStepsApiData();
                    $api_model->user_id = $uid;
                    $api_model->company_id = $result_uid->company_id;
                    $api_model->team_id = $result_uid->team_id;
                    $api_model->steps = $steps;
                    $api_model->calories = $cal;
                    $api_model->sleephr = $sleep;
                    $api_model->distance = $distance;
                    $api_model->week_no = $week_asper_date;
                    $api_model->date = $date;
                    $api_model->time = time();
                    $api_model->save(false);
                else:
                    $getdata->company_id = $result_uid->company_id;
                    $getdata->team_id = $result_uid->team_id;
                    $getdata->steps = $steps;
                    $getdata->calories = $cal;
                    $getdata->sleephr = $sleep;
                    $getdata->distance = $distance;
                    $getdata->week_no = $week_asper_date;
                    $getdata->save(false);
                endif;

                $getdataarray = array('date' => $date, 'calories' => $cal, 'steps' => $steps, 'sleephr' => $sleep, 'distance' => $distance);
                $status = "200";
            else:
                $getdataarray = 'Authentication failed.';
                $status = "400";
            endif;
        else:
            $getdataarray = 'Authentication failed.';
            $status = "400";
        endif;
        $jsonarray = array('status' => $status, 'data' => $getdataarray);
        echo json_encode($jsonarray);
        exit();
    }

    /**
     * 
     * @param type $exif
     * @param type $field
     * @return string
     */
    public function search_features_array($exif, $field) {
        foreach ($exif as $data) {
            if ($data['feature_name'] == $field)
                return 'enable';
        }
    }

    /**
     * Total Steps Modal - Top 5 Users's Steps
     */
    public function actionTotalStepsModal() {
        $game = PilotFrontUser::getGameID('leads');
        $user_id = Yii::$app->user->identity->id;
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 10;
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $totalsteps_model = new PilotFrontLeadsStepsApiData();
        //My Total Steps for Complete Challenge
        $user_total_steps = PilotFrontLeadsStepsApiData::getUserStepsforchallenge($user_id);
        //Top five Users Total Steps for Complete Challenge
        $all_users_total_steps = PilotFrontLeadsStepsApiData::getAllUsersStepsforchallenge();
        arsort($all_users_total_steps);

        $html = $this->renderAjax('game_modals', [
            'totalsteps_model' => $totalsteps_model,
            'user_total_steps' => $user_total_steps,
            'all_users_total_steps' => $all_users_total_steps,
        ]);
        return $html;
    }

    /**
     * Read the Congrats Modal on 10K Steps Reach
     */
    public function actionReadCongrats() {
        $user_id = $_POST['user_id'];
        $challenge_id = $_POST['challenge_id'];
        $steps = $_POST['steps'];
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $congratsModel = new PilotFrontLeadsStepsModal();
        $congratsModel->challenge_id = $challenge_id;
        $congratsModel->user_id = $user_id;
        $congratsModel->steps = $steps;
        $congratsModel->modal_shown = 'Yes';
        $congratsModel->modal_read = 'Yes';
        $congratsModel->dayset = $dayset;
        $congratsModel->created = time();
        $congratsModel->updated = time();
        $congratsModel->save(false);
        return 'success';
    }

    /**
     * Tech Support Action for Raised Tickets
     */
    public function actionTechSupport() {
        $this->layout = 'leads';
        $baseurl = Yii::$app->request->baseurl;
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        //User Team ID
        $team_id = Yii::$app->user->identity->team_id;

        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $model = new PilotFrontLeadsTechSupport();

        if (Yii::$app->request->post()):
            $postedData = Yii::$app->request->post()['PilotFrontLeadsTechSupport'];
            $username = $postedData['email'];
            $attc_path = 'NA';
            //Save the Ticket Details to Database 
            if (!Yii::$app->user->isGuest):
                $model->user_id = Yii::$app->user->identity->id;
                $username = Yii::$app->user->identity->username;
            endif;
            $model->email = $postedData['email'];
            $model->subject = $postedData['subject'];
            $model->message = $postedData['message'];
            $model->priority = $postedData['priority'];
            $model->challenge_id = $game_obj->id;
            $attachment = UploadedFile::getInstance($model, 'attachment');
            if (isset($attachment)) {
                if ($attachment->error == 0) {
                    $attachment_name = $attachment->baseName . '_' . time() . '.' . $attachment->extension;
                    $attachment->saveAs(Yii::getAlias('@uploads/tickets/' . $attachment_name));
                    $model->attachment = $attachment_name;
                    $attc_path = $baseurl . '/uploads/tickets/' . $attachment_name;
                }
            }
            $model->created = time();
            $model->updated = time();
            $model->save(false);
            $submitted_date = date("l F j, Y h:i:s A", $model->created);

            //dynamic company name
            $comp_id = Yii::$app->user->identity->company_id;
            $compObj = Company::find()->where(['id' => $comp_id])->one();

            //Send the Email to Support InoyGlobal (support@injoyglobal.com) for the new Ticket
            $send_email = Yii::$app
                    ->mailer
                    ->compose('send-ticket', ['model' => $model, 'username' => $username])
                    ->setFrom($postedData['email'])
                    ->setTo('support@injoyglobal.com')
                    ->setSubject($compObj->company_name . ' : Ticket has been raised')
                    ->send();


            $newModel = new PilotFrontLeadsTechSupport();
            Yii::$app->session->setFlash('success', 'Thank you for Contacting Us. Have a good day :)');
            return $this->render('tech_support', [
                        'model' => $newModel,
            ]);
        else:
            return $this->render('tech_support', [
                        'model' => $model,
            ]);
        endif;
    }

    /**
     * 
     * @return Smartphonel Modal
     */
    public function actionSmartphone() {
        $html = $this->renderAjax('smartphone_modal');
        return $html;
    }

    /**
     * 
     * @return user list for autocomplete on high-five search
     */
    public function actionUserlist() {
        $search = $_POST['query'];
        $comp_id = Yii::$app->user->identity->company_id;
        $challenge_id = Yii::$app->user->identity->challenge_id;
        $user_idlist = PilotFrontLeadsHighfive::find()->select('user_id')->where(['company_id' => $comp_id, 'game_id' => $challenge_id]);
//        echo "<pre>";print_r($user_idlist);die('sasas');
//        foreach($user_idlist as $user)
//        {
        $query = PilotFrontUser::find()->where(['id' => $user_idlist])->andFilterWhere(['like', 'username', $search])->all();
        //echo '<pre>';print_r($query);die;
//        }
        $newdata = [];
        foreach ($query as $value) {
            if (empty($value->profile_pic)) {
                $value->profile_pic = 'user_icon.jpg';
            }
            $newdata[] = ['name' => $value->username, 'img' => $value->profile_pic];
        }
        return json_encode($newdata);
    }

    // return all notification on new page

    public function actionSeeAll() {
        $this->layout = 'leads';
        $game = PilotFrontUser::getGameID('leads');

        $comp_id = Yii::$app->user->identity->company_id;
        $shareawins_all = PilotFrontLeadsNotifications::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id])->orderBy(['created' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $shareawins_all,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        return $this->render('see-all', [
                    'shareawins_all' => $dataProvider,
        ]);
    }

    public function actionDailyEmail() {
        $daily_email = new PilotFrontLeadsEmail;
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $dayset = date('Y-m-d');
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_current_day_no = PilotFrontUser::getGameDay($game_obj);
        $daily_category_id = $game_obj->daily_inspiration_content;
        $daily_inspiration_obj = PilotDailyinspirationImage::find()->where(['category_id' => $daily_category_id, 'order_number' => $game_current_day_no])->one();
        $daily_image_path = $daily_inspiration_obj->image_name;
        $message = '';
        $headers = [];
        if (Yii::$app->request->post()):
            $messagecontent = '<html><body><img src="' . Yii::getAlias('@back_end') . '/img/daily-inspiration-images/' . $daily_image_path . '"></body></html>';
            ;
            //$messagecontent ='hello';
            $send_email = Yii::$app
                    ->mailer
                    ->compose('send-image', ['model' => $_POST['message'], 'daily_image_path' => $daily_image_path])
                    ->setFrom('support@injoyglobal.com')
                    ->setTo($_POST['email_id'])
                    ->setSubject('Daily Inspiration Image')
                    ->send();
            if ($send_email == 1):
                $daily_email->email_id = $_POST['email_id'];
                $daily_email->message = json_encode($messagecontent);
                $daily_email->attachment = $daily_image_path;
                $daily_email->created = time();
                $daily_email->save(false);
                Yii::$app->session->setFlash('success', 'Image Shared Successfully.');
                return $this->redirect(['dashboard']);
            else:
                Yii::$app->session->setFlash('success', 'Image not Shared.');
                return $this->redirect(['dashboard']);
            endif;
        endif;
    }

    public function actionSaveRating() {

        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $html = '';
        if (Yii::$app->request->post()):
            $model = PilotFrontLeadsRating::find()->where(['user_id' => $user_id, 'dayset' => $dayset, 'company_id' => $comp_id, 'challenge_id' => $game_id])->one();
            if (empty($model)):
                $model = new PilotFrontLeadsRating;
                $model->challenge_id = $game_obj->id;
                $model->game_id = $game;
                $model->company_id = $comp_id;
                $model->user_id = $user_id;
                $model->value = Yii::$app->request->post()['PilotFrontLeadsRating']['value'];
                $model->dayset = $dayset;
                $model->week_no = $week_no;
                $model->created = time();
                $model->updated = time();
                if ($model->save(false)):
                    return 'the rating is saved for the day';
                endif;
            else:
                return 'the rating is already saved for the day';
            endif;
        endif;
    }

    public function actionHighFiveimages() {
        $this->layout = 'leads';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $subQuery1 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query1 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit(8);
        $all_highfiveImage = $query1->all();
        $query2 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
        $total_comment = $query2->count();
        return $this->render('highfiveimages', [
                    'all_highfiveImage' => $all_highfiveImage,
                    'total_comment' => $total_comment,
        ]);
    }

    public function actionLoadHighfiveImages() {
        $html = '';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $user_id = Yii::$app->user->identity->id;
        $subQuery1 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query1 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit(10);
        $all_highfiveImage = $query1->all();
        if (count($all_highfiveImage) == 0):
            $html .= '<input type="hidden" id="zerocomment" value="0"/>
                                        <div class="no-data hf"> 
                                            <h3 class="first"> Be the first one to Share an 5S in Action! </h3> 
                                        </div>';
        else:
            foreach ($all_highfiveImage as $hghfv1):
                $hf_cmnt_user = PilotFrontUser::findIdentity($hghfv1->user_id);
                $hf_cmnt_userName = $hf_cmnt_user->username;
                $hf_cmnt_userImage = $hf_cmnt_user->profile_pic;
                $hf_cmnt = $hghfv1->feature_value;
                if ($hf_cmnt_userImage == ''):
                    $hf_cmnt_userImagePath = '../images/user_icon.jpg';
                else:
                    $hf_cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $hf_cmnt_userImage;
                endif;
                $check_comment_liked = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv1->id, 'challenge_id' => $game_id])->one();
                if (empty($check_comment_liked)):
                    $lk_cls = 'not-liked';
                    $lk_img = 'highgivelike.png';
                else:
                    $lk_cls = 'liked';
                    $lk_img = 'highfivelike1.png';
                endif;
                //Total Likes of Each High Five Comment
                $total_likes = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv1->id, 'challenge_id' => $game_id])->all();
                $comment_image = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $hghfv1->id, 'challenge_id' => $game_id])->one();
                $cimg_path = $baseurl . '/uploads/high_five/' . $comment_image->feature_value;
                $html .= '<div class="grid-item" style="position: relative;">
                    <div class="grid-padding">
                        <div class="box-item" style="">
                            <img src="' . $cimg_path . '">
                            <p class="user_comment1">' . json_decode($hf_cmnt) . '</p>
                            <div class="image">
                                <div class="user_image">
                                    <img src="' . $hf_cmnt_userImagePath . '"/>
                                </div>
                                <p class="user_name">' . $hf_cmnt_userName . '</p>
                                <div onclick="highfivelike(' . $user_id . ',' . $hghfv1->id . ')" class="user_likeimage">
                                    <img class="' . $hghfv1->id . '" src="/images/' . $lk_img . '" style="border: medium none; height: 30px; width: 30px;"/>
                                </div>
                                <h6 class="user_like" id="' . $hghfv1->id . '">' . count($total_likes) . '</h6>
                            </div>
                        </div>
                    </div>
                </div>';
            endforeach;
        endif;
        return $html;
    }

    public function actionMoreHfComments() {
        $output = [];
        $count = $_POST['limit'];
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $subQuery = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $subQuery])->andWhere(['challenge_id' => $game_id])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit($count);
        $all_highfivecomment = $query->all();
        $fetched_comment = count($all_highfivecomment);
        $query1 = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $subQuery])->andWhere(['challenge_id' => $game_id])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
        $total_comment = $query1->count();
        $comment_option = '';
        $image_upload_shout = '';
        if (isset($_SESSION['core_Template']['features'])):
            $session_features = $_SESSION['core_Template']['features'];
            $comment_option = $this->search_features_array($session_features, 'Comment Option on Shout');
            $image_upload_shout = $this->search_features_array($session_features, 'Shout Image Upload');
        else: //Re-Enable Session if its Expired!!
            $session = Yii::$app->session;
            $challenge_features = explode(',', $game_obj->features);
            //Define Active Challenge Template - Features
            foreach ($challenge_features as $key => $val):
                $feature = \backend\models\PilotCreateGameFeatures::find()->where(['id' => $val])->one();
                $fea[] = [
                    'feature_id' => $feature->id,
                    'feature_name' => $feature->name
                ];
            endforeach;
            $session['core_Template'] = [
                'features' => $fea
            ];
            $session_features = $_SESSION['core_Template']['features'];
            $comment_option = $this->search_features_array($session_features, 'Comment Option on Shout');
            $image_upload_shout = $this->search_features_array($session_features, 'Shout Image Upload');
        endif;
        $html = $this->renderAjax('highfive_data', [
            'all_highfivecomment' => $all_highfivecomment,
            'comment_option' => $comment_option,
        ]);
        $output['html'] = $html;
        if (isset($_SESSION['shoutouts'])):
            $output['limit'] = $count;
            $session->remove('shoutouts');
        else:
            $output['limit'] = $count + 10;
        endif;
        if ($fetched_comment == $total_comment):
            $output['comments'] = 1;
        else:
            $output['comments'] = 0;
        endif;
        return json_encode($output);
    }

    /**
     * Returns Tagged Users List
     */
    public function actionTagList1() {
        $baseurl = Yii::$app->request->baseurl;
        if ($_POST) {
            $q = $_POST['searchword'];
            if (strpos($q, '@') !== false) {
                $q = str_replace("@", "", $q);
            } else if (strpos($q, '#') !== false) {
                $q = str_replace("#", "", $q);
            }
            /** Adding Wildcard Character * */
            $attachment = '%';
            $count = strlen($q);
            $pos = $count;
            $newstr = substr_replace($q, $attachment, $pos);
            /** End * */
            /** Query Database Table to Fetch the Users who need to Tag * */
            $company_id = Yii::$app->user->identity->company_id;
            $query = "SELECT * FROM pilot_front_user where company_id = '$company_id' and firstname LIKE '$newstr'";
            $find_tagged_users = PilotFrontUser::findBySql($query)->all();

            /** End * */
            if (empty($find_tagged_users)) {
                $h = '32px';
                $htm = ' <div class="display_box1" align="left">
    No Such User<br/>
</div>';
            } else {
                $no_u = count($find_tagged_users);
                $h = 'auto';
                $htm = "";
                $i = 1;
                foreach ($find_tagged_users as $tagged_user) {
                    $userID = $tagged_user['id'];
                    $fname = ucfirst($tagged_user['firstname']);
                    $lname = ucfirst($tagged_user['lastname']);
                    $prof_image = $tagged_user['profile_pic'];
                    if ($prof_image == ''):
                        $prof_image_path = '../images/default-user.png';
                    else:
                        $prof_image_path = $baseurl . '/uploads/thumb_' . $prof_image;
                    endif;
                    $htm .= '<div class="display_box1" align="left" onclick="append_data1(this)" >';
                    $htm .= '<img src="' . $prof_image_path . ' " class="tag-user-img"/>';
                    $htm .= '<a href="javascript:void(0)" class="addname" title=' . $fname . '&nbsp;' . $lname . ' user-id=' . $userID . '> ' . $fname . '&nbsp;' . $lname . ' </a><br/>';
                    $htm .= '</div>';
                    $i++;
                }
            }
            echo json_encode(array('htm' => $htm, 'height_dis' => $h));
        }
    }

    public function actionSaveHighfiveImageComment() {
        $i = 0;
        $html = '';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $team_id = Yii::$app->user->identity->team_id;

        //30 Game Points for shout out comments per day

        $sub_Query = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $Query = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $sub_Query])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id])->andWhere(['dayset' => $dayset])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
        $prev_highfives_currentday = $Query->all();
        $hf_points = 10;
        $count_hf = 0;
        if (!empty($prev_highfives_currentday)):
            $count_hf = count($prev_highfives_currentday);
            if ($count_hf < 3):
                $hf_points = 10;
            else:
                $hf_points = 0;
            endif;
        endif;
        //Game Points 5 Days Per Week - Shout Out Section
        $sum_week_points = 0;
        $sub_Query1 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'week_no' => $week_no, 'challenge_id' => $game_id])->select('linked_feature_id');
        $Query1 = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $sub_Query1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id, 'week_no' => $week_no])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
        $week_entries_points = $Query1->sum('points');
        if (!empty($week_entries_points)):
            $sum_week_points = $week_entries_points;
        endif;
        if ($sum_week_points >= 150):
            $hf_points = 0;
        endif;

        //Makeup Days entry  
        $subQuery5 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query5 = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $subQuery5])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id]);
        $total_points_highfive = $query5->sum('points');
        if (!empty($total_points_highfive) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
            $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
            //echo $total_gameday;
            $totalweek = $total_gameday / 7;
            $exactWeek = explode('.', $totalweek);
            $total_game_points = $exactWeek[0] * 5 * 30;
            if ($total_points_highfive >= $total_game_points):
                $hf_points = 0;
            endif;
        endif;
        //end here
        //Game points for 5s in action
        $subQuery2 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query2 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery2])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['week_no' => $week_no])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
        $all_highfiveImage1 = $query2->all();
        if (empty($all_highfiveImage1)):
            $pointsimage = 30;
        else:
            $pointsimage = 0;
        endif;
        //Makeup day entry for 5s in action
        //Makeup Days entry            
        $subQuery4 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query4 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery4])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'challenge_id' => $game_id]);
        $total_points_highfiveimage = $query4->sum('points');
        if (!empty($total_points_highfiveimage) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
            $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
            $totalweek = $total_gameday / 7;
            $exactWeek = explode('.', $totalweek);
            $total_game_points = $exactWeek[0] * 30;
            if ($total_points_highfiveimage >= $total_game_points):
                $pointsimage = 0;
            endif;
        endif;
        //end heres
        // $session = Yii::$app->session;
        $highfiveModel = new PilotFrontLeadsHighfive;
        $feature_label = 'highfiveComment';
        $feature_value = $_POST['feature_value'];
        $feature_serial = $_POST['serial'];
        $linked_feature_id = $_POST['linked_feature_id'];
        /* $checkModel = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'dayset' => $dayset])->one();
          if (empty($checkModel)): */
        $model = new PilotFrontLeadsHighfive;
        $model->game_id = $game;
        $model->challenge_id = $game_id;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->team_id = $team_id;
        $model->feature_label = $feature_label;
        $model->feature_value = json_encode($feature_value);
        $model->feature_serial = $feature_serial;
        $model->linked_feature_id = $linked_feature_id;
//                    if (Yii::$app->request->post('hf_image_status')):
//                        $type = PilotFrontLeadsHighfiveType::find()->where(['id' => 2])->one();
//                        $type->type = 1;
//                        $type->created = time();
//                        $type->save(false);
//                        $model->points = $pointsimage;
//                    else:
//                        $type = PilotFrontLeadsHighfiveType::find()->where(['id' => 2])->one();
//                        $type->type = 0;
//                        $type->created = time();
//                        $type->save(false);
//                        $model->points = $hf_points;
//                    endif;
        if (isset($_SESSION['hf_cmnt_img'])):
            $model->points = $pointsimage;
        else:
            $model->points = $hf_points;
        endif;
        $model->week_no = $week_no;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save(false);
        $savedmodel_id = $model->id;
        $i++;
        //Save Image Uploaded with Comment
        if (isset($_SESSION['hf_cmnt_img'])):
            $image_model = new PilotFrontLeadsHighfive;
            $image_model->game_id = $game;
            $image_model->challenge_id = $game_id;
            $image_model->user_id = $user_id;
            $image_model->company_id = $comp_id;
            $image_model->team_id = $team_id;
            $image_model->feature_label = 'highfiveCommentImage';
            $image_model->feature_value = $_SESSION['hf_cmnt_img'];
            $image_model->feature_serial = '1';
            $image_model->linked_feature_id = $savedmodel_id;
            $image_model->points = 0;
            $image_model->week_no = $week_no;
            $image_model->dayset = $dayset;
            $image_model->created = time();
            $image_model->updated = time();
            $image_model->save(false);
            $i++;
        endif;
        //Save Notification for User in pilot_front_notifications Table
        $cmnt = $feature_value;
        preg_match_all("/data-uid=\"(.*?)\"/i", $cmnt, $matches);

        if (!empty($matches)):
            foreach ($matches[1] as $key => $tagged_uid):
                $cmnt_val = json_encode($feature_value);
//              echo $cmnt_val;echo '<br>';
                $comment_val = json_decode($cmnt_val);
                $max_length = 25;
//              echo $comment_val;echo '<br>';
//              if (strlen($comment_val) > $max_length):
//                $offset = ($max_length - 3) - strlen($comment_val);
//                $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
//              endif;
//              echo $comment_val;echo '<br>';
                // $comment_val = str_replace("<br>", " ", $comment_val);
//              echo $comment_val;echo '<br>';
//              die;
                $tagged_user = PilotFrontUser::findIdentity($tagged_uid);

                $hf_comment_user = PilotFrontUser::findIdentity($user_id);
                $hf_comment_userName = $hf_comment_user->username;

                $notif_value = json_encode('<b>' . $hf_comment_userName . '</b> has tagged you in a comment <a href="javascript:void(0)">' . $comment_val . '</a>');
                //Save Other Users Activity not Own
                if ($tagged_uid != $user_id):
                    $notif_model = new PilotFrontLeadsNotifications;
                    $notif_model->game_id = $game;
                    $notif_model->challenge_id = $game_id;
                    $notif_model->user_id = $tagged_uid;
                    $notif_model->company_id = $comp_id;
                    $notif_model->notif_type_id = $savedmodel_id;
                    $notif_model->notif_type = 'highfiveComment';
                    $notif_model->notif_value = $notif_value;
                    $notif_model->activity_user_id = $user_id;
                    $notif_model->notif_status = 1;
                    $notif_model->dayset = $dayset;
                    $notif_model->created = time();
                    $notif_model->updated = time();
                    $notif_model->save(false);
                    $i++;
                endif;
            endforeach;
        endif;
        if ($i >= 2 && isset($_SESSION['hf_cmnt_img'])):
            $session = Yii::$app->session;
            $session->remove('hf_cmnt_img');
            $feature_serial++;
            $output['count'] = $i;
            $output['serial'] = $feature_serial;
            $subQuery1 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
            $query1 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['challenge_id' => $game_id])->andWhere(['week_no' => $week_no])->andWhere(['user_id' => $user_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
            $all_highfiveImage1 = $query1->all();
            if (empty($all_highfiveImage1)):
                $hf_cls = 'unchecked';
            else:
                $hf_cls = 'checked';
            endif;
            $output['hf_cls'] = $hf_cls;
            return json_encode($output);
        elseif ($i <= 2):
            $session = Yii::$app->session;
            $session->set('shououtcomment', 1);
            $feature_serial++;
            $output['count'] = $i;
            $output['serial'] = $feature_serial;
            $sub_Query = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
            $Query = PilotFrontLeadsHighfive::find()->where(['not in', 'id', $sub_Query])->andWhere(['challenge_id' => $game_id])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id])->andWhere(['dayset' => $dayset])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
            $prev_highfives_currentday = $Query->all();
            $count_hf = 0;
            if (!empty($prev_highfives_currentday)):
                $count_hf = count($prev_highfives_currentday);
                $output['count_hf'] = $count_hf;
            endif;
            return json_encode($output);
        endif;
        //endif;
    }

    public function actionLoadmoreHighfiveImages() {
        $output = [];
        $count = $_POST['count'];
        $offset = $_POST['offset'];
        $html = '';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $user_id = Yii::$app->user->identity->id;
        $subQuery1 = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query1 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit(5)->offset($offset);
        $all_highfiveImage = $query1->all();

        // total 5S's
        $query2 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
        $total_comment = $query2->count();
        //end 5S's.
        $count1 = $offset + 5;
        $query3 = PilotFrontLeadsHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit($count1);
        $fetched_comment = $query3->count();
        if (count($all_highfiveImage) == 0):
            $output['html'] = $html;
            if ($total_comment == $fetched_comment):
                $output['limit'] = 1;
            else:
                $output['limit'] = 0;
            endif;
            $output['count'] = $count;
            $output['offset'] = $offset;
            return json_encode($output);
        else:
            foreach ($all_highfiveImage as $hghfv1):
                $hf_cmnt_user = PilotFrontUser::findIdentity($hghfv1->user_id);
                $hf_cmnt_userName = $hf_cmnt_user->username;
                $hf_cmnt_userImage = $hf_cmnt_user->profile_pic;
                $hf_cmnt = $hghfv1->feature_value;
                if ($hf_cmnt_userImage == ''):
                    $hf_cmnt_userImagePath = '../images/user_icon.jpg';
                else:
                    $hf_cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $hf_cmnt_userImage;
                endif;
                $check_comment_liked = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv1->id, 'challenge_id' => $game_id])->one();
                if (empty($check_comment_liked)):
                    $lk_cls = 'not-liked';
                    $lk_img = 'highgivelike.png';
                else:
                    $lk_cls = 'liked';
                    $lk_img = 'highfivelike1.png';
                endif;
                //Total Likes of Each High Five Comment
                $total_likes = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv1->id, 'challenge_id' => $game_id])->all();
                $comment_image = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $hghfv1->id, 'challenge_id' => $game_id])->one();
                $cimg_path = $baseurl . '/uploads/high_five/' . $comment_image->feature_value;
                $html .= '<div class="grid-item" style="position: relative;">
                    <div class="grid-padding">
                        <div class="box-item" style="">
                            <img src="' . $cimg_path . '">
                            <p class="user_comment1">' . json_decode($hf_cmnt) . '</p>
                            <div class="image">
                                <div class="user_image">
                                    <img src="' . $hf_cmnt_userImagePath . '"/>
                                </div>
                                <p class="user_name">' . $hf_cmnt_userName . '</p>
                                <div onclick="highfivelike(' . $user_id . ',' . $hghfv1->id . ')" class="user_likeimage">
                                    <img class="' . $hghfv1->id . '" src="/images/' . $lk_img . '" style="border: medium none; height: 30px; width: 30px;"/>
                                </div>
                                <h6 class="user_like" id="' . $hghfv1->id . '">' . count($total_likes) . '</h6>
                            </div>
                        </div>
                    </div>
                </div>';
            endforeach;
        endif;
        $output['html'] = $html;
        if ($total_comment == $fetched_comment):
            $output['limit'] = 1;
        else:
            $output['limit'] = 0;
        endif;
        $output['count'] = $count + 5;
        $output['offset'] = $offset + 5;
        return json_encode($output);
    }
    public function actionWeekly() {
        $this->layout = 'leads';
        $game = PilotFrontUser::getGameID('leads');
        $user_id = Yii::$app->user->identity->id;
        $comp_id = Yii::$app->user->identity->company_id;
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);

        //Current Week Tips Variables
        $week_leadership = 'Week ' . $week_no;
        $tip_no1 = $week_leadership . '-one';
        $tip_no2 = $week_leadership . '-two';
        $tip_no3 = $week_leadership . '-three';
        $week_pattern = $week_leadership . '%';

        $weekly_challenge_id = $game_obj->weekly_challenge_content;

        $leadership_tips = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_challenge_id])
                ->andFilterWhere(['!=', 'week', $week_no])
                ->orderBy(['id' => SORT_DESC])
                ->all();

        //Leadership Corner
        $leadership_entry_weekly = PilotFrontLeadsWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->all();



        if (empty($leadership_entry_weekly)):
            $current_week_leadership_tips = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_challenge_id])
                    ->andWhere(['=', 'week', $week_no])
                    ->orderBy(['id' => SORT_DESC])
                    ->all();
        else:
            $current_week_leadership_tips = PilotWeeklyChallenge::find()->where(['category_id' => $weekly_challenge_id])
                    ->andWhere(['=', 'week', $week_no])
                    ->orderBy(['id' => SORT_DESC])
                    ->all();
        endif;
        return $this->render('weekly', [
                    'leadership_tips' => $leadership_tips,
                    'current_week_leadership_tips' => $current_week_leadership_tips,
                    'week_no' => $week_no,
        ]);
    }
    public function actionSaveHighfiveComment() {
        $i = 0;
        $html = '';
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $team_id = Yii::$app->user->identity->team_id;
        $prev_highfives_currentday = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
        $hf_points = 10;
        $count_hf = 0;
        if (!empty($prev_highfives_currentday)):
            $count_hf = count($prev_highfives_currentday);
            if ($count_hf < 3):
                $hf_points = 10;
            else:
                $hf_points = 0;
            endif;
        endif;

        //Game Points 5 Days Per Week - Shout Out Section
        $sum_week_points = 0;
        $week_entries_points = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no])
                ->sum('points');
        if (!empty($week_entries_points)):
            $sum_week_points = $week_entries_points;
        endif;
        if ($sum_week_points >= 150):
            $hf_points = 0;
        endif;

        //Makeup Days entry           
        $total_points_highfive = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->sum('points');
        if (!empty($total_points_highfive) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
            $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
            //echo $total_gameday;
            $totalweek = $total_gameday / 7;
            $exactWeek = explode('.', $totalweek);
            $total_game_points = $exactWeek[0] * 5 * 30;
            if ($total_points_highfive >= $total_game_points):
                $hf_points = 0;
            endif;
        endif;
        //end here
        // $session = Yii::$app->session;
        $highfiveModel = new PilotFrontLeadsHighfive;
        $feature_label = 'highfiveComment';
        $feature_value = $_POST['feature_value'];
        $feature_serial = $_POST['serial'];
        $linked_feature_id = $_POST['linked_feature_id'];
        /* $checkModel = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'dayset' => $dayset])->one();
          if (empty($checkModel)): */
        $model = new PilotFrontLeadsHighfive;
        $model->game_id = $game;
        $model->challenge_id = $game_id;
        $model->user_id = $user_id;
        $model->company_id = $comp_id;
        $model->team_id = $team_id;
        $model->feature_label = $feature_label;
        $model->feature_value = json_encode($feature_value);
        $model->feature_serial = $feature_serial;
        $model->linked_feature_id = $linked_feature_id;

        $model->points = $hf_points;
        $model->week_no = $week_no;
        $model->dayset = $dayset;
        $model->created = time();
        $model->updated = time();
        $model->save(false);
        $savedmodel_id = $model->id;
        $i++;
        //Save Image Uploaded with Comment
        if (isset($_SESSION['hf_cmnt_img'])):
            $image_model = new PilotFrontLeadsHighfive;
            $image_model->game_id = $game;
            $image_model->challenge_id = $game_id;
            $image_model->user_id = $user_id;
            $image_model->company_id = $comp_id;
            $image_model->team_id = $team_id;
            $image_model->feature_label = 'highfiveCommentImage';
            $image_model->feature_value = $_SESSION['hf_cmnt_img'];
            $image_model->feature_serial = '1';
            $image_model->linked_feature_id = $savedmodel_id;
            $image_model->points = 0;
            $image_model->week_no = $week_no;
            $image_model->dayset = $dayset;
            $image_model->created = time();
            $image_model->updated = time();
            $image_model->save(false);
            $i++;
        endif;
        //Save Notification for User in pilot_front_notifications Table
        $cmnt = $feature_value;
        preg_match_all("/data-uid=\"(.*?)\"/i", $cmnt, $matches);

        if (!empty($matches)):
            foreach ($matches[1] as $key => $tagged_uid):
                $cmnt_val = json_encode($feature_value);
//              echo $cmnt_val;echo '<br>';
                $comment_val = json_decode($cmnt_val);
                $max_length = 25;
//              echo $comment_val;echo '<br>';
//              if (strlen($comment_val) > $max_length):
//                $offset = ($max_length - 3) - strlen($comment_val);
//                $comment_val = substr($comment_val, 0, strrpos($comment_val, ' ', $offset)) . '...';
//              endif;
//              echo $comment_val;echo '<br>';
                // $comment_val = str_replace("<br>", " ", $comment_val);
//              echo $comment_val;echo '<br>';
//              die;
                $tagged_user = PilotFrontUser::findIdentity($tagged_uid);

                $hf_comment_user = PilotFrontUser::findIdentity($user_id);
                $hf_comment_userName = $hf_comment_user->username;

                $notif_value = json_encode('<b>' . $hf_comment_userName . '</b> has tagged you in a comment <a href="javascript:void(0)">' . $comment_val . '</a>');
                //Save Other Users Activity not Own
                if ($tagged_uid != $user_id):
                    $notif_model = new PilotFrontLeadsNotifications;
                    $notif_model->game_id = $game;
                    $notif_model->challenge_id = $game_id;
                    $notif_model->user_id = $tagged_uid;
                    $notif_model->company_id = $comp_id;
                    $notif_model->notif_type_id = $savedmodel_id;
                    $notif_model->notif_type = 'highfiveComment';
                    $notif_model->notif_value = $notif_value;
                    $notif_model->activity_user_id = $user_id;
                    $notif_model->notif_status = 1;
                    $notif_model->dayset = $dayset;
                    $notif_model->created = time();
                    $notif_model->updated = time();
                    $notif_model->save(false);
                    $i++;
                endif;
            endforeach;
        endif;
        if ($i >= 2 && isset($_SESSION['hf_cmnt_img'])):
            $session = Yii::$app->session;
        $session->set('shououtcomment', 1);
            $session->remove('hf_cmnt_img');
            $feature_serial++;
            $output['count'] = $i;
            $output['serial'] = $feature_serial;
            $prev_highfives_currentday = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
            $count_hf = 0;
            if (!empty($prev_highfives_currentday)):
                $count_hf = count($prev_highfives_currentday);
                $output['count_hf'] = $count_hf;
            endif;
            return json_encode($output);
        elseif ($i <= 2):
            $session = Yii::$app->session;
            $session->set('shououtcomment', 1);
            $feature_serial++;
            $output['count'] = $i;
            $output['serial'] = $feature_serial;
            $prev_highfives_currentday = PilotFrontLeadsHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
            $count_hf = 0;
            if (!empty($prev_highfives_currentday)):
                $count_hf = count($prev_highfives_currentday);
                $output['count_hf'] = $count_hf;
            endif;
            return json_encode($output);
        endif;
        //endif;
    }
    public function actionShareData() {
        $game = PilotFrontUser::getGameID('leads');
        $comp_id = Yii::$app->user->identity->company_id;
        $shareawins_all = PilotFrontLeadsShareawin::find()
                        ->where(['game_id' => $game, 'pilot_front_leads_shareawin.company_id' => $comp_id])
                        ->joinWith('userinfo')
                        ->orderBy(['id' => SORT_DESC])->limit(5)->all();
        $html = $this->renderAjax('share_data', [
            'shareawins_all' => $shareawins_all
        ]);
        return $html;
    }

    public function actionCoreData() {
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('leads');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //User Team ID
        $team_id = Yii::$app->user->identity->team_id;
        $timezone = Yii::$app->user->identity->timezone;
        $dayset = date('Y-m-d');
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $feature_array = explode(',', $game_obj->features);
        $game_id = $game_obj->id;
        $ratesaved = PilotFrontLeadsRating::find()->where(['user_id' => $user_id, 'dayset' => $dayset, 'company_id' => $comp_id])->one();
        $prev_today_values_currentday = PilotFrontLeadsCheckin::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset])
                        ->andWhere(['!=', 'label', 'core_values_popup'])->orderBy(['created' => SORT_DESC])->all();
        $count_tv = 0;
        if (!empty($prev_today_values_currentday)):
            $count_tv = count($prev_today_values_currentday);
            if ($count_tv < 2):
                $tv_points = 20;
            else:
                $tv_points = 0;
            endif;
        endif;
        $html = $this->renderAjax('core_data', [
            'prev_today_values_currentday' => $prev_today_values_currentday,
            'feature_array' => $feature_array,
            'count_tv' => $count_tv,
            'game_obj' => $game_obj,
            'ratesaved' => $ratesaved
        ]);
        return $html;
    }
     public function actionClearSession() {
        if (isset($_SESSION['hf_cmnt_img'])):
            $session = Yii::$app->session;
            $session->remove('hf_cmnt_img');
            return 'Session Removed';
        else:
            return 'No Session Set';
        endif;
    }
}
