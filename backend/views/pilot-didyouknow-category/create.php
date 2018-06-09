<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCategory */

$this->title = 'Create Pilot Didyouknow Category';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Didyouknow Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-didyouknow-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
