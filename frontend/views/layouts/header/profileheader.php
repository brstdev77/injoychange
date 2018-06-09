<?php

use yii\helpers\Html;
use frontend\models\PilotFrontCoreNotifications;
use frontend\models\PilotFrontTestTotalPoints;
use backend\models\PilotCreateGame;
use backend\models\PilotGameChallengeName;
use backend\models\Company;
use kartik\rating\StarRating;

$company_logo = '';
$color = '';
$baseurl = Yii::$app->request->baseurl;
$challenge_id = Yii::$app->user->identity->challenge_id;
$company_id = Yii::$app->user->identity->company_id;
$game_obj = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $company_id, 'status' => 1])->one();
$feature_array = explode(',', $game_obj->features);
$challenge1 = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
$challenge_name = $challenge1->challenge_abbr_name;
$challenge_abr = ucfirst($challenge1->challenge_abbr_name);
$model_scorepoints = '\frontend\\models\\PilotFront' . $challenge_abr . 'TotalPoints';
$total_points_data = $model_scorepoints::find()->where(['user_id' => Yii::$app->user->identity->id])->one();
$value1 = $total_points_data->total_points / 575;
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
if ($challenge_id == 6):
    $color = '#cc1c1c';
    $id = 'leads';
endif;
?>
<header>
    <div id=top-header>
        <div class=container>
            <div class=row>
                <?php
                if (Yii::$app->user->isGuest) {
                    ?>
                    <div class="col-xs-4 col-sm-4 col-md-4 left-logo"><div class=leftlogo><?php if (!empty($company_logo)) { ?><a href="/"><img alt=logo src="<?= Yii::getAlias('@back_end') . '/img/uploads/' . $company_logo; ?>" height=81 width=318></a><?php } ?></div></div>
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
                </div>
            </div>
        </div>

        <?php
        if ($action == 'signup' || $action == 'login' || $action == 'welcome' || $action == 'index') {
            
        } else {
            $user_company_id = Yii::$app->user->identity->company_id;
            /* Profile Page as per the Challenge */
            $active_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $user_company_id, 'status' => 1])->one();
            if (!empty($active_challenge)) {
                ?>
                <div class=bottom-header>
                    <div class=container>
                        <div class=row>
                            <div class=col-md-12>
                                <nav class="navbar navbar-inverse">
                                    <div class=navbar-header>
                                        <button type=button class=navbar-toggle data-toggle=collapse data-target="#collapse" style="background:<?= $color; ?>" id="<?= $id; ?>">
                                            <span class=sr-only>Toggle navigation</span>
                                            <span class=icon-bar></span>
                                            <span class=icon-bar></span>
                                            <span class=icon-bar></span>
                                            <span class="toggler"> Menu</span>
                                        </button>
                                    </div>
                                    <div id=collapse class="collapse navbar-collapse navbar-left">
                                        <ul class="nav navbar-nav">
                                            <li><a href="<?= $baseurl; ?>/<?= $challenge_abbr_name; ?>/how-it-work">how it works</a></li>
                                            <li><a data-toggle="modal" href="#rules-prizes">Contest Rules/Prizes</a></li>
                                            <li><a href="<?= $baseurl; ?>/<?= $challenge_abbr_name; ?>/tech-support">Tech Support</a></li>
                                            <li><a href="/<?= $challenge_abbr_name; ?>/smartphone" data-toggle="modal" data-modal-id="smartphone">SmartPhone</a></li>
                                            <?php
                                            if ($challenge_abbr_name != 'productivity') {
                                                ?>
                                                <li><a href="<?= $baseurl; ?>/<?= $challenge_abbr_name; ?>/leaderboard">Leaderboards</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
</header>
