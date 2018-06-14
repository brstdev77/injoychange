<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PilotFrontCoreStepsApiDataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Front Core Steps Api Datas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-front-core-steps-api-data-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pilot Front Core Steps Api Data', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'steps:ntext',
            'calories:ntext',
            'sleephr:ntext',
            // 'distance:ntext',
            // 'date:ntext',
            // 'time:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
