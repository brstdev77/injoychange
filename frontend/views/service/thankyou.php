<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;

$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/above.css');

$company_id = $comp_id = Yii::$app->user->identity->company_id;;
$comp_name = $_SESSION['comp_name'];
$challenge_id = $comp_id = Yii::$app->user->identity->challenge_id;;
$challengeName = $_SESSION['challengename'];
$this->title = 'Thank You';
$completed_challenge = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $company_id, 'status' => 2])->one();
if (empty($completed_challenge->thankyou_image)) {
    $banner_name = 'http://root.injoychange.com/backend/web/image/banner' . $challengeName . '.png';
} else {
    $banner_name = 'http://root.injoychange.com/backend/web/img/game/thankyou_banner/' . $completed_challenge->thankyou_image;
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
                    <p><?= $completed_challenge->thankyou_msg; ?></p>
                </div>
            </div> 
        </div>

    </div>
</div>
<style>
    nav
    {
        display:none;
    }
    p
    {
        font-size:23px;
        font-weight:bold;
    }
    .container
    {
        padding-top:15px !important;
    }
    ul li:nth-child(2)
    {
        display:none;
    }
    .points-images{
        display:none;
    }
</style>
