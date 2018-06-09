<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use backend\models\PilotCreateGame;
use frontend\models\PilotFrontCoreHighfiveSearch;

$this->title = 'Core Values';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Report', 'url' => ['report?id=' . Yii::$app->getRequest()->getQueryParam('id')]];
//$this->params['breadcrumbs'][] = ['label' => $model->id];
$this->params['breadcrumbs'][] = 'Core Values';
$count = $dataProvider->getTotalCount();
 if (isset($_GET['page'])) {
	  $page = $_GET['page'];
	}
	else {
	  $page = 1;
	}
?>


    <div class="grid_managegame grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Core Values Listing</h3>   
                <?= Html::a('<i class="fa fa-download" aria-hidden="true"></i> Download', ['downloadcorevalues?id='.Yii::$app->getRequest()->getQueryParam('id')], ['class' => 'btn btn-default pull-right']) ?>
            </div>
   <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'header' => 'S No.',
                        'headerOptions' => ['width' => '50'],
						'value' => function ($model, $key, $index, $widget) use ($count,$page) {
							//$number = $index + 1;
							$count1 = $count - $index;
							$per_pag = 20;
							if ($page > 1) {
							  $number = $count1 - ($per_pag * ($page - 1));
							}
							else {
							  $number = (($page - 1) * $per_pag) + $count1;
							}
							return $number;
						} 
						
                    ],
                      [
                            'label' => 'First Name/Last Name',
                            'format' => 'raw',
                            'attribute' => 'username',
                            //'headerOptions' => ['width' => '200'],
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
                            'label' => 'Date',
                            'format' => 'raw',
                            'headerOptions' => ['width' => '200'],
                            'value' => function ($model) {
                                return date('M d, Y', strtotime($model->dayset));
                            },
                        ],
                      [
                        'label' => 'Core Values',
                        'attribute' => 'label',
                        //'headerOptions' => ['width' => '110'],                       
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->label;
                        },
                    ],
                    [
                        'label' => 'Comment',
                        //'headerOptions' => ['width' => '110'],                       
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->comment;
                        },
                    ],
                    ],
                ]);
            ?>
        </div>
    </div>
