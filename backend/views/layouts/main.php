<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
//$this->title = '';
//$this->params['breadcrumbs'][] = $this->title;
$test[] = "test";
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>

        <?php $this->head() ?>
    </head>
    <body class="skin-blue sidebar-mini <?= str_replace(' ', '_', strtolower($this->title)) ?>">
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php include 'header.php'; ?>
            <?php include 'sidebar.php'; ?>
            <div class="content-wrapper" style="min-height:850px; padding:20px;">

                <?php
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'homeLink' => [
                        'label' => 'Home',
                        'url' => ['/'],
                        'template' => "<i class='fa fa-tachometer'></i>&nbsp;<li>{link}</li>\n", // template for this link only
                    ],
                ])
                ?>
                <?= $content ?>
            </div>


        </div>



        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
