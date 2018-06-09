<?php
/* @var $this yii\web\View */

$this->title = "See All | Get to Know the Team";
$baseurl = Yii::$app->request->baseurl;
$j = 0;
$k = 0;
?>
<?php
$this->registerCssFile($baseurl . '/css/seeall.css');
?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/customer/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">GET TO KNOW THE TEAM</div>
        </div>
        <div class="toolbox-outer">
            <?php
            $i = 0;
            foreach ($current_week_leadership_tips as $current_week_leadership_tip):
                $i++;
                if ($i % 2 == 0):
                    $row_cls = 'odd';
                else:
                    $row_cls = 'even';
                endif;
                $first_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $current_week_leadership_tip->first_user_profile;
                $second_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $current_week_leadership_tip->second_user_profile;
                $third_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $current_week_leadership_tip->third_user_profile;
                $first_title = $current_week_leadership_tip->first_user;
                $second_title = $current_week_leadership_tip->second_user;
                $third_title = $current_week_leadership_tip->third_user;
                $first_description = $current_week_leadership_tip->first_user_description;
                $second_description = $current_week_leadership_tip->second_user_description;
                $third_description = $current_week_leadership_tip->third_user_description;
                ?>
                <div class="toolbox-row <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $first_image_path; ?>">
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $first_title; ?></strong>
                        </p>
                        <p class="user_hobby"><?= $first_description; ?></p>
                        <!--p class="hobby_description">I have one younger brother. He is doing Mechanical Engineering.</p-->
                    </div> 
                </div>
                <?php
                $i++;
                if ($i % 2 == 0):
                    $row_cls = 'odd';
                else:
                    $row_cls = 'even';
                endif;
                ?>
                <div class="toolbox-row <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $second_image_path; ?>">
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $second_title; ?></strong>
                        </p>
                        <p class="user_hobby"><?= $second_description; ?></p>
                        <!--p class="hobby_description">I have 10 siblings, and I'm the 1st born! 10 of us are within 10 years apart, 8 of us are from the same mom and dad, and all of us love each other every much and would do anything for each other.</p-->
                    </div> 
                </div>
                <?php
                $i++;
                if ($i % 2 == 0):
                    $row_cls = 'odd';
                else:
                    $row_cls = 'even';
                endif;
                ?>
                <div class="toolbox-row <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $third_image_path; ?>">
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $third_title; ?></strong>
                        </p>
                        <p class="user_hobby"><?= $third_description; ?></p>
                        <!--p class="hobby_description">My brother and sister are both highly educated--one being a forensic scientist, and the other being a computer engineer. My sister works for the state of Illinois in the CSI department, and my brother is approaching graduation from San Jose University.</p-->
                    </div> 
                </div>

            <?php endforeach; ?>

            <?php
            foreach ($leadership_tips as $current_week_leadership_tip):
                $i++;
                if ($i % 2 == 0):
                    $row_cls = 'odd';
                else:
                    $row_cls = 'even';
                endif;
                if (!empty($current_week_leadership_tip->first_user_profile)):
                    $first_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $current_week_leadership_tip->first_user_profile;
                else:
                    $first_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/user_icon.png';
                endif;
                if (!empty($current_week_leadership_tip->first_user_profile)):
                    $second_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $current_week_leadership_tip->second_user_profile;
                else:
                    $second_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/user_icon.png';
                endif;
                if (!empty($current_week_leadership_tip->first_user_profile)):
                    $third_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/' . $current_week_leadership_tip->third_user_profile;
                else:
                    $third_image_path = Yii::getAlias('@back_end') . '/img/knowtheteam/user_icon.png';
                endif;
                $first_title = $current_week_leadership_tip->first_user;
                $second_title = $current_week_leadership_tip->second_user;
                $third_title = $current_week_leadership_tip->third_user;
                $first_description = $current_week_leadership_tip->first_user_description;
                $second_description = $current_week_leadership_tip->second_user_description;
                $third_description = $current_week_leadership_tip->third_user_description;
                ?>
                <div class="toolbox-row <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $first_image_path; ?>">
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $first_title; ?></strong>
                        </p>
                        <p class="user_hobby"><?= $first_description; ?></p>
                        <!--p class="hobby_description">I have one younger brother. He is doing Mechanical Engineering.</p-->
                    </div> 
                </div>
                <?php
                $i++;
                if ($i % 2 == 0):
                    $row_cls = 'odd';
                else:
                    $row_cls = 'even';
                endif;
                ?>
                <div class="toolbox-row <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $second_image_path; ?>">
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $second_title; ?></strong>
                        </p>
                        <p class="user_hobby"><?= $second_description; ?></p>
                        <!--p class="hobby_description">I have 10 siblings, and I'm the 1st born! 10 of us are within 10 years apart, 8 of us are from the same mom and dad, and all of us love each other every much and would do anything for each other.</p-->
                    </div> 
                </div>
                <?php
                $i++;
                if ($i % 2 == 0):
                    $row_cls = 'odd';
                else:
                    $row_cls = 'even';
                endif;
                ?>
                <div class="toolbox-row <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $third_image_path; ?>">
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $third_title; ?></strong>
                        </p>
                        <p class="user_hobby"><?= $third_description; ?></p>
                        <!--p class="hobby_description">My brother and sister are both highly educated--one being a forensic scientist, and the other being a computer engineer. My sister works for the state of Illinois in the CSI department, and my brother is approaching graduation from San Jose University.</p-->
                    </div> 
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a>  
</div>
<?php $this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php $this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>