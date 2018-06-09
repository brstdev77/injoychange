<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotDailyinspirationCategory */

$this->title = 'Create Pilot Dailyinspiration Category';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Dailyinspiration Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-dailyinspiration-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
