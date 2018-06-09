<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use frontend\models\PilotFrontCoreHighfive;
use kartik\typeahead\Typeahead;
use frontend\models\PilotFrontUser;
$this->title = 'See All';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/seeall.css');
$info1='';
?>
<?php $count = $shareawins_all->getTotalCount();?>
<div class="site-index">
    <div class="seeall-data">
	    <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/core/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">Notifications</div>
        </div>
        <div class="see-all-powers-outer">
            <div class="see-all-powers-inner">
                <div id="loading-check" class="loading-check-div" style="display: none;">
                    <img id="loading-check-img" src="../images/ajax-loader.gif">
                </div>
                <div class="table-points">
                    <div class="table_1"   >
                        <div class="main-header">
                            <div class="sno header">S No.</div>
                            <div class="name header">Name</div>
                            <div class="date header">Date</div>
                             <div class="value1 header">High Five Like/High Five User Comment</div>                
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
                          'itemView' => function ($model, $key, $index, $widget) use ($count) {
                        $number = $index + 1;
                       if($number%2 ==0)
					   {
						   $cls='even';
					   }
					   else
					   {
						   $cls='odd';
					   }
                        ?>
                        <?php
                        $user_id = Yii::$app->user->identity->id;
                        $comp_id = Yii::$app->user->identity->company_id;
                        $game = PilotFrontUser::getGameID('core');
						 
                        ?>
						<div id="hf_<?= $model->id; ?>" >
                            <div class="points-data record-tr <?= $cls ?>">
                                <div class="sno record-td"><?php echo $number; ?></div>
                                <div class="name record-td">
							
                                    <div class=profile_img>
                                       	<?php
										$info1 = PilotFrontUser::findOne(['id' => $model->activity_user_id]);
										if ($info1->profile_pic) {
                                          $imagePath = Yii::$app->request->baseurl . '/uploads/' . $info1->profile_pic;
                                        }
                                        else {
                                          $imagePath = Yii::$app->request->baseurl . '/images/default-user.png';
                                        }
                                        ?> 
                                        <img src="<?= $imagePath; ?>" class="" alt="User Image" height=45 width=45>
                                    </div>
						  <div class="name"><?php echo $info1->username; ?></div></div>
                                <div class="date record-td"><?php
                                    $newDate = $model->created;
                                    $php_timestamp_date = date("m-d-y", $newDate);
                                    echo $php_timestamp_date;
                                    ?></div>                   
                                <div class="value1 record-td">  
                                    <?= $model->notif_value ?>

                                </div>

                            </div>
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
<?= $this->registerJsFile($baseurl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>