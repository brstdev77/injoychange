<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use frontend\models\PilotFrontTestHighfive;
use kartik\typeahead\Typeahead;
use yii\web\JsExpression;
use frontend\models\PilotFrontUser;
use yii\widgets\Pjax;

$count = $shareawins_all->getTotalCount();  
?>
<div class="table_1"   >
                        <div class="main-header">
                            <div class="sno hf header">#</div>
                            <div class="name hf header">Name</div>
                            <div class="date hf header">Date</div>
                            <div class="shout header">Shout Out</div>
                            <div class="highfive header">High Five</div>                
                        </div>
<?php
Pjax::begin();
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
        $game = PilotFrontUser::getGameID('test');
        ?>
        <?php
        //Comment Liked or Not Liked
        $check_comment_liked = PilotFrontTestHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $model->id])->one();

        if (empty($check_comment_liked)):
            $lk_cls = 'not-liked';
            $lk_img = 'hand.png';
        else:
            $lk_cls = 'liked';
            $lk_img = 'hand.png';
        endif;
        //Total Likes of Each High Five Comment
        $total_likes = PilotFrontTestHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveLike', 'linked_feature_id' => $model->id])->all();
        //Total Comments
        $total_comments = PilotFrontTestHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveUserComment', 'linked_feature_id' => $model->id])->all();
        //Comment Image
        $comment_image = PilotFrontTestHighfive::find()->where(['game_id' => $game, 'company_id' => $comp_id, 'feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $model->id])->all();
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
                                        <img id="cimg_<?= $cimg->id; ?>" alt="image" title="Image" src="<?= $cimg_path; ?>" data-src="<?= $cimg_path; ?>" class="img-attach zoom_image hf_img">
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
                    <img alt=background src="../images/hand.png" height=26 width=78>
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