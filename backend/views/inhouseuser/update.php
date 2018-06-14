<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotInhouseUser */

$this->title = 'Update Pilot Inhouse User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Inhouse Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-inhouse-user-update">



    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
