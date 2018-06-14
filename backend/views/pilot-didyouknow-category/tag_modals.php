<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Category</h4>
</div>
<?php
$form = ActiveForm::begin([
            'id' => 'form-load-tags',
            'options' => ['enctype' => 'multipart/form-data'],
            'errorSummaryCssClass' => 'alert alert-danger',
            'enableAjaxValidation' => FALSE,
            'enableClientValidation' => TRUE,
        ]);
?>
<div class="modal-body">
    <?=
    $form->field($model, 'id', ['inputOptions' => ['value' => $id]])->hiddenInput()->label(false);
    ?>
    <?=
    $form->field($model, 'category_name', ['inputOptions' => ['value' => $category_name]]
    )->textInput(['class' => 'form-control'])->label('Category Name' . Html::tag('span', '*', ['class' => 'required']));
    ?>
    <?=
            $form->field($model1, 'tags', ['inputOptions' => ['value' => $tags_name]])
            ->textInput(['class' => 'form-control input-sm tagsInput typeahead', 'id' => 'pilottags-tags1'])->label('Edit Tags');
    ?>
    <p class="notetext">Note:Use Comma(,) or Enter to separate tags.</p>
</div>
</div>
<div class="modal-footer">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'form-high-five']) ?>
    <button type="button" class="btn btn-default ajax-loader" data-dismiss="modal">Close</button>
    <input type="hidden" class="custom_tags" value="<?= $tags_name ?>"
</div>
<?php ActiveForm::end(); ?>