 <?php 

use frontend\models\PilotFrontUser;

use frontend\models\PilotFrontCustomerHighfive;

$j=1;
$game = PilotFrontUser::getGameID('core');

$comp_id = Yii::$app->user->identity->company_id;

$user_id = Yii::$app->user->identity->id;

 if (count($all_highfivecomment) == 0): ?>

                                        <div class="no-data hf"> 

                                            <h3 class="first"> Be the first one to Share an Appreciation! </h3> 

                                        </div> 

                                        <?php

                                    else:

                                        $i = 1;

                                        foreach ($all_highfivecomment as $hghfv):

                                            $hf_cmnt_user = PilotFrontUser::findIdentity($hghfv->user_id);

                                            $hf_cmnt_userName = $hf_cmnt_user->username;

                                            $hf_cmnt_userImage = $hf_cmnt_user->profile_pic;

                                            $hf_cmnt = $hghfv->feature_value;

                                            if ($hf_cmnt_userImage == ''):

                                                $hf_cmnt_userImagePath = '../images/user_icon.png';

                                            else:

                                                $hf_cmnt_userImagePath = $baseurl . '/uploads/thumb_' . $hf_cmnt_userImage;

                                            endif;

                                            if ($i % 2 == 0):

                                                $row_cls = '';

                                            else:

                                                $row_cls = 'w';

                                            endif;

                                            //Comment Liked or Not Liked

                                            $check_comment_liked = PilotFrontCustomerHighfive::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->one();

                                            if (empty($check_comment_liked)):

                                                $lk_cls = 'not-liked';

                                                $lk_img = 'hand.png';

                                            else:

                                                $lk_cls = 'liked';

                                                $lk_img = 'hand-orange.png';

                                            endif;

                                            //Total Likes of Each High Five Comment

                                            $total_likes = PilotFrontCustomerHighfive::find()->where(['feature_label' => 'highfiveLike', 'linked_feature_id' => $hghfv->id])->all();

                                            //Total Comments

                                            $total_comments = PilotFrontCustomerHighfive::find()->where(['feature_label' => 'highfiveUserComment', 'linked_feature_id' => $hghfv->id])->all();

                                            //Time

                                            $created = $hghfv->created;

                                            $cmnt_time = date('M d, Y h:i A', $created);



                                            //Comment Image

                                            

                                            $comment_image = PilotFrontCustomerHighfive::find()->where(['feature_label' => 'highfiveCommentImage', 'linked_feature_id' => $hghfv->id])->all();

                                            ?>

                                            <div id="hf_<?= $hghfv->id; ?>" class="High-5 <?= $row_cls; ?>">

                                                <div class=user>

                                                    <img alt=user title=Image src="<?= $hf_cmnt_userImagePath; ?>" height=50 width=50>

                                                </div>

                                                <ul class=user-info>

                                                    <li> <h5><?= $hf_cmnt_userName; ?></h5><p class="time1"><?= $cmnt_time; ?></p></li>

                                                    <li> <p><?= json_decode($hf_cmnt); ?></li>

                                                </ul>



                                                <div class=count>

                                                    <div class="high-five <?= $lk_cls; ?>" id="<?= $hghfv->id; ?>" data-uid="<?= Yii::$app->user->identity->id; ?>" data-comment-id="<?= $hghfv->id; ?>" data-feature-label="highfiveLike">

                                                        <input name=high-five value="High Five" type=submit>

                                                    </div>

                                                    <img alt=background src="../images/<?= $lk_img; ?>" height=26 width=78>

                                                    <p class=num><?= count($total_likes); ?></p>

                                                    <?php

                                                    $enable_comment = 'no';

                                                    if (!empty($comment_option)):

                                                        $enable_comment = 'yes';

                                                        ?>

                                                        <div class=comment_count>

                                                            <span> (<span class="c_count <?= $hghfv->id; ?>"><?= count($total_comments); ?></span>)<a onclick="saveusercomment(this,event)" href="highfive-usercomment-modal?uid=<?= $user_id; ?>&cid=<?= $hghfv->id; ?>" data-toggle="modal" data-modal-id="highfive-usercomment"> Add Comment</a></span>

                                                        </div>

                                                    <?php endif; ?>

                                                    <input type="hidden" value="<?= $enable_comment; ?>" id="add_comment_feature"/>

                                                </div>

                                                <?php if (!empty($comment_image)) :?>

                                                    <div class="user-attached desk">

                                                        <span class="user-uploads">

                                                            <?php

                                                            foreach ($comment_image as $cimg):

                                                                $cimg_path = $baseurl . '/uploads/high_five/' . $cimg->feature_value;

                                                                $temp_img_path = $baseurl . '/images/defer_load.gif';

                                                                ?>

                                                                <a class="img_modal <?= $cimg->id; ?>" href="highfive-image-zoom-modal?img_id=<?= $cimg->id; ?>" data-toggle="modal" data-modal-id="highfive-image-zoom1" onclick='highfivezoommodal(this,event)'> 

                                                                    <img id="cimg_<?= $cimg->id; ?>" alt="image" title="View Image" src="<?= $cimg_path; ?>" data-src="<?= $cimg_path; ?>" class="img-attach zoom_image hf_img">

                                                                </a>

                                                            <?php endforeach; ?>

                                                        </span>

                                                    </div>

                                                <?php endif; ?>

                                            </div>

                                            <?php

                                            $i++;

                                        endforeach;

                                    endif;

                                    ?>