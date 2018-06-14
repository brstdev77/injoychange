<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotInhouseUser;
use backend\models\PilotInhouseUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * InhouseuserController implements the CRUD actions for PilotInhouseUser model.
 */
class InhouseuserController extends Controller {

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
                        'actions' => ['index', 'create', 'update', 'view', 'delete', 'profiledataajax'],
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
     * Lists all PilotInhouseUser models.
     * @return mixed
     */
    public function actionIndex() {

        $searchModel = new PilotInhouseUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PilotInhouseUser model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotInhouseUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotInhouseUser();
        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());           
            $profile_pic = UploadedFile::getInstance($model, 'profile_pic');
            if ($profile_pic) {
                $profile_pic = UploadedFile::getInstance($model, 'profile_pic');
                $model->profile_pic = time() . '_' . $profile_pic->name;
                $profile_pic->saveAs('img/profilepic/' . $model->profile_pic);
            } else {
                $model->profile_pic = '';
            }            
            $model->password = md5($model->password);
            $model->confirm_password = md5(Yii::$app->request->post()['PilotInhouseUser']['confirm_password']);    
            $model->created = time();
            $model->updated = time();
            $model->last_access_time = time();           
            if (!empty($model->lastname)) {
                $model->username = ucfirst($model->firstname) . ' ' . ucfirst($model->lastname);
            } else {
                $model->username = $model->firstname;
            }          
            $model->ip_address = $_SERVER['REMOTE_ADDR'];
            if ($model->save()) {
                Yii::$app->session->setFlash('created', 'User ' . ucfirst($model->firstname) . ' ' . ucfirst($model->lastname) . ' has been Created Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('create', ['model' => $model]);
        }
        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing PilotInhouseUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $model->setScenario('update');
        $oldprofilepic = $model->profile_pic;
        if ($model->load(Yii::$app->request->post())) {           
            $profile_pic = UploadedFile::getInstance($model, 'profile_pic');
            if ($profile_pic) {
                $profile_pic = UploadedFile::getInstance($model, 'profile_pic');

                $model->profile_pic = time() . '_' . $profile_pic->name;
                $profile_pic->saveAs('img/profilepic/' . $model->profile_pic);
            } else {
                if ($_POST['imgupdate'] == 1) {
                    if (!empty($model->profile_pic)) {
                        unlink('img/profilepic/' . $model->profile_pic);
                    }
                    $model->profile_pic = '';
                } else {
                    $model->profile_pic = $oldprofilepic;
                }
            }
            if (Yii::$app->request->post()['PilotInhouseUser']['passupdate']) {
                $model->password = md5(Yii::$app->request->post()['PilotInhouseUser']['passupdate']);
            }
            $model->role = Yii::$app->request->post()['PilotInhouseUser']['role'];
            $model->designation = Yii::$app->request->post()['PilotInhouseUser']['designation'];
            $model->status = Yii::$app->request->post()['PilotInhouseUser']['status'];
            $model->confirm_password = md5(Yii::$app->request->post()['PilotInhouseUser']['confirm_password']);
            $model->address = Yii::$app->request->post()['PilotInhouseUser']['address'];
            $model->phone_number_1 = Yii::$app->request->post()['PilotInhouseUser']['phone_number_1'];
            $model->phone_number_2 = Yii::$app->request->post()['PilotInhouseUser']['phone_number_2'];        
            $model->lastname = Yii::$app->request->post()['PilotInhouseUser']['lastname'];
            if (!empty($model->lastname)) {
                $model->username = ucfirst($model->firstname) . ' ' . ucfirst($model->lastname);
            } else {
                $model->username = $model->firstname;
            }
            $model->updated = time();
            if ($model->save()) {
                Yii::$app->session->setFlash('updated', 'User ' . ucfirst($model->firstname) . ' ' . ucfirst($model->lastname) . ' has been Updated Successfully!');
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing PilotInhouseUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        if (!empty($model->profile_pic)) {
            if (@file_get_contents('http://devinjoyglobal.com/pilot/backend/web/img/profilepic/' . $model->profile_pic)) {
                unlink('img/profilepic/' . $model->profile_pic);
            }
        }
        Yii::$app->session->setFlash('deleted', 'User  Successfully Deleted !');
        return $this->redirect(['index']);
    }

    /**
     * Finds the PilotInhouseUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotInhouseUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotInhouseUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionProfiledataajax() {
//        echo '<pre>';
//        print_r($_POST);
          $model = $this->findModel($_POST['id']);
          if(!empty($model->profile_pic)) {
              $image = $model->profile_pic;
          }else{
              $image = 'noimage.png';
          }
//        print_r($model);
        $html = '';
        $html = '<div class="row">
                  <div class="col-md-3">
                   <p> <img style="width: 98px;" src="'.Yii::$app->homeUrl.'img/profilepic/'.$image.'"></p>
                   </div>
                        <div class="col-md-9">
                        <p><b>' . $model->username . ', '.$model->designation.'</b></p>
                        <p>' . $model->emailaddress . '</p>
                        <p>' . $model->phone_number_1 . ', '.$model->phone_number_2.'</p>
                      </div>
                   </div>';
        echo $html;
       exit();
    }

}
