<?php
/* @var $this yii\web\View */

use backend\models\PilotCheckinYourselfData;
use frontend\models\PilotFrontCoreRating;
use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\web\Cookie;
use kartik\rating\StarRating;
use yii\web\JsExpression;

$ratingmodel = new PilotFrontCoreRating;
$content_height = '';
$rating = '';
$rating1 = '';
$button_rating = '';
if (in_array(10, $feature_array)):
    $rating = 'present';
    $button_rating = 'present_width';
endif;
//Today Values
if (!empty($prev_today_values_currentday)):
    foreach ($prev_today_values_currentday as $today_value):
        $serial = $today_value->serial;
    endforeach;
    $tv_serial = $serial + 1;
else:
    $tv_serial = 1;
endif;
$tv_cls1 = 'uncheck';
$tv_cls2 = 'uncheck';
$tv = '';
$tv_btn_text = 'Submit 20 PTS';
if ($count_tv == 1):
    $tv_cls1 = 'check';
    $tv_btn_text = 'Add More 20 PTS';
    $tv = 'addmore';
    $button = 'addcheckin';
/* if (in_array(10, $feature_array)):
  $rating1 = 'present1';
  endif; */
elseif ($count_tv >= 2):
    $tv_cls1 = 'check';
    $tv_cls2 = 'check';
    $tv_btn_text = 'Add More';
endif;
?>
<?php
if (!empty($game_obj->checkin_yourself_content)) {
    $record = PilotCheckinYourselfData::find()->where(['category_id' => $game_obj->checkin_yourself_content])->one();
    $question_lable = $record->question_label;
    $placeholder_text = $record->placeholder_text;
    $selct_option_text = $record->select_option_text;
    $valuesLabelarray = PilotCheckinYourselfData::find()->select(['core_value'])->where(['category_id' => $game_obj->checkin_yourself_content])->orderby(['id' => SORT_ASC])->all();
    $valuesLabel = array();
    foreach ($valuesLabelarray as $obj) {
        $valuesLabel[$obj->core_value] = $obj->core_value;
    }
} else {
    $question_lable = 'How did you use one of the values today?';
    $placeholder_text = 'Write a sentence or two on how you used this value today';
    $selct_option_text = 'Which value';
}
?>
<h1><?= $question_lable; ?></h1>
<div id="today_values">
    <div class="Content-values-outer">
        <?php $count_check = 0; foreach ($prev_today_values_currentday as $today_value) :  $count_check++;?>
            <div class="Content-values">
                <p class="Content-values-first">
                    <span class="values-title"><?= $count_check; ?>)</span>
                    <span class="values-value"><?= $today_value->label; ?></span>
                </p>
                <p class="Content-values-sec"><?= json_decode($today_value->comment); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="new-mail-submit pop_up_button two <?= $button_rating; ?>1 ">
        <div class="col-sm-9 new_text">
            <div href="check-in-modal" data-toggle="modal" data-modal-id="check-in" class=submit-image onclick='highfivezoommodal(this,event)'>
                <span class="background-checkbox  <?= $button; ?> <?= $tv_cls1; ?>"></span>
                <span class="background-checkbox  <?= $button; ?> <?= $tv_cls2; ?>"></span>
                <input id=new-mail-submit class="new-user-submit btn btn-primary form-submit <?= $button; ?>" name=op value="<?= $tv_btn_text; ?>" type=submit onclick='high'>
            </div>
        </div>
    </div>
    <div class="checkin-seeall <?= $tv; ?> <?= $rating; ?>1">
        <?php if (in_array(10, $feature_array)): ?>
            <?php if (empty($ratesaved)): ?>
                <?php
                $formrating = ActiveForm::begin([
                            'id' => 'rating',
                            'action' => 'save-rating',
                            'enableAjaxValidation' => true,
                ]);
                ?>
                <?php echo '<label class="control-label">Rate Your Day</label>'; ?>
                <?php
                echo $formrating->field($ratingmodel, 'value')->widget(StarRating::classname(), [
                    'pluginOptions' => [
                        'stars' => 10,
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                        'showCaption' => false,
                        'showClear' => false,
                    ]
                ])->label(false);
                ?>
                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'style' => 'display:none']) ?>
                <?php ActiveForm::end(); ?>
            <?php else: ?>
                <?php echo '<label class="control-label">Rate Your Day</label>'; ?>
                <?php
                echo StarRating::widget([
                    'name' => 'rating_35',
                    'value' => $ratesaved->value,
                    'pluginOptions' => [
                        'stars' => 10,
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                        'showCaption' => false,
                        'showClear' => false,
                        'displayOnly' => true,
                    ]
                ]);
                ?>
            <?php
            endif;
        endif;
        ?>
        <a href="<?= $baseurl; ?>/core/checkin" class="">See All&nbsp;<span><i class="fa fa-angle-right"></i></span></a></div> 

</div>