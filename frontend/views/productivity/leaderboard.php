<?php
/* @var $this yii\web\View */

$this->title = 'Leaderboard | Productivity Value';
$baseurl = Yii::$app->request->baseurl;

$comp_id = $game_obj->challenge_company_id;

$user_team_id = Yii::$app->user->identity->team_id;
$user_team_obj = \backend\models\PilotCompanyTeams::find()->where(['company_id' => $comp_id, 'id' => $user_team_id])->one();

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

<div class="site-index">
    <div class="content main-dashboard-banners">
        <!--<div class=container>-->
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <div class="top-performer-banner">
                        <div class="top-performer-banner-graph">
                            <div class="top-performer-banner-title-main">
                                <div class="performer-title">Top User Listing: Top Performer</div>
                            </div>
                            <div class="top-performer-graph">
                                <div class="top-performer-graph-bottom-border">
                                    <div class="teamleaderboard_graph_section">
                                        <div class="bolsa-graph-text-val">
                                            <div class="bolsa-val">14</div><div class="bolsa-name"><div class="bolsa-text">Bolsa</div></div>
                                        </div>
                                        <div class="cypress-graph-text-val"><div class="cypress-val">8</div><div class="cypress-name"><div class="cypress-text">Cypress</div></div></div>
                                        <div class="gardengrove-graph-text-val"><div class="gardengrove-val">3</div><div class="gardengrove-name"><div class="gardengrove-text">Garden Grove</div></div></div>
                                        <div class="lapalma-graph-text-val"><div class="lapalma-val">32</div><div class="lapalma-name"><div class="lapalma-text">La Palma</div></div></div>
                                        <div class="ontario-graph-text-val"><div class="ontario-val">35</div><div class="ontario-name"><div class="ontario-text">Ontario</div></div></div>
                                        <div class="santamaria-graph-text-val"><div class="santamaria-val">16</div><div class="santamaria-name"><div class="santamaria-text">Santa Maria</div></div></div>
                                    </div></div>
                                <div class="top-performer-banner-elevation">
                                    <div class="top-performer-elevation-title">Total Pounds Lost</div>
                                    <div class="leaderboard-elevation-number">
                                        <div class="elevating-count">
                                            <div class="top-performer-mood-elevating-number">
                                                <div class="first-number elevation-number"><?= $dgt_5; ?></div>
                                                <div class="second-number elevation-number"><?= $dgt_4; ?></div>
                                                <div class="third-number elevation-number"><?= $dgt_3; ?></div>
                                                <div class="four-number elevation-number"><?= $dgt_2; ?></div>
                                                <div class="five-number elevation-number"><?= $dgt_1; ?></div>
                                            </div>
                                        </div>
                                    </div></div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class=row>
            <div class="dashboard-title leaderboard-title">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning leaderboard-dashboard" href="<?= $baseurl; ?>/productivity/dashboard">&lt; Dashboard</a></div>   
            </div>
        </div>

        <!--</div>-->
        <!--<div class=container>-->
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
</div>

