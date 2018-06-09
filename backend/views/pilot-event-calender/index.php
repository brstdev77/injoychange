<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Company;
use backend\models\PilotEventCalender;
use backend\models\PilotInhouseUser;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotEventCalenderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*
 * Added js and css files
 */
$this->registerJsFile(Yii::$app->homeUrl . 'js/moment.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/fullcalendar.min.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/bootstrap-datepicker.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/custom.calender.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerCssFile(Yii::$app->homeUrl . 'css/fullcalendar.min.css');
$this->registerCssFile(Yii::$app->homeUrl . 'css/datepicker3.css');


$this->title = 'Calender';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-event-calender-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Upcoming Events</h3>
                </div>
                <div class="box-body">
                    <div id="upcomming_event" class="upcomming_event">
                        <?php
                        if (!empty($upcomming)) {
                            foreach ($upcomming as $value) {
                                if ($value['start_date'] != $value['end_date']) {
                                    $start_date = date('M d', $value['start_date']);
                                    $end_date = date('M d, Y', $value['end_date']);
                                    $date = $start_date . ' - ' . $end_date;
                                } else {
                                    $date = date('d M, Y', $value['start_date']);
                                }
                                echo "<div class='external-event'><div style='background-color:" . $value['color'] . ";' class='event-color'></div>" . ucfirst($value['event_name']) . "<br /><span style='padding-left: 16px;'>$date</span></div>";
                            }
                        } else {
                            echo "No Record Found";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="box box-primary calendar-box">
                <div class="overlay calender-loder">
                    <i class="fa fa-refresh fa-spin"></i>
                    <span class="span-loading-text">Loading...</span>
                </div>
                <div class="box-body no-padding"  style="min-height:413px">
                    <div id="calendar" class="fc fc-ltr fc-unthemed">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Add a Reminder pup-up model-->

<div class="modal fade" id="add_event_reminder" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header box box-info add-reminder">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add a Reminder</h4>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin([ 'id' => 'add-event',]); ?>

                <?= $form->field($model, 'event_name')->textInput(['maxlength' => true]) ?>

                <div class='row'>
                    <div class='col-lg-6'>
                        <?=
                        $form->field($model, 'start_date', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                        ])->textInput(['autocomplete' => 'off'])
                        ?>
                    </div>
                    <div class='col-lg-6'>
                        <?=
                        $form->field($model, 'end_date', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                        ])->textInput(['autocomplete' => 'off'])
                        ?> 
                    </div>
                </div>

                <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map(Company::find()->all(), 'id', 'company_name'), ['prompt' => 'Select Campany']) ?>
                <?=
                $form->field($model, 'challenge_id')->dropdownList([
                    1 => '30-day teamwork challenge',
                    2 => '30-day customer service challenge',
                    3 => '30-day productivity challenge',
                    4 => '30-day leadership challenge',
                    5 => '30-day core values challenge',
                        ], ['prompt' => 'Select Challenge']
                );
                ?>
                <?= $form->field($model, 'assign')->dropDownList(ArrayHelper::map(PilotInhouseUser::find()->where(['=', 'role', '2'])->all(), 'id', 'username'), ['multiple' => 'multiple']) ?>

                <?= $form->field($model, 'color')->textInput(['id' => 'color']) ?>
                <div class="btn-group">
                    <ul class="fc-color-picker" id="color-chooser">
                        <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                        <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Save', ['class' => 'btn btn-info btn-flat pull-left event-save', 'id' => 'add-new-event']) ?>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancle</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>