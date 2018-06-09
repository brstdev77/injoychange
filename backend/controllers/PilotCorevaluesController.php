<?php

namespace backend\controllers;

use Yii;
use backend\models\PilotCorevalues;
use backend\models\PilotCoreValuesImageCategorySearch;
use backend\models\PilotCorevaluesSearch;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\Company;
use backend\models\PilotInhouseUser;
use backend\models\PilotTags;
use backend\models\PilotCoreValuesImageCategory;
use backend\models\PilotCoreValueImage;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\filters\AccessControl;

/**
 * PilotCorevaluesController implements the CRUD actions for PilotCorevalues model.
 */
class PilotCorevaluesController extends Controller {

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
                        'actions' => ['index', 'create', 'update', 'view', 'upload', 'load-tag', 'core-image-category', 'corevalue', 'category-delete', 'checkcompanyexistalready', 'core-image-upload', 'coreimagesubmit','coreimage','swap','folder-delete','core_image_delete','upload'],
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

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all PilotCorevalues models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PilotCorevaluesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $searchModel1 = new PilotCoreValuesImageCategorySearch();
        $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
        $model = new PilotCorevalues();
        $model2 = new PilotTags();
        $model1 = new PilotCoreValuesImageCategory();
        if (Yii::$app->request->post()) {
            $comidexist = PilotCorevalues::find()->where(['company_id' => Yii::$app->request->post()['PilotCorevalues']['company_id']])->one();
            if (empty($comidexist)):
                $model->company_id = Yii::$app->request->post()['PilotCorevalues']['company_id'];
                $model->save(false);
            endif;
            Yii::$app->session->setFlash('custom_message', 'Core Values Company Added Successfully!');
            return $this->redirect(index);
        }
        else {
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'searchModel1' => $searchModel1,
                        'dataProvider1' => $dataProvider1,
                        'model' => $model,
                        'model1' => $model1,
                        'model2' => $model2
            ]);
        }
    }

    public function actionCoreImageCategory() {
        $model = new PilotCoreValuesImageCategory();
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

    /**
     * Creates a new core valse model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCorevalue() {
        $cid = isset($_GET['cid']) ? $_GET['cid'] : '';
        if (!empty($cid) && !is_numeric($cid)) {
            return $this->redirect('index');
        }
        if (Yii::$app->request->post()) {
            //delete previous befour update and save
            \Yii::$app
                    ->db
                    ->createCommand()
                    ->delete('pilot_company_corevaluesname', ['company_id' => Yii::$app->request->post()['PilotCompanyCorevaluesname']['company_id']])
                    ->execute();

            $corename = new PilotCompanyCorevaluesname();
            $corename->company_id = Yii::$app->request->post()['PilotCompanyCorevaluesname']['company_id'];
            $corename->vission_msg = Yii::$app->request->post()['PilotCompanyCorevaluesname']['vission_msg'];
            $corename->popup_heading = Yii::$app->request->post()['PilotCompanyCorevaluesname']['popup_heading'];
            $corename->core_heading = Yii::$app->request->post()['PilotCompanyCorevaluesname']['core_heading'];
            $corename->sub_title_heading1 = Yii::$app->request->post()['PilotCompanyCorevaluesname']['sub_title_heading1'];
            $corename->created = time();
            $corename->save(false);

            $coreValuesdefinition = Yii::$app->request->post()['PilotCompanyCorevaluesname']['definition'];
            $coreValues = Yii::$app->request->post()['pilotcompanycorevaluesname-core_values_name']['core_values_name'];
            if (!empty($coreValues)) {
                foreach ($coreValues as $key => $value) {
                    $corename = new PilotCompanyCorevaluesname();
                    $corename->company_id = Yii::$app->request->post()['PilotCompanyCorevaluesname']['company_id'];
                    $corename->core_values_name = $value;
                    $corename->definition = $coreValuesdefinition[$key];
                    $corename->created = time();
                    $corename->save(false);
                }
            }
            Yii::$app->session->setFlash('custom_message', 'Core Values Added Successfully!');
            return $this->redirect(['index']);
        }
        return $this->render('corevalue', [
                    'cid' => $cid,
        ]);
    }

    public function actionView($cid) {
        $core_values = PilotCompanyCorevaluesname::find()->where(['company_id' => $cid])->orderby(['id' => SORT_ASC])->all();
        $vission_message = PilotCompanyCorevaluesname::find()->where(['company_id' => $cid])->andWhere(['!=', 'vission_msg', ''])->one();
        $html = $this->renderAjax('core_values_modal', [
            'core_values' => $core_values,
            'vission_message' => $vission_message
        ]);
        return $html;
    }

    /**
     * Deletes an existing PilotCorevalues model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();
        \Yii::$app
                ->db
                ->createCommand()
                ->delete('pilot_company_corevaluesname', ['company_id' => $model->company_id])
                ->execute();
        return $this->redirect(['index']);
    }

    public function actionCategoryDelete($id) {
        $model = PilotCoreValuesImageCategory::find()->where(['id' => $id])->one();
        if ($model->delete()):
            return $this->redirect(['index']);
        endif;
    }

    /**
     * Finds the PilotCorevalues model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PilotCorevalues the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PilotCorevalues::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * ajax request to check compny alredy exist for core values
     */

    public function actionCheckcompanyexistalready() {

        $model = PilotCorevalues::find()->where(['company_id' => $_POST['companyid']])->one();
        if (!empty($model)) {
            echo 'This company is alredy exist! select another one';
        } else {
            echo '';
        }
        exit();
    }

    public function actionLoadTag() {
        $tags_name = [];
        $id = $_POST['id'];
        $model = new PilotCoreValuesImageCategory;
        $model1 = new Pilottags;
        $modal = PilotCoreValuesImageCategory::find()->where(['id' => $id])->one();
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
            $id = Yii::$app->request->post()['PilotCoreValuesImageCategory']['id'];
            $modal = PilotCoreValuesImageCategory::find()->where(['id' => $id])->one();
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
            if ($modal->category_name != Yii::$app->request->post()['PilotCoreValuesImageCategory']['category_name']):
                $modal->category_name = Yii::$app->request->post()['PilotCoreValuesImageCategory']['category_name'];
            endif;
            $modal->tag_id = implode(',', $tag_ids);
            $modal->updated = time();
            if ($modal->save(false)) {
                Yii::$app->session->setFlash('custom_message', 'Category ' . $model->category_name . ' has been updated successfully!');
                return $this->redirect('index');
            }
        }
    }

    public function actionCoreImageUpload() {
        if ($_FILES) {
            $uploaddir = 'img/game/core_value/';
            $filename = $_FILES['file']['name'];
            $extension = strtolower(substr($filename,strpos($filename,'.')+1));
            $image_name = time() .'.'. $extension;
            $uploadfile = $uploaddir . $image_name;

            $my_array = array($filename);
            $imageName = explode('.', $_FILES['file']['name']);
            $imgOrder = $imageName[0];
            $category = $_POST['category_id'];
            /* if (!is_numeric($imgOrder) || $imgOrder < 0) {
              $output['Error'] = 'Invalid file name. File name must be numeric';
              return json_encode($output);
              die();
              } else { */

            if (isset($_SESSION['file1'])) {
                if (in_array($filename, $_SESSION['file1'])) {
                    $output['Error'] = 'file already uploaded for the day' . $imgOrder;
                    return json_encode($output);
                }
            }

            $models = PilotCoreValueImage::find()->where(['and', "order_number='$imgOrder'", "category_id='$category'"])->one();
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
            //}
        }
    }

    public function actionCoreimagesubmit() {
        $j= '';
        $i = 1;
        $models = PilotCoreValueImage::find()->where(["category_id" => $_POST['category_id']])->all();
        if (!empty($models)):
                $j = count($models);
        endif;
        if($j != ''):
            $j++;
            $i = $j;
        endif;
        if ($_POST) {
            foreach ($_SESSION['image'] as $value) {
                $model = new PilotCoreValueImage();
                $imgOrder = $i;
                $model->order_number = $imgOrder;
                $model->category_id = $_POST['category_id'];
                $model->image_name = $value;
                if ($model->save(false)) {
                    echo 'data Submited Successfully!';
                }
                $i++;
            }
            Yii::$app->session->setFlash('custom_message', 'Core Value Image uploaded successfuly!');
            return $this->redirect('index');
        }
        return $this->redirect('index');
    }
    public function actionCoreimage(){
        return $this->render('coreimage');
    }
     public function actionSwap() {
        $id = $_POST['id'];
        $cid = $_POST['cid'];
        $id1 = $_POST['id1'];
        $model = PilotCoreValueImage::find()->where(['and', "order_number='$id1'", "category_id='$cid'"])->one();
        $model1 = PilotCoreValueImage::find()->where(['and', "order_number='$id'", "category_id='$cid'"])->one();
        $image = $model->image_name;
        $model->image_name = $model1->image_name;
        $model1->image_name = $image;
        if ($model->save() && $model1->save()) {
            echo 'swapped';
        } else {
            return "not swapped";
        }
    }
    public function actionFolderDelete() {
        $imagename = Yii::$app->request->get('filename');
        if (@file_get_contents('img/game/core_value/' . $imagename)) {
            $success = unlink('img/game/core_value/' . $imagename);
            if ($success):
                foreach (array_keys($_SESSION['file1'], $imagename) as $key) {
                    unset($_SESSION['file1'][$key]);
                }
                foreach (array_keys($_SESSION['image'], $imagename) as $key) {
                    unset($_SESSION['image'][$key]);
                    echo 'Image ';
                }
                return 'deleted';
            endif;
        }
    }
     public function actionCore_image_delete() {
        $id = Yii::$app->request->get('id');
        $cid = Yii::$app->request->get('cid');
        $data = PilotCoreValueImage::findOne($id);
        if (!empty($data['image_name'])) {
            // echo $data['image_name'];die;
            if (@file_get_contents('img/game/core_value/' . $data['image_name'])) {
                PilotCoreValueImage::findOne($id)->delete();
                $success = unlink('img/game/core_value/' . $data['image_name']);
                if ($success):
                    return 'deleted';
                endif;
            }
        }
        return "not deleted";
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
