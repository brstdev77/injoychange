<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;

$class = '';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/above.css');
$company_id = $_SESSION['company_id'];
$comp_name = $_SESSION['comp_name'];
$challenge_id = $_SESSION['challenge_id'];
$challengeName = $_SESSION['challengename'];
if ($challenge_id == 6):
    $color = '#cc1c1c';
endif;
if ($challenge_id == 8):
    $class = 'customer_button';
endif;
if ($challenge_id == 9):
    $class = 'peak_button';
    $color = '#0b1854';
endif;
if ($challenge_id == 10 || $challenge_id == 11):
    $class = 'intentional_button';
    $color = '#EE1C25';
endif;
if (!Yii::$app->user->isGuest):
    if (Yii::$app->user->identity->challenge_id != $challenge_id) {
        $comp = $_SESSION['company_name'];
        Yii::$app->response->redirect(['/']);
    }
    $challenge_obj = PilotGameChallengeName::find()->where(['id' => Yii::$app->user->identity->challenge_id])->one();
    $challenge_abbr_name = $challenge_obj->challenge_abbr_name;
endif;

$active_challenge = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $company_id, 'status' => 1])->one();

if (!empty($active_challenge)):
    $text1 = strtolower($active_challenge->banner_text_1);
    $text2 = strtolower($active_challenge->banner_text_2);
    $title = ucwords($text1 . ' ' . $text2);
    //Active Challenge for Company
    $active_challenge_id = $active_challenge->challenge_id;
    $challenge_obj = PilotGameChallengeName::find()->where(['id' => $active_challenge_id])->one();
    if (!empty($active_challenge->banner_text_1) && !empty($active_challenge->banner_text_2)) {
        $active_challenge_name = strtolower($active_challenge->banner_text_1) . ' ' . strtolower($active_challenge->banner_text_2);
    } else {
        $active_challenge_name = $challenge_obj->challenge_name;
    }
    $challenge_abbr_name = $challenge_obj->challenge_abbr_name;
    $this->title = $title;
    if ($active_challenge_id == '7'):
        $welcome_msg = ucwords($active_challenge_name) . '!';
    else:
        if ($active_challenge->challenge_id == 9):
            $banner = explode(' ', $active_challenge->banner_text_1);
            $active_challenge_name = $banner['0'] . ' ' . strtolower($banner['1']) . ' ' . strtolower($active_challenge->banner_text_2);
        endif;
        $welcome_msg = ucwords($active_challenge_name) . '!';
    endif;
    // $welcome_msg = 'Welcome to ' . ucwords($active_challenge_name) . '!';

    if (!$active_challenge->banner_image) {
        $banner_name = 'http://root.injoychange.com/backend/web/image/banner' . $challengeName . '.png';
    } else {
        $banner_name = 'http://root.injoychange.com/backend/web/img/game/welcome_banner/' . $active_challenge->banner_image;
    }

    $content = $active_challenge->welcome_msg;
    $links_register = '';
    $links_login = '';
else:
    //check upcomming challenge
    $upcomming_challenge = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $company_id, 'status' => 0])->one();
    if (!empty($upcomming_challenge)):
        $text1 = strtolower($upcomming_challenge->banner_text_1);
        $text2 = strtolower($upcomming_challenge->banner_text_2);
        $title = ucwords($text1 . ' ' . $text2);
        $upcomming_challenge_id = $upcomming_challenge->challenge_id;
        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $upcomming_challenge_id])->one();
        if (!empty($upcomming_challenge->banner_text_1) && !empty($upcomming_challenge->banner_text_2)) {
            $upcomming_challenge_name = strtolower($upcomming_challenge->banner_text_1) . ' ' . strtolower($upcomming_challenge->banner_text_2);
        } else {
            $upcomming_challenge_name = $challenge_obj->challenge_name;
        }

        $challenge_abbr_name = $challenge_obj->challenge_abbr_name;
        $this->title = $title;
        if ($upcomming_challenge_id == '7'):
            $welcome_msg = ucfirst($upcomming_challenge_name) . '!';
        else:

            if ($upcomming_challenge->challenge_id == 9):
                $banner = explode(' ', $upcomming_challenge->banner_text_1);
                $upcomming_challenge_name = $banner['0'] . ' ' . strtolower($banner['1']) . ' ' . strtolower($upcomming_challenge->banner_text_2);
            endif;
            $welcome_msg = 'Welcome to ' . ucwords($upcomming_challenge_name) . '!';
        endif;

        if (!$upcomming_challenge->banner_image) {
            $banner_name = 'http://root.injoychange.com/backend/web/image/banner' . $challengeName . '.png';
        } else {
            $banner_name = 'http://root.injoychange.com/backend/web/img/game/welcome_banner/' . $upcomming_challenge->banner_image;
        }

        $content = $upcomming_challenge->welcome_msg;

        if (strtotime(date('Y-m-d')) >= $upcomming_challenge->challenge_registration_date) {
            $links_register = '';
        } else {
            $links_register = 'disable';
        }
        if (strtotime(date('Y-m-d')) >= $upcomming_challenge->challenge_start_date) {
            $links_login = '';
        } else {
            $links_login = 'disable';
        }
    else:
        $completed_challenge = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $company_id, 'status' => 2])->one();
        $text1 = strtolower($completed_challenge->banner_text_1);
        $text2 = strtolower($completed_challenge->banner_text_2);
        $title = ucwords($text1 . ' ' . $text2);
        $upcomming_challenge_id = $completed_challenge->challenge_id;
        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $completed_challenge])->one();
        if (!empty($completed_challenge->banner_text_1) && !empty($completed_challenge->banner_text_2)) {
            $upcomming_challenge_name = strtolower($completed_challenge->banner_text_1) . ' ' . strtolower($completed_challenge->banner_text_2);
        } else {
            $upcomming_challenge_name = $challenge_obj->challenge_name;
        }

        $challenge_abbr_name = $challenge_obj->challenge_abbr_name;
        $this->title = $title;

        if (!$completed_challenge->banner_image) {
            $banner_name = 'http://root.injoychange.com/backend/web/image/banner' . $challengeName . '.png';
        } else {
            $banner_name = 'http://root.injoychange.com/backend/web/img/game/thankyou_banner/' . $completed_challenge->banner_image;
        }

        $content = $completed_challenge->thankyou_msg;

        if (strtotime(date('Y-m-d')) >= $completed_challenge->challenge_registration_date) {
            $links_register = '';
        } else {
            $links_register = 'disable';
        }

        if (strtotime(date('Y-m-d')) >= $completed_challenge->challenge_start_date) {
            $links_login = '';
        } else {
            $links_login = 'disable';
        }
    endif;
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
                <div class="home_page_text">
                    <?php
                    if ($challenge_id == 9):
                        $welcome_msg1 = 'Welcome to the 30-Day P.E.A.K. Influence Challenge!  Take your P.E.A.K. Influence training to the next level over the next 30 days as you put your learnings into action in a fun and interactive way.  Prepare to be inspired daily, acknowledge wins, connect with your colleagues and practice your Influencing skills in just a few minutes a day. Thank you for participating and let\'s have a great P.E.A.K. Influence Challenge!';
                        ?>
                        <?= $welcome_msg1; ?>
                    <?php else: ?>
                        <?= $content; ?>
                    <?php endif; ?>
                </div>
                <h1 class="rtecenter"><strong style="text-transform: capitalize;color:<?= $color; ?>"><?= $welcome_msg; ?></strong></h1>
                <div class=login-infor>
                    <?php
                    if (Yii::$app->user->isGuest):
                        ?>
                        <ul class="">
                            <?php
                            if ($links_register != 'disable') {
                                echo '<li><a href="' . $challengeName . '/signup" class="name_user ' . $class . '"  style="background:' . $color . '">Register Now</a> </li>';
                            }
                            if ($links_login != 'disable') {
                                echo '<li><a href="/login" class="name_user ' . $class . '" style="background:' . $color . '">Login</a> </li>';
                            }
                            ?>
                        </ul>
                        <?php
                    else:
                        ?>
                        <ul>
                            <li><a href="/<?= $challenge_abbr_name ?>/dashboard" class="name_user <?= $class; ?>" style="background:<?= $color; ?>">Dashboard</a></li>
                            <li><a class="<?= $class; ?>" style ='background:<?= $color ?>'><?php
                                    echo Html::beginForm(['site/logout'], 'post')
                                    . Html::submitButton(
                                            'Logout', ['class' => 'btn btn-link logout']
                                    )
                                    . Html::endForm()
                                    ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .xyz
    {
        display:none;
    }
    .wrap > .container
    {
        padding: 17px 15px 20px;
    }
</style>