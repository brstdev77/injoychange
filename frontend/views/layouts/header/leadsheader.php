<?php

use yii\helpers\Html;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;
use frontend\models\PilotFrontLeadsNotifications;
use frontend\models\PilotFrontLeadsRating;
use backend\models\Company;
use kartik\rating\StarRating;

$company_logo = '';
$stars = 0;
$baseurl = Yii::$app->request->baseurl;
//$baseurl = str_replace('/admin', '', $baseurl);
$action = Yii::$app->controller->action->id;
$challenge_id = Yii::$app->user->identity->challenge_id;
$company_id = Yii::$app->user->identity->company_id;
$game_obj = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $company_id, 'status' => 1])->one();
$feature_array = explode(',', $game_obj->features);
$challenge1 = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
$challenge_name = $challenge1->challenge_abbr_name;
$challenge_abr = ucfirst($challenge1->challenge_abbr_name);
$model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
$total_points_data = $model_scorepoints::find()->where(['user_id' => Yii::$app->user->identity->id,'challenge_id' => $game_obj->id])->one();
if($challenge_id == 6): 
$value1 = $total_points_data->total_points / 575;
endif;
$valuearray = explode('.', $value1);
$stars = $valuearray[0];
if ($stars >= 1):
    $first = $baseurl . '/images/star1.png';
else:
    $first = $baseurl . '/images/star1_empty.png';
endif;
if ($stars >= 2):
    $second = $baseurl . '/images/star2.png';
else:
    $second = $baseurl . '/images/star2_empty.png';
endif;
if ($stars >= 3):
    $third = $baseurl . '/images/star3.png';
else:
    $third = $baseurl . '/images/star3_empty.png';
endif;
if ($stars >= 4):
    $fourth = $baseurl . '/images/star4.png';
else:
    $fourth = $baseurl . '/images/star4_empty.png';
endif;
$new_notifs = PilotFrontLeadsNotifications::find()->where(['user_id' => Yii::$app->user->identity->id, 'notif_status' => 1])->all();
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

$company = Company::find()->where(['company_name' => $check_comp])->one();
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
                    <div class="col-xs-4 col-sm-4 col-md-4 left-logo"><div class=leftlogo><?php if (!empty($company_logo)) { ?><a href="/<?= $challenge_name; ?>/dashboard"><img alt=logo src="<?= Yii::getAlias('@back_end') . '/img/uploads/' . $company_logo; ?>" height=81 width=318></a><?php } ?></div></div>      
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
                                        <?php
                                        echo Html::a('My Profile', '/my-profile');
                                        ?>  
                                    </li>
                                    <li><?php
                                        echo Html::beginForm(['site/logout'], 'post')
                                        . Html::submitButton(
                                                'Logout', ['class' => 'btn btn-link logout']
                                        )
                                        . Html::endForm()
                                        ?></li>
                                    <?php// if (in_array("10", $feature_array)): ?>
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
                                    <?php //endif; ?>
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
                                        <li><a href="<?= $baseurl; ?>/leads/how-it-work">how it works</a></li>
                                        <li><a data-toggle="modal" href="#rules-prizes">Contest Rules/Prizes</a></li>
                                        <li><a href="<?= $baseurl; ?>/leads/tech-support">Tech Support</a></li>
                                        <li><a href="smartphone" data-toggle="modal" data-modal-id="smartphone">SmartPhone</a></li>
                                        <li><a href="<?= $baseurl; ?>/leads/leaderboard">Leaderboard</a></li>
                                    </ul>
                                </div>
                            </nav>
                            <?php if (!empty($notifs_bell)): ?>
                                <div class="notification bell">
                                    <a href='javascript:void(0)'><img class=notification src="<?= $baseurl; ?>/images/leadsbell.png" alt=notification height=32 width=32 /></a>
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
                                                        <img width="16" height="16" src="../images/ajax-loader-leads.gif" alt="loader">       
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
