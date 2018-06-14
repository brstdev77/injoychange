<?php
/* @var $this yii\web\View */

use yii\widgets\ListView;

$this->title = 'See All | Share a Win';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/seeall.css');
?>
<?php $count = $shareawins_all->getTotalCount(); ?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/service/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title"><?= $game_obj->right_corner_heading;?></div>
        </div>
        <div class="see-all-powers-outer shareawin">
            <div class="see-all-powers-inner">
                <div class="table-points">
                    <div class="table_1">
                        <div class="main-header">
                            <div class="sno header">#</div>
                            <div class="name header">Name</div>
                            <div class="date header">Date</div>
                            <div class="value1 header">Share a Win</div>                
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
                          'emptyText' => ' <div class="no-data"> Be the first one to Share a Win! </div>',
                          'itemView' => function ($model, $key, $index, $widget) use ($count) {
                        $number = $index + 1;
                        $count1 = $count - $index;
                        if ($number % 2 == 0):
                          $cls = 'even';
                        else:
                          $cls = 'odd';
                        endif;
                        if (isset($_GET['page'])) {
                          $page = $_GET['page'];
                        }
                        else {
                          $page = 1;
                        }
                        if (isset($_GET['per-pag'])) {
                          $per_pag = $_GET['per-pag'];
                        }
                        else {
                          $per_pag = 30;
                        }
                        if ($page > 1) {
                          $number = $count1 - ($per_pag * ($page - 1));
                        }
                        else {
                          $number = (($page - 1) * $per_pag) + $count1;
                        }
                        ?>
                        <div class="points-data record-tr <?= $cls ?>">
                            <div class="sno record-td"><?php echo $number; ?></div>
                            <div class="name record-td">
                                <div class=profile_img>
                                    <?php
                                    if ($model->userinfo->profile_pic) {
                                      $imagePath = Yii::$app->request->baseurl . '/uploads/thumb_' . $model->userinfo->profile_pic;
                                    }
                                    else {
                                      $imagePath = Yii::$app->request->baseurl . '/images/default-user.png';
                                    }
                                    ?> 
                                    <img src="<?= $imagePath; ?>" class="" alt="User Image" height=45 width=45>
                                </div>
                                <div class="name"><?php echo $model->userinfo->username; ?></div></div>
                            <div class="date record-td"><?php
                                $newDate = $model->created;
                                $php_timestamp_date = date("m-d-y", $newDate);
                                echo $php_timestamp_date;
                                ?></div>                   

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
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
</div>
<?php $this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php echo $this->render('prize_modal'); ?>