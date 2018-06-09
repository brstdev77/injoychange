<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotInhouseUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilot-inhouse-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'emailaddress') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'role') ?>

    <?php // echo $form->field($model, 'last_login_id') ?>

    <?php // echo $form->field($model, 'last_access_time') ?>

    <?php // echo $form->field($model, 'firstname') ?>

    <?php // echo $form->field($model, 'lastname') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
