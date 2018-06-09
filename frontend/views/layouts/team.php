<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;

use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$asset = frontend\assets\AppAsset::register($this);

$baseUrl = $asset->baseUrl;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/fav.png" type="image/x-icon" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="teamdashboard">
<?php $this->beginBody() ?>

<div class="wrap">

    <?= $this->render('header/teamheader.php',['baseUrl' => $baseUrl]) ?>
    <div class="container">
 
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
     </div>
</div>


 <?= $this->render('footer/teamfooter.php',['baseUrl' => $baseUrl]) ?>
    
    

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
