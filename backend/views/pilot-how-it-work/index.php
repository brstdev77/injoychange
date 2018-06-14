<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use backend\models\PilotInhouseUser;
use backend\models\PilotCreateGame;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotHowItWorkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$highlight_tag1 = Yii::$app->request->get('PilotHowItWorkSearch');
if ($highlight_tag1 != '') {
    $highlight_tag = $highlight_tag1['tag_id'];
}
$this->title = 'Pilot How It Works';
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
<div class="pilot-how-it-work-index">

<?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
        <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
<?php } ?>
    <div class="grid_managegame grid_verical">

        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">How It Works</h3>

            <?= Html::a('Add New Category  <i class="fa fa-plus"></i>', ['javascript:void(0)'], ['class' => 'btn btn-default pull-right', 'data-toggle' => 'modal', 'data-target' => '#add_how_it_work_values']) ?>
            </div>
            <?php if (PilotInhouseUser::isUserAdmin(Yii::$app->user->identity->id)): ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],
                        //'id',
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
                            'format' => 'html',
                            'value' => function ($model) {
                                if (!empty($model->tag_id)):
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
                        //'how_it_work_content',
                        //'user_id',
                        //'created',
                        // 'updated',
                        [
                            'label' => 'Last Updated by',
                            'format' => 'html',
                            'value' => function ($model) {
                                $date = date('M j, Y', $model->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                        //['class' => 'yii\grid\ActionColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Operation',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                /* 'edit' => function($url, $model){
                                  return '<a href="#" class="grid btn btn-default edit-button" data-toggle="modal" data-target="#edit_category" id1="' . $model->id . '"><i class="fa fa-pencil-square-o"></i>Edit Tags</a>';
                                  }, */
                                'update' => function ($url, $model) {
                                    return "<a class='grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-how-it-work/update?id=" . $model->id . "' ><i class='fa fa-pencil-square-o'></i>Edit</a>";
                                },
                                'delete' => function ($url, $model) {
                                    $howitwork_content = array();
                                    $game_obj = PilotCreateGame::find()->all();
                                    foreach ($game_obj as $game):
                                        $howitwork_content[] = $game->howitwork_content;
                                    endforeach;
                                    if (!(in_array($model->id, $howitwork_content))):
                                        return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-how-it-work/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                                    else:
                                        return "<a class=' grid btn btn-default' disabled='disabled'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                                    endif;
                                },
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
                        //['class' => 'yii\grid\SerialColumn'],
                        //'id',
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
                            'format' => 'html',
                            'value' => function ($model) {
                                if (!empty($model->tag_id)):
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
                        //'how_it_work_content',
                        //'user_id',
                        //'created',
                        // 'updated',
                        [
                            'label' => 'Last Updated by',
                            'format' => 'html',
                            'value' => function ($model) {
                                $date = date('M j, Y', $model->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                        //['class' => 'yii\grid\ActionColumn'],
                        ['class' => 'yii\grid\ActionColumn',
                            'header' => 'Operation',
                            'template' => '{update}',
                            'buttons' => [
                                /* 'edit' => function($url, $model){
                                  return '<a href="#" class="grid btn btn-default edit-button" data-toggle="modal" data-target="#edit_category" id1="' . $model->id . '"><i class="fa fa-pencil-square-o"></i>Edit Tags</a>';
                                  }, */
                                'update' => function ($url, $model) {
                                    return "<a class='grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-how-it-work/update?id=" . $model->id . "' ><i class='fa fa-pencil-square-o'></i>Edit</a>";
                                }
                            ],
                        ],
                    ],
                ]);
                ?>
<?php endif; ?>
        </div>
    </div>
</div>
<input type="hidden" name="highlight_tag" value="<?= $highlight_tag; ?>" id="highlight_tag">
<!--************************************CREATE MODEL POPUP START HERE*********************************************************************************-->

<!--bootstrap model popup  start here  -->
<div class="container">
    <div class="modal fade" id="add_how_it_work_values" role="dialog" data-backdrop="static" data-keyboard="false">
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
                                'id' => 'checkin-yourself-dash',
                                'options' => ['enctype' => 'multipart/form-data']]);
                    ?> 
                    <?=
                    $form->field($model, 'category_name'
                    )->textInput();
                    ?>
<?= $form->field($model1, 'tags')->textInput(['class' => 'form-control input-sm tagsInput typeahead'])->label('Add Tags' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <p class="notetext">Note:Use Comma(,) or Enter to separate tags.</p>
                </div>
                <div class="modal-footer">
<?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="hidden" class="custom_tags" value="<?= $tag ?>">
                </div>
<?php ActiveForm::end(); ?>
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