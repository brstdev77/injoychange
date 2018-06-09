<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotInhouseUser */

$this->title = 'Create Pilot Inhouse User';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Inhouse Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-inhouse-user-create">



    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
