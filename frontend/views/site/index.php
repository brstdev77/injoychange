<?php
/* @var $this yii\web\View */
$this->title = 'Landing Page';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/main.css');
?>
<div class="site-index">
    <div class="content main-dashboard-banners">

        <div class=row>
            <div class=col-md-12>
                <div class=login-infor>
                    <?php
                    //if (Yii::$app->user->isGuest) {
                        ?>
                        <ul class="">
                            <li><a href="<?= $baseurl; ?>/above" class=name_user>Above & Beyond</a> </li>
                            <li><a href="<?= $baseurl; ?>/service" class=name_user>Customer Service</a> </li>
                            <li><a href="<?= $baseurl; ?>/core" class=name_user>Core Value</a> </li>
                            <li><a href="<?= $baseurl; ?>/teamwork" class=name_user>Teamwork</a> </li>
                            <li><a href="<?= $baseurl; ?>/leadership" class=name_user>Leadership</a> </li>
                            <li><a href="<?= $baseurl; ?>/productivity" class=name_user>Productivity</a> </li>
                        </ul>
                        <?php
                    //}
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
