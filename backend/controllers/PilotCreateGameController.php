<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotCreateGame;
use backend\models\PilotLogs;
use backend\models\PilotCreateGameSearch;
use backend\models\PilotEventCalender;
use backend\models\PilotCompanyTeams;
use backend\models\PilotEmailTemplate;
use backend\models\PilotLeadershipCategory;
use backend\models\Company;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGameFeatures;
use backend\models\PilotDailyinspirationCategory;
use backend\models\PilotWeeklyCategory;
use backend\models\PilotDailyinspirationImage;
use backend\models\PilotWeeklyChallenge;
use backend\models\PilotLeadershipCorner;
use backend\models\PilotSurveyQuestion;
use backend\models\PilotEmailNotification;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\ButtonToggle;
use frontend\models\PilotFrontCoreShareawinSearch;
use frontend\models\PilotFrontCoreCheckinSearch;
use frontend\models\PilotFrontUserSearch;
use frontend\models\PilotFrontCoreTotalPointsSearch;
use frontend\models\PilotFrontUser;
use backend\models\PilotHowItWork;
use backend\models\PilotPrizesCategory;
use backend\models\PilotCheckinYourselfCategory;
use backend\models\PilotCheckinYourselfData;
use backend\models\PilotInhouseUser;
use backend\models\Categories;
use backend\models\PilotDidyouknowCategory;
use backend\models\PilotDidyouknowCorner;
use backend\models\PilotGettoknowCategory;
use backend\models\PilotGettoknowCorner;
use backend\models\PilotActionmattersCategory;
use backend\models\PilotActionmattersChallenge;
use backend\models\PilotTodayslessonCategory;
use backend\models\PilotTodayslessonCorner;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/**
 * PilotManageGameController implements the CRUD actions for PilotManageGame model.
 */
class PilotCreateGameController extends Controller {
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['currentgame', 'notification'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'game', 'report', 'gethighfivecount', 'getshareawincount', 'getcheckincount', 'gettotalpointscount', 'getregisterusercount', 'digitalhighfive', 'shareawin', 'corecheckin', 'registereduser', 'activeuser', 'getscoreusercount', 'userlistingpoints', 'getteam', 'reminder', 'game-name', 'downloadactiveuser', 'downloadregistereduser', 'downloadcorevalues', 'downloadshareawin', 'downloadhighfive', 'download-dailyinspiration', 'download-weeklychallenge', 'download-leadershipcorner', 'download-voice-matters', 'weekly-reports', 'survey-reports', 'core-value-image', 'savetestimonial', 'testimonial', 'load-testimonial', 'deletetestimonial', 'loaduser', 'getcompanygames', 'getcategorygames'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return PilotInhouseUser::isUserAdmin(Yii::$app->user->identity->id);
                        }
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
     * Lists all PilotManageGame models.
     * @return mixed
     */
    public function actionIndex() {

        $data = PilotCreateGame::find()->with('managerinfo')->one();

        $searchModel = new PilotCreateGameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PilotManageGame model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotManageGame model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotCreateGame();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotManageGame model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $toggle = 'no';
        $model = $this->findModel($id);
        $model1 = $this->findModel($id);
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            //echo '<pre>';print_r(Yii::$app->request->post());die;
            if (!empty($model->challenge_teams)) {
                $model->challenge_teams = implode(",", $model->challenge_teams);
            }
            if (in_array(11, $model->features)):
                $toggle = 'yes';
            endif;
            $model->features = implode(",", $model->features);
            $model->survey = Yii::$app->request->post()['PilotCreateGame']['survey'];
            if (Yii::$app->request->post()['PilotCreateGame']['survey'] == '1') {
                if (Yii::$app->request->post()['PilotCreateGame']['survey_questions']) {
                    $model->survey_questions = implode(",", Yii::$app->request->post()['PilotCreateGame']['survey_questions']);
                }
            } else {
                $model->survey_questions = '';
            }
            $core_image = Yii::$app->request->post()['core_image'];
            if ($core_image) {
                $model->core_image = $core_image;
            }
            if (empty($model->banner_image1)):
                $model->banner_image1 = $model1->banner_image1;
            endif;
            $model->right_corners = Yii::$app->request->post()['PilotCreateGame']['right_corners'];
            $model->getstarted = $model1->getstarted;
            if ($model1->challenge_start_date != $model->challenge_start_date):
                $start_date = date('M d, Y', strtotime($model->challenge_start_date));
                $model->challenge_start_date = strtotime($start_date);
            else:
                $model->challenge_start_date = $model1->challenge_start_date;
            endif;
            if ($model1->challenge_registration_date != $model->challenge_registration_date):
                $reg_date = date('M d, Y', strtotime($model->challenge_registration_date));
                $model->challenge_registration_date = strtotime($reg_date);
            else:
                $model->challenge_registration_date = $model1->challenge_registration_date;
            endif;
            $survey_date = date('M d, Y', strtotime($model->challenge_survey_date));
            $model->challenge_survey_date = strtotime($survey_date);
            $time = $model->challenge_start_date;
            if ($model1->challenge_end_date != $model->challenge_end_date):
                $end_date = date('M d, Y', strtotime($model->challenge_end_date));
                $model->challenge_end_date = strtotime($end_date);
            else:
                $model->challenge_end_date = $model1->challenge_end_date;
            endif;
            if ($model1->makeup_days != $model->makeup_days):
                $makeupdays = date('M d, Y', strtotime($model->makeup_days));
                $model->makeup_days = strtotime($makeupdays);
            else:
                $model->makeup_days != $model1->makeup_days;
            endif;
            $cnvimg = Yii::$app->request->post()['banner_image'];
            $cnvimg = str_replace('data:image/png;base64,', '', $cnvimg);
            $cnvimg = str_replace(' ', '+', $cnvimg);
            $data = base64_decode($cnvimg);
            $file = time() . '.png';
            $location = getcwd() . '/img/game/welcome_banner';
            $success = file_put_contents($location . '/' . $file, $data);
            $model->banner_image = $file;
            $cnvimg1 = Yii::$app->request->post()['thankyou_image'];
            $cnvimg1 = str_replace('data:image/png;base64,', '', $cnvimg1);
            $cnvimg1 = str_replace(' ', '+', $cnvimg1);
            $data1 = base64_decode($cnvimg1);
            $file1 = time() . '.png';
            $location1 = getcwd() . '/img/game/thankyou_banner';
//echo $data;die('sdsdsd');
            $success = file_put_contents($location1 . '/' . $file1, $data1);


            /* $survey_date = date('M d, Y', strtotime($model->challenge_survey_date));
              $model->challenge_survey_date = strtotime($survey_date); */

            $core_heading = Yii::$app->request->post()['PilotCreateGame']['core_heading'];
            if (empty($core_heading)) {
                $core_heading = 'Core Value';
            }
            $model->core_heading = $core_heading;
            $current_time = time();
            $currentdate = date("m-d-Y", $current_time);
            if ($model->challenge_start_date > $current_time) {

                $model->status = 0; //for upcoming 
            }
            if (($model->challenge_start_date <= $current_time) && ($current_time <= $model->challenge_end_date)) {

                $model->status = 1; // for ongoing
            }
            if ($model->challenge_end_date < $current_time) {
                $model->status = 2; // for old
            }
            $model->executive_email_2 = Yii::$app->request->post()['PilotCreateGame']['executive_email_2'];
            $model->executive_email_3 = Yii::$app->request->post()['PilotCreateGame']['executive_email_3'];
            $model->inhouse_email_2 = Yii::$app->request->post()['PilotCreateGame']['inhouse_email_2'];
            $model->inhouse_email_3 = Yii::$app->request->post()['PilotCreateGame']['inhouse_email_3'];
            $model->banner_text_1 = Yii::$app->request->post()['banner_text_1'];
            $model->banner_text_2 = Yii::$app->request->post()['banner_text_2'];
            $model->updated = time();
            $model->created_user_id = Yii::$app->user->identity->id;
            $model->save(false);
            if ($toggle == 'yes'):
                $toggle_data = ButtonToggle::find()->where(['game_id' => $model->id])->one();
                if (!empty($toggle_data)):
                    $toggle_data->Button_text = Yii::$app->request->post()['button_text'];
                    $toggle_data->updated = time();
                    $toggle_data->save(false);
                else:
                    $button_text = new ButtonToggle();
                    $button_text->game_id = $model->id;
                    $button_text->Button_text = Yii::$app->request->post()['button_text'];
                    $button_text->created = time();
                    $button_text->updated = time();
                    $button_text->save(false);
                endif;
            endif;
            if ($model->save(false)) {
                PilotEmailNotification::deleteAll('game_id = :game_id', [':game_id' => $model->id]);
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $current = time();
                $emailnotification->date = date("d-M-Y", $current);
                $emailnotification->subject = 'new game created';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_registration_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $registrationdate = date("d-M-Y", $model->challenge_registration_date);
                $emailnotification->date = $registrationdate;
                $emailnotification->subject = 'This is your friendly reminder that the game registration is started';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $start = $model->challenge_start_date;
                $emailnotification->game_id = $model->id;
                $sevenday = strtotime("-7 days", $start);
                $sevendaydate = date("d-M-Y", $sevenday);
                $emailnotification->date = $sevendaydate;
                $emailnotification->subject = 'This is your friendly reminder that the Challenge will start in 7 days';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $start = $model->challenge_start_date;
                $emailnotification->game_id = $model->id;
                $fiveday = strtotime("-5 days", $start);
                $fivedaydate = date("d-M-Y", $fiveday);
                $emailnotification->date = $fivedaydate;
                $emailnotification->subject = 'This is your friendly reminder that the game content is ready';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $start = $model->challenge_start_date;
                $emailnotification->game_id = $model->id;
                $threeday = strtotime("-3 days", $start);
                $threedaydate = date("d-M-Y", $threeday);
                $emailnotification->date = $threedaydate;
                $emailnotification->subject = 'This is your friendly reminder that the Challenge will start in 3 days';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $startdate = date("d-M-Y", $model->challenge_start_date);
                $emailnotification->date = $startdate;
                $emailnotification->subject = 'This is your friendly reminder that the Challenge will start today';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_survey_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $surveydate = date("d-M-Y", $model->challenge_survey_date);
                $emailnotification->date = $surveydate;
                $emailnotification->subject = 'survey live on reminder';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_end_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $enddate = date("d-M-Y", $model->challenge_end_date);
                $emailnotification->date = $enddate;
                $emailnotification->subject = 'game end date reminder';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            $PilotEventCalender = new PilotEventCalender();
            $PilotEventCalender->update_calender_event($model->id, $model->challenge_registration_date, $model->challenge_registration_date, 1); //for registration date event update
            $PilotEventCalender->update_calender_event($model->id, $model->makeup_days, $model->challenge_end_date, 2); //for makeup Days event update
//$PilotEventCalender->update_survey_event($model->id,$model->challenge_registration_date, $model->challenge_end_date,1);
            $PilotEventCalender->update_calender_event($model->id, $model->challenge_start_date, $model->challenge_end_date, 0); //for game start and end event update
            if (Yii::$app->request->post()['PilotCreateGame']['survey'] == '1'):
                $PilotEventCalender->update_survey_event(3, $model->id, $model->created_user_id, $model->challenge_company_id, $model->challenge_id, $model->challenge_survey_date, $model->challenge_survey_date); //for survey date update
            endif;
            Yii::$app->session->setFlash('created', 'Game Updated Successfully!');
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PilotManageGame model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = PilotCreateGame::findOne($id);
        $tablename = $_POST['tablename'];
//        echo $tablename;
//        die;
        if (!empty($model)):
            $challenge = PilotGameChallengeName::find()->where(['id' => $model->challenge_id])->one();
            $challenge_abr = ucfirst($challenge->challenge_abbr_name);
            if ($challenge_abr == 'Teamwork'):
                $challenge_abr = 'Team';
            endif;
//highfive
            $model_checkin = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';
            $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
            $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
            $model_shareawin = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';
            $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';
            $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
            $model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
            $model_notification = '\frontend\\models\\PilotFront' . $challenge_abr . 'Notifications';
            $model_survey = '\frontend\\models\\PilotFront' . $challenge_abr . 'SurveyData';
            $model_tech = '\frontend\\models\\PilotFront' . $challenge_abr . 'TechSupport';
            /* $step_api = '\frontend\\models\\PilotFront'.$challenge_abr.'StepsApiData';
              $step_modal = '\frontend\\models\\PilotFront'.$challenge_abr.'StepsModal'; */
            if ($tablename == 'checkin'):
                $checkin = $model_checkin::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $model_checkin . " data deleted";
            elseif ($tablename == 'daily'):
                $daily = $daily_model_name::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $daily_model_name . " data deleted";
            elseif ($tablename == 'highfive'):
                $highfive = $model_highfive::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $model_highfive . " data deleted";
            elseif ($tablename == 'sharewin'):
                $shareawin = $model_shareawin::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $model_shareawin . " data deleted";
            elseif ($tablename == 'leadership'):
                $leadership = $corner_tips_model_name::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $corner_tips_model_name . " data deleted";
            elseif ($tablename == 'weekly'):
                $weekly = $weekly_model_name::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $weekly_model_name . " data deleted";
            elseif ($tablename == 'totalpoints'):
                $totalpoints = $model_scorepoints::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $model_scorepoints . " data deleted";
            elseif ($tablename == 'notification'):
                $notif_data = $model_notification::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $model_notification . " data deleted";
            elseif ($tablename == 'survey'):
                $survey = $model_survey::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $model_survey . " data deleted";
            elseif ($tablename == 'techsupport'):
                $model_tech::deleteAll('challenge_id = :challenge_id', [':challenge_id' => $id]);
                return $model_tech . " data deleted";
            elseif ($tablename == "modal"):
                PilotEventCalender::deleteAll('game_id = :game_id', [':game_id' => $id]);
                PilotEmailNotification::deleteAll('game_id = :game_id', [':game_id' => $id]);
                $model->delete();
                Yii::$app->session->setFlash('created', 'Game Deleted Successfully!');
                return "All tables deleted.";
            endif;
        endif;
    }

    /**
     * Finds the PilotManageGame model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotManageGame the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotCreateGame::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGame() {
        $toggle = 'no';
        $model = new PilotCreateGame();
        $button_text = new ButtonToggle();
        $emailnotification = new PilotEmailNotification();
        if (Yii::$app->request->post()) {
            //echo '<pre>';print_r(Yii::$app->request->post());die;
            $model->load(Yii::$app->request->post());
            if (!empty($model->challenge_teams)) {
                $model->challenge_teams = implode(",", $model->challenge_teams);
            }
            if (in_array(11, $model->features)):
                $toggle = 'yes';
            endif;
            $model->features = implode(",", $model->features);
            $model->survey = Yii::$app->request->post()['PilotCreateGame']['survey'];
            if (Yii::$app->request->post()['PilotCreateGame']['survey'] == '1') {
                if (Yii::$app->request->post()['PilotCreateGame']['survey_questions']) {
                    $model->survey_questions = implode(",", Yii::$app->request->post()['PilotCreateGame']['survey_questions']);
                }
            } else {
                $model->survey_questions = '';
            }

            $image1 = UploadedFile::getInstance($model, 'banner_image1');
            if ($image1) {
                $image1 = UploadedFile::getInstance($model, 'banner_image1');
                $model->banner_image1 = time() . '.' . $image1->extension;
                $image1->saveAs('img/game/' . $model->banner_image1);
            } else {
                $model->banner_image1 = '';
            }
            if (!empty(Yii::$app->request->post()['PilotCreateGame']['companynamecustom'])):
                $model->challenge_company_id = Yii::$app->request->post()['PilotCreateGame']['companynamecustom'];
            endif;
            if (!empty(Yii::$app->request->post()['PilotCreateGame']['categoryexpreess'])):
                $model->category_id = Yii::$app->request->post()['PilotCreateGame']['categoryexpreess'];
            endif;
            $cnvimg = Yii::$app->request->post()['banner_image'];
            $cnvimg = str_replace('data:image/png;base64,', '', $cnvimg);
            $cnvimg = str_replace(' ', '+', $cnvimg);
            $data = base64_decode($cnvimg);
            $file = time() . '.png';
            $location = getcwd() . '/img/game/welcome_banner';
            $success = file_put_contents($location . '/' . $file, $data);
            $model->banner_image = $file;
            $cnvimg1 = Yii::$app->request->post()['thankyou_image'];
            $cnvimg1 = str_replace('data:image/png;base64,', '', $cnvimg1);
            $cnvimg1 = str_replace(' ', '+', $cnvimg1);
            $data1 = base64_decode($cnvimg1);
            $file1 = time() . '.png';
            $location1 = getcwd() . '/img/game/thankyou_banner';
//echo $data;die('sdsdsd');
            $success = file_put_contents($location1 . '/' . $file1, $data1);
            $model->thankyou_image = $file1;
            $core_image = Yii::$app->request->post()['core_image'];
            if ($core_image) {
                $model->core_image = $core_image;
            }
            $start_date = date('M d, Y', strtotime($model->challenge_start_date));
            $model->challenge_start_date = strtotime($start_date);
            $reg_date = date('M d, Y', strtotime($model->challenge_registration_date));
            $model->challenge_registration_date = strtotime($reg_date);
            $survey_date = date('M d, Y', strtotime($model->challenge_survey_date));
            $model->challenge_survey_date = strtotime($survey_date);
            $time = $model->challenge_start_date;
            $end_date = date('M d, Y', strtotime($model->challenge_end_date));
            $model->challenge_end_date = strtotime($end_date);
            $makeupdays = date('M d, Y', strtotime($model->makeup_days));
            $model->makeup_days = strtotime($makeupdays);
            $current_time = time();
            $currentdate = date("m-d-Y", $current_time);
            $model->right_corners = Yii::$app->request->post()['PilotCreateGame']['right_corners'];
            if ($model->challenge_start_date > $current_time) {

                $model->status = 0; //for upcoming 
            }
            if (($model->challenge_start_date <= $current_time) && ($current_time <= $model->challenge_end_date)) {

                $model->status = 1; // for ongoing
            }
            if ($model->challenge_end_date < $current_time) {
                $model->status = 2; // for old
            }
            $core_heading = Yii::$app->request->post()['PilotCreateGame']['core_heading'];
            if (empty($core_heading)) {
                $core_heading = 'Core Value';
            }
            $model->core_heading = $core_heading;
            $model->executive_email_2 = Yii::$app->request->post()['PilotCreateGame']['executive_email_2'];
            $model->executive_email_3 = Yii::$app->request->post()['PilotCreateGame']['executive_email_3'];
            $model->inhouse_email_2 = Yii::$app->request->post()['PilotCreateGame']['inhouse_email_2'];
            $model->inhouse_email_3 = Yii::$app->request->post()['PilotCreateGame']['inhouse_email_3'];
            $model->banner_text_1 = Yii::$app->request->post()['banner_text_1'];
            $model->banner_text_2 = Yii::$app->request->post()['banner_text_2'];
            $model->created = time();
            $model->updated = time();
            $model->created_user_id = Yii::$app->user->identity->id;
//echo "<pre>";print_r($model);die;
            $model->save(false);
            if ($toggle == 'yes'):
                $button_text->game_id = $model->id;
                $button_text->Button_text = Yii::$app->request->post()['button_text'];
                $button_text->created = time();
                $button_text->updated = time();
                $button_text->save(false);
            endif;
            $current_time = time();
            if ($model->save(false)) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $current = time();
                $emailnotification->date = date("d-M-Y", $current);
                $emailnotification->subject = 'new game created';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_registration_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $registrationdate = date("d-M-Y", $model->challenge_registration_date);
                $emailnotification->date = $registrationdate;
                $emailnotification->subject = 'This is your friendly reminder that the game registration is started';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $start = $model->challenge_start_date;
                $emailnotification->game_id = $model->id;
                $sevenday = strtotime("-7 days", $start);
                $sevendaydate = date("d-M-Y", $sevenday);
                $emailnotification->date = $sevendaydate;
                $emailnotification->subject = 'This is your friendly reminder that the Challenge will start in 7 days';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $start = $model->challenge_start_date;
                $emailnotification->game_id = $model->id;
                $fiveday = strtotime("-5 days", $start);
                $fivedaydate = date("d-M-Y", $fiveday);
                $emailnotification->date = $fivedaydate;
                $emailnotification->subject = 'This is your friendly reminder that the game content is ready';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $start = $model->challenge_start_date;
                $emailnotification->game_id = $model->id;
                $threeday = strtotime("-3 days", $start);
                $threedaydate = date("d-M-Y", $threeday);
                $emailnotification->date = $threedaydate;
                $emailnotification->subject = 'This is your friendly reminder that the Challenge will start in 3 days';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_start_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $startdate = date("d-M-Y", $model->challenge_start_date);
                $emailnotification->date = $startdate;
                $emailnotification->subject = 'This is your friendly reminder that the Challenge will start today';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_survey_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $surveydate = date("d-M-Y", $model->challenge_survey_date);
                $emailnotification->date = $surveydate;
                $emailnotification->subject = 'survey live on reminder';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
            if ($model->challenge_end_date) {
                $emailnotification = new PilotEmailNotification();
                $emailnotification->game_id = $model->id;
                $enddate = date("d-M-Y", $model->challenge_end_date);
                $emailnotification->date = $enddate;
                $emailnotification->subject = 'game end date reminder';
                $emailnotification->active = 0;
                $emailnotification->save(false);
            }
// saving calender event corresponding to the
            $PilotEventCalender = new PilotEventCalender();
//$event_id= $PilotEventCalender->save_register_event($model->id,$model->created_user_id, $model->challenge_company_id, $model->challenge_id, $model->challenge_registration_date, $model->challenge_end_date);
            $event_id = $PilotEventCalender->save_calender_event($model->id, $model->created_user_id, $model->challenge_company_id, $model->challenge_id, $model->challenge_registration_date, $model->challenge_start_date, $model->makeup_days, $model->challenge_survey_date, $model->challenge_end_date);
//$PilotEventCalender->save_makeupdays_event($event_id,$model->id,$model->created_user_id, $model->challenge_company_id, $model->challenge_id, $model->makeup_days, $model->challenge_end_date);
            if (Yii::$app->request->post()['PilotCreateGame']['survey'] == '1'):
                $PilotEventCalender->save_surveydates_event($event_id, $model->id, $model->created_user_id, $model->challenge_company_id, $model->challenge_id, $model->challenge_survey_date, $model->challenge_survey_date);
            endif;
            Yii::$app->session->setFlash('created', 'Game Created Successfully!');
            return $this->redirect('index');
        }
        return $this->render('game', ['model' => $model]);
    }

    /**
     * this render the Report page
     * @return mixed
     */
    public function actionReport($id) {
        $model = $this->findModel($id);
        $surveyques = explode(',', $model->survey_questions);
        foreach ($surveyques as $survey) {
            $surveymodel[] = PilotSurveyQuestion::find()->where(['id' => $survey])->one();
        }
        // echo '<pre>';print_r($surveymodel);die;
        $cid = $model->challenge_company_id;
        $challid = $model->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';

        // to get the all register user to the corrsponding company_id
        $frontregisteruser = \frontend\models\PilotFrontUser::find()->where(['company_id' => $cid])->all();
        $userlisting = [];
        $count = 0;
        // to find ongoing user ,playing , to get the points
//        foreach ($frontregisteruser as $value) {
        $ongoinguser = $daily_model_name::find()->where(['game_id' => $challid, 'company_id' => $cid])
                ->andWhere(['between', 'created', $model->challenge_start_date, $model->challenge_end_date])
                ->orderBy(['total_points' => SORT_DESC, 'updated' => SORT_DESC])
                ->limit(7)
                ->all();
        foreach ($ongoinguser as $value) {
            if (!empty($value)):
                $username = \frontend\models\PilotFrontUser::find()->where(['id' => $value->user_id])->one();
                $userlisting[] = array('total_points' => $value->total_points, 'user_name' => $username->username, 'profile_pic' => $username->profile_pic, 'userid' => $username->id);
            endif;
        }
        //echo '<pre>';print_r($ongoinguser);die;
        //}
        $dailycategory = $model->daily_inspiration_content;
        $dailyinspirationcount = count(PilotDailyinspirationImage::find()->where(['category_id' => $dailycategory])->all());
        // $leadershipcorner = $model->leadership_corner_content;
        // $leadershipcompanyname = Company::find()->where(['id' => $leadershipcorner])->one();
        //  $leadershipcornercount = count(PilotLeadershipCorner::find()->where(['category_id' => $leadershipcorner])->all());
        $dailyinspiration = PilotDailyinspirationCategory::find()->where(['id' => $dailycategory])->one();
        $weeklychallenge = PilotWeeklyCategory::find()->where(['id' => $weeklycategory])->one();
        $leadershipcategory = PilotLeadershipCategory::find()->where(['id' => $leadershipcorner])->one();
        $howitwork = PilotHowItWork::find()->where(['id' => $model->howitwork_content])->one();
        $prizecategory = PilotPrizesCategory::find()->where(['id' => $model->prize_content])->one();
         if ($challid != 7 && $challid != 8 && $challid != 11):
            $leadershipcorner = $model->leadership_corner_content;
            $leadershipcompanyname = Company::find()->where(['id' => $leadershipcorner])->one();
            $leadershipcornercount = count(PilotLeadershipCorner::find()->where(['category_id' => $leadershipcorner])->all());
            $weeklycategory = $model->weekly_challenge_content;
            $weeklychallengecount = count(PilotWeeklyChallenge::find()->where(['category_id' => $weeklycategory])->all());
            $checkin = PilotCheckinYourselfCategory::find()->where(['id' => $model->checkin_yourself_content])->one();
            $checkincount = count(PilotCheckinYourselfData::find()->where(['category_id' => $model->checkin_yourself_content])->all());
            $corevalueid = $model->core_value_content;
            $corecount = count(PilotCompanyCorevaluesname::find()->where(['company_id' => $corevalueid])->all());
            $corecategory = Company::find()->where(['id' => $corevalueid])->one();
            $weeklychallenge = PilotWeeklyCategory::find()->where(['id' => $weeklycategory])->one();
            $leadershipcategory = PilotLeadershipCategory::find()->where(['id' => $leadershipcorner])->one();
        endif;
        if ($challid == 7):
            $todayslesssoncategory = $model->todays_lesson_content;
            $leadershipcompanyname = Company::find()->where(['id' => $todayslesssoncategory])->one();
            $todayslesssoncount = count(PilotTodayslessonCorner::find()->where(['category_id' => $todayslesssoncategory])->all());
            $todayslessson = PilotTodayslessonCategory::find()->where(['id' => $todayslesssoncategory])->one();
            $didyoucategory = $model->did_you_know_content;
            $didyouchallengecount = count(PilotDidyouknowCorner::find()->where(['category_id' => $didyoucategory])->all());
            $didyouchallenge = PilotDidyouknowCategory::find()->where(['id' => $didyoucategory])->one();
            $gettoknowcategory = $model->get_to_know_content;
            $gettoknowchallengecount = count(PilotGettoknowCorner::find()->where(['category_id' => $gettoknowcategory])->all());
            $gettoknowchallenge = PilotGettoknowCategory::find()->where(['id' => $gettoknowcategory])->one();
        endif;
        if ($challid == 8 || $challid == 11):
            $todayslesssoncategory = $model->todays_lesson_content;
            $leadershipcompanyname = Company::find()->where(['id' => $todayslesssoncategory])->one();
            $todayslesssoncount = count(PilotTodayslessonCorner::find()->where(['category_id' => $todayslesssoncategory])->all());
            $todayslessson = PilotTodayslessonCategory::find()->where(['id' => $todayslesssoncategory])->one();
            $didyoucategory = $model->did_you_know_content;
            $didyouchallengecount = count(PilotDidyouknowCorner::find()->where(['category_id' => $didyoucategory])->all());
            $didyouchallenge = PilotDidyouknowCategory::find()->where(['id' => $didyoucategory])->one();
            $gettoknowcategory = $model->voicematters_content;
            $gettoknowchallengecount = count(PilotActionmattersChallenge::find()->where(['category_id' => $gettoknowcategory])->all());
            $gettoknowchallenge = PilotActionmattersCategory::find()->where(['id' => $gettoknowcategory])->one();
        endif;
       // echo '<pre>';print_r($leadershipcategory);die;
        $fea = $model->features;
        $featarray = explode(',', $fea);
        foreach ($featarray as $key => $val) {
            $features[] = PilotCreateGameFeatures::find()->where(['id' => $val])->one();
        }
        $company = Company::find()->where(['id' => $cid])->one();
        $teams = PilotCompanyTeams::find()->where(['company_id' => $cid])->all();
        $gamechallengename = PilotGameChallengeName::find()->where(['id' => $challid])->one();
        if ($challid != 7 & $challid != 8 && $challid != 11):
            return $this->render('report', ['model' => $model,
                        'company' => $company,
                        'teams' => $teams,
                        'features' => $features,
                        'gamechallengename' => $gamechallengename,
                        'userlisting' => $userlisting,
                        'surveymodel' => $surveymodel,
                        'userlisting' => $userlisting,
                        'challid' => $challid,
                        'cid' => $cid,
                        'id' => $id,
                        'dailycategory' => $dailycategory,
                        'dailyinspirationcount' => $dailyinspirationcount,
                        'weeklycategory' => $weeklycategory,
                        'weeklychallengecount' => $weeklychallengecount,
                        'leadershipcorner' => $leadershipcorner,
                        'leadershipcompanyname' => $leadershipcompanyname,
                        'leadershipcornercount' => $leadershipcornercount,
                        'dailyinspiration' => $dailyinspiration,
                        'weeklychallenge' => $weeklychallenge,
                        'leadershipcategory' => $leadershipcategory,
                        'corevalueid' => $corevalueid,
                        'corecount' => $corecount,
                        'corecategory' => $corecategory,
                        'howitwork' => $howitwork,
                        'checkin' => $checkin,
                        'checkincount' => $checkincount,
                        'prizecategory' => $prizecategory,
            ]);
        endif;
        if ($challid == 7):
            return $this->render('report', ['model' => $model,
                        'company' => $company,
                        'teams' => $teams,
                        'features' => $features,
                        'gamechallengename' => $gamechallengename,
                        'userlisting' => $userlisting,
                        'surveymodel' => $surveymodel,
                        'userlisting' => $userlisting,
                        'challid' => $challid,
                        'cid' => $cid,
                        'id' => $id,
                        'dailycategory' => $dailycategory,
                        'dailyinspirationcount' => $dailyinspirationcount,
                        'didyoucategory' => $didyoucategory,
                        'gettoknowcategory' => $gettoknowcategory,
                        'didyouchallengecount' => $didyouchallengecount,
                        'gettoknowchallengecount' => $gettoknowchallengecount,
                        'todayslessson' => $todayslessson,
                        'leadershipcompanyname' => $leadershipcompanyname,
                        'todayslesssoncount' => $todayslesssoncount,
                        'dailyinspiration' => $dailyinspiration,
                        'didyouchallenge' => $didyouchallenge,
                        'gettoknowchallenge' => $gettoknowchallenge,
                        'todayslesssoncategory' => $todayslesssoncategory,
                        'howitwork' => $howitwork,
                        'checkin' => $checkin,
                        'checkincount' => $checkincount,
                        'prizecategory' => $prizecategory,
            ]);
        endif;
        if ($challid == 8 || $challid == 11):
            return $this->render('report', ['model' => $model,
                        'company' => $company,
                        'teams' => $teams,
                        'features' => $features,
                        'gamechallengename' => $gamechallengename,
                        'userlisting' => $userlisting,
                        'surveymodel' => $surveymodel,
                        'userlisting' => $userlisting,
                        'challid' => $challid,
                        'cid' => $cid,
                        'id' => $id,
                        'dailycategory' => $dailycategory,
                        'dailyinspirationcount' => $dailyinspirationcount,
                        'didyoucategory' => $didyoucategory,
                        'gettoknowcategory' => $gettoknowcategory,
                        'didyouchallengecount' => $didyouchallengecount,
                        'gettoknowchallengecount' => $gettoknowchallengecount,
                        'todayslessson' => $todayslessson,
                        'leadershipcompanyname' => $leadershipcompanyname,
                        'todayslesssoncount' => $todayslesssoncount,
                        'dailyinspiration' => $dailyinspiration,
                        'didyouchallenge' => $didyouchallenge,
                        'gettoknowchallenge' => $gettoknowchallenge,
                        'todayslesssoncategory' => $todayslesssoncategory,
                        'howitwork' => $howitwork,
                        'checkin' => $checkin,
                        'checkincount' => $checkincount,
                        'prizecategory' => $prizecategory,
            ]);
        endif;
    }

    /*
     * get the count highfive on report page
     * through ajax hit when page load complete
     */

    public function actionGethighfivecount() {
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $_POST['challid']])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //highfive
        $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $highfivecount = count($model_highfive::find()->where(['game_id' => $_POST['challid'], 'company_id' => $_POST['cid']])
                        ->andWhere(['feature_label' => 'highfiveComment'])
                        ->andWhere(['between', 'created', $_POST['startdate'], $_POST['enddate']])
                        ->all());

        echo $highfivecount;
        exit();
        //echo '<pre>';print_r($_POST);die; 
    }

    /*
     * get the count share a win on report page
     * through ajax hit when page load complete
     */

    public function actionGetshareawincount() {
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $_POST['challid']])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //share a win
        $model_shareawin = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';
        $shareawincount = count($model_shareawin::find()->where(['game_id' => $_POST['challid'], 'company_id' => $_POST['cid']])
                        ->andWhere(['between', 'created', $_POST['startdate'], $_POST['enddate']])
                        ->all());
        echo $shareawincount;
        exit();
    }

    /*
     * get the count core values on report page
     * through ajax hit when page load complete
     */

    public function actionGetcheckincount() {
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $_POST['challid']])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //Check in
        $model_checkin = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';
        $checkincount = count($model_checkin::find()->where(['game_id' => $_POST['challid'], 'company_id' => $_POST['cid']])
                        ->andWhere(['!=', 'label', 'core_values_popup'])
                        ->andWhere(['between', 'created', $_POST['startdate'], $_POST['enddate']])
                        ->all());

        echo $checkincount;
        exit();
    }

    /*
     * get the count total points on report page
     * through ajax hit when page load complete
     */

    public function actionGettotalpointscount() {
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $_POST['challid']])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //share a win
        $model_totalpoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
        $checkincount = $model_totalpoints::find()->where(['game_id' => $_POST['challid'], 'company_id' => $_POST['cid']])
                ->andWhere(['between', 'created', $_POST['startdate'], $_POST['enddate']])
                ->sum('total_game_actions');
        echo $checkincount;
        exit();
    }

    /*
     * get the count register user on report page
     * through ajax hit when page load complete
     */

    public function actionGetregisterusercount() {
        $usercount = \frontend\models\PilotFrontUser::find()->where(['company_id' => $_POST['cid']])
                        ->andWhere(['between', 'created', $_POST['regdate'], $_POST['enddate']])->all();

        echo count($usercount);
        exit();
    }

    /*
     * show listing of all digital high five
     * when click on highfive color tab on report page
     */

    public function actionDigitalhighfive() {
        return $this->render('digitalhighfive');
    }

    /*
     * show listing of all share a win
     * when click on shareawin color tab on report page
     */

    public function actionShareawin($id) {
        $searchModel = new PilotFrontCoreShareawinSearch();
        $dataProvider = $searchModel->searchbackend(Yii::$app->request->queryParams, $id);
        return $this->render('shareawin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    /*
     * show listing of all core values checkin
     * when click on core values color tab on report page
     */

    public function actionCorecheckin($id) {
        $searchModel = new PilotFrontCoreCheckinSearch();
        $dataProvider = $searchModel->searchbackend(Yii::$app->request->queryParams, $id);
        return $this->render('corecheckin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    /*
     * show listing of all registered user
     * when click on core values color tab on report page
     */

    public function actionRegistereduser($id) {
        $searchModel = new PilotFrontUserSearch();
        $dataProvider = $searchModel->searchbackend(Yii::$app->request->queryParams, $id);
        return $this->render('registereduser', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    /*
     * show listing of all active user
     * when click on active user color tab on report page
     */

    public function actionActiveuser($id) {
        $searchModel = new PilotFrontCoreTotalPointsSearch();
        $dataProvider = $searchModel->searchbackend(Yii::$app->request->queryParams, $id);
        return $this->render('activeuser', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

    /*
     * get the count total points on report page
     * through ajax hit when page load complete
     */

    public function actionGetscoreusercount() {
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $_POST['challid']])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //share a win
        $model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
        $scorecount = $model_scorepoints::find()->where(['game_id' => $_POST['challid'], 'company_id' => $_POST['cid']])
                ->andWhere(['between', 'created', $_POST['startdate'], $_POST['enddate']])
                ->andWhere(['and', "total_points>0"])
                ->all();
        echo count($scorecount);
        exit();
    }

    public function actionUserlistingpoints($id) {
        $model = $this->findModel($id);
        $cid = $model->challenge_company_id;
        $challid = $model->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
        // to get the all register user to the corrsponding company_id
        $frontregisteruser = \frontend\models\PilotFrontUser::find()->where(['company_id' => $cid])->all();
        $userlisting = [];
        // to find ongoing user ,playing , to get the points
        foreach ($frontregisteruser as $value) {
            $ongoinguser = $daily_model_name::find()->where(['game_id' => $challid, 'user_id' => $value->id, 'company_id' => $value->company_id])
                    ->andWhere(['between', 'created', $model->challenge_start_date, $model->challenge_end_date])
                    ->one();
            if (!empty($ongoinguser)):
                $username = \frontend\models\PilotFrontUser::find()->where(['id' => $ongoinguser->user_id])->one();
                $userlisting[] = array('total_points' => $ongoinguser->total_points, 'user_name' => $username->username, 'profile_pic' => $username->profile_pic, 'userid' => $username->id, 'updated' => $ongoinguser->updated);
            endif;
        }
        $sort = array();
        foreach ($userlisting as $key => $row) {
            $sort['total_points'][$key] = $row['total_points'];
            $sort['updated'][$key] = $row['updated'];
        }
        array_multisort($sort['total_points'], SORT_DESC, $sort['updated'], SORT_DESC, $userlisting);
        //Sort the Array in Descending Order as per Points
        // usort($userlisting, 'self::userPointsDescSort');

        return $this->render('userlistingpoints', [
                    'userlisting' => $userlisting
        ]);
    }

    /**
     * Function to Sort Users Points Array as per the Overall Points
     * @param type $item1
     * @param type $item2
     * @return int
     */
    public static function userPointsDescSort($item1, $item2) {
        if ($item1['total_points'] == $item2['total_points'])
            return 0;
        return ($item1['total_points'] < $item2['total_points']) ? 1 : -1;
    }

    /*
     *  ajax hit from game.js
     * get the team coressponding to the company id
     */

    public function actionGetteam() {
        if ($_POST) {
            $id = $_POST['compid'];
            $company = PilotCompanyTeams::find()->where(['company_id' => $id])->all();
            foreach ($company as $val) {
                $html .= '<div class="checkbox"><label><input type="checkbox" value="' . $val->id . '" name="PilotCreateGame[challenge_teams][]"> ' . $val->team_name . '</label></div>';
            }
            if (empty($company)) {
                $html = '<p class="help-block">No team available for selection</p>';
            }
            return $html;
        }
    }

    /*
     * ajax request from game.js
     * in listing page at reminder button
     */

    public function actionReminder() {
        $makeup_days = '';
        $html = '';
        $preview = '';
        $teams = '';
        $feature_name = '';
        $id = $_POST['modelid'];
        $game = PilotCreateGame::find()->where(['id' => $id])->one();
        $features = explode(',', $game->features);
        $survey_ques = explode(',', $game->survey_questions);
        // features
        foreach ($features as $features) {
            $feat[] = PilotCreateGameFeatures::find()->where(['id' => $features])->one();
        }
        foreach ($feat as $featr) {
            $featurename[$featr->name] = $featr->font_awesome_class;
        }
        foreach ($featurename as $featkey => $featval) {
            $feature_name .= '<p style="float:left;width:50%;"><i class="' . $featval . '"></i>' . $featkey . '</p>';
        }
        // survey
        foreach ($survey_ques as $ques) {
            $survey[] = PilotSurveyQuestion::find()->where(['id' => $ques])->one();
        }
        foreach ($survey as $surveyQ) {
            $surveyname .= '<p style="float:left;width:50%;">' . $surveyQ->question . '</p>';
        }
        //email
        $email = '';
        $email_1 = $game->executive_email_1;
        $email_2 = $game->executive_email_2;
        $email_3 = $game->executive_email_3;
        $email_inhouse_1 = $game->inhouse_email_1;
        $email_inhouse_2 = $game->inhouse_email_2;
        $email_inhouse_3 = $game->inhouse_email_3;
        if ($email_1 != '') {
            $email .= '<p style="float:left;width:50%;"><i style="margin-right:5px;" class="fa fa-envelope"></i>' . $email_1 . '</p>';
        }
        if ($email_2 != '') {
            $email .= '<p style="float:left;width:50%;"><i style="margin-right:5px;" class="fa fa-envelope"></i>' . $email_2 . '</p>';
        }
        if ($email_3 != '') {
            $email .= '<p style="float:left;width:50%;"><i style="margin-right:5px;" class="fa fa-envelope"></i>' . $email_3 . '</p>';
        }
        if ($email_inhouse_1 != '') {
            $email .= '<p style="float:left;width:50%;"><i style="margin-right:5px;" class="fa fa-envelope"></i>' . $email_inhouse_1 . '</p>';
        }
        if ($email_inhouse_2 != '') {
            $email .= '<p style="float:left;width:50%;"><i style="margin-right:5px;" class="fa fa-envelope"></i>' . $email_inhouse_2 . '</p>';
        }
        if ($email_inhouse_3 != '') {
            $email .= '<p style="float:left;width:50%;"><i style="margin-right:5px;" class="fa fa-envelope"></i>' . $email_inhouse_3 . '</p>';
        }
        $dailycategory = $game->daily_inspiration_content;
        $dailyinspirationcount = count(PilotDailyinspirationImage::find()->where(['category_id' => $dailycategory])->all());
        $dailyinspiration = PilotDailyinspirationCategory::find()->where(['id' => $dailycategory])->one();

        if ($game->challenge_id != 7 && $game->challenge_id != 8 && $game->challenge_id != 11):
            $leadershipcorner = $game->leadership_corner_content;
            $leadershipcompanyname = Company::find()->where(['id' => $leadershipcorner])->one();
            $leadershipcornercount = count(PilotLeadershipCorner::find()->where(['category_id' => $leadershipcorner])->all());
            $leadershipcategory = PilotLeadershipCategory::find()->where(['id' => $leadershipcorner])->one();
            $weeklycategory = $game->weekly_challenge_content;
            $weeklychallengecount = count(PilotWeeklyChallenge::find()->where(['category_id' => $weeklycategory])->all());
            $weeklychallenge = PilotWeeklyCategory::find()->where(['id' => $weeklycategory])->one();
            $corevalueid = $game->core_value_content;
            $corecount = count(PilotCompanyCorevaluesname::find()->where(['company_id' => $corevalueid])->all());
            $checkin = PilotCheckinYourselfCategory::find()->where(['id' => $game->checkin_yourself_content])->one();
            $checkincount = count(PilotCheckinYourselfData::find()->where(['category_id' => $game->checkin_yourself_content])->all());
            $corecategory = Company::find()->where(['id' => $corevalueid])->one();
        endif;
        if ($game->challenge_id == 7):
            $lessoncorner = $game->todays_lesson_content;
            $leadershipcompanyname = Company::find()->where(['id' => $lessoncorner])->one();
            $leadershipcornercount = count(PilotTodayslessonCorner::find()->where(['category_id' => $lessoncorner])->all());
            $leadershipcategory = PilotTodayslessonCategory::find()->where(['id' => $lessoncorner])->one();
            $didyoucategory = $game->did_you_know_content;
            $didyouchallengecount = count(PilotDidyouknowCorner::find()->where(['category_id' => $didyoucategory])->all());
            $didyouchallenge = PilotDidyouknowCategory::find()->where(['id' => $didyoucategory])->one();
            $gettoknowcategory = $game->get_to_know_content;
            $gettoknowchallengecount = count(PilotGettoknowCorner::find()->where(['category_id' => $gettoknowcategory])->all());
            $gettoknowchallenge = PilotGettoknowCategory::find()->where(['id' => $gettoknowcategory])->one();
        endif;
        if ($game->challenge_id == 8):
            $lessoncorner = $game->todays_lesson_content;
            $leadershipcompanyname = Company::find()->where(['id' => $lessoncorner])->one();
            $leadershipcornercount = count(PilotTodayslessonCorner::find()->where(['category_id' => $lessoncorner])->all());
            $leadershipcategory = PilotTodayslessonCategory::find()->where(['id' => $lessoncorner])->one();
            $didyoucategory = $game->did_you_know_content;
            $didyouchallengecount = count(PilotDidyouknowCorner::find()->where(['category_id' => $didyoucategory])->all());
            $didyouchallenge = PilotDidyouknowCategory::find()->where(['id' => $didyoucategory])->one();
            $gettoknowcategory = $game->voicematters_content;
            $gettoknowchallengecount = count(PilotActionmattersChallenge::find()->where(['category_id' => $gettoknowcategory])->all());
            $gettoknowchallenge = PilotActionmattersCategory::find()->where(['id' => $gettoknowcategory])->one();
        endif;
        if ($game->challenge_id == 11):
            $lessoncorner = $game->todays_lesson_content;
            $leadershipcompanyname = Company::find()->where(['id' => $lessoncorner])->one();
            $leadershipcornercount = count(PilotTodayslessonCorner::find()->where(['category_id' => $lessoncorner])->all());
            $leadershipcategory = PilotTodayslessonCategory::find()->where(['id' => $lessoncorner])->one();
            $didyoucategory = $game->did_you_know_content;
            $didyouchallengecount = count(PilotDidyouknowCorner::find()->where(['category_id' => $didyoucategory])->all());
            $didyouchallenge = PilotDidyouknowCategory::find()->where(['id' => $didyoucategory])->one();
            $gettoknowcategory = $game->voicematters_content;
            $gettoknowchallengecount = count(PilotActionmattersChallenge::find()->where(['category_id' => $gettoknowcategory])->all());
            $gettoknowchallenge = PilotActionmattersCategory::find()->where(['id' => $gettoknowcategory])->one();
        endif;
        $howitwork = PilotHowItWork::find()->where(['id' => $game->howitwork_content])->one();
        $prizecategory = PilotPrizesCategory::find()->where(['id' => $game->prize_content])->one();
        if (!empty($game->challenge_teams)):
            $team = explode(',', $game->challenge_teams);
            // tema
            foreach ($team as $team) {
                $teamname[] = PilotCompanyTeams::find()->where(['id' => $team])->all();
            }
            foreach ($teamname as $val) {
                foreach ($val as $value) {
                    $teamName[] = $value->team_name;
                }
            }
            foreach ($teamName as $name) {
                $teams .= '<p style="font-weight: normal;font-size: 14px;float:left;width:50%;"><i style="margin-right:5px;" class="fa fa-users"></i>' . $name . '</p>';
            }
        endif;
        $cid = $game->challenge_id;
        $companyid = $game->challenge_company_id;
        $company = Company::find()->where(['id' => $companyid])->one();
        $gamechallengename = PilotGameChallengeName::find(['challenge_name'])->where(['id' => $cid])->one();
        $challengename = $gamechallengename->challenge_name . ' (Reminder)';
        $gamename = $gamechallengename->challenge_abbr_name;
        $companyname = (str_replace(' ', '-', strtolower($company->company_name)));
        $start = $game->challenge_start_date;
        $startdate = date("D M d, Y", $start);
        $reg = $game->challenge_registration_date;
        $registrationdate = date("D M d, Y", $reg);
        $sevenday = strtotime("-7 days", $start);
        $sevendayreminder = date("D M d, Y", $sevenday);
        $fiveday = strtotime("-5 days", $start);
        $fivedayreminder = date("D M d, Y", $fiveday);
        $threeday = strtotime("-3 days", $start);
        $threedayreminder = date("D M d, Y", $threeday);
        $end = $game->challenge_end_date;
        $enddate = date("D M d, Y", $end);

        if (empty($game->banner_text_1) && empty($game->banner_text_2)) {
            $game_name = $gamechallengename->challenge_name;
        } else {
            $game_name = $game->banner_text_1 . ' ' . $game->banner_text_2;
        }
//        $survey = strtotime("-7 days", $end);
//        $surveydate = date("D M d, Y", $survey);
        if (($game->survey) == 1) {
            $survey = $game->challenge_survey_date;
            $surveydate = date("D M d, Y", $survey);
        } else {
            $surveydate = 'Not Included';
        }
        if ($game->makeup_days) {
            $diff = abs($game->challenge_end_date - $game->makeup_days);
            if (!empty($diff)) {
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                for ($i = 0; $i <= $days; $i++) {
                    $makeupdate = date('D M d, Y', strtotime("+$i day", $game->makeup_days));
                    $makeup_days .= '<p  style="font-weight: bold;font-size: 14px;width:50%;float:left;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="registration-date">' . $makeupdate . '</span></p>';
                }
            }
        }
        if (!empty($game->banner_image)):
            $banner = '<img style ="width:100%; margin-right: 10px;margin-bottom:7px" src="' . Yii::$app->homeUrl . 'img/game/welcome_banner/' . $game->banner_image . '">';
        else:
            $banner = '<img style ="height: 150px; margin-right: 10px;margin-bottom:7px" src="' . Yii::$app->homeUrl . 'img/game/' . $gamechallengename->challenge_image . '">';
        endif;
        $makup_html = '';
        if ($makeup_days) {
            $makup_html = '<div class="col-md-12 makeupdays">
			       <h4 style="color:#45C0EC">Makeup Days</h4>
                               ' . $makeup_days . '
                           </div>';
        }
        $html .= '<div class="row">
                    <table class="table table-striped table-bordered">
                         <tr><td><ul><li>' . $registrationdate . ' the game registration date reminder</li></ul></td></tr>
                         <tr><td><ul><li>' . $sevendayreminder . ' the game start reminder</li></ul></td></tr>
                         <tr><td><ul><li>' . $fivedayreminder . ' the game content ready on reminder </li></ul></td></tr>
                         <tr><td><ul><li>' . $threedayreminder . ' the game will start in three days</li></ul></td></tr>
                         <tr><td><ul><li>' . $startdate . ' the game start date reminder</li></ul></td></tr>
                         <tr><td><ul><li>' . $surveydate . ' the survey live on reminder</li></ul></td></tr>
                         <tr><td><ul><li>' . $enddate . ' the game end date reminder</li></ul></td></tr>
                         <tr><td></td></tr>     
                    </table>
                 </div>';

        $preview .= '<div class="row">
                        <div id="game-img-src" class="col-md-6">' . $banner . '
                            <br><a id ="gameid" style="font-weight: bold;color:#000000;font-size:15px" href="http://' . $companyname . '.injoychange.com/' . $gamename . '" target="_blank">' . $companyname . '.injoychange.com/' . $gamename . '</a>
                        </div>
                        <div class="col-md-6">
                            <h4 id ="game-name" style="font-weight: bold; margin-top: 0;">' . $game_name . '</h4>
                            <p id="company-name-preview">' . $company->company_name . '</p>
                        </div>
                     </div>
                     <hr style="border-bottom: 1px solid #ccc; margin:0px;">
                     <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Team</h4>
                            <div id="selected-team">'
                . $teams .
                '</div>
                     </div>
                     </div>
                     <hr style="border-bottom: 1px solid #ccc; margin:0px;">
                     <div class="row">
                        <div class="col-md-6">
                            <h4 style="color:#45C0EC">Start Date</h4>
                            <p  style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="start-date">' . $startdate . '</span></p>
                            <h4 style="color:#45C0EC">Survey Date</h4>
                            <p  style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="survey-date-preview">' . $surveydate . '</span></p>
                        </div>
                        <div class="col-md-6">
                            <h4 style="color:#45C0EC">Registration Start From</h4>
                            <p style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="registration-date">' . $registrationdate . '</span></p>
                            <h4 style="color:#45C0EC">End Date</h4>
                            <p style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="end-date">' . $enddate . '</span></p>
                        </div>
                            ' . $makup_html . '								
                    </div>
                    <hr style="border-bottom: 1px solid #ccc;margin:0px;">';

        $preview .= '<div class="row">
                        <h4 style="color:#11B89A;padding-left:15px;">Content</h4>
						<div class="col-md-12">
						 <div class="row">
                          <div class="col-md-6">
                            <p> <b>Daily Inspiration Content</b></p>
						  </div>
						  <div class="col-md-6">
							<p><span id="daily">' . $dailyinspiration->category_name . '(' . $dailyinspirationcount . ' Images)' . '</span><a target="_blank" id="daily_href" style="padding-left:5px" href="' . Yii::$app->homeUrl . '/pilot-dailyinspiration-category/dailyinspiration?cid=' . $dailycategory . '">View Content</a></p>
						  </div>
						 </div>
						<hr style="margin:0px;">
						</div>';
        if ($cid != 7 && $cid != 8 && $cid != 11):
            $preview .= '<div class="col-md-12">
						  <div class="row">
							<div class="col-md-6">
								<p><b>Leadership Corner Content</b></p>
							</div>
							<div class="col-md-6">
								<p><span id="corner">' . $leadershipcategory->category_name . '(' . $leadershipcornercount . ' Corner)' . '</span><a target="_blank" id="corner_href" style="padding-left:5px" href="' . Yii::$app->homeUrl . '/pilot-leadership-corner/index?cid=' . $leadershipcorner . '">View Content</a></p>
							</div>
						  </div>
						<hr style="margin:0px;">
						</div>
                                                <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-6">
            <p> <b>Weekly Challenge Content</b></p>
            </div>
            <div class = "col-md-6">
            <p><span id = "weekly">' . $weeklychallenge->category_name . '(' . $weeklychallengecount . ' Video)' . '</span><a target = "_blank" id = "weekly_href" style = "padding-left:5px" href = "' . Yii::$app->homeUrl . '/pilot-weekly-challenge/index?cid=' . $weeklycategory . '">View Content</a></p>
            </div>
            </div>
            <hr style = "margin:0px;">
            </div>
            <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-6">
            <p><b>Core Value Content</b></p>
            </div>
            <div class = "col-md-6">
            <p><span id = "corner">' . $corecategory->company_name . '(' . $corecount . ' Corner)' . '</span><a target = "_blank" id = "corner_href" style = "padding-left:5px" href = "' . Yii::$app->homeUrl . '/pilot-corevalues/index">View Content</a></p>
            </div>
            </div>
            <hr style = "margin:0px;">
            </div>
            <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-6">
            <p> <b>Checkin Yourself Content</b></p>
            </div>
            <div class = "col-md-6">
            <p><span id = "daily">' . $checkin->category_name . '(' . $checkincount . ' Corner)' . '</span><a target = "_blank" id = "daily_href" style = "padding-left:5px" href = "' . Yii::$app->homeUrl . 'pilot-checkin-yourself-category/index">View Content</a></p>
            </div>
            </div>
            <hr style = "margin:0px;">
            </div>';
        endif;
        if ($cid == 7):
            $preview .= '<div class="col-md-12">
						  <div class="row">
							<div class="col-md-6">
								<p><b>Todays Lesson Content</b></p>
							</div>
							<div class="col-md-6">
								<p><span id="corner">' . $leadershipcategory->category_name . '(' . $leadershipcornercount . ' Corner)' . '</span><a target="_blank" id="corner_href" style="padding-left:5px" href="' . Yii::$app->homeUrl . '/pilot-todayslesson-corner/index?cid=' . $lessoncorner . '">View Content</a></p>
							</div>
						  </div>
						<hr style="margin:0px;">
						</div>
                <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-6">
            <p> <b>Did You Know Content</b></p>
            </div>
            <div class = "col-md-6">
            <p><span id = "weekly">' . $didyouchallenge->category_name . '(' . $didyouchallengecount . ' Corner)' . '</span><a target = "_blank" id = "weekly_href" style = "padding-left:5px" href = "' . Yii::$app->homeUrl . '/pilot-didyouknow-corner/index?cid=' . $didyoucategory . '">View Content</a></p>
            </div>
            </div>
            <hr style = "margin:0px;">
            </div>
            <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-6">
            <p><b>Know the Team Content</b></p>
            </div>
            <div class = "col-md-6">
            <p><span id = "corner">' . $gettoknowchallenge->category_name . '(' . $gettoknowcountchallengecount . ' Corner)' . '</span><a target = "_blank" id = "corner_href" style = "padding-left:5px" href = "' . Yii::$app->homeUrl . '/pilot-gettoknow-corner/index?cid=' . $gettoknowcategory . '">View Content</a></p>
            </div>
            </div>
            <hr style = "margin:0px;">
            </div>';
        endif;
        if ($cid == 8 || $cid ==11):
            $preview .= '<div class="col-md-12">
						  <div class="row">
							<div class="col-md-6">
								<p><b>Todays Lesson Content</b></p>
							</div>
							<div class="col-md-6">
								<p><span id="corner">' . $leadershipcategory->category_name . '(' . $leadershipcornercount . ' Corner)' . '</span><a target="_blank" id="corner_href" style="padding-left:5px" href="' . Yii::$app->homeUrl . '/pilot-todayslesson-corner/index?cid=' . $lessoncorner . '">View Content</a></p>
							</div>
						  </div>
						<hr style="margin:0px;">
						</div>
                                                <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-6">
            <p> <b>Did You Know Content</b></p>
            </div>
            <div class = "col-md-6">
            <p><span id = "weekly">' . $didyouchallenge->category_name . '(' . $didyouchallengecount . ' Corner)' . '</span><a target = "_blank" id = "weekly_href" style = "padding-left:5px" href = "' . Yii::$app->homeUrl . '/pilot-didyouknow-corner/index?cid=' . $didyoucategory . '">View Content</a></p>
            </div>
            </div>
            <hr style = "margin:0px;">
            </div>
            <div class = "col-md-12">
            <div class = "row">
            <div class = "col-md-6">
            <p><b>Voice Matters Content</b></p>
            </div>
            <div class = "col-md-6">
            <p><span id = "corner">' . $gettoknowchallenge->category_name . '(' . $gettoknowcountchallengecount . ' Question)' . '</span><a target = "_blank" id = "corner_href" style = "padding-left:5px" href = "' . Yii::$app->homeUrl . '/pilot-voicematters-challenge/index?cid=' . $gettoknowcategory . '">View Content</a></p>
            </div>
            </div>
            <hr style = "margin:0px;">
            </div>';
        endif;
        $preview .= '<div class="col-md-12">
						 <div class="row">
                                                    <div class="col-md-6">
                                                        <p> <b>How It Work Content</b></p>
						  </div>
						  <div class="col-md-6">
							<p><span id="daily">' . $howitwork->category_name . '</span><a target="_blank" id="daily_href" style="padding-left:5px" href="' . Yii::$app->homeUrl . 'pilot-how-it-work/index">View Content</a></p>
						  </div>
						 </div>
						<hr style="margin:0px;">
						</div>
                                                <div class="col-md-12">
						 <div class="row">
                                                    <div class="col-md-6">
                                                        <p> <b>Prize Content</b></p>
						  </div>
						  <div class="col-md-6">
							<p><span id="daily">' . $prizecategory->category_name . '</span><a target="_blank" id="daily_href" style="padding-left:5px" href="' . Yii::$app->homeUrl . 'pilot-prizes-category/index">View Content</a></p>
						  </div>
						 </div>
						<hr style="margin:0px;">
						</div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Features</h4>
                            <div  id="features">
                            ' . $feature_name . '
                            </div>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #ccc;margin:0px;">
                    <div class="row">
                        <div class="col-md-6" id="survey"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Survey</h4>
                            <div  id="survey-questions">' . $surveyname . '</div>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #ccc;margin:0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Reports</h4>
                            <div id="reports">' . $email . '</div>
                        </div>
                    </div>';

        $data = array('html' => $html, 'preview' => $preview);
        return \yii\helpers\Json::encode($data);
    }

    public function actionGameName($id) {
        $id = Yii::$app->request->get('id');
        $game_obj = PilotGameChallengeName::find()->where(['id' => $id])->one();
        $output['filename'] = $game_obj->challenge_abbr_name;
        $output['image'] = $game_obj->challenge_image;
        return json_encode($output);
    }

    public function actionNotification() {
        $emailtemplate = new PilotEmailTemplate();
        $model = PilotEmailNotification::find()->all();
        $current_time = time();
        $current_date = date("d-M-Y", $current_time);

        foreach ($model as $val) {
            if (($val->date) == $current_date) {
                $emailtemplate = new PilotEmailTemplate();
                $emailtemplate->subject = $val->subject;
                $emailtemplate->save(false);
                $gamereports = PilotCreateGame::find()->where(['id' => $val->game_id])->one();
                if (!empty($gamereports->executive_email_1)) {
                    PilotCreateGameController::sendmailyii($gamereports->executive_email_1, $val->subject);
                }
                if (!empty($gamereports->executive_email_2)) {
                    PilotCreateGameController::sendmailyii($gamereports->executive_email_2, $val->subject);
                }
                if (!empty($gamereports->executive_email_3)) {
                    PilotCreateGameController::sendmailyii($gamereports->executive_email_3, $val->subject);
                }
                if (!empty($gamereports->inhouse_email_1)) {
                    PilotCreateGameController::sendmailyii($gamereports->inhouse_email_1, $val->subject);
                }
                if (!empty($gamereports->inhouse_email_2)) {
                    PilotCreateGameController::sendmailyii($gamereports->inhouse_email_2, $val->subject);
                }
                if (!empty($gamereports->inhouse_email_3)) {
                    PilotCreateGameController::sendmailyii($gamereports->inhouse_email_3, $val->subject);
                }
            }
        }
        $log = new PilotLogs();
        $log->message = 'Notification hit by crone!!!';
        $log->type = 'page';
        $log->log_type = 'info';
        $log->save(false);
        // echo 'Mail has been sent';
        // return $this->render('notification');
    }

    public function sendmail($tto, $sub) {
        $to = $tto;
        $subject = $sub;
        $message = 'Hello, Reminder about the game challenge';
        $headers = 'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    public function sendmailyii($tto, $sub) {
        Yii::$app->mailer->compose()
                ->setFrom('from@domain.com')
                ->setTo($tto)
                ->setSubject($sub)
                ->setTextBody('Plain text content')
                ->setHtmlBody('<b>' . $sub . ' </b>')
                ->send();
    }

    public function actionCurrentgame() {
        $gamemodel = PilotCreateGame::find()->all();
        foreach ($gamemodel as $model) {
            $challenge = Company::find()->where(['id' => $model->challenge_company_id])->one();
//            if (!empty($challenge->timezone)):
//                date_default_timezone_set($challenge->timezone);
//            endif;
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

    public function actionDownloadactiveuser($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
//share a win
        $model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
        $activeuser = $model_scorepoints::find()->where(['game_id' => $challid, 'company_id' => $cid])
                        ->andWhere(['between', 'created', $gamemodel->challenge_start_date, $gamemodel->challenge_end_date])
                        ->andWhere(['and', "total_points>0"])->all();
        $data[] = array_filter(array('Full Name', 'Email Address', 'Total Points'));

        foreach ($activeuser as $value) {
            $user = PilotFrontUser::find()->where(['id' => $value->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'email' => $user->emailaddress, 'total_points' => $value->total_points);
        }

        return $this->render('weekly-reports/generate_activeuser', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
// header('Content-Type: text/xls; charset=utf-8');
//
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=activeuser.xls');
//        //header("Pragma: no-cache");
//        //header("Expires: 0");
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }

    /*
     * downloading registered user
     */

    public function actionDownloadregistereduser($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $registereduser = PilotFrontUser::find()->where(['company_id' => $cid, 'challenge_id' => $challid])->all();
        $data[] = array_filter(array('Full Name', 'Email Address'));
        foreach ($registereduser as $user) {
            $dataxls[] = array('username' => $user->username, 'email' => $user->emailaddress);
        }
        return $this->render('weekly-reports/generate_reports', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=registereduser.xls');
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }

    /*
     * downloading core values
     */

    public function actionDownloadcorevalues($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';

        $corevalues = $model_highfive::find()->where(['game_id' => $challid, 'company_id' => $cid, 'challenge_id' => $id])
                        ->andWhere(['!=', 'label', 'core_values_popup'])->orderBy(['created' => SORT_ASC])->all();
        $data[] = array_filter(array('Full Name', 'Email Address', 'Date', 'Time', 'Core Values', 'Comment'));
        foreach ($corevalues as $core) {
            $user = PilotFrontUser::find()->where(['id' => $core->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'emailaddress' => $user->emailaddress, 'date' => date('F j, Y', $core->created), 'time' => date('g:i a', $core->created), 'label' => $core->label, 'comment' => json_decode($core->comment));
        }
        usort($dataxls, function($a, $b) {
            return (strtotime($a['time']) > strtotime($b['time']));
        });
        return $this->render('weekly-reports/generate_corevalue', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=corevalues.xls');
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }

    /*
     * downloading share a win
     */

    public function actionDownloadshareawin($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
//share a win
        $model_shareawin = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';
        $shareawin = $model_shareawin::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_shareawin.company_id' => $cid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_shareawin.challenge_id' => $id])->orderBy(['created' => SORT_ASC])->all();

        $data[] = array_filter(array('Full Name', 'Email Address', 'Date', 'Time', 'Comment'));
        foreach ($shareawin as $share) {
            $user = PilotFrontUser::find()->where(['id' => $share->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'emailaddress' => $user->emailaddress, 'date' => date('F j, Y', $share->created), 'time' => date('g:i a', $share->created), 'comment' => json_decode($share->comment));
        }

        usort($dataxls, function($a, $b) {
            return (strtotime($a['time']) > strtotime($b['time']));
        });
        return $this->render('weekly-reports/generate_shareawin', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=shareawin.xls');
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }

    public function actionDownloadhighfive($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';

        $highfive = $model_highfive::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_highfive.company_id' => $cid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_highfive.challenge_id' => $id])
                        ->andWhere(['feature_label' => 'highfiveComment'])->orderBy(['created' => SORT_ASC])->all();

        $data[] = array_filter(array('Full Name', 'Email Address', 'Date', 'Time', 'High Five Comment'));
        foreach ($highfive as $high) {
            $user = PilotFrontUser::find()->where(['id' => $high->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'emailaddress' => $user->emailaddress, 'date' => date('F j, Y', $high->created), 'time' => date('g:i a', $high->created), 'comment' => json_decode($high->feature_value));
        }

        usort($dataxls, function($a, $b) {
            return (strtotime($a['time']) > strtotime($b['time']));
        });
        return $this->render('weekly-reports/generate_highfive', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=digitalhighfive.xls');
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }

    public function actionDownloadDailyinspiration($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';

        $highfive = $model_highfive::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_dailyinspiration.company_id' => $cid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_dailyinspiration.challenge_id' => $id])
                        ->orderBy(['created' => SORT_ASC])->all();
        //echo '<pre>';print_r($highfive);die;
        $sort = array();
        $data[] = array_filter(array('Full Name', 'Email Address', 'Date', 'Time'));
//        foreach ($highfive as $high) {
//            $time = date('g:i a', $high->created);
//            array_push($sort, $time);
//        }
//        usort($sort, function($a, $b) {
//            return (strtotime($a) > strtotime($b));
//        });
        foreach ($highfive as $high) {
            $user = PilotFrontUser::find()->where(['id' => $high->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'emailaddress' => $user->emailaddress, 'date' => date('F j, Y', $high->created), 'time' => date('g:i a', $high->created));
        }
        usort($dataxls, function($a, $b) {
            return (strtotime($a['time']) > strtotime($b['time']));
        });
        return $this->render('weekly-reports/generate_daily', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=digitalhighfive.xls');
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }

    public function actionDownloadLeadershipcorner($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';

        $highfive = $model_highfive::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_leadershipcorner.company_id' => $cid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_leadershipcorner.challenge_id' => $id])
                        ->andWhere(['!=', 'user_id', '468'])->orderBy(['created' => SORT_ASC])->all();

        $data[] = array_filter(array('Full Name', 'Email Address', 'Date', 'Time'));
        foreach ($highfive as $high) {
            $user = PilotFrontUser::find()->where(['id' => $high->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'emailaddress' => $user->emailaddress, 'date' => date('F j, Y', $high->created), 'time' => date('g:i a', $high->created));
        }
        usort($dataxls, function($a, $b) {
            return (strtotime($a['time']) > strtotime($b['time']));
        });
        return $this->render('weekly-reports/generate_leadership', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=digitalhighfive.xls');
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }

    public function actionDownloadWeeklychallenge($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';

        $highfive = $model_highfive::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_weeklychallenge.company_id' => $cid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_weeklychallenge.challenge_id' => $id])
                        ->orderBy(['created' => SORT_ASC])->all();

        $data[] = array_filter(array('Full Name', 'Email Address', 'Date', 'Time', 'Comment'));
        foreach ($highfive as $high) {
            $user = PilotFrontUser::find()->where(['id' => $high->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'emailaddress' => $user->emailaddress, 'date' => date('F j, Y', $high->updated), 'time' => date('g:i a', $high->updated), 'comment' => json_decode($high->comment));
        }
        usort($dataxls, function($a, $b) {
            return (strtotime($a['time']) > strtotime($b['time']));
        });
        return $this->render('weekly-reports/generate_weekly', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
//        header("Content-Type: application/vnd.ms-excel");
//        header('Content-Disposition: attachment;filename=digitalhighfive.xls');
//        foreach ($data as $row) {
//            echo implode("\t", array_values($row)) . "\n"; //for headers
//        }
//        foreach ($dataxls as $row) {
//            echo implode("\t", array_values($row)) . "\n";  //for data
//        }
//        exit;
    }
    
    public function actionDownloadVoiceMatters($id) {
        $gamemodel = \backend\models\PilotCreateGame::find()->where(['id' => $id])->one();
        $cid = $gamemodel->challenge_company_id;
        $challid = $gamemodel->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challid])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $model_highfive = '\frontend\\models\\PilotFront' . $challenge_abr . 'Question';

        $highfive = $model_highfive::find()->where(['game_id' => $challid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_question.company_id' => $cid, 'pilot_front_' . $challenge_obj->challenge_abbr_name . '_question.challenge_id' => $id])
                        ->orderBy(['created' => SORT_DESC])->all();

        $data[] = array_filter(array('Full Name', 'Email Address', 'Date','Comment'));
        foreach ($highfive as $high) {
            $user = PilotFrontUser::find()->where(['id' => $high->user_id])->one();
            $dataxls[] = array('username' => $user->username, 'emailaddress' => $user->emailaddress, 'date' => date('F j, Y g:i a', $high->created), 'comment' => json_decode($high->comment));
        }
//        usort($dataxls, function($a, $b) {
//            return (strtotime($a['time']) > strtotime($b['time']));
//        });
        return $this->render('weekly-reports/generate_voicematters', [
                    'gamemodel' => $gamemodel,
                    'comp_id' => $cid,
                    'data' => $data,
                    'dataxls' => $dataxls,
        ]);
    }

    /**
     * Generates Weekly Reports for the Challenge
     * @param integer $id & Week
     * @return mixed
     */
    public function actionWeeklyReports($id, $week) {
        $challenge_id = $id;
        $challenge_week = $week;
        //Game Challenge Details
        $game_obj = PilotCreateGame::find()->where(['id' => $challenge_id])->one();
        $game = $game_obj->challenge_id;
        $comp_id = $game_obj->challenge_company_id;
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);


        //Dynamically declare the Challenge Models

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';
        $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $share_a_win_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';
        $steps_api_model = '\frontend\\models\\PilotFront' . $challenge_abr . 'StepsApiData';


        //Get Total Users for Challenge Company
        $company_users = \frontend\models\PilotFrontUser::find()->where(['company_id' => $comp_id])->all();
        $users_weekly_points = [];

        //Get the Total Points for Each User
        foreach ($company_users as $user):
            if ($user->id !== 196): //Test User for Injoy
                $users_weekly_points[$user->id] = \frontend\models\PilotFrontUser::getUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week);
            endif;
        endforeach;
        //Sort Array in Decending order as per Total Points of Users
        arsort($users_weekly_points);
        //User Array for Report Generation 
        $user_arr = [];
        foreach ($users_weekly_points as $user_id => $total_points):
            $user_obj = \frontend\models\PilotFrontUser::findIdentity($user_id);
            //Total Daily Inspiration
            $daily_actions = count($daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                            ->andWhere(['<=', 'week_no', $week])
                            ->all());

            //Total Leadership Corner
            $corner_tips_actions = count($corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                            ->andWhere(['<=', 'week_no', $week])
                            ->all());

            //Total Weekly Entries
            $weekly_actions = count($weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                            ->andWhere(['<=', 'week_no', $week])
                            ->all());

            //Total High Fives
            $digital_hfs = count($high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])
                            ->andWhere(['<=', 'week_no', $week])
                            ->all());

            //Total Core Values
            $core_values = count($check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'label' => 'core_values_popup'])
                            ->andWhere(['<=', 'week_no', $week])
                            ->all());

            //Total Check Ins
            $chek_in_actions = count($check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                            ->andWhere(['<=', 'week_no', $week])
                            ->andWhere(['!=', 'label', 'core_values_popup'])
                            ->all());

            //Total Share a wins
            $share_a_wins = count($share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                            ->andWhere(['<=', 'week_no', $week])
                            ->all());

            //Total Steps
            $total_steps = 0;
            $steps_sum = $steps_api_model::find()->where(['user_id' => $user_id])
                    ->andWhere(['<=', 'week_no', $week])
                    ->sum('steps');
            if (!empty($steps_sum)):
                $total_steps = $steps_sum;
            endif;
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
                'shout_out' => $digital_hfs,
                'leadership_corner' => $corner_tips_actions,
                'weekly_video' => $weekly_actions,
                'share_a_wins' => $share_a_wins,
                'total_actions' => $total_actions,
                'total_steps' => $total_steps,
                'total_points' => $total_points,
                'raffle_ticket' => $raffle_ticket,
            ];
        endforeach;

        return $this->render('weekly-reports/generate_excel', [
                    'game' => $game,
                    'game_obj' => $game_obj,
                    'comp_id' => $comp_id,
                    'challenge_obj' => $challenge_obj,
                    'week' => $week,
                    'user_arr' => $user_arr,
        ]);
    }

    public function actionSurveyReports($id) {
        $game_obj = PilotCreateGame::find()->where(['id' => $id])->one();
        $game = $game_obj->challenge_id;
        $comp_id = $game_obj->challenge_company_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        $survey_model = '\frontend\\models\\PilotFront' . $challenge_abr . 'SurveyData';
        $surveyques = explode(',', $game_obj->survey_questions);
        $company_users = \frontend\models\PilotFrontUser::find()->where(['company_id' => $comp_id])->all();
        return $this->render('weekly-reports/generate_survey', [
                    'game' => $game,
                    'game_obj' => $game_obj,
                    'comp_id' => $comp_id,
                    'challenge_obj' => $challenge_obj,
                    'surveyques' => $surveyques,
                    'company_users' => $company_users,
                    'survey_model' => $survey_model,
        ]);
    }

    public function actionCoreValueImage() {
        $cnvimg1 = $_POST['core_image1'];
        $image_name = $_POST['image_name'];
        $cnvimg1 = str_replace('data:image/png;base64,', '', $cnvimg1);
        $cnvimg1 = str_replace(' ', '+', $cnvimg1);
        $data1 = base64_decode($cnvimg1);
        $file1 = time() . '.png';
        $location1 = getcwd() . '/img/game/core_value';
//        if (!empty($image_name) && $image_name != 'core.png'):
//            unlink($location1 . '/' . $image_name);
//        endif;
        //echo $data;die('sdsdsd');
        $success = file_put_contents($location1 . '/' . $file1, $data1);
        if ($success) {
            return $file1;
        } else {
            return "not saved";
        }
    }

    public function actionGetcompanygames($id) {
        $html = '<div class="selected_game2"><div class="overlay"><i class="fa fa-refresh fa-spin"></i> </div></div>';
        $model = new PilotCreateGame;
        if (!empty($id)):
            $challenge = PilotGameChallengeName::find()->where(['client_id' => $id])->all();
            if (empty($challenge)):
                $id = 0;
                $challenge = PilotGameChallengeName::find()->where(['client_id' => $id])->all();
                $form = ActiveForm::begin();
                $html .= $form->field($model, 'challenge_id')->radioList(ArrayHelper::map(PilotGameChallengeName::find()->all(), 'id', 'challenge_name'), ['disabled' => true])->label(false);
                foreach ($challenge as $challenges):
                    $html .= '<div class="selected_game" style="display:none"><div class="my-show"><i class="fa fa-check"></i><span class="selected_shadow_text">Selected</span><span class="selected_shadow"> </span></div><img  rel="' . $challenges->id . '" src="' . Yii::$app->homeUrl . 'img/game/' . $challenges->challenge_image . '"></div>';
                endforeach;
                return $html;
            endif;
            $form = ActiveForm::begin();
            $html .= $form->field($model, 'challenge_id')->radioList(ArrayHelper::map(PilotGameChallengeName::find()->all(), 'id', 'challenge_name'), ['disabled' => true])->label(false);
            foreach ($challenge as $challenges):
                $html .= '<div class="selected_game" style="display:none"><div class="my-show"><i class="fa fa-check"></i><span class="selected_shadow_text">Selected</span><span class="selected_shadow"> </span></div><img  rel="' . $challenges->id . '" src="' . Yii::$app->homeUrl . 'img/game/' . $challenges->challenge_image . '"></div>';
            endforeach;
            return $html;
        else:
            $id = 0;
            $challenge = PilotGameChallengeName::find()->where(['client_id' => $id])->all();
            $form = ActiveForm::begin();
            $html .= $form->field($model, 'challenge_id')->radioList(ArrayHelper::map(PilotGameChallengeName::find()->all(), 'id', 'challenge_name'), ['disabled' => true])->label(false);
            foreach ($challenge as $challenges):
                $html .= '<div class="selected_game" style="display:none"><div class="my-show"><i class="fa fa-check"></i><span class="selected_shadow_text">Selected</span><span class="selected_shadow"> </span></div><img  rel="' . $challenges->id . '" src="' . Yii::$app->homeUrl . 'img/game/' . $challenges->challenge_image . '"></div>';
            endforeach;
            return $html;
        endif;
    }

    public function actionGetcategorygames($id) {
        $html = '<div class="selected_game2"><div class="overlay"><i class="fa fa-refresh fa-spin"></i> </div></div>';
        $model = new PilotCreateGame;
        if (!empty($id)):
            $challenge = PilotGameChallengeName::find()->where(['category_id' => $id])->all();
            if (empty($challenge)):
                //foreach ($challenge as $challenges):
                $html .= '<div class="selected_game">No Games for this Category</div>';
                //endforeach;
                return $html;
            endif;
            $form = ActiveForm::begin();
            $html .= $form->field($model, 'challenge_id')->radioList(ArrayHelper::map(PilotGameChallengeName::find()->all(), 'id', 'challenge_name'), ['disabled' => true])->label(false);
            //echo '<pre>';print_r($challenge);die;
            foreach ($challenge as $challenges):
                $html .= '<div class="selected_game" style="display:none"><div class="my-show"><i class="fa fa-check"></i><span class="selected_shadow_text">Selected</span><span class="selected_shadow"> </span></div><img  rel="' . $challenges->id . '" src="' . Yii::$app->homeUrl . 'img/game/' . $challenges->challenge_image . '"></div>';
            endforeach;
            return $html;
        else:
            $id = 0;
            $challenge = PilotGameChallengeName::find()->where(['client_id' => $id])->all();
            $form = ActiveForm::begin();
            $html .= $form->field($model, 'challenge_id')->radioList(ArrayHelper::map(PilotGameChallengeName::find()->all(), 'id', 'challenge_name'), ['disabled' => true])->label(false);
            foreach ($challenge as $challenges):
                $html .= '<div class="selected_game" style="display:none"><div class="my-show"><i class="fa fa-check"></i><span class="selected_shadow_text">Selected</span><span class="selected_shadow"> </span></div><img  rel="' . $challenges->id . '" src="' . Yii::$app->homeUrl . 'img/game/' . $challenges->challenge_image . '"></div>';
            endforeach;
            return $html;
        endif;
    }

}
