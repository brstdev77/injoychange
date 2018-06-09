<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$baseUrl = $asset->baseUrl;
$this->title = 'Error 404 | InjoyGlobal'
?>
<?php $this->registerCssFile($baseurl . "/css/error.css", ['position' => yii\web\View::POS_READY, 'depends' => ['yii\bootstrap\BootstrapAsset']]); ?>
<section class="content">
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
            <p>
                We could not find the page you were looking for.
            </p>
            <p>
                <a href="/"> Return to Home </a>
            </p>
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>

