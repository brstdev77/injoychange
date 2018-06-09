<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotGettoknowCorner;
use backend\models\PilotGettoknowCornerSearch;
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
class PilotGettoknowCornerController extends Controller {
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
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'viewleadership', 'weekvalidation', 'checkforweek','checkforweekonedit','upload'],
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
     * Lists all PilotLeadershipCorner models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PilotGettoknowCornerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
    }

    /**
     * Lists all PilotLeadershipCorner models.
     * @return mixed
     */
    public function actionViewleadership($cid) {
        $check = PilotGettoknowCorner::find()->where(['client_listing' => $cid])->all();
        if (empty($check)) {
            return $this->redirect('index');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => PilotGettoknowCorner::find()->where(['client_listing' => $cid]),
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

        $model = new PilotGettoknowCorner();
         $model->scenario = 'create';
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $firstimg = UploadedFile::getInstance($model, 'first_user_profile');
            $secondimg = UploadedFile::getInstance($model, 'second_user_profile');
            $thirdimg = UploadedFile::getInstance($model, 'third_user_profile');
            if ($firstimg) {
                $model->first_user_profile = time() . '_' . $firstimg->name;
                $firstimg->saveAs('img/knowtheteam/' . $model->first_user_profile);
            }
            if ($secondimg) {
                $model->second_user_profile = time() . '_' . $secondimg->name;
                $secondimg->saveAs('img/knowtheteam/' . $model->second_user_profile);
            }
            if ($thirdimg) {
                $model->third_user_profile = time() . '_' . $thirdimg->name;
                $thirdimg->saveAs('img/knowtheteam/' . $model->third_user_profile);
            }
            $model->user_id = Yii::$app->user->identity->id;
            $model->category_id = Yii::$app->request->post()['PilotGettoknowCorner']['category_id'];
            $model->created = time();
            $model->updated = time();
            if ($model->save(false)) {
                $cid = $model->category_id;
                Yii::$app->session->setFlash('custom_message', 'GetToKnow Corner Created Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-gettoknow-corner/index?cid=$cid");
            }
//            echo '<pre>';print_r(Yii::$app->request->post());
//            echo '<pre>';print_r($model);die;
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotLeadershipCorner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
         $model->scenario = 'update';
        $oldfirstimage = $model->first_user_profile;
        $oldsecondimage = $model->second_user_profile;
        $oldthirdimage = $model->third_user_profile;
//        $oldpicture = $model->picture;
        if ($model->load(Yii::$app->request->post())) {
            $firstimg = UploadedFile::getInstance($model, 'first_user_profile');
            $secondimg = UploadedFile::getInstance($model, 'second_user_profile');
            $thirdimg = UploadedFile::getInstance($model, 'third_user_profile');
            if ($firstimg) {
                $model->first_user_profile = time() . '_' . $firstimg->name;
                $firstimg->saveAs('img/knowtheteam/' . $model->first_user_profile);
            }
            else{
                $model->first_user_profile = $oldfirstimage;
            }
            if ($secondimg) {
                $model->second_user_profile = time() . '_' . $secondimg->name;
                $secondimg->saveAs('img/knowtheteam/' . $model->second_user_profile);
            }
            else{
                $model->second_user_profile = $oldsecondimage;
            }
            if ($thirdimg) {
                $model->third_user_profile = time() . '_' . $thirdimg->name;
                $thirdimg->saveAs('img/knowtheteam/' . $model->third_user_profile);
            }
            else{
                $model->third_user_profile = $oldthirdimage;
            }
            $model->user_id = Yii::$app->user->identity->id;
            $model->updated = time();
            if ($model->save(false)) {
                $cid = $model->category_id;
                Yii::$app->session->setFlash('custom_message', 'GetToKnow Corner Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-gettoknow-corner/index?cid=$cid");
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

        if (!empty($model->first_user_profile)) {
            if (@file_get_contents('http://root.injoymore.com/backend/web/img/knowtheteam/' . $model->first_user_profile)) { 
                unlink('img/knowtheteam/' . $model->first_user_profile);
            }
        }
        if (!empty($model->second_user_profile)) {
            if (@file_get_contents('http://root.injoymore.com/backend/web/img/knowtheteam/' . $model->second_user_profile)) {
                unlink('img/knowtheteam/' . $model->second_user_profile);
            }
        }
         if (!empty($model->third_user_profile)) {
            if (@file_get_contents('http://root.injoymore.com/backend/web/img/knowtheteam/' . $model->third_user_profile)) {
                unlink('img/knowtheteam/' . $model->third_user_profile);
            }
        }
        Yii::$app->session->setFlash('custom_message', 'Get to know the team corner has been  deleted successfully!');
        return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-gettoknow-corner/index?cid=$cid");
    }

    /**
     * Finds the PilotLeadershipCorner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotLeadershipCorner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotGettoknowCorner::findOne($id)) !== null) {
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
        $model = PilotGettoknowCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
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
        $modelforcid = PilotGettoknowCorner::find()->where(['id' => $id])->one();
        $cid = $modelforcid->category_id;
        $alreadyweekexist = $modelforcid->week;
        $model = PilotGettoknowCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
       // echo '<pre>';print_r($_POST);die;
        if ($model) {
          if(($model->week) == $alreadyweekexist){
              exit();
          }else{
            echo 'This is Already exist!Select another one';   
          }
            
        } else { 
           exit();
        }
        //echo '<pre>';print_r($_POST);die;
    }
//    public function actionGetInfo(){
//        $id = $_POST['id'];
//        $model = PilotGettoknowCorner::find()->where(['id' => $id])->one();
//        return json_encode($model);
//    }
    public function actionUpload() {
        if (($_FILES['upload'] == "none") OR ( empty($_FILES['upload']['name']))) {
            $message = "Please Upload the Image";
        } else if (($_FILES['upload']["type"] != "image/jpeg") AND ( $_FILES['upload']["type"] != "image/png")) {
            $message = "Please Select JPG Or PNG.";
        } else {
            $name = $_FILES['upload']['name'];
            $full_path = Yii::getAlias('@image') . '/' . $name;
            move_uploaded_file($_FILES['upload']['tmp_name'], $full_path);
            $web_path = 'http://root.injoymore.com' . Yii::$app->homeUrl . 'image/' . $name;
        }

        $callback = $_REQUEST['CKEditorFuncNum'];
        echo '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $callback . '", "' . $web_path . '", "' . $message . '" );</script>';
    }
}
