<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\PilotFrontUser */

$this->title = 'Create Pilot Front User';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Front Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-front-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
