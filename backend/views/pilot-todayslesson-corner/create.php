<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */

$this->title = 'Create Pilot Todays Lesson Corner';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Today Lesson Corners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-todayslessong-corner-create">

   

    <?= $this->render('_form', [
        'model' => $model,
        'question' => $question
    ]) ?>

</div>
