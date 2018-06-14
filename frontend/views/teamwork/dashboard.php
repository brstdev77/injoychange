<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard | Teamwork';
$baseurl = Yii::$app->request->baseurl;
$this->registerCssFile($baseurl . '/css/style.css');
?>
<?php $this->registerCssFile($baseurl . '/css/font-awesome.min.css'); ?>
<div class="site-index">
<div class="content main-dashboard-banners">
<!--<div class=container>-->
<div class=row>
<div class=col-md-12>
<div class=main-dashboard-banner>
<img class=main-banner src="<?= $baseurl; ?>/images/banner_team.png" alt=banner height=392 width=1180 />
</div>
</div>
</div>
<!--</div>-->
<!--<div class=container>-->
<div class=row>
<div class="col-md-4 col-sm-4 outer_left">
<div class="">
<div class=s_daily_ins>
<div class="bg-color bg-img">
<h1 class="heading hh new"> Daily Inspiration </h1>
<div class=submitinspiration>
<div class="checkbox checkbox1 abs">
<div class=label1><input type=checkbox><label class=unchecked> </label>Submit 10 Pts</div>
</div>
    <div class="see_more">
    <span class="see-al"><a href="<?= $baseurl; ?>/teamwork/daily-inspiration">See All <span><i class="fa fa-angle-right"></i></span></a></span>
    </div>

</div>
</div>
</div>
<div class=s_points>
<div class="bg-color height-fix">
<h1 class="heading hh new">your Points</h1>
<div class=content1>
<ul class=top_points>
<li class=abs> <img src="<?= $baseurl; ?>/images/gradd.png" alt=bg height=42 width=66><p class="num_pt num_pt1">0</p><p class=pt>Total Points</p> </li>
<li class=abs><img class=point src="<?= $baseurl; ?>/images/point.png" alt=point height=50 width=51><p class=num_pt_circle1>2</p><p class="pt hide">points</p> </li>
<li class=abs><img src="<?= $baseurl; ?>/images/entry.png" alt=entry height=47 width=68> <p class=pt>0 Entry</p> </li>
</ul>
<table id=tt>
<thead>
<tr>
<th class=rank_user>RANK </th>
<th class=profile_user>PROF. PIC</th>
<th class=name_user>NAME </th>
<th class=points_user>POINTS</th>
</tr>
</thead>
<tbody>
<tr class=odd>
<td class=oned>1</td>
<td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
<td class=tn>Laura Gibbs </td>
<td class=fourd>3180</td>
</tr>
<tr class=even>
<td class=oned>2</td>
<td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
<td class=tn>Kevin Steele</td>
<td class=fourd>2980</td>
</tr>
<tr class=odd>
<td class=oned>3</td>
<td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
<td class=tn>Laura Gibbs </td>
<td class=fourd>3180</td>
</tr>
<tr class=even>
<td class=oned>4</td>
<td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
<td class=tn>Kevin Steele</td>
<td class=fourd>2980</td>
</tr>
<tr class=odd>
<td class=oned>5</td>
<td class=twod> <img alt=people src="<?= $baseurl; ?>/images/user1.jpg" height=50 width=50></td>
<td class=tn>Laura Gibbs </td>
<td class=fourd>3180</td>
</tr>
</tbody>
</table>
<span class=see1><a href="javascript:void(0);"> See All <span><i class="fa fa-angle-right"></i></span></a></span>
<div class=base_pt>
<h2>Team Core Values Actions</h2>
<h6><span class=prog_last_community>532</span></h6>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-8 col-sm-8 outer_right">
<div class=s_checkin>
<div class=bg-color>
<h1 class="heading new">
<a class=checkin-calendaricon href="/calendar"><img src="<?= $baseurl; ?>/images/calimg.png" alt="" height=24 width=25></a>Check in with yourself
<span class=icon_right><img src="<?= $baseurl; ?>/images/smartphn.png" alt="" height=26 width=16></span>
</h1>
<div class=value>
<div class=value_content>
<div class=activecontent>
<h4>CORE VALUES</h4>
<a href="#">
<img src="<?= $baseurl; ?>/images/core.png" alt="" height=218 width=219>
</a>
</div>
<div class=submitcore>
<div class="checkbox checkbox1 core_value">
<div class=label1><input type=checkbox><label class=unchecked> </label>Submit 5 Pts</div>
</div>
</div>
</div>
<div class=form>
<h1>How did you use one of the values today?</h1>
<form id=today_values action="#" method=post>
<div>
<div class="form-item form-type-select user-form-email form-group">
<div class="form-item form-type-select form-item-which-values">
<select id=new-user-email class="new-user-email form-control form-select" name=which_values>
<option value="" selected style="display: none;">Which value</option>
<option value="Responsiveness and commitment to our community">Responsiveness and commitment to our community
</option><option value="Accountability and integrity in our operation">Accountability and integrity in our operation</option>
<option value="Excellence through evidence-based and innovative practices">Excellence through evidence-based and innovative practices</option>
<option value="Leading by example">Leading by example</option>
</select>
</div>
</div>
<div class=form-today-values-textfield><div class=form-group><div class="form-item form-type-textarea form-item-today-values">
<div class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
<textarea id=core_value_area placeholder="Write a sentence or two on how you used that value today" maxlength=100 class="good-news-textarea form-textarea required form-textarea" name=today_values cols=60 rows=5>
</textarea>
</div>
</div>
<div class=maximum-character></div></div></div>
<div class="new-mail-submit  "><div class="col-sm-9 new_text"><div class=submit-image><span class="background-checkbox uncheck"></span>
<span class="background-checkbox uncheck"></span><input id=new-mail-submit class="new-user-submit btn btn-primary form-submit" name=op value="Submit 20 PTS" type=submit></div>
</div></div>
 <div class=checkin-seeall><a href="<?= $baseurl; ?>/teamwork/checkin" class="">See All&nbsp;<span><i class="fa fa-angle-right"></i></span></a></div>
</div>
</form>
</div>
</div>
</div>
</div>
<div class=s_shout_out>
<div class=bg-color>
<h1 class=heading_w>DIGITAL HIGH 5 - Who do you appreciate today?</h1>
<div class=place>
<form id=shareWin action="#" method=post accept-charset=UTF-8>
<div><div class="content pc"><div class=top-content>
<div class=comment-container><div class=profile_high_five_image>
<img src="<?= $baseurl; ?>/images/shout.jpg" alt=shout></div>
<div class="benefits-textbox form-control" placeholder="What is one thing you appreciate about one of your teammates today?" id=benefits-recieved contenteditable=true></div></div><div id=display>
</div><div id=msgbox> </div><div class=text-grateful-var></div></div>
<div class=submits><span class=sb_pt><input checked type=checkbox>
<label class=unchecked></label>
<input checked type=checkbox>
<label class=unchecked></label>
<input checked type=checkbox>
<label class=unchecked></label><input id=benefits-submit name=op value="SUBMIT 10 PTS" class=form-submit type=submit></span></div></div>
</div></form>
<div class=addmore-seeall>
<a class="squaredbutton1 right" href="<?= $baseurl; ?>/teamwork/hive-five">See All <span><i class="fa fa-angle-right"></i></span></a>
</div>
</div>
<div class=outer-content>
<div class=last-content>
<div class="High-5 w">
<div class=user>
<img alt=user title=Image src="<?= $baseurl; ?>/images/shout_user1.jpg" height=50 width=50>
</div>
<ul class=user-info>
<li> <h5>Christina Martin</h5></li>
<li> <p>Daniell Thankyou for all your support with my BMR Questions</li>
</ul>
<div class=count><div class="high-five liked">
<input name=high-five value="High Five" type=submit></div>
<img alt=background src="<?= $baseurl; ?>/images/hand.png" height=26 width=78><p class=num>0</p>
<div class=comment_count>
<span> (<span class="c_count 3612">0</span>)<a href="#"> Add Comment</a></span></div></div>
</div>
<div class=High-5>
<div class=user>
<img alt=user title=Image src="<?= $baseurl; ?>/images/shout_user2.jpg" height=50 width=50>
</div>
<ul class=user-info>
<li> <h5>Christina Martin</h5></li>
<li> <p>Daniell Thankyou for all your support with my BMR Questions</li>
</ul>
<div class=count><div class="high-five not-liked">
<input name=high-five value="High Five" type=submit></div>
<img alt=background src="<?= $baseurl; ?>/images/hand.png" height=26 width=78><p class=num>0</p>
<div class=comment_count>
<span> (<span class="c_count 3612">0</span>)<a href="javascript:void(0);"> Add Comment</a></span></div></div>
</div>
<div class="High-5 w">
<div class=user>
<img alt=user title=Image src="<?= $baseurl; ?>/images/shout_user1.jpg" height=50 width=50>
</div>
<ul class=user-info>
<li> <h5>Christina Martin</h5></li>
<li> <p>Daniell Thankyou for all your support with my BMR Questions</li>
</ul>
<div class=count><div class="high-five liked">
<input name=high-five value="High Five" type=submit></div>
<img alt=background src="<?= $baseurl; ?>/images/hand.png" height=26 width=78><p class=num>0</p>
<div class=comment_count>
<span> (<span class="c_count 3612">0</span>)<a href="javascript:void(0);"> Add Comment</a></span></div></div>
</div>
<div class=High-5>
<div class=user>
<img alt=user title=Image src="<?= $baseurl; ?>/images/shout_user2.jpg" height=50 width=50>
</div>
<ul class=user-info>
<li> <h5>Christina Martin</h5></li>
<li> <p>Daniell Thankyou for all your support with my BMR Questions</li>
</ul>
<div class=count><div class="high-five not-liked">
<input name=high-five value="High Five" type=submit></div>
<img alt=background src="<?= $baseurl; ?>/images/hand.png" height=26 width=78><p class=num>0</p>
<div class=comment_count>
<span> (<span class="c_count 3612">0</span>)<a href="javascript:void(0);"> Add Comment</a></span></div></div>
</div>
<div class="High-5 w">
<div class=user>
<img alt=user title=Image src="<?= $baseurl; ?>/images/shout_user1.jpg" height=50 width=50>
</div>
<ul class=user-info>
<li> <h5>Christina Martin</h5></li>
<li> <p>Daniell Thankyou for all your support with my BMR Questions</li>
</ul>
<div class=count><div class="high-five liked">
<input name=high-five value="High Five" type=submit></div>
<img alt=background src="<?= $baseurl; ?>/images/hand.png" height=26 width=78><p class=num>0</p>
<div class=comment_count>
<span> (<span class="c_count 3612">0</span>)<a href="javascript:void(0);"> Add Comment</a></span></div></div>
</div>
<div class=High-5>
<div class=user>
<img alt=user title=Image src="<?= $baseurl; ?>/images/shout_user2.jpg" height=50 width=50>
</div>
<ul class=user-info>
<li> <h5>Christina Martin</h5></li>
<li> <p>Daniell Thankyou for all your support with my BMR Questions</li>
</ul>
<div class=count><div class="high-five not-liked">
<input name=high-five value="High Five" type=submit></div>
<img alt=background src="<?= $baseurl; ?>/images/hand.png" height=26 width=78><p class=num>0</p>
<div class=comment_count>
<span> (<span class="c_count 3612">0</span>)<a href="javascript:void(0);"> Add Comment</a></span></div></div>
</div>
<div class="High-5 w">
<div class=user>
<img alt=user title=Image src="<?= $baseurl; ?>/images/shout_user1.jpg" height=50 width=50>
</div>
<ul class=user-info>
<li> <h5>Christina Martin</h5></li>
<li> <p>Daniell Thankyou for all your support with my BMR Questions</li>
</ul>
<div class=count><div class="high-five liked">
<input name=high-five value="High Five" type=submit></div>
<img alt=background src="<?= $baseurl; ?>/images/hand.png" height=26 width=78><p class=num>0</p>
<div class=comment_count>
<span> (<span class="c_count 3612">0</span>)<a href="javascript:void(0);"> Add Comment</a></span></div></div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!--</div>-->
<!--<div class=container>-->
<div class=row>
<div class="col-xs-12 col-sm-4 gratitude">
<div class=today_g>
<div class=today_gratitude>
<h1 class=heading>Leadership Corner</h1>
</div>
<div class=content>
<div class=toolbox-lc-left>
<div class=img_b>
<img src="<?= $baseurl; ?>/images/leadership.png" alt=leadership height=201 width=192>
</div>
</div>
<div class=toolbox-lc-right>
<ul>
<li><a href="#">Monday</a></li>
<li><a href="#">Wednesday</a></li>
<li><a href="#">Friday</a></li>
</ul>
</div>
<div class=submitleader>
<div class="checkbox checkbox1 core_value">
<div class=label1><input type=checkbox><label class=unchecked> </label>Read Now 10 Pts</div>
</div>

<span class="see-al"><a href="<?= $baseurl; ?>/teamwork/toolbox">See All <span><i class="fa fa-angle-right"></i></span></a></span>
</div>
</div>
</div>
</div>
<div class="col-sm-4 col-xs-12 toolbox">
<div class=today_g>
<div class=today_gratitude>
<h1 class=heading>Weekly Challenge</h1>
</div>
<div class=content>
<div class=tool>
<a href="#">
<img class=video src="<?= $baseurl; ?>/images/week.jpg" alt=week height=344 width=158>
</a>
</div>
<p class=culture>Everyday Leadership</p>
<div class=submitweek>
<div class="checkbox checkbox1 core_value">
<div class=label1><input type=checkbox><label class=unchecked> </label>Watch Now 40 pts</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-sm-4 col-xs-12 lightbox">
<div class=today_g>
<div class=today_gratitude>
<h1 class=heading>Share A Win</h1>
</div>
<div class=content>
<div class=slider>
<div id=myCarousel class="carousel slide" data-ride=carousel>
<div class="carousel-inner inner_s" role=listbox>
<div class="item c_slider active">
<div class=carousel-caption>
<div class=share-content>
<p>I have gained a different
understanding of leadership that
has allowed me to...</p>
</div>
<div class=share-user-data>
<img src="<?= $baseurl; ?>/images/shareawin.png" class=slider-userimage alt=slider height=63 width=63>
</div>
<div class=share-user-name>
Sam
</div>
</div>
</div>
<div class="item c_slider">
<div class=carousel-caption>
<div class=share-content>
<p>I have gained a different
understanding of leadership that
has allowed me to...</p>
</div>
<div class=share-user-data>
<img src="<?= $baseurl; ?>/images/shareawin.png" class=slider-userimage alt=slider height=63 width=63>
</div>
<div class=share-user-name>
Sam
</div>
</div>
</div>
</div>
<a class="left carousel-control" href="#myCarousel" role=button data-slide=prev>
<img src="<?= $baseurl; ?>/images/left.png" alt=left height=31 width=18>
</a>
<a class="right carousel-control" href="#myCarousel" role=button data-slide=next>
<img src="<?= $baseurl; ?>/images/right.png" alt=left height=31 width=18>
</a>
</div> </div>
<div class=align-center>
<div class=box3shareawin>
<div class="checkbox checkbox1 box3">
<div class=label1>
<input type=checkbox />
<label class=""> </label>Share a Win 10 Pts
</div>
</div>
</div>
<span class=see-al><a href="<?= $baseurl; ?>/teamwork/share-a-win">See All <span><i class="fa fa-angle-right"></i></span></a></span>
</div>
</div>
</div>
</div>
</div>
<!--</div>-->
</div>
</div>
