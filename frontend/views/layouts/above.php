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
$curentUrl = Yii::$app->request->hostInfo;
$url = parse_url($curentUrl, PHP_URL_HOST);
$explodedUrl = explode('.', $url);
//save company name into $comp
$comp = $explodedUrl[0];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/fav.png" type="image/x-icon" />
        <?php if ($comp == 'toyota') { ?>
            <link rel="apple-touch-icon" href="/images/iphone_icon_toyota.png" />
        <?php }  ?>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="dashboard">
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            ?>
            <?= $this->render('header/aboveheader.php', ['baseUrl' => $baseUrl]) ?>
            <div class="container">

                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
<?= $content ?>
            </div>
        </div>
        <?= $this->render('footer/abovefooter.php', ['baseUrl' => $baseUrl]) ?>
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
