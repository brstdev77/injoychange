<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotDailyinspirationCategory;
use backend\models\PilotDailyinspirationCategorySearch;
use backend\models\PilotInhouseUser;
use backend\models\PilotDailyinspirationImage;
use backend\models\PilotTags;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PilotDailyinspirationCategoryController implements the CRUD actions for PilotDailyinspirationCategory model.
 */
class PilotDailyinspirationCategoryController extends Controller {

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
                        'actions' => ['index', 'create', 'update', 'view', 'dailyinspiration', 'dailyinspirationsubmit', 'swap', 'folder-delete', 'tag-list', 'load-tag'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['delete', 'dailyinpiration_image_delete'],
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

    /*
     *  enabled csrf for ajax request 
     */

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all PilotDailyinspirationCategory models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new PilotDailyinspirationCategory();
        $model1 = new PilotTags();
        $searchModel = new PilotDailyinspirationCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
        } else {
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
                        'model1' => $model1,
            ]);
        }
    }

    /**
     * Displays a single PilotDailyinspirationCategory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PilotDailyinspirationCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PilotDailyinspirationCategory();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PilotDailyinspirationCategory model.
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
     * Deletes an existing PilotDailyinspirationCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = PilotDailyinspirationImage::find()->where(['category_id' => $id])->all();
        foreach ($model as $val) {
            if (!empty($val->image_name)) {
                if (@file_get_contents('http://root.injoychange.com/backend/web/img/daily-inspiration-images/' . $val->image_name)) {
                    unlink('img/daily-inspiration-images/' . $val->image_name);
                }
            }
        }
        \Yii::$app->db->createCommand()->delete('pilot_dailyinspiration_image', ['category_id' => $id])->execute();
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('custom_message', 'Category  Successfully Deleted !');
        return $this->redirect(['index']);
    }

    /**
     * Finds the PilotDailyinspirationCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotDailyinspirationCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotDailyinspirationCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDailyinspiration() {
        //if(!isset($_SESSION['file1'])){
        //	$_SESSION['file1'] = array();
        //}
        if ($_FILES) {
            $uploaddir = 'img/daily-inspiration-images/';
            $image_name = time() . '_' . $_FILES['file']['name'];
            $uploadfile = $uploaddir . $image_name;
            $filename = $_FILES['file']['name'];

            $my_array = array($filename);
            $imageName = explode('.', $_FILES['file']['name']);
            $imgOrder = $imageName[0];
            $category = $_POST['category_id'];
            if (!is_numeric($imgOrder) || $imgOrder < 0) {
                $output['Error'] = 'Invalid file name. File name must be numeric';
                return json_encode($output);
                die();
            } else {

                if (isset($_SESSION['file1'])) {
                    if (in_array($filename, $_SESSION['file1'])) {
                        $output['Error'] = 'file already uploaded for the day' . $imgOrder;
                        return json_encode($output);
                    }
                }

                $models = PilotDailyinspirationImage::find()->where(['and', "order_number='$imgOrder'", "category_id='$category'"])->one();
                if (empty($models)) {
                    $_SESSION['file1'][] = $filename;
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                        //$images = array($image_name);
                        $_SESSION['image'][] = $image_name;
                        $output['Success'] = "File is valid, and was successfully uploaded.\n data Submited Successfully!\n";
                        $output['filename'] = $image_name;
                        return json_encode($output);
                    } else {
                        $output['Error'] = "Possible file upload attack!\n";
                        return json_encode($output);
                    }
                } else {
                    $output['Error'] = 'file already uploaded for the day' . $imgOrder;
                    return json_encode($output);
                }
            }
        }
        return $this->render('dailyinspiration', [
                    'session' => $session,
        ]);
    }

    public function actionDailyinspirationsubmit() {
        if ($_POST) {
            foreach ($_SESSION['image'] as $value) {
                $model = new PilotDailyinspirationImage();
                $imageName1 = substr($value, strpos($value, '_') + 1);
                $imageName = explode('.', $imageName1);
                $imgOrder = $imageName[0];
                $model->order_number = $imgOrder;
                $model->category_id = $_POST['category_id'];
                $model->image_name = $value;
                if ($model->save(false)) {
                    echo 'data Submited Successfully!';
                }
            }
            Yii::$app->session->setFlash('custom_message', 'Daily inspiration image uploaded successfuly!');
            return $this->redirect('dailyinspiration');
        }
        return $this->redirect('dailyinspiration');
    }

    /*
     * deletion of all images and video form table and from folder 
     * on delete of category
     */

    public function actionDailyinpiration_image_delete() {
        $id = Yii::$app->request->get('id');
        $cid = Yii::$app->request->get('cid');
        $data = PilotDailyinspirationImage::findOne($id);
        if (!empty($data['image_name'])) {
            // echo $data['image_name'];die;
            if (@file_get_contents('img/daily-inspiration-images/' . $data['image_name'])) {
                PilotDailyinspirationImage::findOne($id)->delete();
                $success = unlink('img/daily-inspiration-images/' . $data['image_name']);
                if ($success):
                    return 'deleted';
                endif;
            }
        }
        return "not deleted";
    }

    public function actionFolderDelete() {
        $imagename = Yii::$app->request->get('filename');
        if (@file_get_contents('img/daily-inspiration-images/' . $imagename)) {
            $success = unlink('img/daily-inspiration-images/' . $imagename);
            if ($success):
                $imageName1 = substr($imagename, strpos($imagename, '_') + 1);
                $imageName = explode('.', $imageName1);
                $imgOrder = $imageName[0];
                foreach (array_keys($_SESSION['file1'], $imageName1) as $key) {
                    unset($_SESSION['file1'][$key]);
                }
                foreach (array_keys($_SESSION['image'], $imagename) as $key) {
                    unset($_SESSION['image'][$key]);
                    echo $imgOrder;
                }
                return 'deleted';
            endif;
        }
    }

    public function actionSwap() {
        $id = $_POST['id'];
        $cid = $_POST['cid'];
        $id1 = $_POST['id1'];
        $model = PilotDailyinspirationImage::find()->where(['and', "order_number='$id1'", "category_id='$cid'"])->one();
        $model1 = PilotDailyinspirationImage::find()->where(['and', "order_number='$id'", "category_id='$cid'"])->one();
        $image = $model->image_name;
        $model->image_name = $model1->image_name;
        $model1->image_name = $image;
        if ($model->save() && $model1->save()) {
            echo 'swapped';
        } else {
            return "not swapped";
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
        $model = new PilotDailyinspirationCategory;
        $model1 = new Pilottags;
        $modal = PilotDailyinspirationCategory::find()->where(['id' => $id])->one();
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
            $id = Yii::$app->request->post()['PilotDailyinspirationCategory']['id'];
            $modal = PilotDailyinspirationCategory::find()->where(['id' => $id])->one();
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
            if ($modal->category_name != Yii::$app->request->post()['PilotDailyinspirationCategory']['category_name']):
                $modal->category_name = Yii::$app->request->post()['PilotDailyinspirationCategory']['category_name'];
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
