<?php

namespace backend\controllers;

use Yii;
use backend\models\Company;
use backend\models\companySearch;
use backend\models\PilotInhouseUser;
use backend\models\PilotCompanyTeams;
use backend\models\PilotCompanyCorevaluesname;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

/**
 * ManageclientsController implements the CRUD actions for company model.
 */
class ManageclientsController extends Controller {
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
//'actions' => ['index','create','update'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'profile', 'ajaxgetcountry'],
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $modal = new PilotInhouseUser();
                            return $modal->isUserAdmin(Yii::$app->user->identity->id);
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
// 'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all company models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new companySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single company model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Company();
        $team = new PilotCompanyTeams();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if (($model->start_date) > ($model->end_date)) {
                Yii::$app->session->setFlash('warning', 'start date must be less than end date');
                return $this->render('create', ['model' => $model,'team' => $team,]);
            } else {
                $image = UploadedFile::getInstance($model, 'image');
                $agreementfile = UploadedFile::getInstance($model, 'agreement_file');
                if ($agreementfile) {
                    $model->agreement_file = $agreementfile;
                    $agreementfile->saveAs('img/uploads/agreementfile/' . $model->agreement_file);
                }
                if ($image) {
                    $image = UploadedFile::getInstance($model, 'image');
                    $model->image = time() . '.' . $image->extension;
                    $image->saveAs('img/uploads/' . $model->image);
                } else {
                    $model->image = '';
                }
                if (Yii::$app->request->post()['Company']['manager']) {
                    $model->manager = implode(",", Yii::$app->request->post()['Company']['manager']);
                }
                if (Yii::$app->request->post()['Company']['appreciator']) {
                    $model->appreciator = implode(",", Yii::$app->request->post()['Company']['appreciator']);
                }
                if (Yii::$app->request->post()['Company']['challenge_name']) {
                    $model->challenge_name = implode(",", Yii::$app->request->post()['Company']['challenge_name']);
                }
                $model->start_date = strtotime(Yii::$app->request->post()['Company']['start_date']);
                $model->end_date = strtotime(Yii::$app->request->post()['Company']['end_date']);
                $model->phone = Yii::$app->request->post()['Company']['phone'];
                $model->country = Yii::$app->request->post()['Company']['country'];
                $model->timezone = Yii::$app->request->post()['Company']['timezone'];
                $model->user_id = Yii::$app->user->identity->id;
                //$model->core_values = Yii::$app->request->post()['Company']['core_values'];
                $model->created = time();
                $model->updated = time();
                $model->save(false);


                /*
                 *  saving teams in PilotCompanyTeams model
                 */
                $teams = Yii::$app->request->post()['PilotCompanyTeams']['team_name'];
                if (!empty($teams)) {
                    foreach ($teams as $tname) {
                        if (empty($tname)) {
                            continue;
                        } else {
                            $team = new PilotCompanyTeams();
                            $team->company_id = $model->id;
                            $team->team_name = $tname;
                            $team->save(false);
                        }
                    }
                }

                Yii::$app->session->setFlash('custom_message', 'Company Created Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', ['model' => $model,
                        'team' => $team,
            ]);
        }
    }

    /**
     * Updates an existing company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $team = PilotCompanyTeams::find()->where(['company_id' => $id])->all();
        $oldimage = $model->image;
        $oldfile = $model->agreement_file;
        $teamslist = [];
        foreach($team as $teamid)
        {
            $teamslist[$teamid->id] = $teamid->team_name;
        }
        //echo "<pre>";print_r($teams);die('dsdsd');
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;

        if (Yii::$app->request->post()) {
            //echo "<pre>";print_r();die('sasas');
            $model->load(Yii::$app->request->post());
            if (($model->start_date) > ($model->end_date)) {
                Yii::$app->session->setFlash('warning', 'start date must be less than end date');
                return $this->render('update', ['model' => $model,
                    'team' => $team
                        ]);
            } else {
                $model->start_date = strtotime(Yii::$app->request->post()['Company']['start_date']);
                $model->end_date = strtotime(Yii::$app->request->post()['Company']['end_date']);
                $model->updated = time();
                $model->phone = Yii::$app->request->post()['Company']['phone'];
                $model->country = Yii::$app->request->post()['Company']['country'];
                $model->timezone = Yii::$app->request->post()['Company']['timezone'];
                $model->user_id = Yii::$app->user->identity->id;
                $image = UploadedFile::getInstance($model, 'image');
                $agreementfile = UploadedFile::getInstance($model, 'agreement_file');
                if ($agreementfile) {
                    $model->agreement_file = $agreementfile;
                    $agreementfile->saveAs('img/uploads/agreementfile/' . $model->agreement_file);
                } else {
                    if ($_POST['agreement_file_update'] == 1) {
                        unlink('img/uploads/agreementfile/' . $model->agreement_file);
                        $model->agreement_file = '';
                    } else {
                        $model->agreement_file = $oldfile;
                    }
                }
                if ($image) {
                    $image = UploadedFile::getInstance($model, 'image');
                    $model->image = time() . '.' . $image->extension;
                    $image->saveAs('img/uploads/' . $model->image);
                } else {
                    if ($_POST['imgupdate'] == 1) {
                        if (!empty($model->image)) {
                            unlink('img/uploads/' . $model->image);
                        }
                        $model->image = '';
                    } else {
                        $model->image = $oldimage;
                    }
                }
// $model->core_values = Yii::$app->request->post()['Company']['core_values'];
                if (Yii::$app->request->post()['Company']['manager']) {
                    $model->manager = implode(",", Yii::$app->request->post()['Company']['manager']);
                }
                if (Yii::$app->request->post()['Company']['appreciator']) {
                    $model->appreciator = implode(",", Yii::$app->request->post()['Company']['appreciator']);
                }
                if (Yii::$app->request->post()['Company']['challenge_name']) {
                    $model->challenge_name = implode(",", Yii::$app->request->post()['Company']['challenge_name']);
                }
                $model->updated = time();
                if ($model->save(false)) {
                    $teams = Yii::$app->request->post()['PilotCompanyTeams']['team_name'];
                    //echo "<pre>";print_r($teams);die('dsdsd');
                    if (!empty($teams)) {
                        foreach ($teams as $key => $tname) {
                            if (empty($tname)) {
                                continue;
                            } else {
                                $teamfind = PilotCompanyTeams::find()->where(['id' => $key])->one();
                                if ($teamfind) {
                                    $teamfind->company_id = $model->id;
                                    $teamfind->team_name = $tname;
                                    $teamfind->save(false);
                                    unset($teamslist[$key]);
                                } else {
                                    $team = new PilotCompanyTeams();
                                    $team->company_id = $model->id;
                                    $team->team_name = $tname;
                                    $team->save(false);
                                }
                            }
                        }
                      // echo "<pre>";print_r($teamslist);die('sasa');
                       foreach($teamslist as $key1)
                       {
                           $key2 = array_search($key1, $teamslist);
                           PilotCompanyTeams::findOne($key2)->delete();
                       }
                    }

                    Yii::$app->session->setFlash('custom_message', 'Company Updated Successfully!');
                    return $this->redirect('index');
                }
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'team' => $team,
            ]);
        }
    }

    /**
     * Deletes an existing company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = company::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    /**
     * this render the profie page
     * @return mixed
     */
    public function actionProfile() {
        return $this->render('profile');
    }

    /*
     * for time-zone
     */

    public function actionAjaxgetcountry() {
        $arr = array();
        $html = '';
        $countryname = ucwords(strtolower($_POST['countryname']));
        $countrycode = $_POST['countrycode'];
        $timezone = $_POST['timezone'];
        $gmtdata = \backend\models\Company::childTimezone();
        foreach ($gmtdata as $key => $value) {
            $str = substr($key, 0, strpos($key, '/'));

            if ($str == $countryname) {
                $continent = \backend\models\Company::country_to_continent($countrycode);
                $timezoneArr = explode('/', $key);
                $timezoneNew = end($timezoneArr);
                if ($timezone == $continent . '/' . $timezoneNew) {
                    if ($timezoneNew == 'Honolulu') {
                        $html.= '<option selected value="Pacific/' . $timezoneNew . '">' . $value . '</option>';
                    } else {
                        $html.= '<option selected value="' . $continent . '/' . $timezoneNew . '">' . $value . '</option>';
                    }
                } else {
                    if ($timezoneNew == 'Honolulu') {
                        $html.= '<option selected value="Pacific/' . $timezoneNew . '">' . $value . '</option>';
                    } else {
                        $html.= '<option value="' . $continent . '/' . $timezoneNew . '">' . $value . '</option>';
                    }
                }
            }
        }
        return \yii\helpers\Json::encode($html);
    }

}
