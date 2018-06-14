<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\PilotCategoryContent;
/* @var $this yii\web\View */
/* @var $model backend\models\Content */

$this->title = 'Weekly Challenge';
$this->params['breadcrumbs'][] = ['label' => 'Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="content-dailyinspiration">
    <div class='row'>
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Weekly Challenge</h3>
                    <?= Html::a('Add New Video<i class="fa fa-plus"></i>', ['#'], ['class' => 'btn btn-default pull-right', 'data-toggle' => 'modal', 'data-target' => '#add_video']) ?>
                </div>
                <div class="box-body">
                  
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="modal fade" id="add_video" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Video</h4>
                </div>
                <div class="modal-body">
                    
                    <input type='hidden' value='<?php echo Yii::$app->request->get('cid'); ?>' name='category_id'>
                         <?php
                      $form = ActiveForm::begin([
                    'id' => 'login-dash',
                    'options' => ['enctype' => 'multipart/form-data']]);
                    ?> 
                    <?=
                     $form->field($model, 'week')->dropdownList([
                    1 => 'week1',
                    2 => 'week2',
                    3 => 'week3',
                    4 => 'week4',
                        ], ['prompt' => 'Select Week']
                   );
                   ?> 
                     <?=
                    $form->field($model, 'week_title'
                    )->textInput();
                    ?>
                     <?=
                    $form->field($model, 'video_link'
                    )->textInput();
                    ?>
                    <?=
                    $form->field($model, 'category_id'
                    )->textInput(['value'=> Yii::$app->request->get('cid'),'readonly'=>true])->label('');
                    ?>
                </div>
                <div class="modal-footer">
                   <?= Html::submitButton( 'Submit' ,['class' => 'btn btn-success']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>
</div>
