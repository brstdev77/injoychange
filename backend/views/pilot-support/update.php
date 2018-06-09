<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotSupport */

$this->title = 'Update Pilot Support: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Supports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-support-update">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
