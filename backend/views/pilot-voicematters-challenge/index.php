<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use backend\models\PilotActionmattersChallenge;
use backend\models\PilotActionmattersChallengeSearch;
use yii\data\ActiveDataProvider;
use backend\models\PilotActionmattersCategory;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotActionmattersChallengeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Voicematters Challenges';
$this->params['breadcrumbs'][] = $this->title;
$searchModel = new PilotActionmattersChallengeSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider = new ActiveDataProvider([
    'query' => PilotActionmattersChallenge::find()->where(['category_id' => Yii::$app->request->get('cid')]),
        ]);
$category = PilotActionmattersCategory::find()->where(['id' => Yii::$app->request->get('cid')])->one();
if (!$category) {

    return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-category-content/index");
}
$model = new PilotActionmattersChallenge();
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

                <h3 class="box-title">Voice Matters Question</h3>
                <?= Html::a('Add Question<i class="fa fa-plus"></i>', ['#'], ['class' => 'btn btn-default pull-right create', 'data-toggle' => 'modal', 'data-target' => '#add_video']) ?>
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
                    ['label' => 'Week',
                        //'attribute' => 'week',
                         'headerOptions' => ['width' => '210'],
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotActionmattersChallenge::getWeek($model->id);
                        },
                    ],
                    //'video_title',
                    [
                        'label' => 'Question',
                        //'attribute' =>'video_title',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotActionmattersChallenge::getWeektitle($model->id);
                        },
                    ],
                    //  ['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Edit/Delete',
                        'headerOptions' => ['width' => '210'],
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return '<a class="edit-btn week-video-edit  grid btn btn-default"  week ="'.$model->week.'" week-id ="'.$model->id.'" data-title =" '.$model->question.'"  data-toggle = "modal" data-target = "#edit_video" href="#"><i class="fa fa-pencil-square-o"></i>&nbsp;Edit</a>';
                            },
                            'delete' => function ($url, $model) {
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this item?' class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-voicematters-challenge/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
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
                            <h4 class="modal-title">Add Question</h4>
                        </div>
                        <div class="modal-body">

                            <input class ="category_id" type='hidden' value='<?php echo Yii::$app->request->get('cid'); ?>' name='category_id'>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'create_question',
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
                            )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                            ;
                            ?>

                            <?=
                            $form->field($model, 'question'
                            )->textInput()->label('Question' . Html::tag('span', '*', ['class' => 'required']));
                            ;
                            ?>
                            <input type="hidden" value="<?= Yii::$app->request->get('cid');?>" name="category_id" />
                        </div>
                        <div class="modal-footer">
                            <?= Html::Button('Submit', ['class' => 'btn btn-success', 'id' => 'video_submit']) ?>
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
                            <h4 class="modal-title">Edit Question</h4>
                        </div>
                        <div class="modal-body">

                            <input class ="category_id" type='hidden' value='<?php echo Yii::$app->request->get('cid'); ?>' name='category_id'>
                            <?php
                            $form = ActiveForm::begin([
                                        'id' => 'edit-popup-question',
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
                            )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                            ;
                            ?>

                            <?=
                            $form->field($model, 'question'
                            )->textInput(['id' => 'question_action'])->label('Question' . Html::tag('span', '*', ['class' => 'required']));
                            ;
                            ?>
                            <?=
                            $form->field($model, 'category_id'
                            )->hiddenInput(['id' => 'week_id', 'readonly' => true])->label('');
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
        <style>
            #pilotactionmatterschallenge-category_id {
                display: none;
            }
        </style>

