<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotTodayslessonCategory;
use backend\models\PilotTodayslessonCategorySearch;
use backend\models\PilotTodayslessonCorner;
use backend\models\PilotCreateGame;
use backend\models\PilotInhouseUser;
use backend\models\PilotTags;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PilotTodayslessonCategoryController implements the CRUD actions for PilotTodayslessonCategory model.
 */
class PilotTodayslessonCategoryController extends Controller {

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
                        'actions' => ['index', 'tag-list', 'load-tag'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['delete'],
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
     * Lists all PilotTodayslessonCategory models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PilotTodayslessonCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new PilotTodayslessonCategory();
        $model1 = new PilotTags();
        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->user->identity->id;
            $model->updated = time();
            $model->created = time();

            if (!empty(Yii::$app->request->post()['PilotTags']['tags'])):
                $tags = explode(',', Yii::$app->request->post()['PilotTags']['tags']);
                // $tags = array_filter($arr);
                foreach ($tags as $key => $value):
                    $model2 = PilotTags::find()->where(['tags' => $value])->one();
                    if (!empty($model2)) {
                        $tag_ids[] = $model2->id;
                    } else {
                        $model1 = new PilotTags();
                        $model1->tags = $value;
                        $model1->updated = time();
                        $model1->created = time();
                        if ($model1->save(false)):
                            $tag_ids[] = $model1->id;
                        endif;
                    }
                endforeach;
                $model->tag_id = implode(',', $tag_ids);
            endif;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('custom_message', 'Category ' . $model->category_name . ' has been created successfully!');
                return $this->redirect('index');
            }
        }
        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'model1' => $model1,
        ]);
    }

    /**
     * Displays a single PilotTodayslessonCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotTodayslessonCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotTodayslessonCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotTodayslessonCategory model.
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
     * Deletes an existing PilotTodayslessonCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        // check leadership corner assigned in create game corresponding to the upcoming and ongoing 
        // if yes then it will not delete
//        $gameleadership = PilotCreateGame::find()->where(['todayslesson_corner_content' => $id])->one();
//        $status = $gameleadership->status;
//        $model = $this->findModel($id);
//        $model = PilotTodayslessonCorner::find()->where(['category_id' => $id])->all();
//        if ($status != 1 || $status != 2 || empty($status)) {
//            foreach ($model as $val) {
//                if (!empty($val->lightbox_image)) {
//                    if (@file_get_contents('http://root.injoychange.com/backend/web/img/leadership-corner-images/lightbox-image/' . $val->lightbox_image)) {
//                        unlink('img/leadership-corner-images/lightbox-image' . $val->lightbox_image);
//                    }
//                }
//                if (!empty($val->dashboard_image)) {
//                    if (@file_get_contents('http://root.injoychange.com/backend/web/img/leadership-corner-images/dashboard-image/' . $val->dashboard_image)) {
//                        unlink('img/leadership-corner-images/dashboard-image' . $val->dashboard_image);
//                    }
//                }
//            }
            $this->findModel($id)->delete();
           // \Yii::$app->db->createCommand()->delete('pilot_todayslesson_corner', ['category_id' => $id])->execute();
            Yii::$app->session->setFlash('custom_message', 'The Category is deleted successfuly!!');
            return $this->redirect(['index']);
//        } else {
//            Yii::$app->session->setFlash('nope_message', 'This category will not delete, currenting assigned to the game!');
//            return $this->redirect(['index']);
//        }
    }

    /**
     * Finds the PilotTodayslessonCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotTodayslessonCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotTodayslessonCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionTagList() {
        $output = [];
        $rows = (new \yii\db\Query())
                ->select([tags])
                ->from('pilot_tags')
                ->all();
        // echo "<pre>";print_r($rows);die;
        foreach ($rows as $row) {
            $output[] = $row[tags];
        }
        echo json_encode($output);
    }

    public function actionLoadTag() {
        $tags_name = [];
        $id = $_POST['id'];
        $model = new PilotTodayslessonCategory;
        $model1 = new Pilottags;
        $modal = PilotTodayslessonCategory::find()->where(['id' => $id])->one();
        if (!empty($modal)):
            $tags[] = explode(',', $modal->tag_id);
            foreach ($tags as $value => $new) {
                foreach ($new as $tag_id) {
                    $tags_name1 = PilotTags::getRecords($tag_id);
                    $tags_name[] = $tags_name1;
                }
            }
            $tags_string = implode(',', $tags_name);
            $html = $this->renderAjax('tag_modals', [
                'model' => $model,
                'model1' => $model1,
                'category_name' => $modal->category_name,
                'id' => $modal->id,
                'tags_name' => $tags_string,
            ]);
            return $html;
        endif;
        if (Yii::$app->request->post()) {
            $id = Yii::$app->request->post()['PilotTodayslessonCategory']['id'];
            $modal = PilotTodayslessonCategory::find()->where(['id' => $id])->one();
            $tags = explode(',', Yii::$app->request->post()['PilotTags']['tags']);
            // $tags = array_filter($arr);
            foreach ($tags as $key => $value):
                $model2 = PilotTags::find()->where(['tags' => $value])->one();
                if (!empty($model2)) {
                    $tag_ids[] = $model2->id;
                } else {
                    $model1 = new PilotTags();
                    $model1->tags = $value;
                    $model1->updated = time();
                    $model1->created = time();
                    if ($model1->save(false)):
                        $tag_ids[] = $model1->id;
                    endif;
                }
            endforeach;
            if ($modal->category_name != Yii::$app->request->post()['PilotTodayslessonCategory']['category_name']):
                $modal->category_name = Yii::$app->request->post()['PilotTodayslessonCategory']['category_name'];
            endif;
            $modal->tag_id = implode(',', $tag_ids);
            $modal->updated = time();
            if ($modal->save(false)) {
                Yii::$app->session->setFlash('custom_message', 'Category ' . $model->category_name . ' has been created successfully!');
                return $this->redirect('index');
            }
        }
    }

}
