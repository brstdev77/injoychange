<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotSurveyQuestion */

$this->title = 'Update Pilot Survey Question: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Survey Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-survey-question-update">

   

    <?= $this->render('_form', [
        'model' => $model,
        'model1' => $model1,
        'tags_string' => $tags_string
    ]) ?>

</div>
