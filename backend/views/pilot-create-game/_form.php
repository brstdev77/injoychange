<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotManageGame */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilot-manage-game-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'challenge_start_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'team')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'winner_posted_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'survey_date')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zodiac_1st_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zodiac_2nd_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'zodiac_3rd_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'injoyglobal_1st_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'injoyglobal_2nd_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'injoyglobal_3rd_email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
