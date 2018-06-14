<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotCheckinYourselfCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Checkin Yourself Categories';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($coremodal, 'category_id')->textInput(['value' => $cid]) ?>

<?= $form->field($coremodal, 'question_label')->textInput(['maxlength' => true])->label('Main Question'); ?>

<?= $form->field($coremodal, 'placeholder_text')->textInput(['maxlength' => true])->label('Placeholder Text Inside Text Box'); ?>

<?= $form->field($coremodal, 'select_option_text')->textInput(['maxlength' => true])->label('Drop Down Menu Text'); ?>

<?//= $form->field($coremodal, 'core_value[1]')->textInput(['maxlength' => true])->label('Core Value 1') ?>

<?php
$n = 1;
foreach ($corevalues as $value) {
    if($n > 1){
        $remove = '<div class="input-group-addon" style="cursor:pointer;"><i aria-hidden="true" class="fa fa-times"></i></div>';
    }else{
        $remove = '';
    }
    echo '<div class="form-group field-PilotCheckinYourselfData-core_value-'.$n.'  required">
                           <div class="removecorevalue"><label>Drop Down Option '.$n.'</label>
                           <div class="input-group removecorevalue" style="width:100%">
                           <input type="text" name="PilotCheckinYourselfData[core_value]['.$value->id.']" class="form-control" id="PilotCheckinYourselfData-core_value-'.$n.'" maxlength="255" aria-invalid="false" value="'.$value->core_value.'"/>
                                 '.$remove.'
                               </div></div>
                               <p class="help-block help-block-error"></p></div>';
    $n++;
}
$n = $n - 1;
if(empty($corevalues)){
    echo '<div class="form-group field-PilotCheckinYourselfData-core_value-1  required">
                           <div class="removecorevalue"><label>Drop Down Option 1</label>
                           <div class="input-group removecorevalue" style="width:100%">
                           <input type="text" name="PilotCheckinYourselfData[core_value][1]" class="form-control" id="PilotCheckinYourselfData-core_value-1" maxlength="255" aria-invalid="false" value=""/>
                               </div></div>
                               <p class="help-block help-block-error"></p></div>';
    $n = 1;
}
?>
<input type="hidden" id="corenamecount" value="<?= $n; ?>">
<input type="hidden" id="corenameserial" value="<?= $n; ?>">
<a href="javascript:void(0)" class="btn btn-default addmore-checkin">Add More&nbsp;<i class="fa fa-plus"></i></a>
<div class="modal-footer">
<?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'submit_core_values']) ?>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
<?php ActiveForm::end(); ?>