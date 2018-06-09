<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotManageGame */

$this->title = 'Create Pilot Manage Game';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-manage-game-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
