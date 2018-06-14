<?php
use yii\helpers\Html;
$baseurl = Yii::$app->request->baseurl;
//$baseurl = str_replace('/admin', '', $baseurl);

$action = Yii::$app->controller->action->id;



?>
<header>
<div id=top-header>
<div class=container>
<div class=row>
<div class="col-xs-4 col-sm-4 col-md-4 left-logo"><div class=leftlogo><a href=<?= $baseurl; ?>><img alt=logo src="<?= $baseurl; ?>/images/logo.png" height=81 width=318></a></div></div>
<div class="col-xs-8 col-sm-8 col-md-8 right-info">
<div class=header-right>
    <?php
    
        if (Yii::$app->user->isGuest) {

            ?>

    <?php
            
    } 
    else
    {
        ?>
    <ul class=header-options>
<li><a class=name_user><?php echo Yii::$app->user->identity->username ;?></a> </li>
<li><?php
        echo    Html::beginForm(['site/logout'], 'post')
            . Html::submitButton(
                'Logout',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
?></li>
</ul>
    <div class=user-image>
<img class=header-userimage src="<?= $baseurl; ?>/images/user.png" alt=user_icon height=59 width=59 />
</div>
    <?php
    }
    ?>


</div>
</div>
</div></div>
</div>
    
    <?php

    if($action=='signup' || $action=='login'|| $action=='index' || $action=='leaderboard')
{     
    }
 else {
        ?>
    
    
<div class=bottom-header>
<div class=container>
<div class=row>
<div class=col-md-12>
<nav class="navbar navbar-inverse">
<div class=navbar-header>
<button type=button class=navbar-toggle data-toggle=collapse data-target="#collapse">
<span class=sr-only>Toggle navigation</span>
<span class=icon-bar></span>
<span class=icon-bar></span>
<span class=icon-bar></span>
</button>
</div>
<div id=collapse class="collapse navbar-collapse navbar-left">
<ul class="nav navbar-nav">
<li><a href="<?= $baseurl; ?>/teamwork/how-it-work">how it works</a></li>
<li><a href="#">Contest Rules/Prizes</a></li>
<li><a href="#">Tech Support</a></li>
<li><a href="#">SmartPhone</a></li>
<li><a href="<?= $baseurl; ?>/teamwork/leaderboard">Leaderboards</a></li>
</ul>
</div>
</nav>
<div class=notification>
<a href='#'><img class=notification src="<?= $baseurl; ?>/images/notificationteam.png" alt=notification height=32 width=32 /></a>
</div>
</div></div></div>
</div>
    <?php
 }
    ?>
</header>
  