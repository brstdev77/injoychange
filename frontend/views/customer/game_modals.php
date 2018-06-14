<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use frontend\models\PilotFrontUser;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\PilotCheckinYourselfData;
use backend\models\PilotTodayslessonQuestion;

$baseurl = Yii::$app->request->baseurl;
$session = yii::$app->session;
?>
<!-- Daily Inspirations Modal-->
<?php if (isset($daily_model)): ?>

    <div class="modal-body">
        <div class = "container-fluid" style = "text-align: center;">

            <div class="modal-image">
                <img src="<?= $daily_image_path ?>">
            </div>
            <div class="maildaily" style="display:none">
                <div class="sendmailerform">
                    <div class="padding-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 mail_remove_icon_box">
                        <span style="cursor: pointer;font-size: 24px;" class="fa fa-times" id="mail_remove_box"></span>
                    </div>
                    <?php
                    $form = ActiveForm::begin([
                                'action' => 'daily-email',
                                'id' => 'form-email',
                                'options' => ['enctype' => 'multipart/form-data'],
                                'errorSummaryCssClass' => 'alert alert-danger',
                                'enableClientValidation' => FALSE,
                    ]);
                    ?>

                    <?= $form->field($daily_email, 'email_id')->label(false); ?>
                    <?= $form->field($daily_email, 'message', ['inputOptions' => ['placeholder' => "Type your message"]])->textarea(['id' => 'core_value_area', 'maxlength' => 180])->label(false); ?>

                    <div class="form-group">
                        <?= Html::Button('SEND', ['class' => 'sub-btn btn btn-warning dashboard text-capitalize save_email', 'id' => 'mail-submit']) ?>
                    </div> 
                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
    <div class = "modal-footer">
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-daily',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'errorSummaryCssClass' => 'alert alert-danger',
                    'enableAjaxValidation' => FALSE,
                    'enableClientValidation' => TRUE,
        ]);
        ?>
        <?php
        echo $form->field($daily_model, 'user_id', ['inputOptions' => ['value' => Yii::$app->user->identity->id]])->hiddenInput()->label(false);
        echo $form->field($daily_model, 'dayset', ['inputOptions' => ['value' => date('Y-m-d')]])->hiddenInput()->label(false);
        ?>
        <?php if (empty($daily_entry)): ?>
            <?= Html::Button('Submit 10 pts', ['class' => 'sub-btn btn btn-warning text-capitalize save-daily', 'style' => 'float:left;']); ?>
        <?php endif; ?> 
        <button class="btn btn-warning text-capitalize share" style="float:right">SHARE</button>
    </div>    
    <?php ActiveForm::end(); ?>
<?php endif; ?>
<!--Daily Inspirations End-->  

<!-- Know Modal-->
<?php if (isset($know_model)): ?>
    <?php
    $form = ActiveForm::begin([
                'id' => 'form-know',
                'options' => ['enctype' => 'multipart/form-data'],
                'errorSummaryCssClass' => 'alert alert-danger',
                'enableAjaxValidation' => FALSE,
                'enableClientValidation' => TRUE,
    ]);
    ?>
    <div class="modal-body">
        <div class = "container-fluid" style = "text-align: center;">
            <?= $form->field($know_model, 'tip_pos', ['inputOptions' => ['value' => $tip_pos]])->hiddenInput()->label(false);
            ?>
            <div class="modal-image">
                <div class="tip_des"><?= $didyouknow_tip_obj->description; ?></div>
            </div>
        </div>
    </div>
    <div class = "modal-footer">
        <?php if (empty($know_entry)): ?>
            <?= Html::Button('Submit 10 pts', ['class' => 'sub-btn btn btn-warning text-capitalize know-submit']); ?>
        <?php endif; ?>
    </div>
    <?php ActiveForm::end(); ?>

<?php endif; ?>
<!-- know Modal End -->


<!-- Check In Modal  Modal-->
<?php if (isset($audio_model)): ?>
    <div class="modal-body">
        <!--Calendar Modal Content START-->

        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-today_values',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'errorSummaryCssClass' => 'alert alert-danger',
                    'enableAjaxValidation' => FALSE,
                    'enableClientValidation' => TRUE,
        ]);
        ?>
        <?= $form->field($audio_model, 'tip_pos', ['inputOptions' => ['value' => $tip_pos]])->hiddenInput()->label(false); ?>
        <div class="container-fluid" style="text-align: center;">
            <div class="weekly_audio">
                <?php
                $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/lightbox-image/' . $leadership_tip_obj->popup_image;
                $lesson = PilotTodayslessonQuestion::find()->where(['corner_id' => $leadership_tip_obj->id])->all();
                ?>
                <div class="col-xs-12 col-md-12 audio_image2" style="padding:0;text-align:center;">
                    <img src="<?= $tip_image_path; ?>">
                </div>
<!--                <div class="col-xs-12 col-md-8 user_popup">
                    <div class="user_name">Name: <span style="font-weight:500"><?= $leadership_tip_obj->title; ?></span></div>
                    <div class="job-title">Job Title: <span style="font-weight:500"><?= $leadership_tip_obj->designation; ?></span></div> 
                </div>-->
                <!--div class="dummy-text">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                </div-->
                <p class="col-xs-12 col-md-12 hobby_description" style="text-align:left;padding:0"><?= strip_tags($leadership_tip_obj->description1); ?></p>
                <?php
                if ($leadership_tip_obj->answer_type == '2'):
                    $video_poster = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $leadership_tip_obj->video_poster;
                    $file_link = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $leadership_tip_obj->file_link;
                    ?>
                    <video width="500" height="240" controls="" controlsList="nodownload" poster="<?= $video_poster; ?>" src="<?= $file_link; ?>">
                    </video> 
                    <?php
                endif;
                if ($leadership_tip_obj->answer_type == '1'):
                    $file_link = Yii::getAlias('@back_end') . '/img/leadership-corner-audio/' . $leadership_tip_obj->file_link;
                    ?>
                    <?php if ($tip_pos == 'first'): ?>
                        <input type="hidden" name="audio_loaded" id="audio_loaded" value="1" />
                        <?php
                    endif;
                    if ($tip_pos == 'second'):
                        ?>
                        <input type="hidden" name="audio_loaded" id="audio_loaded" value="2" />
                        <?php
                    endif;
                    if ($tip_pos == 'third'):
                        ?>
                        <input type="hidden" name="audio_loaded" id="audio_loaded" value="3" />
                    <?php endif; ?>
                    <input type="hidden" id="audio_link" value="<?= $file_link; ?>" name="audio_link" />
                    <div class="form-item form-type-select user-form-email1">
                        <div id="audioWrap"></div> 
                    </div>
                    <?php
                endif;
                ?>
                <?php if (empty($audio_entry)): ?>
                    <div class="col-md-12 col-xs-12 Question_answered" style="padding:0">
                        <?= $leadership_tip_obj->question; ?><span> *</span>
                    </div>
                    <div class=form-today-values-textfield style="padding:0">
                        <div class=form-group>
                            <div class="form-item form-type-textarea form-item-today-values">
                                <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                    <?= $form->field($audio_model, 'comment', ['inputOptions' => ['placeholder' => "$leadership_tip_obj->question_placeholder", 'class' => 'good-news-textarea form-textarea required form-textarea', 'onkeyup' => 'return max_char_length(this,event);']])->textarea(['id' => 'core_value_area', 'maxlength' => 180])->label(false); ?>
                                </div>
                            </div>
                            <div class="text-length"><span></span></div>
                            <!--<div class=maximum-character></div>-->
                        </div>
                    </div>
                    <?php
                    if (!empty($lesson)):
                        foreach ($lesson as $id):
                            $c[$id->id] = strip_tags($id->answer);
                            $secondary_question = $id->secondary_question;
                            if ($id->Correct == '1'):
                                $answer_id = $id->id;
                            endif;
                        endforeach;
                        ?>
                        <div class="col-md-12 col-xs-12 Question_answered1" style="padding:0;">
                            <?= $secondary_question ?><span> *</span>
                        </div>
                        <div class="col-md-12" style="padding:0;text-align:left;float:left;">
                            <?=
                            $form->field($audio_model, 'correct_id')->radioList(ArrayHelper::map(PilotTodayslessonQuestion::find()->where(['corner_id' => $leadership_tip_obj->id])->all(), 'id', function ($element) {
                                        $value =  strip_tags($element['answer']);
                                        return $value;
                                    }))->label(false);
                            ?>
                            <img src="" class="help-block1" style="display:none;" />
                            <input type="hidden" value="<?= $answer_id ?>" name="correct_answer" id="correct_answer" />
                            <input type="hidden" value="0" name="check_answer" id="check_answer" />
                            <input type="hidden" value="1" name="multiple" id="multiple" />
                        </div>
                    <?php else: ?>
                        <input type="hidden" value="0" name="multiple" id="multiple" />
                    <?php endif; ?>
                <?php else: ?>
                    <div class="col-md-12 col-xs-12 Question_answered" style="padding:0">
                        <?= $leadership_tip_obj->question; ?><span> *</span>
                    </div>
                    <div class=form-today-values-textfield style="padding:0">
                        <div class=form-group>
                            <div class="form-item form-type-textarea form-item-today-values">
                                <div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
                                    <?php $audio_entry->comment = json_decode($audio_entry->comment); ?>
                                    <?= $form->field($audio_entry, 'comment', ['inputOptions' => ['placeholder' => "$leadership_tip_obj->question_placeholder", 'class' => 'good-news-textarea form-textarea required form-textarea', 'onkeyup' => 'return max_char_length(this,event);']])->textarea(['id' => 'core_value_area', 'maxlength' => 180])->label(false); ?>
                                </div>
                            </div>
                            <div class="text-length"><span></span></div>
                            <!--<div class=maximum-character></div>-->
                        </div>
                    </div>
                    <?php
                    //  echo $audio_model->correct_id;die;
                    if (!empty($lesson)):
                        foreach ($lesson as $id):
                            $c[$id->id] = strip_tags($id->answer);
                            $secondary_question = $id->secondary_question;
                            if ($id->Correct == '1'):
                                $answer_id = $id->id;
                            endif;
                        endforeach;
                        ?>
                        <div class="col-md-12 col-xs-12 Question_answered1" style="padding:0;">
                            <?= $secondary_question ?><span> *</span>
                        </div>
                        <div class="col-md-12" style="padding:0;text-align:left">
                            <?=
                            $form->field($audio_entry, 'correct_id')->radioList(ArrayHelper::map(PilotTodayslessonQuestion::find()->where(['corner_id' => $leadership_tip_obj->id])->all(), 'id', function ($element) {
                                        $value =  strip_tags($element['answer']);
                                        return $value;
                                    }), ['disabled' => true])->label(false);
                            ?>
                            <img src="" class="help-block1" style="display:none;"/>
                            <input type="hidden" value="<?= $answer_id ?>" name="correct_answer" id="correct_answer" />
                            <input type="hidden" value="1" name="check_answer" id="check_answer" />
                            <input type="hidden" value="1" name="multiple" id="multiple" />
                            <input type="hidden" value="1" id="correct_answer1" name="correct_answer1" />
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (empty($audio_entry)): ?>
                    <div class="modal-footer" style="padding-bottom:0">
                        <button class="sub-btn btn btn-warning text-capitalize audio_comment" type="button">Submit 30 pts</button>      
                    </div>
                <?php else: ?>
                    <div class="modal-footer" style="padding-bottom:0">
                        <button class="sub-btn btn btn-warning text-capitalize audio_comment" type="button">Update</button>      
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        <!--Calendar Modal Content END-->
        <!--Dashboard Modal Content-->

    </div>
<?php endif; ?>
<!--Check In Modal End-->  

<!-- High Five Image Zoom Modal-->
<?php if (isset($zoomImage)): ?>
    <?php
    $zoomImage_path = $baseurl . '/uploads/high_five/' . $zoomImage->feature_value;
    ?>
    <div class="modal-body">
        <div class = "container-fluid" style = "text-align: center;">
            <div class="modal-image">
                <img src="<?= $zoomImage_path ?>">
            </div>
        </div>
    </div>
    <div class = "modal-footer">
    </div>    
<?php endif; ?>
<!--High Five Image Zoom Modal End--> 

<!-- High Five User Comment Modal -->
<?php if (isset($usercomment_model)): ?>
    <?php
    $hf_cmnt_user = PilotFrontUser::findIdentity($commentValue->user_id);
    $hf_cmnt_userName = $hf_cmnt_user->username;
    $hf_cmnt_userImage = $hf_cmnt_user->profile_pic;
    $hf_cmnt = $commentValue->feature_value;
    if ($hf_cmnt_userImage == ''):
        $hf_cmnt_userImagePath = '../images/user_icon.png';
    else:
        $hf_cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $hf_cmnt_userImage;
    endif;
    if (!empty($userComments)):
        foreach ($userComments as $comment):
            $serial = $comment->feature_serial;
        endforeach;
        $cmnt_serial = $serial + 1;
    else:
        $cmnt_serial = 1;
    endif;
    $created = $commentValue->created;
    $ht_cmnt_time = date('M d, Y h:i A', $created);
    ?>
    <div id="ucmnt-loading-check" class="loading-check-div" style="display: none;">
        <img id="loading-check-img" src="../images/ajax-loader.gif">
    </div>
    <div class="modal-body hf_cmnt_popup">
        <div class = "container-fluid">
            <div class="outer-content">
                <div class="last-content">
                    <div id="hf_<?= $commentValue->id; ?>" class="High-5">
                        <div class=user>
                            <img alt=user title=Image src="<?= $hf_cmnt_userImagePath; ?>" height=50 width=50>
                        </div>
                        <ul class=user-info>
                            <li> <h5><?= $hf_cmnt_userName; ?></h5><p class="time1"><?= $ht_cmnt_time; ?></p></li>
                            <li> <p><?= json_decode($hf_cmnt); ?></li>
                            <?php if (!empty($commentImages)) : ?>
                                <li>
                                    <?php
                                    foreach ($commentImages as $cimg):
                                        $cimg_path = $baseurl . '/uploads/high_five/' . $cimg->feature_value;
                                        ?>
                                        <img alt="image" title="View Image" src="<?= $cimg_path; ?>" class="img-attach">
                                    <?php endforeach; ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="user-comment-listing">  
                        <?php
                        $i = 1;
                        if (!empty($userComments)):
                            foreach ($userComments as $comment):
                                $cmnt_user = PilotFrontUser::findIdentity($comment->user_id);
                                $cmnt_userName = $cmnt_user->username;
                                $cmnt_userImage = $cmnt_user->profile_pic;
                                $cmnt = json_decode($comment->feature_value);
                                if ($cmnt_userImage == ''):
                                    $cmnt_userImagePath = '../images/user_icon.png';
                                else:
                                    $cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $cmnt_userImage;
                                endif;
                                if ($i % 2 == 0):
                                    $row_cls = '';
                                else:
                                    $row_cls = 'w';
                                endif;
                                $created = $comment->created;
                                $cmnt_time = date('M d, Y h:i A', $created);
                                ?>
                                <div class="user-record High-5 <?= $row_cls; ?>">
                                    <div class="user">
                                        <img alt="user" src="<?= $cmnt_userImagePath; ?>">
                                    </div>
                                    <div class="right_info">
                                        <ul class="user-info">
                                            <li> <h5><?= $cmnt_userName; ?></h5><p class="time1"><?= $cmnt_time; ?></p></li>
                                            <li> <p><?= $cmnt; ?></p> </li>
                                        </ul>
                                    </div> 
                                </div>
                                <?php
                                $i++;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <div class="new-comment High-5">
                        <div class="user">
                            <?php
                            $userImage = Yii::$app->user->identity->profile_pic;
                            if ($userImage == ''):
                                $userImagePath = '../images/user_icon.png';
                            else:
                                $userImagePath = $baseurl . '/uploads/thumb_' . $userImage;
                            endif;
                            ?>
                            <img alt="user" src="<?= $userImagePath; ?>">
                        </div>

                        <div class="comment_form">
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'form-highfive-user-comment',
                                        'options' => ['enctype' => 'multipart/form-data'],
                                        'errorSummaryCssClass' => 'alert alert-danger',
                                        'enableAjaxValidation' => FALSE,
                                        'enableClientValidation' => TRUE,
                            ]);
                            echo $form->field($usercomment_model, 'feature_serial', ['inputOptions' => ['value' => $cmnt_serial, 'class' => 'feature_serial']])->hiddenInput()->label(false);
                            echo $form->field($usercomment_model, 'feature_value', ['template' => '{input}{error}', 'inputOptions' => ['placeholder' => 'Write a Comment', 'onkeyup' => 'return max_char_length(this,event);', 'class' => 'form-control feature_val']])->textarea(['maxlength' => 100]);
                            echo $form->field($usercomment_model, 'linked_feature_id', ['inputOptions' => ['value' => $commentValue->id, 'class' => 'linked_feature_id']])->hiddenInput()->label(false);
                            ?>
                            <div class="text-length"><span></span></div>
                            <div class='error_box'></div>
                            <div class="hf_cmnt_btn"><?= Html::Button('Comment', ['class' => 'sub-btn btn btn-warning text-capitalize ']); ?></div>
                            <?php ActiveForm::end(); ?>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
    <div class = "modal-footer">

    </div>    

<?php endif; ?>
<!-- High Five User Comment End -->  
<!-- playing audio -->
<?php if (isset($audio)): ?>
    <div class="modal-body" style="top:0;padding:5px;">
        <div class = "container-fluid" style = "text-align: center;">
            <div class="modal-image" style="margin:5px auto">
                <input type="hidden" name="audio_link" id="audio_link" value="<?= $audio; ?>"
                       <div class="form-item form-type-select user-form-email1" style="width:100%;float:left;">
                    <div id="audioWrap"></div> 
                </div>
            </div>
        </div>  
    <?php endif; ?>
    <!-- end -->
 <?php if (isset($weekly_model)): ?>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-weekly',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'errorSummaryCssClass' => 'alert alert-danger',
                    'enableAjaxValidation' => FALSE,
                    'enableClientValidation' => TRUE,
        ]);
        ?>
        <div class = "modal-footer">
            <h3 class="share_heading"><?= $weekly_question;?></span> </h3>
            <?php
            if (!empty($weekly_model->comment)) {
                $weekly_model->comment = json_decode($weekly_model->comment);
            }
            ?>
            <?= $form->field($weekly_model, 'comment', ['template' => '{input}{error}', 'inputOptions' => ['onkeyup' => 'return max_char_length(this,event);', 'class' => 'form-control']])->textarea(['maxlength' => 1000, 'id' => 'video_comment']);
            ?>
            <div class="text-length"><span></span></div>
                    <?php if (empty($weekly_entry)): ?>
                        <?= Html::Button('Submit 20 Points', ['class' => 'sub-btn btn btn-warning text-capitalize weekly-save', 'id' => 'weekly-submit']); ?>
                    <?php else: ?>
                        <?= Html::Button('Submit', ['class' => 'sub-btn btn btn-warning text-capitalize weekly-save', 'id' => 'weekly-submit']); ?>
                    <?php endif; ?>
        </div>
        <?php ActiveForm::end(); ?> 
    <?php endif; ?>

    <script>
        var j = 0;
        var i = 0;
        $(document).ready(function () {
            if ($('#correct_answer1').val() == 1) {
                $('#pilotfrontcustomerweeklychallenge-correct_id input[type="radio"]').attr('disabled', 'disabled');
            }
            var audio = $('input[name="audio_loaded"]').val();
            if (audio == 1) {
                var player = $.AudioPlayer;
                player.init({
                    container: '#audioWrap'
                    , source: $('#audio_link').val()
                    , imagePath: '../image'
                    , debuggers: false
                    , allowSeek: true
                });
                $('body').on('click', '.play', function (event) {
                    event.preventDefault();
                    //        player.updateSource({
                    //            source: '../audio/My_Heart.mp3'
                    //        });
                    if (i == 0) {
                        player.play();
                        i = 1;
                    } else {
                        player.pause();
                        i = 0;
                    }
                });
            }
            if (audio == 2) {
                var player1 = $.AudioPlayer1;
                player1.init({
                    container: '#audioWrap'
                    , source: $('#audio_link').val()
                    , imagePath: '../image'
                    , debuggers: false
                    , allowSeek: true
                });
                $('body').on('click', '.play', function (event) {
                    event.preventDefault();
                    //        player.updateSource({
                    //            source: '../audio/My_Heart.mp3'
                    //        });
                    if (i == 0) {
                        player1.play();
                        i = 1;
                    } else {
                        player1.pause();
                        i = 0;
                    }
                });
            }
            if (audio == 3) {
                var player2 = $.AudioPlayer2;
                player2.init({
                    container: '#audioWrap'
                    , source: $('#audio_link').val()
                    , imagePath: '../image'
                    , debuggers: false
                    , allowSeek: true
                });
                $('body').on('click', '.play', function (event) {
                    event.preventDefault();
                    //        player.updateSource({
                    //            source: '../audio/My_Heart.mp3'
                    //        });
                    if (i == 0) {
                        player2.play();
                        i = 1;
                    } else {
                        player2.pause();
                        i = 0;
                    }
                });
            }
//            if (audio == 4) {
//                var player3 = $.AudioPlayer3;
//                player3.init({
//                    container: '#audioWrap'
//                    , source: $('#audio_link').val()
//                    , imagePath: '../image'
//                    , debuggers: false
//                    , allowSeek: true
//                });
//                $('body').on('click', '.play', function (event) {
//                    event.preventDefault();
//                    //        player.updateSource({
//                    //            source: '../audio/My_Heart.mp3'
//                    //        });
//                    if (i == 0) {
//                        player3.play();
//                        i = 1;
//                    } else {
//                        player3.pause();
//                        i = 0;
//                    }
//                });
//            }
//            if (audio == 5) {
//                var player4 = $.AudioPlayer4;
//                player4.init({
//                    container: '#audioWrap'
//                    , source: $('#audio_link').val()
//                    , imagePath: '../image'
//                    , debuggers: false
//                    , allowSeek: true
//                });
//                $('body').on('click', '.play', function (event) {
//                    event.preventDefault();
//                    //        player.updateSource({
//                    //            source: '../audio/My_Heart.mp3'
//                    //        });
//                    if (i == 0) {
//                        player4.play();
//                        i = 1;
//                    } else {
//                        player4.pause();
//                        i = 0;
//                    }
//                });
//            }
//            if (audio == 6) {
//                var player5 = $.AudioPlayer5;
//                player5.init({
//                    container: '#audioWrap'
//                    , source: $('#audio_link').val()
//                    , imagePath: '../image'
//                    , debuggers: false
//                    , allowSeek: true
//                });
//                $('body').on('click', '.play', function (event) {
//                    event.preventDefault();
//                    //        player.updateSource({
//                    //            source: '../audio/My_Heart.mp3'
//                    //        });
//                    if (i == 0) {
//                        player5.play();
//                        i = 1;
//                    } else {
//                        player5.pause();
//                        i = 0;
//                    }
//                });
//            }
//            $('body').on('click', '.mute_button', function (event) {
//                event.preventDefault();
//                player.muted();
//            });
//            $('body').on('click', '.volume_range', function (event) {
//                alert('sasasasasa');
//                event.preventDefault();
//                player.setvolume();
//            });
        });
    </script>


