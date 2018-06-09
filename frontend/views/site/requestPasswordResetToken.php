<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\PilotGameChallengeName;

$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$explodedUrl = explode('/', $actual_link);
$challenge_name = $explodedUrl[1];
$challenge = PilotGameChallengeName::find()->where(['challenge_abbr_name' => $challenge_name])->one();
$challenge_id = $challenge->id;
if($challenge_id == 6):
    $color='#e41515';
endif;

$this->title = 'Request password reset';
$baseurl = Yii::$app->request->baseurl;
//$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile($baseurl . "/css/above.css", ['position' => yii\web\View::POS_READY, 'depends' => ['yii\bootstrap\BootstrapAsset']]); ?>
<div class="site-request-password-reset">
   
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'emailaddress')->textInput(['maxlength' => true])->label('Email Address'. Html::tag('span', '*',['class'=>'required'])) ?>
            
 <?= $form->field($model, 'captcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha::className(), ['siteKey' => '6Lf0VTQUAAAAAKl7i-GglYl7sJE__-ecHgWWzxlG']
            )->label('Captcha'. Html::tag('span', '*',['class'=>'required'])) 
            ?>
            
            
            
                <div class="form-group">
                    <?= Html::submitButton('Send', ['class' => 'btn btn-primary signup_btn','style' => 'background:'.$color]) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
