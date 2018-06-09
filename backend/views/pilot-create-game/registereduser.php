<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use kartik\file\FileInput;
use backend\models\PilotCreateGame;
use frontend\models\PilotFrontCoreHighfiveSearch;

$this->title = 'Registered User';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Report', 'url' => ['report?id=' . Yii::$app->getRequest()->getQueryParam('id')]];
//$this->params['breadcrumbs'][] = ['label' => $model->id];
$this->params['breadcrumbs'][] = 'Registered User';
?>


    <div class="grid_managegame grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Registered User Listing</h3>
                <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i> Download', ['downloadregistereduser?id='.Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-default pull-right']) ?>
            </div>
            <div class="box-body">
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
                            'label' => 'First Name/Last Name',
                            'format' => 'raw',
                            'attribute' => 'username',
                            'headerOptions' => ['width' => '200'],
                            'value' => function ($model) { 
                                if(empty($model->profile_pic))
								{
									$image = 'noimage.png';
								}
								else
								{
									$image = $model->profile_pic;
								}							
                                return '<div class="image-wrapper"><img width="100" alt="" src="/frontend/web/uploads/' . $image . '"></div><div style="padding-top:9px;">' . $model->username . '</div>';
                            },
                        ],
                        [
                            'label' => 'email',
                            'format' => 'raw',
                             'attribute' => 'emailaddress',
                            'headerOptions' => ['width' => '200'],
                            'value' => function ($model) {
                                return $model->emailaddress;
                            },
                        ],                                              
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
