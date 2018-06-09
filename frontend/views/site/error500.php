<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

$baseUrl = $asset->baseUrl;
$this->title = 'Error 500 | InjoyGlobal'
?>
<?php $this->registerCssFile($baseurl . "/css/error.css", ['position' => yii\web\View::POS_READY, 'depends' => ['yii\bootstrap\BootstrapAsset']]); ?>
<section class="content">
    <div class="error-page">
        <h2 class="headline text-red"> 500 </h2>
        <div class="error-content">
            <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong..</h3>
            <p>
                We will work on fixing that right away.
            </p>
            <p>
                Meanwhile, you may 
                <a href="/"> Return to Home </a>
            </p>
        </div>
        <!-- /.error-content -->
    </div>
    <!-- /.error-page -->
</section>

