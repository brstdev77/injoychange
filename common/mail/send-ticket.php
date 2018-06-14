<?php

use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
$submitted_date = date("l F j, Y h:i:s A", $model->created);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
        <style type="text/css">
            .panel-default {
                border-color: #ddd;
            }
            .panel-default > .panel-heading {
                background-color: #f5f5f5;
                border-color: #ddd;
                color: #333;
            }
            .panel-heading {
                border-bottom: 1px solid transparent;
                border-top-left-radius: 3px;
                border-top-right-radius: 3px;
                padding: 10px 15px;
            }
            .panel-body {
                padding: 15px;
            }
            .panel {
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
                margin-bottom: 20px;
                width: 80%;
            }
            .panel-body img {
                max-width: 100%;
            }
        </style>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <p><b>Ticket raised on:</b><?= $submitted_date; ?></p> 
        <p><b>Ticket raised by:</b> <?= $username; ?></p> <br>
            <div class="panel panel-default">
                <div class="panel-heading">Ticket Content</div>
                <div class="panel-body">
                    <p><b>Email: </b><?= $model->email ?></p>
                    <p><b>Subject: </b><?= $model->subject ?></p> 
                    <p><b>Message: </b><?= $model->message ?></p>
                    <p><b>Priority: </b><?= $model->priority ?></p>
                    <?php if ($model->attachment != ''): ?>
                      <p><b>Attachement:</b>
                          <img src='http://pilot.devinjoyglobal.com/uploads/tickets/<?= $model->attachment ?>' />
                      </p>
                    <?php else: ?>
                      <p><b>Attachement:</b> NA </p>
                    <?php endif; ?>
                </div>
            </div>
            <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>