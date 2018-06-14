<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use kartik\file\FileInput;
use backend\models\PilotCreateGame;
use frontend\models\PilotFrontCoreHighfiveSearch;

$value = '';
$this->title = 'Registered User';
$this->params['breadcrumbs'][] = $this->title;
$count = $dataProvider->getTotalCount();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$array = [
    ['id' => 'Computer', 'name' => 'Computer'],
    ['id' => 'Mobile', 'name' => 'Mobile'],
    ['id' => 'Tablet', 'name' => 'Tablet'],
];
$result = ArrayHelper::map($array, 'id', 'name');
$username = '';
$emailaddress = '';
$company = '';
$device = '';
if (!empty($_GET)):
    $username = $_GET['PilotFrontUserSearch']['username'];
    $emailaddress = $_GET['PilotFrontUserSearch']['emailaddress'];
    $company = $_GET['PilotFrontUserSearch']['company_id'];
    $device = $_GET['PilotFrontUserSearch']['device'];
    $status = $_GET['PilotFrontUserSearch']['status'];
    $team_id = $_GET['PilotFrontUserSearch']['team_id'];
endif;
$value = Yii::$app->request->get('PilotFrontUserSearch')['username'];
?>
<div class="grid_managegame grid_verical">
    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">Registered User Listing</h3>
            <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                    <input type="text" name="user_search" class="form-control pull-right" placeholder="Search" value='<?= $value; ?>'>

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default submit"><i class="fa fa-search"></i></button>
                        <button style="margin-left: 12px;" class="btn btn-default reset-search">Reset</button>
                    </div>
                </div>
            </div>
<?= Html::a('<i class="fa fa-download" aria-hidden="true"></i> Download', ['downloaduser?username=' . $username . '&emailaddress=' . $emailaddress . '&company_id=' . $company . '&device=' . $device . '&status=' . $status. '&team_id=' . $team_id], ['class' => 'btn btn-default pull-right']) ?>
        </div>
        <div class="box-body">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [//'class' => 'yii\grid\SerialColumn',
                        'header' => 'S No.',
                        'headerOptions' => ['width' => '50'],
                        'value' => function ($model, $key, $index, $widget) use ($count, $page) {
                            //$number = $index + 1;
                            $count1 = $count - $index;
                            $per_pag = 50;
                            if ($page > 1) {
                                $number = $count1 - ($per_pag * ($page - 1));
                            } else {
                                $number = (($page - 1) * $per_pag) + $count1;
                            }
                            return $number;
                        }
                    ],
                    [
                        'label' => 'First Name/Last Name',
                        'format' => 'raw',
                        'attribute' => 'username',
                        'headerOptions' => ['width' => '150'],
                        'value' => function ($model) {
                            if (empty($model->profile_pic)) {
                                $image = 'noimage.png';
                            } else {
                                $image = 'thumb_'.$model->profile_pic;
                            }
                            return '<div class="image-wrapper"><img width="100" alt="" src="/frontend/web/uploads/' . $image . '"></div><div style="padding-top:9px;">' . $model->username . '</div>';
                        },
                    ],
                    [
                        'label' => 'Email',
                        'format' => 'raw',
                        'attribute' => 'emailaddress',
                        'headerOptions' => ['width' => '75'],
                        'value' => function ($model) { 
                            return $model->emailaddress;
                        },
                    ],
                    [
                        'label' => 'Company Name',
                        'attribute' => 'company_id',
                        'filter' => ArrayHelper::map(backend\models\Company::find()->asArray()->all(), 'id', 'company_name'),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '100'],
                        'value' => function ($model) {
                            return frontend\models\PilotFrontUser::getcompanyname($model->company_id);
                        },
                    ],
                    [
                        'label' => 'Team Name',
                        'attribute' => 'team_id',
                        'filter' => ArrayHelper::map(backend\models\PilotCompanyTeams::find()->asArray()->all(), 'id', 'team_name'),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '100'],
                        'value' => function ($model) {
                            if ($model->team_id == '') {
                                return 'NA';
                            } else {
                                return frontend\models\PilotFrontUser::getteamname($model->company_id, $model->team_id);
                            }
                        },
                    ],
                    [
                        'label' => 'Last Login',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '150'],
                        'value' => function ($model) {
                            return frontend\models\PilotFrontUser::gettimeago($model->last_access_time);
                            ;
                        },
                    ],
                    [
                        'label' => 'Device',
                        'attribute' => 'device',
                        'filter' => $result,
                        'format' => 'raw',
                        'headerOptions' => ['width' => '100'],
                        'value' => function ($model) {
                            return $model->device;
                        },
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'status',
                        'filter' => array('10' => 'Active', '0' => 'Inactive'),
                        'format' => 'raw',
                        'headerOptions' => ['width' => '100'],
                        'value' => function ($model) {
                            if ($model->status == 10):
                                return 'Active';
                            else:
                                return 'Inactive';
                            endif;
                        },
                    ],
                    [
                        'label' => 'Browser',
                        'format' => 'raw',
                        'headerOptions' => ['width' => '100'],
                        'value' => function ($model) {
                            return $model->browser;
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operation',
                        'headerOptions' => ['width' => '150'],
                        'template' => '{edit}{detail}{delete}',
                        'buttons' => [
                            'edit' => function ($url, $model) {
                                return "<a href='" . Yii::$app->homeUrl . "site/update?id=" . $model->id . "'><span class='glyphicon glyphicon-pencil'></span></a>";
                            },
                            'detail' => function ($url, $model) {
                                return "<a href='#' class='view-user' data-toggle='modal' data-target='#view_user' id1='".$model->id."'><span class='glyphicon glyphicon-eye-open'></span></a>";
                            },
                            'delete' => function ($url, $model) {
                                return "<a href='" . Yii::$app->homeUrl . "site/delete?id=" . $model->id . "' data-confirm='Are you sure to delete this user?' ><i class='fa fa-trash-o'></i></a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
<style>
    .pull-right {
        margin-left: 13px;
        position: absolute;
    }
</style>
<div class="container">
    <div class="modal fade" id="view_user" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">User Information</h4>
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