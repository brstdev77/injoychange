<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PilotFrontUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pilot Front Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pilot-front-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Pilot Front User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'emailaddress:email',
            'password',
            'role',
            // 'company_id',
            // 'last_login_id',
            // 'last_access_time:datetime',
            // 'firstname',
            // 'lastname',
            // 'phone_number_1',
            // 'phone_number_2',
            // 'profile_pic',
            // 'dob',
            // 'created',
            // 'updated',
            // 'ip_address',
            // 'address',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
