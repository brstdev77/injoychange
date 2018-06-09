<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\PilotCreateGame;
use frontend\models\PilotFrontCoreHighfiveSearch;

$this->title = 'Active User';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Report', 'url' => ['report?id=' . Yii::$app->getRequest()->getQueryParam('id')]];
//$this->params['breadcrumbs'][] = ['label' => $model->id];
$this->params['breadcrumbs'][] = 'Active User';
?>


    <div class="grid_managegame grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Active User Listing</h3>
                 <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i> Download', ['downloadactiveuser?id='.Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-default pull-right']) ?>
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
                              $user = \frontend\models\PilotFrontUser::find()->where(['id' => $model->user_id])->one();
								if(empty($user->profile_pic))
								{
									$image = 'noimage.png';
								}
								else
								{
									$image = $user->profile_pic;
								}
                                return '<div class="image-wrapper"><img width="100" alt="" src="/frontend/web/uploads/' . $image . '"></div><div style="padding-top:9px;">' . $user->username . '</div>';
                            },
                        ],
                        [
                            'label' => 'email',
                            'format' => 'raw',
                            'attribute' => 'emailaddress',
                            'headerOptions' => ['width' => '200'],
                            'value' => function ($model) {
                                $user = \frontend\models\PilotFrontUser::find()->where(['id' => $model->user_id])->one();
                                return $user->emailaddress;
                            },
                        ],                                              
                        [
                            'label' => 'Total Points',
                            'format' => 'raw',
                             'attribute' => 'total_points',
                            'headerOptions' => ['width' => '200'],
                            'value' => function ($model) {
                                return $model->total_points;
                            },
                        ],                                              
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
