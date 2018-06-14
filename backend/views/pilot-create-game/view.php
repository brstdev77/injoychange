<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\PilotManageGame */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Games', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-manage-game-view">

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
            'company_name',
            'challenge_start_date',
            'team',
            'winner_posted_date',
            'survey_date',
            'zodiac_1st_email:email',
            'zodiac_2nd_email:email',
            'zodiac_3rd_email:email',
            'injoyglobal_1st_email:email',
            'injoyglobal_2nd_email:email',
            'injoyglobal_3rd_email:email',
        ],
    ]) ?>

</div>
