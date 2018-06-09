<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotManageGameSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilot-manage-game-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'challenge_start_date') ?>

    <?= $form->field($model, 'team') ?>

    <?= $form->field($model, 'winner_posted_date') ?>

    <?php // echo $form->field($model, 'survey_date') ?>

    <?php // echo $form->field($model, 'zodiac_1st_email') ?>

    <?php // echo $form->field($model, 'zodiac_2nd_email') ?>

    <?php // echo $form->field($model, 'zodiac_3rd_email') ?>

    <?php // echo $form->field($model, 'injoyglobal_1st_email') ?>

    <?php // echo $form->field($model, 'injoyglobal_2nd_email') ?>

    <?php // echo $form->field($model, 'injoyglobal_3rd_email') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
