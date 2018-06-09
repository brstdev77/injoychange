<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotPrizesCategory */
/* @var $form yii\widgets\ActiveForm */

$default = '<table border="0" cellpadding="0" cellspacing="0" style="height:399px; width:610px">
                <tbody>
                        <tr>
                            <td colspan="2">
                            <p style="text-align:left">Raffle will be for all participating employees. Tickets will allow you to be entered for a chance to win some great prizes. How do I earn raffle tickets?</p>

                            <p style="text-align:left">Raffle tickets will be earned in the following manner:</p>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>
                            <ul>
                                <li>100 challenge pts = 1 raffle ticket</li>
                                <li>At the end of the challenge, all participants&#39; raffle tickets will be put into the drawing.</li>
                                <li>Winners will be notified</li>
                                <li>More points = more chances to win!</li>
                            </ul>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <p><img src="http://knox-county-health-department.injoychange.com/images/raffle_ticket.png" style="height:112px; width:182px" /></p>
                            &nbsp;&nbsp;&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p>Prizes will be:</p>
                                <ul>
                                    <li>1st - $200 Visa Gift Card</li>
                                    <li>2nd - $100 Visa Gift Card</li>
                                </ul>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                </tbody>
         </table>';

if(empty($model->prize_content)){
    $model->prize_content = $default;
}
?>

<div class="pilot-prizes-category-form">
    <div class="col-md-12">
        <div class="box box-warning">
            <div class="box-body">
                <?php $form = ActiveForm::begin(); ?>                
                <?=
                $form->field($model, 'prize_content')->widget(CKEditor::className(), [
                    'options' => ['rows' => 50],
                    'preset' => 'standred'
                ])->label('Prize Model Content');
                ?>

                <? //= $form->field($model, 'category_name')->textInput(['maxlength' => true])  ?>

                <? //= $form->field($model, 'user_id')->textInput()  ?>

                <? //= $form->field($model, 'created')->textInput()  ?>

                <? //= $form->field($model, 'updated')->textInput()  ?>

                <div class="form-group">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
