<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */

$this->title = 'Create Pilot Know Corner';
?>
<div class="pilot-gettoknow-corner-create">

    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>
</div>
