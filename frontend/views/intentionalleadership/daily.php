<?php
//use yii\web\View;
/* @var $this yii\web\View */

$this->title = 'See All | Daily Inspiration';
$baseurl = Yii::$app->request->baseurl;
?>
<?php $this->registerCssFile($baseurl . '/css/seeall.css'); ?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/intentionalleadership/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">
            </div>
        </div>
        <div class="grid-item" style="position: relative; height: 385px;">
            <div class="grid-padding">
                <?php
                foreach ($daily_inspiration_obj as $daily_obj):
                  $daily_image_path = Yii::getAlias('@back_end') . '/img/daily-inspiration-images/' . $daily_obj->image_name;
                  ?>

                  <div class="box-item" style="">
                      <img src="<?= $daily_image_path; ?>">
                  </div>

                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
</div>
<?php
$this->registerJsFile($baseurl . "/js/custom_packery.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);

$this->registerJsFile($baseurl . "/js/packery.pkgd.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);

$this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<?php //echo $this->render('prize_modal'); ?>