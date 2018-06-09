<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use backend\models\PilotTags;
use backend\models\PilotInhouseUser;
use backend\models\PilotCreateGame;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotDailyinspirationCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$highlight_tag1 = Yii::$app->request->get('PilotDailyinspirationCategorySearch');
if ($highlight_tag1 != '') {
    $highlight_tag = $highlight_tag1['tag_id'];
}
$this->title = 'Daily Inspiration Categories';
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
if(!empty($output)):
$tag = implode(',', $output);
endif;
$tags_name = [];
?>
<div class="pilot-dailyinspiration-category-index">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="grid_dailyinspiration grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Daily Inspiration</h3>
                <?= Html::a('Add New Category <i class="fa fa-plus"></i>', ['javascript:void(0)'], ['class' => 'btn btn-default pull-right', 'data-toggle' => 'modal', 'data-target' => '#add_category']) ?>
            </div>


            <?php if (PilotInhouseUser::isUserAdmin(Yii::$app->user->identity->id)): ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
//                    ['class' => 'yii\grid\SerialColumn',
//                        'header' => 'S No.',
//                    ],
                        // 'id',,
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->category_name . '<a href="#" class="pull-right edit-button" data-toggle="modal" data-target="#edit_category" id1="' . $model->id . '"><span class="glyphicon glyphicon-pencil"></span></a>';
                            }
                        ],
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            //'rowOptions'=>function ($model, $key, $index, $grid){if($model->is_deleted){return ['class'=>'red'];}},
                            'format' => 'raw',
                            'value' => function ($model) {
                                if (!empty($model->tag_id)):
                                    $modal_id = $model->id;
                                    $tags[] = explode(',', $model->tag_id);
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
                            'label' => 'Daily Inspiration',
                            'attribute' => 'daily_inspiration',
                            'format' => 'html',
                            'value' => function ($model) {
                                $imagecount = backend\models\PilotDailyinspirationImage::getRecords($model->id);
                                if ($imagecount < 31) {
                                    return '<i class="fa fa-paste"></i>&nbsp;&nbsp;' . $imagecount . ' Images&nbsp;&nbsp;<a href="' . Yii::$app->homeUrl .
                                            'pilot-dailyinspiration-category/dailyinspiration?cid=' . $model->id . '" class="btn btn-default">Manage</a><span title="Upload 31 images"style="color:red">pending</span>';
                                } else {
                                    return '<i class="fa fa-paste"></i>&nbsp;&nbsp;' . $imagecount . ' Images&nbsp;&nbsp;<a href="' . Yii::$app->homeUrl .
                                            'pilot-dailyinspiration-category/dailyinspiration?cid=' . $model->id . '" class="btn btn-default">Manage</a>';
                                }
                            },
                        ],
                        // 'user_id',
                        //  'created',
                        //'updated',
                        [
                            'label' => 'Last Updated by',
                            //'attribute' => 'updated',
                            'format' => 'html',
                            'value' => function ($model) {
                                return backend\models\PilotDailyinspirationCategory::getUpdated($model->id, $model->user_id);
                            },
                        ],
                        //  ['class' => 'yii\grid\ActionColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Operation',
                            'template' => '{delete}',
                            'buttons' => [
                                /* 'edit' => function($url, $model){
                                  return '<a href="#" class="grid btn btn-default edit-button" data-toggle="modal" data-target="#edit_category" id1="' . $model->id . '"><i class="fa fa-pencil-square-o"></i>edit</a>';
                                  }, */
                                'delete' => function ($url, $model) {
                                    $daily_inspiration = array();
                                    $game_obj = PilotCreateGame::find()->all();
                                    foreach ($game_obj as $game):
                                        $daily_inspiration[] = $game->daily_inspiration_content;
                                    endforeach;
                                    if (!(in_array($model->id, $daily_inspiration))):
                                        return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-dailyinspiration-category/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                                    else:
                                        return "<a class=' grid btn btn-default' disabled='disabled'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                                    endif;
                                }
                            ],
                        ],
                    ],
                ]);
                ?>
            <?php else: ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
//                    ['class' => 'yii\grid\SerialColumn',
//                        'header' => 'S No.',
//                    ],
                        // 'id',,
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return $model->category_name . '<a href="#" class="pull-right edit-button" data-toggle="modal" data-target="#edit_category" id1="' . $model->id . '"><span class="glyphicon glyphicon-pencil"></span></a>';
                            }
                        ],
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            //'rowOptions'=>function ($model, $key, $index, $grid){if($model->is_deleted){return ['class'=>'red'];}},
                            'format' => 'raw',
                            'value' => function ($model) {
                                if (!empty($model->tag_id)):
                                    $modal_id = $model->id;
                                    $tags[] = explode(',', $model->tag_id);
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
                            'label' => 'Daily Inspiration',
                            'attribute' => 'daily_inspiration',
                            'format' => 'html',
                            'value' => function ($model) {
                                $imagecount = backend\models\PilotDailyinspirationImage::getRecords($model->id);
                                if ($imagecount < 31) {
                                    return '<i class="fa fa-paste"></i>&nbsp;&nbsp;' . $imagecount . ' Images&nbsp;&nbsp;<a href="' . Yii::$app->homeUrl .
                                            'pilot-dailyinspiration-category/dailyinspiration?cid=' . $model->id . '" class="btn btn-default">Manage</a><span title="Upload 31 images"style="color:red">pending</span>';
                                } else {
                                    return '<i class="fa fa-paste"></i>&nbsp;&nbsp;' . $imagecount . ' Images&nbsp;&nbsp;<a href="' . Yii::$app->homeUrl .
                                            'pilot-dailyinspiration-category/dailyinspiration?cid=' . $model->id . '" class="btn btn-default">Manage</a>';
                                }
                            },
                        ],
                        // 'user_id',
                        //  'created',
                        //'updated',
                        [
                            'label' => 'Last Updated by',
                            //'attribute' => 'updated',
                            'format' => 'html',
                            'value' => function ($model) {
                                return backend\models\PilotDailyinspirationCategory::getUpdated($model->id, $model->user_id);
                            },
                        ],
                    ],
                ]);
                ?>
            <?php endif; ?>
        </div>
    </div>
    <input type="hidden" name="highlight_tag" value="<?= $highlight_tag; ?>" id="highlight_tag">
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
                                'id' => 'login-dash',
                                'options' => ['enctype' => 'multipart/form-data']]);
                    ?> 
                    <?=
                    $form->field($model, 'category_name'
                    )->textInput()->label('Category Name' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?=
                    $form->field($model1, 'tags'
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
                        <img src="http://root.injoymore.com/frontend/web/images/ajax-loader.gif"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
