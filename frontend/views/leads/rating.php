<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PilotFrontLeadsRating */
/* @var $form ActiveForm */
?>
<div class="rating">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'challenge_id') ?>
        <?= $form->field($model, 'game_id') ?>
        <?= $form->field($model, 'user_id') ?>
        <?= $form->field($model, 'company_id') ?>
        <?= $form->field($model, 'value') ?>
        <?= $form->field($model, 'week_no') ?>
        <?= $form->field($model, 'dayset') ?>
        <?= $form->field($model, 'created') ?>
        <?= $form->field($model, 'updated') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- rating -->
