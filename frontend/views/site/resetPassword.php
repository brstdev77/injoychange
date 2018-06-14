<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Reset password';
//$this->params['breadcrumbs'][] = $this->title;

$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . "/css/above.css", ['position' => yii\web\View::POS_READY, 'depends' => ['yii\bootstrap\BootstrapAsset']]); ?>
<div class="site-reset-password">
<!--    <h1><?//= Html::encode($this->title) ?></h1>-->

<!--    <p>Please choose your new password:</p>-->

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['autofocus' => true])->label('New Password') ?>
            
                <?= $form->field($model, 'confirm_password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary signup_btn']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
