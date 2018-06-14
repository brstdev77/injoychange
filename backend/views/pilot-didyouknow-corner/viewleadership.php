<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\Company;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotLeadershipCornerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*
 * use company model to fetch the company name
 * according to the listing
 */

$model = Company::find()->where(['id'=>Yii::$app->request->get('cid')])->one();
$this->title = 'Pilot Leadership Corner';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Leadership Corners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->company_name];

?>



<div class="grid_manageclients">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="box box-warning">
        <div class="box-header">

            <h3 class="box-title"><?= ucfirst($model->company_name) ?>: Leadership Corner </h3>
            <?= Html::a('Add Leadership Corner<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-default pull-right']) ?>
        </div>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn',
                    'header' => 'S No.',
                ],
                //  'id',
                //'title',
                //'picture',
                //'client_listing',              
               /* [
                    'label' => 'Company Name',
                    //'attribute' => 'client_listing',       
                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                    //'headerOptions' => ['width' => '300'],
                    'format' => 'html',
                    'value' => function ($model) {
                        return "<div class='image-wrapper'>" . Html::img(Yii::$app->homeUrl . "uploads/" . backend\models\PilotLeadershipCorner::getClientImage($model->client_listing), ['width' => '100px']) . "</div><div class=comname>" . backend\models\PilotLeadershipCorner::getClientname($model->client_listing) . '</div>';
                        //return backend\models\PilotLeadershipCorner::getClientname($model->client_listing);
                    },
                ],*/
                [
                    'label' => 'Title',
                    'attribute' => 'title',
                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                    //'headerOptions' => ['width' => '300'],
                    'format' => 'html',
                    'value' => function ($model) {

                        return "<div class='image-wrapper'>" . Html::img(Yii::$app->homeUrl . "img/leadership-corner-images/" . backend\models\PilotLeadershipCorner::getImageName($model->id), ['width' => '100px']) . "</div><div class=comname>" . $model->title . '</div>';
                    },
                ],
                            'week',
                // 'discription',
                // 'created',
                //'updated',
                'position',
                [
                    'label' => 'Updated by',
                    //'attribute' => 'updated',
                    //'htmlOptions'=>array('style'=>'width: 50px; text-align: center;', 'class'=>'zzz'),
                    //'headerOptions' => ['width' => '300'],
                    'format' => 'html',
                    'value' => function ($model) {

                        return backend\models\PilotLeadershipCorner::getUpdated($model->id, $model->user_id);
                    },
                ],
                // 'user_id',
                //  ['class' => 'yii\grid\ActionColumn'],
                ['class' => 'yii\grid\ActionColumn',
                    'header' => 'Operation',
                    'template' => '  {update}{delete}',
                    'buttons' => [

                        'update' => function ($url, $model) {
                            return "<a class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-leadership-corner/update?id=" . $model->id . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";
                        },
                        'delete' => function ($url, $model) {
                            return "<a data-method='post' data-confirm='Are you sure you want to delete this item?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-leadership-corner/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                        },
                    ],
                ],
            ],
        ]);
        ?>

    </div>
</div>


