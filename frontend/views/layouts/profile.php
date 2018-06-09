<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use backend\models\PilotCreateGame;
use backend\models\PilotGameChallengeName;

$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
AppAsset::register($this);
$user_company_id = Yii::$app->user->identity->company_id;
$challenge_id = Yii::$app->user->identity->challenge_id; 
/* Profile Page as per the Challenge */
$active_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $user_company_id, 'challenge_id' => $challenge_id,'status' => 1])->one();
$challenge_abbr_name = '';
if (!empty($active_challenge)):
  $challenge_id = $active_challenge->challenge_id;
  $challenge_obj = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
  $challenge_name = $challenge_obj->challenge_name;
  $challenge_abbr_name = $challenge_obj->challenge_abbr_name;
else:
  //Fetch the Most Recent Upcoming Challenge
  $upcoming_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $user_company_id, 'status' => 0])
      ->orderBy(['challenge_start_date' => SORT_ASC])
      ->one();
  if (!empty($upcoming_challenge)):
    $challenge_id = $upcoming_challenge->challenge_id;
    $challenge_obj = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
    $challenge_name = $challenge_obj->challenge_name;
    $challenge_abbr_name = $challenge_obj->challenge_abbr_name;
  endif;
endif;
//echo "<pre>"; print_r($challenge_obj); die(" herer");
/* End */
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
    <?php
    $this->registerCssFile($baseurl . "/css/profile.css");
    ?>
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
    <body class="profile <?= $challenge_abbr_name; ?>">
        <?php $this->beginBody() ?>
        <div class="wrap">
            <?= $this->render('header/profileheader.php', ['baseUrl' => $baseUrl, 'company_logo' => $company_logo, 'challenge_abbr_name' => $challenge_abbr_name]) ?>
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
        <?= $this->render('footer/profilefooter.php', ['baseUrl' => $baseUrl]) ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
<!--Smartphone Modal HTML-->
<div class="modal fade" role="dialog" id="smartphone" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">       
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title text-center">How to add url to home screen (Iphone and Android)</h4>
            </div>
            <?php if($user_company_id == 106):?>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader-leads.gif"/>
                </div>
            </div>
            <?php else:?>
               <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader.gif"/>
                </div>
            </div> 
            <?php endif;?>
        </div>
    </div>
</div>
<!--End-->
<?php
$prize_modal_path = '/' . $challenge_abbr_name . '/prize_modal';
echo $this->render($prize_modal_path);
?>