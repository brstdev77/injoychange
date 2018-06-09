<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

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
$curentUrl = Yii::$app->request->hostInfo;
$url = parse_url($curentUrl, PHP_URL_HOST);
$explodedUrl = explode('.', $url);
$comp_check = $explodedUrl[0];
$check_comp = str_replace(' ', '-', $comp_check);
if($_SESSION['challenge_id'] == 6):
    $color='#cc1c1c';
else:
    $color = '#F78408';
endif;

$this->title = 'Login';
$baseurl = Yii::$app->request->baseurl;
//$this->params['breadcrumbs'][] = $this->title;
?>
<?php //$this->registerCssFile($baseurl . '/css/above.css'); ?>

<?php   $this->registerCssFile($baseurl . "/css/above.css", ['position' => yii\web\View::POS_READY, 'depends' => ['yii\bootstrap\BootstrapAsset']]); ?>

<div class="site-login">


    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'emailaddress')->textInput()->label('Email Address'. Html::tag('span', '*',['class'=>'required']))  ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Password'. Html::tag('span', '*',['class'=>'required']))  ?>
            
                        <?= $form->field($model, 'captcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha::className(), ['siteKey' => '6Lf0VTQUAAAAAKl7i-GglYl7sJE__-ecHgWWzxlG']
            )->label('Captcha'. Html::tag('span', '*',['class'=>'required'])) 
            ?>

            
             <?= $form->field($model, 'rememberMe')->checkbox() ?>
            
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary signup_btn', 'name' => 'login-button','style' => 'background:'.$color]) ?>
                    <?//= Html::a('cancel', $baseurl, ['class' => 'btn btn-primary signup_btn']) ?>
                </div>

            <?php ActiveForm::end(); ?>
              <!--div class="g-recaptcha" data-sitekey="6Lf0VTQUAAAAAKl7i-GglYl7sJE__-ecHgWWzxlG"></div-->
        </div>
    </div>
</div>
