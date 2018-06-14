<?php
/* @var $this yii\web\View */

$this->title = 'See All | Weekly Videos';
$baseurl = Yii::$app->request->baseurl;
?>
<?php $this->registerCssFile($baseurl . '/css/seeall.css'); ?>

<div class="site-index">
    <div class="seeall-data weekly_videos">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/peak/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">Weekly Videos</div>
        </div>
        <div class="toolbox-outer">
            <?php
            $i = 1;
            foreach ($current_week_leadership_tips as $current_week_leadership_tip):
                if ($i % 2 == 0):
                    $row_cls = 'odd';
                else:
                    $row_cls = 'even';
                endif;
                $current_week_tip_title = ucwords($current_week_leadership_tip->video_title);
                $weekly_video_link = $current_week_leadership_tip->video_link;
                $week_title = $current_week_leadership_tip->week;
                ?>
                <div class="toolbox-row  <?= $row_cls; ?>">  
                    <div class="description"> 
                        <div class="week-title">
                           <?= 'Week '.$week_title; ?>
                        </div>
                        <iframe class="youtube-player" type="text/html" src="<?= $weekly_video_link; ?>?hd=1&amp;rel=0" allowfullscreen="" width="480" height="300"></iframe>
                    </div>    
                    <div class="toolbox-left-content">
                        <div class="image">
                            <?= $current_week_tip_title; ?>
                        </div>
                    </div>
                </div>

                <?php
                $i++;
            endforeach;
            ?>
            <?php
            foreach ($leadership_tips as $leadership_tip):
                preg_match_all('!\d!', $leadership_tip->week, $matches);
                $tip_week = (int) implode('', $matches[0]);
                if ($tip_week < $week_no): //Content of Past Weeks of Game Challenge
                    if ($i % 2 == 0):
                        $row_cls = 'odd';
                    else:
                        $row_cls = 'even';
                    endif;
                    $current_week_tip_title = ucwords($leadership_tip->video_title);
                    $weekly_video_link = $leadership_tip->video_link;
                    $week_title = $leadership_tip->week;
                    ?>
                    <div class="toolbox-row  <?= $row_cls; ?>"> 
                        <div class="description">
                            <div class="week-title">
                                <?= 'Week '.$week_title; ?>
                            </div>
                            <iframe class="youtube-player" type="text/html" src="<?= $weekly_video_link; ?>?hd=1&amp;rel=0" allowfullscreen="" width="480" height="300"></iframe>
                        </div>      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <?= $current_week_tip_title; ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    $i++;
                endif;
            endforeach;
            ?>

        </div>
    </div>
</div>
<?php $this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php echo $this->render('prize_modal'); ?>