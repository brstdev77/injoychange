<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use backend\models\PilotWeeklyChallenge;
use backend\models\PilotWeeklyChallengeSearch;
use yii\data\ActiveDataProvider;
use backend\models\PilotWeeklyCategory;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotWeeklyChallengeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Weekly Challenges';
$this->params['breadcrumbs'][] = $this->title;
$searchModel = new PilotWeeklyChallengeSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider = new ActiveDataProvider([
    'query' => PilotWeeklyChallenge::find()->where(['category_id' => Yii::$app->request->get('cid')]),
        ]);
$category = PilotWeeklyCategory::find()->where(['id' => Yii::$app->request->get('cid')])->one();
if (!$category) {

    return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-category-content/index");
}
$model = new PilotWeeklyChallenge();
?>
<div class="pilot-weekly-challenge-index">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="grid_weekly_challenge grid_verical">
        <div class="box box-warning">
            <div class="box-header">

                <h3 class="box-title">Weekly Video</h3>
                <?= Html::a('Add New Video<i class="fa fa-plus"></i>', ['#'], ['class' => 'btn btn-default pull-right create', 'data-toggle' => 'modal', 'data-target' => '#add_video']) ?>
            </div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
//                    ['class' => 'yii\grid\SerialColumn',
//                        'header' => 'S No.',
//                    ],
                    // 'id',
                    //'category_id',
                    //'week',
                    [ 'label' => 'Week',
                        //'attribute' => 'week',
                       // 'headerOptions' => ['width' => '210'],
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotWeeklyChallenge::getWeek($model->id);
                        },
                    ],
                    //'video_title',
                    [
                        'label' => 'Title',
                        //'attribute' =>'video_title',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotWeeklyChallenge::getWeektitle($model->id);
                        },
                    ],
                    //'video_link',
                    [
                        'label' => 'Embed Video',
                        //'attribute' =>'video_link',
                        'format' => 'raw',
                        'value' => function ($model) {
                          //  return backend\models\PilotWeeklyChallenge::getVideo($model->id);
                           return "<iframe width='262' height='130' src=" . backend\models\PilotWeeklyChallenge::getVideo($model->id) . "></iframe>";
                        },
                    ],
                    [
                        'label' => 'Video Image',
                        //'attribute' =>'video_link',
                        'format' => 'raw',
                        'value' => function ($model) {
                            if ($model->image) {
                                return "<img width='262' height='130' src=" . Yii::$app->homeUrl . '/img/weekly-challenge-images/' . $model->image . "></img>";
                            } else {
                                return 'No Image Uploaded';
                            }
                        },
                    ],
                    //  ['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Edit/Delete',
                        'template' => '{update}{delete}',
                        'buttons' => [

                            'update' => function ($url, $model) {
                                return "<a class='edit-btn week-video-edit  grid btn btn-default' image ='$model->image' week ='$model->week' week-id ='$model->id' data-title ='$model->video_title' video-link= '$model->video_link' data-toggle = 'modal' data-target = '#edit_video' href='#'><i class='fa fa-pencil-square-o'></i>&nbsp;Edit</a>";
                            },
                            'delete' => function ($url, $model) {
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this item?' class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-weekly-challenge/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
        <!-- bootstrap model popup  start here-->
        <div class="container">
            <div class="modal fade" id="add_video" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Video</h4>
                        </div>
                        <div class="modal-body">

                            <input class ="category_id" type='hidden' value='<?php echo Yii::$app->request->get('cid'); ?>' name='category_id'>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'login-dash',
                                        'options' => ['enctype' => 'multipart/form-data']]);
                            ?> 

                            <?=
                            $form->field($model, 'week', ['template' => '{label}{input}<span style="color:#dd4b39;"id="week_error"></span>{error}'])->dropdownList([
                                1 => 'week 1',
                                2 => 'week 2',
                                3 => 'week 3',
                                4 => 'week 4',
                                5 => 'week 5',
                                6 => 'week 6',
                                7 => 'week 7',
                                8 => 'week 8',
                                9 => 'week 9',
                                10 => 'week 10',
                                    ], ['prompt' => 'Select Week', 'id' => 'week']
                            )->label('Week'.Html::tag('span','*',['class'=>'required']));;
                            ?>

                            <?=
                            $form->field($model, 'video_title'
                            )->textInput()->label('Video Title'.Html::tag('span','*',['class'=>'required']));;
                            ?>
                            <?=
                            $form->field($model, 'video_link'
                            )->textInput()->label('Video Link'.Html::tag('span','*',['class'=>'required']));;
                            ?>

                            <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*', 'class' => 'browsecreate']); ?>
                            <div class="form-group">
                                <input class='imgcheckcreate' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                                <input class='imgupdatecreate' type='hidden' name="imgupdate" value='0'>
                                <img class="removeimage create"style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/weekly-challenge-images/<?php echo $model->image ?>"><a href="javascript:void(0)" class="removecreate btn btn-default">Remove</a>
                            </div>
                            <?=
                            $form->field($model, 'category_id'
                            )->textInput(['value' => Yii::$app->request->get('cid'), 'readonly' => true])->label('');
                            ?>
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'video_submit']) ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>

                </div>

            </div>
        </div>




        <!--edit *********************************************************************************************************-->

        <div class="container">
            <div class="modal fade" id="edit_video" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Video</h4>
                        </div>
                        <div class="modal-body">

                            <input class ="category_id" type='hidden' value='<?php echo Yii::$app->request->get('cid'); ?>' name='category_id'>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'edit-popup-weekly-video',
                                        'options' => ['enctype' => 'multipart/form-data']]);
                            ?> 

                            <?=
                            $form->field($model, 'week', ['template' => '{label}{input}<span style="color:#dd4b39;"id="week_edit_error"></span>{error}'])->dropdownList([
                                1 => 'week 1',
                                2 => 'week 2',
                                3 => 'week 3',
                                4 => 'week 4',
                                5 => 'week 5',
                                6 => 'week 6',
                                7 => 'week 7',
                                8 => 'week 8',
                                9 => 'week 9',
                                10 => 'week 10',
                                    ], ['prompt' => 'Select Week', 'id' => 'week_edit']
                            )->label('Week'.Html::tag('span','*',['class'=>'required']));;
                            ?>

                            <?=
                            $form->field($model, 'video_title'
                            )->textInput(['id' => 'video_title_val'])->label('Video Title'.Html::tag('span','*',['class'=>'required']));;
                            ?>
                            <?=
                            $form->field($model, 'video_link'
                            )->textInput(['id' => 'video_link_val'])->label('Video Link'.Html::tag('span','*',['class'=>'required']));;
                            ?>

                            <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*', 'class' => 'browse']); ?>
                            <div class="form-group" style="position: relative; min-height:80px;">
                                <input class='imgcheckedit' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                                <input class='imgupdateedit' type='hidden' name="imgupdateedit" value='0'>
                                <img class="popimg update"style="margin-right:20px;width:100px; float:left;"src="/backend/web/img/weekly-challenge-images/<?php echo $model->image ?>"><a href="javascript:void(0)"class="removeupdate btn btn-default" style="margin-top: 2%;">Remove</a>
                                <div class=" fa fa-refresh fa-spin imageloader"></div>
                                <b class="loadingtext">Loading...</b>
                            </div>
                            <?=
                            $form->field($model, 'category_id'
                            )->textInput(['id' => 'week_id'])->label('');
                            ?>

                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'id' => 'update_submit']) ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>


