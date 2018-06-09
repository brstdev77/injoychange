<?php

namespace backend\controllers;

use Yii;
use common\models\LoginForm;
use backend\models\Company;
use backend\models\PilotInhouseUser;
use backend\models\PilotCreateGame;
use backend\models\PilotLogs;
use backend\models\PilotTags;
use yii\web\UploadedFile;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\PilotFrontUser;
use frontend\models\PilotFrontUserSearch;
use backend\models\PilotDailyinspirationCategory;
use backend\models\PilotWeeklyCategory;
use backend\models\PilotLeadershipCategory;
use backend\models\PilotHowItWork;
use backend\models\PilotPrizesCategory;
use backend\models\PilotSurveyQuestion;
use backend\models\PilotCheckinYourselfCategory;
use backend\models\PilotActionmattersCategory;
use backend\models\PilotDidyouknowCategory;
use backend\models\PilotGettoknowCategory;
use backend\models\PilotTodayslessonCategory;
use yii\imagine\Image;
use yii\db\Expression;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'company', 'inhouseuser', 'roledemo', 'getgamedata', 'taglist', 'getgamesurvey', 'user-listing', 'delete', 'downloaduser', 'update', 'uploadPhoto', 'view'],
                        'allow' => true,
                    //'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                // 'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'uploadPhoto' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => Yii::$app->request->baseurl . '/uploads/',
                'path' => '@uploads/',
                'maxSize' => 10485760,
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex() {
        $tag_list = [];
        if (!Yii::$app->user->isGuest) {
            $company = Company::find()->all();
            $tags = new PilotTags();
            if (Yii::$app->request->get()):
                $tag_ids = PilotTags::find()->where(['like', 'tags', Yii::$app->request->get()[PilotTags][tags]])->all();
                if (!empty($tag_ids)):
                    foreach ($tag_ids as $tags => $tag_value):
                        $tag_list[] = $tag_value['id'];
                    endforeach;
                endif;
                $model = new PilotDailyinspirationCategory();
                $query = PilotDailyinspirationCategory::find();
                $dataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model1 = new PilotWeeklyCategory();
                $query1 = PilotWeeklyCategory::find();
                $dataProvider1 = new ActiveDataProvider([
                    'query' => $query1,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model2 = new PilotLeadershipCategory();
                $query2 = PilotLeadershipCategory::find();
                $dataProvider2 = new ActiveDataProvider([
                    'query' => $query2,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model3 = new PilotHowItWork();
                $query3 = PilotHowItWork::find();
                $dataProvider3 = new ActiveDataProvider([
                    'query' => $query3,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model4 = new PilotPrizesCategory();
                $query4 = PilotPrizesCategory::find();
                $dataProvider4 = new ActiveDataProvider([
                    'query' => $query4,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model5 = new PilotCheckinYourselfCategory();
                $query5 = PilotCheckinYourselfCategory::find();
                $dataProvider5 = new ActiveDataProvider([
                    'query' => $query5,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model6 = new PilotSurveyQuestion();
                $query6 = PilotSurveyQuestion::find();
                $dataProvider6 = new ActiveDataProvider([
                    'query' => $query6,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model7 = new PilotActionmattersCategory();
                $query7 = PilotActionmattersCategory::find();
                $dataProvider7 = new ActiveDataProvider([
                    'query' => $query7,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model8 = new PilotDidyouknowCategory();
                $query8 = PilotDidyouknowCategory::find();
                $dataProvider8 = new ActiveDataProvider([
                    'query' => $query8,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model9 = new PilotGettoknowCategory();
                $query9 = PilotGettoknowCategory::find();
                $dataProvider9 = new ActiveDataProvider([
                    'query' => $query9,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                $model10 = new PilotTodayslessonCategory();
                $query10 = PilotTodayslessonCategory::find();
                $dataProvider10 = new ActiveDataProvider([
                    'query' => $query10,
                    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
                ]);
                if (!empty($tag_list)):
                    //for fetching dailyinspiration contents
                    // echo count($dataProvider);die;
                    foreach ($tag_list as $value):
                        $query->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query1->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query2->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query3->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query4->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query5->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query6->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query7->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query8->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query9->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                        $query10->orwhere(new Expression('FIND_IN_SET(' . $value . ', tag_id)'));
                    endforeach;
                else:
                    $query->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query1->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query2->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query3->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query4->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query5->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query6->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query7->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query8->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query9->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                    $query10->andFilterWhere(['like', 'tag_id', Yii::$app->request->get()[PilotTags][tags]]);
                endif;
                $query->all();
                $query1->all();
                $query2->all();
                $query3->all();
                $query4->all();
                $query5->all();
                $query6->all();
                $query7->all();
                $query8->all();
                $query9->all();
                $query10->all();
                return $this->render('tagsearch', [
                            'dataProvider' => $dataProvider,
                            'model' => $model,
                            'dataProvider1' => $dataProvider1,
                            'model1' => $model1,
                            'dataProvider2' => $dataProvider2,
                            'model2' => $model2,
                            'dataProvider3' => $dataProvider3,
                            'model3' => $model3,
                            'dataProvider4' => $dataProvider4,
                            'model4' => $model4,
                            'dataProvider5' => $dataProvider5,
                            'model5' => $model5,
                            'dataProvider6' => $dataProvider6,
                            'model6' => $model6,
                            'dataProvider7' => $dataProvider7,
                            'model7' => $model7,
                            'dataProvider8' => $dataProvider8,
                            'mode' => $model8,
                            'dataProvider9' => $dataProvider9,
                            'model9' => $model9,
                            'dataProvider10' => $dataProvider10,
                            'model10' => $model10,
                ]);
            endif;
            return $this->render('index', ['company' => $company,
                        'tags' => $tags,
            ]);
        } else {
            return $this->redirect('site/login');
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        $this->layout = "login";
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        $model->load(Yii::$app->request->post());
        $models = PilotInhouseUser::find()->where(['emailaddress' => $model->emailaddress])->one();
        if (($models->status) == '0') {
            Yii::$app->session->setFlash('custom_message', 'You are currrently Blocked, Please contact to site admin for more info !');
            return $this->render('login', [
                        'model' => $model,
            ]);
        } else {
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                $models = PilotInhouseUser::find()->where(['id' => Yii::$app->user->identity->id])->one();
                $models->last_access_time = time();

                /*
                 * saving log message
                 */
                $PilotLogs = new PilotLogs();
                $PilotLogs->setpilotlog(Yii::$app->user->identity->id, 'user', 'info', Yii::$app->request->hostInfo . Yii::$app->request->url, 'user has been login successfully!');

                return $this->redirect('');
            } else {
                return $this->render('login', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {

        /*
         * saving log message 
         */
        $PilotLogs = new PilotLogs();
        $PilotLogs->setpilotlog(Yii::$app->user->identity->id, 'user', 'info', Yii::$app->request->hostInfo . Yii::$app->request->url, 'user has been logout successfully!');
        Yii::$app->user->logout();
        return $this->redirect('login');
    }

    public function actionTaglist() {
        $htm = '';
        $h = '80px';
        $i = 1;
        $search = $_POST['searchword'];
        $search = str_replace("+", "", $search);
        $query = PilotTags::find()->where(['like', 'tags', $search])->all();
        $newdata = [];
        foreach ($query as $value) {
            $newdata[] = ['name' => $value->tags];
            $htm .= '<div class="display_box" align="left" >';
            $htm .= '<a href="javascript:void(0)" class="addname">' . $value->tags . '</a><br/>';
            $htm .= '</div>';
            $i++;
        }
        if ($htm == '') {
            $htm .= '<div class="display_box" align="left" >';
            $htm .= 'no such tags';
            $htm .= '</div>';
            $h = '32px';
        }
        if ($i == 2) {
            $h = '32px';
        }
        echo json_encode(array('htm' => $htm, 'height_dis' => $h));
    }

    public function actionGetgamedata() {
        $id = $_POST['id'];
        $output = [];
        $output['nogame'] = '';
        $challenge_array = [];
        //$userlisting =[];
        $total_highfives = 0;
        $total_shoutouts = 0;
        $total_shareawin = 0;
        $total_gameactions = 0;
        $challenge_id = 0;
        $challenge_dropdown = '<select id="challenge_game" class="form-control"><option>Select Challenge</option>';
        $user_html = '';
        $user_percentage = '';
        $user20percent = '';
        $user40percent = '';
        $user60percent = '';
        $user80percent = '';
        $userpercent = '';
        $count1 = '';
        $type1 = '';
        $i = 1;
        $no = 1;
        $j = 0;
        $n = 1;
        $survey_question = [];
        if ($id != 0):
            $ongoing = count(PilotCreateGame::find()->where(['challenge_company_id' => $id, 'status' => 1])->all());
            $upcoming = PilotCreateGame::find()->where(['challenge_company_id' => $id, 'status' => 0])->count();
            $completed = PilotCreateGame::find()->where(['challenge_company_id' => $id, 'status' => 2])->count();
            $game_obj = PilotCreateGame::find()->where(['challenge_company_id' => $id])->all();
            if (empty($game_obj)):
                $output['nogame'] = 'no challenge is played for this company.';
                return json_encode($output);
            endif;
            $game_list = PilotCreateGame::find()->where(['challenge_company_id' => $id, 'status' => [0, 1, 2]])->one();
            foreach ($game_obj as $game_name) {
                $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                if (!empty($challenge_obj)):
                    $challenge_name = ucfirst($challenge_obj->challenge_abbr_name);
                endif;
                if ($challenge_id == 0 || $challenge_id != $game_name->challenge_id):
                    $users = PilotFrontUser::find()->where(['challenge_id' => $game_name->challenge_id, 'company_id' => $game_name->challenge_company_id])->count('id');
                    if ($challenge_name == 'Test'):
                        $challenge_array['challenge_name' . $n] = 'Learning';
                        $output['Learning'] = $users;
                    else:
                        $challenge_array['challenge_name' . $n] = $challenge_name;
                        $output[$challenge_name] = $users;
                    endif;
                    $total_highfives += $users;
                    $n++;
                    $j++;
                    $userlists = PilotFrontUser::find()->where(['challenge_id' => $game_name->challenge_id, 'company_id' => $game_name->challenge_company_id])->andWhere(['!=', 'status', 0])->all();
                    foreach ($userlists as $users):
                        $model_scorepoints1 = '\frontend\\models\\PilotFront' . $challenge_name . 'TotalPoints';
                        $points = $model_scorepoints1::find()->where(['user_id' => $users->id])->andWhere(['!=', 'total_points', 0])->one();
                        if ($game_name->challenge_id == 7 || $game_name->challenge_id == 8 || $game_name->challenge_id == 11):
                            if (!empty($points)):
                                if ($points->total_points <= 264):
                                    $user20percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points <= 528):
                                    $user40percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points > 528 && $points->total_points <= 792):
                                    $user60percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points > 528 && $points->total_points > 792 && $points->total_points <= 1056):
                                    $user80percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points > 528 && $points->total_points > 792 && $points->total_points > 1056 && $points->total_points <= 1320):
                                    $userpercent++;
                                endif;
                                if ($points->total_points > 1320):
                                    $userpercent++;
                                endif;
                            endif;
                        else:
                            if (!empty($points)):
                                if ($points->total_points <= 436):
                                    $user20percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points <= 872):
                                    $user40percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points > 872 && $points->total_points <= 1308):
                                    $user60percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points > 872 && $points->total_points > 1308 && $points->total_points <= 1744):
                                    $user80percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points > 872 && $points->total_points > 1308 && $points->total_points > 1744 && $points->total_points <= 2180):
                                    $userpercent++;
                                endif;
                                if ($points->total_points > 2180):
                                    $userpercent++;
                                endif;
                            endif;
                        endif;
                    endforeach;
                endif;
                if (!(empty($survey_question))):
                    $survey_array = explode(',', $game_name->survey_questions);
                    foreach ($survey_array as $question):
                        if (!(in_array($question, $survey_question))):
                            array_push($survey_question, $question);
                        endif;
                    endforeach;
                else:
                    $survey_array = explode(',', $game_name->survey_questions);
                    foreach ($survey_array as $question):
                        array_push($survey_question, $question);
                    endforeach;
                endif;
                $challenge_id = $game_name->challenge_id;
                $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Dailyinspiration';
                if ($game_name->challenge_id == 7 || $game_name->challenge_id == 8 || $game_name->challenge_id == 11):
                    $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Question';
                    $model_shareawin = '\frontend\\models\\PilotFront' . $challenge_name . 'Knowcorner';
                else:
                    $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Checkin';
                    $model_shareawin = '\frontend\\models\\PilotFront' . $challenge_name . 'Shareawin';
                endif;
                $model_highfive = '\frontend\\models\\PilotFront' . $challenge_name . 'Highfive';
                $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Leadershipcorner';
                $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Weeklychallenge';
                $model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_name . 'TotalPoints';

                $total_shoutouts += count($model_highfive::find()->where(['company_id' => $game_name->challenge_company_id])
                                ->andWhere(['game_id' => $game_name->challenge_id])
                                ->andWhere(['!=', 'feature_label', 'highfiveLike'])
                                ->all());
                $total_shareawin += count($check_in_model_name::find()->where(['company_id' => $game_name->challenge_company_id])
                                ->andWhere(['game_id' => $game_name->challenge_id])
                                ->all());
                $checkincount = $model_scorepoints::find()->where(['company_id' => $game_name->challenge_company_id])
                        ->andWhere(['game_id' => $game_name->challenge_id])
                        ->andWhere(['between', 'created', $game_name->challenge_start_date, $game_name->challenge_end_date])
                        ->sum('total_game_actions');
                $total_gameactions += $checkincount;
                $i++;
                $challenge_dropdown .= '<option value="' . $game_name->challenge_id . '">' . $challenge_name . '</option>';
            }
            $a = array_values(array_diff($survey_question, array("", "")));
            if (!empty($a)) {
                $output['surveypresent'] = 1;
                foreach ($a as $id):
                    $count1 = '';
                    $type1 = '';
                    $count = 0;
                    $type = 0;
                    $neutral = 0;
                    $somedisagree = 0;
                    $disagree = 0;
                    $surveymodel = PilotSurveyQuestion::find()->where(['id' => $id])->one();
                    if ($surveymodel->type == 'checkbox'):
                        foreach ($game_obj as $game_name):
                            $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                            $challenge_name = ucfirst($challenge_obj->challenge_abbr_name);
                            $model_survey = '\frontend\\models\\PilotFront' . $challenge_name . 'SurveyData';
                            $model = $model_survey::find()->where(['and', "challenge_id = '$game_name->id'", "survey_question_id = '$id'", "survey_filled = 'Yes'"])->all();
                            if (!empty($model)) {
                                foreach ($model as $key):
                                    if ($key['survey_response'] == "agree" || $key['survey_response'] == "Agree") {
                                        $count++;
                                    } else if ($key['survey_response'] == "somewhat agree" || $key['survey_response'] == "Somewhat Agree") {
                                        $type++;
                                    } else if ($key['survey_response'] == "neutral" || $key['survey_response'] == "Neutral") {
                                        $neutral++;
                                    } else if ($key['survey_response'] == "somewhat disagree" || $key['survey_response'] == "Somewhat Disagree") {
                                        $somedisagree++;
                                    } else if ($key['survey_response'] == "disagree" || $key['survey_response'] == "Disagree") {
                                        $disagree++;
                                    }
                                endforeach;
                            }
                        endforeach;
                        $output['Question' . $id] = array($count, $type, $neutral, $somedisagree, $disagree);
                    endif;
                    if ($surveymodel->type == 'textbox'):
                        foreach ($game_obj as $game_name):
                            $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                            $challenge_name = ucfirst($challenge_obj->challenge_abbr_name);
                            $model_survey = '\frontend\\models\\PilotFront' . $challenge_name . 'SurveyData';
                            $total = count(PilotFrontUser::find()->where(['company_id' => $game_name->challenge_company_id])
                                            ->andWhere(['challenge_id' => $game_name->challenge_id])
                                            ->all());
                            $model = $model_survey::find()->where(['and', "challenge_id = '$game_name->id'", "survey_question_id = '$id'", "survey_filled = 'Yes'"])->count();
                            if (!empty($model)) {
                                $count = $model;
                                $type = $total - $count;
                            } else {
                                $count = 0;
                                $type = 0;
                            }
                            $count1 += $count;
                            $type1 += $type;
                        endforeach;
                        $output['Question' . $id] = array($count1, $type1);
                    endif;
                endforeach;
            } else {
                $output['surveypresent'] = 0;
            }
            $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_list->challenge_id])->one();
            $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
            $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
            $ongoinguser = $daily_model_name::find()->where(['game_id' => $game_list->challenge_id, 'company_id' => $game_list->challenge_company_id])
                    ->andWhere(['between', 'created', $game_list->challenge_start_date, $game_list->challenge_end_date])
                    ->orderBy(['total_points' => SORT_DESC])
                    ->limit(8)
                    ->all();
            foreach ($ongoinguser as $value) {
                if (!empty($value)):
                    $username = \frontend\models\PilotFrontUser::find()->where(['id' => $value->user_id])->one();
                    if (empty($username->profile_pic)):
                        $username->profile_pic = 'thumb_noimage.png';
                    else:
                        $username->profile_pic = 'thumb_' . $username->profile_pic;
                    endif;
                    $user_html .= '<li>
                      <img alt="User Image" src="/frontend/web/uploads/' . $username->profile_pic . '">
                      <a href="#" class="users-list-name">' . $username->username . '</a>
                      <span class="users-list-date">' . $value->total_points . 'Pts</span>
                    </li>';
                    $no++;
                endif;
            }
        else:
            $value = [1, 2];
            $game_list = PilotCreateGame::find()->where(['status' => $value])->one();
            $ongoing = PilotCreateGame::find()->where(['status' => 1])->count();
            $upcoming = PilotCreateGame::find()->where(['status' => 0])->count();
            $completed = PilotCreateGame::find()->where(['status' => 2])->count();
            $game_obj = PilotCreateGame::find()->all();
            foreach ($game_obj as $game_name) {
                $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                if (!empty($challenge_obj)):
                    $challenge_name = ucfirst($challenge_obj->challenge_abbr_name);
                endif;
                if ($challenge_id == 0 || $challenge_id != $game_name->challenge_id):
                    $users = PilotFrontUser::find()->where(['challenge_id' => $game_name->challenge_id])->andWhere(['!=', 'status', 0])->count('id');
                    if ($challenge_name == 'Test'):
                        $challenge_array['challenge_name' . $n] = 'Learning';
                    else:
                        $challenge_array['challenge_name' . $n] = $challenge_name;
                    endif;
                    $n++;
                    $j++;
                    $userlists = PilotFrontUser::find()->where(['challenge_id' => $game_name->challenge_id, 'company_id' => $game_name->challenge_company_id])->all();
                    foreach ($userlists as $users):
                        $model_scorepoints1 = '\frontend\\models\\PilotFront' . $challenge_name . 'TotalPoints';
                        $points = $model_scorepoints1::find()->where(['user_id' => $users->id])->andWhere(['!=', 'total_points', 0])->one();
                        if ($game_name->challenge_id == 7 || $game_name->challenge_id == 8 || $game_name->challenge_id == 11):
                            if (!empty($points)):
                                if ($points->total_points <= 264):
                                    $user20percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points <= 528):
                                    $user40percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points > 528 && $points->total_points <= 792):
                                    $user60percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points > 528 && $points->total_points > 792 && $points->total_points <= 1056):
                                    $user80percent++;
                                endif;
                                if ($points->total_points > 264 && $points->total_points > 528 && $points->total_points > 792 && $points->total_points > 1056 && $points->total_points <= 1320):
                                    $userpercent++;
                                endif;
                                if ($points->total_points > 1320):
                                    $userpercent++;
                                endif;
                            endif;
                        else:
                            if (!empty($points)):
                                if ($points->total_points <= 436):
                                    $user20percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points <= 872):
                                    $user40percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points > 872 && $points->total_points <= 1308):
                                    $user60percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points > 872 && $points->total_points > 1308 && $points->total_points <= 1744):
                                    $user80percent++;
                                endif;
                                if ($points->total_points > 436 && $points->total_points > 872 && $points->total_points > 1308 && $points->total_points > 1744 && $points->total_points <= 2180):
                                    $userpercent++;
                                endif;
                                if ($points->total_points > 2180):
                                    $userpercent++;
                                endif;
                            endif;
                        endif;
                    endforeach;
                endif;
                if (!(empty($survey_question))):
                    $survey_array = explode(',', $game_name->survey_questions);
                    foreach ($survey_array as $question):
                        if (!(in_array($question, $survey_question))):
                            array_push($survey_question, $question);
                        endif;
                    endforeach;
                else:
                    $survey_array = explode(',', $game_name->survey_questions);
                    foreach ($survey_array as $question):
                        array_push($survey_question, $question);
                    endforeach;
                endif;
                $challenge_id = $game_name->challenge_id;
                $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Dailyinspiration';
                if ($game_name->challenge_id == 7 || $game_name->challenge_id == 8 || $game_name->challenge_id == 11):
                    $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Question';
                else:
                    $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Checkin';
                endif;
                $model_highfive = '\frontend\\models\\PilotFront' . $challenge_name . 'Highfive';
                if ($game_name->challenge_id != 7 && $game_name->challenge_id == 8 && $game_name->challenge_id == 11):
                    $model_shareawin = '\frontend\\models\\PilotFront' . $challenge_name . 'Shareawin';
                else:
                    $model_shareawin = '\frontend\\models\\PilotFront' . $challenge_name . 'Knowcorner';
                endif;
                $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Leadershipcorner';
                $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_name . 'Weeklychallenge';
                $model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_name . 'TotalPoints';
                $total_highfives += count($model_highfive::find()->where(['company_id' => $game_name->challenge_company_id])
                                ->andWhere(['game_id' => $game_name->challenge_id])
                                ->andWhere(['feature_label' => 'highfiveLike'])
                                ->all());
                $total_shoutouts += count($model_highfive::find()->where(['company_id' => $game_name->challenge_company_id])
                                ->andWhere(['game_id' => $game_name->challenge_id])
                                ->andWhere(['!=', 'feature_label', 'highfiveLike'])
                                ->all());
                $total_shareawin += count($check_in_model_name::find()->where(['company_id' => $game_name->challenge_company_id])
                                ->andWhere(['game_id' => $game_name->challenge_id])
                                ->all());
                $checkincount = $model_scorepoints::find()->where(['company_id' => $game_name->challenge_company_id])
                        ->andWhere(['game_id' => $game_name->challenge_id])
                        ->andWhere(['between', 'created', $game_name->challenge_start_date, $game_name->challenge_end_date])
                        ->sum('total_game_actions');
                $total_gameactions += $checkincount;
                $i++;

//echo $game_name->challenge_company_id.'<br>'.$total_gameactions;die;
            }
            $a = array_values(array_diff($survey_question, array("", "")));
            foreach ($a as $id):
                $count1 = '';
                $type1 = '';
                $count = 0;
                $type = 0;
                $neutral = 0;
                $somedisagree = 0;
                $disagree = 0;
                $surveymodel = PilotSurveyQuestion::find()->where(['id' => $id])->one();
                if ($surveymodel->type == 'checkbox'):
                    foreach ($game_obj as $game_name):
                        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                        $model_survey = '\frontend\\models\\PilotFront' . $challenge_name . 'SurveyData';
                        $model = $model_survey::find()->where(['and', "challenge_id = '$game_name->id'", "survey_question_id = '$id'", "survey_filled = 'Yes'"])->all();
                        if (!empty($model)) {
                            foreach ($model as $key):
                                if ($key['survey_response'] == "agree" || $key['survey_response'] == "Agree") {
                                    $count++;
                                } else if ($key['survey_response'] == "somewhat agree" || $key['survey_response'] == "Somewhat Agree") {
                                    $type++;
                                } else if ($key['survey_response'] == "neutral" || $key['survey_response'] == "Neutral") {
                                    $neutral++;
                                } else if ($key['survey_response'] == "somewhat disagree" || $key['survey_response'] == "Somewhat Disagree") {
                                    $somedisagree++;
                                } else if ($key['survey_response'] == "disagree" || $key['survey_response'] == "Disagree") {
                                    $disagree++;
                                }
                            endforeach;
                        }
                    endforeach;
                    $output['Question' . $id] = array($count, $type, $neutral, $somedisagree, $disagree);
                endif;
                if ($surveymodel->type == 'textbox'):
                    foreach ($game_obj as $game_name):
                        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                        $model_survey = '\frontend\\models\\PilotFront' . $challenge_name . 'SurveyData';
                        $total = count(PilotFrontUser::find()->where(['company_id' => $game_name->challenge_company_id])
                                        ->andWhere(['challenge_id' => $game_name->challenge_id])
                                        ->all());
                        $model = $model_survey::find()->where(['and', "challenge_id = '$game_name->id'", "survey_question_id = '$id'", "survey_filled = 'Yes'"])->count();
                        if (!empty($model)) {
                            $count = $model;
                            $type = $total - $count;
                            $count1 += $count;
                            $type1 += $type;
                        } else {
                            $count = 0;
                            $type = 0;
                            $count1 += $count;
                            $type1 += $type;
                        }
                    endforeach;
                    $output['Question' . $id] = array($count1, $type1);
                endif;
            endforeach;
            $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_list->challenge_id])->one();
            $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
            $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
            $ongoinguser = $daily_model_name::find()->where(['game_id' => $game_list->challenge_id, 'company_id' => $game_list->challenge_company_id])
                    ->andWhere(['between', 'created', $game_list->challenge_start_date, $game_list->challenge_end_date])
                    ->orderBy(['total_points' => SORT_DESC])
                    ->limit(8)
                    ->all();
            foreach ($ongoinguser as $value) {
                if (!empty($value)):
                    $username = \frontend\models\PilotFrontUser::find()->where(['id' => $value->user_id])->one();
                    if (empty($username->profile_pic)):
                        $username->profile_pic = 'noimage.png';
                    else:
                        $username->profile_pic = 'thumb_' . $username->profile_pic;
                    endif;
                    $user_html .= '<li>
                      <img alt="User Image" src="/frontend/web/uploads/' . $username->profile_pic . '">
                      <a href="#" class="users-list-name">' . $username->username . '</a>
                      <span class="users-list-date">' . $value->total_points . 'Pts</span>
                    </li>';
                    $no++;
                endif;
            }
        endif;
        if (empty($user20percent)):
            $user20percent = 0;
        endif;
        if (empty($user40percent)):
            $user40percent = 0;
        endif;
        if (empty($user60percent)):
            $user60percent = 0;
        endif;
        if (empty($user80percent)):
            $user80percent = 0;
        endif;
        if (empty($userpercent)):
            $userpercent = 0;
        endif;
        // $high_five = highfivedata($id);
        $user_percentage .= '<li><a href="#">20% Achievers
                                <span class="pull-right text-red"> ' . $user20percent . '</span></a></li>
                        <li><a href="#">40% Achievers <span class="pull-right text-green">' . $user40percent . '</span></a>
                        </li>
                        <li><a href="#">60% Achievers
                                <span class="pull-right text-yellow"> ' . $user60percent . '</span></a></li>
                        <li><a href="#">80% Achievers
                                <span class="pull-right text-yellow"> ' . $user80percent . '</span></a></li>
                        <li><a href="#">100% Achievers
                                <span class="pull-right text-yellow"> ' . $userpercent . '</span></a></li>';
        $challenge_dropdown .= '</select>';
        $output['ongoing'] = $ongoing;
        $output['upcoming'] = $upcoming;
        $output['completed'] = $completed;
        $output['total_challenges'] = $j;
        $output['total_highfives'] = $total_highfives;
        $output['total_shoutouts'] = $total_shoutouts;
        $output['total_shareawin'] = $total_shareawin;
        $output['total_gameactions'] = $total_gameactions;
        $output['user_html'] = $user_html;
        $output['user_percentage'] = $user_percentage;
        $output['user20percent'] = $user20percent;
        $output['user40percent'] = $user40percent;
        $output['user60percent'] = $user60percent;
        $output['user80percent'] = $user80percent;
        $output['userpercent'] = $userpercent;
        $output['challenge_dropdown'] = $challenge_dropdown;
        $output1 = array_merge($output, $challenge_array);
        return json_encode($output1);
    }

    public function actionGetgamesurvey() {
        $company_id = $_POST['companyid'];
        $challenge_id = $_POST['challenge_id'];
        $count1 = '';
        $type1 = '';
        $i = 1;
        $no = 1;
        $j = 0;
        $n = 1;
        $survey_question = [];
        $game_obj = PilotCreateGame::find()->where(['challenge_company_id' => $company_id, 'challenge_id' => $challenge_id])->all();
        if (empty($game_obj)):
            $output['nogame'] = 'no challenge is played for this company.';
            return json_encode($output);
        endif;
        foreach ($game_obj as $game_name) {
            $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
            if (!empty($challenge_obj)):
                $challenge_name = ucfirst($challenge_obj->challenge_abbr_name);
            endif;
            if (!(empty($survey_question))):
                $survey_array = explode(',', $game_name->survey_questions);
                foreach ($survey_array as $question):
                    if (!(in_array($question, $survey_question))):
                        array_push($survey_question, $question);
                    endif;
                endforeach;
            else:
                $survey_array = explode(',', $game_name->survey_questions);
                foreach ($survey_array as $question):
                    array_push($survey_question, $question);
                endforeach;
            endif;
        }
        $a = array_values(array_diff($survey_question, array("", "")));
        if (!empty($a)) {
            $output['surveypresent'] = 1;
            foreach ($a as $id):
                $count1 = '';
                $type1 = '';
                $count = 0;
                $type = 0;
                $neutral = 0;
                $somedisagree = 0;
                $disagree = 0;
                $surveymodel = PilotSurveyQuestion::find()->where(['id' => $id])->one();
                if ($surveymodel->type == 'checkbox'):
                    foreach ($game_obj as $game_name):
                        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                        $challenge_name = ucfirst($challenge_obj->challenge_abbr_name);
                        $model_survey = '\frontend\\models\\PilotFront' . $challenge_name . 'SurveyData';
                        $model = $model_survey::find()->where(['and', "challenge_id = '$game_name->id'", "survey_question_id = '$id'", "survey_filled = 'Yes'"])->all();
                        if (!empty($model)) {
                            foreach ($model as $key):
                                if ($key['survey_response'] == "agree" || $key['survey_response'] == "Agree") {
                                    $count++;
                                } else if ($key['survey_response'] == "somewhat agree" || $key['survey_response'] == "Somewhat Agree") {
                                    $type++;
                                } else if ($key['survey_response'] == "neutral" || $key['survey_response'] == "Neutral") {
                                    $neutral++;
                                } else if ($key['survey_response'] == "somewhat disagree" || $key['survey_response'] == "Somewhat Disagree") {
                                    $somedisagree++;
                                } else if ($key['survey_response'] == "disagree" || $key['survey_response'] == "Disagree") {
                                    $disagree++;
                                }
                            endforeach;
                        }
                    endforeach;
                    $output['Question' . $id] = array($count, $type, $neutral, $somedisagree, $disagree);
                endif;
                if ($surveymodel->type == 'textbox'):
                    foreach ($game_obj as $game_name):
                        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game_name->challenge_id])->one();
                        $challenge_name = ucfirst($challenge_obj->challenge_abbr_name);
                        $model_survey = '\frontend\\models\\PilotFront' . $challenge_name . 'SurveyData';
                        $total = count(PilotFrontUser::find()->where(['company_id' => $game_name->challenge_company_id])
                                        ->andWhere(['challenge_id' => $game_name->challenge_id])
                                        ->all());
                        $model = $model_survey::find()->where(['and', "challenge_id = '$game_name->id'", "survey_question_id = '$id'", "survey_filled = 'Yes'"])->count();
                        if (!empty($model)) {
                            $count = $model;
                            $type = $total - $count;
                        } else {
                            $count = 0;
                            $type = 0;
                        }
                        $count1 += $count;
                        $type1 += $type;
                    endforeach;
                    $output['Question' . $id] = array($count1, $type1);
                endif;
            endforeach;
        } else {
            $output['surveypresent'] = 0;
        }
        $output['question'] = $a;
        return json_encode($output);
    }

    public function actionUserListing() {

        $searchModel = new PilotFrontUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('frontuser', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id) {
        $model = PilotFrontuser::find()->where(['id' => $id])->one();
        if ($model->delete()):
            return $this->redirect(['user-listing']);
        endif;
    }

    public function actionDownloaduser() {
        if ($_GET) {
            $registereduser = PilotFrontUser::find()->where(['like', 'username', $_GET['username']])
                            ->andWhere(['like', 'emailaddress', $_GET['emailaddress']])
                            ->andWhere(['like', 'company_id', $_GET['company_id']])
                            ->andWhere(['like', 'team_id', $_GET['team_id']])
                            ->andWhere(['like', 'device', $_GET['device']])
                            ->andWhere(['like', 'status', $_GET['status']])
                            ->orderBy(['id' => SORT_DESC])->all();
            if (empty($registereduser)):
                return $this->redirect(Yii::$app->request->referrer);
            endif;
            if (!empty($_GET['company_id'])):
                $company = Company::find()->where(['id' => $_GET['company_id']])->one();
                $company_logo = '/backend/web/img/uploads/' . $company->image;
            else:
                $company_logo = '/backend/web/img/uploads/1513062882.png';
            endif;
            $data[] = array_filter(array('Full Name', 'Email Address', 'Company Name', 'Team', 'Last Login', 'Device', 'Browser'));
            foreach ($registereduser as $user) {
                if (empty($user->profile_pic)) {
                    $image = 'noimage.png';
                } else {
                    $image = $user->profile_pic;
                }
                $company_name = PilotFrontUser::getcompanyname($user->company_id);
                if (!empty($user->team_id)) {
                    $team_name = PilotFrontUser::getteamname($user->company_id, $user->team_id);
                } else {
                    $team_name = 'NA';
                }
                $last_login = PilotFrontUser::gettimeago($user->last_access_time);
                $user_data = $user->username;
                $dataxls[] = array('username' => $user_data, 'email' => $user->emailaddress, 'company_name' => $company_name, 'team_name' => $team_name, 'last_login' => $last_login, 'device' => $user->device, 'browser' => $user->browser);
            }
            return $this->render('weekly-reports/generate_registereduser', [
                        'data' => $data,
                        'dataxls' => $dataxls,
                        'company_logo' => $company_logo,
            ]);
        } else {
            $registereduser = PilotFrontUser::find()->orderBy(['id' => SORT_DESC])->all();
            $company_logo = '/backend/web/img/uploads/1513062882.png';
            $data[] = array_filter(array('Full Name', 'Email Address', 'Company Name', 'Team', 'Last Login', 'Device', 'Browser'));
            foreach ($registereduser as $user) {
                if (empty($user->profile_pic)) {
                    $image = 'noimage.png';
                } else {
                    $image = $user->profile_pic;
                }
                $company_name = PilotFrontUser::getcompanyname($user->company_id);
                if (!empty($user->team_id)) {
                    $team_name = PilotFrontUser::getteamname($user->company_id, $user->team_id);
                } else {
                    $team_name = 'NA';
                }
                $last_login = PilotFrontUser::gettimeago($user->last_access_time);
                $user_data = $user->username;
                $dataxls[] = array('username' => $user_data, 'email' => $user->emailaddress, 'company_name' => $company_name, 'team_name' => $team_name, 'last_login' => $last_login, 'device' => $user->device, 'browser' => $user->browser);
            }
            return $this->render('weekly-reports/generate_registereduser', [
                        'data' => $data,
                        'dataxls' => $dataxls,
                        'company_logo' => $company_logo,
            ]);
        }
    }

    public function actionUpdate($id) {
        $user_obj_model = PilotFrontUser::find()->where(['id' => $id])->one();
        $user_obj_model->scenario = 'update';
        $user_pswd = $user_obj_model->password_hash;
        $user_obj_model->password_hash = '';
        $upcoming_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $user_obj_model->company_id])
                ->orderBy(['challenge_start_date' => SORT_ASC])
                ->one();
        $challenge_teams = explode(',', $upcoming_challenge->challenge_teams);
        foreach ($challenge_teams as $key => $val):
            $team_obj = \backend\models\PilotCompanyTeams::find()->where(['id' => $val])->one();
            if (!empty($team_obj)):
                $teamsData[$team_obj->id] = $team_obj->team_name;
            endif;
        endforeach;
        /* Profile Update Form Submitted */
        if (Yii::$app->request->post()):
            $postedData = Yii::$app->request->post();
            $user_obj_model->load(Yii::$app->request->post());
            $user_obj_model->username = ucfirst($user_obj_model->firstname) . ' ' . ucfirst($user_obj_model->lastname);
            if ($postedData['PilotFrontUser']['password_hash'] == ''): //Password not updated Case
                $user_obj_model->password_hash = $user_pswd;
            else: //Password updated Case
                $user_obj_model->setPassword($postedData['PilotFrontUser']['password_hash']);
            endif;
            if ($postedData['PilotFrontUser']['profile_pic'] != ""):
                $userimg_path = Yii::$app->request->post()['PilotFrontUser']['profile_pic'];
                $image = explode('/', $userimg_path);
                $profile_image = end($image);
                $pimg_save = Image::thumbnail(Yii::getAlias('@uploads/' . $profile_image), 71, 71)
                        ->save(Yii::getAlias('@uploads/thumb_' . $profile_image), ['quality' => 100]);
                $user_obj_model->profile_pic = $profile_image;
            else:
                //echo "<pre>"; print_r(Yii::$app->request->post()); die(" herer");
                if (Yii::$app->request->post()['base64_pic'] != ''):
                    $base64_pic = Yii::$app->request->post()['base64_pic'];
                    $imgData = explode(',', $code_base64);
                    $decoded_img = base64_decode($imgData[1]);
                    $base64_pic = str_replace('data:image/png;base64,', '', $base64_pic);
                    $base64_pic = str_replace('data:image/jpeg;base64,', '', $base64_pic);
                    $base64_pic = str_replace(' ', '+', $base64_pic);
                    $decoded_img = base64_decode($base64_pic);
                    $new_image_name = time() . '.jpg';
                    $new_path = Yii::getAlias('@uploads/' . $new_image_name);
                    //Save Image to folder
                    $file = file_put_contents($new_path, $decoded_img);
                    //rotating the image if contains exif data
                    $DefaultTargetPath = Yii::getAlias('@uploads/') . $new_image_name;
                    //get resorce id of image uploaded by extenstion
                    $resouceID = imagecreatefromstring(file_get_contents($DefaultTargetPath));
                    //rotate image according to exif angle
                    $rotateImage = imagerotate($resouceID, Yii::$app->request->post()['exif_angle'], 0);
                    $newName = time() . '_' . $new_image_name;
                    $targetPathNew = Yii::getAlias('@uploads/') . $newName;
                    //get image extension
                    $ext = pathinfo($new_image_name, PATHINFO_EXTENSION);

                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG' || $ext == 'JPEG'):
                        $a = imagejpeg($rotateImage, $targetPathNew, 100);
                    endif;
                    if ($ext == 'png' || $ext == 'PNG'):
                        $a = imagepng($rotateImage, $targetPathNew, 0);
                    endif;
                    imagedestroy($rotateImage);

                    //remove default saved file
                    unlink($DefaultTargetPath);
                    $profile_image = substr($targetPathNew, strrpos($targetPathNew, '/') + 1);
                    //Generate Thumbnail of the image
                    $pimg_save = Image::thumbnail(Yii::getAlias('@uploads/' . $profile_image), 71, 71)
                            ->save(Yii::getAlias('@uploads/thumb_' . $profile_image), ['quality' => 100]);
                    $user_obj_model->profile_pic = $profile_image;
                endif;
            endif;
            $user_obj_model->country = $postedData['PilotFrontUser']['country'];
            $user_obj_model->timezone = $postedData['PilotFrontUser']['timezone'];
            $user_obj_model->ip_address = $_SERVER['REMOTE_ADDR'];
            $user_obj_model->device = PilotFrontUser::getDeviceName();
            $user_obj_model->browser = PilotFrontUser::getBrowser();
            $user_obj_model->last_access_time = time();
            $user_obj_model->updated = time();
            $user_obj_model->save(false);

            Yii::$app->session->setFlash('success', 'Profile has been updated!');
            return $this->redirect(['user-listing']);
        endif;

        return $this->render('edit_profile', [
                    'user_obj_model' => $user_obj_model,
                    'teamsData' => $teamsData,
        ]);
    }

    public function actionView($cid) {
        $html = '';
        $user = PilotFrontUser::findOne($cid);
        $html = $this->renderAjax('user_models', ['user' => $user]);
        return $html;
    }

}
