<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotActionmattersChallenge;
use backend\models\PilotActionmattersChallengeSearch;
use backend\models\PilotInhouseUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * PilotActionmattersChallengeController implements the CRUD actions for PilotActionmattersChallenge model.
 */
class PilotVoicemattersChallengeController extends Controller {

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
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'weeklychallenge', 'checkweekvideo', 'checkweekvideooneditpopup'],
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
     * Lists all PilotActionmattersChallenge models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new PilotActionmattersChallenge(); 
        if (Yii::$app->request->post()) {
            $week_id = Yii::$app->request->post()['PilotActionmattersChallenge']['category_id'];
            $modelupdate = PilotActionmattersChallenge::find()->where(['id' => $week_id])->one();
            // $oldimageupdate = $modelupdate->image;
            if ($modelupdate) {
                $modelupdate->week = Yii::$app->request->post()['PilotActionmattersChallenge']['week'];
                $modelupdate->question = Yii::$app->request->post()['PilotActionmattersChallenge']['question'];
                $modelupdate->save(false);
                $cid = $modelupdate->category_id;
                Yii::$app->session->setFlash('custom_message', 'Action Matters Question Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-voicematters-challenge/index?cid=$cid");
            } else {
                $model->load(Yii::$app->request->post());
                $model->category_id = Yii::$app->request->post()['category_id'];
                if ($model->save(false)) {
                    $cid = $model->category_id;
                    Yii::$app->session->setFlash('custom_message', 'Action Matters Question Created Successfully!');
                    return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-voicematters-challenge/index?cid=$cid");
                }
            }
        } else {
            return $this->render('index');
        }
    }

    /**
     * Displays a single PilotActionmattersChallenge model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotActionmattersChallenge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotActionmattersChallenge();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotActionmattersChallenge model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PilotActionmattersChallenge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $cid = $model->category_id;
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('custom_message', 'Question Deleted Successfully!');
        return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-voicematters-challenge/index?cid=$cid");
    }

    /**
     * Finds the PilotActionmattersChallenge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotActionmattersChallenge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotActionmattersChallenge::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * save wikely challenge model
     * If save is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionWeeklychallenge() {
//        $model = new PilotActionmattersChallenge();
//        if ($_POST) {
//            $model->load(Yii::$app->request->post());
//            if ($model->save(false)) {
//                return $this->redirect('weeklychallenge');
//            }
//        } else {
//            return $this->render('weeklychallenge', [
//                        'model' => $model,
//                            ]
//            );
//        }
//    }

    /*
     * checking week  exist corrsponding to the weekly challenge video 
     * if yes it will not add more than one video according to the category id
     */

    public function actionCheckweekvideo() {
        if ($_POST) {
            $week = $_POST['week'];
            $category = $_POST['category_id'];
            $model = PilotActionmattersChallenge::find()->where(['and', "week='$week'", "category_id='$category'"])->one();
            if ($model) {
                return 'This week is already exist!';
                exit();
            } else {
                exit();
            }
        }
    }

    /**
     * check if week already exits in database corresponding to category.
     * @return false or ture
     */
    public function actionCheckweekvideooneditpopup() {
        if ($_POST) {
            $week = $_POST['week'];
            $category = $_POST['category_id'];
            $weekid = $_POST['weekid'];
            $model = PilotActionmattersChallenge::find()->where(['and', "week='$week'", "category_id='$category'"])->one();
            if ($model->id == "$weekid") {
                exit();
            } else if (!empty($model)) {
                return 'This week is already exist!';
                exit();
            } else {
                exit();
            }
        }
    }

}
