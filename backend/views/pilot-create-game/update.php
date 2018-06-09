<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotManageGame */

$this->title = 'Update Pilot Manage Challenge: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-manage-game-update">


    <?= $this->render('gameupdate', [
        'model' => $model,
    ]) ?>

</div>
