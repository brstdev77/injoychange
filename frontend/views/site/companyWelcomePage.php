<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;
use backend\models\Company;

$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/above.css');
$curentUrl = Yii::$app->request->hostInfo;
$url = parse_url($curentUrl, PHP_URL_HOST);
$explodedUrl = explode('.', $url);
$comp = $explodedUrl[0];
//$comp = str_replace(' ', '-', $comp_check);
$companies = Company::find()->all();
if (!empty($companies)):
    foreach ($companies as $company):
        $company_name = $company->company_name;
        $company_code = str_replace(' ', '-', strtolower($company_name));
        if ($company_code == $comp):
            $company_id = $company->id;
            $comp_name = $company->company_name;
            $company_logo = $company->image;
        endif;
    endforeach;
endif;
if ($comp_name == 'Toyota'):
    $color = '#e41515';
else:
    $color = '#F78408';
endif;
$start_msg = '';
//echo $company_id;
$game_obj = PilotCreateGame::find()->where(['challenge_company_id' => $company_id, 'status' => 2])->orderBy(['id' => SORT_DESC])->one();

if (!empty($game_obj)) {
    $banner_name = 'http://root.injoychange.com/backend/web/img/game/thankyou_banner/' . $game_obj->thankyou_image;
}
$active_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $company_id])->andWhere(['or', ['status' => 1], ['status' => 0]])->all();
//echo "<pre>";print_r($active_challenge);die;

if (!empty($active_challenge)):
    //Active Challenge for Company
    foreach ($active_challenge as $challenge):
        $active_challenge_id = $challenge->challenge_id;
        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $active_challenge_id])->one();

        $active_challenge_name = $challenge_obj->challenge_name;
        $challenge_abbr_name = $challenge_obj->challenge_abbr_name;
        $banner_name = 'http://root.injoychange.com/backend/web/img/game/welcome_banner/' . $challenge->banner_image;
        $this->title = $comp_name;
    endforeach;
    $welcome_msg = 'Welcome to the ' . $comp_name . ' Online Challenges!';
    $content = 'Select your Challenge:';
    $start_msg = 'LET THE GAMES BEGIN!';
else:
    $content = $game_obj->thankyou_msg;
    $welcome_msg = '';
    $links_reg_log = 'disable';
    $start_msg = '';
endif;
?>
<div class="site-index">
    <div class="content main-dashboard-banners">
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <img class=main-banner src="<?= $banner_name; ?>" alt=banner height=392 width=1180 />
                </div> 
            </div>
        </div>
        <div class=row>
            <div class=col-md-12>
                <?php if ($comp_name == 'avion'): 
                    $welcome_msg1 = 'Welcome to the 30-Day P.E.A.K. Influence Challenge!  Take your P.E.A.K. Influence training to the next level over the next 30 days as you put your learnings into action in a fun and interactive way.  Prepare to be inspired daily, acknowledge wins, connect with your colleagues and practice your Influencing skills in just a few minutes a day.Thank you for participating and let\'s have a great P.E.A.K. Influence Challenge!';
                    ?>
                    <h1 class="rtecenter"><strong style='color:<?= $color; ?>'><?= $welcome_msg1; ?></strong></h1>
                <?php else: ?>
                    <h1 class="rtecenter"><strong style='color:<?= $color; ?>'><?= $welcome_msg; ?></strong></h1>
                <?php endif; ?>
                <div class="home_page_text">
                    <?= $content; ?>
                </div>
                <?php //if ($links_reg_log != 'disable'):   ?>
                <div class=login-infor>
                    <?php
                    if (Yii::$app->user->isGuest):
                        ?>
                        <ul class="">
                            <?php
                            foreach ($active_challenge as $challenge) {
                                if ($challenge->challenge_id == '5') {
                                    ?>
                                    <li><a href="<?= $baseurl; ?>/core" class=name_user style='background:<?= $color; ?>'>CORE</a> </li>
                                <?php } if ($challenge->challenge_id == '3') { ?>
                                    <li><a href="<?= $baseurl; ?>/productivity" class=name_user style='background:<?= $color; ?>'>Productivity</a> </li>
                                <?php } if ($challenge->challenge_id == '2') { ?>
                                    <li><a href="<?= $baseurl; ?>/service" class=name_user style='background:<?= $color; ?>'>SERVICE</a> </li>
                                <?php } if ($challenge->challenge_id == '4') { ?>
                                    <li><a href="<?= $baseurl; ?>/leadership" class=name_user style='background:<?= $color; ?>'>LEADERSHIP</a> </li>
                                <?php } if ($challenge->challenge_id == '6') { ?>
                                    <li><a href="<?= $baseurl; ?>/leads" class=name_user style='background:<?= $color; ?>'>ABOVE AND BEYOND</a> </li>
                                <?php } if ($challenge->challenge_id == '1') { ?>
                                    <li><a href="<?= $baseurl; ?>/teamwork" class=name_user style='background:<?= $color; ?>'>TEAMWORK</a> </li>
                                <?php }if ($challenge->challenge_id == '7') {
                                    ?>
                                    <li><a href="<?= $baseurl; ?>/test" class=name_user style='background:<?= $color; ?>'>LEARNING MONTH</a> </li>
                                <?php }if ($challenge->challenge_id == '8') {
                                    ?>
                                    <li><a href="<?= $baseurl; ?>/customer" class="name_user customer_button">CUSTOMER SERVICE MONTH 1</a> </li>
                                    <?php
                                } if ($challenge->challenge_id == '9') {
                                    ?>
                                    <li><a href="<?= $baseurl; ?>/peak" class="name_user peak_button">P.E.A.K</a> </li>
                                    <?php
                                }
                                if ($challenge->challenge_id == '10') {
                                    ?>
                                    <li><a href="<?= $baseurl; ?>/intentional" class="name_user intentional_button">INTENTIONAL</a> </li>
                                    <?php
                                }
                                if ($challenge->challenge_id == '11') {
                                    ?>
                                    <li><a href="<?= $baseurl; ?>/intentionalleadership" class="name_user intentional_button">INTENTIONAL LEADERSHIP</a> </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <?php
                    else:
                        ?>
                        <ul class="">
                            <?php
                            foreach ($active_challenge as $challenge) {
                                if ($challenge->challenge_id == '5') {
                                    if (Yii::$app->user->identity->challenge_id == '5') {
                                        echo '<li><a href="' . $baseurl . '/core/dashboard" class=name_user style="background:' . $color . '">CORE</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class=name_user style="background:' . $color . '">CORE</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '3') {
                                    if (Yii::$app->user->identity->challenge_id == '3') {
                                        echo '<li><a href="' . $baseurl . '/productivity/dashboard" class=name_user style="background:' . $color . '">Productivity</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class=name_user style="background:' . $color . '">Productivity</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '4') {
                                    if (Yii::$app->user->identity->challenge_id == '4') {
                                        echo '<li><a href="' . $baseurl . '/leadership/dashboard" class=name_user style="background:' . $color . '">LEADERSHIP</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class=name_user style="background:' . $color . '">LEADERSHIP</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '2') {
                                    if (Yii::$app->user->identity->challenge_id == '2') {
                                        echo '<li><a href="' . $baseurl . '/service/dashboard" class=name_user>SERVICE</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class=name_user>SERVICE</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '1') {
                                    if (Yii::$app->user->identity->challenge_id == '2') {
                                        echo '<li><a href="' . $baseurl . '/teamwork/dashboard" class=name_user style="background:' . $color . '">TEAMWORK</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class=name_user style="background:' . $color . '">TEAMWORK</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '6') {
                                    if (Yii::$app->user->identity->challenge_id == '6') {
                                        echo '<li><a href="' . $baseurl . '/leads/dashboard" class=name_user style="background:' . $color . '">ABOVE AND BEYOND</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class=name_user style="background:' . $color . '">ABOVE AND BEYOND</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '7') {
                                    if (Yii::$app->user->identity->challenge_id == '6') {
                                        echo '<li><a href="' . $baseurl . '/learning/dashboard" class=name_user style="background:' . $color . '">LEARNING MONTH</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class=name_user style="background:' . $color . '">LEARNING MONTH</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '8') {
                                    if (Yii::$app->user->identity->challenge_id == '8') {
                                        echo '<li><a href="' . $baseurl . '/customer/dashboard" class="name_user customer_button" style="background:' . $color . '">CUSTOMER SERVICE MONTH 1</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class="name_user customer_button" style="background:' . $color . '">CUSTOMER SERVICE MONTH 1</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '9') {
                                    if (Yii::$app->user->identity->challenge_id == '9') {
                                        echo '<li><a href="' . $baseurl . '/peak/dashboard" class="name_user peak_button" style="background:' . $color . '">P.E.A.K</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class="name_user peak_button" style="background:' . $color . '">P.E.A.K</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '10') {
                                    if (Yii::$app->user->identity->challenge_id == '10') {
                                        echo '<li><a href="' . $baseurl . '/intentional/dashboard" class="name_user intentional_button" style="background:' . $color . '">INTENTIONAL</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class="name_user intentional_button" style="background:' . $color . '">INTENTIONAL</a> </li>';
                                    }
                                }
                                if ($challenge->challenge_id == '11') {
                                    if (Yii::$app->user->identity->challenge_id == '11') {
                                        echo '<li><a href="' . $baseurl . '/intentionalleadership/dashboard" class="name_user intentional_button" style="background:' . $color . '">INTENTIONAL LEADERSHIP</a> </li>';
                                    } else {
                                        echo '<li><a href="javascript:void(0)" class="name_user intentional_button" style="background:' . $color . '">INTENTIONAL LEADERSHIP</a> </li>';
                                    }
                                }
                            }
                            ?>
                        </ul>
                    <?php endif; ?>
                </div>
                <h3><?= $start_msg; ?></h3>
            </div>
        </div>
    </div>
</div>
<style>
    ul.header-options li:nth-child(2){
        display: none;
    }
</style>