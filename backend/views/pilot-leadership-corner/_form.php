<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Company;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;
use budyaga\cropper\Widget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */
/* @var $form yii\widgets\ActiveForm */
$this->registerJsFile('https://rawgit.com/jseidelin/exif-js/master/exif.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<?php
$modelclient = Company::find()->all();
foreach ($modelclient as $val) {
    
}
?>

<div class="pilot-leadership-corner-form">
    <div class='row'>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">

                    <h3 class="box-title">Leadership Corner</h3>
                </div>
                <div class="box-body">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'leadership_corner_form',
                                'options' => ['enctype' => 'multipart/form-data']]);
                    ?> 
                    <?
                    //= $form->field($model, 'client_listing')->dropDownList(
                    // ArrayHelper::map(Company::find()->all(), 'id', 'company_name'), ['prompt' => 'Select Client']
                    // );
                    ?>
                    <?php
                    if ((!empty($model->popup_image))) {
                        $imgcheck = 1;
                        $class = 'existimage';
                    } else {
                        $imgcheck = 0;
                        $class = '';
                    }
                    if ((!empty($model->file_link))) {
                        $audiocheck = 1;
                        $classaudio = 'existmedia';
                    } else {
                        $audiocheck = 0;
                        $classaudio = '';
                    }
                    if ((!empty($model->video_poster))) {
                        $postercheck = 1;
                    } else {
                        $postercheck = 0;
                    }
                    ?>
                    <?=
                    $form->field($model, 'week')->dropDownList([
                        'Week 1-one' => 'Week 1-one',
                        'Week 1-two' => 'Week 1-two',
                        'Week 1-three' => 'Week 1-three',
                        'Week 2-one' => 'Week 2-one',
                        'Week 2-two' => 'Week 2-two',
                        'Week 2-three' => 'Week 2-three',
                        'Week 3-one' => 'Week 3-one',
                        'Week 3-two' => 'Week 3-two',
                        'Week 3-three' => 'Week 3-three',
                        'Week 4-one' => 'Week 4-one',
                        'Week 4-two' => 'Week 4-two',
                        'Week 4-three' => 'Week 4-three',
                        'Week 5-one' => 'Week 5-one',
                        'Week 5-two' => 'Week 5-two',
                        'Week 5-three' => 'Week 5-three',
                        'Week 6-one' => 'Week 6-one',
                        'Week 6-two' => 'Week 6-two',
                        'Week 6-three' => 'Week 6-three',
                        'Week 7-one' => 'Week 7-one',
                        'Week 7-two' => 'Week 7-two',
                        'Week 7-three' => 'Week 7-three',
                            ], ['prompt' => 'Select Week']
                    )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p id="week_error_edit" style="color:#dd4b39;"></p>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'id' => 'title_edit_leadership'])->label('Title' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'id' => 'designation_edit_leadership'])->label('Designation'); ?>
                    <?= $form->field($model, 'question')->textInput(['maxlength' => true, 'id' => 'question_edit_leadership'])->label('Question' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <? /* =
                      $form->field($model, 'answer_type')->dropDownList([
                      'text' => 'text',
                      'audio' => 'audio',
                      'video' => 'video',
                      ], ['prompt' => 'Select Answer Type', 'id' => 'answer_edit_leadership']
                      )->label('Answer Type'); */
                    ?>




                    <? //= $form->field($model, 'popup_image')->fileInput(['accept' => 'image/*', 'id' => 'browselightboxedit', 'class' => $class, 'maxlength' => true])->label('Popup Image' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <!--div class="form-group addleadership" style="position: relative; min-height:80px;float:left;width:100%;">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='lightboximgupdate' type='hidden' name="lightboximgupdate" value='0'>
                        <img class="removelightboxedit" src1="<?= $model->popup_image; ?>" style="margin-right:20px;width:100px; float:left;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" style="margin-top: 2%;" id="removebuttonlightboxedit">Remove</a>
                        <div class=" fa fa-refresh fa-spin imageloader"></div>
                        <b class="loadingtext">Loading...</b>
                    </div>
                    <? //= $form->field($model, 'dashboard_image')->fileInput(['accept' => 'image/*', 'id' => 'browsedashboardedit', 'class' => $class, 'maxlength' => true])->label('Dashboard Image' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <div class="form-group leadershipdashboard" style="position: relative; min-height:80px;float:left;width:100%;">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='dashboardimgupdate' type='hidden' name="dashboardimgupdate" value='0'>
                        <img class="removedashboardedit" src1="<?= $model->dashboard_image; ?>"  style="margin-right:20px;width:100px; float:left;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" style="margin-top: 2%;" id="removebuttondashboardedit">Remove</a>
                        <div class=" fa fa-refresh fa-spin imageloaderdash"></div>
                        <b class="loadingtextdash">Loading...</b>
                    </div-->
                    <?=
                    $form->field($model, 'description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6, 'id' => 'descrition_edit_leadership'],
                        'preset' => 'basic',
                    ])->label('Description');
                    ;
                    ?>
                    <?php if ($model->isNewRecord): ?>
                        <?=
                        $form->field($model, 'category_id'
                        )->textInput(['readonly' => true, 'value' => Yii::$app->request->get('cid')])->label('');
                        ?>
                    <?php else: ?>
                        <?=
                        $form->field($model, 'category_id'
                        )->textInput(['readonly' => true, 'value' => Yii::$app->request->get('id')])->label('');
                        ?>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Upload Image/Audio</h3>
                </div>
                <div class="box-body">
                    <? //= $form->field($model, 'popup_image')->fileInput(['accept' => 'image/*', 'id' => 'browselightboxedit', 'class' => $class, 'maxlength' => true])->label('Popup Image' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <div class="form-group addleadership" style="position: relative; min-height:80px;float:left;width:100%;">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='lightboximgupdate' type='hidden' name="lightboximgupdate" value='0'>
                        <img class="removelightboxedit" src1="<?= $model->popup_image; ?>" style="margin-right:20px;width:100px; float:left;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" style="margin-top: 2%;" id="removebuttonlightboxedit">Remove</a>
                        <div class=" fa fa-refresh fa-spin imageloader"></div>
                        <b class="loadingtext">Loading...</b>
                    </div>
                    <div class="lightbox_image">
                        <?=
                        $form->field($model, 'popup_image', [
                            'template' => '{label}<div class="col-lg-10 col-md-8 col-sm-8 col-xs-8 popup_image"><div>{input}</div></div>{error}',
                        ])->widget(Widget::className(), [
                            'label' => 'Upload or Drag an image here',
                            'maxSize' => 10485760,
                            'uploadUrl' => Url::toRoute('/pilot-leadership-corner/popupPhoto'),
                            'cropAreaWidth' => 150,
                            'cropAreaHeight' => 150,
                            'width' => 340,
                            'height' => 340,
                        ])->label('Popup Image');
                        ?>
                        <input type="hidden" value="0" name="exif_angle" id="exif_angle">
                        <input type="hidden" value="leadership" name="current_action" id="current_action">
                    </div>
                    <? //= $form->field($model, 'dashboard_image')->fileInput(['accept' => 'image/*', 'id' => 'browsedashboardedit', 'class' => $class, 'maxlength' => true])->label('Dashboard Image' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <div class="form-group leadershipdashboard" style="position: relative; min-height:80px;float:left;width:100%;">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='dashboardimgupdate' type='hidden' name="dashboardimgupdate" value='0'>
                        <img class="removedashboardedit" src1="<?= $model->dashboard_image; ?>"  style="margin-right:20px;width:100px; float:left;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" style="margin-top: 2%;" id="removebuttondashboardedit">Remove</a>
                        <div class=" fa fa-refresh fa-spin imageloaderdash"></div>
                        <b class="loadingtextdash">Loading...</b>
                    </div>
                    <div class="dashboard_image">
                        <?=
                        $form->field($model, 'dashboard_image', [
                            'template' => '{label}<div class="col-lg-10 col-md-8 col-sm-8 col-xs-8 dashboard_image"><div>{input}</div></div>{error}',
                        ])->widget(Widget::className(), [
                            'label' => 'Upload or Drag an image here',
                            'maxSize' => 10485760,
                            'uploadUrl' => Url::toRoute('/pilot-leadership-corner/dashboardPhoto'),
                            'cropAreaWidth' => 150,
                            'cropAreaHeight' => 150,
                            'width' => 340,
                            'height' => 340,
                        ])->label('Dashboard Image');
                        ?>
                        <input type="hidden" value="0" name="exif_angle" id="exif_angle">
                        <input type="hidden" value="leadership" name="current_action" id="current_action">
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <?php
                        if (!is_numeric($model->answer_type)):
                            $model->answer_type = 0;
                        else:
                            if (empty($model->answer_type)):
                                $model->answer_type = 0;
                            endif;
                        endif;
                        // }
                        ?>
                        <?= $form->field($model, 'answer_type')->radioList(array('1' => 'Add Audio', '2' => 'Add Video', '0' => 'No Media')); ?>
                        <div id="myId" style=display:none" class="<?= $classaudio; ?>">
                            <div class="dz-default dz-message"><span><i class="fa fa-cloud-upload fa-4x"></i><br><b>Drag &amp; Drop Files Here</b><br><span>Only mp3 & m4a files</span></span></div>
                        </div> 
                        <div class="successtext1" style="margin-bottom:10px"></div>
                        <input id='audiocheck' type='hidden' name='audio_check' value='<?php echo $audiocheck; ?>'>
                        <input id='dashboardaudioupdate' type='hidden' name="dashboardaudioupdate" value='0'>
                        <div class="form-group audiodashboard" style="position: relative; min-height:80px;float:left;width:100%;display:none">
                            <audio class="removeaudioedit"  style="margin-right:20px;width:50%; float:left;"  controls>
                            </audio> 
                            <a class="btn btn-default" style="margin-top: 0%;" id="removebuttonaudioedit">Remove</a>
                        </div>    
                        <div id="myId1" class="<?= $classaudio; ?>" style="display:none;margin-bottom:20px !important;">
                            <div class="dz-default dz-message"><span><i class="fa fa-cloud-upload fa-4x"></i><br><b>Drag &amp; Drop Files Here</b><br><span>Only mp4 & MOV files</span></span></div>
                        </div>
                        <div id="myId2" class="<?= $classaudio; ?>" style="display:none">
                            <div class="dz-default dz-message"><span><i class="fa fa-cloud-upload fa-4x"></i><br><b>Drag &amp; Drop Files Here</b><br><span>Video Screenshots</span></span></div>
                        </div>
                        <div class="successtext3" style="margin-bottom:10px"></div>
                        <? //= $form->field($model, 'video_poster')->fileInput(['accept' => 'image/*', 'id' => 'browseposteredit', 'class' => $class, 'maxlength' => true])->label('Poster Image' . Html::tag('span', '*', ['class' => 'required'])); ?>
                        <div class="form-group videodashboard" style="position: relative; min-height:80px;float:left;width:100%;display:none">
                            <video width="400" height="240" controls="" controlsList="nodownload" poster="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-video/<?php echo $model->video_poster; ?>" class="removevideoedit" style="margin-right:20px;float:left;">
                            </video>
                            <input id='dashboardposterupdate' type='hidden' name="dashboardposterupdate" value='0'>
                            <!--<input id='postercheck' type='hidden' name='poster_check' value='<?php echo $postercheck; ?>'>-->
                            <a class="btn btn-default" style="margin-top: 4%;" id="removebuttonvideoedit">Remove</a>
                            <!--a class="btn btn-default" style="margin-top: 4%;" id="removebuttonposteredit">Change Video Poster</a-->
                        </div> 
                        <div class="successtext2" style="margin-bottom:10px"></div>
                    </div>
                    <div class="col-md-12 note_message">
                        Note: Video Size must be less than 256 MB and video format will be .mp4 or .mov.
                    </div>
                    <div class="col-md-12 note_message">
                        Note: Audio Size must be less than 50 MB and audio format will be .mp3 or .m4a.
                    </div>
                    <div class="col-md-12 note_message">
                        Note: Video Poster Size must be less than 10 MB and Poster format will be .png or jpg.
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 form-group">
            <?= Html::Button($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'update-disable']) ?>
            <span class="cancel_btn">
                <?= Html::a('Cancel', ['index', 'cid' => Yii::$app->request->get('cid')], ['class' => 'btn btn-default']) ?>
            </span>
        </div>
        <input type="hidden" name="file_name" id="file_name" value="<?= $model->file_link; ?>" />
        <input type="hidden" name="video_poster" id="video_poster" value="<?= $model->video_poster; ?>" />
        <?php ActiveForm::end(); ?>
    </div>
    <style>
        .field-pilotleadershipcorner-popup_image label,.field-pilotleadershipcorner-dashboard_image label{
            float:left;
            width:100%;
        }
        .field-pilotleadershipcorner-dashboard_image .help-block,.field-pilotleadershipcorner-popup_image .help-block{
            float:left;
            width:100%;
        }
        .popup_image,.dashboard_image{
            padding-left: 0px !important;
        }
        .new_photo_area {
            display: inline-block;
            margin: 0px 20px !important;
            float:left;
        }
        .cropper_buttons.preview_pane {
            float: left;
            width: 45% !important;
        }
        .thumbnail {
            height: 150px !important; 
            width: 150px !important;
        }
        .cropper_buttons.crp_btn {
            float: left;
            width: 80%;
            margin-top: 15px !important;
            margin-left:16px !important;
        }
        .noimg.cropper_buttons.crp_btn {
            display:inline-block;
            width: 100%;
            margin-top:15px !important;
        }
        .progress {
            display: inline-block;
            vertical-align: middle;
            margin-bottom: 0px !important;
            margin-left: 22px;
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
        #pilotleadershipcorner-answer_type > label {
            float: left;
            margin: 5px 50px 20px 0;
            /* width: 11%;*/
        }
        #myId,#myId1,#myId2{
            display:none;
            background: #f3f6fb none repeat scroll 0 0;
            border: 2px dashed #9c9d9f;
            border-radius: 3px;
            bottom: 17px;
            min-height: 200px;
            padding: 23px;
        }
        .form-group.field-pilotleadershipcorner-answer_type {
            min-height: 72px;
        }
        .dz-default.dz-message {
            float: left;
            left: 0;
            margin-left: 0;
            margin-right: 0;
            margin-top: 0;
            position: relative;
        }
        .dz-default.dz-message > span {
            float: left;
            margin: 5% 38%;
            text-align: center;
        }
        .dz-default.dz-message b {
            float: left;
            font-size: 17px;
            margin: 10px 0;
            width: 100%;
        }

        .dz-clickable .dz-message,.dz-clickable .dz-message span {
            cursor: pointer;
        }
        .dz-started .dz-default.dz-message {
            display: none;
        }
        .dz-details {
            display: block;
        }
        .dropzone .dz-preview .dz-details .dz-size {
            font-size: 16px;
            margin-bottom: 1em;
        }
        .dropzone .dz-preview .dz-details .dz-filename span, .dropzone .dz-preview .dz-details .dz-size span {
            background-color: rgba(255, 255, 255, 0.4);
            border-radius: 3px;
            padding: 0 0.4em;
        }
        .dropzone .dz-preview .dz-details .dz-filename:not(:hover) {
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .cross {
            left: 36px;
            position: absolute;
            top: 30px;
            z-index: 999;
        }
        .dropzone .dz-preview, .dropzone-previews .dz-preview {
            background: rgba(255, 255, 255, 0.8) none repeat scroll 0 0;
            display: inline-block;
            margin: 17px;
            position: relative;
            vertical-align: top;
            border:none;
            padding:none;
        }
        .dz-filename {
            display: block;
        }
        .dropzone .dz-preview .dz-details .dz-size, .dropzone-previews .dz-preview .dz-details .dz-size {
            bottom: -28px;
            height: 28px;
            left: 22px;
            line-height: 28px;
            position: absolute;
        }
        .existmedia{
            display:none;
        }
        .field-browseposteredit{
            display:none;
        }
        #myId2 .dz-details{
            display:none;
        }
        .note_message{
            color:red;
        }
        @media screen and (max-width: 1300px){
            #pilotleadershipcorner-answer_type > label {
                float: left;
                margin: 5px 68px 20px 0;
                /* width: 11%; */
            }
            .popup_image,.dashboard_image{
                padding-left: 0px !important;
                width:100% !important;
            }
            .cropper_widget .preview_pane .thumbnail{
                margin-bottom:0;
            }
            .crp_dl_btn{
                clear: both;
                float: left;
                width: 45px;
                margin-top: 19px !important;
            }
        }
    </style>