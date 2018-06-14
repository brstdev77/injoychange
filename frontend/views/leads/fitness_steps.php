<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = 'See All | Fitness';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/seeall.css');
$count = count($fitness_data_arr);
?>

<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/Service/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">Fitness Activity</div>
        </div>
        <div class="see-all-powers-outer">
            <div class="see-all-powers-inner">
                <div class="table-points">
                    <div class="table_1 band-data-table">
                        <div class="main-header">
                            <!--<div class="sno header">S No.</div>-->
                            <div class="date fit header">Date</div>
                            <div class="steps header">Steps</div>   
                            <div class="calrs header">Calories</div>   
                            <div class="distnc header">Distance</div>   
                            <div class="slp header">Sleep</div>   
                        </div>
                        <?php
                        $a = krsort($fitness_data_arr);
                        $count = $rcrd_start;
                        $i = 1;
                        foreach ($fitness_data_arr as $timestamp => $fitness_data):
                          if ($i >= $rcrd_start):
                            foreach ($fitness_data as $date => $data):
                              $steps = 0;
                              $cal = 0;
                              $sleep = '00h:00m';
                              $dis = '0.00';
                              if ($data != 0):
                                $steps = $data->steps;
                                $cal = $data->calories;
                                $sleep = $data->sleephr;
                                $dis = $data->distance;
                              endif;
                            endforeach;
                            if ($count % 2 == 0):
                              $cls = 'even';
                            else:
                              $cls = 'odd';
                            endif;
                            $date_format = date('d-m-Y', strtotime($date)); 

                            if ($rcrd_start <= $count):
                              ?>
                              <div class="points-data record-tr <?= $cls; ?>">
                                  <!--<div class="sno record-td"><?php echo $count; ?></div>-->
                                  <div class="date fit record-td"><?= $date_format; ?></div>                   
                                  <div class="steps record-td">
                                      <img src="/images/steps.png" alt="steps" width="66" height="42">
                                       <?= $steps; ?>
                                  </div>   
                                  <div class="calrs record-td">
                                      <img src="/images/calories.png" alt="calories" width="51" height="50">
                                      <?= $cal; ?>
                                  </div>   
                                  <div class="distnc record-td">
                                      <img src="/images/miles.png" alt="miles" width="68" height="47">
                                      <?= $dis; ?>
                                  </div>   
                                  <div class="slp record-td">
                                      <img src="/images/sleep.png" alt="hours" width="68" height="47">
                                      <?= $sleep; ?>
                                  </div>   
                              </div>
                              <?php
                            endif;
                            $count = $count + 1;
                            if ($count > $rcrd_end):
                              break;
                            endif;
                          endif;
                          $i++;
                        endforeach;
                        ?>
                    </div>
                    <div class="data-pager">
                        <?php
                        echo LinkPager::widget([
                          'pagination' => $pages,
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
