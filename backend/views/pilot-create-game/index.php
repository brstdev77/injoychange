<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotManageGameSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Manage Challenges';
//$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games Listing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Yii::$app->homeUrl . 'css/game.css');
$this->registerJsFile(Yii::$app->homeUrl . 'js/game.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/bootstrap-notify.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$role = \backend\models\PilotInhouseUser::isUserAdmin(Yii::$app->user->identity->id);
?>
<div class="pilot-manage-game-index">
    <?php if (Yii::$app->session->getFlash('created')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('created'); ?>
        </div>
    <?php } ?>

    <div class="grid_managegame grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Game Listing</h3>
                <?= Html::a('Add Challenge<i class="fa fa-plus"></i>', ['game'], ['class' => 'btn btn-default pull-right']) ?>
            </div>

            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'header' => 'S No.',
                        'headerOptions' => ['width' => '50'],
                    ],
                    [
                        'label' => 'Company Name',
                        'attribute' => 'challenge_company_id',
                        'filter' => ArrayHelper::map(backend\models\Company::find()->asArray()->all(), 'id', 'company_name'),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '200'],
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getcompanyname($model->challenge_company_id, $model->id);
                        },
                    ],
                    [
                        'label' => 'Category Name',
                        'attribute' => 'category_id',
                        'filter' => ArrayHelper::map(backend\models\Categories::find()->asArray()->all(), 'id', 'Category_name'),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '200'],
                        'value' => function ($model) {

                            return backend\models\PilotCreateGame::getcategoryname($model->category_id, $model->id);
                        },
                    ], 
                    [
                        'label' => 'Challenge Name',
                        'attribute' => 'challenge_id',
                        'filter' => ArrayHelper::map(backend\models\PilotGameChallengeName::find()->asArray()->all(), 'id', 'challenge_name'),
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getchallengename($model->id);
                        },
                    ],
                    [
                        'label' => 'No. of Days',
                        'headerOptions' => ['width' => '90'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getnumofdays($model->id);
                        },
                    ],
                    [
                        'label' => 'Starting Date',
                        //'attribute' => 'challenge_start_date',
                        'headerOptions' => ['width' => '115'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getstartdate($model->id);
                        },
                    ],
                    [
                        'label' => 'Ending Date',
                        // 'attribute' => 'challenge_end_date',
                        'headerOptions' => ['width' => '115'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getenddate($model->id);
                        },
                    ],
                    [
                        'label' => 'Makeup Days',
                        // 'attribute' => 'challenge_end_date',
                        'headerOptions' => ['width' => '115'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getmakeupdays($model->id);
                        },
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'status',
                        'headerOptions' => ['width' => '100'],
                        'format' => 'raw',
                        'filter' => array("0" => "Upcoming", "1" => "Ongoing", "2" => "Completed"),
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getstatus($model->id);
                        },
                    ],
                    [
                        'label' => 'Manager',
                        'attribute' => 'manager',
                        //'headerOptions' => ['width' => '110'],
                        'filter' => ArrayHelper::map(backend\models\PilotInhouseUser::find()->where(['role' => '2'])->asArray()->all(), 'id', 'username'),
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getmanager($model->challenge_company_id);
                        },
                    ],
                    [
                        'label' => 'Updated By',
                        //'attribute' => 'created_user_id',
                        'headerOptions' => ['width' => '150'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getupdated($model->id);
                        },
                    ],
                    // ['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operation',
                        'headerOptions' => ['width' => '225'],
                        'template' => '{edit} {report}{detail}{delete}',
                        'buttons' => [
                            'edit' => function ($url, $model) {
                                if ($model->status != 2 || $role == 1):
                                    return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-create-game/update?id=" . $model->id . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                                else:
                                    return "<a class=' grid btn btn-default' href='#' disabled='disabled'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                                endif;
                            },
                            'detail' => function ($url, $model) {
                                return "<a  data-toggle = 'modal' data-target = '#reminder' class=' grid btn btn-default reminder' href='javascript:void(0)' rel='" . $model->id . "'><i class='fa fa-clock-o' aria-hidden='true'></i>&nbsp;Detail</a>";
                            },
                            'report' => function ($url, $model) {
                                if (($model->status) != 0)
                                    return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-create-game/report?id=" . $model->id . "'><i class='fa fa-share-square-o'></i> Report</a>";
                            },
                            'delete' => function ($url, $model) {
                                if ($model->status == 2 || $model->status == 0):
                                    return "<div class=' grid btn btn-default delete_game' rel='" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</div>";
                                else:
                                    return "<a class=' grid btn btn-default' href='#' disabled='disabled'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                                endif;
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>


<!--bootstrap model popup start here-->


<div class="container">
    <div class="modal fade" id="reminder" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>                  
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#preview">Detail</a></li>
                        <li><a data-toggle="tab" href="#remind">Reminder</a></li> 
                    </ul>
                </div>
                <div class="modal-body box no-border" style="min-height: 200px; box-shadow: none; padding-bottom: 0px; margin-bottom: 0px;">
                    <div class="overlay" style="display:none;">
                        <i class="fa fa-refresh fa-spin"></i>
                        <span class="span-loading-text">Loading...</span>
                    </div>
                    <div class="modal-contant">
                        <div id ="remind" class="tab-pane fade"></div>
                        <div id ="preview" class="tab-pane fade in active"> 
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="text-align: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>