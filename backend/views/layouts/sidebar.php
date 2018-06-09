<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;

$baseurl = Yii::$app->homeUrl;
$highlight_tag1 = Yii::$app->request->get('PilotTags');
$highlight_tag = $highlight_tag1['tags'];
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (!empty(Yii::$app->user->identity->profile_pic)) { ?>
                    <img src="<?php echo $baseUrl . "/img/profilepic/" . Yii::$app->user->identity->profile_pic; ?>" class="img-circle" alt="User Image">
                <?php } else { ?>
                    <img src="<?php echo $baseUrl . "/img/profilepic/noimage.png" ?>" class="img-circle" alt="User Image">
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form method="get" action="/backend/web/" id="form-tags" class="sidebar-form">
            <!-- search form (Optional) -->
            <div class="input-group">

                <input type="text" name="PilotTags[tags]" id="highlight_tag" class="form-control" placeholder="Search Tags..." value="<?= $highlight_tag; ?>" autocomplete="off">

                <span class="input-group-btn">
                    <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-flat', 'id' => 'search-btn']) ?>
                    </button>
                </span>
            </div>
            <div id=display2></div>
            <div id=msgbox1></div>

        </form>
        <ul class="sidebar-menu">
                    <li <?php if ($controller == 'site' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl; ?>><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
            <li class="treeview <?php if ($controller == 'pilot-todayslesson-category' || $controller == 'pilot-todayslesson-corner' || $controller == 'pilot-voicematters-category' || $controller == 'pilot-voicematters-challenge' || $controller == 'pilot-gettoknow-category' || $controller == 'pilot-gettoknow-corner' || $controller == 'pilot-didyouknow-category' || $controller == 'pilot-didyouknow-corner' || $controller == 'pilot-leadership-category' || $controller == 'pilot-leadership-corner' || $controller == 'manageclients' || $controller == 'pilot-corevalues' || $controller == 'pilot-dailyinspiration-category' || $controller == 'pilot-weekly-category' || $controller == 'pilot-weekly-challenge' || $controller == 'pilot-leadership-category' || $controller == 'pilot-leadership-corner' || $controller == 'pilot-survey-question' || $controller == 'pilot-checkin-yourself-category' || $controller == 'pilot-prizes-category' || $controller == 'pilot-how-it-work' || $controller == 'pilot-create-game') echo 'active'; ?>">
                <a href="#">
                    <i class="fa fa-cog"></i> <span>Set up a Challenge</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if (Yii::$app->user->identity->role == '1') {
                        ?>
                        <li class="treeview <?php if ($controller == 'manageclients') echo 'active'; ?>">
                            <a href="#"><i class="fa fa-link"></i> <span>Company</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li  <?php if ($controller == 'manageclients' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "manageclients/index" ?>><i class="fa fa-circle-o"></i> <span>Company Listing</span></a></li>
                                <li  <?php if (($controller == 'manageclients') && ($action == 'create')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "manageclients/create" ?>><i class="fa fa-circle-o"></i> <span>Edit/ Add a New Company</span></a></li>                     
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="treeview <?php if ($controller == 'pilot-todayslesson-category' || $controller == 'pilot-todayslesson-corner' || $controller == 'pilot-voicematters-category' || $controller == 'pilot-voicematters-challenge' || $controller == 'pilot-gettoknow-category' || $controller == 'pilot-gettoknow-corner' || $controller == 'pilot-didyouknow-category' || $controller == 'pilot-didyouknow-corner' || $controller == 'pilot-corevalues' || $controller == 'pilot-dailyinspiration-category' || $controller == 'pilot-weekly-category' || $controller == 'pilot-weekly-challenge' || $controller == 'pilot-leadership-category' || $controller == 'pilot-leadership-corner' || $controller == 'pilot-survey-question' || $controller == 'pilot-checkin-yourself-category' || $controller == 'pilot-prizes-category' || $controller == 'pilot-how-it-work') echo 'active'; ?>">
                        <a href="#"><i class="fa fa-link"></i> <span>Content</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li  <?php if ($controller == 'pilot-dailyinspiration-category' && ($action == 'index' || $action == 'dailyinspiration')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-dailyinspiration-category/index" ?>><i class="fa fa-circle-o"></i> <span>Daily Inspiration</span></a></li>
                            <li  <?php if (($controller == 'pilot-weekly-category' || $controller == 'pilot-weekly-challenge') && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-weekly-category/index" ?>><i class="fa fa-circle-o"></i> <span>Weekly Challenge</span></a></li>
                            <li  <?php if (($controller == 'pilot-leadership-category' || $controller == 'pilot-leadership-corner') && ($action == 'index' || $action == 'create' || $action == 'update')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-leadership-category/index" ?>><i class="fa fa-circle-o"></i> <span>Leadership Corner</span></a></li>
                            <li  <?php if ($controller == 'pilot-survey-question' && ($action == 'index' || $action == 'create' || $action == 'update')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-survey-question/index" ?>><i class="fa fa-circle-o"></i> <span>Survey Questions</span></a></li>
                            <li  <?php if ($controller == 'pilot-corevalues' && ($action == 'index' || $action == 'create' || $action == 'update' || $action == 'coreimage')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-corevalues/index" ?>><i class="fa fa-circle-o"></i> <span>Core Values</span></a></li>
                            <li  <?php if ($controller == 'pilot-checkin-yourself-category' && ($action == 'index' || $action == 'create' || $action == 'update')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-checkin-yourself-category/index" ?>><i class="fa fa-circle-o"></i> <span>Checkin Yourself</span></a></li>
                            <li  <?php if ($controller == 'pilot-prizes-category' && ($action == 'index' || $action == 'create' || $action == 'update')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-prizes-category/index" ?>><i class="fa fa-circle-o"></i> <span>Prizes Category</span></a></li>
                            <li  <?php if ($controller == 'pilot-how-it-work' && ($action == 'index' || $action == 'create' || $action == 'update')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-how-it-work/index" ?>><i class="fa fa-circle-o"></i> <span>How It Work</span></a></li>
                            <li  <?php if (($controller == 'pilot-didyouknow-category' || $controller == 'pilot-didyouknow-corner')  && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-didyouknow-category/index" ?>><i class="fa fa-circle-o"></i> <span>Did You Know Corner</span></a></li>
                            <li  <?php if (($controller == 'pilot-gettoknow-category' || $controller == 'pilot-gettoknow-corner')  && ($action == 'index' || $action == 'create' || $action == 'update')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-gettoknow-category/index" ?>><i class="fa fa-circle-o"></i> <span>Get to Know the Team</span></a></li>
                            <li  <?php if (($controller == 'pilot-voicematters-category' || $controller == 'pilot-voicematters-challenge')  && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-voicematters-category/index" ?>><i class="fa fa-circle-o"></i> <span>Voice Matters</span></a></li>
                            <li  <?php if (($controller == 'pilot-todayslesson-category' || $controller == 'pilot-todayslesson-corner')  && ($action == 'index' || $action == 'create' || $action == 'update')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-todayslesson-category/index" ?>><i class="fa fa-circle-o"></i> <span>Today's Lesson</span></a></li>
                        </ul>
                    </li>
                    <li class="treeview <?php if ($controller == 'pilot-create-game') echo 'active'; ?>">
                        <a href="#"><i class="fa fa-link"></i> <span>Challenge</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li  <?php if ($controller == 'pilot-create-game' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-create-game/index" ?>><i class="fa fa-circle-o"></i> <span>Challenge Listing</span></a></li>
                            <li  <?php if (($controller == 'pilot-create-game') && ($action == 'game')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-create-game/game" ?>><i class="fa fa-circle-o"></i> <span>Add a Challenge</span></a></li>                     
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview <?php if ($controller == 'pilot-event-calender' || $controller == 'pilot-support' || $controller == 'pilot-logs') echo 'active'; ?>">
                <a href="#">
                    <i class="fa fa-tasks"></i> <span>Resources</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">

                    
                    <li <?php if ($controller == 'pilot-event-calender' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-event-calender/index" ?>><i class="fa fa-calendar-minus-o"></i> <span>Calender</span></a></li>

                    <li><a href="#"><i class="fa fa-book"></i> <span>Reports</span></a></li>
                    <li <?php if ($controller == 'pilot-logs' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-logs/index" ?>><i class="fa fa-link"></i> <span>Logs</span></a></li>
                    <li <?php if ($controller == 'pilot-support' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-support/index" ?>><i class="fa fa-users"></i> <span>Support</span></a></li>

                </ul>
            </li>


            <?php if (Yii::$app->user->identity->role == '1') {
                ?>
             <li <?php if ($controller == 'inhouseuser' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "inhouseuser/index" ?>><i class="fa fa-users"></i> <span>In-house users</span></a></li>
             <li <?php if ($controller == 'site' && ($action == 'user-listing')) echo "class='active'"; ?>><a href=<?php echo $baseUrl. "site/user-listing" ; ?>><i class="fa fa-fw fa-user"></i> <span>User Listing</span></a></li>
                 <?php } ?>
        </ul>
        <?php
        //if (Yii::$app->user->identity->role != '1' && Yii::$app->user->identity->role == '2') {
        ?>
        <!--ul class="sidebar-menu">
            <li <?php if ($controller == 'site' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "site/index" ?>><i class="fa fa-tachometer"></i> <span>Dashboard</span></a></li>
            <li <?php if ($controller == 'pilot-event-calender' && ($action == 'index')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "pilot-event-calender/index" ?>><i class="fa fa-calendar-minus-o"></i> <span>Calender</span></a></li>

            <li <?php if ($controller == 'site' && ($action == 'logout')) echo "class='active'"; ?>><a href=<?php echo $baseUrl . "site/logout" ?>><i class="fa fa-sign-out"></i> <span>Logout</span></a></li>

        </ul-->
        <?php //}
        ?>


    </section>
</aside>
<style>
    #display2, #msgbox1 {
        background: none repeat scroll 0 0 white;
        display: none;
        float: left;
        overflow-x: hidden;
        overflow-y: scroll;
        padding: 0;
        position: absolute;
        top: 150px;
        width: 91%;
        z-index: 9999;
    }
    .display_box a {
        font-size: 16px;
        top: 5px;
        color:black !important;
    }
</style>