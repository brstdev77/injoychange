<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotCorevaluesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Corevalues';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Yii::$app->homeUrl . 'css/bootstrap-tagsinput.css');
$this->registerJsFile(Yii::$app->homeUrl . 'js/bootstrap-tagsinput.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/typeahead.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/tag.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.mark.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$rows = (new \yii\db\Query())
        ->select([tags])
        ->from('pilot_tags')
        ->all();
// echo "<pre>";print_r($rows);die;
foreach ($rows as $row) {
    $output[] = $row[tags];
}
if (!empty($output)):
    $tag = implode(',', $output);
endif;
$tags_name = [];
?>
<div class="pilot-corevalues-index">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="grid_managegame grid_verical">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Core Values</h3>

                <?= Html::a('Add Core Values <i class="fa fa-plus"></i>', ['javascript:void(0)'], ['class' => 'btn btn-default pull-right', 'data-toggle' => 'modal', 'data-target' => '#add_core_values']) ?>
            </div>



            <?php Pjax::begin(); ?>    <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],

                    [
                        'label' => 'Company Name',
                        'attribute' => 'company_id',
                        'format' => 'html',
                        'value' => function ($model) {
                            $company = backend\models\Company::find()->where(['id' => $model->company_id])->one();
                            //return Html::img(Yii::$app->homeUrl . 'img/uploads/' . $company->image, ['width' => '100px']) . '<br>' . $company->company_name;
                            return "<div class='image-wrapper'>" . Html::img(Yii::$app->homeUrl . "img/uploads/" . $company->image, ['width' => '100px']) . "</div><div class=comname>" . $company->company_name . '</div>';
                        }
                    ],
                    [
                        'label' => 'Core Values',
                        'format' => 'html',
                        'value' => function ($model) {
                            $corecount = count(backend\models\PilotCompanyCorevaluesname::find()->where(['company_id' => $model->company_id])->all());
                            return $corecount . ' Core Values';
                        }
                    ],
                    //['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operation',
                        'template' => '{update} {view} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return "<a class='grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-corevalues/corevalue?cid=" . $model->company_id . "' ><i class='fa fa-pencil-square-o'></i>Edit</a>";
                            },
                            'view' => function ($url, $model) {
                                return "<a class='grid btn btn-default view-button'  data-toggle = 'modal' data-target = '#view_core_values' href='#' id1='" . $model->company_id . "'><i class='fa fa-clock-o' aria-hidden='true'></i>View</a>";
                            },
                            'delete' => function ($url, $model) {
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-corevalues/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?>
        </div>

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Core Value Images</h3>
                <?= Html::a('Add Category <i class="fa fa-plus"></i>', ['javascript:void(0)'], ['class' => 'btn btn-default pull-right', 'data-toggle' => 'modal', 'data-target' => '#add_category']) ?>
            </div>  <?=
            GridView::widget([
                'dataProvider' => $dataProvider1,
                'filterModel' => $searchModel1,
                'columns' => [
                    // ['class' => 'yii\grid\SerialColumn'],

                    [
                        'label' => 'Category Name',
                        'attribute' => 'category_name',
                        'format' => 'raw',
                        'value' => function ($model1) {
                            return $model1->category_name . '<a href="#" class="pull-right edit-button" data-toggle="modal" data-target="#edit_category" id1="' . $model1->id . '"><span class="glyphicon glyphicon-pencil"></span></a>';
                        }
                    ],
                    [
                        'label' => 'Tag Name',
                        'attribute' => 'tag_id',
                        'contentOptions' => ['class' => 'tags-column'],
                        'headerOptions' => ['class' => 'tags-column'],
                        //'rowOptions'=>function ($model, $key, $index, $grid){if($model->is_deleted){return ['class'=>'red'];}},
                        'format' => 'raw',
                        'value' => function ($model1) {
                            if (!empty($model1->tag_id)):
                                $modal_id = $model1->id;
                                $tags[] = explode(',', $model1->tag_id);
                                foreach ($tags as $value => $new) {
                                    foreach ($new as $tag_id) {
                                        $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                        $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                    }
                                }
                                $tags_string = implode(' ', $tags_name);
                                return $tags_string;
                            else:
                                return 'NA';
                            endif;
                        },
                    ],
                    [
                            'label' => 'Core Images',
                            'format' => 'html',
                            'value' => function ($model1) {
                                $imagecount = backend\models\PilotCoreValueImage::getRecords($model1->id);
                                    return '<i class="fa fa-paste"></i>&nbsp;&nbsp;' . $imagecount . ' Images&nbsp;&nbsp;<a href="' . Yii::$app->homeUrl .
                                            'pilot-corevalues/coreimage?cid=' . $model1->id . '" class="btn btn-default">Manage</a>';
                            },
                        ],
                    [
                        'label' => 'Last Updated by',
                        //'attribute' => 'updated',
                        'format' => 'html',
                        'value' => function ($model1) {
                            return backend\models\PilotCoreValuesImageCategory::getUpdated($model1->id, $model1->user_id);
                        },
                    ],
                    //['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operation',
                        'template' => '{delete}',
                        'buttons' => [
                            'delete' => function ($url, $model1) {
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-corevalues/category-delete?id=" . $model1->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>

        <!--************************************CREATE MODEL POPUP START HERE*********************************************************************************-->

        <div class="container">
            <div class="modal fade" id="add_core_values" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Core Value</h4>
                        </div>
                        <div class="modal-body">
                            <?php $form = ActiveForm::begin(); ?>
                            <?=
                            $form->field($model, 'company_id')->dropDownList(
                                    ArrayHelper::map(backend\models\Company::find()->all(), 'id', 'company_name'), ['prompt' => 'Select Company']
                            )->label('For which company you want to add Core Values' . Html::tag('span', '*', ['class' => 'required']));
                            ;
                            ?>
                            <p style="color:#dd4b39;" id="alredyexistcomid"></p>
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'submit_core_values']) ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <!--bootstrap model start here  -->
        <div class="container">
            <div class="modal fade" id="add_category" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Add Category</h4>
                        </div>
                        <div class="modal-body">
                            <?php
                            $form = ActiveForm::begin([
                                        'action' => 'core-image-category',
                                        'id' => 'login-dash',
                                        'options' => ['enctype' => 'multipart/form-data']]);
                            ?> 
                            <?=
                            $form->field($model1, 'category_name'
                            )->textInput()->label('Category Name' . Html::tag('span', '*', ['class' => 'required']));
                            ?>
                            <?=
                            $form->field($model2, 'tags'
                            )->textInput(['class' => 'form-control input-sm tagsInput typeahead'])->label('Add Tags' . Html::tag('span', '*', ['class' => 'required']));
                            ?>
                            <p class="notetext">Note:Use Comma(,) or Enter to separate tags.</p>
                            <!--label>Add Tags</label>
                            <div>
                                <input type="text" value="" data-role="tagsinput" id="tags1" class="form-control"></div-->

                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'form-high-five']) ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="hidden" class="custom_tags" value="<?= $tag ?>">
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="modal fade" id="view_core_values" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Core Value</h4>
                        </div>
                        <div class="modal-body">
                            <div class="modal-ajax-loader">
                                <img src="http://devinjoyglobal.com/pilot/frontend/web/images/ajax-loader.gif">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="modal fade" id="edit_category" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Tags</h4>
                        </div>
                        <div class="modal-form">
                            <div class="modal-ajax-loader">  
                                <img src="http://devinjoyglobal.com/pilot/frontend/web/images/ajax-loader.gif"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        