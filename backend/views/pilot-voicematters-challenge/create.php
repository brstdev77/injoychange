<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotWeeklyChallenge */

$this->title = 'Create Pilot Weekly Challenge';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Weekly Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-weekly-challenge-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
