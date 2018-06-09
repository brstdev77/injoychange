<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotSupportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Supports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-support-index">


    <div class="grid_managegame grid_verical">
        <div class="box box-warning">            

            <?php Pjax::begin(); ?>    <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'header'=>'S.No.'
                        ],
                  //  'id',
                    'email:email',
                    'subject',
                   // 'image',
                    'description',
                   // ['class' => 'yii\grid\ActionColumn'],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operation',
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return "<a  class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-support/update?id=" . $model->id . "'><i class='fa fa-pencil-square-o'></i>View</a>";
                            },
                            'delete' => function ($url, $model) {
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-support/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
            <?php Pjax::end(); ?></div>
    </div>
</div>
