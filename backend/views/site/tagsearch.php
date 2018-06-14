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
$this->title = 'Tag Search';
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Yii::$app->homeUrl . 'css/bootstrap-tagsinput.css');
$this->registerJsFile(Yii::$app->homeUrl . 'js/bootstrap-tagsinput.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.mark.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$rows = (new \yii\db\Query())
        ->select([tags])
        ->from('pilot_tags')
        ->all();
$highlight_tag1 = Yii::$app->request->get('PilotTags');
$highlight_tag = $highlight_tag1['tags'];
// echo "<pre>";print_r($rows);die;
foreach ($rows as $row) {
    $output[] = $row[tags];
}
$tag = implode(',', $output);
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
        <?php if ($dataProvider->getTotalCount() > 0): ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Daily Inspiration</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
//                    ['class' => 'yii\grid\SerialColumn',
//                        'header' => 'S No.',
//                    ],
                        // 'id',,
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model) {
                                return $model->category_name;
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
            </div>
            <?php
        endif;
        if ($dataProvider1->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Weekly Challenge</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider1,
                    'columns' => [
//                    ['class' => 'yii\grid\SerialColumn',
//                        'header' => 'S No.',
//                    ],
                        //  'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model1) {
                                return $model1->category_name;
                            }
                        ],
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
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
                            'label' => 'Last Updated by',
                            //'attribute' => 'updated',
                            'format' => 'html',
                            'value' => function ($model1) {
                                return backend\models\PilotWeeklyCategory::getUpdated($model1->id, $model1->user_id);
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider2->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Leadership Corner</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider2,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],
                        // 'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model2) {
                                return $model2->category_name;
                            }
                        ],
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'format' => 'html',
                            'value' => function ($model2) {
                                if (!empty($model2->tag_id)):
                                    $tags[] = explode(',', $model2->tag_id);
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
                            'label' => 'Last Updated by',
                            //'attribute' => 'updated',
                            'format' => 'html',
                            'value' => function ($model2) {
                                return backend\models\PilotLeadershipCategory::getUpdated($model2->id, $model2->user_id);
                            },
                        ],
                    ],
                ]);
                ?>
            </div> 
            <?php
        endif;
        if ($dataProvider3->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in How it Work</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider3,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model3) {
                                return $model3->category_name;
                            }
                        ],
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'format' => 'html',
                            'value' => function ($model3) {
                                if (!empty($model3->tag_id)):
                                    $tags[] = explode(',', $model3->tag_id);
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
                            'value' => function ($model3) {
                                $date = date('M j, Y', $model3->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model3->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider4->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Prizes Category</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider4,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model4) {
                                return $model4->category_name;
                            }
                        ],
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'format' => 'html',
                            'value' => function ($model4) {
                                if (!empty($model4->tag_id)):
                                    $tags[] = explode(',', $model4->tag_id);
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
                        //'user_id',
                        [
                            'label' => 'Last Updated by',
                            'format' => 'html',
                            'value' => function ($model4) {
                                $date = date('M j, Y', $model4->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model4->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider5->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in CheckInYourself Category</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider5,
                    'columns' => [
                        //['class' => 'yii\grid\SerialColumn'],
                        //'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model5) {
                                return $model5->category_name;
                            }
                        ],
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'format' => 'html',
                            'value' => function ($model5) {
                                if (!empty($model5->tag_id)):
                                    $tags[] = explode(',', $model5->tag_id);
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
                        //'user_id',
                        //'created',
                        //'updated',
                        [
                            'label' => 'Last Updated by',
                            'format' => 'html',
                            'value' => function ($model5) {
                                $date = date('M j, Y', $model5->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model5->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider6->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Survey Questions</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider6,
                    'columns' => [
                        //'id',
                        [
                            'label' => 'Question',
                            'attribute' => 'question',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model6) {
                                return $model6->question;
                            }
                        ],
                        //'created',
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'value' => function ($model6) {
                                if (!empty($model6->tag_id)):
                                    $tags[] = explode(',', $model6->tag_id);
                                    foreach ($tags as $value => $new) {
                                        foreach ($new as $tag_id) {
                                            $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                            $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                        }
                                    }
                                    $tags_string = implode(' ', $tags_name);
                                    return $tags_string;
                                else:
                                    return ' ';
                                endif;
                            },
                        ],
                        [
                            'label' => 'Updated By',
                            //'attribute' => 'created',
                            'format' => 'raw',
                            'value' => function ($model6) {
                                $date = date('M j, Y', $model6->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model6->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider7->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Action Matters</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider7,
                    'columns' => [
                        //'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model7) {
                                return $model7->category_name;
                            }
                        ],
                        //'created',
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'value' => function ($model7) {
                                if (!empty($model7->tag_id)):
                                    $tags[] = explode(',', $model7->tag_id);
                                    foreach ($tags as $value => $new) {
                                        foreach ($new as $tag_id) {
                                            $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                            $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                        }
                                    }
                                    $tags_string = implode(' ', $tags_name);
                                    return $tags_string;
                                else:
                                    return ' ';
                                endif;
                            },
                        ],
                        [
                            'label' => 'Updated By',
                            //'attribute' => 'created',
                            'format' => 'raw',
                            'value' => function ($model7) {
                                $date = date('M j, Y', $model7->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model7->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider8->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Did You know</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider8,
                    'columns' => [
                        //'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model8) {
                                return $model8->category_name;
                            }
                        ],
                        //'created',
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'value' => function ($model8) {
                                if (!empty($model8->tag_id)):
                                    $tags[] = explode(',', $model8->tag_id);
                                    foreach ($tags as $value => $new) {
                                        foreach ($new as $tag_id) {
                                            $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                            $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                        }
                                    }
                                    $tags_string = implode(' ', $tags_name);
                                    return $tags_string;
                                else:
                                    return ' ';
                                endif;
                            },
                        ],
                        [
                            'label' => 'Updated By',
                            //'attribute' => 'created',
                            'format' => 'raw',
                            'value' => function ($model8) {
                                $date = date('M j, Y', $model8->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model8->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider9->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Get to know</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider9,
                    'columns' => [
                        //'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model9) {
                                return $model9->category_name;
                            }
                        ],
                        //'created',
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'value' => function ($model9) {
                                if (!empty($model9->tag_id)):
                                    $tags[] = explode(',', $model9->tag_id);
                                    foreach ($tags as $value => $new) {
                                        foreach ($new as $tag_id) {
                                            $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                            $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                        }
                                    }
                                    $tags_string = implode(' ', $tags_name);
                                    return $tags_string;
                                else:
                                    return ' ';
                                endif;
                            },
                        ],
                        [
                            'label' => 'Updated By',
                            //'attribute' => 'created',
                            'format' => 'raw',
                            'value' => function ($model9) {
                                $date = date('M j, Y', $model9->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model9->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
            <?php
        endif;
        if ($dataProvider10->getTotalCount() > 0):
            ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Data found in Todays Lesson</h3>
                </div>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider10,
                    'columns' => [
                        //'id',
                        [
                            'label' => 'Category Name',
                            'attribute' => 'category_name',
                            'format' => 'raw',
                            'contentOptions' => ['style' => 'width:650px;'],
                            'value' => function ($model10) {
                                return $model10->category_name;
                            }
                        ],
                        //'created',
                        [
                            'label' => 'Tag Name',
                            'attribute' => 'tag_id',
                            'format' => 'html',
                            'contentOptions' => ['class' => 'tags-column'],
                            'headerOptions' => ['class' => 'tags-column'],
                            'value' => function ($model10) {
                                if (!empty($model10->tag_id)):
                                    $tags[] = explode(',', $model10->tag_id);
                                    foreach ($tags as $value => $new) {
                                        foreach ($new as $tag_id) {
                                            $tags_name1 = backend\models\PilotTags::getRecords($tag_id);
                                            $tags_name[] = '<span class="tag label label-info">' . $tags_name1 . '</span>';
                                        }
                                    }
                                    $tags_string = implode(' ', $tags_name);
                                    return $tags_string;
                                else:
                                    return ' ';
                                endif;
                            },
                        ],
                        [
                            'label' => 'Updated By',
                            //'attribute' => 'created',
                            'format' => 'raw',
                            'value' => function ($model10) {
                                $date = date('M j, Y', $model10->updated);
                                $username = backend\models\PilotInhouseUser::getUsername($model10->user_id);
                                return $username . '<br />' . $date;
                            },
                        ],
                    ],
                ]);
                ?>
            </div>
        <?php endif; ?>
        <?php if ($dataProvider->getTotalCount() < 1 && $dataProvider1->getTotalCount() < 1 && $dataProvider2->getTotalCount() < 1 && $dataProvider3->getTotalCount() < 1 && $dataProvider4->getTotalCount() < 1 && $dataProvider5->getTotalCount() < 1 && $dataProvider6->getTotalCount() < 1 && $dataProvider7->getTotalCount() < 1 && $dataProvider8->getTotalCount() < 1 && $dataProvider9->getTotalCount() < 1 && $dataProvider10->getTotalCount() < 1): ?>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">No Such Tag Found</h3>
                </div>
            </div> 
        <?php endif; ?>
    </div>
    <input type="hidden" name="highlight_tag" value="<?= $highlight_tag; ?>" id="highlight_tag1">
</div>