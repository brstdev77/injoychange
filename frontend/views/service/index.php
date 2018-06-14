<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Landing | Core Value';
$baseurl = Yii::$app->request->baseurl;
?>
<?php $this->registerCssFile($baseurl . '/css/above.css'); ?>
<div class="site-index">
    <div class="content main-dashboard-banners">
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <img class=main-banner src="<?= $baseurl; ?>/images/bannercore.png" alt=banner height=392 width=1180 />
                </div>
            </div>
        </div>
        <div class=row>
            <div class=col-md-12>
                <div class="home_page_text">
                    The Injoy team is talented and amazing. 
                    But think about how great would it be to take a few minutes each day to really acknowledge the wins we are having as a group, the difference we are making in our lives to be healthy and stay active. 
                    It's time to maintain a healthy, and balanced lifestyle. That's what this challenge is all about! ?   
                </div>
                <h1 class="rtecenter"><strong> Welcome to the 30 - Day Core Value Challenge!</strong></h1>
                <div class=login-infor>
                    <?php
                    if (Yii::$app->user->isGuest) {
                        ?>
                        <ul class="">
                            <li><a href="<?= $baseurl; ?>/site/signup" class=name_user>Register Now</a> </li>
                            <li><a href="<?= $baseurl; ?>/site/login" class=name_user>Login</a> </li>

                        </ul>
                        <?php
                    } else {
                        ?>
                        <ul>
                            <li><a href="<?= $baseurl; ?>/core/dashboard" class=name_user>Dashboard</a> </li>
                            <li><a><?php
                                    echo Html::beginForm(['site/logout'], 'post')
                                    . Html::submitButton(
                                            'Logout', ['class' => 'btn btn-link logout']
                                    )
                                    . Html::endForm()
                                    ?></a></li>
                        </ul>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
