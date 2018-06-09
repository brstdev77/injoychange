<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCategory */

$this->title = 'Update Pilot Leadership Category: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Leadership Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-leadership-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
