<?php
use backend\models\PilotCreateGame;
use frontend\models\PilotFrontUser;

/* @var $this yii\web\View */
$this->title = 'How it Works';
$baseurl = Yii::$app->request->baseurl;

$user_id = Yii::$app->user->identity->id;
$challenge_id = Yii::$app->user->identity->challenge_id;
//Get the Challenge(Game) ID
$game = PilotFrontUser::getGameID('intentionalleadership');
//User Company ID
$comp_id = Yii::$app->user->identity->company_id;
//Active Challenge Object (Start Date & End Date) 
$game_obj = PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
$gameID = '';
if(!empty($game_obj)){
    $gameID = $game_obj->id;
}
?>
<?php $this->registerCssFile($baseurl . '/css/seeall.css'); 
$this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<?php if (empty($game_obj->howitwork_content)) { ?>
<div class="site-index">
    <div class="seeall-data">
        <div class="dashboard-title" style="padding-bottom:20px"><div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/intentionalleadership/dashboard">&lt; Dashboard</a></div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 high-five-title" style='color:<?=$color;?>'>How it works</div>
        </div>
        <div class="work_content">
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 points-data even">               
                <div class=" col-lg-4 col-md-6 col-sm-6 col-xs-12 left-images">
                    <p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/coredaily.png" /></p>
                </div>                     
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 right-data">
                    <h3>Daily Inspiration</h3>
                    <ul>
                        <li><h4>These are quick daily thoughts of inspiration that will motivate you to excel through this challenge. The daily inspirations relate to the core values and will remind you of their importance.</h4></li>
                        <li><h4>Our attitude is so largely impacted by thought. Even one positive thought read in the morning can set the tone for the whole day.</h4></li>
                        <li><h4>Points Value = 10 points per day</h4></li>
                    </ul>                    
                </div> 
            </div>
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 points-data odd">               
                <div class=" col-lg-4 col-md-6 col-sm-6 col-xs-12 left-images">
                    <p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/corecheck.png" /></p>
                </div>                     
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 right-data">
                    <h3>Check in with yourself</h3>
                    <ul>
                        <li><h4>The Check In With Yourself section is where you will practice reinforcing the core values each day.
                            </h4></li>
                        <li><h4>To earn points for a prior day, click on the calendar icon on the top left of the Check in With Yourself Section. Hover your mouse cursor over the points value on the day you would like to make-up points for, then click on the "Edit" button that appears. From there you can add a Values Action and submit it to make up that day's points.
                            </h4></li>
                        <li><h4>Note : This section is your private journal and your entries will not be shared. All data you enter will be permanently deleted from our platform 2 weeks after the end of this challenge
                            </h4></li>
                        <li><h4>Points Value:  </h4>
                        </li><li><h4>Core Values Pop Up = 5 points per day </h4></li>
                        <li><h4>Core Values Check In = 20 points 2x a day</h4></li>
                    </ul>                    
                </div>
            </div>
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 points-data even">               
                <div class=" col-lg-4 col-md-6 col-sm-6 col-xs-12 left-images">
                    <p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/corepoint.png" /></p>
                </div>                     
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 right-data">
                    <h3>your Points</h3>
                    <ul>
                        <li><h4>This section creates an experience of a game.  There is badge value in being on the leaderboard as well as real prizes that make the whole experience more fun and engaging.</h4></li>
                        <li><h4> Everything you do on this site earns you points. Those points will earn you the chance at some amazing prizes and bragging rights on your team's.</h4></li>
                        <li><h4>Each day you will be able to see your points, keep track of your goals and who the overall leaders are.</h4></li>
                        <?php if($gameID == '159' || $gameID == '158'): ?>
                        <li><h4>Each time you reach 10000 steps, you will receive additional 100 points.</h4></li>
                        <?php endif; ?>
                    </ul>                    
                </div>
            </div>
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 points-data odd">               
                <div class=" col-lg-4 col-md-6 col-sm-6 col-xs-12 left-images">
                    <p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/corehive.png" /></p>
                </div>                     
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 right-data">
                    <h3>Shout Out &amp; Digital High 5's</h3>
                    <ul>
                        <li><h4>This is a simple but powerful way to create an atmosphere of ongoing recognition.
                            </h4></li>
                        <li><h4>Recognition and appreciation are so simple, yet so powerful. This section is a place to show your appreciation for the impact that others make each day. You can also comment or give a Digital High 5 to those who have been recognized by others.
                            </h4></li>
                        <li><h4>Points Value = 10 points, 3x a day</h4></li>
                    </ul>                       
                </div>
            </div>
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 points-data even">               
                <div class=" col-lg-4 col-md-6 col-sm-6 col-xs-12 left-images">
                    <p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/coreleader.png" /></p>
                </div>                     
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 right-data">
                    <h3>Leadership Corner </h3>
                    <ul>
                        <li><h4>In this section, you will read about your leaders personal perspectives on the importance of the Core Values.  
                            </h4></li>
                        <li><h4>The leadership section will become a library of memorable tools and insights for you to take with you throughout this challenge and beyond. 
                            </h4></li>
                        <li><h4>Points Value = 10 points per day</h4></li>
                    </ul>                           
                </div>
            </div>
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 points-data odd">               
                <div class=" col-lg-4 col-md-6 col-sm-6 col-xs-12 left-images">
                    <!--<p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/coreweek.png" /></p>-->
                    <p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/coreweek2.png" /></p>
                </div>                     
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 right-data">
                    <h3>Weekly Challenge</h3>
                    <ul>
                        <li><h4>This is an educational section that includes videos to inspire you and reinforce the overall goals of the challenge. You will watch a variety of videos to gain perspective and motivation through their messages. All videos support the core values and encourage their significance.  
                            </h4></li>
                        <li><h4>Points Value = 40 points per week
                            </h4></li>
                    </ul>                 
                </div>
            </div>
            <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12 points-data even">               
                <div class=" col-lg-4 col-md-6 col-sm-6 col-xs-12 left-images">
                    <p style="text-align: center"><img class=main-banner src="<?= $baseurl; ?>/images/howitwork/coreshare.png" /></p>
                </div>                     
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 right-data">
                    <h3>share a win</h3>
                    <ul>
                        <li><h4>This is a chance to celebrate the journey through this core values challenge.</h4></li>
                        <li><h4>Everyday there are things that are wins. But we rarely celebrate or even acknowledge them. Regardless of whether they are big or small, the more we share our wins and celebrate our progress the more inspired we are to take on harder challenges.</h4></li>
                        <li><h4>Point Value = 10 points per day</h4></li>
                    </ul>              
                </div>
            </div>
        </div>
    </div>
    <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a>  
</div>
<?php
}else {
    $how_content_id = $game_obj->howitwork_content;
    $how_data = backend\models\PilotHowItWork::find()->where(['id' => $how_content_id])->one();
    ?>
    <div class="site-index">
        <div class="seeall-data">
            <div class="dashboard-title"><div class="col-lg-2 col-md-2 col-sm-3 col-xs-12 dashboard-link"><a class="btn btn-warning dashboard" href="<?= $baseurl; ?>/intentionalleadership/dashboard" style='background:<?= $color;?>'>&lt; Dashboard</a></div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 high-five-title" style='color:<?=$color;?>'>How it works</div>
            </div>
            <div class="work_content">
                 <?= $how_data->how_it_work_content; ?>
            </div>
        </div>
        <a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up"></i></a> 
    </div>
<?php } ?>
<?php echo $this->render('prize_modal'); ?>