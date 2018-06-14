<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use frontend\models\PilotFrontUser;
use frontend\models\PilotFrontHighfive;

$this->title = 'Dashboard | Above & Beyond';
$baseurl = Yii::$app->request->baseurl;
$game = 1;
$user_id = Yii::$app->user->identity->id;
$comp_id = 1;
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
$tv_btn_text = 'Submit 20 PTS';
if ($count_tv == 1):
  $tv_cls1 = 'check';
  $tv_btn_text = 'Add More 20 PTS';
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
//Leadership Corner
if (empty($leadership_entry_weekly)):
  $first_li_cls = 'enable';
  $sec_li_cls = 'disable';
  $third_li_cls = 'disable';

  $first_lock_img = 'unlock.png';
  $sec_lock_img = 'lock.png';
  $third_lock_img = 'lock.png';

  $first_modal_link = 'leadership-modal?tip=first';
  $sec_modal_link = 'javascript:void(0)';
  $third_modal_link = 'javascript:void(0)';

  $active_modal = $first_modal_link;
  $leadership_btn_cls = 'unchecked';
endif;
if (!empty($leadership_entry_first)):
  if (empty($leadership_entry_currentday)):
    $first_li_cls = 'enable';
    $sec_li_cls = 'enable';
    $third_li_cls = 'disable';
    $first_lock_img = 'unlock.png';
    $sec_lock_img = 'unlock.png';
    $third_lock_img = 'lock.png';
    $first_modal_link = 'leadership-modal?tip=first';
    $sec_modal_link = 'leadership-modal?tip=second';
    $third_modal_link = 'javascript:void(0)';
    $active_modal = $sec_modal_link;
    $leadership_btn_cls = 'unchecked';
  else:
    $first_li_cls = 'enable';
    $sec_li_cls = 'disable';
    $third_li_cls = 'disable';
    $first_lock_img = 'unlock.png';
    $sec_lock_img = 'lock.png';
    $third_lock_img = 'lock.png';
    $first_modal_link = 'leadership-modal?tip=first';
    $sec_modal_link = 'javascript:void(0)';
    $third_modal_link = 'javascript:void(0)';
    $active_modal = $first_modal_link;
    $leadership_btn_cls = 'checked';
  endif;
endif;
if (!empty($leadership_entry_sec)):
  if (empty($leadership_entry_currentday)):
    $sec_li_cls = 'enable';
    $third_li_cls = 'enable';
    $sec_lock_img = 'unlock.png';
    $third_lock_img = 'unlock.png';
    $sec_modal_link = 'leadership-modal?tip=second';
    $third_modal_link = 'leadership-modal?tip=third';
    $active_modal = $third_modal_link;
    $leadership_btn_cls = 'unchecked';
  else:
    $sec_li_cls = 'enable';
    $third_li_cls = 'disable';
    $sec_lock_img = 'unlock.png';
    $sec_modal_link = 'leadership-modal?tip=second';
    $third_modal_link = 'javascript:void(0)';
    $active_modal = $sec_modal_link;
    $leadership_btn_cls = 'checked';
  endif;
endif;
if (!empty($leadership_entry_third)):
  $third_li_cls = 'enable';
  $third_lock_img = 'unlock.png';
  $third_modal_link = 'leadership-modal?tip=third';
  $active_modal = $third_modal_link;
  $leadership_btn_cls = 'checked';
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
?>
<?php $this->registerCssFile($baseurl . '/css/style.css'); ?>
<?php $this->registerCssFile($baseurl . '/css/font-awesome.min.css'); ?>
<div class="site-index">
    <div class="content main-dashboard-banners">
        <!--<div class=container>-->
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <img class=main-banner src="<?= $baseurl; ?>/images/banner_above.png" alt=banner height=392 width=1180 />
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
                                <div href="daily-modal" data-toggle="modal" data-modal-id="daily-inspiration" class="checkbox checkbox1 abs">
                                    <div class=label1><input type=checkbox>
                                        <label class='<?= $daily_btn_cls; ?>'></label>
                                        Submit 10 Pts
                                    </div>                                    
                                </div>
                                <div class="see_more">
                                    <span class="see-al"><a href="<?= $baseurl; ?>/above/daily-inspiration">See All <span><i class="fa fa-angle-right"></i></span></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=s_points>
                        <div class="bg-color height-fix">
                            <h1 class="heading hh new">your Points</h1>
                            <div class=content1>
                                <ul class=top_points>
                                    <li class=abs> <img src="<?= $baseurl; ?>/images/gradd.png" alt=bg height=42 width=66><p class="num_pt num_pt1">0</p><p class=pt>Total Points</p> </li>
                                    <li class=abs><img class=point src="<?= $baseurl; ?>/images/point.png" alt=point height=50 width=51><p class=num_pt_circle1>2</p><p class="pt hide">points</p> </li>
                                    <li class=abs><img src="<?= $baseurl; ?>/images/entry.png" alt=entry height=47 width=68> <p class=pt>0 Entry</p> </li>
                                </ul>
                                <table id=tt>
                                    <thead>
                                        <tr>
                                            <th class=rank_user>RANK </th>
                                            <th class=profile_user>PROF. PIC</th>
                                            <th class=name_user>NAME </th>
                                            <th class=points_user>POINTS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class=odd>
                                            <td class=oned>1</td>
                                            <td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
                                            <td class=tn>Laura Gibbs </td>
                                            <td class=fourd>3180</td>
                                        </tr>
                                        <tr class=even>
                                            <td class=oned>2</td>
                                            <td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
                                            <td class=tn>Kevin Steele</td>
                                            <td class=fourd>2980</td>
                                        </tr>
                                        <tr class=odd>
                                            <td class=oned>3</td>
                                            <td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
                                            <td class=tn>Laura Gibbs </td>
                                            <td class=fourd>3180</td>
                                        </tr>
                                        <tr class=even>
                                            <td class=oned>4</td>
                                            <td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
                                            <td class=tn>Kevin Steele</td>
                                            <td class=fourd>2980</td>
                                        </tr>
                                        <tr class=odd>
                                            <td class=oned>5</td>
                                            <td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
                                            <td class=tn>Laura Gibbs </td>
                                            <td class=fourd>3180</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <span class=see1><a href="javascript:void(0);"> See All <span><i class="fa fa-angle-right"></i></span></a></span>
                                <div class=base_pt>
                                    <h2>Team Core Values Actions</h2>
                                    <h6><span class=prog_last_community>532</span></h6>
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
                            <a class=checkin-calendaricon href="/calendar"><img src="<?= $baseurl; ?>/images/calimg.png" alt="" height=24 width=25></a>Check in with yourself
                            <span class=icon_right><img src="<?= $baseurl; ?>/images/smartphn.png" alt="" height=26 width=16></span>
                        </h1>
                        <div class=value>
                            <div class=value_content>
                                <div class=activecontent>
                                    <h4>CORE VALUES</h4>
                                    <a href="core-values-modal" data-toggle="modal" data-modal-id="core-values">
                                        <img src="<?= $baseurl; ?>/images/core.png" alt="" height=218 width=219>
                                    </a>
                                </div>
                                <div class=submitcore>
                                    <div href="core-values-modal" data-toggle="modal" data-modal-id="core-values" class="checkbox checkbox1 core_value">
                                        <div class=label1><input type=checkbox>
                                            <label class="<?= $core_btn_cls; ?>"></label>
                                            Submit 5 Pts
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=form>
                                <h1>How did you use one of the values today?</h1>

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
                                              $valuesLabel = [
                                                'Responsiveness and commitment to our community' => 'Responsiveness and commitment to our community',
                                                'Accountability and integrity in our operation' => 'Accountability and integrity in our operation',
                                                'Excellence through evidence-based and innovative practices' => 'Excellence through evidence-based and innovative practices',
                                                'Leading by example' => 'Leading by example',
                                              ];
                                              echo $form->field($today_valuesModel, 'label')->dropDownList($valuesLabel, ['prompt' => 'Which value', 'id' => 'new-user-email'])->label(false);
                                              ?>
                                          </div>
                                      </div>
                                      <div class=form-today-values-textfield>
                                          <div class=form-group>
                                              <div class="form-item form-type-textarea form-item-today-values">
                                                  <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                                      <?= $form->field($today_valuesModel, 'comment', ['inputOptions' => ['placeholder' => "Write a sentence or two on how you used this value today", 'class' => 'good-news-textarea form-textarea required form-textarea', 'onkeyup' => 'return max_char_length(this);']])->textarea(['id' => 'core_value_area', 'maxlength' => 100])->label(false); ?>
                                                  </div>
                                              </div>
                                              <div class="text-length"><span></span></div>
                                              <!--<div class=maximum-character></div>-->
                                          </div>
                                      </div>
                                      <?= $form->field($today_valuesModel, 'serial', ['inputOptions' => ['value' => $tv_serial]])->hiddenInput()->label(false); ?>
                                      <div class="new-mail-submit">
                                          <div class="col-sm-9 new_text">
                                              <div class=submit-image>
                                                  <span class="background-checkbox <?= $tv_cls1; ?>"></span>
                                                  <span class="background-checkbox <?= $tv_cls2; ?>"></span>
                                                  <input id=new-mail-submit class="new-user-submit btn btn-primary form-submit" name=op value="<?= $tv_btn_text; ?>" type=submit>
                                              </div>
                                          </div>
                                      </div>
                                      <div class=checkin-seeall><a href="<?= $baseurl; ?>/above/checkin" class="">See All&nbsp;<span><i class="fa fa-angle-right"></i></span></a></div>
                                  </div>
                                  <?php ActiveForm::end(); ?>
                                <?php else: ?>
                                  <div id="today_values">
                                      <div class="Content-values-outer">
                                          <?php foreach ($prev_today_values_currentday as $today_value) : ?>
                                            <div class="Content-values">
                                                <p class="Content-values-first">
                                                    <span class="values-title"><?= $today_value->serial; ?>.)</span>
                                                    <span class="values-value"><?= $today_value->label; ?></span>
                                                </p>
                                                <p class="Content-values-sec"><?= json_decode($today_value->comment); ?></p>
                                            </div>
                                          <?php endforeach; ?>
                                      </div>
                                      <div class="new-mail-submit">
                                          <div class="col-sm-9 new_text">
                                              <div href="check-in-modal" data-toggle="modal" data-modal-id="check-in" class=submit-image>
                                                  <span class="background-checkbox <?= $tv_cls1; ?>"></span>
                                                  <span class="background-checkbox <?= $tv_cls2; ?>"></span>
                                                  <input id=new-mail-submit class="new-user-submit btn btn-primary form-submit" name=op value="<?= $tv_btn_text; ?>" type=submit>
                                              </div>
                                          </div>
                                      </div>
                                      <div class=checkin-seeall><a href="<?= $baseurl; ?>/above/checkin" class="">See All&nbsp;<span><i class="fa fa-angle-right"></i></span></a></div>

                                  </div>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                </div>
                <div class=s_shout_out>
                    <div class=bg-color>
                        <h1 class=heading_w>DIGITAL HIGH 5 - Who do you appreciate today?</h1>
                        <div class=place>
                            <?php
                            $form = ActiveForm::begin([
                                  'id' => 'form-high-five',
                            ]);
                            $userImage = Yii::$app->user->identity->profile_pic;
                            if ($userImage == ''):
                              $userImagePath = '../images/user_icon.png';
                            else:
                              $userImagePath = $baseurl . '/uploads/thumb_' . $userImage;
                            endif;
                            ?>
                            <div>
                                <div class="content pc">
                                    <div class=top-content>
                                        <div class=comment-container>
                                            <div class=profile_high_five_image>
                                                <img src="<?= $userImagePath; ?>" alt=user>
                                            </div>
                                            <div class="benefits-textbox form-control" placeholder="What is one thing you appreciate about one of your teammates today?" id=benefits-recieved contenteditable=true maxlength="100"></div>
                                        </div>
                                        <div class='error_box'></div>
                                        <div id=display></div>
                                        <div id=msgbox></div>
                                        <div class=text-grateful-var></div>
                                    </div>
                                    <?= $form->field($highfiveModel, 'feature_label', ['inputOptions' => ['value' => 'highfiveComment']])->hiddenInput()->label(false); ?>
                                    <?= $form->field($highfiveModel, 'feature_value')->hiddenInput(['id' => 'highfiveComment_value'])->label(false); ?>
                                    <?= $form->field($highfiveModel, 'feature_serial', ['inputOptions' => ['value' => $feature_serial]])->hiddenInput()->label(false); ?>
                                    <?= $form->field($highfiveModel, 'linked_feature_id', ['inputOptions' => ['value' => 0]])->hiddenInput()->label(false); ?>
                                    <div class=submits>
                                        <span class=sb_pt>
                                            <input checked type=checkbox>
                                            <label class="<?= $hf_cls1; ?>"></label>
                                            <input checked type=checkbox>
                                            <label class="<?= $hf_cls2; ?>"></label>
                                            <input checked type=checkbox>
                                            <label class="<?= $hf_cls3; ?>"></label>
                                            <input id=benefits-submit name=op value="SUBMIT 10 PTS" class=form-submit type=submit>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                            <div class=addmore-seeall>
                                <a class="squaredbutton1 right" href="<?= $baseurl; ?>/above/high-five">See All <span><i class="fa fa-angle-right"></i></span></a>
                            </div>
                        </div>
                        <div class=outer-content>
                            <div id="loading-check" class="loading-check-div">
                                <img id="loading-check-img" src="../images/ajax-loader.gif">
                            </div>
                            <div class=last-content>
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
                                    $check_comment_liked = PilotFrontHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->one();
                                    if (empty($check_comment_liked)):
                                      $lk_cls = 'not-liked';
                                      $lk_img = 'hand.png';
                                    else:
                                      $lk_cls = 'liked';
                                      $lk_img = 'hand-colored.png';
                                    endif;
                                    //Total Likes of Each High Five Comment
                                    $total_likes = PilotFrontHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->all();
                                    //Total Comments
                                    $total_comments = PilotFrontHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $hghfv->id])->all();
                                    //Time
                                    $created = $hghfv->created;
                                    $cmnt_time = date('M d, Y h:i A', $created);
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
                                            <div class=comment_count>
                                                <span> (<span class="c_count 3612"><?= count($total_comments); ?></span>)<a href="highfive-usercomment-modal?uid=<?= $user_id; ?>&cid=<?= $hghfv->id; ?>" data-toggle="modal" data-modal-id="highfive-usercomment"> Add Comment</a></span>
                                            </div>
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
                </div>
            </div>
        </div>
        <div class=row>
            <div class="col-xs-12 col-sm-4 gratitude">
                <div class=today_g>
                    <div class=today_gratitude>
                        <h1 class=heading>Leadership Corner</h1>
                    </div>
                    <div class=content>
                        <div class=toolbox-lc-left>
                            <div class=img_b>
                                <img src="<?= $baseurl; ?>/images/leadership.png" alt=leadership height=201 width=192>
                            </div>
                        </div>
                        <div class=toolbox-lc-right>
                            <div class="heading-toolbox">Click for tips:</div>
                            <ul>
                                <li class="<?= $first_li_cls; ?>">
                                    <div class="li-text">
                                        <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $first_modal_link; ?>">
                                            First
                                        </a>
                                    </div>
                                    <div class="li-img">
                                        <img src="../images/<?= $first_lock_img; ?>">
                                    </div>
                                </li>
                                <li class="<?= $sec_li_cls; ?>">
                                    <div class="li-text">
                                        <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $sec_modal_link; ?>">
                                            Second
                                        </a>
                                    </div>
                                    <div class="li-img">
                                        <img src="../images/<?= $sec_lock_img; ?>">
                                    </div>
                                </li>
                                <li class="<?= $third_li_cls; ?>">
                                    <div class="li-text">
                                        <a data-toggle="modal" class="" data-toggle="modal" data-modal-id="leadership-corner" href="<?= $third_modal_link; ?>">
                                            Third
                                        </a>
                                    </div>
                                    <div class="li-img">
                                        <img src="../images/<?= $third_lock_img; ?>">
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class=submitleader>
                            <div href="<?= $active_modal; ?>" data-toggle="modal" data-modal-id="leadership-corner" class="checkbox checkbox1 core_value">
                                <div class=label1><input type=checkbox>
                                    <label class='<?= $leadership_btn_cls; ?>'></label>
                                    Read Now 10 Pts
                                </div>
                            </div>
                            <span class="see-al"><a href="<?= $baseurl; ?>/above/toolbox">See All <span><i class="fa fa-angle-right"></i></span></a></span>
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
                                <img class=video src="<?= $baseurl; ?>/images/week.jpg" alt=week height=344 width=158>
                            </a>
                        </div>
                        <p class=culture>Everyday Leadership</p>
                        <div class=submitweek>
                            <div href="weekly-modal" data-toggle="modal" data-modal-id="weekly-challenge" class="checkbox checkbox1 core_value">
                                <div class=label1><input type=checkbox>
                                    <label class='<?= $weekly_btn_cls; ?>'></label>
                                    Watch Now 40 pts
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xs-12 lightbox">
                <div class=today_g>
                    <div class=today_gratitude>
                        <h1 class=heading>Share A Win</h1>
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
                                        $share_comment = $shareawin->comment;
                                        $max_length = 75;
                                        if (strlen($share_comment) > $max_length) {
                                          $offset = ($max_length - 3) - strlen($share_comment);
                                          $share_comment = substr($share_comment, 0, strrpos($share_comment, ' ', $offset)) . '...';
                                        }
                                        ?>
                                        <div class="item c_slider <?= $cls ?>">
                                            <div class=carousel-caption>
                                                <div class=share-content>
                                                    <p>
                                                        <?= json_decode($share_comment); ?>
                                                    </p>
                                                </div>
                                                <div class=share-user-data>
                                                    <?php
                                                    if ($shareawin->userinfo->profile_pic) {
                                                      $imagePath = Yii::$app->request->baseurl . '/uploads/' . $shareawin->userinfo->profile_pic;
                                                    }
                                                    else {
                                                      $imagePath = Yii::$app->request->baseurl . '/images/user_icon.png';
                                                    }
                                                    ?> 
                                                    <img src="<?= $imagePath; ?>"  class=slider-userimage alt=slider height=63 width=63>
                                                </div>
                                                <div class=share-user-name>
                                                    <?php echo ucfirst($shareawin->userinfo->firstname); ?>
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
                          <div class="no-data"> Be the first one to Share a Win! </div>
                        <?php endif; ?>
                        <div class=align-center>
                            <div class=box3shareawin>
                                <div href="share-a-bin-modal" data-toggle="modal" data-modal-id="share-a-win" class="checkbox checkbox1 box3">
                                    <div class=label1>
                                        <input type=checkbox />
                                        <label class='<?= $shareawin_btn_cls; ?>'></label>
                                        Share a Win 10 Pts                                       
                                    </div>
                                </div>
                            </div>
                            <span class=see-al><a href="<?= $baseurl; ?>/above/share-a-win">See All <span><i class="fa fa-angle-right"></i></span></a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?
$this->registerJsFile($baseurl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<!--All Modals HTML-->
<!-- Daily Inspiration Modal HTML-->
<div class="modal fade" role="dialog" id="daily-inspiration">
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
<!-- Core Values Modal HTML-->
<div class="modal fade" role="dialog" id="core-values">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Core Values</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Check In Modal HTML-->
<div class="modal fade" role="dialog" id="check-in">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Check-In With Yourself</h4>
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
<div class="modal fade" role="dialog" id="highfive-usercomment">
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
<!-- Leadership Modal HTML -->
<div class="modal fade" role="dialog" id="leadership-corner">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Leadership Modal</h4>
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
<div class="modal fade" role="dialog" id="weekly-challenge">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Weekly Challenge</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Share A Win Modal HTML-->
<div class="modal fade" role="dialog" id="share-a-win">
    <div class="modal-dialog">       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Share A Win</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>



