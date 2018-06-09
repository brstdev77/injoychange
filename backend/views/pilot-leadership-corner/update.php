<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */

$this->title = 'Update Pilot Leadership Corner';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Leadership Corners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-leadership-corner-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
