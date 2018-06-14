<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PilotFrontCoreStepsApiData */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilot-front-core-steps-api-data-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'steps')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'calories')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sleephr')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'distance')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'time')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
