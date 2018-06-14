<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Company;
use backend\models\PilotInhouseUser;
use backend\models\PilotEventCalender;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotEventCalenderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*
 * Added js and css files
 */
$this->registerJsFile(Yii::$app->homeUrl . 'js/custom.calender.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);


$this->title = 'Event Listing';
$this->params['breadcrumbs'][] = ['label' => 'Calender', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-event-calender-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php if (Yii::$app->session->getFlash('custom_message')) { ?>
        <div class="callout callout-success">
            <i class="icon fa fa-check"></i>
            <?php echo Yii::$app->session->getFlash('custom_message'); ?>
        </div>
    <?php } ?>
    <div class="grid_calender grid_verical">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Event Listing</h3>
                <h3 class="box-title pull-right list active" data-toggle="tooltip" title='List View'>&nbsp;</h3>
                <h3 class="box-title pull-right grid" data-toggle="tooltip" title='Grid View'>&nbsp;</h3>
            </div>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn',
                        'header' => 'S No.',
                    ],
                    //'event_name',
                    [
                        'label' => 'Event Name',
                        'attribute' => 'event_name',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotEventCalender::geteventname($model->id);
                        },
                    ],
                    [
                        'label' => 'Comapany',
                        'attribute' => 'company_id',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotEventCalender::getcampanyname($model->company_id);
                        },
                    ],
                    [
                        'label' => 'Challenge',
                        'attribute' => 'challenge_id',
                        'format' => 'html',
                        'value' => function ($model) {
                            return backend\models\PilotEventCalender::getchallengename($model->challenge_id);
                        },
                    ],
                    [
                        'label' => 'Start Date',
                        'attribute' => 'start_date',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotEventCalender::getstartdate($model->id);
                        },
                    ],
                    [
                        'label' => 'End Date',
                        'attribute' => 'end_date',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return backend\models\PilotEventCalender::getenddate($model->id);
                        },
                    ],
                    [
                        'label' => 'Updated By',
                        //'attribute' => 'user_id',
                        'format' => 'html',
                        'value' => function ($model) {
                            return "by " . backend\models\PilotEventCalender::getusername($model->user_id) . "<br />" . backend\models\PilotEventCalender::getupdatedate($model->id);
                        },
                    ],
                    ['class' => 'yii\grid\ActionColumn',
                        'header' => 'Operations',
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                $permission = PilotEventCalender::getcheckbuttonpermission($model);
                                if ($permission == false) {
                                    return false;
                                }
                                return "<a rel='" . $model->id . "' data-target='#edit_event_reminder' data-toggle='modal' class='edit_reminder grid btn btn-default' href='javascript:void(0)' ><i class='fa fa-pencil-square-o'></i>&nbsp;Edit</a>";
                            },
                            'delete' => function ($url, $model) {
                                $permission = PilotEventCalender::getcheckbuttonpermission($model);
                                if ($permission == false) {
                                    return false;
                                }
                                return "<a data-method='post' data-confirm='Are you sure you want to delete this event?'class=' grid btn btn-default' href='" . Yii::$app->homeUrl . "pilot-event-calender/delete?id=" . $model->id . "'><i class='fa fa-trash-o'></i>&nbsp;Delete</a>";
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<!--Edit a Reminder pup-up model-->

<div class="modal fade" id="edit_event_reminder" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content box">
            <div class="modal-header box box-info add-reminder">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit a Reminder</h4>
            </div>
            <div class="overlay calender-loder">
                <i class="fa fa-refresh fa-spin"></i>
                <span class="span-loading-text">Loading...</span>
            </div>
            <div class="modal-body">
                <div class="modal-event-edit-form">
                    <?php $form = ActiveForm::begin([ 'id' => 'edit-event',]); ?>

                    <?= $form->field($model, 'id')->textInput() ?>
                    <?= $form->field($model, 'event_name')->textInput(['maxlength' => true]) ?>

                    <div class='row'>
                        <div class='col-lg-6'>
                            <?=
                            $form->field($model, 'start_date', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                            ])->textInput(['autocomplete' => 'off', 'readonly' => true])
                            ?>
                        </div>
                        <div class='col-lg-6'>
                            <?=
                            $form->field($model, 'end_date', [
                                'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                            ])->textInput(['autocomplete' => 'off', 'readonly' => true])
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
            </div>
            <div class="modal-footer">
                <?= Html::submitButton('Save', ['class' => 'btn btn-info btn-flat pull-left event-save', 'id' => 'update-event']) ?>
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
