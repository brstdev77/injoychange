<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $baseUrl = Yii::$app->homeUrl; ?>
<div class="loginhead"><img style="width: 147px;" src="<?php echo $baseUrl ?>/image/Titlelogo.png"></div>
<div class="homelogintext"><div>YOUR GAMIFIED CULTURE </div><div>REINFORCEMENT PLATFORM</div></div>
<div class="site-login">
    <div class="row">
        <div class="col-lg-3  col-lg-offset-4">
            <img src="<?php echo $baseUrl ?>/image/Titlelogo.png">
            <p class='wlcm'>Welcome to Injoy Global</p>
            <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
                <div style="color:#b42b18;">
                    <?php echo Yii::$app->session->getFlash('custom_message'); ?>
                </div>
            <?php } ?>
            <p class='title'>LOGIN</p>
            <p class='log'>Please enter your Username and Password to Login</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?=
            $form->field($model, 'emailaddress', [
                'inputTemplate' => '<div class="input-group"><i class="fa fa-user"></i>{input}</div>'
            ])->textInput(['autofocus' => true, 'placeholder' => 'Emailaddress'])->label('')
            ?>

            <?=
            $form->field($model, 'password', [
                'inputTemplate' => '<div class="input-group"><i class="fa fa-lock"></i>{input}</div>'
            ])->passwordInput(['placeholder' => 'Password'])->label('')
            ?>

            <?= $form->field($model, 'rememberMe')->checkbox(['class' => 'remember']) ?>

            <?=
            $form->field($model, 'captcha')->widget(
                    \himiklab\yii2\recaptcha\ReCaptcha::className(), ['siteKey' => '6Lf0VTQUAAAAAKl7i-GglYl7sJE__-ecHgWWzxlG']
            )
            ?>
            <div class="form-group">
                <?= Html::submitButton('Sign In', ['class' => 'login', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <!--div class="g-recaptcha" data-sitekey="6Lf0VTQUAAAAAKl7i-GglYl7sJE__-ecHgWWzxlG"></div-->
        </div>
    </div>
    <div class="footer">
        <div class="footer_left">
            <span>&copy; Injoyglobal.All Time Reserved</span>
        </div>
        <div class="footer_right">
            <ul>
                <li><a href="#">Terms & Condition</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
</div>
