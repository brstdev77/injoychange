<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\companySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Client Listing';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">


    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>

    <div class="grid_manageclients grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Company Listing</h3>
                <?= Html::a('Add Company<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-default pull-right']) ?>
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
                    [
                        'label' => 'Name',
                        'attribute' => 'company_name',
                        //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                        'headerOptions' => ['width' => '350'],
                        'format' => 'raw',
                        'value' => function ($model) {
                            $comp = str_replace(' ', '-', strtolower($model->company_name));
                            $check_comp = $comp . '.injoychange.com';
                            return "<div class='image-wrapper'>" . Html::img(Yii::$app->homeUrl . "img/uploads/" . backend\models\Company::getImageName($model->id), ['width' => '100px']) . "</div><div class=comname>" . $model->company_name . "</div><div class='cmpnyLink'><a target='_blank' href='http://" . $check_comp . "'>" . $check_comp . "</a></div>";
                        },
                    ],
                    [
                        'label' => 'Contact',
                        'attribute' => 'phone',
                        'headerOptions' => ['width' => '200'],
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\Company::getContact($model->id);
                        }
                    ],
                    //'company_address',
                    [
                        'label' => 'Email Address',
                        'headerOptions' => ['width' => '110'],
                        'attribute' => 'email_address_1',
                        'value' => 'email_address_1'
                    ],
                    //'image',
                    // 'full_name',
                    [
                        // 'attribute' => 'email_address_1',
                        'headerOptions' => ['width' => '250'],
                        'label' => 'Current Game',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotCreateGame::getcurrentgame($model->id);
                        }
                    ],
                    //'additional_info',
                    // 'email_address_2:email',
                    // 'phone',
                    // 'fax',
                    // 'manager',
                    // 'team_name_1',
                    // 'team_name_2',
                    // 'start_date',
                    // 'end_date',
                    // 'status',
                    // 'remarks',
                    // 'user_id',
                    // 'created',
                    // 'updated',
                    [
                        'label' => 'Last Updated by',
                        'headerOptions' => ['width' => '120'],
                        //'attribute' => 'updated',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\Company::getUpdated($model->id, $model->user_id);
                        },
                    ],
                    [
                        'label' => 'Status',
                        // 'headerOptions' => ['width' => '50'],
                        //'attribute' => 'status',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\Company::getStatus($model->id);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operation',
                        'headerOptions' => ['width' => '230'],
                        'template' => '{user} {view} {update}',
                        'buttons' => [
                            'user' => function ($url, $model) {
                                return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "manageclients/index?id=" . $model->id . "'><i class='fa fa-user'></i> Profile</a>";
                            },
                            'update' => function ($url, $model) {
                                return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "manageclients/update?id=" . $model->id . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                            },
                            'view' => function ($url, $model) {
                                return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "manageclients/index?id=" . $model->id . "'><i class='fa fa-share-square-o'></i> Report</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
