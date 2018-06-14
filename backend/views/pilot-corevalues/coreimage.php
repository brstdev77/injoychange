<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\PilotCoreValueImage;
use backend\models\PilotCoreValuesImageCategory;

/* @var $this yii\web\View */
/* @var $model backend\models\Content */

/*
 * Added js and css files
 */
$this->registerJsFile(Yii::$app->homeUrl . 'js/packery.pkgd.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->title = 'Core Image';
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
session_destroy();
?>
<input type="hidden" name="cid" id="cid" value="<?php echo $_GET['cid']; ?>" />
<?php
$model = PilotCoreValueImage::find()->where(['category_id' => Yii::$app->request->get('cid')])->orderBy([new \yii\db\Expression('order_number')])->all();

$category = PilotCoreValuesImageCategory::find()->where(['id' => Yii::$app->request->get('cid')])->one();
?>
<div class="content-dailyinspiration">
    <div class='row'>
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Core Value Images</h3>
                    <?= Html::a('Add Image<i class="fa fa-plus"></i>', ['#'], ['class' => 'btn btn-default pull-right', 'data-toggle' => 'modal', 'data-target' => '#add_image']) ?>
                </div>
                <div class="box-body">

                    <?php
                    if ($category) {
                        if ($model) {
                            ?>
                            <div class='grid-item'>
                                <?php foreach ($model as $val) { ?>
                                    <div class="box-item del<?= $val->id ?>" rel1="<?php echo $val->category_id ?>">
                                        <a class="delete2" rel="<?php echo $val->id ?>" cid="<?php echo $val->category_id ?>">
                                            <i class="fa fa-trash-o img_delete"></i></a>
                                            <p class="img_delete1">Day <?= $val->order_number ?></p>
                                        <img rel='<?php echo $val->order_number ?>' style='max-width:240px;'src="<?php echo Yii::$app->homeUrl ?>img/game/core_value/<?php echo $val->image_name ?>"></div>

                                <?php } ?>
                            </div>
                            <?php
                        } else {
                            Yii::$app->session->setFlash('category_null', 'No Result Found!');
                            ?>
                            <div class='no_content'>
                                No Image Upload Yet!
                            </div>
                            <?php
                        }
                    }
                    ?>  



                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->registerJsFile(Yii::$app->request->baseurl . "/js/jquery-ui.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<div class="container">
    <div class="modal fade" id="add_image" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Image</h4>
                </div>
                <div class="modal-body">
                    <form action="core-image-upload"  class="custom_dropzone" id="my-awesome-dropzone">
                        <div class="dz-default dz-message"><span><i class="fa fa-cloud-upload fa-4x"></i><br><b>Drag &amp; Drop Files Here</b><br><span>Width 500 X Height 500<br> Only Jpeg or Png files</span></span></div>
                        <input type='hidden' value='' name='category_id' class='category_id' value='<?php echo $_GET['cid']; ?>'>
                    </form>
                    <form id='daily_inspiration_form'>
                        <input type='hidden' value='' name='img' class='img'>
                        <input type='hidden' value='' name='category_id' class='category_id' value='<?php echo $_GET['cid']; ?>'>
                        <select id='select_order' style='display:none;'>
                            <option value="">Select Order</option>
                        <?php
                            for ($i = 1; $i <= 31; $i++) {
                                echo "<option value='$i'>Day $i</option>";
                            }
                        ?>
                        </select> <span style='color:red; display:none'id='order_error'></span> 
                        <input id='form_submit' style='display:none;' type="submit" value="Submit">
                    </form>
                    <div class="processtext"></div>
                   <div class="responsetext"></div>
                   <div class="successtext"></div>
                   <div class="deletetext"></div>
                </div>
                <div class="modal-footer">
                    <button id='popup_submit1' type="button" class="btn btn-success" >Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

            </div>

        </div>

    </div>
</div>