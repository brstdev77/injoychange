<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\PilotInhouseUser;
use backend\models\PilotLogs;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotLogsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .btn.btn-default.pull-right .fa.fa-trash-o {
        background-color: #e7e7e7;
        border-left: 1px solid #ccc;
        margin-left: 8px;
        padding: 6px;
    }
</style>
<div class="pilot-logs-index">
    <div class="grid_logs grid_verical">
        <div class="box box-info">
            <div class="box-header">
                <h3 class="box-title">Logs</h3>
                <?= Html::a('Clear All<i class="fa fa-trash-o"></i>', ['clear'], ['class' => 'btn btn-default pull-right']) ?>
            </div>
            <h1><? //= Html::encode($this->title)            ?></h1>
            <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>
            <p>
                <? //= Html::a('Create Pilot Logs', ['create'], ['class' => 'btn btn-success'])   ?>
            </p>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    /* ['class' => 'yii\grid\SerialColumn',
                      'header' => 'S No.',
                      ], */
                    [
                        'label' => 'Type',
                        'attribute' => 'type',
                        'format' => 'html',
                        'headerOptions' => ['width' => '70'],
                    ],
                    [
                        'label' => 'Log Type',
                        'attribute' => 'log_type',
                        'format' => 'html',
                        'headerOptions' => ['width' => '100'],
                    ],
                    'message',
                    'refer',
                    'location',
                    [
                        'label' => 'Date',
                        //'attribute' => 'timestamp',
                        'format' => 'html',
                        'headerOptions' => ['width' => '100'],
                        'value' => function ($model) {
                            return backend\models\PilotLogs::logdate($model->id);
                        },
                    ],
                    [
                        'label' => 'User Name',
                        //'attribute' => 'user_id',
                        'format' => 'html',
                         'headerOptions' => ['width' => '100'],
                        'value' => function ($model) {
                            return backend\models\PilotInhouseUser::getusername($model->user_id);
                        },
                    ],
                    //'refer',
                    // 'location',
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operations',
                        'template' => '{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return "<a rel='" . $model->id . "' class='grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-logs/view?id=" . $model->id . "' ><i class='fa fa-eye'></i>&nbsp;View</a>";
                            },
                            'delete' => function ($url, $model) {
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this event?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-logs/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>

        </div>
    </div>
</div>
