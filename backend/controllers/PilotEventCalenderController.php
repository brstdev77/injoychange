<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotEventCalender;
use backend\models\PilotEventCalenderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\db\Expression;

/**
 * PilotEventCalenderController implements the CRUD actions for PilotEventCalender model.
 */
class PilotEventCalenderController extends Controller {
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
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all PilotEventCalender models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new PilotEventCalender();
       
        /*
         * check if there is post
         */
        if ($model->load(Yii::$app->request->post())) {
            $model->start_date = strtotime($model->start_date);
            $model->end_date = strtotime($model->end_date);
            $model->updated = time();
            $model->created = time();
            $model->user_id = Yii::$app->user->identity->id;
            $model->color = Yii::$app->request->post()['PilotEventCalender']['color'];
            if (!empty(Yii::$app->request->post()['PilotEventCalender']['assign'])) {
                $model->assign = implode(",", Yii::$app->request->post()['PilotEventCalender']['assign']);
            }
            if (empty($model->color)) {
                $model->color = 'rgb(0, 192, 239)';
            }
            if ($model->save(false)) {
                Yii::$app->session->setFlash('custom_message', 'Event has been created successfully!');
                return $this->redirect('index');
            }
        } else {
            $date = time();
            /*
             * check user if admin or manager
             */
            if (Yii::$app->user->identity->role != '1') {
                $upcomming = PilotEventCalender::find()->where(['>', 'start_date', $date])->andWhere(['OR', ['user_id' => Yii::$app->user->identity->id], (new Expression('FIND_IN_SET(:uid, assign)'))])->addParams([':uid' => Yii::$app->user->identity->id])->asArray()->orderBy(['start_date' => SORT_ASC])->all();
            } else {
                $upcomming = PilotEventCalender::find()->where(['>', 'start_date', $date])->orderBy(['start_date' => SORT_ASC])->all();
            }

            return $this->render('index', [
                        'model' => $model,
                        'upcomming' => $upcomming
            ]);
        }
    }

    /**
     * Displays a single PilotEventCalender model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotEventCalender model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotEventCalender();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotEventCalender model.
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
     * Deletes an existing PilotEventCalender model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('custom_message', 'Event has been deleted successfully!');
        return $this->redirect(Yii::$app->homeUrl . 'pilot-event-calender/eventlisting');
    }

    /**
     * Finds the PilotEventCalender model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotEventCalender the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotEventCalender::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * fetch all existing PilotEventCalender events.
     * @return json
     */
    public function actionGetallevent() {
        /*
         * check user if admin or manager
         */
        if (Yii::$app->user->identity->role != '1') {
            $model = PilotEventCalender::find()->Where(['OR', ['user_id' => Yii::$app->user->identity->id], (new Expression('FIND_IN_SET(:uid, assign)'))])->addParams([':uid' => Yii::$app->user->identity->id])->asArray()->orderBy(['start_date' => SORT_ASC])->all();
        } else {
            $model = PilotEventCalender::find()->all();
        }

        $data = array();
        foreach ($model as $value) {
            $value = (object) $value;
            $data[] = array(
                'title' => $value->event_name,
                'start' => Date('c', $value->start_date), //valide format :: '2017-06-05T09:54:51'
                'end' => Date('c', $value->end_date),
                'allDay' => false,
                'backgroundColor' => $value->color,
                'borderColor' => $value->color,
            );
        }
        return json_encode($data);
        exit();
    }

    /**
     * lising of all events
     * @return mixed
     */
    public function actionEventlisting() {
        /*
         * check if there is post
         */
        if (!empty(Yii::$app->request->post())) {
            $id = Yii::$app->request->post()['PilotEventCalender']['id'];
            $model_update = $this->findModel($id);
            if ($model_update->load(Yii::$app->request->post())) {
                $model_update->start_date = strtotime($model_update->start_date);
                $model_update->end_date = strtotime($model_update->end_date);
                $model_update->event_name = Yii::$app->request->post()['PilotEventCalender']['event_name'];
                $model_update->updated = time();
                $model_update->user_id = Yii::$app->user->identity->id;
                $model_update->color = Yii::$app->request->post()['PilotEventCalender']['color'];
                if (!empty(Yii::$app->request->post()['PilotEventCalender']['assign'])) {
                    $model_update->assign = implode(",", Yii::$app->request->post()['PilotEventCalender']['assign']);
                }
                if (empty($model_update->color)) {
                    $model_update->color = 'rgb(0, 166, 90)';
                }
                $model_update->save(false);
                Yii::$app->session->setFlash('custom_message', 'Event has been updated successfully!');
                return $this->redirect(Yii::$app->homeUrl . 'pilot-event-calender/eventlisting');
            }
        } else {
            $model = new PilotEventCalender();
            $searchModel = new PilotEventCalenderSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('event-listing', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model
            ]);
        }
    }

    /**
     * Retrive detali of event
     * @param $id integer
     * @return mixed
     */
    public function actionEventdata($id) {
        $model = $this->findModel($id);
        $data = array();
        if (!empty($model)) {
            $data = array(
                'id' => $model->id,
                'title' => $model->event_name,
                'start_date' => date('m/d/Y', $model->start_date),
                'end_date' => date('m/d/Y', $model->end_date),
                'campany_id' => $model->company_id,
                'challenge_id' => $model->challenge_id,
                'color' => $model->color,
                'assign' => $model->assign,
            );
        }
        return \yii\helpers\Json::encode($data);
        exit();
    }

}
