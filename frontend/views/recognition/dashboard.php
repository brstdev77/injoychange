<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use kartik\file\FileInput;
use yii\web\Cookie;
use kartik\rating\StarRating;
use yii\web\JsExpression;

$this->registerCssFile($baseurl . '/css/style.css');
$this->registerCssFile($baseurl . '/css/font-awesome.min.css');
$this->registerCssFile($baseurl . '/css/fileinput_widget.css');
$this->registerCssFile($baseurl . '/css/jQuery.AudioPlayer.css');

$this->title = 'Recognition Dashboard';
?>
<div class="site-index">
    <div class="content main-dashboard-banners">
        <!--<div class=container>-->
        <div class=row>
            <div class=col-md-12>
                <div class=main-dashboard-banner>
                    <img class=main-banner src="http://root.injoychange.com/backend/web/img/game/welcome_banner/recognition.jpg" alt=banner height=392 width=1180 />  
                </div>
            </div>
        </div>
        <div class=row>
            <div class="col-md-7 col-sm-7 col-xs-12 outer_left">
                <div class=s_checkin1>
                    <div class="bg-color1 bg-img1">
                        <h1 class="heading hh new"> Team Accomplishments </h1>
                        <div class="accomplishments">
                            <div class="padding-0 col-lg-6 col-md-6 col-xs-12 value_left 1">
                                <div class="top">
                                    <div class="img_b">
                                        <p class="rock">Check Out What You Accomplished As A Team!</p>
                                    </div>  
                                </div>
                                <div class="middle">
                                    <div class="img_b">
                                        <p class="rock1">Total Actions:</p>
                                    </div>
                                    <div class="actions1">
                                        <img width="66" height="42" alt="bg" src="../images/total_actions.png">
                                        <p class="num_pts num_pt1">182</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 value_right">
                                <div class="col-md-4 col-xs-4 img_spl">
                                    <div class="first leaderboard_actions single">325</div>
                                    <div class="leaderboard_img1">
                                        <span>Wins</span>
                                        <img src="../images/sharewins.png">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-4 img_spl">
                                    <div class="second leaderboard_actions single">137</div>
                                    <div class="leaderboard_img2">
                                        <span>Check Ins</span>
                                        <img src="../images/actions.png">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-4 img_spl">
                                    <div class="third leaderboard_actions single">235</div>
                                    <div class="leaderboard_img3">
                                        <span>Shout Outs</span>
                                        <img src="../images/shoutouts.png">
                                    </div>
                                </div>
                            </div>       
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-12 outer_left">
                <div class="today_g">
                    <h1 class="heading_w">
                        Personal Accomplishments
                    </h1>
                    <div class="value1 individual">
                        <div class="upper">
                            <a download="" target="_blank" href="#"> 
                                <img width="93" height="93"  src="../images/personal_prize.png" alt="Share_Story">
                            </a>
                            <div class="report-data">
                                <p class="smallpdf">Your Personal Report</p>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 see-more-link">
                                    <a class="comm_view wall" href="personal-report-modal" data-toggle="modal" data-modal-id="core-values">DOWNLOAD</a>
                                </div>
                            </div>
                        </div>
                        <div class="middle1 no_more">
                            <a href="#">
                                <img width="93" height="93" src="../images/certificate.png" alt="Share_Story"></a>
                            <div class="report-data1">
                                <p class="smallpdf">Certificate of Completion</p>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 see-more-link">
                                    <a class="comm_view wall" href="certificate-modal" data-toggle="modal" data-modal-id="certificate-modal">DOWNLOAD</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-12 outer_left">
                <div class=s_daily_ins>
                    <div class="bg-color2 bg-img2">
                        <h1 class="heading hh new"> Thought of the day </h1>
                        <div class=submitinspiration>
                            <!--div href="daily-modal" data-toggle="modal" data-modal-id="daily-inspiration" class="checkbox checkbox1 abs"-->
                            <div href="daily-modal" data-toggle="modal" data-modal-id="daily-inspiration" class="recognition checkbox checkbox1 abs">
<!--                                <div class=label1><input type=checkbox>
                                    <label class='daily_checkbox <?= $daily_btn_cls; ?>'></label>-->
                                <span> Click Here</span>
                            </div>
                        </div>
                        <div class="see_more see_more1">
                            <span class="see-al"><a href="#">See All <span><i class="fa fa-angle-right"></i></span></a></span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-7 col-xs-12 outer_right recognition">
                <div class="s_checkin">
                    <div class="bg-color">
                        <div class="value">
                            <div class="form">
                                <h2 style='text-transform:uppercase;'>Celebrating your success</h2>
                            </div>
                            <div class="col-md-2 col-xs-2 col-lg-2 img_new">
                                <img src="../images/b7.png" />
                            </div>
                            <div class="col-md-10 col-xs-10 col-lg-10 text_new">
                                <h1>What are 3 wins you had doing this challenge?</h1>
                                <input type="text" id="firstwin" name="firstwin" placeholder="First Win..">
                                <input type="text" id="secondwin" name="secondwin" placeholder="Second Win..">
                                <input type="text" id="thirdwin" name="thirdwin" placeholder="Third Win..">
                            </div>
                            <div id="today_values">
                                <div class="new-mail-submit present_width">
                                    <div class="new_text new_text1">
                                        <div class="submit-image">
                                            <span class="background-checkbox uncheck"></span>
                                            <input type="button" value="Submit" name="op" class="new-user-submit btn btn-primary form-submit dash-btn" id="new-mail-submit">
                                        </div>
                                    </div>
                                </div>
                                <a class="" href="#">View All&nbsp;<span><i class="fa fa-angle-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 outer_right">
                <div class="s_checkin1">
                    <div class="bg-color">
                        <div class="value">
                            <div class="form">
                                <h2 style='text-transform:uppercase;'>Celebrating our team's success</h2>
                            </div>
                            <div id="myCarousel" class="carousel carousel1 slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="recognition-corousel item active">
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content1">
                                                <div class=share-user-name1>
                                                    Jeff Baietto
                                                </div>
                                                <p>
                                                    I feel the core challenge gives you a positive lift in the morning before you start your work day.
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content2">
                                                <div class=share-user-name1>
                                                    Phil Dixon
                                                </div>
                                                <p>
                                                    I think this challenge has been my favorite thus far, simply because we are in a service industry and our jobs are to put others first. I tell my team that I am here to serve them; I consider myself to be a servant leader, so the 
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content3">
                                                <div class=share-user-name1>
                                                    Brady Teter
                                                </div>
                                                <p>
                                                    The biggest benefit I can take from this challenge is the dedication and encouragement our teams have for one another. Empowerment, it really shows the core value we have within ourselves . It feels good to see others appreciate other employees even outside of their property, and it feels good to receive the positive feedback. With all the positive attitudes & words of encouragement it just re assures us that we all have each others back.
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recognition-corousel item">
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content1">
                                                <div class=share-user-name1>
                                                    Jeff Baietto
                                                </div>
                                                <p>
                                                    I feel the core challenge gives you a positive lift in the morning before you start your work day.
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content2">
                                                <div class=share-user-name1>
                                                    Phil Dixon
                                                </div>
                                                <p>
                                                    I think this challenge has been my favorite thus far, simply because we are in a service industry and our jobs are to put others first. I tell my team that I am here to serve them; I consider myself to be a servant leader, so the 
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content3">
                                                <div class=share-user-name1>
                                                    Brady Teter
                                                </div>
                                                <p>
                                                    The biggest benefit I can take from this challenge is the dedication and encouragement our teams have for one another. Empowerment, it really shows the core value we have within ourselves . It feels good to see others appreciate other employees even outside of their property, and it feels good to receive the positive feedback. With all the positive attitudes & words of encouragement it just re assures us that we all have each others back.
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="recognition-corousel item">
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content1">
                                                <div class=share-user-name1>
                                                    Jeff Baietto
                                                </div>
                                                <p>
                                                    I feel the core challenge gives you a positive lift in the morning before you start your work day.
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content2">
                                                <div class=share-user-name1>
                                                    Phil Dixon
                                                </div>
                                                <p>
                                                    I think this challenge has been my favorite thus far, simply because we are in a service industry and our jobs are to put others first. I tell my team that I am here to serve them; I consider myself to be a servant leader, so the 
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/^54A8FF015CA2AE515A5756B92BB06F3DC274C9D225BC0C8767^pimgpsh_fullsize_distr.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 carousel-caption1">
                                            <div class="share-content3">
                                                <div class=share-user-name1>
                                                    Brady Teter
                                                </div>
                                                <p>
                                                    The biggest benefit I can take from this challenge is the dedication and encouragement our teams have for one another. Empowerment, it really shows the core value we have within ourselves . It feels good to see others appreciate other employees even outside of their property, and it feels good to receive the positive feedback. With all the positive attitudes & words of encouragement it just re assures us that we all have each others back.
                                                </p>
                                            </div>
                                            <div class=share-user-data1>
                                                <img src="http://injoyglobal.com/wp-content/uploads/2017/02/1.jpg"  class=slider-userimage alt=slider height=63 width=63 style="border: 3px solid #fff;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<!--All Modals HTML-->
<!-- Daily Inspiration Modal HTML-->
<div class="modal fade" role="dialog" id="daily-inspiration" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">THOUGHT OF THE DAY</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader-leads.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Personal Report Modal HTML--> 
<div class="modal fade" role="dialog" id="core-values" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Personal Report</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader-leads.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Check In Modal HTML-->
<div class="modal fade" role="dialog" id="certificate-modal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"></button>
                <h4 class="modal-title">Certificate Of Completion</h4>
            </div>
            <div class="modal-form">
                <div class="modal-ajax-loader">  
                    <img src="../images/ajax-loader-leads.gif"/>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile($baseurl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/bootstrap-notify.min.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<style>
    div#star_integrity,#total_scores{
        display:none;
    }
</style>