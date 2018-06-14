<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use frontend\models\PilotFrontCustomerHighfive;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use frontend\models\PilotFrontUser;
use yii\widgets\Pjax;

$this->registerJs('$(document).on("pjax:timeout", function(event) {
  // Prevent default timeout redirection behavior
  event.preventDefault()
});');
$this->title = 'See All | High Five';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/seeall.css');

$this->registerJsFile('http://code.jquery.com/ui/1.10.4/jquery-ui.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$value = Yii::$app->request->get('PilotFrontCustomerHighfiveSearch');
$value1 = Yii::$app->request->get('shouttype');
if ($value != '') {
    $name = $value['user_id'];
    $shouttype = $value1;
} else {
    $shouttype = 0;
}
$challenge_id = Yii::$app->user->identity->challenge_id;
?>
<?php $count = $shareawins_all->getTotalCount(); ?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title" style="padding-bottom: 0"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/customer/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 high-five-title">JOIN THE CONVERSATION</div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 dashboard-link">
                <div class="pilot-front-highfive-search">
                    <?php
                    $form = ActiveForm::begin([
                                'action' => 'high-five',
                                'method' => 'get',
                                'id' => 'highfivesearch',
                    ]);
                    ?>
                    <?php
                    /* $str = implode(",", $userData);
                      $array = explode(',', $str);

                      //$template = '<p class="user-result"><img src="{{img}}">{{name}}</p>';

                      echo Typeahead::widget([
                      'model' => $model,
                      'attribute' => 'user_id',
                      'scrollable' => TRUE,
                      'options' => ['placeholder' => 'Search for teammate'],
                      'pluginOptions' => ['highlight' => true],
                      'dataset' => [
                      [
                      'local' => $array,
                      'templates' => [
                      'notFound' => '<div class="text-danger" style="padding:0 8px">No Result Found</div>',
                      //'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                      ]
                      ]
                      ]
                      ]); */
                    ?>
                    <div class='tt-scrollable-menu'>
                        <div class="form-group">
                            <input id="project" class='form-control tt-hint' name='PilotFrontCustomerHighfiveSearch[user_id]' placeholder='Search for teammate' value='<?= $name ?>'>
                            <input type="hidden" id="shouttype" value="<?= $shouttype; ?>" name="shouttype"/>
                            <img width="20px" src="<?php echo $baseurl ?>/images/loader.gif" class="userloader">
                            <div class="help-block" style="color:red;display:none">Please enter name.</div>
                        </div> 
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12"></div>

        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 shoutouts-paddings">
            <div class="btn-group sht_btn">

                <button type="button" class="btn btn-primary shoutoutsgiven rgn_btn_2 shout0" data-tabname="icac" rel="0">Shout Outs Given</button>
                <button type="button" class="btn btn-primary shoutoutsgiven ic_btn_1 shout1" data-tabname="region" style="color:#ec6817;background:#fff" rel="1">Shout Outs Recieved</button>


            </div>
        </div>
        <div class="see-all-powers-outer">
            <div class="see-all-powers-inner">
                <div id="loading-check" class="loading-check-div" style="display: none;">
                    <img id="loading-check-img" src="../images/ajax-loader-leads.gif">
                </div>
                <div class="table-points">
                    <div class="table_1"   >
                        <div class="main-header">
                            <div class="sno hf header">#</div>
                            <div class="name hf header">Name</div>
                            <div class="date hf header">Date</div>
                            <div class="shout header">Shout Out</div>
                            <div class="highfive header">High Five</div>                
                        </div>
                        <?php
                        Pjax::begin(['enablePushState' => false]);
                        echo ListView::widget([
                            'dataProvider' => $shareawins_all,
                            'itemOptions' => ['class' => ''],
                            'layout' => '{items}<br/><div id="pagination-wrapper">{pager}</div>',
                            'pager' => ['options' => [
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
                                <?php
                                $user_id = Yii::$app->user->identity->id;
                                $comp_id = Yii::$app->user->identity->company_id;
                                $game = PilotFrontUser::getGameID('customer');
                                ?>
                                <?php
                                //Comment Liked or Not Liked
                                $check_comment_liked = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $model->id])->one();

                                if (empty($check_comment_liked)):
                                    $lk_cls = 'not-liked';
                                    $lk_img = 'hand.png';
                                else:
                                    $lk_cls = 'liked';
                                    $lk_img = 'hand-orange.png';
                                endif;
                                //Total Likes of Each High Five Comment
                                $total_likes = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $model->id])->all();
                                //Total Comments
                                $total_comments = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $model->id])->all();
                                //Comment Image
                                $comment_image = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $model->id])->all();
                                ?>


                                <div id="hf_<?= $model->id; ?>" >
                                    <div class="points-data record-tr <?= $cls ?>">
                                        <div class="sno hf record-td"><?= $number; ?></div>
                                        <div class="name hf record-td">
                                            <div class="hf profile_img">
                                                <?php
                                                if ($model->userinfo->profile_pic) {
                                                    $imagePath = Yii::$app->request->baseurl . '/uploads/thumb_' . $model->userinfo->profile_pic;
                                                } else {
                                                    $imagePath = Yii::$app->request->baseurl . '/images/default-user.png';
                                                }
                                                ?> 
                                                <img src="<?= $imagePath; ?>" class="" alt="User Image" height=45 width=45>
                                            </div>
                                            <div class="name hf record-td"><?php echo $model->userinfo->username; ?></div></div>
                                        <div class="date hf record-td"><?php
                                            $newDate = $model->created;
                                            $php_timestamp_date = date("m-d-y", $newDate);
                                            echo $php_timestamp_date;
                                            ?></div>                   
                                        <div class="value1 shout record-td">  
                                            <?= json_decode($model->feature_value); ?>

                                            <?php if (!empty($comment_image)) : ?>
                                                <div class="user-attached">
                                                    <span class="user-uploads">
                                                        <?php
                                                        foreach ($comment_image as $cimg):
                                                            $cimg_path = $baseurl . '/uploads/high_five/' . $cimg->feature_value;
                                                            $temp_img_path = $baseurl . '/images/defer_load.gif';
                                                            ?>
                                                            <a class="img_modal" href="highfive-image-zoom-modal?img_id=<?= $cimg->id; ?>" data-toggle="modal" data-modal-id="highfive-image-zoom" onclick='highfivezoommodal(this, event)'> 
                                                                <img id="cimg_<?= $cimg->id; ?>" alt="image" title="Image" src="<?= $temp_img_path; ?>" data-src="<?= $cimg_path; ?>" class="img-attach zoom_image hf_img">
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </span>
                                                </div>
                                            <?php endif; ?>

                                        </div>

                                        <div class="count highfive">
                                            <div class="high-five <?= $lk_cls; ?>" id="<?= $model->id; ?>" data-uid="<?= Yii::$app->user->identity->id; ?>" data-comment-id="<?= $model->id; ?>" data-feature-label="highfiveLike">
                                                <input name=high-five value="High Five" type=submit>
                                            </div>
                                            <img alt=background src="../images/<?= $lk_img; ?>" height=26 width=78>
                                            <p class=num><?= count($total_likes); ?></p>
                                            <div class=comment_count>
                                                <span> (<span class="c_count <?= $model->id; ?>"><?= count($total_comments); ?></span>)<a onclick="saveusercomment(this, event)" href="highfive-usercomment-modal?uid=<?= $user_id; ?>&cid=<?= $model->id; ?>" data-toggle="modal" data-modal-id="highfive-usercomment"> Add Comment</a></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <?php
                            },
                        ]);
                        Pjax::end();
                        ?> 
                    </div>
                </div>
            </div>  
        </div>
    </div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
</div>
<?
$this->registerJsFile($baseurl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>

<!-- High Five User Comment Modal HTML-->
<div class="modal fade" role="dialog" id="highfive-usercomment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <!--<h4 class="modal-title">Add Comment</h4>-->
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- High Five Image Zoom Modal HTML-->
<div class="modal fade" role="dialog" id="highfive-image-zoom">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <!--<h4 class="modal-title">Add Comment</h4>-->
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//echo $this->render('prize_modal'); ?>