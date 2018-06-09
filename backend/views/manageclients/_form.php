<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;

$this->title = 'Manage Client';
?>

<?php
$form = ActiveForm::begin([
            'id' => 'login-dash',
            'enableAjaxValidation' => true,
            // 'enableClientValidation' => true,
            'options' => ['enctype' => 'multipart/form-data']]);
?> 
<div class='row'>
    <div class="col-md-6">
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Company Details</h3>
            </div>
            <div class="box-body">
                <?= $form->field($model, 'company_name')->textInput()->label('Company Name' . Html::tag('span', '*', ['class' => 'required'])); ?>
                <?php
                if ((!empty($model->image))) {
                    $imgcheck = 1;
                    $class = 'existimage';
                } else {
                    $imgcheck = 0;
                    $class = '';
                }
                ?>
                <?= $form->field($model, 'image')->fileInput(['accept' => 'image/*', 'id' => 'browse', 'class' => $class])->label('Add a logo'); ?>
                <div class="form-group">
                    <input id='imgcheck' type='hidden' name='img_check' value='<?php echo $imgcheck; ?>'>
                    <input id='imgupdate' type='hidden' name="imgupdate" value='0'>
                    <img id="removeimage"style="margin-right:20px;height:100px;width:100px;"src="<?php echo Yii::$app->homeUrl ?>/img/uploads/<?php echo $model->image ?>"><button id="remove">Remove</button>
                </div>
                <?= $form->field($model, 'additional_info')->textarea(['rows' => 5])->label('Additional Info (ie. Additional Team Members)'); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <?=
                        $form->field($model, 'full_name', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                        ])->label('Main Contact');
                        ?>
                    </div>
                    <div class="col-lg-6">
                        <?=
                        $form->field($model, 'secondary_contact', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-user"></i></div>{input}</div>'
                        ])->label('Secondary Contact');
                        ?>
                    </div>
                </div>

                <?=
                $form->field($model, 'email_address_1', [
                    'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                ]);
                ?>
                <?=
                $form->field($model, 'email_address_2', [
                    'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                ]);
                ?>
                <?=
                $form->field($model, 'phone', [
                    'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-phone"></i></div>{input}</div>'
                ])->textInput(['id' => 'phone', 'data-mask' => '', 'data-inputmask' => '"mask": "(999) 999-9999"']);
                ?>

            </div>
        </div>		
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Customer Success Manager</h3>
            </div>
            <div class="box-body">
                <?php
                if (!($model->isNewRecord)) {
                    $model->manager = explode(",", $model->manager);
                }
                ?>
                <?php
                $frontuser = backend\models\PilotInhouseUser::find()->where(['role' => '2'])->all();
                $option = [];
                foreach ($frontuser as $val) {
                    $option[$val->id] = $val->firstname . ' ' . $val->lastname . ' (' . $val->emailaddress . ')';
                }
                ?>
                <?=
                $form->field($model, 'manager')->dropdownList($option, ['multiple' => 'multiple']);
                ?> 
                <?=
                $form->field($model, 'appreciator')->dropdownList($option, ['multiple' => 'multiple']);
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Teams/Divisions/Regions</h3>
            </div>
            <div class="box-body">
                <?php if ($model->isNewRecord) { ?>
                    <input type="hidden" id="teamcount" value="1">
                    <input type="hidden" id="serialcount" value="1">
                    <?=
                    $form->field($team, "team_name[1]", [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-users"></i></div>{input}</div>'
                    ])->label('Team Name 1');
                    ?>
                    <?php
                } else {
                    echo '<input type="hidden" id="teamcount" value="' . count($team) . '">';
                    $n = 1;
                    $count = count($team);
                    $countcheck = 1;
                    $serial = 0;

                    foreach ($team as $t_data) {
                        if ($countcheck == 1) {
                            ?>
                            <?=
                            $form->field($t_data, "team_name[$t_data->id]", [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-users"></i></div>{input}</div>'
                            ])->textInput(['value' => $t_data->team_name])->label('Team Name ' . ++$serial);
                            ?>
                            <?php
                        } else {
                            echo $form->field($t_data, "team_name[$t_data->id]", [
                                'inputTemplate' => '<div class="removeteam"><div class="input-group"><div class="input-group-addon"><i class="fa fa-users"></i></div>{input}<div style="cursor:pointer;" class="input-group-addon"><i class="fa fa-times" aria-hidden="true"></i></div></div></div>'
                            ])->textInput(['value' => $t_data->team_name])->label('Team Name ' . ++$serial);
                        }
                        $n++;
                        $countcheck++;
                    }
                    ?>
                    <input type="hidden" id="serialcount" value=<?php echo $serial ?>>
                <?php }
                ?>


                <a href="javascript:void(0)" class="btn btn-default addmore-team">Add More&nbsp;<i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Contract Dates</h3>
            </div>
            <div class="box-body">
                <div class='row'>
                    <div class='col-lg-12'>
                        <?php
                        if (!empty($model->agreement_file)) {
                            $check = 1;
                            $class = 'exist';
                        } else {
                            $check = 0;
                            $class = '';
                        }
                        ?>
                        <?= $form->field($model, 'agreement_file')->fileInput(['id' => 'agreement_file', 'class' => $class])->label('Statement of Work'); ?>

                        <div class="agreement_file">
                            <span id ="agreement_file_name"style="margin-right:20px;"><i class="fa fa-file"></i>&nbsp;&nbsp;<?php echo $model->agreement_file; ?></span>
                            <button id="browse_button">Remove</button>
                            <input id="agreement_file_check" type="hidden" name="agreement_file_check" value="<?php echo $check; ?>">
                            <input id="agreement_file_update" type="hidden" name="agreement_file_update" value="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <?php
                        if ($model->start_date) {
                            $startdate = $model->start_date;
                            $model->start_date = date('m/d/Y', $startdate);
                        }
                        ?>
                        <?=
                        $form->field($model, 'start_date', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                        ])->textInput(['id' => 'datepicker'])->label('Contract Start Date');
                        ?>
                    </div>
                    <div class="col-lg-6">
                        <?php
                        if ($model->end_date) {
                            $enddate = $model->end_date;
                            $model->end_date = date('m/d/Y', $enddate);
                        }
                        ?>
                        <?=
                        $form->field($model, 'end_date', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                        ])->textInput(['id' => 'datepickerr'])->label('Contract End Date');
                        ?>

                    </div>
                    <div class="col-lg-12">
                        <span style="color:red;"> <?php echo Yii::$app->session->getFlash('warning'); ?></span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <?= $form->field($model, 'status')->radioList(array(1 => 'Active', 0 => 'Inactive'))->label('Status' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    </div>
                </div>
                <?= $form->field($model, 'remarks')->textarea(['rows' => 5, 'placeholder' => "Notes..."])->label('Additional info'); ?>
                <?=
                $form->field($model, 'country')->dropdownList(
                        backend\models\Company::timezoneCountries(), ['prompt' => 'Please Select']
                );
                ?>
                <div class='ajax-timezone'>
                    <img src='http://gifimage.net/wp-content/uploads/2017/06/gif-upload-14.gif'>
                    <?=
                    $form->field($model, 'timezone')->dropdownList(
                            []
                    );
                    ?>
                </div>
                <input id="timezone_val" type="hidden" value="<?php echo $model->timezone; ?>"></input>

                <?php
                if (!($model->isNewRecord)) {
                    $model->challenge_name = explode(",", $model->challenge_name);
                }
                ?>
                <?php ?>

                <?/*=
                $form->field($model, 'challenge_name')->dropdownList(
                        ArrayHelper::map(backend\models\PilotGameChallengeName::find()->all(), 'id', 'challenge_name'), ['multiple' => 'multiple']
                )->label('Select Challenges');*/
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
<div class="g-recaptcha" data-sitekey="6LeP6iAUAAAAANelcejeVc7TDaY_xZbjBVT6_Zql"></div>
