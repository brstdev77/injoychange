<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use frontend\models\PilotFrontUser;
use frontend\models\PilotFrontIntentionalHighfive;
use frontend\models\PilotFrontIntentionalSurveyData;
use frontend\models\PilotFrontIntentionalRating;
use backend\models\PilotCreateGame;
use backend\models\PilotLeadershipCorner;
use backend\models\PilotCheckinYourselfData;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\ButtonToggle;
use kartik\file\FileInput;
use yii\web\Cookie;
use kartik\rating\StarRating;
use yii\web\JsExpression;

$content_height = '';
$rating = '';
$rating1 = '';
$button_rating = '';
$place = '';
$see_all = '';
$session = Yii::$app->session;
$session->remove('hf_cmnt_img');
$baseurl = Yii::$app->request->baseurl;
$game = PilotFrontUser::getGameID('intentional');
$user_id = Yii::$app->user->identity->id;
$comp_id = Yii::$app->user->identity->company_id;
$challenge_id = Yii::$app->user->identity->challenge_id;
$userImage = Yii::$app->user->identity->profile_pic;
$dayset = date('Y-m-d');
$ratesaved = PilotFrontIntentionalRating::find()->where(['user_id' => $user_id, 'dayset' => $dayset, 'company_id' => $comp_id])->one();
if ($userImage == ''):
    $userImagePath = '../images/user_icon.png';
else:
    $userImagePath = $baseurl . '/uploads/thumb_' . $userImage;
endif;
//Active Challenge Object (Start Date & End Date) 
$game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
$game_id = $game_obj->id;
$vission_message = PilotCompanyCorevaluesname::find()->where(['company_id' => $game_obj->core_value_content])->andWhere(['!=', 'vission_msg', ''])->one();
$feature_array = explode(',', $game_obj->features);
if (in_array(11, $feature_array)):
    $content_height = 'appreciation';
endif;
if (in_array(7, $feature_array)):
    $content_height = 'image_upload';
endif;
if (in_array(11, $feature_array) && in_array(7, $feature_array)):
    $content_height = 'both';
    $see_all = 'all_button';
    $place = 'place_height';
    $button_text = ButtonToggle::find()->select('Button_text')->where(['game_id' => $game_obj->id])->one();
    if (!empty($button_text)):
        $button_toggle = strtoupper($button_text->Button_text);
    else:
        $button_toggle = '5S IN ACTION';
    endif;
endif;
if (in_array(10, $feature_array)):
    $rating = 'present';
    $button_rating = 'present_width';
endif;
//echo $content_height;die;
$limit = 1;
if (in_array(11, $feature_array)):
    $subQuery = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
    $query = PilotFrontIntentionalHighfive::find()->where(['not in', 'id', $subQuery])->andWhere(['challenge_id' => $game_id])->andWhere(['=', 'feature_label', 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $count = $query->count();
    if ($count > 20) {
        $limit = 0;
    } else {
        $limit = 1;
    }
else:
    $count = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveComment'])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC])->count();
    if ($count > 20) {
        $limit = 0;
    } else {
        $limit = 1;
    }
endif;
$text1 = $game_obj->banner_text_1;
$text2 = strtolower($game_obj->banner_text_2);
$contents = explode(' ', $text1);
$content1 = strtolower(end($contents));
$action1 = $content1 . ' ' . $text2 . ' ';
$title = ucwords($action1);
$this->title = 'Dashboard | ' . $title;
$week_no = PilotFrontUser::getGameWeek($game_obj);
$game_challenge_id = $game_obj->id;
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
//Core Values
if (empty($corevalues_entry)):
    $core_btn_cls = 'unchecked';
else:
    $core_btn_cls = 'checked';
endif;
//Today Values
if (!empty($prev_today_values_currentday)):
    foreach ($prev_today_values_currentday as $today_value):
        $serial = $today_value->serial;
    endforeach;
    $tv_serial = $serial + 1;
else:
    $tv_serial = 1;
endif;
$tv_cls1 = 'uncheck';
$tv_cls2 = 'uncheck';
$tv = '';
$tv_btn_text = 'Submit 20 PTS';
if ($count_tv == 1):
    $tv_cls1 = 'check';
    $tv_btn_text = 'Add More 20 PTS';
    $tv = 'addmore';
    $button = 'addcheckin';
/* if (in_array(10, $feature_array)):
  $rating1 = 'present1';
  endif; */
elseif ($count_tv >= 2):
    $tv_cls1 = 'check';
    $tv_cls2 = 'check';
    $tv_btn_text = 'Add More';
endif;
//High Five Section
if (!empty($prev_highfives_currentday)):
    foreach ($prev_highfives_currentday as $highfive):
        $serial = $highfive->feature_serial;
    endforeach;
    $feature_serial = $serial + 1;
else:
    $feature_serial = 1;
endif;
$hf_cls1 = 'unchecked';
$hf_cls2 = 'unchecked';
$hf_cls3 = 'unchecked';
$hf_cls = 'unchecked';
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
$subQuery1 = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage'])->select('linked_feature_id');
$query1 = PilotFrontIntentionalHighfive::find()->where(['in', 'id', $subQuery1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['week_no' => $week_no])->andWhere(['user_id' => $user_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
$all_highfiveImage1 = $query1->all();
if (empty($all_highfiveImage1)):
    $hf_cls = 'unchecked';
else:
    $hf_cls = 'checked';
endif;
//Leadership Corner
if (empty($leadership_entry_weekly)):
    $first_li_cls = 'enable';
    $sec_li_cls = 'disable';
    $third_li_cls = 'disable';

    $first_lock_img = 'unlock_peak.png';
    $sec_lock_img = 'lock-intentional.png';
    $third_lock_img = 'lock-intentional.png';

    $first_modal_link = 'leadership-modal?tip=first';
    $sec_modal_link = 'javascript:void(0)';
    $third_modal_link = 'javascript:void(0)';

    $active_modal = $first_modal_link;
    $leadership_btn_cls = 'unchecked';

    $tip_pos = 'first';
endif;
if (!empty($leadership_entry_first)):
    if (empty($leadership_entry_currentday)):
        $first_li_cls = 'enable';
        $sec_li_cls = 'enable';
        $third_li_cls = 'disable';
        $first_lock_img = 'unlock_peak.png';
        $sec_lock_img = 'unlock_peak.png';
        $third_lock_img = 'lock-intentional.png';
        $first_modal_link = 'leadership-modal?tip=first';
        $sec_modal_link = 'leadership-modal?tip=second';
        $third_modal_link = 'javascript:void(0)';
        $active_modal = $sec_modal_link;
        $leadership_btn_cls = 'unchecked';
        $tip_pos = 'second';
    else:
        $first_li_cls = 'enable';
        $sec_li_cls = 'disable';
        $third_li_cls = 'disable';
        $first_lock_img = 'unlock_peak.png';
        $sec_lock_img = 'lock-intentional.png';
        $third_lock_img = 'lock-intentional.png';
        $first_modal_link = 'leadership-modal?tip=first';
        $sec_modal_link = 'javascript:void(0)';
        $third_modal_link = 'javascript:void(0)';
        $active_modal = $first_modal_link;
        $leadership_btn_cls = 'checked';
        $tip_pos = 'first';
    endif;
endif;
if (!empty($leadership_entry_sec)):
    if (empty($leadership_entry_currentday)):
        $sec_li_cls = 'enable';
        $third_li_cls = 'enable';
        $sec_lock_img = 'unlock_peak.png';
        $third_lock_img = 'unlock_peak.png';
        $sec_modal_link = 'leadership-modal?tip=second';
        $third_modal_link = 'leadership-modal?tip=third';
        $active_modal = $third_modal_link;
        $leadership_btn_cls = 'unchecked';
        $tip_pos = 'third';
    else:
        $sec_li_cls = 'enable';
        $third_li_cls = 'disable';
        $sec_lock_img = 'unlock_peak.png';
        $sec_modal_link = 'leadership-modal?tip=second';
        $third_modal_link = 'javascript:void(0)';
        $active_modal = $sec_modal_link;
        $leadership_btn_cls = 'checked';
        $tip_pos = 'second';
    endif;
endif;
if (!empty($leadership_entry_third)):
    $third_li_cls = 'enable';
    $third_lock_img = 'unlock_peak.png';
    $third_modal_link = 'leadership-modal?tip=third';
    $active_modal = $third_modal_link;
    $leadership_btn_cls = 'checked';
    $tip_pos = 'third';
endif;

//Tip Image  & Title
//Fetch the Leadership Content for Tip Position & Current Week 
$week_leadership = 'Week ' . $week_no;
if ($tip_pos == 'first'):
    $tip_no = $week_leadership . '-one';
elseif ($tip_pos == 'second'):
    $tip_no = $week_leadership . '-two';
elseif ($tip_pos == 'third'):
    $tip_no = $week_leadership . '-three';
endif;
//Content of Leadeship section
$leadership_category_id = $game_obj->leadership_corner_content;
$leadership_challenge_obj = PilotLeadershipCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
if (!empty($leadership_challenge_obj)):
    $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/dashboard-image/' . $leadership_challenge_obj->dashboard_image;
    $tip_title = $leadership_challenge_obj->title;
    $designation = $leadership_challenge_obj->designation;
    $question = $leadership_challenge_obj->question;
else:
    $leadership_challenge1 = PilotLeadershipCorner::find()->where(['category_id' => $leadership_category_id])->count();
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
    $leadership_challenge_obj = PilotLeadershipCorner::find()->where(['category_id' => $leadership_category_id, 'week' => $tip_no])->one();
    $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/dashboard-image/' . $leadership_challenge_obj->dashboard_image;
    $tip_title = $leadership_challenge_obj->title;
    $designation = $leadership_challenge_obj->designation;
    $question = $leadership_challenge_obj->question;
endif;

//Weekly Challenge
if (empty($weekly_entry)):
    $weekly_btn_cls = 'unchecked';
else:
    $weekly_btn_cls = 'checked';
endif;
//Share A Win
if (empty($shareawin_entry)):
    $shareawin_btn_cls = 'unchecked';
else:
    $shareawin_btn_cls = 'checked';
endif;

//Fitness Data
$today_steps = 0;
$today_cal = 0;
$today_distance = '0.00';
$today_sleep = '00h:00m';
if (!empty($fitness_data)):
    $today_steps = $fitness_data->steps;
    $today_cal = $fitness_data->calories;
    $today_distance = $fitness_data->distance;
    $today_sleep = $fitness_data->sleephr;
endif;
?>
<?php $this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php
$this->registerCssFile($baseurl . '/css/style.css');
$this->registerCssFile($baseurl . '/css/font-awesome.min.css');
$this->registerCssFile($baseurl . '/css/fileinput_widget.css');
$this->registerCssFile($baseurl . '/css/jQuery.AudioPlayer.css');
$this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/jQuery.AudioPlayer.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
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

if ($show_10k_congrats == 'true'):
    $this->registerJs("
        $(document).ready(function(){
         $('#10k-steps-congrats').modal('show');
          $('.read_congrats').on('click', function () {
            $('#10k-steps-congrats').modal('hide');
                $.ajax({
                    type: 'post',
                    url: 'read-congrats',
                    data: {
                        user_id: $user_id,
                        challenge_id: $game_challenge_id,
                        steps: $today_steps,
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
                        <img class=main-banner src="<?= $baseurl; ?>/images/banner_core.png" alt=banner height=392 width=1180 />
                    <?php } ?>
                </div>
            </div>
        </div>
        <!--</div>-->
        <!--<div class=container>-->
        <div class=row>
            <div class="col-md-4 col-sm-4 outer_left">
                <div class="">
                    <div class=s_daily_ins>
                        <div class="bg-color bg-img <?= $rating1; ?>1">
                            <h1 class="heading hh new"> Daily Inspiration </h1>
                            <div class=submitinspiration>
                                <div href="daily-modal" data-toggle="modal" data-modal-id="daily-inspiration" class="checkbox checkbox1 abs">
                                    <div class=label1><input type=checkbox>
                                        <label class='daily_checkbox <?= $daily_btn_cls; ?>'></label>
                                        <span> Click Here 20 Pts </span>
                                    </div>
                                </div>
                                <div class="see_more">
                                    <span class="see-al"><a href="<?= $baseurl; ?>/intentional/daily-inspiration">See All <span><i class="fa fa-angle-right"></i></span></a></span>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class=s_points>
                        <div class="bg-color height-fix">

                            <h1 class="heading hh new">your Points</h1>
                            <div class=content1>

                                <ul class=top_points>
                                    <div style="display: none;" class="loading-check-div" id="loading-scores1">
                                        <img src="../images/ajax-loader.gif" id="loading-check-img" width="auto" height="auto">
                                    </div>
                                    <li class=abs>
                                        <img class="img-circle point" src="<?= $userImagePath; ?>" alt=point height=50 width=51>
                                    </li>
                                    <li class=abs> <img src="<?= $baseurl; ?>/images/gradd.png" alt=bg height=42 width=66><p class="total_pts num_pt num_pt1"></p><p class=pt>Total Points</p> </li>
<!--                                    <li class=abs><img class=point src="<?= $baseurl; ?>/images/point.png" alt=point height=50 width=51><p class="core_values num_pt_circle1"></p><p class="pt hide">points</p> </li>-->

<!--li class=abs><img src="<?= $baseurl; ?>/images/raffle_ticket_sm2.png" alt=entry height=47 width=68> <p class="entry pt"> Entry</p> </li-->
                                </ul>
                                <?php
                                $bandClassMore = '';
                                if ($count_top_list_users > 5):
                                    $bandClassMore = 'tbody_lessHeight';
                                endif;

                                $bandClass = 'bandExclude';
                                if ($game_challenge_id == '159' || $game_challenge_id == '158'):
                                    $bandClass = '';
                                    ?>
                                    <ul class="band_data">
                                        <li class="abs stps_lbl">
                                            <p class="pt">Steps Today</p> 
                                        </li>
                                        <li class="abs stps_count">
                                            <img src="<?= $baseurl; ?>/images/steps.jpg" alt=steps height=42 width=66>
                                            <span class="total_sleep pt"> <?= $today_steps; ?></span> 
                                        </li>
                                        <li class="abs stps_seeall">
                                            <span class="see1 see-all-band">
                                                <a href="total-steps-modal" data-toggle="modal" data-modal-id="total-steps">  
                                                    See All 
                                                    <span>
                                                        <i class="fa fa-angle-right"></i>
                                                    </span>
                                                </a>
                                            </span>
                                        </li>
                                    </ul>
                                <?php endif; ?>


                                <div class="user_points <?php echo $bandClass . ' ' . $bandClassMore; ?>">
                                    <div style="display: none;" class="loading-check-div" id="loading-scores2">
                                        <img src="../images/ajax-loader-blue.gif" id="loading-check-img" width="auto" height="auto">
                                    </div>
                                    <?php
                                    //$count_top_list_users = 6;
                                    $tbody_cls = '';
                                    if ($count_top_list_users <= 5):
                                        $tbody_cls = 'tbody_height';
                                    endif;
                                    ?>
                                    <table id=tt>
                                        <thead>
                                            <tr>
                                                <th class=rank_user>RANK </th>
                                                <th class=profile_user>PROF. PIC</th>
                                                <th class=name_user>NAME </th>
                                                <th class=points_user>POINTS</th>
                                            </tr>
                                        </thead>
                                        <tbody class="<?= $tbody_cls; ?>">
                                        </tbody>
                                    </table>
                                    <?php if ($count_top_list_users > 5): ?>
                                        <span class=see1>
                                            <a href="leaderboard-points-modal" data-toggle="modal" data-modal-id="leaderboard-points"> 
                                                See All 
                                                <span>
                                                    <i class="fa fa-angle-right"></i>
                                                </span>
                                            </a>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class=base_pt>
                                    <h2><?= $scorecard_bottom; ?></h2>
                                    <h6>
                                        <span class="prog_last_community load_actions ajax_img">
                                            <img src="../images/ajax-loader-leads-action.gif" width="auto" height="auto">
                                        </span>
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-8 outer_right">
                <div class=s_checkin>
                    <div class=bg-color>
                        <h1 class="heading new">
                            <a class=checkin-calendaricon href="calendar"><img src="<?= $baseurl; ?>/images/calender.png" alt="" height=24 width=25></a>Check in with yourself
                            <span class="icon_right" href="smartphone" data-toggle="modal" data-modal-id="smartphone"><img src="<?= $baseurl; ?>/images/phone.png" alt="" height=26 width=16></span>
                        </h1>
                        <div class="loading-check-div" id="loading-check1" style="display: none;">
                            <img src="../images/loaderhighfive.gif" id="loading-check-img">
                        </div>
                        <div class=value>
                            <div class=value_content>
                                <div class=activecontent>
                                    <?php
                                    if (!empty($game_obj->core_heading)) {
                                        $word = strtolower($game_obj->core_heading);
                                        $coreHeading = $game_obj->core_heading;
                                    } else {
                                        $coreHeading = "Core Value";
                                    }
                                    ?>
                                    <h4><?= $coreHeading; ?></h4>
                                    <a href="core-values-modal" data-toggle="modal" data-modal-id="core-values">
                                        <?php
                                        if (!empty($game_obj->core_image)) {
                                            $coreImg = Yii::getAlias('@back_end') . "/img/game/core_value/" . $game_obj->core_image;
                                        } else {
                                            $coreImg = Yii::getAlias('@back_end') . "/img/game/core.png";
                                        }
                                        ?>
                                        <img src="<?= $coreImg; ?>" alt="" height=218 width=219>
                                    </a>
                                </div>
                                <div class='submitcore <?= $rating1; ?>1'>
                                    <div href="core-values-modal" data-toggle="modal" data-modal-id="core-values" class="checkbox checkbox1 core_value">
                                        <div class=label1><input type=checkbox>
                                            <label class="core_checkbox <?= $core_btn_cls; ?>"> </label>
                                            <span>Click Here 5 Pts</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=form>
                                <?php
                                if (!empty($game_obj->checkin_yourself_content)) {
                                    $record = PilotCheckinYourselfData::find()->where(['category_id' => $game_obj->checkin_yourself_content])->one();
                                    $question_lable = $record->question_label;
                                    $placeholder_text = $record->placeholder_text;
                                    $selct_option_text = $record->select_option_text;
                                    $valuesLabelarray = PilotCheckinYourselfData::find()->select(['core_value'])->where(['category_id' => $game_obj->checkin_yourself_content])->orderby(['id' => SORT_ASC])->all();
                                    $valuesLabel = array();
                                    foreach ($valuesLabelarray as $obj) {
                                        $valuesLabel[$obj->core_value] = $obj->core_value;
                                    }
                                } else {
                                    $question_lable = 'How did you use one of the values today?';
                                    $placeholder_text = 'Write a sentence or two on how you used this value today';
                                    $selct_option_text = 'Which value';
                                }
                                ?>
                                <h1><?= $question_lable; ?></h1>
                                <?php if (empty($prev_today_values_currentday)): ?>
                                    <?php
                                    $form = ActiveForm::begin([
                                                'id' => 'today_values',
                                    ]);
                                    ?>
                                    <div>
                                        <div class="form-item form-type-select user-form-email">
                                            <div class="form-item form-type-select form-item-which-values">
                                                <?php
                                                echo $form->field($today_valuesModel, 'label')->dropDownList($valuesLabel, ['prompt' => $selct_option_text, 'id' => 'new-user-email'])->label(false);
                                                ?>
                                            </div>
                                        </div>
                                        <div class=form-today-values-textfield>
                                            <div class=form-group>
                                                <div class="form-item form-type-textarea form-item-today-values">
                                                    <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                                        <?= $form->field($today_valuesModel, 'comment', ['inputOptions' => ['placeholder' => "$placeholder_text", 'class' => 'good-news-textarea form-textarea required form-textarea', 'onkeyup' => 'return max_char_length(this,event);']])->textarea(['id' => 'core_value_area', 'maxlength' => 180])->label(false); ?>
                                                    </div>
                                                </div>
                                                <div class="text-length"><span></span></div>
                                                <!--<div class=maximum-character></div>-->
                                            </div>
                                        </div>
                                        <?= $form->field($today_valuesModel, 'serial', ['inputOptions' => ['value' => $tv_serial]])->hiddenInput(['id' => 'serial'])->label(false); ?>
                                        <div class="new-mail-submit <?= $button_rating; ?>">
                                            <div class="col-sm-9 new_text">
                                                <div class=submit-image>
                                                    <span class="background-checkbox <?= $tv_cls1; ?>"></span>
                                                    <span class="background-checkbox <?= $tv_cls2; ?>"></span>
                                                    <input id=new-mail-submit class="new-user-submit btn btn-primary form-submit dash-btn save-checkin" name=op value="<?= $tv_btn_text; ?>" type=button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php ActiveForm::end(); ?>
                                        <div class='checkin-seeall <?= $rating; ?>'>
                                            <?php if (in_array(10, $feature_array)): ?>
                                                <?php if (empty($ratesaved)): ?>
                                                    <?php
                                                    $formrating = ActiveForm::begin([
                                                                'id' => 'rating',
                                                                'action' => 'save-rating',
                                                                'enableAjaxValidation' => true,
                                                    ]);
                                                    ?>
                                                    <?php echo '<label class="control-label">Rate Your Day</label>'; ?>
                                                    <?php
                                                    echo $formrating->field($ratingmodel, 'value')->widget(StarRating::classname(), [
                                                        'pluginOptions' => [
                                                            'stars' => 10,
                                                            'min' => 0,
                                                            'max' => 10,
                                                            'step' => 1,
                                                            'showCaption' => false,
                                                            'showClear' => false,
                                                        ]
                                                    ])->label(false);
                                                    ?>
                                                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'style' => 'display:none']) ?>
                                                    <?php ActiveForm::end(); ?>
                                                <?php else: ?>
                                                    <?php echo '<label class="control-label">Rate Your Day</label>'; ?>
                                                    <?php
                                                    echo StarRating::widget([
                                                        'name' => 'rating_35',
                                                        'value' => $ratesaved->value,
                                                        'pluginOptions' => [
                                                            'stars' => 10,
                                                            'min' => 0,
                                                            'max' => 10,
                                                            'step' => 1,
                                                            'showCaption' => false,
                                                            'showClear' => false,
                                                            'displayOnly' => true,
                                                        ]
                                                    ]);
                                                    ?>
                                                <?php
                                                endif;
                                            endif;
                                            ?>
                                            <a href="<?= $baseurl; ?>/intentional/checkin" class="">See All&nbsp;<span><i class="fa fa-angle-right"></i></span></a></div>
                                    </div>
                                <?php else: ?>
                                    <div id="today_values">
                                        <div class="Content-values-outer">
                                            <?php
                                            $count_check = 0;
                                            foreach ($prev_today_values_currentday as $today_value) : $count_check++;
                                                ?>
                                                <div class="Content-values">
                                                    <p class="Content-values-first">
                                                        <span class="values-title"><?= $count_check; ?>)</span>
                                                        <span class="values-value"><?= $today_value->label; ?></span>
                                                    </p>
                                                    <p class="Content-values-sec"><?= json_decode($today_value->comment); ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="new-mail-submit two <?= $button_rating; ?>1">
                                            <div class="col-sm-9 new_text">
                                                <div href="check-in-modal" data-toggle="modal" data-modal-id="check-in" class=submit-image>
                                                    <span class="background-checkbox  <?= $button; ?> <?= $tv_cls1; ?>"></span>
                                                    <span class="background-checkbox  <?= $button; ?> <?= $tv_cls2; ?>"></span>
                                                    <input id=new-mail-submit class="new-user-submit btn btn-primary form-submit <?= $button; ?>" name=op value="<?= $tv_btn_text; ?>" type=submit>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="checkin-seeall <?= $tv; ?> <?= $rating; ?>1">
                                            <?php if (in_array(10, $feature_array)): ?>
                                                <?php if (empty($ratesaved)): ?>
                                                    <?php
                                                    $formrating = ActiveForm::begin([
                                                                'id' => 'rating',
                                                                'action' => 'save-rating',
                                                                'enableAjaxValidation' => true,
                                                    ]);
                                                    ?>
                                                    <?php echo '<label class="control-label">Rate Your Day</label>'; ?>
                                                    <?php
                                                    echo $formrating->field($ratingmodel, 'value')->widget(StarRating::classname(), [
                                                        'pluginOptions' => [
                                                            'stars' => 10,
                                                            'min' => 0,
                                                            'max' => 10,
                                                            'step' => 1,
                                                            'showCaption' => false,
                                                            'showClear' => false,
                                                        ]
                                                    ])->label(false);
                                                    ?>
                                                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'style' => 'display:none']) ?>
                                                    <?php ActiveForm::end(); ?>
                                                <?php else: ?>
                                                    <?php echo '<label class="control-label">Rate Your Day</label>'; ?>
                                                    <?php
                                                    echo StarRating::widget([
                                                        'name' => 'rating_35',
                                                        'value' => $ratesaved->value,
                                                        'pluginOptions' => [
                                                            'stars' => 10,
                                                            'min' => 0,
                                                            'max' => 10,
                                                            'step' => 1,
                                                            'showCaption' => false,
                                                            'showClear' => false,
                                                            'displayOnly' => true,
                                                        ]
                                                    ]);
                                                    ?>
                                                <?php
                                                endif;
                                            endif;
                                            ?>
                                            <a href="<?= $baseurl; ?>/intentional/checkin" class="">See All&nbsp;<span><i class="fa fa-angle-right"></i></span></a></div>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=s_shout_out>
                    <div class=bg-color>
                        <h1 class=heading_w><?= $highfive_heading; ?></h1>
                        <div class="place <?= $place; ?>">
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
                                    <div class='submits  <?= $see_all; ?>'>
                                        <span class='sb_pt hf_commentsonly'>
                                            <input checked type=checkbox>
                                            <label class="firstcheckbox <?= $hf_cls1; ?>"></label>
                                            <input checked type=checkbox>
                                            <label class="secondcheckbox <?= $hf_cls2; ?>"></label>
                                            <input checked type=checkbox>
                                            <label class="thirdcheckbox <?= $hf_cls3; ?>"></label>
                                            <input id=benefits-submit name=op value="SUBMIT 10 PTS" class=form-submit type=button>
                                        </span>
                                        <span class='sb_pt hf_imageonly' style="display:none">
                                            <input checked type=checkbox>
                                            <label class="<?= $hf_cls; ?>"></label>
                                            <input id=benefits-submit name=op value="SUBMIT 30 PTS" class=form-submit type=button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <input type=hidden id="hf_image_status" name="hf_image_status" value="1"/>
                            <input type=hidden id="hf_image_count" value="0"/>
                            <?php ActiveForm::end(); ?>
                            <?php
                            $enable_upload = 'no';
                            if (!empty($image_upload_shout)):
                                $enable_upload = 'yes';
                                ?>
                                <?php if (in_array(11, $feature_array)): ?>
                                    <div class="upload_hf_image upload_image <?= $see_all; ?>">
                                        <a class="hf_image_label">
                                            <i class="icon icon-photo fa  fa-image"></i>
                                            <p>Upload Image</p>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="upload_hf_image">
                                        <a class="hf_image_label">
                                            <i class="icon icon-photo fa  fa-image"></i>
                                            <p>Upload Image</p>
                                        </a>
                                    </div>

                                <?php endif; ?>
                            <?php endif; ?>
                            <?php
                            if (in_array(11, $feature_array)):
                                ?>
                                <div class="btn-group sht_btn dashboard_button <?= $see_all; ?>">
                                    <input type='hidden' name='imageuploaded' id='imageuploaded' value='0' />
                                    <input type='hidden' name='shoutout' id='shoutout' value='0' />
                                    <button type="button" class="btn btn-primary shoutoutsgiven appreciation1 shout0" data-tabname="icac" rel="0">SHOUT OUTS</button>
                                    <button type="button" class="btn btn-primary shoutoutsgiven highfiveimage shout1" data-tabname="region" style="color:rgb(46, 109, 164);background:#fff" rel="1"><?= $button_toggle; ?></button>
                                </div>
                            <?php endif; ?>
                            <input type="hidden" value="<?= $enable_upload; ?>" id="upload_image_feature"/>
                            <div class="addmore-seeall <?= $see_all; ?>" >
                                <a class="squaredbutton1 right" href="<?= $baseurl; ?>/intentional/high-five">See All <span><i class="fa fa-angle-right"></i></span></a>
                            </div>
                            <?php if (!empty($image_upload_shout)): ?>
                                <?php
                                if (in_array(11, $feature_array)):
                                    ?>
                                    <div class="upload_hf_image_widget upload_image" style="display:none;">
                                    <?php else: ?>
                                        <div class="upload_hf_image_widget" style="display:none;">
                                        <?php endif; ?>
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
                            <?php if (in_array(11, $feature_array)): ?>
                                <div class="outer-content zero-padding">
                                    <div id="loading-check" class="loading-check-div">
                                        <input type='hidden' name='feature_array' id='feature_array' value='11' />
                                        <input type='hidden' name='limit_count' id='limit_count' value='20' />
                                        <input type='hidden' name='limit_count1' id='limit_count1' value='<?= $limit; ?>' />
                                        <img id="loading-check-img" src="../images/loaderhighfive.gif">
                                    </div>
                                    <div class="last-content <?= $content_height; ?> commentonly">
                                        <div class="actionimage" style="display:none">
                                        </div>
                                        <div class="highfivecomment">
                                            <?php if (count($all_highfives) == 0): ?>
                                                <div class="no-data hf"> 
                                                    <h3 class="first"> Be the first one to Shout Out! </h3> 
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
                                                        $hf_cmnt_userImagePath = '../images/user_icon.jpg';
                                                    else:
                                                        $hf_cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $hf_cmnt_userImage;
                                                    endif;
                                                    if ($i % 2 == 0):
                                                        $row_cls = 'w';
                                                    else:
                                                        $row_cls = '';
                                                    endif;
                                                    //Comment Liked or Not Liked
                                                    $check_comment_liked = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->one();
                                                    if (empty($check_comment_liked)):
                                                        $lk_cls = 'not-liked';
                                                        $lk_img = 'hand.png';
                                                    else:
                                                        $lk_cls = 'liked';
                                                        $lk_img = 'aspireh-5.png';
                                                    endif;
                                                    //Total Likes of Each High Five Comment
                                                    $total_likes = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->all();
                                                    //Total Comments
                                                    $total_comments = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $hghfv->id])->all();
                                                    //Time
                                                    $created = $hghfv->created;
                                                    $cmnt_time = date('M d, Y h:i A', $created);

                                                    //Comment Image
                                                    $comment_image = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $hghfv->id])->all();
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
                                                            <img alt=background class="peak_like" src="../images/<?= $lk_img; ?>" height=26 width=78>
                                                            <p class=num><?= count($total_likes); ?></p>
                                                            <?php
                                                            $enable_comment = 'no';
                                                            if (!empty($comment_option)):
                                                                $enable_comment = 'yes';
                                                                ?>
                                                                <div class=comment_count>
                                                                    <img src="../images/msg.png" /><span> (<span class="c_count <?= $hghfv->id; ?>" style="color:#545454"><?= count($total_comments); ?></span>)<a href="highfive-usercomment-modal?uid=<?= $user_id; ?>&cid=<?= $hghfv->id; ?>" data-toggle="modal" data-modal-id="highfive-usercomment" style="color:#545454"> Add Comment</a></span>
                                                                </div>
                                                            <?php endif; ?>
                                                            <input type="hidden" value="<?= $enable_comment; ?>" id="add_comment_feature"/>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $i++;
                                                endforeach;
                                            endif;
                                            ?>

                                        </div>
                                    </div> 
                                </div>
                            <?php else: ?>
                                <div class=outer-content>
                                    <div id="loading-check" class="loading-check-div">
                                        <input type='hidden' name='limit_count' id='limit_count' value='20' />
                                        <input type='hidden' name='limit_count1' id='limit_count1' value='<?= $limit; ?>' />
                                        <img id="loading-check-img" src="../images/loaderhighfive.gif">
                                    </div>
                                    <div class="last-content commentonly <?= $content_height; ?>">
                                        <div class="highfivecomment">
                                            <?php if (count($all_highfives) == 0): ?>
                                                <div class="no-data hf"> 
                                                    <h3 class="first"> Be the first one to Share a Win! </h3> 
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
                                                        $row_cls = 'w';
                                                    else:
                                                        $row_cls = '';
                                                    endif;
                                                    //Comment Liked or Not Liked
                                                    $check_comment_liked = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->one();
                                                    if (empty($check_comment_liked)):
                                                        $lk_cls = 'not-liked';
                                                        $lk_img = 'hand.png';
                                                    else:
                                                        $lk_cls = 'liked';
                                                        $lk_img = 'aspireh-5.png';
                                                    endif;
                                                    //Total Likes of Each High Five Comment
                                                    $total_likes = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->all();
                                                    //Total Comments
                                                    $total_comments = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $hghfv->id])->all();
                                                    //Time
                                                    $created = $hghfv->created;
                                                    $cmnt_time = date('M d, Y h:i A', $created);

                                                    //Comment Image
                                                    $comment_image = PilotFrontIntentionalHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $hghfv->id])->all();
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
                                                            <img alt=background class="peak_like" src="../images/<?= $lk_img; ?>" height=26 width=78>
                                                            <p class=num><?= count($total_likes); ?></p>
                                                            <?php
                                                            $enable_comment = 'no';
                                                            if (!empty($comment_option)):
                                                                $enable_comment = 'yes';
                                                                ?>
                                                                <div class=comment_count>
                                                                    <img src="../images/msg.png" /><span> (<span class="c_count <?= $hghfv->id; ?>"><?= count($total_comments); ?></span>)<a href="highfive-usercomment-modal?uid=<?= $user_id; ?>&cid=<?= $hghfv->id; ?>" data-toggle="modal" data-modal-id="highfive-usercomment"> Add Comment</a></span>
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
                                                                        <a class="img_modal <?= $cimg->id; ?>" href="highfive-image-zoom-modal?img_id=<?= $cimg->id; ?>" data-toggle="modal" data-modal-id="highfive-image-zoom"> 
                                                                            <img id="cimg_<?= $cimg->id; ?>" alt="image" title="View Image" src="<?= $temp_img_path; ?>" data-src="<?= $cimg_path; ?>" class="img-attach zoom_image hf_img hide">
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
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--</div>-->
            <!--<div class=container>-->
            <div class=row>
                <div class="col-xs-12 col-sm-4 gratitude">
                    <div class=today_g>
                        <div class=today_gratitude>
                            <?php if (!empty($game_obj->left_corner_heading)): ?>
                                <h1 class=heading><?= $game_obj->left_corner_heading; ?></h1>
                            <?php else: ?>
                                <h1 class=heading>Leadership Corner</h1>
                            <?php endif; ?>
                        </div>
                        <div class=content>
<!--                            <div class="col-md-12 action-matters" style="color:#666c78;min-height: 44px;max-height: 44px;text-align:center;"><?= $question; ?></div>-->
                            <div class=toolbox-lc-left>
                                <div class=img_b>
                                    <img src="<?= $tip_image_path; ?>" alt=leadership height=201 width=192>
                                </div>
                                <p class="leadership_title" style="color:#070707;"><?= $tip_title; ?></p>
                                <p style="text-align: center;margin: 0;"><?= $designation; ?></p>
                            </div>
                            <div class=toolbox-lc-right>
                                <!--                            <div class="heading-toolbox">Click for tips:</div>-->
                                <?php if ($game_obj->left_corner_type == '1'): ?>
                                    <ul>
                                        <li class="<?= $first_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($first_modal_link) && $first_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $first_modal_link; ?>"> FIRST</a>
                                                <?php else: ?>
                                                    <span> First</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $first_lock_img; ?>">
                                            </div>
                                        </li>
                                        <li class="<?= $sec_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($sec_modal_link) && $sec_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $sec_modal_link; ?>"> SECOND </a>
                                                <?php else: ?>
                                                    <span> Second</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $sec_lock_img; ?>">
                                            </div>
                                        </li>
                                        <li class="<?= $third_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($third_modal_link) && $third_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $third_modal_link; ?>"> THIRD</a>
                                                <?php else: ?>
                                                    <span> Third</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $third_lock_img; ?>">
                                            </div>
                                        </li>
                                    </ul>
                                <?php elseif ($game_obj->left_corner_type == '0'): ?>
                                    <ul>
                                        <li class="<?= $first_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($first_modal_link) && $first_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $first_modal_link; ?>"> 1</a>
                                                <?php else: ?>
                                                    <span> 1</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $first_lock_img; ?>">
                                            </div>
                                        </li>
                                        <li class="<?= $sec_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($sec_modal_link) && $sec_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $sec_modal_link; ?>"> 2 </a>
                                                <?php else: ?>
                                                    <span> 2</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $sec_lock_img; ?>">
                                            </div>
                                        </li>
                                        <li class="<?= $third_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($third_modal_link) && $third_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $third_modal_link; ?>"> 3</a>
                                                <?php else: ?>
                                                    <span> 3</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $third_lock_img; ?>">
                                            </div>
                                        </li>
                                    </ul>
                                <?php else: ?>
                                    <ul>
                                        <li class="<?= $first_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($first_modal_link) && $first_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $first_modal_link; ?>"> FIRST</a>
                                                <?php else: ?>
                                                    <span> First</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $first_lock_img; ?>">
                                            </div>
                                        </li>
                                        <li class="<?= $sec_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($sec_modal_link) && $sec_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $sec_modal_link; ?>"> SECOND </a>
                                                <?php else: ?>
                                                    <span> Second</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $sec_lock_img; ?>">
                                            </div>
                                        </li>
                                        <li class="<?= $third_li_cls; ?>">
                                            <div class="li-text">
                                                <?php if (!empty($third_modal_link) && $third_modal_link != 'javascript:void(0)'): ?>
                                                    <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $third_modal_link; ?>"> THIRD</a>
                                                <?php else: ?>
                                                    <span> Third</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="li-img">
                                                <img src="../images/<?= $third_lock_img; ?>">
                                            </div>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                            <!--<div class="tip_title"><?= $tip_title; ?></div>-->
                            <div class=submitleader>
                                <div href="<?= $active_modal; ?>" data-toggle="modal" data-modal-id="leadership-corner" class="checkbox checkbox1 core_value">
                                    <div class=label1><input type=checkbox>
                                        <label class='leadership_checkbox <?= $leadership_btn_cls; ?>'></label>
                                        <span>Read Now 10 Pts</span>
                                    </div>
                                </div>
                                <span class="see-al"><a href="<?= $baseurl; ?>/intentional/toolbox">See All <span><i class="fa fa-angle-right"></i></span></a></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 toolbox">
                    <div class=today_g>
                        <div class=today_gratitude>
                            <h1 class=heading>Weekly Challenge</h1>
                        </div>
                        <div class=content>
                            <div class=tool>
                                <a href="weekly-modal" data-toggle="modal" data-modal-id="weekly-challenge">
                                    <img class=video src="<?= $weekly_video_image; ?>" alt=week height=344 width=158>
                                </a>
                            </div>
                            <p class=culture style="font-family: lato-bold;"><?= ucwords($weekly_title); ?></p>
                            <div class=submitweek>
                                <div href="weekly-modal" data-toggle="modal" data-modal-id="weekly-challenge" class="checkbox checkbox1 core_value">
                                    <div class=label1><input type=checkbox>
                                        <label class='weekly_checkbox <?= $weekly_btn_cls; ?>'></label>
                                        <span>Watch Now 40 pts</span>
                                    </div>
                                </div>
                                <span class="see-al"><a href="<?= $baseurl; ?>/intentional/weekly">See All <span><i class="fa fa-angle-right"></i></span></a></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 lightbox">
                    <div class=today_g>
                        <div class=today_gratitude>
                            <?php if (!empty($game_obj->right_corner_heading)): ?>
                                <h1 class=heading><?= $game_obj->right_corner_heading; ?></h1>
                            <?php else: ?>
                                <h1 class=heading>Share A Win</h1>
                            <?php endif; ?>
                        </div>
                        <div class=content>
                            <?php if (!empty($shareawins_all)) : ?>
                                <div class=slider>
                                    <div id=myCarousel class="carousel slide" data-ride=carousel>
                                        <div class="carousel-inner inner_s" role=listbox>
                                            <?php
                                            $i = 1;
                                            foreach ($shareawins_all as $shareawin):
                                                if ($i == 1):
                                                    $cls = 'active';
                                                else:
                                                    $cls = '';
                                                endif;
                                                $shareawin->comment = strip_tags($shareawin->comment);
                                                $share_comment = json_decode($shareawin->comment);
                                                // print_r($share_comment);
                                                $max_length = 70;
                                                if (strlen($share_comment) > $max_length) {
                                                    $offset = ($max_length - 3) - strlen($share_comment);
                                                    $bar = preg_match('/\s/', $share_comment);
                                                    if ($bar >= 1):
                                                        $share_comment = substr($share_comment, 0, strrpos($share_comment, ' ', $offset)) . '...';
                                                    else:
                                                        $share_comment = substr($share_comment, 0, 65) . '...';
                                                    endif;
                                                }
                                                ?>
                                                <div class="item c_slider <?= $cls ?>">
                                                    <div class=carousel-caption>
                                                        <div class=share-content>
                                                            <p>
                                                                <?= $share_comment; ?>
                                                            </p>
                                                        </div>
                                                        <div class=share-user-data>
                                                            <?php
                                                            if ($shareawin->userinfo->profile_pic) {
                                                                $imagePath = Yii::$app->request->baseurl . '/uploads/thumb_' . $shareawin->userinfo->profile_pic;
                                                            } else {
                                                                $imagePath = Yii::$app->request->baseurl . '/images/user_icon.png';
                                                            }
                                                            ?> 
                                                            <img src="<?= $imagePath; ?>"  class=slider-userimage alt=slider height=63 width=63>
                                                        </div>
                                                        <div class=share-user-name>
                                                            <?php echo ucwords($shareawin->userinfo->username); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $i++;
                                            endforeach;
                                            ?>
                                        </div>
                                        <a class="left carousel-control" href="#myCarousel" role=button data-slide=prev>
                                            <img src="<?= $baseurl; ?>/images/left.png" alt=left height=31 width=18>
                                        </a>
                                        <a class="right carousel-control" href="#myCarousel" role=button data-slide=next>
                                            <img src="<?= $baseurl; ?>/images/right.png" alt=left height=31 width=18>
                                        </a>
                                    </div> 
                                </div>
                            <?php else: ?>
                                <div class="no-data share_data"> Be the first one to Share a Win! </div>
                            <?php endif; ?>
                            <div class=align-center>
                                <div class=box3shareawin>
                                    <div href="share-a-bin-modal" data-toggle="modal" data-modal-id="share-a-win" class="checkbox checkbox1 box3">
                                        <div class=label1>
                                            <input type=checkbox />
                                            <label class='share_checkbox <?= $shareawin_btn_cls; ?>'></label>
                                            <span> Share A Win 10 Pts  </span>                                  
                                        </div>
                                    </div>
                                </div>
                                <span class=see-al><a href="<?= $baseurl; ?>/intentional/share-a-win">See All <span><i class="fa fa-angle-right"></i></span></a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--</div>-->
        </div>
        <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
    </div>
    <?
    $this->registerJsFile($baseurl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
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
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Core Values Modal HTML--> 
    <div class="modal fade" role="dialog" id="core-values" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <?php if (empty($vission_message->core_heading)): ?>
                        <h4 class="modal-title">Core Values</h4>
                    <?php else: ?>
                        <h4 class="modal-title"><?= $vission_message->core_heading; ?></h4>
                    <?php endif; ?>
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Check In Modal HTML-->
    <div class="modal fade" role="dialog" id="check-in" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Check-In With Yourself</h4>
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
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
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- High Five Image Zoom Modal HTML-->
    <div class="modal fade" role="dialog" id="highfive-image-zoom" data-backdrop="static" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <!--<h4 class="modal-title">Add Comment</h4>-->
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="highfive-image-zoom1" data-backdrop="static" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <!--<h4 class="modal-title">Add Comment</h4>-->
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Leadership Modal HTML -->
    <div class="modal fade" role="dialog" id="leadership-corner" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <?php if (!empty($game_obj->left_corner_heading)): ?>
                        <h4 class="modal-title"><?= $game_obj->left_corner_heading; ?></h4>
                    <?php else: ?>
                        <h4 class="modal-title">Leadership Corner</h4>
                    <?php endif; ?>
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Weekly Challenge Modal HTML-->
    <div class="modal fade" role="dialog" id="weekly-challenge" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Weekly Challenge</h4>
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Share A Win Modal HTML-->
    <div class="modal fade" role="dialog" id="share-a-win" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">       
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <?php if (!empty($game_obj->left_corner_heading)): ?>
                        <h4 class="modal-title"><?= $game_obj->right_corner_heading; ?></h4>
                    <?php else: ?>
                        <h4 class="modal-title">Share A Win</h4>
                    <?php endif; ?>
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Leaderboard Users Modal HTML-->
    <div class="modal fade" role="dialog" id="leaderboard-points" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">       
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Top 20 Leaders</h4>
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Total Steps Modal HTML-->
    <div class="modal fade" role="dialog" id="total-steps" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">       
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Total Steps</h4>
                </div>
                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader-leads.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Survey Modal HTML-->
    <?php
    if ($show_survey == 'true'):
        $surveyModel = new PilotFrontIntentionalSurveyData();
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
                                    'action' => 'submit-survey',
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
                                        <?= $form->field($surveyModel, 'survey_response[' . $sr . ']')->textarea()->label(false); ?>
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
                                    <div class="perm-opt">
                                        <?= $form->field($surveyModel, 'permission_use_data')->radioList(['yes' => 'Yes', 'no' => 'No'])->label(false); ?> 
                                    </div>
                                    <div class="perm-text">
                                        Do we have your permission to use your responses in core challenge feedback reports and in promotions for future challenges?
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class = "modal-footer">
                            <?= Html::submitButton('Submit here', ['class' => 'sub-btn btn btn-warning text-capitalize']); ?>
                            <a href="javascript:void(0)" class="sub-btn btn btn-warning text-capitalize skip_survey" style="margin-top:10px;background:-webkit-linear-gradient(90deg, rgb(0,97,193) 8%, rgb(30,143,255) 42%)">Skip for now</a>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!--Survey Modal HTML-->
    <?php
    if ($show_10k_congrats == 'true'):
        ?>
        <div class="modal fade" role="dialog" id="10k-steps-congrats" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog">       
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close read_congrats" data-dismiss="modal"></button>
                        <h4 class="modal-title">Congratulations!</h4>
                    </div>

                    <div class="modal-body congrats"> 
                        <div class="container-fluid" >
                            Congratulations! You have hit 10 thousand steps today.<br>
                            You are amazing!
                        </div>
                    </div>

                    <div class = "modal-footer">

                    </div>

                </div>
            </div>
        </div>

    <?php endif; ?>
    <div class="modal fade" role="dialog" id="daily_email" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">       
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Send Email</h4>
                </div>

                <div class="modal-form">
                    <div class="modal-ajax-loader">  
                        <img src="../images/ajax-loader.gif"/>
                    </div>
                </div>

                <div class = "modal-footer">
                    <?= Html::submitButton('Send', ['class' => 'sub-btn btn btn-warning text-capitalize']); ?>
                </div>

            </div>
        </div>
    </div>

    <?php
//$this->registerJsFile($baseurl . "/js/custom_packery.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);

    $this->registerJsFile($baseurl . "/js/packery.pkgd.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
    $this->registerJsFile($baseurl . "/js/bootstrap-notify.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
    $this->registerJsFile($baseurl . "/js/ajaxsubmit.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
    ?>
    <?= $this->render('prize_modal'); ?> 