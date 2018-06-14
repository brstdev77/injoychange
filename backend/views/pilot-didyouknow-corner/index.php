<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
//use yii\helpers\ArrayHelper;
use backend\models\Company;
use backend\models\PilotDidyouknowCorner;
use backend\models\PilotDidyouknowCornerSearch;
use backend\models\PilotDidyouknowCategory;
use yii\data\ActiveDataProvider;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotLeadershipCornerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot DidyouKnow Corners';
$this->params['breadcrumbs'][] = ['label' => 'pilot-didyouknow-category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$searchModel = new PilotDidyouknowCornerSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider = new ActiveDataProvider([
    'query' => PilotDidyouknowCorner::find()->where(['category_id' => Yii::$app->request->get('cid')]),
        ]);
$category = PilotDidyouknowCategory::find()->where(['id' => Yii::$app->request->get('cid')])->one();
if (!$category) {

    return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-didyouknow-category/index");
}
$model = new PilotDidyouknowCorner();
?>
<style>
    /*hide ssome tool of ck editor on leadership corner */

</style>


<div class="grid_didyouknow_corners grid_verical">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="box box-warning">
        <div class="box-header">

            <h3 class="box-title">DidYouKnow Corner</h3>
            <?= Html::a('Add New Corner<i class="fa fa-plus"></i>', ['javascript:void(0)'], ['class' => 'btn btn-default pull-right add-corner', 'data-toggle' => 'modal', 'data-target' => '#add_didyouknow_corner', 'disabled' => true]) ?>
        </div>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
//                ['class' => 'yii\grid\SerialColumn',
//                    'header' => 'S No.',
//                ],
                //  'id',


                [
                    'label' => 'Week',
                    'attribute' => 'week',
                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                    'headerOptions' => ['width' => '150'],
                    'format' => 'html',
                    'value' => function ($model) {
                        return $model->week;
                    },
                ],
//                [
//                    'label' => 'Dashboard Image',
//                    //'attribute' => 'dashboard_image',
//                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
//                    //'headerOptions' => ['width' => '300'],
//                    'format' => 'html',
//                    'value' => function ($model) {
//                        if ($model->dashboard_image) {
//                            return '<img style="width:150px"src=' . Yii::$app->homeUrl . 'img/leadership-corner-images/' . $model->dashboard_image . '>';
//                        } else {
//                            return 'No Image Uploaded';
//                        }
//                    },
//                ],
//                [
//                    'label' => 'Lightbox Image',
//                    //'attribute' => 'popup_image',
//                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
//                    //'headerOptions' => ['width' => '300'],
//                    'format' => 'html',
//                    'value' => function ($model) {
//                        if ($model->popup_image) {
//                            return '<img style="width:150px"src=' . Yii::$app->homeUrl . 'img/leadership-corner-images/' . $model->popup_image . '>';
//                        } else {
//                            return 'No Image Uploaded';
//                        }
//                    },
//                ],
                [
                    'label' => 'Corner',
                    // 'attribute' => 'title',
                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                    'headerOptions' => ['width' => '500'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        return '<div class="row"><div class="col-md-8" style="word-wrap: break-word;">' . $model->description . '</div></div>';
                    },
                ],
                //  'description',
                // 'created',
                //'updated',
                // 'position',
                [
                    'label' => 'Updated by',
                    //'attribute' => 'updated',
                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                    //'headerOptions' => ['width' => '300'],
                    'format' => 'html',
                    'value' => function ($model) {

                        return backend\models\PilotDidyouknowCorner::getUpdated($model->id, $model->user_id);
                    },
                ],
                // 'user_id',
                //  ['class' => 'yii\grid\ActionColumn'],
                ['class' => 'yii\grid\ActionColumn',
                    'header' => 'Operation',
                    'template' => '  {update}{delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return "<a leadership_id = '" . $model->id . "' week='" . $model->week . "'  description='" . $model->description . " 'class=' grid btn btn-default edit_didyouknow_corner' data-toggle = 'modal', data-target = '#edit_didyouknow_corner'  href='javascript:void(0)'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                        },
                        'delete' => function ($url, $model) {
                            return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-didyouknow-corner/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                        },
                    ],
                ],
            ],
        ]);
        ?>

    </div>
</div>


<!-- bootstrap model popup  start here-->
<div class="container">
    <div class="modal fade" id="add_didyouknow_corner" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add DidYouKnow Corner</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'leadership_corner_form',
                                'options' => ['enctype' => 'multipart/form-data']]);
                    ?> 
                    <?=
                    $form->field($model, 'week')->dropDownList([
                        'Week 1-one' => 'Week 1-one',
                        'Week 1-two' => 'Week 1-two',
                        'Week 2-one' => 'Week 2-one',
                        'Week 2-two' => 'Week 2-two',
                        'Week 3-one' => 'Week 3-one',
                        'Week 3-two' => 'Week 3-two',
                        'Week 4-one' => 'Week 4-one',
                        'Week 4-two' => 'Week 4-two',
                        'Week 5-one' => 'Week 5-one',
                        'Week 5-two' => 'Week 5-two',
                        'Week 6-one' => 'Week 6-one',
                        'Week 6-two' => 'Week 6-two',
                        'Week 7-one' => 'Week 7-one',
                        'Week 7-two' => 'Week 7-two',
                            ], ['prompt' => 'Select Week']
                    )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                    ;
                    ?>
                    <p id="week_error_create" style="color:#dd4b39;"></p>
                   <?=
                    $form->field($model, 'description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'full',
                        'clientOptions' => [
                            'filebrowserUploadUrl' => 'upload'
                        ]
                    ])->label('Description' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?=
                    $form->field($model, 'category_id'
                    )->textInput(['value' => Yii::$app->request->get('cid'), 'readonly' => true])->label('');
                    ?>

                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'submit-disable']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>





<!-- edit*****************************************************************EDIT model popup  start here**************************************************************************-->
<div class="container">
    <div class="modal fade" id="edit_didyouknow_corner" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit DidYouKnow Corner</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $form = ActiveForm::begin([
                                'id' => 'leadership_corner_form',
                                'options' => ['enctype' => 'multipart/form-data']]);
                    ?> 
                    <?
                    //= $form->field($model, 'client_listing')->dropDownList(
                    // ArrayHelper::map(Company::find()->all(), 'id', 'company_name'), ['prompt' => 'Select Client']
                    // );
                    ?>
                    <?=
                    $form->field($model, 'week')->dropDownList([
                        'Week 1-one' => 'Week 1-one',
                        'Week 1-two' => 'Week 1-two',
                        'Week 2-one' => 'Week 2-one',
                        'Week 2-two' => 'Week 2-two',
                        'Week 3-one' => 'Week 3-one',
                        'Week 3-two' => 'Week 3-two',
                        'Week 4-one' => 'Week 4-one',
                        'Week 4-two' => 'Week 4-two',
                        'Week 5-one' => 'Week 5-one',
                        'Week 5-two' => 'Week 5-two',
                        'Week 6-one' => 'Week 6-one',
                        'Week 6-two' => 'Week 6-two',
                        'Week 7-one' => 'Week 7-one',
                        'Week 7-two' => 'Week 7-two',
                            ], ['prompt' => 'Select Week', 'id' => 'week_edit_didyouknow']
                    )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p id="week_error_edit" style="color:#dd4b39;"></p>
                    <?=
                    $form->field($model, 'description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6, 'id' => 'descrition_edit_didyouknow'],
                        'preset' => 'full',
                        'clientOptions' => [
                            'filebrowserUploadUrl' => 'upload'
                        ]
                    ])->label('Description' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?=
                    $form->field($model, 'category_id'
                    )->textInput(['id' => 'didyouknow_id', 'readonly' => true])->label('');
                    ?>

                </div>
                <div class="modal-footer">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'id' => 'update-disable']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                <?php ActiveForm::end(); ?>
            </div>

        </div>

    </div>
</div>

<style>
    .field-didyouknow_id,.field-pilotdidyouknowcorner-category_id{
        display:none;
    }
</style>
