<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotHowItWork */

$this->title = 'Update Pilot How It Work: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot How It Works', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pilot-how-it-work-update">

    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">How It Works</h3>
        </div>
        <div class="box-body">
            <?=
            $this->render('_form', [
                'model' => $model,
            ])
            ?>
        </div>
    </div>



</div>
