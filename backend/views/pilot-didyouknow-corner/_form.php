<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Company;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLeadershipCorner */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$modelclient = Company::find()->all();
foreach ($modelclient as $val) {
    
}
?>

<div class="pilot-leadership-corner-form">
    <div class='row'>

        <div class="col-md-6">
            <div class="box box-warning">
                <div class="box-header with-border">

                    <h3 class="box-title">Leadership Corner</h3>
                </div>
                <div class="box-body">
                    <?php $form = ActiveForm::begin([ 'id' => 'leadership-corner-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                    <?= $form->field($model, 'client_listing')->dropDownList(
                            ArrayHelper::map(Company::find()->all(), 'id', 'company_name'), ['prompt' => 'Select Client']
                    );
                    ?>
                    <?php
                    if ((!empty($model->picture))) {
                        $imgcheck = 1;
                        $class = 'existimage';
                    } else {
                        $imgcheck = 0;
                        $class = '';
                    }
                    ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'week')->dropDownList([
                                                              '1-1' =>'Week 1-1',
                                                              '1-2' =>'Week 1-2',
                                                             ' 1-3' =>'Week 1-3',
                                                              '2-1' =>'Week 2-1',
                                                              '2-2' =>'Week 2-2',
                                                             ' 2-3' =>'Week 2-3',
                                                              '3-1' =>'Week 3-1',
                                                              '3-2' =>'Week 3-2',
                                                              '3-3' =>'Week 3-3',
                                                             ' 4-1' =>'Week 4-1',
                                                              '4-2' =>'Week 4-2',
                                                              '4-3' =>'Week 4-3',
                                                             ' 5-1' =>'Week 5-1',
                                                              '5-2' =>'Week 5-2',
                                                             ' 5-3' =>'Week 5-3',
                                                                    ],['prompt' => 'Select Week']
                                                                ); ?>
                    <?//= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>  
                    <?= $form->field($model, 'picture')->fileInput(['accept' => 'image/*', 'id' => 'browse', 'class' => $class, 'maxlength' => true]) ?>
                    <div class="form-group">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='imgupdate' type='hidden' name="imgupdate" value='0'>
                        <img id="removeimage"style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/leadership-corner-images/<?php echo $model->picture ?>"><button id="remove">Remove</button>
                    </div>

                    <?=
                    $form->field($model, 'description')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'basic'
                    ])->label('Description');
                    ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        <span class="cancel_btn">
                            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
                        </span>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
