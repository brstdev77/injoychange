<?php

use yii\helpers\Html;
use frontend\models\PilotFrontAboveNotifications;
use backend\models\Company;

$company_logo = '';
$baseurl = Yii::$app->request->baseurl;
$action = Yii::$app->controller->action->id;
$new_notifs = PilotFrontAboveNotifications::find()->where(['user_id' => Yii::$app->user->identity->id, 'notif_status' => 1])->all();
$count_notifs = count($new_notifs);
if ($count_notifs == 0):
    $count_notifs = 'no';
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
                <div class="col-xs-4 col-sm-4 col-md-4 left-logo">
                    <div class=leftlogo>
                        <?php
                        if (Yii::$app->user->isGuest) {
                            ?>
                            <?php if (!empty($company_logo)) { ?>
                                <a href="/"><img alt=logo src="<?= Yii::getAlias('@back_end') . '/img/uploads/' . $company_logo; ?>" height=81 width=318></a><?php } ?>
                            <?php
                        } else {
                            $challenge_name = backend\models\PilotGameChallengeName::find()->where(['id' => Yii::$app->user->identity->challenge_id])->one();
                            $comp_id = Yii::$app->user->identity->company_id;
                            $company = backend\models\Company::find()->where(['id' => $comp_id])->one();
                            $company_logo = Yii::getAlias('@back_end') . '/img/uploads/' . $company->image;
                            ?>
                            <?php if (!empty($company_logo)) { ?>
                                <a href="/<?= $challenge_name->challenge_abbr_name; ?>/dashboard"><img alt=logo src="<?= $company_logo; ?>" height=81 width=318></a> <?php } ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 right-info">
                    <div class=header-right>
                        <?php
                        if (Yii::$app->user->isGuest) {
                            ?>
                            <!--<img src="<?= $baseurl; ?>/images/logo.png" height="81" width="318"/>-->
                            <?php
                        } else {
                            $comp_id = Yii::$app->user->identity->company_id;
                            $company = \backend\models\Company::find()->where(['id' => $comp_id])->one();
                            $company_code = str_replace(' ', '-', strtolower($company->company_name));
                            ?>
                            <ul class=header-options>
                                <li><a class=name_user><?php echo Yii::$app->user->identity->username; ?></a> </li>
                                <? if ($action !== 'privacy-policy' && $action !== 'terms-condition'): ?>
                                    <li>
                                        <?php echo Html::a('My Profile', '/my-profile'); ?>  
                                    </li>
                                <?php endif; ?>
                                <li><?php
                                    echo Html::beginForm(['site/logout'], 'post')
                                    . Html::submitButton(
                                            'Logout', ['class' => 'btn btn-link logout']
                                    )
                                    . Html::endForm()
                                    ?></li>
                            </ul>
                            <div class=user-image>
                                <?php
                                if (Yii::$app->user->identity->profile_pic) {
//                                    $user_image_explode = explode("frontend", $baseurl);
//                                    $image = $user_image_explode['0'];
//                                    $imagePath = $image . '/uploads/' . Yii::$app->user->identity->profile_pic;
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
    if ($action == 'index' ||
            $action == 'login' ||
            $action == 'signup' ||
            $action == 'request-password-reset' ||
            $action == 'leaderboard' ||
            $action == 'how-it-work' ||
            $action == 'reset-password' ||
            $action == 'privacy-policy' ||
            $action == 'terms-condition'
    ) {
        
    } else {
        ?>


        <div class=bottom-header>
            <div class=container>
                <div class=row>
                    <div class="col-md-12 xyz">
                        <nav class="navbar navbar-inverse">
                            <div class=navbar-header>
                                <button type=button class=navbar-toggle data-toggle=collapse data-target="#collapse">
                                    <span class=sr-only>Toggle navigation</span>
                                    <span class=icon-bar></span>
                                    <span class=icon-bar></span>
                                    <span class=icon-bar></span>
                                </button>
                            </div>
                            <div id=collapse class="collapse navbar-collapse navbar-left">
                                <ul class="nav navbar-nav">
                                    <li><a href="<?= $baseurl; ?>/above/how-it-work">how it works</a></li>
                                    <li><a href="#">Contest Rules/Prizes</a></li>
                                    <li><a href="#">Tech Support</a></li>
                                    <li><a href="#">SmartPhone</a></li>
                                    <li><a href="<?= $baseurl; ?>/above/leaderboard">Leaderboards</a></li>
                                </ul>
                            </div>
                        </nav>
                        <div class="notification bell">
                            <a href='javascript:void(0)'><img class=notification src="<?= $baseurl; ?>/images/notification.png" alt=notification height=32 width=32 /></a>
                        </div>
                        <div style="display: none;" class="notification-bar-popup">       
                            <div class="notification-bar-modal-open">    
                                <div class="notification-bar-modal-dialog">     
                                    <div class="modal-content bg-custom">     
                                        <div class="modal-header">            
                                            <div class="notification-count-message">         
                                                You have <?= $count_notifs; ?> new notfications      
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
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</header>



