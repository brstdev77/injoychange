<?php

use yii\helpers\Html;
use frontend\models\PilotFrontProductivityNotifications;

$baseurl = Yii::$app->request->baseurl;
//$baseurl = str_replace('/admin', '', $baseurl);
$action = Yii::$app->controller->action->id;
$new_notifs = PilotFrontProductivityNotifications::find()->where(['user_id' => Yii::$app->user->identity->id, 'notif_status' => 1])->all();
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
if (isset($_SESSION['company_logo'])):
  $company_logo = Yii::getAlias('@back_end') . '/img/uploads/' . $_SESSION['company_logo'];
else:
  $company_logo = $baseurl.'/images/logo.png';
endif;
?>
<header>
    <div id=top-header>
        <div class=container>
            <div class=row>
                <?php
                    if (Yii::$app->user->isGuest) {
                ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 left-logo"><div class=leftlogo><a href="/"><img alt=logo src="<?= $company_logo; ?>" height=81 width=318></a></div></div>
                <?php
                    }
                    else {
                 ?>
                      <div class="col-xs-4 col-sm-4 col-md-4 left-logo"><div class=leftlogo><a href="/<?= $_SESSION['challengename']?>/dashboard"><img alt=logo src="<?= $company_logo; ?>" height=81 width=318></a></div></div>      
                <?php } ?>
                <div class="col-xs-8 col-sm-8 col-md-8 right-info">
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
    if ($action == 'signup' || $action == 'login' || $action == 'index' || $action == 'leaderboard') {
        
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
                                </button>
                            </div>
                            <div id=collapse class="collapse navbar-collapse navbar-left">
                                <ul class="nav navbar-nav">
                                    <li><a href="<?= $baseurl; ?>/productivity/how-it-work">how it works</a></li>
                                    <li><a data-toggle="modal" href="#rules-prizes">Contest Rules/Prizes</a></li>
                                    <li><a href="<?= $baseurl; ?>/productivity/tech-support">Tech Support</a></li>
                                    <li><a href="smartphone" data-toggle="modal" data-modal-id="smartphone">SmartPhone</a></li>
<!--                                    <li><a href="<?= $baseurl; ?>/productivity/leaderboard">Leaderboard</a></li>-->
                                </ul>
                            </div>
                        </nav>
                        <?php if (!empty($notifs_bell)): ?>
                        <div class="notification bell">
                            <a href='javascript:void(0)'><img class=notification src="<?= $baseurl; ?>/images/notification1.png" alt=notification height=32 width=32 /></a>
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
<!--                                        <div class="model-footer">
                                             <div class=checkin-seeall><a href="<?= $baseurl; ?>/core/see-all" class="notification-count-message" style="color:black;text-decoration:none">See All</a></div>
                                        </div>										-->
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
