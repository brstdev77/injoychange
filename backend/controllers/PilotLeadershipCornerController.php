<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotLeadershipCorner;
use backend\models\PilotLeadershipCornerSearch;
use backend\models\PilotInhouseUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * PilotLeadershipCornerController implements the CRUD actions for PilotLeadershipCorner model.
 */
class PilotLeadershipCornerController extends Controller {
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
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'viewleadership', 'weekvalidation', 'checkforweek', 'checkforweekonedit', 'upload-audio', 'upload-video', 'popupPhoto', 'dashboardPhoto','upload-videoimages'],
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
     * Lists all PilotLeadershipCorner models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PilotLeadershipCornerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new PilotLeadershipCorner();
        $id = Yii::$app->request->post()['PilotLeadershipCorner']['category_id'];
        $modelupdate = PilotLeadershipCorner::find()->where(['id' => $id])->one();

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
            $modelupdate->designation = Yii::$app->request->post()['PilotLeadershipCorner']['designation'];
            if ($modelupdate->save(false)) {
                $cid = $modelupdate->category_id;
                Yii::$app->session->setFlash('custom_message', 'Leadership Corner Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/index?cid=$cid");
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/index?cid=$cid");
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
            $model->category_id = Yii::$app->request->post()['PilotLeadershipCorner']['category_id'];
            $model->created = time();
            $model->updated = time();
            if ($model->save()) {
                $cid = $model->category_id;
                Yii::$app->session->setFlash('custom_message', 'Leadership Corner Created Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/index?cid=$cid");
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
     * Lists all PilotLeadershipCorner models.
     * @return mixed
     */
    public function actionViewleadership($cid) {
        $check = PilotLeadershipCorner::find()->where(['client_listing' => $cid])->all();
        if (empty($check)) {
            return $this->redirect('index');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => PilotLeadershipCorner::find()->where(['client_listing' => $cid]),
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);
        return $this->render('viewleadership', [
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PilotLeadershipCorner model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotLeadershipCorner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new PilotLeadershipCorner();
        if (Yii::$app->request->post()) {
//            echo '<pre>';
//            print_r(Yii::$app->request->post());
//            die;
//            $lightboximg = UploadedFile::getInstance($model, 'popup_image');
//            $dashboardimg = UploadedFile::getInstance($model, 'dashboard_image');
//            if ($lightboximg) {
//                $model->popup_image = time() . '_' . $lightboximg->name;
//                $lightboximg->saveAs('img/leadership-corner-images/lightbox-image/' . $model->popup_image);
//            }
//            if ($dashboardimg) {
//                $model->dashboard_image = time() . '_' . $dashboardimg->name;
//                $dashboardimg->saveAs('img/leadership-corner-images/dashboard-image/' . $model->dashboard_image);
//            }
            //$posterimg = UploadedFile::getInstance($model, 'video_poster');
            //ech
//            if ($posterimg) {
//                $model->video_poster = time() . '_' . $posterimg->name;
//                $posterimg->saveAs('img/leadership-corner-video/' . $model->video_poster);
//            }
            $model->load(Yii::$app->request->post());
            $popuparray = explode('/', Yii::$app->request->post()['PilotLeadershipCorner']['popup_image']);
            $dashboardarray = explode('/', Yii::$app->request->post()['PilotLeadershipCorner']['dashboard_image']);
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
            $model->category_id = Yii::$app->request->post()['PilotLeadershipCorner']['category_id'];
            $model->created = time();
            $model->updated = time();
            // echo '<pre>';print_r($model);die;
            if ($model->save(false)) {
                $cid = $model->category_id;
                Yii::$app->session->setFlash('custom_message', 'Leadership Corner Created Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/index?cid=$cid");
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing PilotLeadershipCorner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $oldlightboximageupdate = $model->popup_image;
        $olddashboardimageupdate = $model->dashboard_image;
        $oldfilelink = $model->file_link;
        $oldanswer = $model->answer_type;
        $oldposter = $model->video_poster;
        //$cid = $model->client_listing;
//        $oldpicture = $model->picture;
        if ($model->load(Yii::$app->request->post())) {
           // echo '<pre>';print_r(Yii::$app->request->post());die;
//            $lightboximage = UploadedFile::getInstance($model, 'popup_image');
//            $dashboardimage = UploadedFile::getInstance($model, 'dashboard_image');
//            $posterimg = UploadedFile::getInstance($model, 'video_poster');
//            //ech
//            if ($posterimg) {
//                $model->video_poster = time() . '_' . $posterimg->name;
//                $posterimg->saveAs('img/leadership-corner-video/' . $model->video_poster);
//            } else {
//                if ($_POST['dashboardposterupdate'] == 1) {
//                    if (!empty($model->video_poster)) {
//                        
//                    }
//                    $model->video_poster = '';
//                } else {
//                    $model->video_poster = $oldposter;
//                }
//            }
            $popuparray = explode('/', Yii::$app->request->post()['PilotLeadershipCorner']['popup_image']);
            $dashboardarray = explode('/', Yii::$app->request->post()['PilotLeadershipCorner']['dashboard_image']);
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
            $model->designation = Yii::$app->request->post()['PilotLeadershipCorner']['designation'];
            if ($model->save(false)) {
                $cid = $model->category_id;
                Yii::$app->session->setFlash('custom_message', 'Leadership Corner Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/index?cid=$cid");
            } else {
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/index?cid=$cid");
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PilotLeadershipCorner model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $cid = $model->category_id;
        $this->findModel($id)->delete();

        if (!empty($model->dashboard_image)) {
            if (@file_get_contents('http://devinjoyglobal.com/pilot/backend/web/img/leadership-corner-images/dashboard-image/' . $model->dashboard_image)) {
                unlink('img/leadership-corner-images/dashboard-image/' . $model->dashboard_image);
            }
        }
        if (!empty($model->popup_image)) {
            if (@file_get_contents('http://devinjoyglobal.com/pilot/backend/web/img/leadership-corner-images/lightbox-image/' . $model->popup_image)) {
                unlink('img/leadership-corner-images/lightbox-image/' . $model->popup_image);
            }
        }
        Yii::$app->session->setFlash('custom_message', 'Leadership corner has been  deleted successfully!');
        return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/index?cid=$cid");
    }

    /**
     * Finds the PilotLeadershipCorner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotLeadershipCorner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotLeadershipCorner::findOne($id)) !== null) {
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
        $model = PilotLeadershipCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
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
        $modelforcid = PilotLeadershipCorner::find()->where(['id' => $id])->one();
        $cid = $modelforcid->category_id;
        $alreadyweekexist = $modelforcid->week;
        $model = PilotLeadershipCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
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
}
