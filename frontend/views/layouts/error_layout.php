<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use frontend\assets\AppAsset;

$asset = frontend\assets\AppAsset::register($this);

$baseUrl = $asset->baseUrl;
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
    <body class="error">
<?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            ?>
<?= $this->render('header/errorheader.php') ?>
            <div class="container">

<?= $content ?>
            </div>
        </div>
        <?= $this->render('footer/errorfooter.php') ?>
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
