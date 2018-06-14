<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use frontend\models\PilotFrontUser;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\PilotCheckinYourselfData;

$baseurl = Yii::$app->request->baseurl;
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
                        <span style="cursor: pointer;" class="fa fa-times" id="mail_remove_box"></span>
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
                    <?= $form->field($daily_email, 'message', ['inputOptions' => ['placeholder' => "type your message"]])->textarea(['id' => 'core_value_area', 'maxlength' => 180])->label(false); ?>

                    <div class="form-group">
                        <?= Html::Button('SEND', ['class' => 'sub-btn btn btn-warning text-capitalize save_email', 'id' => 'mail-submit', 'style' => 'background:#e41515']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>

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
            echo $form->field($daily_model, 'user_id', ['inputOptions' => ['value' => Yii::$app->user->identity->id]])->hiddenInput(['id' => 'pilotfrontcoredailyinspiration-user_id'])->label(false);
            echo $form->field($daily_model, 'dayset', ['inputOptions' => ['value' => date('Y-m-d')]])->hiddenInput(['id' => 'pilotfrontcoredailyinspiration-dayset'])->label(false);
            ?>
            <?php if (empty($daily_entry)): ?>
                <?= Html::Button('Submit 10 pts', ['class' => 'sub-btn btn btn-warning text-capitalize save-daily', 'style' => 'float:left;']); ?>
            <?php endif; ?>
            <button class="btn btn-warning text-capitalize share" style="float:right">SHARE</button>
        </div>    
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
    <!--Daily Inspirations End-->  

    <!-- Core Values Modal-->
    <?php
    if (isset($corevalues_model)):
        $core_values = PilotCompanyCorevaluesname::find()->where(['company_id' => $core_id])->orderby(['id' => SORT_ASC])->all();
        $vission_message = PilotCompanyCorevaluesname::find()->where(['company_id' => $core_id])->andWhere(['!=', 'vission_msg', ''])->one();
        ?>
        <div class="corevalues_content">
            <?php
            $form = ActiveForm::begin([
                        'id' => 'form-core-values',
                        'options' => ['enctype' => 'multipart/form-data'],
                        'errorSummaryCssClass' => 'alert alert-danger',
                        'enableAjaxValidation' => FALSE,
                        'enableClientValidation' => TRUE,
            ]);
            ?>
            <div class="modal-body">
                <div class = "container-fluid" style = "text-align: center;">
                    <?php
                    echo $form->field($corevalues_model, 'user_id', ['inputOptions' => ['value' => Yii::$app->user->identity->id]])->hiddenInput(['id' => 'pilotfrontcorecheckin-user_id'])->label(false);
                    echo $form->field($corevalues_model, 'dayset', ['inputOptions' => ['value' => date('Y-m-d')]])->hiddenInput()->label(false);
                    ?>
                    <div class="popup-title">
                        <h1><?= $vission_message->popup_heading; ?></h1>
                    </div>
                    <div class="value-description-wrapper">
                        <?php if (!empty($core_values)) { ?>
                            <div class="value-des-header">
                                <div class="critical-value-header">
                                    <?php if (!empty($vission_message->sub_title_heading1)): ?>
                                        <?= $vission_message->sub_title_heading1; ?>
                                    <?php else: ?>
                                        5S
                                    <?php endif; ?>
                                </div>
                                <div class="critical-value-desc">
                                    Definition
                                </div>
                            </div>
                            <div class="value-des-content">
                                <?php
                                $row = 1;
                                foreach ($core_values as $core) {
                                    if (empty($core->core_values_name)) {
                                        continue;
                                    }
                                    if (!empty($core->core_values_name)) {
                                        $expordValue = explode('-', $core->core_values_name);
                                        $firstLetter = $expordValue[0];
                                        $fullword = isset($expordValue[1]) ? $expordValue[1] : '';
                                        $row++;
                                    }
                                    ?>
                                    <div class="value-des-critical-row row<?= $row; ?>">
                                        <div class="value-content-value">
                                            <!--<span><?= $firstLetter; ?></span> - <?= $fullword; ?> -->
                                            <?= $core->core_values_name; ?>
                                        </div>
                                        <div class="des-content-value">
                                            <ul class="core_value_list">
                                                <li>
                                                    <?= $core->definition; ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?> 
                    </div>
                    <div class="mission-vision-footer">
                        <?= $vission_message->vission_msg; ?>
                        <!--                    <div class="mission-content-main">
                                                <div class="mission-title"></div>
                                                <div class="mission-content">
                                                    Our Vision is simple clear and powerful, guiding us to provide a path to transformation through our products and services.
                                                </div>
                                            </div>
                                            <div class="vision-content-main">
                                                <div class="vision-title">
                                                    Vision
                                                </div>
                                                <div class="vision-content">
                                                    To provide a platform for individuals and organizations to engage, connect and elevate themselves through the values they stand for with personal and professional growth as the metric of success.
                                                    <br><br>
                                                    We can thank all of you for creating the true HEART of Injoy Global.
                                                </div>
                                            </div>-->
                    </div>
                </div>
            </div>
            <div class = "modal-footer">
                <?php if (empty($corevalues_entry)): ?>
                    <?= Html::Button('Submit 5 pts', ['class' => 'sub-btn btn btn-warning text-capitalize core-daily']); ?>
                <?php endif; ?>
            </div>    
            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>
    <!-- Core Values End-->  

    <!-- Check In Modal  Modal-->
    <?php
    if (isset($today_valuesModel)):
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
        if (isset($action)):
            $action_val = $action;
        else:
            $action_val = '';
        endif;
        ?>
        <div class="modal-body">
            <!--Calendar Modal Content START-->
            <?php
            if (!empty($game_obj->checkin_yourself_content)) {
                $record = PilotCheckinYourselfData::find()->where(['category_id' => $game_obj->checkin_yourself_content])->one();
                $question_lable = $record->question_label;
                $placeholder_text = $record->placeholder_text;
                $selct_option_text = $record->select_option_text;
                $valuesLabelarray = PilotCheckinYourselfData::find()->select(['core_value'])->where(['category_id' => $game_obj->checkin_yourself_content])->all();
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
            <?php if (isset($action)): ?>
                <?php if (!empty($prev_values_currentday)): ?>
                    <h3><?= $question_lable ?></h3>
                    <div id="today_values">
                        <div class="Content-values-outer">
                            <?php foreach ($prev_values_currentday as $value) : ?>
                                <div class="Content-values">
                                    <p class="Content-values-first">
                                        <span class="values-title"><?= $value->serial; ?>)</span>
                                        <span class="values-value"><?= $value->label; ?></span>
                                    </p>
                                    <p class="Content-values-sec"><?= json_decode($value->comment); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (empty($prev_values_currentday)): ?>
                    <h3><?= $question_lable ?></h3>
                <?php endif; ?>
                <?php
                $form = ActiveForm::begin([
                            'id' => 'form-today_values',
                            'options' => ['enctype' => 'multipart/form-data'],
                            'errorSummaryCssClass' => 'alert alert-danger',
                            'enableAjaxValidation' => FALSE,
                            'enableClientValidation' => TRUE,
                            'action' => $action_val
                ]);
                ?>

                <div class="container-fluid" style="text-align: center;">
                    <div class="form-item form-type-select user-form-email form-group">
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
                    <?= $form->field($today_valuesModel, 'serial', ['inputOptions' => ['value' => $tv_serial]])->hiddenInput()->label(false); ?>
                    <?php
                    //Calendar Case:
                    if (isset($dayset)):
                        echo $form->field($today_valuesModel, 'dayset', ['inputOptions' => ['value' => $dayset]])->hiddenInput()->label(false);
                    endif;
                    ?>
                </div>


                <div class="new-mail-submit">
                    <div class="new_text">
                        <div class=submit-image>
                            <span class="background-checkbox <?= $tv_cls1; ?>"></span>
                            <span class="background-checkbox <?= $tv_cls2; ?>"></span>
                            <input id=new-mail-submit class="new-user-submit btn btn-primary form-submit mdl-btn1" name=op value="<?= $tv_btn_text; ?>" type=submit>
                        </div>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
                <!--Calendar Modal Content END-->
                <!--Dashboard Modal Content-->
            <?php else:
                ?>
                <h3><?= $question_lable ?></h3>
                <?php
                $form = ActiveForm::begin([
                            'id' => 'form-today_values',
                            'options' => ['enctype' => 'multipart/form-data'],
                            'errorSummaryCssClass' => 'alert alert-danger',
                            'enableAjaxValidation' => FALSE,
                            'enableClientValidation' => TRUE,
                            'action' => $action_val
                ]);
                ?>

                <div class="container-fluid" style="text-align: center;">
                    <div class="form-item form-type-select user-form-email form-group">
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
                    <?php
                    //Calendar Case:
                    if (isset($dayset)):
                        echo $form->field($today_valuesModel, 'dayset', ['inputOptions' => ['value' => $dayset]])->hiddenInput()->label(false);
                    endif;
                    ?>
                </div>


                <div class="new-mail-submit">
                    <div class="new_text">
                        <div class=submit-image>
                            <span class="background-checkbox <?= $tv_cls1; ?>"></span>
                            <span class="background-checkbox <?= $tv_cls2; ?>"></span>
                            <input id=new-mail-submit class="new-user-submit btn btn-primary form-submit mdl-btn2" name=op value="<?= $tv_btn_text; ?>" type=button>
                        </div>
                    </div>
                </div>

                <?php
                ActiveForm::end();
            endif;
            ?>
        </div>
        <div class = "modal-footer"></div>
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
            <img id="loading-check-img" src="../images/ajax-loader-leads.gif">
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

    <!-- Leadership Modal-->
    <?php if (isset($leadership_model)): ?>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-leadership',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'errorSummaryCssClass' => 'alert alert-danger',
                    'enableAjaxValidation' => FALSE,
                    'enableClientValidation' => TRUE,
        ]);
        ?>
        <div class="modal-body">
            <div class = "container-fluid" style = "text-align: center;">
                <?php
                echo $form->field($leadership_model, 'user_id', ['inputOptions' => ['value' => Yii::$app->user->identity->id]])->hiddenInput(['id' => 'logged_id'])->label(false);
                echo $form->field($leadership_model, 'tip_pos', ['inputOptions' => ['value' => $tip_pos]])->hiddenInput(['id' => 'tip_pos'])->label(false);
                echo $form->field($leadership_model, 'dayset', ['inputOptions' => ['value' => date('Y-m-d')]])->hiddenInput()->label(false);
                ?>

                <div class="modal-image">

                    <?php
                    $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/lightbox-image/' . $leadership_tip_obj->popup_image;
                    ?>
                    <img class="leader-img" src="<?= $tip_image_path; ?>">
                    <div class="tip_title"><?= $leadership_tip_obj->title; ?><p style="font-weight: lighter;"><?= $leadership_tip_obj->designation; ?></p></div>
                    <div class="tip_des">
                        <?php
                        if ($leadership_tip_obj->answer_type == '2'):
                            $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $leadership_tip_obj->video_poster;
                            $file_link = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $leadership_tip_obj->file_link;
                            ?>
                            <video width="500" height="240" controls="" controlsList="nodownload" poster="<?= $tip_image_path; ?>" src="<?= $file_link; ?>">
                                <!--<source src="<?= strip_tags($leadership_tip_obj->description); ?>" type="video/mp4">-->
                                <!--source src="movie.ogg" type="video/ogg"-->
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
                        <?= $leadership_tip_obj->description; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class = "modal-footer">
            <?php if (empty($leadership_entry)): ?>
                <?= Html::Button('Submit 10 pts', ['class' => 'sub-btn btn btn-warning text-capitalize leadership-save']); ?>
            <?php endif; ?>
        </div>
        <?php ActiveForm::end(); ?>

    <?php endif; ?>
    <!-- Leadership Modal End -->

    <!-- Weekly Challenge Modal-->
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
        <div class="modal-body">
            <div class = "container-fluid" style = "text-align: center;">
                <?php
                echo $form->field($weekly_model, 'user_id', ['inputOptions' => ['value' => Yii::$app->user->identity->id]])->hiddenInput()->label(false);
                echo $form->field($weekly_model, 'dayset', ['inputOptions' => ['value' => date('Y-m-d')]])->hiddenInput()->label(false);
                ?>
                <div class="modal-image">
                    <iframe class="youtube-player" type="text/html" src="<?= $weekly_video_link; ?>?hd=1&amp;rel=0" allowfullscreen="" width="480" height="385">

                    </iframe>

                    <div class="week_title">
                        <p style='color:#e41515'><?= ucwords($weekly_title); ?></p>
                    </div>
                </div>
            </div>              
        </div>

        <div class = "modal-footer">
            <h3 class="share_heading">What is one thing you took away from this video? <span class="required">*</span> </h3>
            <?php
            if (!empty($weekly_model->comment)) {
                $weekly_model->comment = json_decode($weekly_model->comment);
            }
            ?>
            <?= $form->field($weekly_model, 'comment', ['template' => '{input}{error}', 'inputOptions' => ['onkeyup' => 'return max_char_length(this,event);', 'class' => 'form-control']])->textarea(['maxlength' => 255, 'id' => 'video_comment']);
            ?>
            <div class="text-length"><span></span></div>
            <?= Html::Button('Submit 40 pts', ['class' => 'sub-btn btn btn-warning text-capitalize weekly-save']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
    <!-- Weekly Challenge Modal End -->  

    <!-- Share A Win Modal-->
    <?php if (isset($shareawin_model)): ?>
        <div style="display: none;" id="loading-check" class="loading-check-div">
            <img id="loading-check-img" src="../images/loaderhighfive.gif">
        </div>
        <?php
        $form = ActiveForm::begin([
                    'id' => 'form-shareawin',
                    'options' => ['enctype' => 'multipart/form-data'],
                    'errorSummaryCssClass' => 'alert alert-danger',
                    'enableAjaxValidation' => FALSE,
                    'enableClientValidation' => TRUE,
        ]);
        ?>
        <div class="modal-body">
            <div class = "container-fluid" style = "text-align: center;">
                <h3 class="share_heading">What is one win you had today? <span class="required">*</span></h3>
                <div class="benefits-textbox form-control" id=pilotfrontleadsshareawin-comment contenteditable=true maxlength="150" onkeyup="return tag_users(this, event)" onkeydown="return text_length(this, event)"></div>
                <?php
                echo $form->field($shareawin_model, 'user_id', ['inputOptions' => ['value' => Yii::$app->user->identity->id]])->hiddenInput()->label(false);
                echo $form->field($shareawin_model, 'dayset', ['inputOptions' => ['value' => date('Y-m-d')]])->hiddenInput()->label(false);
                echo $form->field($shareawin_model, 'comment')->hiddenInput(['id' => 'leadsshareawin-comment'])->label(false);
                ?>
                <div id=display1></div>
                <div id=msgbox1></div>

                <div class='error_box1'></div>
                <div class=text-grateful-var1></div>
                <div class="text-length"><span></span></div>
            </div>
        </div>
        <div class = "modal-footer">
            <?= Html::Button('SHARE A WIN 10 PTS', ['class' => 'sub-btn btn btn-warning text-capitalize', 'id' => 'share-submit']); ?>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
    <!-- Share A Win Modal End --> 

    <!-- Total Steps Modal-->
    <?php if (isset($totalsteps_model)): ?>

        <div class="modal-body">
            <div class="container-fluid padding-0">

                <div class="my-steps"> 
                    <div class="row">
                        <div class="cell stpslbl">
                            <p class="pt">My Total Steps</p> 
                        </div>
                        <div class="cell stpsicn">
                            <img src="<?= $baseurl; ?>/images/steps.png" alt=steps height=42 width=66>
                        </div>
                        <div class="cell stpscount">
                            <p class="pt"><?= $user_total_steps; ?></p> 
                        </div>
                    </div>
                </div>
                <?php if (!empty($all_users_total_steps)): ?>
                    <div class="higest-steps"> 
                        <div class="row hs-header">
                            <div class="cell pro-pic"> Prof. Pic </div>
                            <div class="cell pro-pic"> Name </div>
                            <div class="cell icn"> Icon</div>
                            <div class="cell h-scr"> Step Score </div>
                        </div>
                        <?php
                        $i = 1;
                        foreach ($all_users_total_steps as $user_id => $user_steps):
                            if ($i <= 5):
                                if ($i % 2 == 0):
                                    $row_cls = 'even';
                                else:
                                    $row_cls = 'odd';
                                endif;
                                //Get User Identity
                                $user_obj = PilotFrontUser::findIdentity($user_id);
                                $userImage = $user_obj->profile_pic;
                                $username = $user_obj->username;
                                if ($userImage == ''):
                                    $userImagePath = '../images/user_icon.png';
                                else:
                                    $userImagePath = $baseurl . '/uploads/thumb_' . $userImage;
                                endif;
                                ?>
                                <div class="row <?= $row_cls; ?>">
                                    <div class="cell stpslbl">
                                        <img src="<?= $userImagePath; ?>" alt=steps height=42 width=66>
                                    </div>
                                    <div class="cell stpsuname">
                                        <p class="uname"><?= $username; ?></p> 
                                    </div>
                                    <div class="cell stpsicn">
                                        <img src="<?= $baseurl; ?>/images/steps.png" alt=steps height=42 width=66>
                                    </div>
                                    <div class="cell stpscount">
                                        <p class="pt"><?= $user_steps; ?></p> 
                                    </div>
                                </div>
                                <?php
                            endif;
                            $i++;
                        endforeach;
                        ?>
                    </div>
                <?php endif; ?>


            </div>
        </div>
        <div class = "modal-footer">

        </div>

    <?php endif; ?>
    <!-- Total Steps Modal End --> 

    <script>
        var j = 0;
        var i = 0;
        $(document).ready(function () {
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
                $('body').on('click', '.audio_player1.play', function (event) {
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
                $('body').on('click', '.audio_player2.play', function (event) {
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
                $('body').on('click', '.audio_player3.play', function (event) {
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
        });
        jQuery.fn.putCursorAtEnd = function () {

            return this.each(function () {

                var $el = $(this),
                        el = this;

                if (!$el.is(":focus")) {
                    $el.focus();
                }

                // If this function exists... (IE 9+)
                if (el.setSelectionRange) {

                    var len = $el.val().length * 2;

                    setTimeout(function () {
                        el.setSelectionRange(len, len);
                    }, 1);

                } else {

                    $el.val($el.val());

                }

                this.scrollTop = 999999;

            });

        };

        (function () {

            var searchInput = $("#core_value_area");

            searchInput
                    .putCursorAtEnd() // should be chainable
                    .on("focus", function () { // could be on any event
                        searchInput.putCursorAtEnd()
                    });

        })();
    </script>


