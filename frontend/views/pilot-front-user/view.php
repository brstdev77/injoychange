<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\PilotFrontUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Front Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-front-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'emailaddress:email',
            'password',
            'role',
            'company_id',
            'last_login_id',
            'last_access_time:datetime',
            'firstname',
            'lastname',
            'phone_number_1',
            'phone_number_2',
            'profile_pic',
            'dob',
            'created',
            'updated',
            'ip_address',
            'address',
            'status',
        ],
    ]) ?>

</div>
