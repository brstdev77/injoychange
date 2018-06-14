<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotLogs */

$this->title = 'Details';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Details';
?>
<div class="pilot-logs-view">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Log Details</h3>
        </div>
        <div class="box-body">
            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'user_id',
                    'type',
                    'log_type',
                    'message',
                    'refer',
                    'location',
                    'timestamp:datetime',
                ],
            ])
            ?>
            <p style='margin-top: 20px'>
                <? //= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?=
                Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ])
                ?>
                <?=
                Html::a('Cancle', ['index'], [
                    'class' => 'btn btn-primary',
                ])
                ?>
            </p>
        </div>

    </div>
</div>
