<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\PilotCompanyCorevaluesname;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotCorevalues */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Core Values';
$this->params['breadcrumbs'][] = $this->title;

$corevalues = PilotCompanyCorevaluesname::find()->where(['company_id' => $cid])->orderBy(['id' => SORT_ASC])->all();
$model = PilotCompanyCorevaluesname::find()->where(['company_id' => $cid])->andWhere(['!=', 'vission_msg', ''])->one();
if (empty($model)) {
    $model = new PilotCompanyCorevaluesname();
}
?>

<div class="pilot-corevalues-manage">
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class='col-md-12 no-padding'>
        <?php $form = ActiveForm::begin(); ?>
        <div class='col-md-8'>
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Core Values</h3>
                </div>
                <div class="box-body no-padding">
                    <?php
                    $n = 1;
                    foreach ($corevalues as $value) {
                        if (empty($value->core_values_name)) {
                            continue;
                        }
                        if ($n > 1) {
                            $remove = '<div class="cross-wrapper"><a href="javascript:void(0)">X</a></div>';
                        } else {
                            $remove = '';
                        }
                        echo '<div class="corevalue-wrapper">
                               ' . $remove . '
                               <div class="col-md-6">
                                  <div class="form-group field-pilotcompanycorevaluesname-core_values_name-' . $n . '  required">
                                      <label>Core Value ' . $n . '</label>
                                      <input type="text" name="pilotcompanycorevaluesname-core_values_name[core_values_name][' . $value->id . ']" class="form-control" id="pilotcompanycorevaluesname-core_values_name-' . $n . '" maxlength="255" aria-invalid="false" value="' . $value->core_values_name . '"/>
                                     <p class="help-block help-block-error"></p>
                                 </div>
                               </div>';

                        echo '<div class="col-md-6">
                                <div class="form-group field-pilotcompanycorevaluesname-definition-' . $n . '" style="position: relative;">
                                    <label class="control-label" for="pilotcompanycorevaluesname-definition-' . $value->id . '">Definition</label>
                                    <textarea id="pilotcompanycorevaluesname-definition-' . $n . '" class="form-control" name="PilotCompanyCorevaluesname[definition][' . $value->id . ']" rows="1">' . $value->definition . '</textarea>
                                   <div class="help-block"></div>
                                </div>
                             </div>
                             <div class="sprattar"></div>
                             </div>';
                        $n++;
                    }
                    if ($n > 1) {
                        $n = $n - 1;
                    }
                    if (empty($corevalues)) {
                        echo '<div class="corevalue-wrapper">
                                <div class="col-md-6">
                                    <div class="form-group field-pilotcompanycorevaluesname-core_values_name-1  required">
                                        <label>Core Value 1</label>
                                        <input type="text" name="pilotcompanycorevaluesname-core_values_name[core_values_name][1]" class="form-control" id="pilotcompanycorevaluesname-core_values_name-1" maxlength="255" aria-invalid="false" value=""/>
                                        <p class="help-block help-block-error"></p>
                                   </div>
                               </div>';

                        echo '<div class="col-md-6">
                                <div class="form-group field-pilotcompanycorevaluesname-definition-1" style="position: relative;">
                                   <label class="control-label" for="pilotcompanycorevaluesname-definition-1">Definition</label>
                                   <textarea id="pilotcompanycorevaluesname-definition-1" class="form-control" name="PilotCompanyCorevaluesname[definition][1]" rows="1"></textarea>
                                   <div class="help-block"></div>
                                </div>
                             </div>
                             <div class="sprattar"></div>
                            </div>';
                    }
                    ?>
                    <div class='col-md-12 append-new' style='margin-bottom:15px;'>
                        <input type="hidden" id="corenamecount" value="<?= $n; ?>">
                        <input type="hidden" id="corenameserial" value="<?= $n; ?>">
                        <a href="javascript:void(0)" class="btn btn-default addmore-corename">Add More&nbsp;<i class="fa fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">Vision Message</h3>
                </div>
                <div class="box-body no-padding">
                    <div class='col-md-12'>
                        <?= $form->field($model, 'company_id')->textInput(['class' => 'company_id', 'value' => $cid])->label('Challenge ID'); ?>
                        <?= $form->field($model, 'popup_heading')->textInput()->label('Heading'); ?>
                        <?= $form->field($model, 'core_heading')->textInput()->label('Core Heading'); ?>
                        <?= $form->field($model, 'sub_title_heading1')->textInput()->label('Sub Title Heading1'); ?>
                        <?=
                        $form->field($model, 'vission_msg')->widget(CKEditor::className(), [
                            'options' => ['rows' => 15],
                                        //'preset' => 'full',
                                        'clientOptions' => [
                                            'filebrowserUploadUrl' => 'upload', 'customConfig' => 'http://root.injoychange.com/backend/web/js/config.js'
                                        ]
                        ])->label('Vision Message');
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-12'>
            <div class="box box-default">
                <div class="box-header">
                </div>
                <div class="box-body">
                    <div class='submit-action' style='margin-bottom:15px;'>
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-success', 'id' => 'submit_core_values']) ?>
                        <a href="/pilot/backend/web/pilot-corevalues/index" class="btn btn-default" style='margin-left: 15px;'>Cancel</a>
                    </div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
