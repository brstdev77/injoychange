<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;
use frontend\models\PilotFrontUser;
use backend\models\CronReports;
use backend\models\PilotCompanyTeams;

$challenge_abr = ucfirst($gamechallengename->challenge_abbr_name);
$daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'SurveyData';
$this->registerJsFile(Yii::$app->homeUrl . 'js/game.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.flot.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.flot.pie.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->title = 'Report';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id];
$this->params['breadcrumbs'][] = 'Report';
$game_id = Yii::$app->request->get('id');
$j = 1;
if ($model->makeup_days) {
    $diff = abs($model->challenge_end_date - $model->makeup_days);
    if (!empty($diff)) {
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        for ($i = 0; $i <= $days; $i++) {
            $makeupdate = date('D M d, Y', strtotime("+$i day", $model->makeup_days));
            $makeup_days .= '<p  style="font-size: 14px;width:50%;float:left;"><span id="registration-date">' . $makeupdate . '</span></p>';
        }
    }
}
$days = PilotFrontUser::datediff($model->challenge_start_date, $model->challenge_end_date);
$weeks = $days / 7;
$weekarray = explode('.', $weeks);
$totalweeks = $weekarray[0] + 1;
$week_name = ['Ist', '2nd', '3rd', '4th', '5th', '6th', '7th', '8th', '9th', '10th', '11th', '12th', '13th'];
$week_end = ['+6 days', '+13 days', '+20 days', '+27 days', '+34 days', '+41 days', '+48 days', '+55 days', '+62 days', '+69 days', '+76 days', '+83` days'];
$week_start = ['+7 days', '+14 days', '+21 days', '+28 days', '+35 days', '+42 days', '+49 days', '+56 days', '+63 days', '+70 days', '+77 days', '+84 days'];
$week = 1;
if (empty($company->image)) {
    $company->image = 'trans.gif.jpg';
}
?>

<input id="company_id" type="hidden" name="company_id" value="<?php echo $cid ?>">
<input id="challenge_id" type="hidden" name="challenge_id" value="<?php echo $challid ?>">
<input id="challenge_start_date" type="hidden" name="company_id" value="<?php echo $model->challenge_start_date; ?>">
<input id="challenge_registration_date" type="hidden" name="company_id" value="<?php echo $model->challenge_registration_date; ?>">
<input id="challenge_end_date" type="hidden" name="challenge_id" value="<?php echo $model->challenge_end_date; ?>">

<div class="row">
    <div class="col-lg-6">
        <div class="box box-warning">
            <div class="box-body">                
                <div class="row">
                    <div class="col-md-6">
                        <b style="margin:12px 0px 6px;"><?php echo $company->company_name; ?></b><br />
                        <img style="width:40px;margin-top:10px;" src="<?php echo Yii::$app->homeUrl . 'img/uploads/' ?><?php echo $company->image ?>">

                    </div>
                    <div class="col-md-6">
                        <div style="text-align:right;">
                            <?php if (!empty($model->banner_image)) { ?>
                                <img style="height:auto;border: 1px solid #cccccc;width:100%" src="<?php echo Yii::$app->homeUrl . 'img/game/welcome_banner/' ?><?php echo $model->banner_image ?>">
                            <?php } else { ?>
                                <img style="height:150px;border: 1px solid #cccccc;" src="<?php echo Yii::$app->homeUrl . 'img/game/' ?><?php echo $gamechallengename->challenge_image ?>">
                            <?php } ?>
                        </div>

                    </div>
                </div>
                <?php if (!empty($model->challenge_teams)) { ?>
                    <div class='row'>
                        <h5 class='col-md-12'><b><i class="fa fa-users" style="margin-right:5px;"></i>Team</b></h5>
                        <?php foreach ($teams as $val) { ?>
                            <p class='col-md-6' style="font-weight: normal;font-size: 14px;float:left;width:50%;"><?php echo $val->team_name; ?></p>
                        <?php } ?> 

                    </div>
                <?php } ?>
                <hr style='margin:10px;'>
                <?php
                $startdate = date('d M D, Y', $model->challenge_start_date);
                $registrationdate = date("d M D, Y", $model->challenge_registration_date);
                $surveydate = date("d M D, Y", $model->challenge_survey_date);
                $enddate = date('d M D, Y', $model->challenge_end_date);
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <h5><b><i class="fa fa-calendar" style="margin-right:5px;"></i>Start Date</b></h5>
                        <p><span id="start-date"> <?php echo $startdate ?></span></p>
                        <h5><b><i class="fa fa-calendar" style="margin-right:5px;"></i>Survey Date</b></h5>
                        <p><span id="start-date"> <?php echo $surveydate ?></span></p>
                    </div>

                    <div class="col-md-6">
                        <h5><b><i class="fa fa-calendar" style="margin-right:5px;"></i>Registration Start From</b></h5>
                        <p><span id="start-date"> <?php echo $registrationdate ?></span></p>
                        <h5><b><i class="fa fa-calendar" style="margin-right:5px;"></i>End Date</b></h5>
                        <p><span id="start-date"> <?php echo $enddate ?></span></p>
                    </div>

                    <div class="col-md-12 makeupdays">
                        <h5><b><i class="fa fa-calendar" style="margin-right:5px;"></i>Makeup Days</b></h5>
                        <?= $makeup_days; ?>
                    </div>
                </div>
                <hr style='margin:10px;'>
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Daily Inspiration Content</b></p>
                    </div>
                    <div class="col-md-6">
                        <p><span id="daily"><?php echo $dailyinspiration->category_name . '(' . $dailyinspirationcount . ' Images)'; ?> </span><a target="_blank" id="daily_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-dailyinspiration-category/dailyinspiration?cid=' . $dailycategory; ?> ">View Content</a></p>
                    </div>
                </div>
                <?php if ($challid != 7 && $challid != 8 && $challid != 11): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Leadership Corner Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="corner"><?php echo $leadershipcategory->category_name . '(' . $leadershipcornercount . ' Corner)'; ?></span><a target="_blank" id="corner_href" style="padding-left:5px" href="<?= Yii::$app->homeUrl . '/pilot-leadership-corner/index?cid=' . $leadershipcorner; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>Weekly Challenge Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="weekly"><?php echo $weeklychallenge->category_name . '(' . $weeklychallengecount . ' Video)'; ?></span><a target="_blank" id="weekly_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-weekly-challenge/index?cid=' . $weeklycategory; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Core Value Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="corner"><?= $corecategory->company_name . '(' . $corecount . ' Corner)'; ?></span><a target="_blank" id="corner_href" style="padding-left:5px" href="<?= Yii::$app->homeUrl . '/pilot-corevalues/index'; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Checkin Yourself Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="corner"><?= $checkin->category_name . '(' . $checkincount . ' Corner)'; ?></span><a target="_blank" id="corner_href" style="padding-left:5px" href="<?= Yii::$app->homeUrl . '/pilot-checkin-yourself-category/index'; ?>">View Content</a></p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($challid == 7): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>Today's Lesson Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="todayslesson"><?php echo $todayslessson->category_name . '(' . $todayslesssoncount . ' Corners)'; ?></span><a target="_blank" id="did_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-todayslesson-corner/index?cid=' . $todayslesssoncategory; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>Did You Know Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="didyouknow"><?php echo $didyouchallenge->category_name . '(' . $didyouchallengecount . ' Corners)'; ?></span><a target="_blank" id="did_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-didyouknow-corner/index?cid=' . $didyoucategory; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Know the Team Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="gettoknow"><?= $gettoknowchallenge->category_name . '(' . $gettoknowchallengecount . ' Corner)'; ?></span><a target="_blank" id="know_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-gettoknow-corner/index?cid=' . $gettoknowcategory; ?>">View Content</a></p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($challid == 8): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>Today's Lesson Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="todayslesson"><?php echo $todayslessson->category_name . '(' . $todayslesssoncount . ' Corners)'; ?></span><a target="_blank" id="did_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-todayslesson-corner/index?cid=' . $todayslesssoncategory; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>Did You Know Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="didyouknow"><?php echo $didyouchallenge->category_name . '(' . $didyouchallengecount . ' Corners)'; ?></span><a target="_blank" id="did_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-didyouknow-corner/index?cid=' . $didyoucategory; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Voice Matters Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="gettoknow"><?= $gettoknowchallenge->category_name . '(' . $gettoknowchallengecount . ' Question)'; ?></span><a target="_blank" id="know_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-voicematters-corner/index?cid=' . $gettoknowcategory; ?>">View Content</a></p>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($challid == 11): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>Today's Lesson Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="todayslesson"><?php echo $todayslessson->category_name . '(' . $todayslesssoncount . ' Corners)'; ?></span><a target="_blank" id="did_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-todayslesson-corner/index?cid=' . $todayslesssoncategory; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p> <b>Did You Know Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="didyouknow"><?php echo $didyouchallenge->category_name . '(' . $didyouchallengecount . ' Corners)'; ?></span><a target="_blank" id="did_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-didyouknow-corner/index?cid=' . $didyoucategory; ?>">View Content</a></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p><b>Voice Matters Content</b></p>
                        </div>
                        <div class="col-md-6">
                            <p><span id="gettoknow"><?= $gettoknowchallenge->category_name . '(' . $gettoknowchallengecount . ' Question)'; ?></span><a target="_blank" id="know_href" style="padding-left:5px" href="<?php echo Yii::$app->homeUrl . '/pilot-voicematters-corner/index?cid=' . $gettoknowcategory; ?>">View Content</a></p>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-6">
                        <p><b>How It Work Content</b></p>
                    </div>
                    <div class="col-md-6">
                        <p><span id="corner"><?= $howitwork->category_name; ?></span><a target="_blank" id="corner_href" style="padding-left:5px" href="<?= Yii::$app->homeUrl . '/pilot-how-it-work/index'; ?>">View Content</a></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Prize Content</b></p>
                    </div>
                    <div class="col-md-6">
                        <p><span id="corner"><?= $prizecategory->category_name; ?></span><a target="_blank" id="corner_href" style="padding-left:5px" href="<?= Yii::$app->homeUrl . '/pilot-prizes-category/index'; ?>">View Content</a></p>
                    </div>
                </div>
                <hr style='margin:10px;'>
                <?php if ($challid != 7 && $challid != 8 && $challid == 11): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <h5><b>Core Heading</b></h5>
                            <p><?php echo $model->core_heading; ?></p>
                        </div>
                        <div class="col-md-6" style="text-align:center">
                            <h5><b>Core Image</b></h5>
                            <p><img src="<?php echo Yii::$app->homeUrl . '/img/game/core_value/' . $model->core_image; ?>"></p>
                        </div>
                    </div>
                    <hr style='margin:10px;'>
                <?php endif; ?>
                <div class="row">
                    <div class="col-md-12">

                        <div  id="features">
                            <?php foreach ($features as $features) { ?>
                                <b> <p style="float:left;width:50%;"><i style="margin-right: 5px;" class="<?php echo $features->font_awesome_class; ?>"></i><?php echo $features->name; ?></p></b>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <hr style='margin:10px;'>
                <?php
                $email = '';
                if (!empty($model->executive_email_1)) {
                    $email .= '<p class="col-md-6" style="float:left;width:50%;">' . $model->executive_email_1 . '</p>';
                };
                if (!empty($model->executive_email_2)) {
                    $email .= '<p class="col-md-6" style="float:left;width:50%;">' . $model->executive_email_2 . '</p>';
                };
                if (!empty($model->executive_email_3)) {
                    $email .= '<p class="col-md-6" style="float:left;width:50%;">' . $model->executive_email_3 . '</p>';
                };
                if (!empty($model->inhouse_email_1)) {
                    $email .= '<p class="col-md-6" style="float:left;width:50%;">' . $model->inhouse_email_1 . '</p>';
                };
                if (!empty($model->inhouse_email_2)) {
                    $email .= '<p class="col-md-6" style="float:left;width:50%;">' . $model->inhouse_email_2 . '</p>';
                };
                if (!empty($model->inhouse_email_3)) {
                    $email .= '<p class="col-md-6" style="float:left;width:50%;">' . $model->inhouse_email_3 . '</p>';
                };
                ?>              
                <div class="row">

                    <h5 class='col-md-12'><b><i class="fa fa-envelope" style="margin-right:5px;"></i>Reports</b></h5>
                    <div id="reports">
                        <?php echo $email ?>
                    </div>

                </div>               

            </div>
        </div>
        <div class="box box-danger">
            <div class="box-header with-border">
                <div class="col-md-6">
                    <h3 class="box-title">Top 7 Members</h3>
                </div>
                <div class="col-md-6">
                    <div class="list-points" style="text-align:right;">
                        <a href="userlistingpoints?id=<?php echo $model->id; ?>">
                            See All
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="col-md-12">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <th>Rank</th>
                                <th>Profile Pic & Name</th>
                                <th>Overall Points</th>
                            </tr>
                            <?php
                            $i = 1;
                            foreach ($userlisting as $topuser) {
                                if ($i <= 7) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><div class="image-wrapper"><img width="100" alt="" src="/frontend/web/uploads/<?php
                                                if (!empty($topuser['profile_pic'])) {
                                                    echo $topuser['profile_pic'];
                                                } else {
                                                    echo 'noimage.png';
                                                }
                                                ?>"></div><p style='margin-top:10px;'><?php echo $topuser['user_name']; ?></p></td>
                                        <td><p style='margin-top:10px;'><?php echo $topuser['total_points']; ?></p></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">

        <a href="digitalhighfive?id=<?php echo Yii::$app->getRequest()->getQueryParam('id'); ?>"><div class="digital_high"><span class="color_white"><b id="highfivecount" class="font_size"><i style="font-size:20px;" class="fa fa-refresh fa-spin highfive" style="display: none;"></i><?php echo $highfivecount; ?></b> Digital High Five</span>
                <div class="pull-right" style="margin-right:23px;width:43px;"><img class="highfive" src="<?php echo Yii::$app->homeUrl ?>img/game/highfive.png">
                </div>
            </div>
        </a>
        <?php if ($model->challenge_id != '7' && $model->challenge_id != '8' && $model->challenge_id != '11'): ?>
            <a href='shareawin?id=<?php echo Yii::$app->getRequest()->getQueryParam('id'); ?>'><div class="share_win"><span class="color_white"><b id="shareawincount" class="font_size"><i style="font-size:20px;" class="fa fa-refresh fa-spin shareawin" style="display: none;"></i><?php echo $shareawincount; ?></b>  Share a Win</span>
                    <div class="pull-right icon_width2"><i class="fa fa-share-alt" aria-hidden="true"></i>

                    </div>
                </div>
            </a>
            <a href="corecheckin?id=<?php echo Yii::$app->getRequest()->getQueryParam('id'); ?>"><div class="weekly_chall"><span class="color_white"><b id="checkincount" class="font_size"><i style="font-size:20px;" class="fa fa-refresh fa-spin checkin" style="display: none;"></i><?php echo $weeklycount; ?></b> Core Values</span>
                    <div class="pull-right icon_width"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <div class="total_action"><span class="color_white"><b id="totalpointcount" class="font_size"><i style="font-size:20px;display: none;" class="fa fa-refresh fa-spin action"></i><?php echo $weeklycount; ?></b> Total Actions</span>
            <div class="pull-right icon_width"><i class="fa fa-envelope"></i>
            </div>
        </div>
        <a href="registereduser?id=<?php echo Yii::$app->getRequest()->getQueryParam('id'); ?>"><div class="register_user"><span class="color_white"><b id="registerusercount" class="font_size"><i style="font-size:20px;display: none;" class="fa fa-refresh fa-spin reguser"></i><?php echo $weeklycount; ?></b> Registered User</span>
                <div class="pull-right icon_width"><i class="fa fa-registered" aria-hidden="true"></i>
                </div>
            </div>
        </a>
        <a href="activeuser?id=<?php echo Yii::$app->getRequest()->getQueryParam('id'); ?>"><div class="score_user"><span class="color_white"><b id="scoreusercount" class="font_size"><i style="font-size:20px;display: none;" class="fa fa-refresh fa-spin scoreuser"></i><?php echo $weeklycount; ?></b> Active User</span>
                <div class="pull-right icon_width"><i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                </div>
            </div>
        </a>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Reports</h3>
            </div>
            <div class="box-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <th>Week</th>
                            <th>Download</th>
                        </tr>
                        <?php
                        $starttime = $model->challenge_start_date;
                        $endtime = $model->challenge_end_date;
                        for ($week = 1; $week <= $totalweeks; $week++):
                            //echo $week;die;
                            $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week])->one();
                            if ($week == 1):
                                $firstweek = date("d M D, Y", $starttime);
                            else:
                                $firstweek = date("d M D, Y", strtotime($week_start[$week - 2], $starttime));
                            endif;
                            if ($week == $totalweeks):
                                $firstweek_end = date("d M D, Y", $endtime);
                            else:
                                $firstweek_end = date("d M D, Y", strtotime($week_end[$week - 1], $starttime));
                            endif;
                            ?>

                            <tr>
                                <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $firstweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $firstweek_end; ?></td>
                                <td><?= $week_name[$week - 1]; ?> Week</td> 
                                <?php if (!empty($report)) {
                                    ?>
                                    <td><a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;Download</a></td>
                                    <?php
                                } else {
                                    ?>
                                    <td>Report will be available soon.</td>
                                    <?php
                                }
                                ?>
                            </tr>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
        if (!empty($model->challenge_teams)) {
            $teams1[] = explode(',', $model->challenge_teams);
            ?>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Team Reports</h3>
                </div>
                <div class="box-body">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <th>Date</th>
                                <th>Week</th>
                                <th>Download</th>
                            </tr>
                            <tr>
                                <?php
                                $starttime = $model->challenge_start_date;
                                $week = PilotFrontUser::getGameWeek($model);
                                if ($week != 0):
                                    $week = $week - 1;
                                endif;
                                $firstweek = date("d M D, Y", $starttime);
                                $firstweek_end = date("d M D, Y", strtotime("+6 days", $starttime));
                                ?>
                                <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $firstweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $firstweek_end; ?></td>
                                <td>1st Week</td> 
                                <td>
                                    <?php
                                    foreach ($teams1 as $team_array):
                                        foreach ($team_array as $team_id):
                                            $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week, 'team_id' => $team_id])->one();
                                            $company = PilotCompanyTeams::find()->where(['id' => $team_id])->one();
                                            if (!empty($report) && $week == '1') {
                                                $report_array[] = $report->filepath;
                                                ?>
                                                <a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php
                                            } else if ($week == 0 || $week > 1) {
                                                $report1 = CronReports::find()->where(['game_id' => $game_id, 'week_no' => 1, 'team_id' => $team_id])->one();
                                                if (!empty($report1)) {
                                                    $report_array[] = $report1->filepath;
                                                    ?>
                                                    <a href="/backend/web/<?= $report1->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php } else {
                                                    ?>
                                                    Report will be available soon.<?php
                                                }
                                            } else {
                                                ?>
                                                Report will be available soon.
                                                <?php
                                            }
                                        endforeach;
                                    endforeach;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                $starttime = $model->challenge_start_date;
                                $secondweek = date("d M D, Y", strtotime("+7 days", $starttime));
                                $secondweek_end = date("d M D, Y", strtotime("+13 days", $starttime));
                                ?>
                                <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $secondweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $secondweek_end; ?></td>
                                <td>2nd Week</td>
                                <td>
                                    <?php
                                    foreach ($teams1 as $team_array):
                                        foreach ($team_array as $team_id):
                                            $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week, 'team_id' => $team_id])->one();
                                            $company = PilotCompanyTeams::find()->where(['id' => $team_id])->one();
                                            if (!empty($report) && $week == '2') {
                                                ?>
                                                <a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php
                                            } else if ($week == 0 || $week > 2) {
                                                $report1 = CronReports::find()->where(['game_id' => $game_id, 'week_no' => 2, 'team_id' => $team_id])->one();
                                                if (!empty($report1)) {
                                                    ?>
                                                    <a href="/backend/web/<?= $report1->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php } else {
                                                    ?>
                                                    Report will be available soon.<?php
                                                }
                                            } else {
                                                ?>
                                                Report will be available soon.
                                                <?php
                                            }
                                        endforeach;
                                    endforeach;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                $thirdweek = date("d M D, Y", strtotime("+14 days", $starttime));
                                $thirdweek_end = date("d M D, Y", strtotime("+20 days", $starttime));
                                ?>
                                <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $thirdweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $thirdweek_end; ?></td>
                                <td>3rd Week</td>
                                <td>
                                    <?php
                                    foreach ($teams1 as $team_array):
                                        foreach ($team_array as $team_id):
                                            $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week, 'team_id' => $team_id])->one();
                                            $company = PilotCompanyTeams::find()->where(['id' => $team_id])->one();
                                            if (!empty($report) && $week == '3') {
                                                ?>
                                                <a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php
                                            } else if ($week == 0 || $week > 3) {
                                                $report1 = CronReports::find()->where(['game_id' => $game_id, 'week_no' => 3, 'team_id' => $team_id])->one();
                                                if (!empty($report1)) {
                                                    ?>
                                                    <a href="/backend/web/<?= $report1->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php } else {
                                                    ?>
                                                    Report will be available soon.<?php
                                                }
                                            } else {
                                                ?>
                                                Report will be available soon.
                                                <?php
                                            }
                                        endforeach;
                                    endforeach;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <?php
                                $fourthweek = date("d M D, Y", strtotime("+21 days", $starttime));
                                $fourthweek_end = date("d M D, Y", strtotime("+27 days", $starttime));
                                ?>
                                <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $fourthweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $fourthweek_end; ?></td>
                                <td>4th Week</td>
                                <td>
                                    <?php
                                    foreach ($teams1 as $team_array):
                                        foreach ($team_array as $team_id):
                                            $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week, 'team_id' => $team_id])->one();
                                            $company = PilotCompanyTeams::find()->where(['id' => $team_id])->one();
                                            if (!empty($report) && $week == '4') {
                                                ?>
                                                <a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php
                                            } else if ($week == 0 || $week > 4) {
                                                $report1 = CronReports::find()->where(['game_id' => $game_id, 'week_no' => 4, 'team_id' => $team_id])->one();
                                                if (!empty($report1)) {
                                                    ?>
                                                    <a href="/backend/web/<?= $report1->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                <?php } else {
                                                    ?>
                                                    Report will be available soon.<?php
                                                }
                                            } else {
                                                ?>
                                                Report will be available soon.
                                                <?php
                                            }
                                        endforeach;
                                    endforeach;
                                    ?>
                                </td>
                            </tr>
                            <?php if (5 <= $totalweeks && $totalweeks < 6) { ?>
                                <tr>
                                    <?php
                                    $fifthweek = date("d M D, Y", strtotime("+28 days", $starttime));
                                    //echo $model->challenge_end_date;die;
                                    $fifthweek_end = date("d M D, Y", $model->challenge_end_date);
                                    ?>
                                    <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $fifthweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $fifthweek_end; ?></td>
                                    <td>5th Week</td>
                                    <td>
                                        <?php
                                        foreach ($teams1 as $team_array):
                                            foreach ($team_array as $team_id):
                                                $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week, 'team_id' => $team_id])->one();
                                                $company = PilotCompanyTeams::find()->where(['id' => $team_id])->one();
                                                if (!empty($report) && $week == '5') {
                                                    ?>
                                                    <a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                    <?php
                                                } else if ($week == 0 || $week > 5) {
                                                    $report1 = CronReports::find()->where(['game_id' => $game_id, 'week_no' => 5, 'team_id' => $team_id])->one();
                                                    if (!empty($report1)) {
                                                        ?>
                                                        <a href="/backend/web/<?= $report1->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                    <?php } else {
                                                        ?>
                                                        Report will be available soon.<?php
                                                    }
                                                } else {
                                                    ?>
                                                    Report will be available soon.
                                                    <?php
                                                }
                                            endforeach;
                                        endforeach;
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                            <?php if (5 < $totalweeks && $totalweeks <= 6) { ?>
                                <tr>
                                    <?php
                                    $fifthweek = date("d M D, Y", strtotime("+28 days", $starttime));
                                    //echo $model->challenge_end_date;die;
                                    $fifthweek_end = date("d M D, Y", strtotime("+34 days", $starttime));
                                    ?>
                                    <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $fifthweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $fifthweek_end; ?></td>
                                    <td>5th Week</td>
                                    <td>
                                        <?php
                                        foreach ($teams1 as $team_array):
                                            foreach ($team_array as $team_id):
                                                $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week, 'team_id' => $team_id])->one();
                                                $company = PilotCompanyTeams::find()->where(['id' => $team_id])->one();
                                                if (!empty($report) && $week == '5') {
                                                    ?>
                                                    <a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                    <?php
                                                } else if ($week == 0 || $week > 5) {
                                                    $report1 = CronReports::find()->where(['game_id' => $game_id, 'week_no' => 5, 'team_id' => $team_id])->one();
                                                    if (!empty($report1)) {
                                                        ?>
                                                        <a href="/backend/web/<?= $report1->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                                    <?php } else {
                                                        ?>
                                                        Report will be available soon.<?php
                                                    }
                                                } else {
                                                    ?>
                                                    Report will be available soon.
                                                    <?php
                                                }
                                            endforeach;
                                        endforeach;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <?php
                                    $sixthweek = date("d M D, Y", strtotime("+35 days", $starttime));
                                    //echo $model->challenge_end_date;die;
                                    $sixthweek_end = date("d M D, Y", $model->challenge_end_date);
                                    ?>
                                    <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $sixthweek; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $sixthweek_end; ?></td>
                                    <td>6th Week</td>
                                    <?php
                                    foreach ($teams1 as $team_array):
                                        foreach ($team_array as $team_id):
                                            $report = CronReports::find()->where(['game_id' => $game_id, 'week_no' => $week, 'team_id' => $team_id])->one();
                                            $company = PilotCompanyTeams::find()->where(['id' => $team_id])->one();
                                            if (!empty($report) && $week == '6') {
                                                ?>
                                        <a href="/backend/web/<?= $report->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                        <?php
                                    } else if ($week == 0 || $week > 6) {
                                        $report1 = CronReports::find()->where(['game_id' => $game_id, 'week_no' => 6, 'team_id' => $team_id])->one();
                                        if (!empty($report1)) {
                                            ?>
                                            <a href="/backend/web/<?= $report1->filepath; ?>" class="btn btn-default custom_btn1"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;<?= $company->team_name; ?></a>
                                        <?php } else {
                                            ?>
                                            Report will be available soon.<?php
                                        }
                                    } else {
                                        ?>
                                        Report will be available soon.
                                        <?php
                                    }
                                endforeach;
                            endforeach;
                            ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Survey Reports</h3>
            </div>
            <div class="box-body">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <?php
                            if ($model->survey == 0) {
                                ?>
                                <td colspan="3" style="text-align: center">No Survey Selected for this game</td>
                                <?php
                            } else {
                                ?>
                                <th>Date</th>
                                <th>Download</th>
                            </tr>
                            <tr>
                                <?php
                                $surveytime = $model->challenge_survey_date;
                                $surveydate = date("d M D, Y", $surveytime);
                                $endtime = $model->challenge_end_date;
                                $enddate = date("d M D, Y", $endtime);
                                $date = date("d M D, Y");
                                ?> 
                                <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?php echo $surveydate; ?>&nbsp;&nbsp;-&nbsp;&nbsp;<?php echo $enddate; ?></td>
                                <?php if (time() >= $surveytime) { ?>
                                    <td><a href="survey-reports?id=<?= $model->id; ?>" class="btn btn-default custom_btn"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;Download</a></td>
                                    <?php
                                }
                            }
                            ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-info survey">
            <div class="box-header with-border">
                <h3 class="box-title">Survey</h3>
            </div>
            <p id="reportstart" rel="<?= $j ?>" style="display:none"></p>
            <?php
            $total = PilotFrontUser::find()->count();
            foreach ($surveymodel as $survey) {
                $count = 0;
                $type = 0;
                $neutral = 0;
                $somedisagree = 0;
                $disagree = 0;
                ?>
                <div class="future">

                    <p id= "surveytype<?= $j ?>" rel="<?= $survey->type ?>" style="display:none;"></p>		

                    <?php
                    if ($survey->type == "checkbox") {
                        $fill = 'Yes';
                        $model = $daily_model_name::find()->where(['and', "challenge_id = '$id'", "survey_question_id = '$survey->id'", "survey_filled = '$fill'"])->all();
                        if (!empty($model)) {
                            foreach ($model as $key):
                                if ($key['survey_response'] == "agree" || $key['survey_response'] == "Agree") {
                                    $count++;
                                } else if ($key['survey_response'] == "somewhat agree" || $key['survey_response'] == "Somewhat Agree") {
                                    $type++;
                                } else if ($key['survey_response'] == "neutral" || $key['survey_response'] == "Neutral") {
                                    $neutral++;
                                } else if ($key['survey_response'] == "somewhat disagree" || $key['survey_response'] == "Somewhat Disagree") {
                                    $somedisagree++;
                                } else if ($key['survey_response'] == "disagree" || $key['survey_response'] == "Disagree") {
                                    $disagree++;
                                }
                            endforeach;
                        }
                        ?>
                        <?php if ($count == 0 && $type == 0 && $neutral == 0 && $somedisagree == 0 && $disagree == 0) { ?>
                            <div class="pull-left cont col-md-8 col-sm-8">
                                <?php echo $survey->question; ?>     
                            </div>
                        <?php } else { ?>
                            <div class="pull-left cont col-md-8 col-sm-8">
                                <?php echo $survey->question; ?> 
                            </div>
                        <?php } ?>					  
                        <?php if ($count == 0 && $type == 0 && $neutral == 0 && $somedisagree == 0 && $disagree == 0) { ?>
                            <div class="pull-right bar col-md-4 col-sm-4">
                                <div class="survey_report">
                                    <div class="chart-legend clearfix">No one filled this survey.</div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="pull-right bar col-md-4 col-sm-4">
                                <div class="survey_report">
                                    <div id="donut-chart<?= $j ?>" style="height: 100px;position:inherit">
                                        <p id="surveyagree<?= $j ?>" rel="<?= $count ?>" style="display:none"></p>
                                        <p id="surveysomeagree<?= $j ?>" rel="<?= $type ?>" style="display:none"></p>
                                        <p id="surveyneutral<?= $j ?>" rel="<?= $neutral ?>" style="display:none"></p>
                                        <p id="surveysomedis<?= $j ?>" rel="<?= $somedisagree ?>" style="display:none"></p>
                                        <p id="surveydisagree<?= $j ?>" rel="<?= $disagree ?>" style="display:none"></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $j++;
                        }
                        ?>

                        <?php
                    } elseif ($survey->type == "textbox") {
                        $fill = 'Yes';
                        $model = $daily_model_name::find()->where(['and', "challenge_id = '$id'", "survey_question_id = '$survey->id'", "survey_filled = '$fill'"])->count();
                        if (!empty($model)) {
                            $count = $model;
                            $type = $total - $count;
                        } else {
                            $count = 0;
                            $type = 0;
                        }
                        ?>
                        <?php if ($count == 0 && $type == 0) { ?>
                            <div class="pull-left cont col-md-8 col-sm-8">
                                <?php echo $survey->question; ?>     
                            </div>
                        <?php } else { ?>	
                            <div class="pull-left cont col-md-8 col-sm-8">
                                <?php echo $survey->question; ?>   
                            </div>
                        <?php } ?>
                        <?php if ($count == 0 && $type == 0) { ?>
                            <div class="pull-right bar col-md-4 col-sm-4">
                                <div class="survey_report">
                                    <div class="chart-legend clearfix">No one filled this survey.</div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="pull-right bar col-md-4 col-sm-4">
                                <div class="survey_report">
                                    <div id="donut-chart<?= $j ?>" style="height: 100px;position:inherit">
                                        <p id="surveycount<?= $j ?>" rel="<?= $count ?>" style="display:none"></p>
                                        <p id="surveytype1<?= $j ?>" rel="<?= $type ?>" style="display:none"></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $j++;
                        }
                        ?>
                    <?php } ?>
                </div>
            <?php } ?>
            <div class="future1">
                <div class="col-md-12 col-sm-12">
                    <div class="check1">   <div class="align"> <div class="red" style="background-color:#EE3B24;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px"></div><span class="reporttext">Agree</span></div>
                        <div class="align"> <div class="red" style="background-color:#FF9C00;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px"></div><span class="reporttext">Somewhat Agree</span></div>
                        <div class="align"> <div class="red" style="background-color:#3C8DBC;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px"></div><span class="reporttext">Neutral</span></div>
                        <div class="align"> <div class="red" style="background-color:#0073B7;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px"></div><span class="reporttext">Somewhat Disagree</span></div>
                        <div class="align"> <div class="red" style="background-color:#00C0EF;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px"></div><span class="reporttext">Disagree</span></div>
                    </div>
                </div>
            </div>
            <p id="reportlast" rel="<?= $j ?>" style="display:none"></p>
        </div>
    </div>
</div>

