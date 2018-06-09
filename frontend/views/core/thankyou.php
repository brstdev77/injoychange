<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;

$this->title = 'Thank you | Appreciation Challenge';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/above.css');

$company_id = $_SESSION['company_id'];
$comp_name = $_SESSION['comp_name'];
$challenge_id = $_SESSION['challenge_id'];
$challengeName = $_SESSION['challengename'];

$company_id = Yii::$app->user->identity->company_id;
$completed_challenge = PilotCreateGame::find()->where(['id' => 230, 'status' => 2])->one();
if ($completed_challenge->thankyou_image) {
    $banner_name = 'http://root.injoychange.com/backend/web/img/game/thankyou_banner/' . $completed_challenge->thankyou_image;
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
                        <img class=main-banner src="<?php echo $banner_name; ?>" alt=banner height=392 width=1180 />
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
    .wlcm_msg p
    {
        font-size:23px;
        font-weight: bold;
    }
    .container
    {
        padding-top:15px !important;
    }
    ul li:nth-child(2){
        display: none;
    }
    .notification {
        display: none;
    }
</style>
