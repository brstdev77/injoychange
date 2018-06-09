<?php

use yii\helpers\Html;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;
use frontend\models\PilotFrontCoreNotifications;
use frontend\models\PilotFrontCoreRating;
use frontend\models\PilotFrontCoreDailyinspiration;
use frontend\models\PilotFrontCoreLeadershipcorner;
use frontend\models\PilotFrontCoreWeeklychallenge;
use frontend\models\PilotFrontCoreShareawin;
use frontend\models\PilotFrontCoreHighfive;
use frontend\models\PilotFrontCoreHighfiveSearch;
use frontend\models\PilotFrontCoreCheckin;
use backend\models\Company;
use frontend\models\PilotFrontUser;
use kartik\rating\StarRating;

$company_logo = '';
$baseurl = Yii::$app->request->baseurl;
//$baseurl = str_replace('/admin', '', $baseurl);
$action = Yii::$app->controller->action->id;
$challenge_id = Yii::$app->user->identity->challenge_id;
$company_id = Yii::$app->user->identity->company_id;
$user_id = Yii::$app->user->identity->id;
$game_obj = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $company_id, 'status' => 1])->one();
$game_id = $game_obj->id;
$feature_array = explode(',', $game_obj->features);
$challenge1 = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
$challenge_name = $challenge1->challenge_abbr_name;
$challenge_abr = ucfirst($challenge1->challenge_abbr_name);

$week_no = PilotFrontUser::getGameWeek($game_obj);
//$model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
//$total_points_data = $model_scorepoints::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
//$value1 = $total_points_data->total_points / 545;
//$valuearray = explode('.', $value1);
//$stars = $valuearray[0];
if (in_array(11, $feature_array)):
    $sub_Query1 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'week_no' => 1, 'challenge_id' => $game_id])->select('linked_feature_id');
    $Query1 = PilotFrontCoreHighfive::find()->where(['not in', 'id', $sub_Query1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'week_no' => 1])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $first_entries_points = $Query1->count();
    $subQuery2 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id, 'user_id' => $user_id])->select('linked_feature_id');
    $query2 = PilotFrontCoreHighfive::find()->where(['in', 'id', $subQuery2])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['week_no' => 1])->andWhere(['user_id' => $user_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $first_highfiveImage1 = $query2->count();
endif;
$firstweek_daily = PilotFrontCoreDailyinspiration::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 1])->count();
$firstweek_leadership = PilotFrontCoreLeadershipcorner::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 1])->count();
$firstweek_shareawin = PilotFrontCoreShareawin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 1])->count();
$firstweek_weekly = PilotFrontCoreWeeklychallenge::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 1])->count();
$firstweek_corevalue = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 1, 'label' => 'core_values_popup'])->count();
$firstweek_checkin = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 1])->andWhere(['!=', 'label', 'core_values_popup'])->count();


if (in_array(11, $feature_array)):
    $sub_Query1 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'week_no' => 2, 'challenge_id' => $game_id])->select('linked_feature_id');
    $Query1 = PilotFrontCoreHighfive::find()->where(['not in', 'id', $sub_Query1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'week_no' => 2])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $second_entries_points = $Query1->count();
    $subQuery2 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
    $query2 = PilotFrontCoreHighfive::find()->where(['in', 'id', $subQuery2])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['week_no' => 2])->andWhere(['user_id' => $user_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $second_highfiveImage1 = $query2->count();
endif;
$secondweek_daily = PilotFrontCoreDailyinspiration::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 2])->count();
$secondweek_leadership = PilotFrontCoreLeadershipcorner::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 2])->count();
$secondweek_shareawin = PilotFrontCoreShareawin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 2])->count();
$secondweek_weekly = PilotFrontCoreWeeklychallenge::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 2])->count();
$secondweek_corevalue = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 2, 'label' => 'core_values_popup'])->count();
$secondweek_checkin = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 2])->andWhere(['!=', 'label', 'core_values_popup'])->count();


if (in_array(11, $feature_array)):
    $sub_Query1 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'week_no' => 3, 'challenge_id' => $game_id])->select('linked_feature_id');
    $Query1 = PilotFrontCoreHighfive::find()->where(['not in', 'id', $sub_Query1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'week_no' => 3])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $third_entries_points = $Query1->count();
    $subQuery2 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
    $query2 = PilotFrontCoreHighfive::find()->where(['in', 'id', $subQuery2])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['week_no' => 3])->andWhere(['user_id' => $user_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $third_highfiveImage1 = $query2->count();
endif;
$thirdweek_daily = PilotFrontCoreDailyinspiration::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 3])->count();
$thirdweek_leadership = PilotFrontCoreLeadershipcorner::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 3])->count();
$thirdweek_shareawin = PilotFrontCoreShareawin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 3])->count();
$thirdweek_weekly = PilotFrontCoreWeeklychallenge::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 3])->count();
$thirdweek_corevalue = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 3, 'label' => 'core_values_popup'])->count();
$thirdweek_checkin = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 3])->andWhere(['!=', 'label', 'core_values_popup'])->count();

if (in_array(11, $feature_array)):
    $sub_Query1 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'week_no' => 4, 'challenge_id' => $game_id])->select('linked_feature_id');
    $Query1 = PilotFrontCoreHighfive::find()->where(['not in', 'id', $sub_Query1])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['user_id' => $user_id, 'week_no' => 4])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $fourth_entries_points = $Query1->count();
    $subQuery2 = PilotFrontCoreHighfive::find()->where(['game_id' => $challenge_id, 'company_id' => $company_id, 'feature_label' => 'highfiveCommentImage', 'challenge_id' => $game_id])->select('linked_feature_id');
    $query2 = PilotFrontCoreHighfive::find()->where(['in', 'id', $subQuery2])->andWhere(['=', 'feature_label', 'highfiveComment'])->andWhere(['week_no' => 4])->andWhere(['user_id' => $user_id])->orderBy(['created' => SORT_DESC, 'id' => SORT_DESC]);
    $fourth_highfiveImage1 = $query2->count();
endif;
$fourthweek_daily = PilotFrontCoreDailyinspiration::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 4])->count();
$fourthweek_leadership = PilotFrontCoreLeadershipcorner::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 4])->count();
$fourthweek_shareawin = PilotFrontCoreShareawin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 4])->count();
$fourthweek_weekly = PilotFrontCoreWeeklychallenge::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 4])->count();
$fourthweek_corevalue = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 4, 'label' => 'core_values_popup'])->count();
$fourthweek_checkin = PilotFrontCoreCheckin::find()->where(['user_id' => Yii::$app->user->identity->id, 'week_no' => 4])->andWhere(['!=', 'label', 'core_values_popup'])->count();

if ($week <= 2):
    if ($first_entries_points >= 15 && $first_highfiveImage1 >= 1 && $firstweek_daily >= 5 && $firstweek_leadership >= 3 && $firstweek_weekly >= 1 && $firstweek_checkin >= 10 && $firstweek_corevalue >= 5 && $firstweek_shareawin >= 5):
        $first = $baseurl . '/images/star1.png';
    else:
        $first = $baseurl . '/images/star1_empty.png';
    endif;
endif;
if ($week <= 3):
    if ($second_entries_points >= 15 && $second_highfiveImage1 >= 1 && $secondweek_daily >= 5 && $secondweek_leadership >= 3 && $secondweek_weekly >= 1 && $secondweek_checkin >= 10 && $secondweek_corevalue >= 5 && $secondweek_shareawin >= 5):
        $second = $baseurl . '/images/star2.png';
    else:
        $second = $baseurl . '/images/star2_empty.png';
    endif;
endif;
if ($week <= 4):
    if ($third_entries_points >= 15 && $third_highfiveImage1 >= 1 && $thirdweek_daily >= 5 && $thirdweek_leadership >= 3 && $thirdweek_weekly >= 1 && $thirdweek_checkin >= 10 && $thirdweek_corevalue >= 5 && $thirdweek_shareawin >= 5):
        $third = $baseurl . '/images/star3.png';
    else:
        $third = $baseurl . '/images/star3_empty.png';
    endif;
endif;
if ($fourth_entries_points >= 15 && $fourth_highfiveImage1 >= 1 && $fourthweek_daily >= 5 && $fourthweek_leadership >= 3 && $fourthweek_weekly >= 1 && $fourthweek_checkin >= 10 && $fourthweek_corevalue >= 5 && $fourthweek_shareawin >= 5):
    $fourth = $baseurl . '/images/star4.png';
else:
    $fourth = $baseurl . '/images/star4_empty.png';
endif;



//if ($stars >= 1):
//    $first = $baseurl . '/images/star1.png';
//else:
//    $first = $baseurl . '/images/star1_empty.png';
//endif;
//if ($stars >= 2):
//    $second = $baseurl . '/images/star2.png';
//else:
//    $second = $baseurl . '/images/star2_empty.png';
//endif;
//if ($stars >= 3):
//    $third = $baseurl . '/images/star3.png';
//else:
//    $third = $baseurl . '/images/star3_empty.png';
//endif;
//if ($stars >= 4):
//    $fourth = $baseurl . '/images/star4.png';
//else:
//    $fourth = $baseurl . '/images/star4_empty.png';
//endif;
$new_notifs = PilotFrontCoreNotifications::find()->where(['user_id' => Yii::$app->user->identity->id, 'notif_status' => 1])->all();
$count_notifs = count($new_notifs);
if ($count_notifs == 0):
    $count_notifs = 'no';
endif;
//Bell Feature Enable Disable
$notifs_bell = '';
$enable_bell = 'no';
if (isset($_SESSION['core_Template']['features'])):
    $session_features = $_SESSION['core_Template']['features'];
    foreach ($session_features as $data):
        if ($data['feature_name'] == 'Notification Bell')
            $notifs_bell = 'enable';
        $enable_bell = 'yes';
    endforeach;
endif;
$curentUrl = Yii::$app->request->hostInfo;
$url = parse_url($curentUrl, PHP_URL_HOST);
$explodedUrl = explode('.', $url);
$comp_check = $explodedUrl[0];
$check_comp = str_replace(' ', '-', $comp_check);

$company = Company::find()->where(['id' => $company_id])->one();
if (!empty($company)):
    $company_logo = $company->image;
elseif (isset($_SESSION['company_logo'])):
    $company_logo = $_SESSION['company_logo'];
endif;
?>
<header>
    <div id=top-header>
        <div class=container>
            <div class=row>
                <?php
                if (Yii::$app->user->isGuest) {
                    ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 left-logo"><div class=leftlogo><?php if (!empty($company_logo)) { ?><a href="/"><img alt=logo src="<?= Yii::getAlias('@back_end') . '/img/uploads/' . $company_logo; ?>" height=81 width=318></a> <?php } ?></div></div>
                    <?php
                } else {
                    ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 left-logo"><div class=leftlogo><?php if (!empty($company_logo)) { ?><a href="/core/dashboard"><img alt=logo src="<?= Yii::getAlias('@back_end') . '/img/uploads/' . $company_logo; ?>" height=81 width=318></a><?php } ?></div></div>      
                <?php } ?>
                <?php if (in_array("10", $feature_array)): ?>
                    <div class="col-xs-8 col-sm-8 col-md-8 right-info">
                    <?php else: ?>
                        <div class="col-xs-8 col-sm-8 col-md-8 right-info">
                        <?php endif; ?>
                        <div class=header-right>
                            <?php
                            if (Yii::$app->user->isGuest) {
                                ?>

                                <?php
                            } else {
                                $comp_id = Yii::$app->user->identity->company_id;
                                $company = \backend\models\Company::find()->where(['id' => $comp_id])->one();
                                $company_code = str_replace(' ', '-', strtolower($company->company_name));
                                ?>
                                <ul class=header-options>
                                    <li><a class=name_user><?php echo Yii::$app->user->identity->username; ?></a> </li>
                                    <li>

                                        <?php echo Html::a('My Profile', '/my-profile'); ?>

                                    </li>
                                    <li><?php
                                        echo Html::beginForm(['site/logout'], 'post')
                                        . Html::submitButton(
                                                'Logout', ['class' => 'btn btn-link logout']
                                        )
                                        . Html::endForm()
                                        ?></li>
                                    <?php if ($action != 'welcome' && $action != 'thankyou'): ?>
                                        <li> 
                                            <div class="points-images" id="star_integrity">
                                                <a href="#" class='hastooltip' data-toggle="tooltip1" title="A new star will turn gold after each week that you have achieved a perfect score." style="float:right;">
                                                    <img alt="Image" src="<?= $fourth; ?>" class="">
                                                    <img alt="Image" src="<?= $third; ?>" class="">
                                                    <img alt="Image" src="<?= $second; ?>" class="">
                                                    <img alt="Image" src="<?= $first; ?>" class="">
                                                    <div class="week">WEEK:</div>
                                                </a>
                                            </div> 
                                        </li>
                                    <?php endif; ?>
                                </ul>
                                <div class=user-image>
                                    <?php
                                    if (Yii::$app->user->identity->profile_pic) {
                                        $imagePath = $baseurl . '/uploads/' . Yii::$app->user->identity->profile_pic;
                                    } else {
                                        $imagePath = $baseurl . '/images/user_icon.png';
                                    }
                                    ?> 
                                    <img src="<?= $imagePath; ?>" class="img-circle" alt="User Image">
                                </div>
                                <?php
                            }
                            ?>


                        </div>
                    </div>
                </div></div>
        </div>

        <?php
        if ($action == 'signup' || $action == 'login' || $action == 'welcome' || $action == 'index') {
            
        } else {
            ?>


            <div class=bottom-header>
                <div class=container>
                    <div class=row>
                        <div class=col-md-12>
                            <?php if (!empty($notifs_bell)): ?>
                                <?php if ($count_notifs != 'no'): ?>
                                    <div class="notif_count_top">
                                        <span><?= $count_notifs; ?></span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            <nav class="navbar navbar-inverse">
                                <div class=navbar-header>
                                    <button type=button class=navbar-toggle data-toggle=collapse data-target="#collapse">
                                        <span class=sr-only>Toggle navigation</span>
                                        <span class=icon-bar></span>
                                        <span class=icon-bar></span>
                                        <span class=icon-bar></span>
                                        <span class="toggler"> Menu</span>
                                    </button>
                                </div>
                                <div id=collapse class="collapse navbar-collapse navbar-left">
                                    <ul class="nav navbar-nav">
                                        <li><a href="<?= $baseurl; ?>/core/how-it-work">how it works</a></li>
                                        <li><a data-toggle="modal" href="#rules-prizes">Contest Rules/Prizes</a></li>
                                        <li><a href="<?= $baseurl; ?>/core/tech-support">Tech Support</a></li>
                                        <li><a href="smartphone" data-toggle="modal" data-modal-id="smartphone">SmartPhone</a></li>
                                        <li><a href="<?= $baseurl; ?>/core/leaderboard">Leaderboard</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <?php if (!empty($notifs_bell)): ?>
                                <div class="notification bell">
                                    <a href='javascript:void(0)'><img class=notification src="<?= $baseurl; ?>/images/notification.png" alt=notification height=32 width=32 /></a>
                                </div>
                                <div style="display: none;" class="notification-bar-popup">       
                                    <div class="notification-bar-modal-open">    
                                        <div class="notification-bar-modal-dialog">     
                                            <div class="modal-content bg-custom">     
                                                <div class="modal-header">            
                                                    <div class="notification-count-message">         
                                                        You have <span><?= $count_notifs; ?></span> new notfications      
                                                    </div>          
                                                </div>
                                                <div class="modal-body">       
                                                    <div class="loader-notif" style="display: block;">
                                                        <img width="16" height="16" src="../images/ajax-loader.gif" alt="loader">       
                                                    </div>                    
                                                    <div class="notification-bar-messages"> 
                                                        <div class="share-win-notification">
                                                        </div>
                                                    </div>
                                                </div>  									
                                            </div>         
                                        </div>          
                                    </div>      
                                </div>
                            <?php endif; ?>
                            <input type="hidden" value="<?= $enable_bell; ?>" id="notifs_bell_feature"/>
                        </div></div></div>
            </div>
            <?php
        }
        ?>
</header>
