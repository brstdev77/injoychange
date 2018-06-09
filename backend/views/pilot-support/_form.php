<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotSupport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilot-support-form">
    <div class='row'>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">

                    <h3 class="box-title">Pilot Support</h3>
                </div>
                <div class="box-body">
                   <table class="table">
                       <tr>
                           <th>Email</th>                         
                           <th>Subject</th>                         
                           <th>Image</th>                         
                           <th>Description</th>                         
                       </tr>
                       <tr>
                           <td><?php echo $model->email?></td>                         
                           <td><?php echo $model->subject?></td>                         
                           <td><img style="width:100px;"src="http://devinjoyglobal.com/pilot/backend/web/image/no-image.png"></td>   
                           <td><?php echo $model->description;?></td>
                       </tr>
                   </table> 
                </div>
                </div>
                </div>
                </div>
<div class='row'>

        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">

                    <h3 class="box-title">Reply</h3>
                </div>
                 <div class="box-body">
    <?php $form = ActiveForm::begin([ 'options' => ['enctype'=>'multipart/form-data']]); ?>

    <?//= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'image')->fileInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'description')->textArea(['maxlength' => true,'rows'=>6]) ?>
    <?= $form->field($model, 'reply')->textArea(['maxlength' => true,'rows'=>6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' =>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
</div>
</div>
