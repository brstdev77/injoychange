<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile(Yii::$app->homeUrl . 'css/bootstrap-tagsinput.css');
$this->registerJsFile(Yii::$app->homeUrl . 'js/bootstrap-tagsinput.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/typeahead.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/tag.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$rows = (new \yii\db\Query())
        ->select([tags])
        ->from('pilot_tags')
        ->all();
// echo "<pre>";print_r($rows);die;
foreach ($rows as $row) {
    $tags[] = $row[tags];
}
foreach ($rows as $row) {
    $output[] = $row[tags];
}
if(!empty($output)):
$tag = implode(',', $output);
endif;
$tags_name = [];
/* @var $this yii\web\View */
/* @var $model backend\models\PilotSurveyQuestion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pilot-survey-question-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class='row'>
        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Survey Question</h3>
                </div>
                <div class="box-body">
                    <?= $form->field($model, 'question')->textInput()->label('Question' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?=
                    $form->field($model, 'type')->dropDownList(
                            [
                        'checkbox' => 'Checkbox',
                        'textbox' => 'Textbox',
                            ], ['prompt' => 'Select Type']
                    )->label('Answer Format' . Html::tag('span', '*', ['class' => 'required']));
                    ;
                    ?>
                    <?php if (isset($tags_string)): ?>
                        <?= $form->field($model1, 'tags', ['inputOptions' => ['value' => $tags_string]])
                        ->textInput(['class' => 'form-control input-sm tagsInput typeahead', 'id' => 'pilottags-tags'])->label('Edit Tags');
                        ?>
                    <?php else: ?>
                        <?= $form->field($model1, 'tags')->textInput(['class' => 'form-control input-sm tagsInput typeahead'])->label('Add Tags' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    <?php endif; ?>
                    <p class="notetext">Note:Use Comma(,) or Enter to separate tags.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group modal-footer" style="float:left;">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        <input type="hidden" class="custom_tags" value="<?= $tag ?>"
    </div>
    <?php ActiveForm::end(); ?>
</div>