<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotCheckinYourselfCategory */

$this->title = 'Create Pilot Checkin Yourself Category';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Checkin Yourself Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-checkin-yourself-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
