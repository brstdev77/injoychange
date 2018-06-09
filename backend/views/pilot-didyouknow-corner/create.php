<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */

$this->title = 'Create Pilot Leadership Corner';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Leadership Corners', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-leadership-corner-create">

   

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
