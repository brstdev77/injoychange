<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */
?>

<?php
$form = ActiveForm::begin([
            'id' => 'gettoknow_corner_form',
            'options' => ['enctype' => 'multipart/form-data']]);
?> 
<div class='row'>
    <div class="col-md-6">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Add Corner</h3>
            </div>
            <div class="box-body">

                <?=
                $form->field($model, 'week')->dropDownList([
                    'Week 1-one' => 'Week 1-one',
                    'Week 1-two' => 'Week 1-two',
                    'Week 1-three' => 'Week 1-three',
                    'Week 2-one' => 'Week 2-one',
                    'Week 2-two' => 'Week 2-two',
                    'Week 2-three' => 'Week 2-three',
                    'Week 3-one' => 'Week 3-one',
                    'Week 3-two' => 'Week 3-two',
                    'Week 3-three' => 'Week 3-three',
                    'Week 4-one' => 'Week 4-one',
                    'Week 4-two' => 'Week 4-two',
                    'Week 4-three' => 'Week 4-three',
                    'Week 5-one' => 'Week 5-one',
                    'Week 5-two' => 'Week 5-two',
                    'Week 5-three' => 'Week 5-three',
                    'Week 6-one' => 'Week 6-one',
                    'Week 6-two' => 'Week 6-two',
                    'Week 6-three' => 'Week 6-three',
                    'Week 7-one' => 'Week 7-one',
                    'Week 7-two' => 'Week 7-two',
                    'Week 7-three' => 'Week 7-three',
                        ], ['prompt' => 'Select Week']
                )->label('Week' . Html::tag('span', '*', ['class' => 'required']));
                ?>

                <p id="week_error_create" style="color:#dd4b39;"></p>
                <?= $form->field($model, 'question')->textInput(['maxlength' => true])->label('Question' . Html::tag('span', '*', ['class' => 'required'])); ?>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Add First Option</h3>
            </div>
            <div class="box-body">
                <?php
                if ((!empty($model->first_user_profile))) {
                    $firstcheck = 1;
                    $firstclass = 'existfirstimage';
                } else {
                    $firstcheck = 0;
                    $firstclass = '';
                }
                ?>
                <?= $form->field($model, 'first_user')->textInput(['maxlength' => true])->label('First Option Name' . Html::tag('span', '*', ['class' => 'required'])); ?>
                <?=
                $form->field($model, 'first_user_description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 3],
                    'preset' => 'full',
                    'clientOptions' => [
                        'filebrowserUploadUrl' => 'upload'
                    ]
                ])->label('First Option Description' . Html::tag('span', '*', ['class' => 'required']));
                ?>
                <?= $form->field($model, 'first_user_profile')->fileInput(['accept' => 'image/*', 'id' => 'browsefirstuser', 'class' => $firstclass, 'maxlength' => true])->label('First Option Image') ?>
                <div class="form-group browsefirstuser">   
                    <input id='first_check' type='hidden' name='first_check' value='<?php echo $firstcheck; ?>'>
                    <input id='first_update' type='hidden' name="first_update" value='0'>
                    <img class="removeimagebrowsefirstuser" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/knowtheteam/<?= $model->first_user_profile; ?>"><a class="btn btn-default" id="removefirst">Remove</a>
                </div>
                <?= $form->field($model, 'first_user_answer')->radioList(array(1 => 'Correct', '0' => 'Incorrect'))->label('Answer' . Html::tag('span', '*', ['class' => 'required'])); ?>
            </div>
        </div>

        <!-- Second Option Details -->
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Add Second Option</h3>
            </div>
            <div class="box-body">
                <?php
                if ((!empty($model->second_user_profile))) {
                    $secondcheck = 1;
                    $secondclass = 'existsecondimage';
                } else {
                    $secondcheck = 0;
                    $secondclass = '';
                }
                ?>
                <?= $form->field($model, 'second_user')->textInput(['maxlength' => true])->label('Second Option Name' . Html::tag('span', '*', ['class' => 'required'])); ?>
                <?=
                $form->field($model, 'second_user_description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 3],
                    'preset' => 'full',
                    'clientOptions' => [
                        'filebrowserUploadUrl' => 'upload'
                    ]
                ])->label('Second Option Description' . Html::tag('span', '*', ['class' => 'required']));
                ?>
                <?= $form->field($model, 'second_user_profile')->fileInput(['accept' => 'image/*', 'id' => 'browseseconduser', 'class' => $secondclass, 'maxlength' => true])->label('Second Option Image') ?>
                <div class="form-group browseseconduser">
                    <input id='second_check' type='hidden' name='second_check' value='<?php echo $secondcheck; ?>'>
                    <input id='second_update' type='hidden' name="second_ipdate" value='0'>                        
                    <img class="removeimagebrowseseconduser" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/knowtheteam/<?= $model->second_user_profile; ?>"><a class="btn btn-default" id="removesecond">Remove</a>
                </div>
                <?= $form->field($model, 'second_user_answer')->radioList(array(1 => 'Correct', '0' => 'Incorrect'))->label('Answer' . Html::tag('span', '*', ['class' => 'required'])); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <!-- Third Option Details -->
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Add Third Option</h3>
            </div>
            <div class="box-body">
                <?php
                if ((!empty($model->third_user_profile))) {
                    $thirdcheck = 1;
                    $thirdclass = 'existthirdimage';
                } else {
                    $thirdcheck = 0;
                    $thirdclass = '';
                }
                ?>
                <?= $form->field($model, 'third_user')->textInput(['maxlength' => true])->label('Third Option Name' . Html::tag('span', '*', ['class' => 'required'])); ?>
                <?=
                $form->field($model, 'third_user_description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 3],
                    'preset' => 'full',
                    'clientOptions' => [
                        'filebrowserUploadUrl' => 'upload'
                    ]
                ])->label('Third Option Description' . Html::tag('span', '*', ['class' => 'required']));
                ?>
                <?= $form->field($model, 'third_user_profile')->fileInput(['accept' => 'image/*', 'id' => 'browsethirduser', 'class' => $thirdclass, 'maxlength' => true])->label('Third Option Image') ?>
                <div class="form-group browsethirduser">  
                    <input id='third_check' type='hidden' name='third_check' value='<?php echo $thirdcheck; ?>'>
                    <input id='third_update' type='hidden' name="third_update" value='0'>                      
                    <img class="removeimagebrowsethirduser" style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/knowtheteam/<?= $model->third_user_profile; ?>"><a class="btn btn-default" id="removethird">Remove</a>
                </div>
                <?= $form->field($model, 'third_user_answer')->radioList(array(1 => 'Correct', '0' => 'Incorrect'))->label('Answer' . Html::tag('span', '*', ['class' => 'required'])); ?>
                <?=
                $form->field($model, 'category_id'
                )->hiddenInput(['value' => Yii::$app->request->get('cid'), 'readonly' => true])->label('');
                ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'submit-know']) ?>
            <span class="cancel_btn">
                <?= Html::a('Cancel', ['index', 'cid' => Yii::$app->request->get('cid')], ['class' => 'btn btn-default']) ?>
            </span>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<style>
    #pilotgettoknowcorner-first_user_answer .radio:nth-child(2),#pilotgettoknowcorner-second_user_answer .radio:nth-child(2),#pilotgettoknowcorner-third_user_answer .radio:nth-child(2) {
        display: none;
    }
</style>