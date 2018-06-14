<?php
/* @var $this yii\web\View */

$this->title = 'See All | Leadership Corner';
$baseurl = Yii::$app->request->baseurl;
$j = 0;
$k = 0;
?>
<?php
$this->registerCssFile($baseurl . '/css/seeall.css');
$this->registerCssFile($baseurl . '/css/jQuery.AudioPlayer.css');
?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/core/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title"><?= $game_obj->left_corner_heading ;?></div>
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
                $current_week_tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/dashboard-image/' . $current_week_leadership_tip->dashboard_image;
                $current_week_tip_title = ucwords($current_week_leadership_tip->title);
                $current_week_tip_des = $current_week_leadership_tip->description;
                ?>
                <div class="toolbox-row  <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $current_week_tip_image_path; ?>">
                        </div>
                        <p style="font-family:lato-bold;font-size:16px;text-align:center"><?= $current_week_tip_title; ?></p>
                        <p style="font-family:lato-bold;font-size:14px;text-align:center"><?= $current_week_leadership_tip->designation; ?></p>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $current_week_leadership_tip->question; ?></strong>
                        </p>
                        <p> 
                            <?= $current_week_tip_des; ?>   
                            <?php
                            if ($current_week_leadership_tip->answer_type == '2'):
                                $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $current_week_leadership_tip->video_poster;
                                $file_link = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $current_week_leadership_tip->file_link;
                                ?>
                                <video width="500" height="240" controls="" controlsList="nodownload" poster="<?= $tip_image_path; ?>" src="<?= $file_link; ?>">
                                    <!--<source src="<?= strip_tags($current_week_tip_des); ?>" type="video/mp4">-->
                                    <!--source src="movie.ogg" type="video/ogg"-->
                                </video>  
                            <?php endif; ?>

                            <?php
                            if ($current_week_leadership_tip->answer_type == '1'): $k++;
                                $file_link = Yii::getAlias('@back_end') . '/img/leadership-corner-audio/' . $current_week_leadership_tip->file_link;
                                ?>
                            <div class="col-xs-12 col-md-6">
                                <div id="audioWrap<?= $k; ?>"></div>
                            </div>
                            <!--button class="sub-btn btn btn-warning text-capitalize audio_play" href='play-audio?tip=<?= strip_tags($current_week_tip_des); ?>' data-toggle="modal" data-modal-id="play">play audio</button-->
                            <input type="hidden" class="audio_link" id="audio_link<?= $k; ?>" value="<?= $file_link; ?>" name="audio_link<?= $k; ?>" /> 
                        <?php endif; ?>
                        </p>
                    </div> 
                </div>

                <?php
                $i++;
            endforeach;
            ?>
            <input type='hidden' name='current_audios' value='<?= $k; ?>' id='current_audios' />
            <?php
            if ($k == 0):
                $j = 0;
            else:
                $j = $k;
            endif;
            foreach ($leadership_tips as $leadership_tip):
                preg_match_all('!\d!', $leadership_tip->week, $matches);
                $tip_week = (int) implode('', $matches[0]);
                if ($tip_week < $week_no): //Content of Past Weeks of Game Challenge
                    if ($i % 2 == 0):
                        $row_cls = 'odd';
                    else:
                        $row_cls = 'even';
                    endif;
                    $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/dashboard-image/' . $leadership_tip->dashboard_image;
                    $tip_title = ucwords($leadership_tip->title);
                    $tip_des = $leadership_tip->description;
                    ?>
                    <div class="toolbox-row  <?= $row_cls; ?>">      
                        <div class="toolbox-left-content">
                            <div class="image">
                                <img alt=user title=Image src="<?= $tip_image_path; ?>">
                            </div>
                            <p style="font-family:lato-bold;font-size:16px;text-align:center"><?= $tip_title; ?></p>
                            <p style="font-family:lato-bold;font-size:14px;text-align:center"><?= $leadership_tip->designation; ?></p>
                        </div>
                        <div class="description">
                            <p>
                                <strong><?= $leadership_tip->question; ?></strong>
                            </p>
                            <p> 
                                <?= $tip_des; ?> 
                                <?php
                                if ($leadership_tip->answer_type == '2'):
                                    $tip_image_path1 = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $leadership_tip->video_poster;
                                    $file_link1 = Yii::getAlias('@back_end') . '/img/leadership-corner-video/' . $leadership_tip->file_link;
                                    ?>
                                    <video width="500" height="240" controls="" controlsList="nodownload" poster="<?= $tip_image_path1; ?>" src="<?= $file_link1; ?>">
                                        <!--<source src="<?= strip_tags($current_week_tip_des); ?>" type="video/mp4">-->
                                        <!--source src="movie.ogg" type="video/ogg"-->
                                    </video>  
                                <?php endif; ?>
                                <?php
                                if ($leadership_tip->answer_type == '1'): $j++;
                                    $file_link1 = Yii::getAlias('@back_end') . '/img/leadership-corner-audio/' . $leadership_tip->file_link;
                                    ?>
                                <div class="col-xs-12 col-md-6">
                                    <div id="audioWrap<?= $j; ?>"></div>
                                </div>
                                <!--button class="sub-btn btn btn-warning text-capitalize audio_play" href='play-audio?tip=<?= strip_tags($current_week_tip_des); ?>' data-toggle="modal" data-modal-id="play">play audio</button-->
                                <input type="hidden" class="audio_link" id="audio_link<?= $j; ?>" value="<?= $file_link1; ?>" name="audio_link<?= $j; ?>" /> 
                            <?php endif; ?>
                            </p>
                        </div> 
                    </div>

                    <?php
                    $i++;
                endif;
            endforeach;
            ?>
            <?php if ($j != 0): ?>
                <input type='hidden' name='leadership_audios' value='<?= $j; ?>' id='leadership_audios' />
            <?php else: ?>
                <input type='hidden' name='leadership_audios' value='<?= $k; ?>' id='leadership_audios' />
            <?php endif; ?>
        </div>
    </div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
</div>
<?php $this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php
$this->registerJsFile($baseurl . "/js/jQuery.AudioPlayer1.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/audio.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<?php echo $this->render('prize_modal'); ?>