<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Gamecompetition */

$this->title = 'Add Client ';
$this->params['breadcrumbs'][] = ['label' => 'Client Listing', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-create">



    <?=
    $this->render('_form', [
        'model' => $model,
        'team' => $team,
         'corename' => $corename
    ])
    ?>

</div>
