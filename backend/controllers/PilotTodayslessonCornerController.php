<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotTodayslessonCorner;
use backend\models\PilotTodayslessonQuestion;
use backend\models\PilotTodayslessonCornerSearch;
use backend\models\PilotInhouseUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * PilotTodayslessonCornerController implements the CRUD actions for PilotTodayslessonCorner model.
 */
class PilotTodayslessonCornerController extends Controller {
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
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'viewleadership', 'weekvalidation', 'checkforweek', 'checkforweekonedit', 'upload-audio', 'upload-video', 'popupPhoto', 'dashboardPhoto', 'upload-videoimages','upload'],
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

    public function actions() {
        return [
            'popupPhoto' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => 'http://root.injoychange.com/backend/web/img/leadership-corner-images/lightbox-image',
                'path' => '@backend/web/img/leadership-corner-images/dashboard-image',
                'maxSize' => 10485760,
            ],
            'dashboardPhoto' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => 'http://root.injoychange.com/backend/web/img/leadership-corner-images/dashboard-image',
                'path' => '@backend/web/img/leadership-corner-images/dashboard-image',
                'maxSize' => 10485760,
            ]
        ];
    }

    /**
     * Lists all PilotTodayslessonCorner models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PilotTodayslessonCornerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new PilotTodayslessonCorner();
        $id = Yii::$app->request->post()['PilotTodayslessonCorner']['category_id'];
        $modelupdate = PilotTodayslessonCorner::find()->where(['id' => $id])->one();

        $oldlightboximageupdate = $modelupdate->popup_image;
        $olddashboardimageupdate = $modelupdate->dashboard_image;
        if ($modelupdate) {
            $modelupdate->load(Yii::$app->request->post());
            $lightboximage = UploadedFile::getInstance($modelupdate, 'popup_image');
            $dashboardimage = UploadedFile::getInstance($modelupdate, 'dashboard_image');

            if ($lightboximage) {
                $modelupdate->popup_image = time() . '_' . $lightboximage->name;
                $lightboximage->saveAs('img/leadership-corner-images/lightbox-image/' . $modelupdate->popup_image);
            } else {
                if ($_POST['lightboximgupdate'] == 1) {
                    if (!empty($modelupdate->popup_image)) {
// unlink('img//' . $model->image);
                    }
                    $modelupdate->popup_image = '';
                } else {
                    $modelupdate->popup_image = $oldlightboximageupdate;
                }
            }
            if ($dashboardimage) {
                $modelupdate->dashboard_image = time() . '_' . $dashboardimage->name;
                $dashboardimage->saveAs('img/leadership-corner-images/dashboard-image/' . $modelupdate->dashboard_image);
            } else {
                if ($_POST['dashboardimgupdate'] == 1) {
                    if (!empty($modelupdate->dashboard_image)) {
// unlink('img//' . $model->image);
                    }
                    $modelupdate->dashboard_image = '';
                } else {
                    $modelupdate->dashboard_image = $olddashboardimageupdate;
                }
            }
            $modelupdate->designation = Yii::$app->request->post()['PilotTodayslessonCorner']['designation'];
            if ($modelupdate->save(false)) {
                $cid = $modelupdate->category_id;
                Yii::$app->session->setFlash('custom_message', 'Leadership Corner Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-todayslesson-corner/index?cid=$cid");
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-todayslesson-corner/index?cid=$cid");
            }
        } elseif (Yii::$app->request->post()) {
            $lightboximg = UploadedFile::getInstance($model, 'popup_image');
            $dashboardimg = UploadedFile::getInstance($model, 'dashboard_image');
            if ($lightboximg) {
                $model->popup_image = time() . '_' . $lightboximg->name;
                $lightboximg->saveAs('img/leadership-corner-images/lightbox-image/' . $model->popup_image);
            }
            if ($dashboardimg) {
                $model->dashboard_image = time() . '_' . $dashboardimg->name;
                $dashboardimg->saveAs('img/leadership-corner-images/dashboard-image/' . $model->dashboard_image);
            }
            $model->load(Yii::$app->request->post());
            $model->user_id = Yii::$app->user->identity->id;
            $model->category_id = Yii::$app->request->post()['PilotTodayslessonCorner']['category_id'];
            $model->created = time();
            $model->updated = time();
            if ($model->save()) {
                $cid = $model->category_id;
                Yii::$app->session->setFlash('custom_message', 'Leadership Corner Created Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-todayslesson-corner/index?cid=$cid");
            }
//            echo '<pre>';print_r(Yii::$app->request->post());
//            echo '<pre>';print_r($model);die;
        } else {
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Lists all PilotTodayslessonCorner models.
     * @return mixed
     */
    public function actionViewleadership($cid) {
        $check = PilotTodayslessonCorner::find()->where(['client_listing' => $cid])->all();
        if (empty($check)) {
            return $this->redirect('index');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => PilotTodayslessonCorner::find()->where(['client_listing' => $cid]),
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        return $this->render('viewleadership', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PilotTodayslessonCorner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotTodayslessonCorner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new PilotTodayslessonCorner();
        $question = new PilotTodayslessonQuestion;
        if (Yii::$app->request->post()) {
            //$model->load(Yii::$app->request->post()['PilotTodayslessonCorner']);
            $popuparray = explode('/', Yii::$app->request->post()['PilotTodayslessonCorner']['popup_image']);
            $dashboardarray = explode('/', Yii::$app->request->post()['PilotTodayslessonCorner']['dashboard_image']);
            $model->popup_image = end($popuparray);
            $model->dashboard_image = end($dashboardarray);
            $DefaultTargetPath = Yii::getAlias('@dashboard/') . $model->popup_image;
            $targetPathNew = Yii::getAlias('@popup/') . $model->popup_image;

            copy($DefaultTargetPath, $targetPathNew);
            if ($_POST['file_name'] != '') {
                $model->file_link = $_POST['file_name'];
                $model->video_poster = $_POST['video_poster'];
            }
            $model->user_id = Yii::$app->user->identity->id;
            $model->category_id = Yii::$app->request->post()['PilotTodayslessonCorner']['category_id'];
            $model->title = Yii::$app->request->post()['PilotTodayslessonCorner']['title'];
            $model->designation = Yii::$app->request->post()['PilotTodayslessonCorner']['designation'];
            $model->week = Yii::$app->request->post()['PilotTodayslessonCorner']['week'];
            $model->question = Yii::$app->request->post()['PilotTodayslessonCorner']['question'];
            $model->question_placeholder = Yii::$app->request->post()['PilotTodayslessonCorner']['question_placeholder'];
            $model->answer_type = Yii::$app->request->post()['PilotTodayslessonCorner']['answer_type'];
            $model->description1 = Yii::$app->request->post()['PilotTodayslessonCorner']['description1'];
            $model->description2 = Yii::$app->request->post()['PilotTodayslessonCorner']['description2'];
            $model->created = time();
            $model->updated = time();
            if ($model->save(false)) {
                $cid = $model->category_id;
                $answers = Yii::$app->request->post()['PilotTodayslessonQuestion']['answer'];
                $corrects = Yii::$app->request->post()['PilotTodayslessonQuestion']['Correct'];
//                if (!empty($answers) && !empty($corrects)):
//                    foreach ($answers as $answer) {
//                        if (empty($answer)) {
//                            continue;
//                        } else {
                for ($i = 1; $i <= Yii::$app->request->post()['dropdown_answer']; $i++):
                    $question = new PilotTodayslessonQuestion();
                    $question->secondary_question = Yii::$app->request->post()['PilotTodayslessonQuestion']['secondary_question'];
                    $question->corner_id = $model->id;
                    $question->Correct = $corrects[$i];
                    $question->answer = $answers[$i];
                    $question->created = time();
                    $question->updated = time();
                    $question->save(false);
                endfor;
//                        }
//                    }
//                endif;
                Yii::$app->session->setFlash('custom_message', 'Lesson Created Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-todayslesson-corner/index?cid=$cid");
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'question' => $question,
        ]);
    }

    /**
     * Updates an existing PilotTodayslessonCorner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $category_id = $model->category_id;
        $question = PilotTodayslessonQuestion::find()->where(['corner_id' => $id])->all();
        $question1 = PilotTodayslessonQuestion::find()->where(['corner_id' => $id])->one();
        //echo '<pre>';print_r($question1);die;
        $oldlightboximageupdate = $model->popup_image;
        $olddashboardimageupdate = $model->dashboard_image;
        $oldfilelink = $model->file_link;
        $oldanswer = $model->answer_type;
        $oldposter = $model->video_poster;
        $answerslist = [];
        $ids = [];
        foreach ($question as $teamid) {
            $answerslist[$teamid->id] = $teamid->answer;
        }
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post()['PilotTodayslessonCorner']);
            //echo '<pre>';print_r(Yii::$app->request->post());die;
            $popuparray = explode('/', Yii::$app->request->post()['PilotTodayslessonCorner']['popup_image']);
            $dashboardarray = explode('/', Yii::$app->request->post()['PilotTodayslessonCorner']['dashboard_image']);
            $lightboximage = end($popuparray);
            $dashboardimage = end($dashboardarray);
            $filelink = $_POST['file_name'];
            if ($lightboximage) {
                $model->popup_image = $lightboximage;
                $DefaultTargetPath = Yii::getAlias('@dashboard/') . $model->popup_image;
                $targetPathNew = Yii::getAlias('@popup/') . $model->popup_image;

                copy($DefaultTargetPath, $targetPathNew);
//                $model->popup_image = time() . '_' . $lightboximage->name;
//                $lightboximage->saveAs('img/leadership-corner-images/lightbox-image/' . $model->popup_image);
            } else {
                if ($_POST['lightboximgupdate'] == 1) {
                    if (!empty($model->popup_image)) {
// unlink('img//' . $model->image);
                    }
                    $model->popup_image = '';
                } else {
                    $model->popup_image = $oldlightboximageupdate;
                }
            }
            if ($dashboardimage) {
                $model->dashboard_image = $dashboardimage;
//                $model->dashboard_image = time() . '_' . $dashboardimage->name;
//                $dashboardimage->saveAs('img/leadership-corner-images/dashboard-image/' . $model->dashboard_image);
            } else {
                if ($_POST['dashboardimgupdate'] == 1) {
                    if (!empty($model->dashboard_image)) {
// unlink('img//' . $model->image);
                    }
                    $model->dashboard_image = '';
                } else {
                    $model->dashboard_image = $olddashboardimageupdate;
                }
            }
            if ($filelink) {
                $model->file_link = $filelink;
                $model->answer_type = $model->answer_type;
                $model->video_poster = $_POST['video_poster'];
            } else {
                if ($_POST['dashboardaudioupdate'] == 1) {
                    if (!empty($model->file_link)) {
                        
                    }
                    $model->file_link = '';
                    $model->answer_type = 0;
                    $model->video_poster = '';
                } else {
                    $model->file_link = $oldfilelink;
                    $model->answer_type = $oldanswer;
                    $model->video_poster = $oldposter;
                }
            }
//            if ($_POST['file_name'] != '') {
//                $model->file_link = $_POST['file_name'];
//            }
            $model->user_id = Yii::$app->user->identity->id;
            $model->category_id = $category_id;
            $model->title = Yii::$app->request->post()['PilotTodayslessonCorner']['title'];
            $model->designation = Yii::$app->request->post()['PilotTodayslessonCorner']['designation'];
            $model->week = Yii::$app->request->post()['PilotTodayslessonCorner']['week'];
            $model->question = Yii::$app->request->post()['PilotTodayslessonCorner']['question'];
            $model->question_placeholder = Yii::$app->request->post()['PilotTodayslessonCorner']['question_placeholder'];
            $model->answer_type = Yii::$app->request->post()['PilotTodayslessonCorner']['answer_type'];
            $model->description1 = Yii::$app->request->post()['PilotTodayslessonCorner']['description1'];
            $model->description2 = Yii::$app->request->post()['PilotTodayslessonCorner']['description2'];
            $model->updated = time();
            //$model->designation = Yii::$app->request->post()['PilotTodayslessonCorner']['designation'];
            if ($model->save(false)) {
                $cid = $model->category_id;
                $answers = Yii::$app->request->post()['PilotTodayslessonQuestion']['answer'];
                $corrects = Yii::$app->request->post()['PilotTodayslessonQuestion']['Correct'];
                if (!empty($question)):
                    $ids = Yii::$app->request->post()['PilotTodayslessonQuestion']['id'];
                endif;
                for ($i = 1; $i <= Yii::$app->request->post()['dropdown_answer']; $i++):
                    if (!empty($ids)):
                        $question = PilotTodayslessonQuestion::find()->where(['id' => $ids[$i]])->one();
                        if ($question) {
                            $id = $ids[$i];
                            $question->secondary_question = Yii::$app->request->post()['PilotTodayslessonQuestion']['secondary_question'];
                            $question->corner_id = $model->id;
                            $question->Correct = $corrects[$i];
                            $question->answer = $answers[$i];
                            $question->created = time();
                            $question->save(false);
                            unset($answerslist[$id]);
                        } else {
                            $question = new PilotTodayslessonQuestion();
                            $question->secondary_question = Yii::$app->request->post()['PilotTodayslessonQuestion']['secondary_question'];
                            $question->corner_id = $model->id;
                            $question->Correct = $corrects[$i];
                            $question->answer = $answers[$i];
                            $question->created = time();
                            $question->updated = time();
                            $question->save(false);
                        }
                    else:
                        $question = new PilotTodayslessonQuestion();
                        $question->secondary_question = Yii::$app->request->post()['PilotTodayslessonQuestion']['secondary_question'];
                        $question->corner_id = $model->id;
                        $question->Correct = $corrects[$i];
                        $question->answer = $answers[$i];
                        $question->created = time();
                        $question->updated = time();
                        $question->save(false);
                    endif;
                endfor;
                foreach ($answerslist as $key1) {
                    $key2 = array_search($key1, $answerslist);
                    PilotTodayslessonQuestion::findOne($key2)->delete();
                }
                Yii::$app->session->setFlash('custom_message', 'Lesson Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-todayslesson-corner/index?cid=$cid");
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-todayslesson-corner/index?cid=$cid");
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'question' => $question,
                        'question1' => $question1
            ]);
        }
    }

    /**
     * Deletes an existing PilotTodayslessonCorner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $cid = $model->category_id;
        $this->findModel($id)->delete();

        if (!empty($model->dashboard_image)) {
            if (@file_get_contents('http://root.injoychange.com/backend/web/img/leadership-corner-images/dashboard-image/' . $model->dashboard_image)) {
                unlink('img/leadership-corner-images/dashboard-image/' . $model->dashboard_image);
            }
        }
        if (!empty($model->popup_image)) {
            if (@file_get_contents('http://root.injoychange.com/backend/web/img/leadership-corner-images/lightbox-image/' . $model->popup_image)) {
                unlink('img/leadership-corner-images/lightbox-image/' . $model->popup_image);
            }
        }
        Yii::$app->session->setFlash('custom_message', 'Lesson has been  deleted successfully!');
        return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-todayslesson-corner/index?cid=$cid");
    }

    /**
     * Finds the PilotTodayslessonCorner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotTodayslessonCorner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotTodayslessonCorner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /* ajax hit from create leadership corner popup
     * from custom.js
     */

    public function actionCheckforweek() {
        $cid = $_POST['cid'];
        $week = $_POST['week'];
        $model = PilotTodayslessonCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
        if ($model) {
            echo 'This is already exist!Select another one';
        } else {
            exit();
        }
//echo '<pre>';print_r($_POST);die;
    }

    /* ajax hit from create leadership corner from EDIT popup
     * from custom.js
     */

    public function actionCheckforweekonedit() {
        $id = $_POST['id'];
        $week = $_POST['week'];
        $modelforcid = PilotTodayslessonCorner::find()->where(['id' => $id])->one();
        $cid = $modelforcid->category_id;
        $alreadyweekexist = $modelforcid->week;
        $model = PilotTodayslessonCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
// echo '<pre>';print_r($_POST);die;
        if ($model) {
            if (($model->week) == $alreadyweekexist) {
                exit();
            } else {
                echo 'This is Already exist!Select another one';
            }
        } else {
            exit();
        }
//echo '<pre>';print_r($_POST);die;
    }

    public function actionUploadAudio() {
        if ($_FILES) {

            $uploaddir = 'img/leadership-corner-audio/';
            $image_name = time() . '_' . $_FILES['file']['name'];
            $uploadfile = $uploaddir . $image_name;
            $filename = $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $output['Success'] = "File is valid, and was successfully uploaded.\n data Submited Successfully!\n";
                $output['filename'] = $image_name;
                return json_encode($output);
            }
        }
    }

    public function actionUploadVideo() {
        if ($_FILES) {
            $uploaddir = 'img/leadership-corner-video/';
            $image_name = time() . '_' . $_FILES['file']['name'];
            $uploadfile = $uploaddir . $image_name;
            $filename = $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $output['Success'] = "File is valid, and was successfully uploaded.\n data Submited Successfully!\n";
                $output['filename'] = $image_name;
                return json_encode($output);
            }
        }
    }

    public function actionUploadVideoimages() {
        if ($_FILES) {
            $uploaddir = 'img/leadership-corner-video/';
            $image_name = time() . '_' . $_FILES['file']['name'];
            $uploadfile = $uploaddir . $image_name;
            $filename = $_FILES['file']['name'];
            if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                $output['Success'] = "File is valid, and was successfully uploaded.\n data Submited Successfully!\n";
                $output['filename'] = $image_name;
                return json_encode($output);
            }
        }
    }
    public function actionUpload() {
        if (($_FILES['upload'] == "none") OR ( empty($_FILES['upload']['name']))) {
            $message = "Please Upload the Image";
        } else if (($_FILES['upload']["type"] != "image/jpeg") AND ( $_FILES['upload']["type"] != "image/png")) {
            $message = "Please Select JPG Or PNG.";
        } else {
            $name = $_FILES['upload']['name'];
            $full_path = Yii::getAlias('@image') . '/' . $name;
            move_uploaded_file($_FILES['upload']['tmp_name'], $full_path);
            $web_path = 'http://root.injoychange.com' . Yii::$app->homeUrl . 'image/' . $name;
        }

        $callback = $_REQUEST['CKEditorFuncNum'];
        echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '", "' . $web_path . '", "' . $message . '" );</script>';
    }
}
