<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\web\Cookie;
use kartik\rating\StarRating;
use yii\web\JsExpression;
use backend\models\PilotCreateGame;
use backend\models\PilotLeadershipCorner;
use backend\models\PilotGettoknowCorner;
use frontend\models\PilotFrontUser;
use frontend\models\PilotFrontCustomerHighfive;
use frontend\models\PilotFrontCustomerSurveyData;
use frontend\models\PilotFrontCustomerQuestion;


$session = Yii::$app->session;
$session->remove('hf_cmnt_img');
//$session->remove('audio');
$this->title = 'Dashboard | Welcome To LandCare';
$baseurl = Yii::$app->request->baseurl;
$game = \frontend\models\PilotFrontUser::getGameID('customer');
$user_id = Yii::$app->user->identity->id;
$comp_id = Yii::$app->user->identity->company_id;
$challenge_id = \frontend\models\PilotFrontUser::getGameID('customer');
$userImage = Yii::$app->user->identity->profile_pic;
$dayset = date('Y-m-d');
if (count($all_highfives) < 20) {
    $limit_highfive = 1;
} else {
    $limit_highfive = 0;
}
if ($userImage == ''):
    $userImagePath = '../images/user_icon.png';
else:
    $userImagePath = $baseurl . '/uploads/thumb_' . $userImage;
endif;
$game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
$week_no = PilotFrontUser::getGameWeek($game_obj);
if (!empty($game_obj->highfive_heading)):
    $highfive_heading = $game_obj->highfive_heading;
endif;
if (!empty($game_obj->highfive_placeholder)):
    $highfive_placeholder = $game_obj->highfive_placeholder;
endif;
if (!empty($game_obj->scorecard_bottom)):
    $scorecard_bottom = $game_obj->scorecard_bottom;
endif;
$hf_cls1 = 'unchecked';
$hf_cls2 = 'unchecked';
$hf_cls3 = 'unchecked';
$feature_serial = 1;
if (!empty($game_obj->highfive_heading)):
    $highfive_heading = $game_obj->highfive_heading;
endif;
if (!empty($game_obj->highfive_placeholder)):
    $highfive_placeholder = $game_obj->highfive_placeholder;
endif;
if (!empty($game_obj->scorecard_bottom)):
    $scorecard_bottom = $game_obj->scorecard_bottom;
endif;
//Daily Inspiration
if (empty($daily_entry)):
    $daily_btn_cls = 'unchecked';
else:
    $daily_btn_cls = 'checked';
endif;
//Shout Out Section
if ($count_hf == 1):
    $hf_cls1 = 'checked';
elseif ($count_hf == 2):
    $hf_cls1 = 'checked';
    $hf_cls2 = 'checked';
elseif ($count_hf >= 3):
    $hf_cls1 = 'checked';
    $hf_cls2 = 'checked';
    $hf_cls3 = 'checked';
endif;
// Todays Lesson
if (empty($audio_entry_weekly)):
    $first_li_cls = 'enable';
    $sec_li_cls = 'disable';
    $third_li_cls = 'disable';

    $first_lock_img = 'unlock-customer.png';
    $sec_lock_img = 'lock-test.png';
    $third_lock_img = 'lock-test.png';

    $first_modal_link = 'audio-modal?tip=first';
    $sec_modal_link = 'javascript:void(0)';
    $third_modal_link = 'javascript:void(0)';

    $active_modal = $first_modal_link;
    $audio_btn_cls = 'uncheck';

    $tip_pos = 'first';
endif;
if (!empty($audio_entry_first)):
    if (empty($audio_entry_currentday)):
        $first_li_cls = 'enable';
        $sec_li_cls = 'enable';
        $third_li_cls = 'disable';
        $first_lock_img = 'unlock-customer.png';
        $sec_lock_img = 'unlock-customer.png';
        $third_lock_img = 'lock-test.png';
        $first_modal_link = 'audio-modal?tip=first';
        $sec_modal_link = 'audio-modal?tip=second';
        $third_modal_link = 'javascript:void(0)';
        $active_modal = $sec_modal_link;
        $audio_btn_cls = 'uncheck';
        $tip_pos = 'second';
    else:
        $first_li_cls = 'enable';
        $sec_li_cls = 'disable';
        $third_li_cls = 'disable';
        $first_lock_img = 'unlock-customer.png';
        $sec_lock_img = 'lock-test.png';
        $third_lock_img = 'lock-test.png';
        $first_modal_link = 'audio-modal?tip=first';
        $sec_modal_link = 'javascript:void(0)';
        $third_modal_link = 'javascript:void(0)';
        $active_modal = $first_modal_link;
        $audio_btn_cls = 'check';
        $tip_pos = 'first';
    endif;
endif;
if (!empty($audio_entry_sec)):
    if (empty($audio_entry_currentday)):
        $sec_li_cls = 'enable';
        $third_li_cls = 'enable';
        $sec_lock_img = 'unlock-customer.png';
        $third_lock_img = 'unlock-customer.png';
        $sec_modal_link = 'audio-modal?tip=second';
        $third_modal_link = 'audio-modal?tip=third';
        $active_modal = $third_modal_link;
        $audio_btn_cls = 'uncheck';
        $tip_pos = 'third';
    else:
        $sec_li_cls = 'enable';
        $third_li_cls = 'disable';
        $sec_lock_img = 'unlock-customer.png';
        $sec_modal_link = 'audio-modal?tip=second';
        $third_modal_link = 'javascript:void(0)';
        $active_modal = $sec_modal_link;
        $audio_btn_cls = 'check';
        $tip_pos = 'second';
    endif;
endif;
if (!empty($audio_entry_third)):
    $third_li_cls = 'enable';
    $third_lock_img = 'unlock-customer.png';
    $third_modal_link = 'audio-modal?tip=third';
    $active_modal = $third_modal_link;
    $audio_btn_cls = 'check';
    $tip_pos = 'third';
endif;
//did you know section 
if (empty($know_entry_weekly)):
    $first_li_cls_know = 'enable';
    $sec_li_cls_know = 'disable';

    $first_lock_img_know = 'unlock-customer.png';
    $sec_lock_img_know = 'lock-test.png';

    $first_modal_link_know = 'know-modal?tip=first';
    $sec_modal_link_know = 'javascript:void(0)';
    $active_modal_know = $first_modal_link_know;
    $tip_pos_know = 'first';
    $know_btn_cls = 'unchecked';
endif;
if (!empty($know_entry_first)):
    if (empty($know_entry_currentday)):
        $first_li_cls_know = 'enable';
        $sec_li_cls_know = 'enable';
        $first_lock_img_know = 'unlock-customer.png';
        $sec_lock_img_know = 'unlock-customer.png';
        $first_modal_link_know = 'know-modal?tip=first';
        $sec_modal_link_know = 'know-modal?tip=second';
        $active_modal_know = $sec_modal_link_know;
        $tip_pos_know = 'second';
        $know_btn_cls = 'unchecked';
    else:
        $first_li_cls_know = 'enable';
        $sec_li_cls_know = 'disable';
        $first_lock_img_know = 'unlock-customer.png';
        $sec_lock_img_know = 'lock-test.png';
        $first_modal_link_know = 'know-modal?tip=first';
        $sec_modal_link_know = 'javascript:void(0)';
        $active_modal_know = $first_modal_link_know;
        $tip_pos_know = 'first';
        $know_btn_cls = 'checked';
    endif;
endif;
if (!empty($know_entry_sec)):
    $sec_li_cls_know = 'enable';
    $sec_lock_img_know = 'unlock-customer.png';
    $sec_modal_link_know = 'know-modal?tip=second';
    $active_modal_know = $sec_modal_link_know;
    $audio_btn_cls_know = 'check';
    $tip_pos_know = 'second';
    $know_btn_cls = 'checked';
endif;
//Voice Matters Section
if (empty($answer_entry_weekly)):
    $weekly_btn_cls = 'unchecked';
else:
    $weekly_btn_cls = 'checked';
endif;
//Tip Image  & Title
//Fetch the // Todays Lesson Content for Tip Position & Current Week 
$week_leadership = 'Week ' . $week_no;
if ($tip_pos == 'first'):
    $tip_no = $week_leadership . '-one';
elseif ($tip_pos == 'second'):
    $tip_no = $week_leadership . '-two';
elseif ($tip_pos == 'third'):
    $tip_no = $week_leadership . '-three';
endif;
//Content of // Todays Lesson section
$leadership_category_id = $game_obj->todays_lesson_content;
$leadership_challenge_obj = backend\models\PilotTodayslessonCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
if (!empty($leadership_challenge_obj)):
    $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/dashboard-image/' . $leadership_challenge_obj->dashboard_image;
    $tip_title = $leadership_challenge_obj->title;
    $designation = $leadership_challenge_obj->designation;
    $description2 = strip_tags($leadership_challenge_obj->description2);
else:
    $leadership_challenge1 = backend\models\PilotTodayslessonCorner::find()->where(['category_id' => $leadership_category_id])->count();
    $weeks = PilotFrontUser::numofweeks($game_obj->challenge_start_date, $game_obj->challenge_end_date);
    $total_weeks_data = $leadership_challenge1;
    $week_no = PilotFrontUser::getweek($week_no * 3, $total_weeks_data);
    $week_leadership = 'Week ' . $week_no;
    if ($week_no < 0):
        $week_leadership = 'Week ' . 1;
    endif;
    if ($tip_pos == 'first'):
        $tip_no = $week_leadership . '-one';
    elseif ($tip_pos == 'second'):
        $tip_no = $week_leadership . '-two';
    elseif ($tip_pos == 'third'):
        $tip_no = $week_leadership . '-three';
    endif;
    $leadership_challenge_obj = backend\models\PilotTodayslessonCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
    $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/dashboard-image/' . $leadership_challenge_obj->dashboard_image;
    $tip_title = $leadership_challenge_obj->title;
    $designation = $leadership_challenge_obj->designation;
    $description2 = strip_tags($leadership_challenge_obj->description2);
endif;
$description2 = substr($description2, 0, 150);
$this->registerCssFile($baseurl . '/css/style.css');
$this->registerCssFile($baseurl . '/css/font-awesome.min.css');
$this->registerCssFile($baseurl . '/css/fileinput_widget.css');
$this->registerCssFile($baseurl . '/css/jQuery.AudioPlayer.css');
$this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/jQuery.AudioPlayer1.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
if ($show_survey == 'true'):
    $this->registerJs("
        $(document).ready(function(){
         $('#survey').modal('show');
          $('.skip_survey').on('click', function () {
          $('#survey').modal('hide');
              $.ajax({
                  type: 'post',
                  url: 'skip-survey',
                  data: {
                      user_id: $user_id,
                      challenge_id: $game_challenge_id,
                  },
                  dataType: 'json',
                  success: function (result) {                    
                  },
              });
          });

        });
");
endif;
?>
<div class="site-index">
    <div class="content main-dashboard-banners">
        <!--<div class=container>-->
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <?php
                    $active_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $comp_id, 'challenge_id' => $challenge_id, 'status' => 1])->one();
                    if (!empty($active_challenge->banner_image)) {
                        ?>
                        <img class=main-banner src="<?= Yii::getAlias('@back_end') . '/img/game/welcome_banner/' . $active_challenge->banner_image; ?>" alt=banner height=392 width=1180 />
                    <?php } else { ?>
                        <img class=main-banner src="http://root.injoychange.com/backend/web/img/game/welcome_banner/1518767329.png" alt=banner height=392 width=1180 />  
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class=row>
            <div class="col-md-4 col-sm-4 outer_left">
                <div class="">
                    <div class=s_daily_ins>
                        <div class="bg-color bg-img">
                            <h1 class="heading hh new"> Daily Inspiration </h1>
                            <div class=submitinspiration>
                                <!--div href="daily-modal" data-toggle="modal" data-modal-id="daily-inspiration" class="checkbox checkbox1 abs"-->
                                <div href="daily-modal"  data-toggle="modal" data-modal-id="daily-inspiration" class="checkbox checkbox1 abs">
                                    <div class=label1><input type=checkbox>
                                        <label class='daily_checkbox <?= $daily_btn_cls; ?>'></label>
                                        <span> Click Here  10 Pts </span>
                                    </div>
                                </div>
                                <div class="see_more">
                                    <span class="see-al"><a href="<?= $baseurl; ?>/customer/daily-inspiration">View All <span><i class="fa fa-angle-right"></i></span></a></span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="today_g">
                    <div class="today_gratitude">
                        <h1 class="heading">Did you know</h1>
                    </div>
                    <div class="content">
                        <div class="tool">
                            <img width="158" height="344" alt="week" src="../images/know_customer.png" class="video">
                        </div>
                        <div class="toolbox-lc-right">
                            <ul>
                                <li class="<?= $first_li_cls_know; ?>">
                                    <div class="li-img">
                                        <img src="../images/<?= $first_lock_img_know; ?>">
                                    </div>
                                    <div class="li-text">
                                        <?php if (!empty($first_modal_link_know) && $first_modal_link_know != 'javascript:void(0)'): ?>
                                            <a data-toggle="modal" data-modal-id="know-challenge" href="<?= $first_modal_link_know; ?>"> First</a>
                                        <?php else: ?>
                                            <span> First</span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <li class="<?= $sec_li_cls_know; ?>">
                                    <div class="li-img">
                                        <img src="../images/<?= $sec_lock_img_know; ?>">
                                    </div>
                                    <div class="li-text">
                                        <?php if (!empty($sec_modal_link_know) && $sec_modal_link_know != 'javascript:void(0)'): ?>
                                            <a data-toggle="modal" data-modal-id="know-challenge" href="<?= $sec_modal_link_know; ?>"> Second</a>
                                        <?php else: ?>
                                            <span> Second</span>
                                        <?php endif; ?>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="submitweek">
                            <!--div class="checkbox checkbox1 core_value" data-modal-id="weekly-challenge" data-toggle="modal" href="weekly-modal"-->
                            <div class="checkbox checkbox1 core_value know_completed" data-toggle="modal" data-modal-id="know-challenge" href="<?= $active_modal_know; ?>">
                                <div class="label1"><input type=checkbox>
                                    <label class='<?= $know_btn_cls; ?>'></label>
                                    <span>Read Now 10 Pts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="today_g">
                    <div class="today_gratitude">
                        <h1 class="heading">Your Voice Matters</h1>
                    </div>
                    <?php // if ($answer_tip_pos == 'first'): ?>
                    <div class="content">
                        <div class="slider">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner inner_s" role="listbox">
                                    <div class="item c_slider">
                                        <div class="carousel-caption">
                                            <div class="share-content">
                                                <p>This Week's Question</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="submitleader">
                            <div class="checkbox checkbox1 core_value question_completed" href="weekly-modal" data-toggle="modal" data-modal-id="weekly-challenge">
                                <div class="label1"><input type=checkbox>
                                    <label class='weekly_checkbox <?= $weekly_btn_cls; ?>'></label>
                                    <span>Click to Submit 20 Pts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 outer_right">
                <div class="s_checkin">
                    <div class="bg-color">
                        <div class="value">
                            <div class="form">
                                <h2 style='text-transform:uppercase;'>Today's Lesson</h2>
                                <div class="checkin_test">
                                    <div class="col-xs-5 col-md-5 injoy_team">
                                        <div class="value_content">
                                            <div class="activecontent">
                                                <p><?= $description2;?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-7 col-md-7">
                                        <div class="col-xs-6 col-md-7 checkin_test_img"><img src="<?= $tip_image_path; ?>"></div>
                                        <div class="col-xs-6 col-md-5 checkin_details">   
                                            <div class="checkin_name"><?= $tip_title; ?></div>
                                            <div class="checkin_designation"><?= $designation; ?></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-md-8 todayslesson_answer" style="padding:0">
                                        <div class="toolbox-lc-right">
                                            <ul>
                                                <li class="<?= $first_li_cls; ?>">
                                                    <div class="li-text">
                                                        <?php if (!empty($first_modal_link) && $first_modal_link != 'javascript:void(0)'): ?>
                                                            <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="audio_challenge" href="<?= $first_modal_link; ?>"> First</a>
                                                        <?php else: ?>
                                                            <span> First</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="li-img">
                                                        <img class="first_audio" src="../images/<?= $first_lock_img; ?>">
                                                    </div>

                                                </li>
                                                <li class="<?= $sec_li_cls; ?>">
                                                    <div class="li-text">
                                                        <?php if (!empty($sec_modal_link) && $sec_modal_link != 'javascript:void(0)'): ?>
                                                            <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="audio_challenge" href="<?= $sec_modal_link; ?>"> Second </a>
                                                        <?php else: ?>
                                                            <span> Second</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="li-img">
                                                        <img class="second_audio" src="../images/<?= $sec_lock_img; ?>">
                                                    </div>
                                                </li>
                                                <li class="<?= $third_li_cls; ?>">
                                                    <div class="li-text">
                                                        <?php if (!empty($third_modal_link) && $third_modal_link != 'javascript:void(0)'): ?>
                                                            <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="audio_challenge" href="<?= $third_modal_link; ?>"> Third</a>
                                                        <?php else: ?>
                                                            <span> Third</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="li-img">
                                                        <img class="third_audio" src="../images/<?= $third_lock_img; ?>">
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div></div>

                            <div id="today_values">
                                <div class="new-mail-submit present_width">
                                    <div class="new_text"  href='<?= $active_modal; ?>' data-toggle="modal" data-modal-id="audio_challenge">
                                        <div class="submit-image">
                                            <span class="background-checkbox <?= $audio_btn_cls; ?>"></span>
                                            <input type="button" value="Learn Now 30 pts" name="op" class="new-user-submit btn btn-primary form-submit dash-btn" id="new-mail-submit">
                                        </div>
                                    </div>
                                </div>
                                <a class="" href="<?= $baseurl; ?>/customer/toolbox">View All&nbsp;<span><i class="fa fa-angle-right"></i></span></a>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="s_shout_out">
                    <div class="bg-color">
                        <h1 class="heading_w"><?= $highfive_heading; ?></h1>
                        <div class=place>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'form-high-five',
                            ]);
                            ?>
                            <div>
                                <div class="content pc">
                                    <div class=top-content>
                                        <div class=comment-container>
                                            <div class=profile_high_five_image>
                                                <img src="<?= $userImagePath; ?>" alt=user>
                                            </div>
                                            <div class="benefits-textbox form-control" placeholder="<?= $highfive_placeholder; ?>" id=benefits-recieved contenteditable=true maxlength="100"></div>
                                        </div>
                                        <div id=display></div>
                                        <div id=msgbox></div>
                                    </div>
                                    <div class='error_box'></div>
                                    <div class=text-grateful-var></div>
                                    <?= $form->field($highfiveModel, 'feature_label', ['inputOptions' => ['value' => 'highfiveComment']])->hiddenInput()->label(false); ?>
                                    <?= $form->field($highfiveModel, 'feature_value')->hiddenInput(['id' => 'highfiveComment_value'])->label(false); ?>
                                    <?= $form->field($highfiveModel, 'feature_serial', ['inputOptions' => ['value' => $feature_serial]])->hiddenInput()->label(false); ?>
                                    <?= $form->field($highfiveModel, 'linked_feature_id', ['inputOptions' => ['value' => 0]])->hiddenInput()->label(false); ?>
                                    <div class=submits>
                                        <span class='sb_pt hf_commentsonly'>
                                            <input checked type=checkbox>
                                            <label class="firstcheckbox <?= $hf_cls1; ?>"></label>
                                            <input checked type=checkbox>
                                            <label class="secondcheckbox <?= $hf_cls2; ?>"></label>
                                            <input checked type=checkbox>
                                            <label class="thirdcheckbox <?= $hf_cls3; ?>"></label>
                                            <input id=benefits-submit name=op value="SUBMIT 10 PTS" class=form-submit type=button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <input type=hidden id="hf_image_status" name="hf_image_status" value="1"/>
                            <input type=hidden id="feature_array" name="feature_array" value="0"/>
                            <input type=hidden id="hf_image_count" value="0"/>
                            <?php ActiveForm::end(); ?>
                            <?php
                            $enable_upload = 'no';
                            if (!empty($image_upload_shout)):
                                $enable_upload = 'yes';
                                ?>
                                <div class="upload_hf_image">
                                    <a class="hf_image_label">
                                        <i class="icon icon-photo fa  fa-image"></i>
                                        <p>Upload Image</p>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" value="<?= $enable_upload; ?>" id="upload_image_feature"/>
                            <div class=addmore-seeall>
                                <a class="squaredbutton1 right" href="<?= $baseurl; ?>/customer/high-five">View All <span><i class="fa fa-angle-right"></i></span></a>
                            </div>
                            <?php if (!empty($image_upload_shout)): ?>
                                <div class="upload_hf_image_widget" style="display:none;">
                                    <?php
                                    // Kartik File Input Widget
                                    echo FileInput::widget([
                                        'name' => 'hf_cmnt_img',
                                        'id' => 'hf_cmnt_img',
                                        'options' => [
                                            'multiple' => true,
                                            'accept' => 'image/*'
                                        ],
                                        'pluginOptions' => [
                                            'uploadUrl' => Url::to(['highfive-image-upload']),
                                            'uploadExtraData' => [
                                                'album_id' => 20,
                                                'cat_id' => 'Nature'
                                            ],
                                            'maxFileCount' => 1,
                                            'validateInitialCount' => true,
                                            'overwriteInitial' => false,
                                            'showCaption' => false,
                                            'showRemove' => false,
                                            'showUpload' => false,
                                            'showBrowse' => false,
                                            'browseOnZoneClick' => true,
                                            'fileActionSettings' => [
                                                'showUpload' => false,
                                                'showZoom' => false,
                                            ],
                                            'maxFileSize' => 10000
                                        ]
                                    ]);
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>                                                        
                        <div class=outer-content>
                            <div id="loading-check" class="loading-check-div">
                                <input type='hidden' name='limit_count' id='limit_count' value='30' />
                                <input type='hidden' name='limit_count1' id='limit_count1' value='<?= $limit_highfive; ?>' />
                                <img id="loading-check-img" src="../images/loaderhighfive.gif">
                            </div>
                            <div class="last-content <?= $content_height; ?>">
                                <div class='highfivecomment'>
                                    <?php if (count($all_highfives) == 0): ?>
                                        <div class="no-data hf"> 
                                            <h3 class="first"> Be the first one to Share an Appreciation! </h3> 
                                        </div> 
                                        <?php
                                    else:
                                        $i = 1;
                                        foreach ($all_highfives as $hghfv):
                                            $hf_cmnt_user = PilotFrontUser::findIdentity($hghfv->user_id);
                                            $hf_cmnt_userName = $hf_cmnt_user->username;
                                            $hf_cmnt_userImage = $hf_cmnt_user->profile_pic;
                                            $hf_cmnt = $hghfv->feature_value;
                                            if ($hf_cmnt_userImage == ''):
                                                $hf_cmnt_userImagePath = '../images/user_icon.png';
                                            else:
                                                $hf_cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $hf_cmnt_userImage;
                                            endif;
                                            if ($i % 2 == 0):
                                                $row_cls = '';
                                            else:
                                                $row_cls = 'w';
                                            endif;
                                            //Comment Liked or Not Liked
                                            $check_comment_liked = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->one();
                                            if (empty($check_comment_liked)):
                                                $lk_cls = 'not-liked';
                                                $lk_img = 'hand.png';
                                            else:
                                                $lk_cls = 'liked';
                                                $lk_img = 'hand-orange.png';
                                            endif;
                                            //Total Likes of Each High Five Comment
                                            $total_likes = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->all();
                                            //Total Comments
                                            $total_comments = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $hghfv->id])->all();
                                            //Time
                                            $created = $hghfv->created;
                                            $cmnt_time = date('M d, Y h:i A', $created);

                                            //Comment Image
                                            $comment_image = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $hghfv->id])->all();
                                            ?>
                                            <div id="hf_<?= $hghfv->id; ?>" class="High-5 <?= $row_cls; ?>">
                                                <div class=user>
                                                    <img alt=user title=Image src="<?= $hf_cmnt_userImagePath; ?>" height=50 width=50>
                                                </div>
                                                <ul class=user-info>
                                                    <li> <h5><?= $hf_cmnt_userName; ?></h5><p class="time1"><?= $cmnt_time; ?></p></li>
                                                    <li> <p><?= json_decode($hf_cmnt); ?></li>
                                                </ul>

                                                <div class=count>
                                                    <div class="high-five <?= $lk_cls; ?>" id="<?= $hghfv->id; ?>" data-uid="<?= Yii::$app->user->identity->id; ?>" data-comment-id="<?= $hghfv->id; ?>" data-feature-label="highfiveLike">
                                                        <input name=high-five value="High Five" type=submit>
                                                    </div>
                                                    <img alt=background src="../images/<?= $lk_img; ?>" height=26 width=78>
                                                    <p class=num><?= count($total_likes); ?></p>
                                                    <?php
                                                    $enable_comment = 'no';
                                                    if (!empty($comment_option)):
                                                        $enable_comment = 'yes';
                                                        ?>
                                                        <div class=comment_count>
                                                            <!--img src="../images/msg.png" alt="message"--><span> (<span class="c_count <?= $hghfv->id; ?>"><?= count($total_comments); ?></span>)<a href="highfive-usercomment-modal?uid=<?= $user_id; ?>&cid=<?= $hghfv->id; ?>" data-toggle="modal" data-modal-id="highfive-usercomment"> Add Comment</a></span>
                                                        </div>
                                                    <?php endif; ?>
                                                    <input type="hidden" value="<?= $enable_comment; ?>" id="add_comment_feature"/>
                                                </div>
                                                <?php if (!empty($comment_image)) : ?>
                                                    <div class="user-attached desk">
                                                        <span class="user-uploads">
                                                            <?php
                                                            foreach ($comment_image as $cimg):
                                                                $cimg_path = $baseurl . '/uploads/high_five/' . $cimg->feature_value;
                                                                $temp_img_path = $baseurl . '/images/defer_load.gif';
                                                                ?>
                                                                <a class="img_modal <?= $cimg->id; ?>" href="highfive-image-zoom-modal?img_id=<?= $cimg->id; ?>" data-toggle="modal" data-modal-id="highfive-image-zoom1"> 
                                                                    <img id="cimg_<?= $cimg->id; ?>" alt="image" title="View Image" src="<?= $cimg_path; ?>" data-src="<?= $cimg_path; ?>" class="img-attach zoom_image hf_img hide">
                                                                </a>
                                                            <?php endforeach; ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <?php
                                            $i++;
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
    </div>
</div>
<?php
$this->registerJsFile($baseurl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/learning_ajax.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<!--All Modals HTML-->
<!-- Daily Inspiration Modal HTML-->
<div class="modal fade" role="dialog" id="daily-inspiration" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Daily Inspiration</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- High Five User Comment Modal HTML-->
<div class="modal fade" role="dialog" id="highfive-usercomment" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <!--<h4 class="modal-title">Add Comment</h4>-->
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- High Five Image Zoom Modal HTML-->
<div class="modal fade" role="dialog" id="highfive-image-zoom1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <!--<h4 class="modal-title">Add Comment</h4>-->
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Weekly Challenge Modal HTML-->
<div class="modal fade" role="dialog" id="audio_challenge" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Today's Lesson</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Today's Question Modal HTML-->
<div class="modal fade" role="dialog" id="weekly-challenge" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Your Voice Matters</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Did you know Modal HTML-->
<div class="modal fade" role="dialog" id="know-challenge" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">DID YOU KNOW</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Survey Modal HTML-->
<?php
if ($show_survey == 'true'):
    $surveyModel = new PilotFrontCustomerSurveyData();
    ?>
    <div class="modal fade" role="dialog" id="survey" data-backdrop="static" data-keyboard="false" style="z-index:9999">
        <div class="modal-dialog">       
            <div class="modal-content">
                <div class="modal-header">
                    <!--                  <button type="button" class="close skip_survey" data-dismiss="modal"></button>-->
                    <h4 class="modal-title">Feedback Survey</h4>
                </div>
                <div class="modal-form">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'form-survey',
                                'options' => ['enctype' => 'multipart/form-data'],
                                'errorSummaryCssClass' => 'alert alert-danger',
                                'enableAjaxValidation' => FALSE,
                                'enableClientValidation' => TRUE,
                    ]);
                    ?>
                    <div class="modal-body survey">
                        <div class="container-fluid" >
                            <h3>Congratulations on an amazing challenge! Please take a minute to share your feedback with us.</h3>
                            <?php
                            $sr = 1;
                            foreach ($survey_questions_arr as $survey_question):
                                ?>
                                <div class="ques"><span><?= $sr . '. '; ?></span><?= $survey_question['text']; ?></div>
                                <?= $form->field($surveyModel, 'survey_question_id[' . $sr . ']', ['inputOptions' => ['value' => $survey_question['id']], 'options' => ['class' => 'hide']])->hiddenInput()->label(false); ?>
                                <?php if ($survey_question['type'] == 'textbox'): ?>
                                    <?= $form->field($surveyModel, 'survey_response[' . $sr . ']')->textarea(['maxlength' => 200])->label(false); ?>
                                    <div class="text-length hidelength<?= $sr; ?>"><span></span></div>
                                    <?php
                                elseif ($survey_question['type'] == 'checkbox'):
                                    $option_arr = [
                                        'agree' => 'Agree',
                                        'somewhat agree' => 'Somewhat Agree',
                                        'neutral' => 'Neutral',
                                        'somewhat disagree' => 'Somewhat Disagree',
                                        'disagree' => 'Disagree'
                                    ];
                                    $radio_name = 'option' . $sr;
                                    ?>
                                    <?= $form->field($surveyModel, 'survey_response[' . $sr . ']')->radioList($option_arr, ['name' => $radio_name])->label(false); ?>
                                <?php endif; ?>
                                <?php
                                $sr++;
                            endforeach;
                            ?>
                            <div class="perm">
                                <div class="perm-text">
                                    Do we have your permission to use your responses in core challenge feedback reports and in promotions for future challenges?
                                </div>
                                <div class="perm-opt">
                                    <?= $form->field($surveyModel, 'permission_use_data')->radioList(['yes' => 'Yes', 'no' => 'No'])->label(false); ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class = "modal-footer">
                        <?= Html::submitButton('Submit here', ['class' => 'save-survey sub-btn btn btn-warning text-capitalize']); ?>
                        <a href="javascript:void(0)" class="sub-btn btn btn-warning text-capitalize skip_survey" style="margin-top:10px;">Skip for now</a>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!--Survey Modal HTML-->
<?= $this->render('prize_modal'); ?>
<?php
$this->registerJsFile($baseurl . "/js/bootstrap-notify.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>