<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\company */

$this->title = 'Edit: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Client Listing', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, /*'url' => ['view', 'id' => $model->id]*/];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="company-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'team' =>$team,
        'corename' => $corename
    ])
    ?>

</div>
