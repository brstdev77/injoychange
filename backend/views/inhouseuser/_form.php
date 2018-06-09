<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;

$this->title = 'Inhouse User';
?>


<div class="inhouse-user-form">
    <?php
    $form = ActiveForm::begin([
                'id' => 'login-dash',
//                'enableAjaxValidation' => true,
                'options' => ['enctype' => 'multipart/form-data']]);
    ?> 


    <div class='row'>

        <div class="col-md-6">
            <div class="box box-danger">
                <div class="box-header with-border">

                    <h3 class="box-title">Pilot Login Details</h3>
                </div>
                <div class="box-body">
                    <?=
                    $form->field($model, 'emailaddress', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                            ]
                    )->textInput(['readonly' => $model->isNewRecord ? false : true])->label('Email Address'.Html::tag('span','*',['class'=>'required']));
                    ?>
                    <?php if ($model->isNewRecord) { ?>
                        <?=
                        $form->field($model, 'password', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-lock"></i></div>{input}</div>',
                        ])->passwordInput(['value' => ''])->label('Password'.Html::tag('span','*',['class'=>'required']));
                        ?>
                    <?php } ?>
                    <?php if (!($model->isNewRecord)) { ?>
                        <?=
                        $form->field($model, 'passupdate', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-lock"></i></div>{input}</div>',
                        ])->passwordInput(['value' => ''])->label('Password'.Html::tag('span','*',['class'=>'required']));
                        ?>
                    <?php } ?>
                    <?=
                    $form->field($model, 'confirm_password', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-lock"></i></div>{input}</div>'
                    ])->passwordInput(['value' => ''])->label('Confirm Password'.Html::tag('span','*',['class'=>'required']));
                    ?>
                    <?=
                    $form->field($model, 'designation', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                    ])->textInput();
                    ?>
                    <?=
                    $form->field($model, 'role')->dropDownList(
                            [
                                '1' => 'Admin',
                                '2' => 'Manager',
                            ]
                    );
                    ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <?= $form->field($model, 'status')->radioList(array(1 => 'Active', 0 => 'Inactive'))->label('Status'.Html::tag('span','*',['class'=>'required'])); ?>
                        </div>
                    </div>

                </div>
            </div> 		

        </div>
        <div class="col-md-6">
           <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Personal Information</h3>
                </div>
                <div class="box-body">

                    <?=
                    $form->field($model, 'firstname', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                            ]
                    )->label('First Name'.Html::tag('span','*',['class'=>'required']));
                    ?>
                    <?=
                    $form->field($model, 'lastname', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                    ]);
                    ?>

                    <?=
                    $form->field($model, 'phone_number_1', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i></div>{input}</div>'
                    ])->textInput(['id' => 'phone', 'data-mask' => '', 'data-inputmask' => '"mask": "(999) 999-9999"']);
                    ?>
                    <?=
                    $form->field($model, 'phone_number_2', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i></div>{input}</div>'
                    ])->textInput(['id' => 'phone2', 'data-mask' => '', 'data-inputmask' => '"mask": "(999) 999-9999"']);
                    ?>                   
                    <?php
                    if ((!empty($model->profile_pic))) {
                        $imgcheck = 1;
                        $class = 'existimage';
                    } else {
                        $imgcheck = 0;
                        $class = '';
                    }
                    ?>
                    <?= $form->field($model, 'profile_pic')->fileInput(['accept' => 'image/*', 'id' => 'browse', 'class' => $class]); ?>

                    <div class="form-group">
                        <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                        <input id='imgupdate' type='hidden' name="imgupdate" value='0'>
                        <img id="removeimage"style="margin-right:20px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>img/profilepic/<?php echo $model->profile_pic ?>"><button id="remove">Remove</button>
                    </div>
                    <?=
                    $form->field($model, 'address')->textarea(['rows' => 4]);
                    ?>


                </div>
            </div>		

        </div>

    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <span class="cancel_btn">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        </span>
    </div>
    <?php ActiveForm::end(); ?>
</div>



