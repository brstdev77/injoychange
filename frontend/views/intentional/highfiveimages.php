<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use frontend\models\PilotFrontPeakHighfive;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use frontend\models\PilotFrontUser;

$this->title = 'See All | High Five Images';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/seeall.css');
$this->registerCssFile($baseurl . '/css/highfiveimages.css');

$this->registerJsFile($baseurl . "/js/bootstrap-notify.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$value = Yii::$app->request->get('PilotFrontPeakHighfiveSearch');
$value1 = Yii::$app->request->get('shouttype');
if ($value != '') {
    $name = $value['user_id'];
    $shouttype = $value1;
} else {
    $shouttype = 0;
}
$challenge_id = Yii::$app->user->identity->challenge_id;
$game = $challenge_id;
$comp_id = Yii::$app->user->identity->company_id;
$user_id = Yii::$app->user->identity->id;
if ($total_comment < 5):
    $scroll = 1;
else:
    $scroll = 0;
endif;
?>
<?php //$count = $shareawins_all->getTotalCount();     ?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title" style="padding-bottom:20px"><div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/intentional/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 high-five-title">SHOUT OUT GALLERY</div>
        </div>
        <!--div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 dashboard-link">
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
                        <input id="project" class='form-control tt-hint' name='PilotFrontPeakHighfiveSearch[user_id]' placeholder='Search for teammate' value='<?= $name ?>'>
                        <input type="hidden" id="shouttype" value="<?= $shouttype; ?>" name="shouttype"/>
                        <img width="20px" src="<?php echo $baseurl ?>/images/loader.gif" class="userloader">
                        <div class="help-block" style="color:red;display:none">Please enter a username.</div>
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
            <button type="button" class="btn btn-primary shoutoutsgiven ic_btn_1 shout1" data-tabname="region" style="color:#cc1c1c;background:#fff" rel="1">Shout Outs Recieved</button>


        </div>
    </div-->
        <div class="see-all-powers-outer innerpages">
            <input type="hidden" name='count_images' id='count_images' value = '10'/>
            <input type="hidden" name='count_offset' id='count_offset' value = '5'/>
            <input type="hidden" name='count_limit' id='count_limit' value = '<?= $scroll; ?>'/>
            <div class="see-all-powers-inner">
                <div id="loading-check" class="loading-check-div" style="display: none;">
                    <img id="loading-check-img" src="../images/loaderhighfive.gif">
                </div>
                <div class="actionimage">
                    <?php if (count($all_highfiveImage) == 0): ?>
                        <input type="hidden" id="zerocomment" value="0"/>
                        <div class="no-data hf"> 
                            <h3 class="first"> Be the first one to Share an 5S in Action! </h3> 
                        </div>
                        <?php
                    else:
                        foreach ($all_highfiveImage as $hghfv1):
                            $hf_cmnt_user = PilotFrontUser::findIdentity($hghfv1->user_id);
                            $hf_cmnt_userName = $hf_cmnt_user->username;
                            $hf_cmnt_userImage = $hf_cmnt_user->profile_pic;
                            $hf_cmnt = $hghfv1->feature_value;
                            if ($hf_cmnt_userImage == ''):
                                $hf_cmnt_userImagePath = '../images/user_icon.jpg';
                            else:
                                $hf_cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $hf_cmnt_userImage;
                            endif;
                            $check_comment_liked = PilotFrontPeakHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv1->id])->one();
                            if (empty($check_comment_liked)):
                                $lk_cls = 'not-liked';
                                $lk_img = 'highgivelike.png';
                            else:
                                $lk_cls = 'liked';
                                $lk_img = 'highfivelike1.png';
                            endif;
                            //Total Likes of Each High Five Comment
                            $total_likes = PilotFrontPeakHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv1->id])->all();
                            $comment_image = PilotFrontPeakHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $hghfv1->id])->one();

                            $cimg_path = $baseurl . '/uploads/high_five/' . $comment_image->feature_value;
                            ?>
                            <div class="grid-item" style="position: relative; height: 250px;">
                                <div class="grid-padding">
                                    <div class="box-item" style="">
                                        <a class="img_modal <?= $comment_image->id;?>" href="highfive-image-zoom-modal?img_id=<?= $comment_image->id;?>" data-toggle="modal" data-modal-id="highfive-image-zoom1" onclick = "highfivezoommodal(this,event)" style="cursor:zoom-in;"> 
                                            <img src="<?= $cimg_path; ?>">
                                        </a>
                                        <p class="user_comment1"><?= json_decode($hf_cmnt); ?></p>
                                        <div class="image">
                                            <div class="user_image">
                                                <img src="<?= $hf_cmnt_userImagePath; ?>"/>
                                            </div>
                                            <p class="user_name"><?= $hf_cmnt_userName; ?></p>
                                            <div onclick="highfivelike(<?= $user_id; ?>,<?= $hghfv1->id; ?>)" class="user_likeimage">
                                                <img class="<?= $hghfv1->id; ?>" src="/images/<?= $lk_img; ?>" style="border: medium none; height: 30px; width: 30px;"/>
                                            </div>
                                            <h6 class="user_like" id="<?= $hghfv1->id; ?>"><?= count($total_likes); ?></h6>
                                        </div>
                                        <!--div class="comment_count1">
                                            <span> (<span class="c_count 8585">0</span>)<a href="highfive-usercomment-modal?uid=468&amp;cid=8585" data-toggle="modal" data-modal-id="highfive-usercomment" style="color:#333"> Add Comment</a></span>
                                        </div-->
                                    </div>
                                </div>
                            </div>
                            <?php
                        endforeach;
                        ?>
                    <?php endif;
                    ?>
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
                    <img src="../images/ajax-loader-leads.gif"/>
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
                    <img src="../images/ajax-loader-leads.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->render('prize_modal'); ?>
<?php
$this->registerJsFile($baseurl . "/js/packery.pkgd.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/custom_packery.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<div class="modal fade" role="dialog" id="highfive-image-zoom1" data-backdrop="static" data-keyboard="false">
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