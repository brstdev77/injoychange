<?php
/* @var $this yii\web\View */


$baseurl = Yii::$app->request->baseurl;

$comp_id = $game_obj->challenge_company_id;
$text1 = $game_obj->banner_text_1;
$text2 = $game_obj->banner_text_2;
$contents = explode(' ', $text1);
$content1 = strtolower(end($contents));
$text3 = strtolower($text2);
$contents = explode(' ', $text2);
$content2 = strtolower($contents[0]);
$action1 = $content1.' '.$content2.' ';
$action = ucwords($action1);
$title = ucwords($content1.' '.$text3);
$this->title = 'Leaderboard | '.$title;
$user_team_id = Yii::$app->user->identity->team_id;
$user_team_obj = \backend\models\PilotCompanyTeams::find()->where(['company_id' => $comp_id, 'id' => $user_team_id])->one();
$wins = '';
$core = '';
$shoutouts = '';

if (strlen($login_user_team_wins) == 1):
    $wins = 'single';
elseif (strlen($login_user_team_wins) == 2):
    $wins = 'double';
elseif (strlen($login_user_team_wins) == 3):
    $wins = 'three';
elseif (strlen($login_user_team_wins) == 4):
    $wins = 'four';
endif;

if (strlen($login_user_team_core_values) == 1):
    $core = 'single';
elseif (strlen($login_user_team_core_values) == 2):
    $core = 'double';
elseif (strlen($login_user_team_core_values) == 3):
    $core = 'three';
elseif (strlen($login_user_team_core_values) == 3):
    $core = 'four';
endif;

if (strlen($login_user_team_high5s) == 1):
    $shoutouts = 'single';
elseif (strlen($login_user_team_high5s) == 2):
    $shoutouts = 'double';
elseif (strlen($login_user_team_high5s) == 3):
    $shoutouts = 'three';
elseif (strlen($login_user_team_high5s) == 4):
    $shoutouts = 'four';
endif;
//Total Actions Digits
$dgt_1 = 0;
$dgt_2 = 0;
$dgt_3 = 0;
$dgt_4 = 0;
$dgt_5 = 0;

$dgt_1 = $login_user_team_actions % 10;
$rslt_1 = $login_user_team_actions / 10;

$dgt_2 = $rslt_1 % 10;
$rslt_2 = $rslt_1 / 10;

$dgt_3 = $rslt_2 % 10;
$rslt_3 = $rslt_2 / 10;

$dgt_4 = $rslt_3 % 10;
$rslt_4 = $rslt_3 / 10;

$dgt_5 = $rslt_4 % 10;
$rslt_5 = $rslt_4 / 10;
//End
?>
<?php $this->registerCssFile($baseurl . '/css/leaderboard.css'); ?>
<?php $this->registerCssFile($baseurl . '/css/seeall.css'); ?>
<?php $this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php $this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<div class="site-index">
    <div class="content main-dashboard-banners">
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <div class="top-performer-banner">
                        <div class="top-performer-banner-graph">
                            <div class="top-performer-banner-title-main">
                                <div class="performer-title">What You've Accomplished as a Team</div>
                            </div>
                            <div class="top-performer-graph">
                                <div class="outer_performer_graph">
                                    <div class="outer_leaderboard action1">            
                                        <div class="first leaderboard_actions <?= $wins; ?>"><?= $login_user_team_wins; ?></div>
                                        <div class="leaderboard_img1">
                                            <span>Voice Matters</span>
                                            <img src="../images/wins.png">
                                        </div>
                                    </div>
                                    <div class="outer_leaderboard action2">
                                        <div class="second leaderboard_actions <?= $core; ?>"><?= $login_user_team_core_values; ?></div>
                                        <div class="leaderboard_img2">
                                            <span>Today's Lesson</span>
                                            <img src="../images/core_values.png">
                                        </div>
                                    </div>     
                                    <div class="outer_leaderboard action3">
                                        <div class="third leaderboard_actions <?= $shoutouts; ?>"><?= $login_user_team_high5s; ?></div>
                                        <div class="leaderboard_img3">
                                            <span>Join The Conversation</span>
                                            <img src="../images/high_fives.png">
                                        </div>
                                    </div>
                                </div>
                                <div class="top-performer-banner-elevation">
                                    <div class="leaderboard-elevation-number">
                                        <div class="elevating-count">
                                            <div class="top-performer-mood-elevating-number">
                                                <div class="first-number elevation-number"><?= $dgt_5; ?></div>
                                                <div class="second-number elevation-number"><?= $dgt_4; ?></div>
                                                <div class="third-number elevation-number"><?= $dgt_3; ?></div>
                                                <div class="four-number elevation-number"><?= $dgt_2; ?></div>
                                                <div class="five-number elevation-number"><?= $dgt_1; ?></div>
                                            </div>
                                            <div class="top-performer-elevation-title">Total Intentional Leadership Actions</div>
                                        </div>

                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=row>
            <div class="dashboard-title leaderboard-title">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/intentionalleadership/dashboard">&lt; Dashboard</a></div>   
            </div>
        </div>
        <div class=row>
            <?php
            foreach ($teams_points_obj_arr as $team_id => $team_arr):
                $team_obj = \backend\models\PilotCompanyTeams::find()->where(['company_id' => $comp_id, 'id' => $team_id])->one();
                ?>
                <div class="col-md-4 col-sm-4 outer_left">
                    <div class="">
                        <div class=s_points>
                            <div class="bg-color height-fix">
                                <h1 class="heading hh new"><?= $team_obj->team_name; ?></h1>
                                <div class=content1>
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
                                            <?php
                                            $rank = 0;
                                            foreach ($team_arr as $user_points_obj):
                                                $user_points = $user_points_obj->total_points;

                                                if ($user_points > 0):
                                                    $rank++;
                                                    if ($rank % 2 == 0):
                                                        $row_cls = 'even';
                                                    else:
                                                        $row_cls = 'odd';
                                                    endif;

                                                    //Get User Features
                                                    $uid = $user_points_obj->user_id;
                                                    $user_obj = \frontend\models\PilotFrontUser::findIdentity($uid);
                                                    $user_name = $user_obj->username;
                                                    // breake the user name after 25 character
                                                    $user_name = (strlen($user_name) > 20) ? substr($user_name, 0, 17) . '...' : $user_name;

                                                    if ($user_obj->profile_pic):
                                                        $user_imagePath = $baseurl . '/uploads/' . $user_obj->profile_pic;
                                                    else :
                                                        $user_imagePath = $baseurl . '/images/user_icon.png';
                                                    endif;
                                                    ?>
                                                    <tr class='<?= $row_cls; ?>'>
                                                        <td class=oned><?= $rank; ?></td>
                                                        <td class=twod> <img alt=people src="<?= $user_imagePath; ?>" height=50 width=50></td>
                                                        <td class=tn><?= $user_name; ?></td>
                                                        <td class=fourd><?= $user_points; ?></td>
                                                    </tr>
                                                    <?php
                                                endif;

                                            endforeach;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
</div>

<?php echo $this->render('prize_modal'); ?>