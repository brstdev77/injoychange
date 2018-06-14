<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotSurveyQuestion */

$this->title = 'Create Pilot Survey Question';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Survey Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-survey-question-create">



    <?= $this->render('_form', [
        'model' => $model,
        'model1' => $model1,
    ]) ?>

</div>
