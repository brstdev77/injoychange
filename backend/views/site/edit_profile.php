<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use budyaga\cropper\Widget;
use kartik\depdrop\DepDrop;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;
use backend\models\Company;

$this->title = 'Edit Profile';
$this->params['breadcrumbs'][] = ['label' => 'User Listing', 'url' => ['user-listing']];
$this->params['breadcrumbs'][] = $this->title;

$challenge_id = $user_obj_model->challenge_id;
$company = Company::find()->where(['id' => $user_obj_model->company_id])->one();
$name = $company->company_name;
//echo $company->
$this->registerJsFile(Yii::$app->request->baseurl . '/js/custom_profile.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('https://rawgit.com/jseidelin/exif-js/master/exif.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);

$baseurl = Yii::$app->request->baseurl;
$show_notis_reminder = 'false';
$this->registerJs("
    //Crop Image Field
    $('.cropper_buttons .crop_photo').on('click', function (e) {
        $('#prof_up_btn').addClass('disable_btn');
        $('#prof_up_btn').attr('disabled', 'disabled');
    });
   
    ");

$gamename = PilotGameChallengeName::find()->where(['id' => $user_obj_model->challenge_id])->one();
$game = $gamename->challenge_abbr_name;
?>

<div class="row my-profile">
    <div class="col-lg-6">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Edit Profile</h3>
            </div>
            <div class="box-body">
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

                <?= $form->field($user_obj_model, 'status')->radioList(array(10 => 'Active', 0 => 'Inactive'))->label('Status'); ?>
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
                <?php
                if (!empty($user_obj_model->profile_pic)) {
                    $user_obj_model->profile_pic = '/frontend/web/uploads/' . $user_obj_model->profile_pic;
                }
                ?>
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
                <input type="hidden" value="update" name="current_action" id="current_action">
                <div class="form-group desc">
                    <label class="control-label"></label>
                    <div class="description">
                        Note: Maximum upload file size is 10MB.
                    </div>
                </div>     

            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $name; ?></h3>
            </div>
            <div class="box-body">
                <?php if (isset($teamsData)): ?>

                    <?= $form->field($user_obj_model, 'company_id', ['inputOptions' => ['value' => $company_id], 'options' => ['class' => 'hide']])->hiddenInput()->label(false); ?>
                    <?php if (!empty($teamsData)): ?>
                        <?= $form->field($user_obj_model, 'team_id')->dropDownList($teamsData, ['prompt' => 'Please Select', 'id' => 'user-team'])->label('Team' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?php endif; ?>

                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
<div class = "form-group">
    <?= Html::submitButton('Update', ['id' => 'prof_up_btn', 'class' => 'btn btn-success prof_up_btn', 'name' => 'prof-button'])
    ?>
    <?= Html::a('Cancel', 'user-listing', ['class' => 'btn btn-default prof_up_btn prof_cncl_btn'])
    ?>
</div>
<?php ActiveForm::end(); ?>
<style>
    .profile_image{
        padding-left: 0px !important;
    }
    .new_photo_area {
        display: inline-block;
        margin: 0px 20px !important;
    }
    .cropper_buttons.preview_pane {
        float: left;
        width: 150px;
    }
    .thumbnail {
        height: 150px !important; 
        width: 150px !important;
    }
    .cropper_buttons.crp_btn {
        float: left;
        width: 80%;
    }
    .noimg.cropper_buttons.crp_btn {
        display:inline-block;
        width: 100%;
    }
    .progress{
        display: inline-block;
        vertical-align: middle;
        margin-bottom: 0px !important; 
        margin-left: 35px;
    }
    .crp_dl_btn{
        clear: both;
        float: left;
        width: 45px;
    }
    .form-group.field-pilotfrontuser-profile_pic label{
        float:left;
        width:100%;
    }
    .form-group.desc .description {
        float: left;
        width: 100%;
    }
    select#user-team {
        width: 50%;
    }
    #pilotfrontuser-status .radio > label {
    float: left;
    margin: 10px 0 15px;
    width: 50%;
}
</style>
