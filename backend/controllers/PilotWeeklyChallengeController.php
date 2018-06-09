<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotWeeklyChallenge;
use backend\models\PilotWeeklyChallengeSearch;
use backend\models\PilotInhouseUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * PilotWeeklyChallengeController implements the CRUD actions for PilotWeeklyChallenge model.
 */
class PilotWeeklyChallengeController extends Controller {

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
     * Lists all PilotWeeklyChallenge models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new PilotWeeklyChallenge();
        if (Yii::$app->request->post()) {
            $week_id = Yii::$app->request->post()['PilotWeeklyChallenge']['category_id'];
            $modelupdate = PilotWeeklyChallenge::find()->where(['id' => $week_id])->one();
            $oldimageupdate = $modelupdate->image;
            if ($modelupdate) {
                $modelupdate->week = Yii::$app->request->post()['PilotWeeklyChallenge']['week'];
                $modelupdate->video_title = Yii::$app->request->post()['PilotWeeklyChallenge']['video_title'];
                $modelupdate->video_link = Yii::$app->request->post()['PilotWeeklyChallenge']['video_link'];
                $image = UploadedFile::getInstance($modelupdate, 'image');
                if ($image) {
                    $modelupdate->image = time() . '.' . $image->extension;
                    $image->saveAs('img/weekly-challenge-images/' . $modelupdate->image);
                } else {
                    if ($_POST['imgupdateedit'] == 1) {
                        if (!empty($modelupdate->image)) {
                            // unlink('img//' . $model->image);
                        }
                        $modelupdate->image = '';
                    } else {
                        $modelupdate->image = $oldimageupdate;
                    }
                }
                $modelupdate->save(false);
                $cid = $modelupdate->category_id;
                Yii::$app->session->setFlash('custom_message', 'Video Updated Successfully!');
                return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-weekly-challenge/index?cid=$cid");
            } else {
                $model->load(Yii::$app->request->post());
                $image = UploadedFile::getInstance($model, 'image');
                if ($image) {
                    $model->image = time() . '.' . $image->extension;
                    $image->saveAs('img/weekly-challenge-images/' . $model->image);
                } else {

                    $model->image = '';
                }
                if ($model->save(false)) {

                    $cid = $model->category_id;
                    Yii::$app->session->setFlash('custom_message', 'Video Uploaded Successfully!');
                    return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-weekly-challenge/index?cid=$cid");
                }
            }
        } else {
            return $this->render('index');
        }
    }

    /**
     * Displays a single PilotWeeklyChallenge model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotWeeklyChallenge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotWeeklyChallenge();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotWeeklyChallenge model.
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
     * Deletes an existing PilotWeeklyChallenge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $cid = $model->category_id;
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('custom_message', 'Video Deleted Successfully!');
        return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-weekly-challenge/index?cid=$cid");
    }

    /**
     * Finds the PilotWeeklyChallenge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotWeeklyChallenge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotWeeklyChallenge::findOne($id)) !== null) {
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
    public function actionWeeklychallenge() {
        $model = new PilotWeeklyChallenge();
        if ($_POST) {
            $model->load(Yii::$app->request->post());
            if ($model->save(false)) {
                return $this->redirect('weeklychallenge');
            }
        } else {
            return $this->render('weeklychallenge', [
                        'model' => $model,
                            ]
            );
        }
    }

    /*
     * checking week  exist corrsponding to the weekly challenge video 
     * if yes it will not add more than one video according to the category id
     */

    public function actionCheckweekvideo() {
        if ($_POST) {
            $week = $_POST['week'];
            $category = $_POST['category_id'];
            $model = PilotWeeklyChallenge::find()->where(['and', "week='$week'", "category_id='$category'"])->one();
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
            $model = PilotWeeklyChallenge::find()->where(['and', "week='$week'", "category_id='$category'"])->one();
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
