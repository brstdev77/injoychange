<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotInhouseUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Inhouse Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-inhouse-user-index">
    <?php if (Yii::$app->session->getFlash('updated')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('updated'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::$app->session->getFlash('created')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('created'); ?>
        </div>
    <?php } ?>
    <?php if (Yii::$app->session->getFlash('deleted')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('deleted'); ?>
        </div>
    <?php } ?>
    <div class="grid_user grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Inhouse User Listing</h3>
                <?= Html::a('Add Inhouse User<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-default pull-right']) ?>
            </div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'header' => 'S No.',
                        'headerOptions' => ['width' => '60'],
                    ],
                    // 'id',
                    //'username',
                    //'firstname',
                    // 'lastname',
                    [
                        'label' => 'Username',
                        // 'attribute' => 'last_access_time',
                        'format' => 'html',
                        'headerOptions' => ['width' => '300'],
                        'value' => function ($model) {
                            // return backend\models\PilotInhouseUser::getUsername($model->id);
                            return "<div class='image-wrapper'>" .
                                    Html::img(Yii::$app->homeUrl .
                                            "img/profilepic/" .
                                            backend\models\PilotInhouseUser::getImage($model->id), ['width' => '100px']) .
                                    "</div><div>" . backend\models\PilotInhouseUser::getUsername($model->id) . '<br><span class="small">' . backend\models\PilotInhouseUser::getEmail($model->id) .
                                    '</span></div>';
                        }
                    ],
                    //  'emailaddress:email',
                    [
                        'label' => 'Phone Number',
                        // 'attribute' => 'last_access_time',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotInhouseUser::getphonenumber1($model->id);
                        }
                    ],
                   
                    // 'role',
                    [
                        'label' => 'Role',
                        //  'attribute' => 'role',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotInhouseUser::getRole($model->id);
                        }
                    ],
                    [
                        'label' => 'Last Access',
                        // 'attribute' => 'last_access_time',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotInhouseUser::getIP($model->id) . '<br>' . backend\models\PilotInhouseUser::getAccesstime($model->id);
                        }
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'status',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotInhouseUser::getStatus($model->id);
                        }
                    ],
                    // 'created',
                    // 'password',
                    // 'last_login_id',
                    // 'last_access_time',
                    //  ['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operation',
                        'template' => '{user} {update} {delete}',
                        'buttons' => [
                            'user' => function ($url, $model) {
                                return "<a data-toggle = 'modal' data-target = #profile_detail class='grid btn btn-default profiledata' href='javascript:void(0)' modelid=".$model->id."><i class='fa fa-user'></i> Profile</a>";
                            },
                            'update' => function ($url, $model) {
                                return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "inhouseuser/update?id=" . $model->id . "'><i class='fa fa-pencil-square-o'></i>Edit</a>";
                            },
                            'delete' => function ($url, $model) {
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "inhouseuser/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>





<!--************************************************POPUP START HERE *********************************************-->

<div class="container">
    <div class="modal fade" id="profile_detail" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                   <!-- <h4 class="modal-title">Profile</h4>-->
                </div>
                <div id="profiledata"class="modal-body">
                   
                </div>
                <div class="modal-footer">                  
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>                    
            </div>
        </div>
    </div>
</div>
