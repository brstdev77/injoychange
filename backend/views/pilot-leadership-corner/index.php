<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
//use yii\helpers\ArrayHelper;
use backend\models\Company;
use backend\models\PilotLeadershipCorner;
use backend\models\PilotLeadershipCornerSearch;
use backend\models\PilotLeadershipCategory;
use yii\data\ActiveDataProvider;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotLeadershipCornerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Leadership Corners';
$this->params['breadcrumbs'][] = ['label' => 'pilot-leadership-category', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$searchModel = new PilotLeadershipCornerSearch();
//$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
$dataProvider = new ActiveDataProvider([
    'query' => PilotLeadershipCorner::find()->where(['category_id' => Yii::$app->request->get('cid')]),
        ]);
$category = PilotLeadershipCategory::find()->where(['id' => Yii::$app->request->get('cid')])->one();
if (!$category) {

    return Yii::$app->getResponse()->redirect(Yii::$app->homeUrl . "pilot-leadership-category/index");
}
$model = new PilotLeadershipCorner();
?>
<style>
    /*hide ssome tool of ck editor on leadership corner */
    .cke_button.cke_button__undo.cke_button_disabled {
        display: none;
    }
    .cke_button.cke_button__redo.cke_button_disabled{
        display:none;
    }
    .cke_button.cke_button__strike.cke_button_off{
        display:none;
    }
    .cke_button.cke_button__copyformatting.cke_button_off{
        display:none;
    }
    .cke_button.cke_button__removeformat.cke_button_off {
        display: none;
    }
    .cke_button.cke_button__textcolor.cke_button_off {
        display: none;
    }
    .cke_button.cke_button__bgcolor.cke_button_off{
        display:none;  
    }
    .cke_button.cke_button__link.cke_button_off {
        display: none;
    }
    .cke_button.cke_button__unlink.cke_button_disabled {
        display: none;
    }
    .cke_button.cke_button__anchor.cke_button_off {
        display: none;
    }
    .cke_button.cke_button__image.cke_button_off {
        display: none;
    }
    .cke_button.cke_button__about.cke_button_off {
        display: none;
    }
</style>


<div class="grid_leadership_corners grid_verical">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="box box-warning">
        <div class="box-header">

            <h3 class="box-title">Leadership Corner</h3>
            <?= Html::a('Add New Corner<i class="fa fa-plus"></i>', ['create', 'cid' => Yii::$app->request->get('cid')], ['class' => 'btn btn-default pull-right add-corner', 'disabled' => true]) ?>
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
                [
                    'label' => 'Corner',
                    // 'attribute' => 'title',
                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                    'headerOptions' => ['width' => '500'],
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model->popup_image)):
                            $img_src = Yii::$app->homeUrl . 'img/leadership-corner-images/lightbox-image/' . $model->popup_image;
                        else:
                            $img_src = Yii::$app->homeUrl . 'img/uploads/trans.gif.jpg';
                        endif;
                        return '<div class="row"><div class="col-md-12" style="text-align:center"><b>' . $model->title . '</b></div><div class="col-md-4" style="text-align:center"><img style="width:100px;text-align:left;" src=" ' . $img_src . ' "></div>
                            <div class="col-md-8" style="word-wrap: break-word;word-break:break-all;">' . $model->description . '</div></div>';
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
                // 'discription',
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

                        return backend\models\PilotLeadershipCorner::getUpdated($model->id, $model->user_id);
                    },
                ],
                // 'user_id',
                //  ['class' => 'yii\grid\ActionColumn'],
                ['class' => 'yii\grid\ActionColumn',
                    'header' => 'Operation',
                    'template' => '  {update}{delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return "<a question = '" . $model->question . "' answer_type = '" . $model->answer_type . "' leadership_id = '" . $model->id . "' week='" . $model->week . "' title='" . $model->title . "' dashboardimg='" . $model->dashboard_image . "' lightboximg='" . $model->popup_image . "' description='" . $model->description . " 'designation=' " . $model->designation . " 'class=' grid btn btn-default edit_leadership_corner' href='" . Yii::$app->homeUrl . "pilot-leadership-corner/update?id=" . $model->id . "&cid=" . Yii::$app->request->get('cid') . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                        },
                        'delete' => function ($url, $model) {
                            return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-leadership-corner/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
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
    <div class="modal fade" id="add_leadership_corner" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Leadership Corner</h4>
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
                    <?php
                    if ((!empty($model->popup_image))) {
                        $imgcheck = 1;
                        $class = 'existimage';
                    } else {
                        $imgcheck = 0;
                        $class = '';
                    }
                    ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('Title' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?= $form->field($model, 'designation')->textInput(['maxlength' => true])->label('Designation'); ?>
                    <?=
                    $form->field($model, 'answer_type')->dropDownList([
                        'text' => 'text',
                        'audio' => 'audio',
                        'video' => 'video',
                            ], ['prompt' => 'Select Answer Type']
                    )->label('Answer Type');
                    ?>
                    <?= $form->field($model, 'question')->textInput(['maxlength' => true])->label('Question'); ?>
                    <?=
                    $form->field($model, 'week')->dropDownList([
                        'Week 1-one' => 'Week 1-one',
                        'Week 1-two' => 'Week 1-two',
                        'Week 1-three' => 'Week 1-three',
                        'Week 2-one' => 'Week 2-one',
                        'Week 2-two' => 'Week 2-two',
                        'Week 2-three' => 'Week 2-three',
                        'Week 3-one' => 'Week 3-one',
                        'Week 3-two' => 'Week 3-two',
                        'Week 3-three' => 'Week 3-three',
                        'Week 4-one' => 'Week 4-one',
                        'Week 4-two' => 'Week 4-two',
                        'Week 4-three' => 'Week 4-three',
                        'Week 5-one' => 'Week 5-one',
                        'Week 5-two' => 'Week 5-two',
                        'Week 5-three' => 'Week 5-three',
                        'Week 6-one' => 'Week 6-one',
                        'Week 6-two' => 'Week 6-two',
                        'Week 6-three' => 'Week 6-three',
                        'Week 7-one' => 'Week 7-one',
                        'Week 7-two' => 'Week 7-two',
                        'Week 7-three' => 'Week 7-three',
                            ], ['prompt' => 'Select Week']
                    )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p id="week_error_create" style="color:#dd4b39;"></p>
                    <? //= $form->field($model, 'position')->textInput(['maxlength' => true])  ?>  
                    <?= $form->field($model, 'popup_image')->fileInput(['accept' => 'image/*', 'id' => 'browseleadership', 'class' => $class, 'maxlength' => true]) ?>
                    <div class="form-group addleadership">                        
                        <img class="removeimageleadership" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" id="removeleadership">Remove</a>
                    </div>
                    <?= $form->field($model, 'dashboard_image')->fileInput(['accept' => 'image/*', 'id' => 'browseleadershipdashboard', 'class' => $class, 'maxlength' => true]) ?>
                    <div class="form-group leadershipdashboard">                       
                        <img class="removeimagedashboard" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" id="removeleadershipdashboard">Remove</a>
                    </div>
                    <?=
                    $form->field($model, 'description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'basic'
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
    <div class="modal fade" id="edit_leadership_corner" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Leadership Corner</h4>
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
                    <?php
                    if ((!empty($model->popup_image))) {
                        $imgcheck = 1;
                        $class = 'existimage';
                    } else {
                        $imgcheck = 0;
                        $class = '';
                    }
                    ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'id' => 'title_edit_leadership'])->label('Title' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?= $form->field($model, 'designation')->textInput(['maxlength' => true, 'id' => 'designation_edit_leadership'])->label('Designation'); ?>
                    <?= $form->field($model, 'question')->textInput(['maxlength' => true, 'id' => 'question_edit_leadership'])->label('Question'); ?>
                    <?=
                    $form->field($model, 'answer_type')->dropDownList([
                        'text' => 'text',
                        'audio' => 'audio',
                        'video' => 'video',
                            ], ['prompt' => 'Select Answer Type', 'id' => 'answer_edit_leadership']
                    )->label('Answer Type');
                    ?>
                    <?=
                    $form->field($model, 'week')->dropDownList([
                        'Week 1-one' => 'Week 1-one',
                        'Week 1-two' => 'Week 1-two',
                        'Week 1-three' => 'Week 1-three',
                        'Week 2-one' => 'Week 2-one',
                        'Week 2-two' => 'Week 2-two',
                        'Week 2-three' => 'Week 2-three',
                        'Week 3-one' => 'Week 3-one',
                        'Week 3-two' => 'Week 3-two',
                        'Week 3-three' => 'Week 3-three',
                        'Week 4-one' => 'Week 4-one',
                        'Week 4-two' => 'Week 4-two',
                        'Week 4-three' => 'Week 4-three',
                        'Week 5-one' => 'Week 5-one',
                        'Week 5-two' => 'Week 5-two',
                        'Week 5-three' => 'Week 5-three',
                        'Week 6-one' => 'Week 6-one',
                        'Week 6-two' => 'Week 6-two',
                        'Week 6-three' => 'Week 6-three',
                        'Week 7-one' => 'Week 7-one',
                        'Week 7-two' => 'Week 7-two',
                        'Week 7-three' => 'Week 7-three',
                            ], ['prompt' => 'Select Week', 'id' => 'week_edit_leadership']
                    )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p id="week_error_edit" style="color:#dd4b39;"></p>
                    <?= $form->field($model, 'popup_image')->fileInput(['accept' => 'image/*', 'id' => 'browselightboxedit', 'class' => $class, 'maxlength' => true]) ?>
                    <div class="form-group" style="position: relative; min-height:80px;float:left;width:100%;">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='lightboximgupdate' type='hidden' name="lightboximgupdate" value='0'>
                        <img class="removelightboxedit"style="margin-right:20px;width:100px; float:left;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" style="margin-top: 2%;" id="removebuttonlightboxedit">Remove</a>
                        <div class=" fa fa-refresh fa-spin imageloader"></div>
                        <b class="loadingtext">Loading...</b>
                    </div>
                    <?= $form->field($model, 'dashboard_image')->fileInput(['accept' => 'image/*', 'id' => 'browsedashboardedit', 'class' => $class, 'maxlength' => true]) ?>
                    <div class="form-group" style="position: relative; min-height:80px;float:left;width:100%;">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='dashboardimgupdate' type='hidden' name="dashboardimgupdate" value='0'>
                        <img class="removedashboardedit"style="margin-right:20px;width:100px; float:left;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/"><a class="btn btn-default" style="margin-top: 2%;" id="removebuttondashboardedit">Remove</a>
                        <div class=" fa fa-refresh fa-spin imageloaderdash"></div>
                        <b class="loadingtextdash">Loading...</b>
                    </div>
                    <?=
                    $form->field($model, 'description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6, 'id' => 'descrition_edit_leadership'],
                        'preset' => 'basic',
                    ])->label('Description' . Html::tag('span', '*', ['class' => 'required']));
                    ;
                    ?>
                    <?=
                    $form->field($model, 'category_id'
                    )->textInput(['id' => 'leadership_id', 'readonly' => true])->label('');
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
