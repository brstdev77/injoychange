<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

$asset = frontend\assets\AppAsset::register($this);

$baseUrl = $asset->baseUrl;
$action = Yii::$app->controller->action->id;
if ($action == 'welcome'):
  $cls = 'wlcm_wrap';
endif;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl; ?>/images/aspire_favicon//favicon-16x16.png" type="image/x-icon" />
        <link rel="apple-touch-icon" href="/images/aspire_favicon/iphone_icon.jpg" />
        <link rel="apple-touch-icon" sizes="57x57" href="/images/aspire_favicon//apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/images/aspire_favicon//apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/images/aspire_favicon//apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/images/aspire_favicon//apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/images/aspire_favicon//apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/images/aspire_favicon//apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/images/aspire_favicon//apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/images/aspire_favicon//apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/images/aspire_favicon//apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/images/aspire_favicon//android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/images/aspire_favicon//favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/images/aspire_favicon//favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/aspire_favicon//favicon-16x16.png">
        <link rel="manifest" href="/images/aspire_favicon//manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/images/aspire_favicon//ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
   <?php $this->registerJs("
     // Support for AJAX loaded modal window.
   $('[data-toggle=modal]').click(function (e) {
        $('body').addClass('fixedposition');
        e.preventDefault();
        var url = $(this).attr('href');
        var modal_id = $(this).attr('data-modal-id');
        $('#' + modal_id).modal();
        if (url.indexOf('#') == 0) {
            $(url).modal('open');
        } else {
            $.get(url, function (data) {
                $('#' + modal_id + ' .modal-form').html(data);
            });
        }
    });
");
?>
    <body class="recognitiondashboard">
        <?php $this->beginBody() ?>

        <div class="wrap">

            <?= $this->render('header/recognitionheader.php', ['baseUrl' => $baseUrl]) ?>
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


        <?= $this->render('footer/recognitionfooter.php', ['baseUrl' => $baseUrl]) ?>



        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
<!--Smartphone Modal HTML-->
<div class="modal fade" role="dialog" id="smartphone" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close skip_survey" data-dismiss="modal"></button>
                <h4 class="modal-title text-center">How to add url to home screen (Iphone and Android)</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader-leads.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End-->
