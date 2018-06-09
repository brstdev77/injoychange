<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotPrizesCategory */

$this->title = 'Update Pilot Prizes Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Prizes Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-prizes-category-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
