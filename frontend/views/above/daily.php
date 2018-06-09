<?php
//use yii\web\View;
/* @var $this yii\web\View */

$this->title = 'Daily Inspiration';
$baseurl = Yii::$app->request->baseurl;
?>
<?php $this->registerCssFile($baseurl . '/css/seeall.css'); ?>

<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/above/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title"></div>
        </div>
        <div class="grid-item" style="position: relative; height: 385px;">
            <div class="grid-padding">
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily10.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily4.png">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily6.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily1.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily2.png">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily6.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily10.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily1.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily7.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily4.png">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily2.jpg">
                </div>
                <div class="box-item" style="">
                    <img src="<?= $baseurl; ?>/images/daily/daily2.png">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile($baseurl . "/js/custom_packery.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);

$this->registerJsFile($baseurl . "/js/packery.pkgd.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>