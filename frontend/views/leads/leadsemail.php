<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PilotFrontLeadsEmail */
/* @var $form ActiveForm */
?>
<div class="maildaily" style="display:none">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'email_id') ?>
        <?= $form->field($model, 'message') ?>
        <?= $form->field($model, 'attachment') ?>
        <?= $form->field($model, 'created') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- leadsemail -->
