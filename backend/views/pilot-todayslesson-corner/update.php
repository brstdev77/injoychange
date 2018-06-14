<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */

$this->title = 'Update Pilot Todays Lesson Corner';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Todays Lesson Corners', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-todayslesson-corner-update">
    <?= $this->render('_form', [
        'model' => $model,
        'question' => $question,
        'question1' => $question1
    ]) ?>

</div>
