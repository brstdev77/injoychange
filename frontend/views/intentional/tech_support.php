<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Contact Us';
$baseurl = Yii::$app->request->baseurl;

$this->registerCssFile($baseurl . '/css/seeall.css');
if (!Yii::$app->user->isGuest):
  $model->email = Yii::$app->user->identity->emailaddress;
endif;
Yii::$app->session->getFlash('TicketSent');
?>



<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/intentional/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 high-five-title">Contact Us</div>
        </div>
        <?php if (Yii::$app->session->hasFlash('TicketSent')): ?>

          <div class="row contact-us">
              <div class="col-lg-5">
                  <div class="panel panel-default">
                      <div class="panel-heading">Message Sent</div>
                      <div class="panel-body">
                          <p><b>Email:</b> <?= $model->email ?> </p>
                          <p><b>Subject:</b> <?= $model->subject ?> </p>
                          <p><b>Message:</b> <?= $model->message ?> </p>
                          <p><b>Priority: </b><?= $model->priority ?></p>
                          <?php if ($model->attachment != ''): ?>
                            <p><b>Attachement:</b>
                                <img src='http://injoy.injoymore.com/uploads/tickets/<?= $model->attachment ?>' />
                            </p>
                          <?php else: ?>
                            <p><b>Attachement:</b> NA </p>
                          <?php endif; ?>
                      </div>
                  </div>
                  <div class="alert alert-success">
                      Thank you for contacting us. We will respond to you as soon as possible.
                  </div>
              </div>
          </div>
        <?php else: ?>
          <div class="row contact-us">
              <div class="col-lg-6">
                  <?php
                  $form = ActiveForm::begin(
                          [
                            'id' => 'contact-us',
                            'options' => ['enctype' => 'multipart/form-data'],
                  ]);
                  ?>

                  <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Email' . Html::tag('span', '*', ['class' => 'required'])); ?>

                  <?= $form->field($model, 'subject')->textInput(['maxlength' => true])->label('Subject' . Html::tag('span', '*', ['class' => 'required'])); ?>

                  <?= $form->field($model, 'message')->textArea(['rows' => 6])->label('Message' . Html::tag('span', '*', ['class' => 'required'])); ?>

                  <?= $form->field($model, 'priority')->dropDownList(['minimum' => 'Minimum', 'medium' => 'Medium', 'maximum' => 'Maximum'], ['prompt' => 'Please Select', 'id' => 'user-company'])->label('Priority' . Html::tag('span', '*', ['class' => 'required'])); ?>

                  <?= $form->field($model, 'attachment')->fileInput(['accept' => 'image/*']); ?>

                  <div class="form-group">
                      <?= Html::submitButton('Submit', ['id' => 'contact-button', 'class' => 'btn btn-warning dashboard', 'name' => 'contact-button']); ?>
                  </div>
                  <?php ActiveForm::end(); ?>
              </div>
          </div>
        <?php endif; ?>
    </div>
</div>
<?php $this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?>
<?php echo $this->render('prize_modal'); ?>