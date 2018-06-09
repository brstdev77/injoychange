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
use frontend\models\PilotFrontIntentionalleadershipDailyinspiration;
use frontend\models\PilotFrontIntentionalleadershipHighfive;
use frontend\models\PilotFrontIntentionalleadershipHighfiveSearch;
use frontend\models\PilotFrontUser;
use frontend\models\PilotFrontIntentionalleadershipNotifications;
use frontend\models\PilotFrontIntentionalleadershipTotalPoints;
use frontend\models\PilotFrontIntentionalleadershipSurveyData;
use frontend\models\PilotFrontIntentionalleadershipTechSupport;
use frontend\models\PilotFrontIntentionalleadershipWeeklychallenge;
use frontend\models\PilotFrontIntentionalleadershipKnowcorner;
use frontend\models\PilotFrontIntentionalleadershipQuestion;
use backend\models\Company;
use backend\models\PilotCreateGame;
use backend\models\PilotDailyinspirationImage;
use backend\models\PilotWeeklyChallenge;
use backend\models\PilotActionmattersChallenge;
use backend\models\PilotLeadershipCorner;
use backend\models\PilotDidyouknowCorner;
use backend\models\PilotGettoknowCorner;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\PilotSurveyQuestion;
use backend\models\PilotTodayslessonCorner;
use yii\filters\auth\HttpBasicAuth;
use frontend\models\PilotFrontIntentionalleadershipEmail;

/**
 * TeamworkController implements the CRUD actions for Teamwork model.
 */
class IntentionalleadershipController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'index', 'view', 'create', 'update', 'delete', 'dashboard', 'daily-modal', 'highfive-like', 'tag-list', 'high-five', 'highfive-usercomment-modal', 'get-notifications', 'notification-status', 'highfive-image-upload', 'highfive-image-zoom-modal', 'get-user-points', 'get-company-users-points', 'leaderboard-points-modal', 'welcome', 'toolbox', 'skip-survey', 'leaderboard', 'tech-support', 'set-notifications-status', 'see-all', 'thankyou', 'daily-email', 'how-it-work', 'save-highfive-image-comment', 'know-modal', 'skip-survey', 'get-user-points', 'toolbox', 'play-audio', 'know-the-team', 'leaderboard', 'weekly-modal', 'clear-session'],
                'rules' => [
                    [
                        'actions' => ['signup', 'index', 'api-login-token', 'post-api-data'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'dashboard', 'daily-modal', 'highfive-like', 'tag-list', 'logout', 'high-five', 'highfive-usercomment-modal', 'get-notifications', 'notification-status', 'highfive-image-upload', 'highfive-image-zoom-modal', 'get-user-points', 'get-company-users-points', 'leaderboard-points-modal', 'welcome', 'toolbox', 'skip-survey', 'leaderboard', 'tech-support', 'set-notifications-status', 'see-all', 'thankyou', 'daily-email', 'how-it-work', 'save-highfive-image-comment', 'know-modal', 'skip-survey', 'get-user-points', 'toolbox', 'play-audio', 'know-the-team', 'leaderboard', 'weekly-modal', 'clear-session'],
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
     * 
     * @return mixed
     */
    public function actionIndex() {
        $this->layout = 'intentionalleadership';
        return $this->render('index');
    }

    //display dashboard page

    public function actionDashboard() {
        $this->layout = 'intentionalleadership';
        $challenge_id = Yii::$app->user->identity->challenge_id;
        $check_challenge = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => Yii::$app->user->identity->company_id, 'status' => [0, 1]])->one();
        //echo '<pre>';print_r($check_challenge);die;
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
            if ($challenge_id != '11' && $challenge_id != 0) {
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

        if ($check_comp != $comp_check):
//            $session->set('company_logo', $company_obj->image);
//            $session->set('company_name', $check_comp);
//            $session->set('comp_name', $company_obj->company_name);
//            $session->set('company_id', $company_obj->id);
        //return $this->redirect('http://' . $check_comp . '.injoychange.com/service/dashboard');
        endif;

        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('intentionalleadership');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //User Team ID
        $team_id = Yii::$app->user->identity->team_id;
        $timezone = Yii::$app->user->identity->timezone;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        //echo '<pre>';print_r($game_obj);die;
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
                    return $this->redirect(Url::to(['/intentionalleadership/welcome']));
                else:
                    return $this->redirect(Url::to(['/intentionalleadership/thankyou']));
                    return $this->goBack();
                endif;
            else:
                return $this->redirect(Url::to(['/intentionalleadership/thankyou']));
                return $this->goBack();
            endif;
        else: //If there is Ongoing Challenge
            $week_no = PilotFrontUser::getGameWeek($game_obj);

            $game_id = $game_obj->id;
            $game_start_date_timestamp = $game_obj->challenge_start_date;
            $game_end_date_timestamp = $game_obj->challenge_end_date;
            //date_default_timezone_set($timezone);
            //date_default_timezone_set('America/Los_Angeles');
            $dayset = date('Y-m-d');
            //Daily Inspiration
            $daily_entry = PilotFrontIntentionalleadershipDailyinspiration::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset])->one();
            $all_highfives = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit(20)->all();
            $prev_highfives_currentday = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
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
            $highfiveModel = new PilotFrontIntentionalleadershipHighfive;
            //Audio Challenge

            $audio_entry_weekly = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->all();
            $audio_entry_currentday = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            $audio_entry_first = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'first', 'challenge_id' => $game_id])->one();
            $audio_entry_sec = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'second', 'challenge_id' => $game_id])->one();
            $audio_entry_third = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'third', 'challenge_id' => $game_id])->one();

            // did you know corner

            $know_entry_weekly = PilotFrontIntentionalleadershipKnowcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->all();
            $know_entry_currentday = PilotFrontIntentionalleadershipKnowcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
            $know_entry_first = PilotFrontIntentionalleadershipKnowcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'first', 'challenge_id' => $game_id])->one();
            $know_entry_sec = PilotFrontIntentionalleadershipKnowcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'second', 'challenge_id' => $game_id])->one();

            // Question Corner
            $answer_entry_weekly = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->all();
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
                    $feedback_given = PilotFrontIntentionalleadershipSurveyData::find()->where(['challenge_id' => $game_obj->id, 'user_id' => $user_id, 'survey_filled' => 'Yes'])->all();
                    if (empty($feedback_given)):
                        //Check whelther User has skipped the Feedback Survey Form for Current Day
                        $feedback_skipped = PilotFrontIntentionalleadershipSurveyData::find()->where(['challenge_id' => $game_obj->id, 'user_id' => $user_id, 'survey_filled' => 'No', 'dayset' => $dayset])->one();
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
            if (Yii::$app->request->post('PilotFrontIntentionalleadershipSurveyData')):
                $skipped_entry = PilotFrontIntentionalleadershipSurveyData::find()->where(['challenge_id' => $game_obj->id, 'user_id' => $user_id, 'survey_filled' => 'No'])->one();
                if (!empty($skipped_entry)):
                    $skipped_entry->delete();
                endif;
                $surveyPostedData = Yii::$app->request->post('PilotFrontIntentionalleadershipSurveyData');
                $survey_posted_questions = $surveyPostedData['survey_question_id'];
                $survey_posted_responses = $surveyPostedData['survey_response'];
                $survey_permission = $surveyPostedData['permission_use_data'];
                foreach ($survey_posted_questions as $key => $q_id):
                    $surveyModel = new PilotFrontIntentionalleadershipSurveyData();
                    $surveyModel->challenge_id = $game_obj->id;
                    $surveyModel->user_id = $user_id;
                    $surveyModel->survey_filled = 'Yes';
                    $surveyModel->survey_question_id = $q_id;
                    if (!empty($survey_posted_responses[$key])):
                        $surveyModel->survey_response = $survey_posted_responses[$key];
                    else:
                        $surveyModel->survey_response = $_POST['option' . $key];
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
            return $this->render('dashboard', [
                        'daily_entry' => $daily_entry,
                        'all_highfives' => $all_highfives,
                        'all_highfives' => $all_highfives,
                        'highfiveModel' => $highfiveModel,
                        'prev_highfives_currentday' => $prev_highfives_currentday,
                        'count_hf' => $count_hf,
                        'comment_option' => $comment_option,
                        'image_upload_shout' => $image_upload_shout,
                        'audio_entry_weekly' => $audio_entry_weekly,
                        'audio_entry_currentday' => $audio_entry_currentday,
                        'audio_entry_first' => $audio_entry_first,
                        'audio_entry_sec' => $audio_entry_sec,
                        'audio_entry_third' => $audio_entry_third,
                        'know_entry_weekly' => $know_entry_weekly,
                        'know_entry_currentday' => $know_entry_currentday,
                        'know_entry_first' => $know_entry_first,
                        'know_entry_sec' => $know_entry_sec,
                        'show_survey' => $show_survey,
                        'survey_questions_arr' => $survey_questions_arr,
                        'answer_entry_weekly' => $answer_entry_weekly,
            ]);
        endif;
    }

    public function actionDailyInspiration() {
        $this->layout = 'intentionalleadership';
        $game = PilotFrontUser::getGameID('intentionalleadership');
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

    public function actionHighFive() {
        $this->layout = 'intentionalleadership';
        $comp_id = Yii::$app->user->identity->company_id;
        $query = PilotFrontUser::find()->where(['company_id' => $comp_id])->all();
        $userData = ArrayHelper::map($query, 'id', 'username');
        $searchModel = new PilotFrontIntentionalleadershipHighfiveSearch();
        $game = PilotFrontUser::getGameID('intentionalleadership');
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

    public function actionHowItWork() {
        $this->layout = 'intentionalleadership';
        return $this->render('howitwork');
    }

    public function actionDailyModal() {
        $game = PilotFrontUser::getGameID('intentionalleadership');
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
        $points = 20;
        $week_entries = PilotFrontIntentionalleadershipDailyinspiration::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->all();
        $count_week_entr = count($week_entries);
        if ($count_week_entr >= 5):
            $points = 0;
            $message = "Saved Successfully. But you don't get any points as you had already taken maximum points for this week for daily inspiration section.";
        endif;

        //Makeup Days entry
        $total_points_dailyInsp = PilotFrontIntentionalleadershipDailyinspiration::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id])
                ->sum('points');
        if (!empty($game_obj->makeup_days)):
            if (!empty($total_points_dailyInsp) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $totalweek = $total_gameday / 7;
                $exactWeek = explode('.', $totalweek);
                $total_game_points = $exactWeek[0] * 5 * 20;
                if ($total_points_dailyInsp >= $total_game_points):
                    $points = 0;
                endif;
            endif;
        endif;
        //end here

        $daily_model = new PilotFrontIntentionalleadershipDailyinspiration;
        $daily_email = new PilotFrontIntentionalleadershipEmail;
        $daily_entry = PilotFrontIntentionalleadershipDailyinspiration::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'dayset' => $dayset])->one();
        if (Yii::$app->request->post()):
            $user_id = $_POST['user_id'];
            $dayset = $_POST['dayset'];
            $checkModel = PilotFrontIntentionalleadershipDailyinspiration::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'dayset' => $dayset])->one();
            if (empty($checkModel)):
                $model = new PilotFrontIntentionalleadershipDailyinspiration;
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
            Yii::$app->end();
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
     * Implements High five Likes
     */
    public function actionHighfiveLike() {
        $game = PilotFrontUser::getGameID('intentionalleadership');
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
        $checkModel = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'linked_feature_id' => $linked_feature_id])->one();
        if (empty($checkModel)):
            $model = new PilotFrontIntentionalleadershipHighfive;
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
            $linked_feature_user_model = PilotFrontIntentionalleadershipHighfive::find()->where(['id' => $linked_feature_id])->one();
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
            $notif_value = '<b>' . $hf_like_userName . '</b> high fived your comment <a href="javascript:void(0)">' . $comment_val . '</a>';

            //Save Other Users Activity not Own
            if ($linked_feature_user->id != $user_id):
                $notif_model = new PilotFrontIntentionalleadershipNotifications;
                $model->challenge_id = $game_id;
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
        $total_likes = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $linked_feature_id])->all();
        echo json_encode(['status' => 'success', 'likes' => count($total_likes), 'hand_img' => 'hand-orange.png']);
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
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $img_id = Yii::$app->request->get('img_id');
        $feature_label = 'highfiveCommentImage';
        $zoomImage = PilotFrontIntentionalleadershipHighfive::find()->where(['id' => $img_id])->one();
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
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 10;
        $usercomment_model = new PilotFrontIntentionalleadershipHighfive;
        $user_id = Yii::$app->request->get()['uid'];
        $comment_id = Yii::$app->request->get()['cid'];
        $feature_label = 'highfiveComment';
        $commentValue = PilotFrontIntentionalleadershipHighfive::find()->where(['id' => $comment_id])->one();
        $commentImages = PilotFrontIntentionalleadershipHighfive::find()->where(['feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $comment_id])->all();
        $userComments = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $comment_id])
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
        $game = PilotFrontUser::getGameID('intentionalleadership');
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
        $checkModel = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'feature_serial' => $feature_serial, 'linked_feature_id' => $linked_feature_id])->one();
        $html = '';
        if (empty($checkModel)):
            $model = new PilotFrontIntentionalleadershipHighfive;
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
            $linked_feature_user_model = PilotFrontIntentionalleadershipHighfive::find()->where(['id' => $linked_feature_id])->one();
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
                $notif_model = new PilotFrontIntentionalleadershipNotifications;
                $notif_model->game_id = $game;
                $model->challenge_id = $game_id;
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
        $allComments = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'linked_feature_id' => $linked_feature_id])
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
            $total_comments = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $team_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $linked_feature_id])->all();
        else:
            $total_comments = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $linked_feature_id])->all();
        endif;

        echo json_encode(array('html' => $html, 'cmnt_serial' => $cmnt_serial, 'total_comments' => count($total_comments), 'status' => 'success'));
    }

    /**
     * 
     * Fetch the Notifications 
     */
    public function actionGetNotifications() {
        $baseurl = Yii::$app->request->baseurl;
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $cmnt_points = 0;
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $user_notifs = PilotFrontIntentionalleadershipNotifications::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])->orderBy(['id' => SORT_DESC])->all();
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
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $cmnt_points = 0;
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $user_notifs = PilotFrontIntentionalleadershipNotifications::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])->orderBy(['id' => SORT_DESC])->all();
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
        $notif_model = PilotFrontIntentionalleadershipNotifications::find()->where(['id' => $notif_id])->one();
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

    public function actionWelcome() {
        $this->layout = 'intentionalleadership';
        $company_id = Yii::$app->user->identity->company_id;
        $challenge_id = Yii::$app->user->identity->challenge_id;
        //$company = Company::find()->where(['id' => $company_id])->one();
        $current_time = time();
        $currentdate = date("m-d-Y", $current_time);
        $gamemodel = PilotCreateGame::find()->where(['challenge_company_id' => $company_id, 'challenge_id' => $challenge_id, 'status' => 1])->one();
        if (!empty($gamemodel)):
            if (((date("m-d-Y", $gamemodel->challenge_start_date)) <= $currentdate)) {
                return $this->redirect(Url::to(['/intentionalleadership/dashboard']));
            }
        endif;
        return $this->render('welcome');
    }

    public function actionAudioModal() {
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 30;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $tip_pos = Yii::$app->request->get()['tip'];
        $audio_model = new PilotFrontIntentionalleadershipWeeklychallenge;
        $audio_entry = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos, 'challenge_id' => $game_id])->one();
        if ($_POST):
            $user_id = Yii::$app->user->identity->id;
            $tip_pos = $_POST['tip_pos'];
            $comment = $_POST['comment'];
            $answer = $_POST['answer'];
            $dayset = $dayset;
            $checkModel = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos, 'challenge_id' => $game_id])->one();

            //Makeup Days entry            
            $total_points_leadership = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->sum('points');
            if (!empty($game_obj->makeup_days)):
                if (!empty($total_points_leadership) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                    $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                    $totalweek = $total_gameday / 7;
                    $exactWeek = explode('.', $totalweek);
                    $total_game_points = $exactWeek[0] * 90;
                    if ($total_points_leadership >= $total_game_points):
                        $points = 0;
                    endif;
                endif;
            endif;
            //end here
            if (empty($checkModel)):
                $model = new PilotFrontIntentionalleadershipWeeklychallenge;
                $model->challenge_id = $game_id;
                $model->game_id = $game;
                $model->user_id = $user_id;
                $model->company_id = $comp_id;
                $model->week_no = $week_no;
                $model->comment = json_encode($comment);
                $model->correct_id = $answer;
                $model->tip_pos = $tip_pos;
                $model->points = $points;
                $model->dayset = $dayset;
                $model->created = time();
                $model->updated = time();
                $model->save(false);
            else:
                $checkModel->comment = json_encode($comment);
                $checkModel->tip_pos = $tip_pos;
                $checkModel->points = $points;
                $checkModel->updated = time();
                $checkModel->save(false);
                return 'Comment Updated Successfully.';
            endif;
            return 'Comment Saved Successfully.';
            Yii::$app->end();
        else:
            //Fetch the Leadership Content for Tip Position & Current Week 
            $week_leadership = 'Week ' . $week_no;
            if ($tip_pos == 'first'):
                $tip_no = $week_leadership . '-one';
            elseif ($tip_pos == 'second'):
                $tip_no = $week_leadership . '-two';
            elseif ($tip_pos == 'third'):
                $tip_no = $week_leadership . '-three';
            endif;
            $leadership_category_id = $game_obj->todays_lesson_content;
            $leadership_tip_obj = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
            if (empty($leadership_tip_obj)):
                $leadership_challenge1 = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_category_id])->count();
                $weeks = PilotFrontUser::numofweeks($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $total_weeks_data = $leadership_challenge1;
                $week_no = PilotFrontUser::getweek($week_no * 3, $total_weeks_data);
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
                $leadership_tip_obj = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
            endif;
            $html = $this->renderAjax('game_modals', [
                'audio_model' => $audio_model,
                'audio_entry' => $audio_entry,
                'leadership_tip_obj' => $leadership_tip_obj,
                'tip_pos' => $tip_pos,
            ]);
            return $html;
        endif;
    }

    /**
     * Thanku Page of the Challenge for the User - if Challenge is completed
     */
    public function actionThankyou() {
        $this->layout = 'intentionalleadership';
        return $this->render('thankyou');
    }

    public function actionSkipSurvey() {
        $user_id = $_POST['user_id'];
        $challenge_id = $_POST['challenge_id'];
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        //Check whelther User has already Skipped the Survey 
        $check_already_skipped = PilotFrontIntentionalleadershipSurveyData::find()->where(['challenge_id' => $challenge_id, 'user_id' => $user_id, 'survey_filled' => 'No'])->one();
        //Save the Entry : Skipped the Survey for Current Day
        if (empty($check_already_skipped)):
            $surveyModel = new PilotFrontIntentionalleadershipSurveyData();
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
     * Tech Support Action for Raised Tickets
     */
    public function actionTechSupport() {
        $this->layout = 'intentionalleadership';
        $baseurl = Yii::$app->request->baseurl;
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        //User Team ID
        $team_id = Yii::$app->user->identity->team_id;

        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $model = new PilotFrontIntentionalleadershipTechSupport();

        if (Yii::$app->request->post()):
            $postedData = Yii::$app->request->post()['PilotFrontIntentionalleadershipTechSupport'];
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


            $newModel = new PilotFrontIntentionalleadershipTechSupport();
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

    public function actionDailyEmail() {
        $daily_email = new PilotFrontIntentionalleadershipEmail;
        $game = PilotFrontUser::getGameID('intentionalleadership');
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
                return 'Image Shared Successfully';
            else:
                return 'Image not shared';
            endif;
        endif;
    }

    public function actionSaveHighfiveImageComment() {
        $i = 0;
        $html = '';
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $dayset = date('Y-m-d');
        $user_id = Yii::$app->user->identity->id;
        $team_id = Yii::$app->user->identity->team_id;
        $prev_highfives_currentday = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
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
        $week_entries_points = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no])
                ->sum('points');
        if (!empty($week_entries_points)):
            $sum_week_points = $week_entries_points;
        endif;
        if ($sum_week_points >= 150):
            $hf_points = 0;
        endif;

        //Makeup Days entry           
        $total_points_highfive = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->sum('points');
        if (!empty($game_obj->makeup_days)):
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
        $highfiveModel = new PilotFrontIntentionalleadershipHighfive;
        $feature_label = 'highfiveComment';
        $feature_value = $_POST['feature_value'];
        $feature_serial = $_POST['serial'];
        $linked_feature_id = $_POST['linked_feature_id'];
        /* $checkModel = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => $feature_label, 'dayset' => $dayset])->one();
          if (empty($checkModel)): */
        $model = new PilotFrontIntentionalleadershipHighfive;
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
            $image_model = new PilotFrontIntentionalleadershipHighfive;
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
                    $notif_model = new PilotFrontIntentionalleadershipNotifications;
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
            $prev_highfives_currentday = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
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
            $prev_highfives_currentday = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment', 'dayset' => $dayset])->orderBy(['created' => SORT_ASC])->all();
            $count_hf = 0;
            if (!empty($prev_highfives_currentday)):
                $count_hf = count($prev_highfives_currentday);
                $output['count_hf'] = $count_hf;
            endif;
            return json_encode($output);
        endif;
        //endif;
    }

    public function actionMoreHfComments() {
        $output = [];
        $count = $_POST['limit'];
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        //$subQuery = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
        $query = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->limit($count);
        $all_highfivecomment = $query->all();
        $fetched_comment = count($all_highfivecomment);
        $query1 = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
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

    public function search_features_array($exif, $field) {
        foreach ($exif as $data) {
            if ($data['feature_name'] == $field)
                return 'enable';
        }
    }

    public function actionUserlist() {
        $search = $_POST['query'];
        $comp_id = Yii::$app->user->identity->company_id;
        $challenge_id = PilotFrontUser::getGameID('intentionalleadership');
        $user_idlist = PilotFrontIntentionalleadershipHighfive::find()->select('user_id')->where(['company_id' => $comp_id, 'game_id' => $challenge_id]);
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
            } else {
                $value->profile_pic = 'thumb_' . $value->profile_pic;
            }
            $newdata[] = ['name' => $value->username, 'img' => $value->profile_pic];
        }
        return json_encode($newdata);
    }

    public function actionKnowModal() {
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 10;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset = date('Y-m-d');
        $tip_pos = Yii::$app->request->get()['tip'];
        $know_model = new PilotFrontIntentionalleadershipKnowcorner;
        $know_entry = PilotFrontIntentionalleadershipKnowcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos, 'challenge_id' => $game_id])->one();
        if ($_POST):
            $user_id = Yii::$app->user->identity->id;
            $tip_pos = $_POST['tip_pos'];
            $dayset = $dayset;
            $checkModel = PilotFrontIntentionalleadershipKnowcorner::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => $tip_pos, 'challenge_id' => $game_id])->one();

            //Makeup Days entry            
            $total_points_leadership = PilotFrontIntentionalleadershipKnowcorner::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                    ->sum('points');
            if (!empty($game_obj->makeup_days)):
                if (!empty($total_points_leadership) && $dayset >= date('Y-m-d', $game_obj->makeup_days)):
                    $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                    $totalweek = $total_gameday / 7;
                    $exactWeek = explode('.', $totalweek);
                    $total_game_points = $exactWeek[0] * 20;
                    if ($total_points_leadership >= $total_game_points):
                        $points = 0;
                    endif;
                endif;
            endif;
            //end here
            if (empty($checkModel)):
                $model = new PilotFrontIntentionalleadershipKnowcorner;
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
                $model->save(false);
            endif;
            return 'Data Saved Successfully.';
            Yii::$app->end();
        else:
            $week_leadership = 'Week ' . $week_no;
            if ($tip_pos == 'first'):
                $tip_no = $week_leadership . '-one';
            elseif ($tip_pos == 'second'):
                $tip_no = $week_leadership . '-two';
            endif;
            $leadership_category_id = $game_obj->did_you_know_content;
            $didyouknow_tip_obj = PilotDidyouknowCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
            $html = $this->renderAjax('game_modals', [
                'know_model' => $know_model,
                'know_entry' => $know_entry,
                'didyouknow_tip_obj' => $didyouknow_tip_obj,
                'tip_pos' => $tip_pos,
            ]);
            return $html;
        endif;
    }

    public function actionGetUserPoints() {
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('intentionalleadership');
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        //Team ID
        $team_id = Yii::$app->user->identity->team_id;
        //Active Challenge Object (Start Date & End Date) 
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        $game_end_date_timestamp = strtotime('+1 day', $game_end_date_timestamp);
        // $game_end_date_timestamp = 1512806400;
        //Count the Total Service Values of the User
        //Get Total Points of User
        $total_points = PilotFrontUser::getlearningUserPoints($game_obj);
        if ($game_obj->id == '159' || $game_obj->id == '158'):
            $total_steps = PilotFrontServiceStepsApiData::getUserStepsforchallenge($user_id);
            //If User reached 10K Steps
            $raffle_add = floor($total_steps / 10000);
            $add_total_points = 100 * $raffle_add; //Additional 100 Points for Each 10K Steps
            $total_points = $total_points + $add_total_points;
        endif;
        $raffle_entry = floor($total_points / 100);
        $total_actions = PilotFrontUser::getlearningUserActions($game_obj);
        //Save the User Points to the Main Table of All Users Points of Service Challenge
        $check_entry = PilotFrontIntentionalleadershipTotalPoints::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->one();
        if (empty($check_entry)):
            $model = new PilotFrontIntentionalleadershipTotalPoints;
            $model->game_id = $game;
            $model->challenge_id = $game_id;
            $model->user_id = $user_id;
            $model->company_id = $comp_id;
            $model->team_id = $team_id;
            $model->total_points = $total_points;
            $model->total_core_values = 0;
            $model->total_raffle_entry = $raffle_entry;
            $model->total_game_actions = $total_actions;
            $model->created = time();
            $model->updated = time();
            $model->save(false);
        else:
            if ($check_entry->total_points != $total_points):
                $check_entry->total_points = $total_points;
                $check_entry->total_core_values = 0;
                $check_entry->total_raffle_entry = $raffle_entry;
                $check_entry->total_game_actions = $total_actions;
                $check_entry->updated = time();
                $check_entry->save(false);
            endif;
        endif;

        $html = '';

        $html .= '<li class=abs><img src="../images/gradd.png" alt=bg height=42 width=66><p class="num_pt num_pt1">' . $total_points . '</p><p class=pt>Total Points</p> </li>
             <li class=abs><img class=point src="../images/point.png" alt=point height=50 width=51><p class="core_values num_pt_circle1">' . count($total_core_values) . '</p><p class="pt hide">points</p> </li>
             <li class=abs><img src="../images/entry.png" alt=entry height=47 width=68> <p class="entry pt">' . $raffle_entry . ' Entry</p> </li>';

        echo json_encode(array('total_points' => $total_points, 'status' => 'success'));
    }

    public function actionToolbox() {
        $this->layout = 'intentionalleadership';
        $game = PilotFrontUser::getGameID('intentionalleadership');
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

        $leadership_tips_id = $game_obj->todays_lesson_content;

        $leadership_tips = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_tips_id])
                ->andFilterWhere(['not like', 'week', $week_leadership])
                ->orderBy(['created' => SORT_DESC])
                ->all();

        //Leadership Corner
        $leadership_entry_weekly = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->all();
        $leadership_entry_currentday = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset])->one();
        $leadership_entry_first = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'first'])->one();
        $leadership_entry_sec = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'second'])->one();
        $leadership_entry_third = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'third'])->one();



        if (empty($leadership_entry_weekly)):
            $current_week_leadership_tips = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_tips_id])
                    ->andWhere(['=', 'week', $tip_no1])
                    ->orderBy(['created' => SORT_DESC])
                    ->all();
        endif;

        if (!empty($leadership_entry_first)):

            if (empty($leadership_entry_currentday)):
                $current_week_leadership_tips = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['week' => [$tip_no1, $tip_no2]])
                        ->andWhere(['!=', 'week', $tip_no3])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();

            else:
                $current_week_leadership_tips = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['=', 'week', $tip_no1])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            endif;
        endif;


        if (!empty($leadership_entry_sec)):
            if (empty($leadership_entry_currentday)):
                $current_week_leadership_tips = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['week' => [$tip_no1, $tip_no2, $tip_no3]])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            else:
                $current_week_leadership_tips = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_tips_id])
                        ->andWhere(['week' => [$tip_no1, $tip_no2]])
                        ->andWhere(['!=', 'week', $tip_no3])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            endif;
        endif;
        //All Three Tips
        if (!empty($leadership_entry_third)):
            $current_week_leadership_tips = PilotTodayslessonCorner::find()->where(['category_id' => $leadership_tips_id])
                    ->andWhere(['week' => [$tip_no1, $tip_no2, $tip_no3]])
                    ->orderBy(['created' => SORT_DESC])
                    ->all();
        endif;

        return $this->render('toolbox', [
                    'leadership_tips' => $leadership_tips,
                    'current_week_leadership_tips' => $current_week_leadership_tips,
                    'week_no' => $week_no,
        ]);
    }

    public function actionPlayAudio() {
        $tip_pos = Yii::$app->request->get()['tip'];
        $audio1 = array();
        $html = $this->renderAjax('game_modals', [
            'audio' => $tip_pos,
            'audio1' => $audio1,
        ]);
        return $html;
    }

    public function actionKnowTheTeam() {
        $this->layout = "intentionalleadership";
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $user_id = Yii::$app->user->identity->id;
        $comp_id = Yii::$app->user->identity->company_id;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $knowtheteam = $game_obj->get_to_know_content;
        $week_no = PilotFrontUser::getGameWeek($game_obj);

        //Current Week Tips Variables
        $week_leadership = 'Week ' . $week_no;
        $tip_no1 = $week_leadership . '-one';
        $tip_no2 = $week_leadership . '-two';
        $tip_no3 = $week_leadership . '-three';

        $leadership_tips = PilotGettoknowCorner::find()->where(['category_id' => $knowtheteam])
                ->andFilterWhere(['not like', 'week', $week_leadership])
                ->orderBy(['created' => SORT_DESC])
                ->all();
        $week_pattern = $week_leadership . '%';
        $leadership_entry_weekly = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->all();
        $leadership_entry_currentday = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset])->one();
        $leadership_entry_first = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'first'])->one();
        $leadership_entry_sec = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'second'])->one();
        $leadership_entry_third = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'tip_pos' => 'third'])->one();


        if (empty($leadership_entry_weekly)):
            $current_week_leadership_tips = PilotGettoknowCorner::find()->where(['category_id' => $knowtheteam])
                    ->andWhere(['=', 'week', $tip_no1])
                    ->orderBy(['created' => SORT_DESC])
                    ->all();
        endif;

        if (!empty($leadership_entry_first)):

            if (empty($leadership_entry_currentday)):
                $current_week_leadership_tips = PilotGettoknowCorner::find()->where(['category_id' => $knowtheteam])
                        ->andWhere(['week' => [$tip_no1, $tip_no2]])
                        ->andWhere(['!=', 'week', $tip_no3])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();

            else:
                $current_week_leadership_tips = PilotGettoknowCorner::find()->where(['category_id' => $knowtheteam])
                        ->andWhere(['=', 'week', $tip_no1])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            endif;
        endif;


        if (!empty($leadership_entry_sec)):
            if (empty($leadership_entry_currentday)):
                $current_week_leadership_tips = PilotGettoknowCorner::find()->where(['category_id' => $knowtheteam])
                        ->andWhere(['week' => [$tip_no1, $tip_no2, $tip_no3]])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            else:
                $current_week_leadership_tips = PilotGettoknowCorner::find()->where(['category_id' => $knowtheteam])
                        ->andWhere(['week' => [$tip_no1, $tip_no2]])
                        ->andWhere(['!=', 'week', $tip_no3])
                        ->orderBy(['created' => SORT_DESC])
                        ->all();
            endif;
        endif;
        //All Three Tips
        if (!empty($leadership_entry_third)):
            $current_week_leadership_tips = PilotGettoknowCorner::find()->where(['category_id' => $knowtheteam])
                    ->andWhere(['week' => [$tip_no1, $tip_no2, $tip_no3]])
                    ->orderBy(['created' => SORT_DESC])
                    ->all();
        endif;

//        if (empty($leadership_entry_weekly)):
//            $tip = $tip_no1;
//        endif;
//
//        if (!empty($leadership_entry_first)):
//            $tip = $tip_no2;
//        endif;
//        if (!empty($leadership_entry_sec)):
//            $tip = $tip_no3;
//        endif;
//        //All Three Tips
//        if (!empty($leadership_entry_third)):
//            $tip = $tip_no3;
//        endif;
// $answer_entry_second = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no, 'dayset' => $dayset, 'challenge_id' => $game_id])->one();
        return $this->render('knowtheteam', [
                    'leadership_tips' => $leadership_tips,
                    'current_week_leadership_tips' => $current_week_leadership_tips,
                    'week_no' => $week_no]);
    }

    public function actionLeaderboard() {
        $this->layout = 'intentionalleadership';
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = PilotFrontUser::getGameID('intentionalleadership');
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
                $points_obj = PilotFrontIntentionalleadershipTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $team_id])
                        ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                        ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                        ->limit(10)
                        ->all();

                $teams_points_obj_arr[$team_id] = $points_obj;
            endif;
        endforeach;
        if (empty($teams[0])) {
            $points_obj = PilotFrontIntentionalleadershipTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                    ->limit(10)
                    ->all();
            $teams_points_obj_arr[] = $points_obj;
        }
        //Login User Team Total Actions
        if (!empty($user_team_id)):
            $login_user_team_actions = PilotFrontIntentionalleadershipTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->sum('total_game_actions');
        else:
            $login_user_team_actions = PilotFrontIntentionalleadershipTotalPoints::find()->where(['game_id' => $game, 'company_id' => $comp_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->sum('total_game_actions');
        endif;

        //Login User Team Total Service Values
        if (!empty($user_team_id)):
            $login_user_team_core_values = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id])
                            ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])->count('id');
        else:
            $login_user_team_core_values = PilotFrontIntentionalleadershipWeeklychallenge::find()->where(['game_id' => $game, 'company_id' => $comp_id])
                            ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])->count('id');
        endif;
        if (empty($login_user_team_core_values)):
            $login_user_team_core_values = 0;
        endif;

        //Login User Team Total Wins
        if (!empty($user_team_id)):
            $login_user_team_wins = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->count('id');
        else:
            $login_user_team_wins = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'company_id' => $comp_id])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->count('id');
        endif;

        //Login User Team High 5s
        if (!empty($user_team_id)):
            $login_user_team_high5s = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'team_id' => $user_team_id, 'feature_label' => 'highfiveComment'])
                    ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                    ->count('id');
        else:
            $login_user_team_high5s = PilotFrontIntentionalleadershipHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])
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

    public function actionWeeklyModal() {
        $game = PilotFrontUser::getGameID('intentionalleadership');
        $comp_id = Yii::$app->user->identity->company_id;
        $points = 20;
        $game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        $week_no = PilotFrontUser::getGameWeek($game_obj);
        $weekly_entry = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id, 'week_no' => $week_no])->one();
        $timezone = Yii::$app->user->identity->timezone;
        date_default_timezone_set($timezone);
        $dayset1 = date('Y-m-d');
//        if (empty($weekly_entry)):
        $weekly_model = new PilotFrontIntentionalleadershipQuestion;
//        else:
//            $weekly_model = $weekly_entry;
//        endif;
        if (Yii::$app->request->post()):
            $user_id = Yii::$app->user->identity->id;
            $dayset = date('Y-m-d');
            $comment = $_POST['comment'];
            $checkModel = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'week_no' => $week_no, 'challenge_id' => $game_id])->one();
            $message = "Response Saved Successfully.";
            $count_week_entr = count($checkModel);
            if ($count_week_entr >= 1):
                $points = 0;
                $message = "Response Saved Successfully.";
            endif;
            //Makeup Days entry            
            $total_points_weeklyvideo = PilotFrontIntentionalleadershipQuestion::find()->where(['game_id' => $game, 'user_id' => Yii::$app->user->identity->id, 'company_id' => $comp_id])
                    ->sum('points');
            if (!empty($game_obj->makeup_days)):
                if (!empty($total_points_weeklyvideo) && $dayset1 >= date('Y-m-d', $game_obj->makeup_days)):
                    $total_gameday = PilotFrontUser::datediff($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                    $totalweek = $total_gameday / 7;
                    $exactWeek = explode('.', $totalweek);
                    $total_game_points = $exactWeek[0] * 30;
                    if ($total_points_weeklyvideo >= $total_game_points):
                        $points = 0;
                    endif;
                endif;
            endif;
            //end here
            // if (empty($checkModel)):
            $model = new PilotFrontIntentionalleadershipQuestion;
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
            if ($model->save(false)):
                return $message;
            endif;
        // else:
//                $checkModel->comment = json_encode($comment);
//                $checkModel->updated = time();
//                if ($checkModel->save()):
//                    return 'Updated Successfully';
//                endif;
        // endif;
        else:
            //Fetch the Video & Title for Current Week - Weekly Challenge
            $game_current_week_no = $week_no;
            $voicematters_category_id = $game_obj->voicematters_content;
            $voicematters_challenge_obj = PilotActionmattersChallenge::find()->where(['category_id' => $voicematters_category_id, 'week' => $game_current_week_no])->one();
            if (empty($voicematters_challenge_obj)):
                $weeks = PilotFrontUser::numofweeks($game_obj->challenge_start_date, $game_obj->challenge_end_date);
                $weekly_challenge_count = PilotActionmattersChallenge::find()->where(['category_id' => $voicematters_category_id])->count();
                $game_current_week_no = PilotFrontUser::getvideoweek($week_no, $weekly_challenge_count);
                $voicematters_challenge_obj = PilotActionmattersChallenge::find()->where(['category_id' => $voicematters_category_id, 'week' => $game_current_week_no])->one();
            endif;
            $weekly_question = $voicematters_challenge_obj->question;

            $html = $this->renderAjax('game_modals', [
                'weekly_model' => $weekly_model,
                'weekly_question' => $weekly_question,
                'weekly_entry' => $weekly_entry
            ]);
            return $html;
        endif;
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
