<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotCheckinYourselfCategory;
use backend\models\PilotCheckinYourselfCategorySearch;
use backend\models\PilotCheckinYourselfData;
use backend\models\PilotTags;
use backend\models\PilotInhouseUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\AccessControl;

/**
 * PilotCheckinYourselfCategoryController implements the CRUD actions for PilotCheckinYourselfCategory model.
 */
class PilotCheckinYourselfCategoryController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [''],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'view', 'create', 'update', 'ajaxcheckin', 'tag-list', 'load-tag'],
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
     * Lists all PilotCheckinYourselfCategory models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PilotCheckinYourselfCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new PilotCheckinYourselfCategory();
        $model1 = new PilotTags();
        $coremodal = new PilotCheckinYourselfData();

        if (isset(Yii::$app->request->post()['PilotCheckinYourselfCategory']) && $model1->load(Yii::$app->request->post())) {
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
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
                    'model1' => $model1,
                    'coremodal' => $coremodal
        ]);
    }

    /**
     * Displays a single PilotCheckinYourselfCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotCheckinYourselfCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotCheckinYourselfCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotCheckinYourselfCategory model.
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
     * Deletes an existing PilotCheckinYourselfCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        $corevalues = PilotCheckinYourselfData::find()->where(['category_id' => $id])->all();
        if (!empty($corevalues)) {
            foreach ($corevalues as $data) {
                PilotCheckinYourselfData::findOne($data->id)->delete();
            }
        }
        Yii::$app->session->setFlash('custom_message', 'The Category is deleted successfuly!!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the PilotCheckinYourselfCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotCheckinYourselfCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotCheckinYourselfCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAjaxcheckin() {
        $cid = isset($_GET['cid']) ? $_GET['cid'] : '';
        if (!empty($cid)) {
            $coremodal = PilotCheckinYourselfData::find()->where(['category_id' => $cid])->one();
            $corevalues = PilotCheckinYourselfData::find()->where(['category_id' => $cid])->all();
        } else {
            $coremodal = new PilotCheckinYourselfData();
            $corevalues = array();
        }
        if (empty($coremodal)) {
            $coremodal = new PilotCheckinYourselfData();
        }

        $oldcoreValue = array();

        if (Yii::$app->request->post()) {
            foreach ($corevalues as $val) {
                $oldcoreValue[$val->id] = $val->id;
            }

            //echo "<pre>"; print_r(Yii::$app->request->post()['PilotCheckinYourselfData']); die(" here");
            $core_value = Yii::$app->request->post()['PilotCheckinYourselfData']['core_value'];
            if (!empty($core_value)) {
                foreach ($core_value as $key => $value) {
                    if (!empty($value)) {
                        if (in_array($key, $oldcoreValue)) {
                            $coremodal = PilotCheckinYourselfData::find()->where(['id' => $key])->one();
                            $coremodal->user_id = Yii::$app->user->identity->id;
                            $coremodal->category_id = Yii::$app->request->post()['PilotCheckinYourselfData']['category_id'];
                            $coremodal->question_label = Yii::$app->request->post()['PilotCheckinYourselfData']['question_label'];
                            $coremodal->placeholder_text = Yii::$app->request->post()['PilotCheckinYourselfData']['placeholder_text'];
                            $coremodal->select_option_text = Yii::$app->request->post()['PilotCheckinYourselfData']['select_option_text'];
                            $coremodal->core_value = $value;
                            $coremodal->created = time();
                            $coremodal->updated = time();
                            $coremodal->save(false);
                            unset($oldcoreValue[$key]);
                        } else {
                            $coremodal = new PilotCheckinYourselfData();
                            $coremodal->user_id = Yii::$app->user->identity->id;
                            $coremodal->category_id = Yii::$app->request->post()['PilotCheckinYourselfData']['category_id'];
                            $coremodal->question_label = Yii::$app->request->post()['PilotCheckinYourselfData']['question_label'];
                            $coremodal->placeholder_text = Yii::$app->request->post()['PilotCheckinYourselfData']['placeholder_text'];
                            $coremodal->select_option_text = Yii::$app->request->post()['PilotCheckinYourselfData']['select_option_text'];
                            $coremodal->core_value = $value;
                            $coremodal->created = time();
                            $coremodal->updated = time();
                            $coremodal->save(false);
                        }
                    }
                }
                if (!empty($oldcoreValue)) {
                    foreach ($oldcoreValue as $key => $data) {
                        PilotCheckinYourselfData::findOne($key)->delete();
                    }
                }
            }
            return $this->redirect('index');
        }

        $html = $this->renderAjax('ajaxcheckin', [
            'coremodal' => $coremodal,
            'corevalues' => $corevalues,
            'cid' => $cid,
        ]);
        echo $html; //json_encode(['status' => 'success', 'html' => $html]);
        exit();
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
        $model = new PilotCheckinYourselfCategory;
        $model1 = new Pilottags;
        $modal = PilotCheckinYourselfCategory::find()->where(['id' => $id])->one();
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
            $id = Yii::$app->request->post()['PilotCheckinYourselfCategory']['id'];
            $modal = PilotCheckinYourselfCategory::find()->where(['id' => $id])->one();
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
            if ($modal->category_name != Yii::$app->request->post()['PilotCheckinYourselfCategory']['category_name']):
                $modal->category_name = Yii::$app->request->post()['PilotCheckinYourselfCategory']['category_name'];
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
