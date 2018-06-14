<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotDidyouknowCorner;
use backend\models\PilotDidyouknowCornerSearch;
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
class PilotDidyouknowCornerController extends Controller {
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
        $searchModel = new PilotDidyouknowCornerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new PilotDidyouknowCorner();
        $id = Yii::$app->request->post()['PilotDidyouknowCorner']['category_id'];
        $modelupdate = PilotDidyouknowCorner::find()->where(['id' => $id])->one();
        if ($modelupdate) {
            $modelupdate->load(Yii::$app->request->post());
            if ($modelupdate->save()) {
                $cid = $modelupdate->category_id;
                Yii::$app->session->setFlash('custom_message', 'Didyouknow Corner Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-didyouknow-corner/index?cid=$cid");
            }
        } elseif (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $model->user_id = Yii::$app->user->identity->id;
            $model->category_id = Yii::$app->request->post()['PilotDidyouknowCorner']['category_id'];
            $model->created = time();
            $model->updated = time();
            if ($model->save()) {
                $cid = $model->category_id;
                Yii::$app->session->setFlash('custom_message', 'Didyouknow Corner Created Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-didyouknow-corner/index?cid=$cid");
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
        $check = PilotDidyouknowCorner::find()->where(['client_listing' => $cid])->all();
        if (empty($check)) {
            return $this->redirect('index');
        }
        $dataProvider = new ActiveDataProvider([
            'query' => PilotDidyouknowCorner::find()->where(['client_listing' => $cid]),
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
        if ($model->load(Yii::$app->request->post())) {
//            $picture = UploadedFile::getInstance($model, 'picture');
//            if ($picture) {
//                $model->picture = time() . '_' . $picture->name;
//                $picture->saveAs('img/leadership-corner-images/' . $model->picture);
//            }
            $model->updated = time();
            $model->created = time();
            $model->user_id = Yii::$app->user->identity->id;
            $model->save();
            Yii::$app->session->setFlash('custom_message', 'Didyouknow corner has been  created successfully!');
            return $this->redirect('index');
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
        $cid = $model->client_listing;
//        $oldpicture = $model->picture;
        if ($model->load(Yii::$app->request->post())) {
//            $picture = UploadedFile::getInstance($model, 'picture');
//            if ($picture) {
//                $model->picture = time() . '_' . $picture->name;
//                $picture->saveAs('img/leadership-corner-images/' . $model->picture);
//            } else {
//                if ($_POST['imgupdate'] == 1) {
//                    if (!empty($model->picyure)) {
//                        unlink('img/leadership-corner-images/' . $model->picture);
//                    }
//                    $model->picture = '';
//                } else {
//                    $model->picture = $oldpicture;
            //  }
            //  }
            $model->updated = time();
            $model->user_id = Yii::$app->user->identity->id;
            $model->save(false);
            return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-corner/viewleadership?cid=$cid");
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

        Yii::$app->session->setFlash('custom_message', 'Didyouknow corner has been  deleted successfully!');
        return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-didyouknow-corner/index?cid=$cid");
    }

    /**
     * Finds the PilotLeadershipCorner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotLeadershipCorner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotDidyouknowCorner::findOne($id)) !== null) {
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
        $model = PilotDidyouknowCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
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
        $modelforcid = PilotDidyouknowCorner::find()->where(['id' => $id])->one();
        $cid = $modelforcid->category_id;
        $alreadyweekexist = $modelforcid->week;
        $model = PilotDidyouknowCorner::find()->where(['and', ['category_id' => $cid], ['week' => $week]])->one();
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
