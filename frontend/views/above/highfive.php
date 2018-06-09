<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use frontend\models\PilotFrontHighfive;
use kartik\typeahead\Typeahead;

$this->title = 'See All | High Five';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/seeall.css');
?>
<?php $count = $shareawins_all->getTotalCount(); ?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/above/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 high-five-title">SHOUT OUT & DIGITAL HIGH 5'S</div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 dashboard-link">
                <div class="pilot-front-highfive-search">
                    <?php
                    $form = ActiveForm::begin([
                          'action' => 'high-five',
                          'method' => 'get',
                    ]);
                    ?>
                    
                    
                    
                    
                    <?php
              
                   
                    
                    
             $str = implode (",", $compData);
                    
             
             

$array = explode(',', $str);

    

echo Typeahead::widget([
    'model' => $model, 
    'attribute' => 'user_id',
     'scrollable' => TRUE,
    'options' => ['placeholder' => 'Search Users'],
    'pluginOptions' => ['highlight'=>true],

        'dataset' => [
        [
            'local' => $array,
            'templates' => [
                'notFound' => '<div class="text-danger" style="padding:0 8px">No Result Found</div>',
                
            ]
        ]
    ]
    
    
    

]);
                    ?>
                    
                    
                    
                    
                    

              <?//= $form->field($model, 'user_id')->dropDownList($compData, ['prompt' => 'Please Select'])->label('Username' . Html::tag('span', '*', ['class' => 'required'])); ?>         

                    <?//= $form->field($model, 'user_id') ?>
                    
                    

                    
                    
                    <div class="form-group">
                        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>

                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>





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
                            <div class="value1 header">High Five</div>                
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
                          'emptyText' => ' <div class="no-data"> Be the first one to Share an Appreciation! </div>',
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
                        }
                        else {
                          $page = 1;
                        }
                        if (isset($_GET['per-pag'])) {
                          $per_pag = $_GET['per-pag'];
                        }
                        else {
                          $per_pag = 4;
                        }
                        if ($page > 1) {
                          $number = $count1 - ($per_pag * ($page - 1));
                        }
                        else {
                          $number = (($page - 1) * $per_pag) + $count1;
                        }
                        ?>
                        <div id="hf_<?= $model->id; ?>" >
                            <div class="points-data record-tr <?= $cls ?>">
                                <div class="sno record-td"><?php echo $number; ?></div>
                                <div class="name record-td">
                                    <div class=profile_img>
                                        <?php
                                        if ($model->userinfo->profile_pic) {
                                          $imagePath = Yii::$app->request->baseurl . '/uploads/' . $model->userinfo->profile_pic;
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
                                
                                
                                <div class="value1 record-td">  <?= json_decode($model->feature_value); ?></div>

                                <?php
                                $user_id = Yii::$app->user->identity->id;
                                $comp_id = 1;
                                $game = 1;
                                ?>
                                <?php
//Comment Liked or Not Liked
                                $check_comment_liked = PilotFrontHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $model->id])->one();
                                if (empty($check_comment_liked)):
                                  $lk_cls = 'not-liked';
                                  $lk_img = 'hand.png';
                                else:
                                  $lk_cls = 'liked';
                                  $lk_img = 'hand-colored.png';
                                endif;
//Total Likes of Each High Five Comment
                                $total_likes = PilotFrontHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $model->id])->all();
                                ?>


                                <div class=count>
                                    <div class="high-five <?= $lk_cls; ?>" id="<?= $model->id; ?>" data-uid="<?= Yii::$app->user->identity->id; ?>" data-comment-id="<?= $model->id; ?>" data-feature-label="highfiveLike">
                                        <input name=high-five value="High Five" type=submit>
                                    </div>
                                    <img alt=background src="../images/<?= $lk_img; ?>" height=26 width=78>
                                    <p class=num><?= count($total_likes); ?></p>

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
<? $this->registerJsFile($baseurl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>