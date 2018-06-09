<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = 'See All | Check in with Yourself';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/seeall.css');
?>
<?php
$count = $shareawins_all->getTotalCount();
?>

<div class="site-index">

    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/productivity/dashboard">&lt; Dashboard</a></div>

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title"></div>
        </div>


        <div class="see-all-powers-outer">


            <div class="see-all-powers-inner">
                <div class="table-points">
                    <div class="table_1">
                        <div class="main-header">
                            <div class="sno header">S No.</div>
                            <div class="date header">Date</div>
                            <div class="name header">Value</div>
                            <div class="value1 header">Description</div>                
                        </div>

                        <?php
                        echo ListView::widget([
                            'dataProvider' => $shareawins_all,
                            'itemOptions' => ['class' => ''],
                            'layout' => '{items}<br/><div id="pagination-wrapper">{pager}</div>',
                            'pager' => [ 'options' => [
                                    'class' => 'pagination',
                                ]
                            ],
                            'emptyText' => ' <div class="no-data"> No results found! </div>',
                            'itemView' => function ($model, $key, $index, $widget) use ($count) {
                                $number = $index + 1;
                                $count1 = $count - $index;
                                if ($number % 2 == 0):
                                    $cls = 'odd';
                                else:
                                    $cls = 'even';
                                endif;
                                if (isset($_GET['page'])) {
                                    $page = $_GET['page'];
                                } else {
                                    $page = 1;
                                }
                                if (isset($_GET['per-pag'])) {
                                    $per_pag = $_GET['per-pag'];
                                } else {
                                    $per_pag = 30;
                                }
                                if ($page > 1) {
                                    $number = $count1 - ($per_pag * ($page - 1));
                                } else {
                                    $number = (($page - 1) * $per_pag) + $count1;
                                }
                                ?>
                                <div class="points-data record-tr <?= $cls ?>">
                                    <div class="sno record-td"><?php echo $number; ?></div>
                                    <div class="date record-td"><?php
                                        $newDate = $model->dayset;
                                        $php_timestamp_date = date("m-d-y", strtotime($newDate));
                                        echo $php_timestamp_date;
                                        ?>
                                    </div>                   
                                    <div class="core_val record-td">  <?= $model->label; ?></div>
                                    <div class="value1 record-td">  <?= json_decode($model->comment); ?></div>
                                </div>
                                <?php
                            },
                        ]);
                        ?> 
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<?php echo $this->render('prize_modal'); ?>