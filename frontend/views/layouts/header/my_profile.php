<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use budyaga\cropper\Widget;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;
$i='';
$challenge_id = Yii::$app->user->identity->challenge_id;
$comp_id = Yii::$app->user->identity->company_id;
if ($challenge_id == 6):
    $color = '#cc1c1c';
endif;
if ($challenge_id == 8):
    $class = 'customer_button';
endif;
if ($challenge_id == 9):
    $class = 'peak_button';
endif;
$game_obj = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $comp_id, 'status' => [0,1]])->one();
$game_start_date = date('Y-m-d', $game_obj->challenge_start_date);
$current_date = date('Y-m-d', time());
if($current_date < $game_start_date):
    $i= 'hidedashboard';
endif;
$this->registerJsFile(Yii::$app->request->baseurl . '/js/custom_profile.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('https://rawgit.com/jseidelin/exif-js/master/exif.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->title = 'My Profile';
$baseurl = Yii::$app->request->baseurl;
$show_notis_reminder = 'false';
$this->registerJs("
    //Crop Image Field
    $('.cropper_buttons .crop_photo').on('click', function (e) {
        $('#prof_up_btn').addClass('disable_btn');
        $('#prof_up_btn').attr('disabled', 'disabled');
    });
   
    ");

$gamename = PilotGameChallengeName::find()->where(['id' => Yii::$app->user->identity->challenge_id])->one();
$game = $gamename->challenge_abbr_name;
?>
<div class="site-index">
    <div class="my-profile-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard <?= $i;?>  <?= $class;?>" href="<?= $baseurl; ?>/<?= $game; ?>/dashboard" style="background:<?= $color; ?>">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 title">My Profile</div>
        </div>
        <div class="row my-profile">
            <div class="col-lg-12">
                <?php
                $form = ActiveForm::begin([
                            'options' => ['enctype' => 'multipart/form-data'],
                            'id' => 'form-profile',
                                // 'enableAjaxValidation' => true,
                ]);
                ?>
                <?= $form->field($user_obj_model, 'firstname')->textInput(['maxlength' => true])->label('First Name' . Html::tag('span', '*', ['class' => 'required'])) ?>

                <?= $form->field($user_obj_model, 'lastname')->textInput(['maxlength' => true])->label('Last Name' . Html::tag('span', '*', ['class' => 'required'])) ?>

                <?= $form->field($user_obj_model, 'emailaddress')->textInput(['maxlength' => true])->label('Email Address' . Html::tag('span', '*', ['class' => 'required'])) ?>

                <?= $form->field($user_obj_model, 'password_hash')->passwordInput(['maxlength' => true])->label('Password') ?>

                <?= $form->field($user_obj_model, 'confirm_password')->passwordInput(['maxlength' => true])->label('Confirm Password') ?>

                <? //= $form->field($user_obj_model, 'height')->textInput(['maxlength' => true])->label('Height (Inches)' . Html::tag('span', '*', ['class' => 'required'])) ?>

                <? //= $form->field($user_obj_model, 'weight')->textInput(['maxlength' => true])->label('Weight (lbs)' . Html::tag('span', '*', ['class' => 'required'])) ?>

                <!-- check if time zone is selected for challenge-->
                <?php
                $company = backend\models\Company::find()->where(['company_name' => $_SESSION['company_name']])->one();
                $challenge = backend\models\PilotGameChallengeName::find()->where(['challenge_abbr_name' => $game])->one();
                $current_challenge = backend\models\PilotCreateGame::find()->where(['challenge_company_id' => $company->id])->andWhere(['challenge_id' => $challenge->id])->one();
                $checkedfeatures = explode(',', $current_challenge->features);
                $country_timezone = false;
                foreach ($checkedfeatures as $value) {
                    if ($value == 9) {
                        $country_timezone = TRUE;
                    }
                }
                if ($country_timezone == TRUE) {
                    ?> 
                    <?=
                    $form->field($user_obj_model, 'country')->dropdownList(
                            backend\models\Company::timezoneCountries(), ['prompt' => 'Please Select']
                    )->label('Country' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <input type="hidden" id = "timezone_val" value= '<?= $user_obj_model->timezone ?>'>
                    <div class='ajax-timezone'>
                        <img src='http://gifimage.net/wp-content/uploads/2017/06/gif-upload-14.gif'>
                        <?=
                        $form->field($user_obj_model, 'timezone')->dropdownList(
                                []
                        )->label('Timezone' . Html::tag('span', '*', ['class' => 'required']));
                        ?>
                    </div>
                <?php } ?>

                <?=
                $form->field($user_obj_model, 'profile_pic', [
                    'template' => '{label}<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 profile_image">{beginWrapper}{input}{endWrapper}</div>{error}',
                ])->widget(Widget::className(), [
                    'label' => 'Upload or Drag an image here',
                    'maxSize' => 10485760,
                    'uploadUrl' => Url::toRoute('/site/uploadPhoto'),
                    'cropAreaWidth' => 150,
                    'cropAreaHeight' => 150,
                    'width' => 2400,
                    'height' => 2400,
                ])->label('Profile Picture');
                ?>

                <input type="hidden" value="" name="base64_pic" id="base64_pic">
                <input type="hidden" value="0" name="exif_angle" id="exif_angle">
                <div class="form-group desc">
                    <label class="control-label"></label>
                    <div class="description">
                        Note: Maximum upload file size is 10MB.
                    </div>
                </div>     

                <div class = "form-group">
                    <?= Html::submitButton('Update', ['id' => 'prof_up_btn', 'class' => 'btn btn-warning dashboard prof_up_btn '.$class, 'name' => 'prof-button', 'style' => 'background:' . $color])
                    ?>
                    <?= Html::a('Cancel', '/' . $game . '/dashboard', ['class' => 'btn btn-warning dashboard prof_up_btn prof_cncl_btn '.$class, 'style' => 'background:' . $color])
                    ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a>
</div>
<style>
    .hidedashboard{
        display:none; 
    }
</style>
<style>
    .customer_button{
        background-image: -moz-linear-gradient( 10deg, rgb(228,93,20) 0%, rgb(243,112,41) 25%, rgb(243,112,41) 70%, rgb(223,95,26) 100%) !important;
        background-image: -webkit-linear-gradient( 10deg, rgb(228,93,20) 0%, rgb(243,112,41) 25%, rgb(243,112,41) 70%, rgb(223,95,26) 100%) !important;
        background-image: -ms-linear-gradient( 10deg, rgb(228,93,20) 0%, rgb(243,112,41) 25%, rgb(243,112,41) 70%, rgb(223,95,26) 100%) !important;
        box-shadow: 0px 9px 23.75px 1.25px rgba(0, 0, 0, 0.5);
        border-radius: 3px;
    }
    .peak_button{
        border-radius: 3px;
        background-image: -moz-linear-gradient( 90deg, rgb(24,68,115) 0%, rgb(53,114,179) 50%, rgb(25,81,142) 100%) !important;
        background-image: -webkit-linear-gradient( 90deg, rgb(24,68,115) 0%, rgb(53,114,179) 50%, rgb(25,81,142) 100%) !important;
        background-image: -ms-linear-gradient( 90deg, rgb(24,68,115) 0%, rgb(53,114,179) 50%, rgb(25,81,142) 100%) !important;
        box-shadow: 0px 4px 16.49px 0.51px rgba(0, 0, 0, 0.7);
    }
</style>