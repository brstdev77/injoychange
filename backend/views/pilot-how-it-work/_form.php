<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotHowItWork */
/* @var $form yii\widgets\ActiveForm */

$default = '<table align="left" border="0" cellpadding="0" cellspacing="0" style="height: auto; width: 100%;">
	<tbody>
           <tr>
                <td>
                    <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/img/game/bannerservice.jpg" style="height:533px; width:350px" /></p>
                </td>
                <td>
                    <p><span style="font-size:24px"><strong>Daily Inspiration</strong></span></p>
                    <ul>
                        <li>
                            <p>These are quick daily thoughts of inspiration that will motivate you to excel through this challenge. The daily inspirations relate to the core values and will remind you of their importance.</p>
                        </li>
                        <li>
                            <p>Our attitude is so largely impacted by thought. Even one positive thought read in the morning can set the tone for the whole day.</p>
                        </li>
                        <li>
                            <p>Points Value = 10 points per day</p>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/image/Screenshot_11.png" /></p>
                </td>
                <td>
                    <p><span style="font-size:24px"><strong>Daily Inspiration</strong></span></p>
                    <ul>
                        <li>
                            <p>These are quick daily thoughts of inspiration that will motivate you to excel through this challenge. The daily inspirations relate to the core values and will remind you of their importance.</p>
                        </li>
                         <li>
                             <p>Our attitude is so largely impacted by thought. Even one positive thought read in the morning can set the tone for the whole day.</p>
                        </li>
                        <li>
                            <p>Points Value = 10 points per day</p>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/image/Screenshot_7.png" style="height:207px; width:413px" /></p>
                </td>
                <td>
                    <p><span style="font-size:24px"><strong>Check in with yourself</strong></span></p>
                    <ul>
                        <li>
                            <p>The Check In With Yourself section is where you will practice reinforcing the core values each day.</p>
                        </li>
                        <li>
                            <p>To earn points for a prior day, click on the calendar icon on the top left of the Check in With Yourself Section. Hover your mouse cursor over the points value on the day you would like to make-up points for, then click on the &quot;Edit&quot; button that appears. From there you can add a Values Action and submit it to make up that day&#39;s points.</p>
                        </li>
                        <li>
                            <p>Note : This section is your private journal and your entries will not be shared. All data you enter will be permanently deleted from our platform 2 weeks after the end of this challenge</p>
                        </li>
                        <li>
                            <p>Points Value:</p>
                        </li>
                        <li>
                            <p>Core Values Pop Up = 5 points per day</p>
                        </li>
                        <li>
                            <p>Core Values Check In = 20 points 2x a day</p>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/image/action.png" /></p>
                </td>
                <td>
                <p><strong><span style="font-size:24px">your Points</span></strong></p>

                <ul>
                    <li>
                         <p>This section creates an experience of a game. There is badge value in being on the leaderboard as well as real prizes that make the whole experience more fun and engaging.</p>
                    </li>
                    <li>
                        <p>Everything you do on this site earns you points. Those points will earn you the chance at some amazing prizes and bragging rights on your team&#39;s.</p>
                    </li>
                    <li>
                        <p>Each day you will be able to see your points, keep track of your goals and who the overall leaders are.</p>
                    </li>
                </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/image/w2.jpg" style="height:314px; width:382px" /></p>
                </td>
                <td>
                    <p><span style="font-size:24px"><strong>Shout Out</strong></span><span style="font-size:24px"><strong> &amp; Digital High 5&#39;s</strong></span></p>
                    <ul>
                        <li>
                            <p>This is a simple but powerful way to create an atmosphere of ongoing recognition.</p>
                        </li>
                        <li>
                            <p>Recognition and appreciation are so simple, yet so powerful. This section is a place to show your appreciation for the impact that others make each day. You can also comment or give a Digital High 5 to those who have been recognized by others.</p>
                        </li>
                        <li>
                            <p>Points Value = 10 points, 3x a day</p>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/image/leadership-corner-howitwork.png" /></p>
                </td>
                <td>
                    <p><strong><span style="font-size:24px">Leadership Corner</span></strong></p>
                    <ul>
                        <li>
                            <p>In this section, you will read about your leaders personal perspectives on the importance of the Core Values.</p>
                        </li>
                        <li>
                            <p>The leadership section will become a library of memorable tools and insights for you to take with you throughout this challenge and beyond.</p>
                        </li>
                        <li>
                            <p>Points Value = 10 points per day</p>
                        </li>
                    </ul>
                </td>
            </tr>
            <tr>
                    <td>
                        <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/image/weekly-challenge-howitwork.png" /></p>
                    </td>
                    <td>
                        <p><strong><span style="font-size:24px">Weekly Challenge</span></strong></p>
                        <ul>
                            <li>
                                <p>This is an educational section that includes videos to inspire you and reinforce the overall goals of the challenge. You will watch a variety of videos to gain perspective and motivation through their messages. All videos support the core values and encourage their significance.</p>
                            </li>
                            <li>
                                <p>Points Value = 40 points per week</p>
                            </li>
                        </ul>
                    </td>
            </tr>
            <tr>
                <td>
                    <p style="text-align:center"><img class="main-banner" src="http://root.injoychange.com/backend/web/image/Screenshot_service.png" /></p>
                </td>
                <td>
                    <p><strong><span style="font-size:24px">share a win</span></strong></p>

                    <ul>
                        <li>
                            <p>This is a chance to celebrate the journey through this core values challenge.</p>
                        </li>
                        <li>
                            <p>Everyday there are things that are wins. But we rarely celebrate or even acknowledge them. Regardless of whether they are big or small, the more we share our wins and celebrate our progress the more inspired we are to take on harder challenges.</p>
                        </li>
                        <li>
                            <p>Point Value = 10 points per day</p>
                        </li>
                    </ul>
                </td>
            </tr>
	</tbody>
</table>';

if (empty($model->how_it_work_content)) {
    $model->how_it_work_content = $default;
}
?>

<div class="pilot-how-it-work-form">

    <?php $form = ActiveForm::begin(); ?>

    <? //= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    <?=
    $form->field($model, 'how_it_work_content')->widget(CKEditor::className(), [
        'options' => ['rows' => 50],
        'preset' => 'full',
        'clientOptions' => [
            'filebrowserUploadUrl' => 'upload'
        ]
    ])->label(false);
    ?>

    <? //= $form->field($model, 'user_id')->textInput() ?>

    <? //= $form->field($model, 'created')->textInput() ?>

    <? //= $form->field($model, 'updated')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
