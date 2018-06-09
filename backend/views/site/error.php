<?php
/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;
use backend\models\PilotLogs;

//echo '<pre>';
//print_r($exception);
//die;
$this->title = $name;
$this->params['breadcrumbs'][] = $this->title;
if ($exception->statusCode == 404) {
    // call the function from pilotlogs model to save the error log in database
    PilotLogs::setpilotlog(Yii::$app->user->identity->id, 'page', 'warning', Yii::$app->request->hostInfo . Yii::$app->request->url, 'page not found!');
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            404 Error Page
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                <p>
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href=<?php echo Yii::$app->homeUrl . 'site/index' ?>>return to dashboard</a> or try using the search form.
                </p>

                <form class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->

    <?php
} elseif ($exception->statusCode == 403) {
    // call the function from pilotlogs model to save the error log in database
    PilotLogs::setpilotlog(Yii::$app->user->identity->id, 'page', 'warning', Yii::$app->request->hostInfo . Yii::$app->request->url, 'access denied!');
    ?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            403 Forbidden Access
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 403</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Access Denied.</h3>

                <p>
                    Page or resources you were trying to reach is absolutely forbidden for some reason.
                    Meanwhile, you may <a href=<?php echo Yii::$app->homeUrl . 'site/index' ?>>return to dashboard</a> or try using the search form.
                </p>

                <form class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">

                        <div class="input-group-btn">
                            <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
    <!-- /.content -->

    <?php
} else {
    // call the function from pilotlogs model to save the error log in database
    PilotLogs::setpilotlog(Yii::$app->user->identity->id, 'php', 'error', Yii::$app->request->hostInfo . Yii::$app->request->url, $exception->getMessage());
    ?>
    <div class="site-error">
        <div class="content-wrapper-error">
            <section class="content-header">
                <h1>
                    500 Error Page
                </h1>   
            </section>
            <section class="content">
                <div class="error-page">
                    <h2 class="headline text-red">500</h2>
                    <div class="error-content">
                        <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
                        <p>
                            We will work on fixing that right away.
                            Meanwhile, you may <a href=<?php echo Yii::$app->homeUrl . 'site/index' ?>>return to dashboard</a> or try using the search form.
                        </p>
                        <form class="search-form">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search">
                                <div class="input-group-btn">
                                    <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>

    </div>


    <!--    <div class="site-error">

            <h1><? //= Html::encode($this->title)     ?></h1>

            <div class="alert alert-danger">
    <? //= nl2br(Html::encode($message))   ?>
            </div>

            <p>
                The above error occurred while the Web server was processing your request.
            </p>
            <p>
                Please contact us if you think this is a server error. Thank you.
            </p>

        </div>-->
<?php } ?>