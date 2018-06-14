<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;

$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/above.css');

$company_id = Yii::$app->user->identity->company_id;
//Fetch the Most Recent Upcoming Challenge
$upcoming_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $company_id, 'status' => 0])
    ->orderBy(['challenge_start_date' => SORT_ASC])
    ->one();
//Upcoming Challenge for Company
$upcoming_challenge_id = $upcoming_challenge->challenge_id;
$challenge_obj = PilotGameChallengeName::find()->where(['id' => $upcoming_challenge_id])->one();
$upcoming_challenge_name = $challenge_obj->challenge_name;
$upcoming_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
$this->title = ucwords($upcoming_challenge_name) . ' | ' . $company_name;
$banner_name = 'banner_' . $upcoming_challenge_abbr_name . '.png';
$welcome_msg = 'Welcome to ' . ucwords($upcoming_challenge_name) . '!';
$current_date = date('Y-m-d');
$challenge_reg_date = date('Y-m-d', $upcoming_challenge->challenge_registration_date);
$challenge_start_date = date('F d', $upcoming_challenge->challenge_start_date);
$challenge_end_date = date('F d, Y', $upcoming_challenge->challenge_end_date);
$challenge_start_date_ordinal = date('S', $upcoming_challenge->challenge_start_date);
$challenge_end_date_ordinal = date('S', $upcoming_challenge->challenge_end_date);

if (!$upcoming_challenge->banner_image) {
    $banner_name = 'http://root.injoychange.com/backend/web/image/banner' . $upcoming_challenge_name . '.png';
} else {
    $banner_name = 'http://root.injoychange.com/backend/web/img/game/welcome_banner/' . $upcoming_challenge->banner_image;
}
?>

<div class="site-index welcome">
    <div class="content main-dashboard-banners">
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <div class="banner_wlcm">
                        <img class=main-banner src="<?= $banner_name; ?>" alt=banner height=392 width=1180 />
                    </div>
                </div>
                <div class="wlcm_msg">
                    <div class="wlcm"><?= $welcome_msg ?></div>
                    <!--                    <div class="game_dates">
                                            <span class="str_dt"><?= $challenge_start_date; ?></span>
                                            -
                                            <span class="end_dt"> <?= $challenge_end_date; ?></span>
                                        </div>-->
                    <div class="suc_reg">You have successfully registered.</div>
                    <div class="chl_strt">This Challenge officially starts on <?= $challenge_start_date; ?><sup><?= $challenge_start_date_ordinal; ?></sup>, so get ready to rock it! </div>
                    <div class="grat">Thanks for all you do to make our company great!</div>
                    <div class="cr_tm">Your At Our Core Leadership Team</div>
                    <div class="beg">The Journey Continues!</div>
                </div>
            </div>
        </div>

    </div>
</div>
