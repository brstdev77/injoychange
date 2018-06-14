<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\PilotFrontCoreStepsApiData */

$this->title = 'Create Pilot Front Core Steps Api Data';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Front Core Steps Api Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-front-core-steps-api-data-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
