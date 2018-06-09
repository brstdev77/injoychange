<?php
/* @var $this yii\web\View */

$this->title = 'See All | Leadership Corner';
$baseurl = Yii::$app->request->baseurl;
?>
<?php $this->registerCssFile($baseurl . '/css/seeall.css'); ?>

<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/leadership/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">What are they saying?</div>
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
                  </div>
                  <div class="description">
                      <p>
                          <strong><?= $current_week_tip_title; ?></strong>
                      </p>
                      <p> 
                          <?= $current_week_tip_des; ?>   
                      </p>
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
                $tip_image_path = Yii::getAlias('@back_end') . '/img/leadership-corner-images/dashboard-image/' . $leadership_tip->dashboard_image;
                $tip_title = ucwords($leadership_tip->title);
                $tip_des = $leadership_tip->description;
                ?>
                <div class="toolbox-row  <?= $row_cls; ?>">      
                    <div class="toolbox-left-content">
                        <div class="image">
                            <img alt=user title=Image src="<?= $tip_image_path; ?>">
                        </div>
                    </div>
                    <div class="description">
                        <p>
                            <strong><?= $tip_title; ?></strong>
                        </p>
                        <p> 
                            <?= $tip_des; ?>   
                        </p>
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

<?php echo $this->render('prize_modal'); ?>