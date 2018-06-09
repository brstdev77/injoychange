<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\PilotFrontCoreStepsApiData */

$this->title = 'Update Pilot Front Core Steps Api Data: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Front Core Steps Api Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-front-core-steps-api-data-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
