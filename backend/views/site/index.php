<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

//use kartik\date\DatePicker;
$this->title = 'Dashboard';
$this->registerJsFile(Yii::$app->homeUrl . 'js/dashboard.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.flot.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.flot.pie.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.flot.resize.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.flot.categories.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/chart.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>
<!--h1>Welcome <?php //echo Yii::$app->user->identity->username;                               ?></h1-->
<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-white" style="background:white;line-height:79px">
                    <img style="max-width:63px" src="/backend/web/img/uploads/1502176797.png">
                </span>

                <div class="info-box-content1">
                    <span class="info-box-text">
                        <div class="selected_game_dashboard">
                            <p class="company_name" id="80"><b>Injoy</b></p>
                            <input type="hidden" value="80" id="company_id"> 
                            <div style="float:right;cursor:pointer" class="dropdown_challenge"><i aria-hidden="true" class="fa fa-caret-down"></i></div>
                        </div> 
                    </span>
                </div>
                <!-- /.info-box-content -->
                <div id="display1" style="height: auto;">
                    <?php foreach ($company as $companies): ?>
                        <div align="left" class="display_box1" onclick="append_datas(this)">
                            <img class="logo_dashboard" src="/backend/web/img/uploads/<?= $companies->image ?>" alt="logo" />
                            <p class="lists_name" id="<?= $companies->id ?>"><b><?= $companies->company_name; ?></b></p>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12 xyz1">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">ONGOING CHALLENGES</span>
                    <div class="overlay" style="display:none">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <span class="info-box-number ongoing"></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12 xyz1">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-android-checkbox-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">UPCOMING CHALLENGES</span>
                    <div class="overlay" style="display:none">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <span class="info-box-number upcoming"></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12 xyz1">
            <div class="info-box">
                <span class="info-box-icon" style="background:#6B8363;"><i class="fa fa-user" style="color:white;"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">COMPLETED CHALLENGES</span>
                    <div class="overlay" style="display:none">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <span class="info-box-number completed"></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Bar chart -->
            <div class="box box-danger">
                <div class="box-header with-border">

                    <h3 class="box-title">Total Users</h3>
                    <div class="box-tools pull-right">
                        <!--span class="label label-danger">8 New Members</span-->
                        <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i></button>
                        <button data-widget="remove" class="btn btn-box-tool" type="button"><i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body">
                    <div id="bar-chart" style="height: 300px; padding: 0px; position: relative;"></div>
                </div>
                <!-- /.box-body-->

            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-green">
                <div class="inner" style="font-size: 42px;">
                    <img src="/backend/web/img/game/user_image.png" class="highfive1" style="margin-bottom: 3px;">
                    <p>TOTAL USERS</p>
                    <div class="overlay" style="display:none;font-size: 42px;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <h3 class="highfives">7890</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <img src="/backend/web/img/game/shareawin1.png" class="highfive1">
                    <p>ACTIONS</p>
                    <div class="overlay" style="display:none;font-size: 42px">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <h3 class="actions">4321</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-yellow">
                <div class="inner" style="font-size: 47px;">
                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                    <p>CHECK IN's</p>
                    <div class="overlay" style="display:none;font-size: 42px;">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <h3 class="shares">2230</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="small-box bg-red">
                <div class="inner">
                    <img src="/backend/web/img/game/shoutouts.png" class="highfive1">
                    <p>SHOUT OUTS</p>
                    <div class="overlay" style="display:none;font-size: 42px">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                    <h3 class="shout-outs">7890</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-bottom:20px">
            <div class="box box-info">
                <div class="box-header with-border">

                    <h3 class="box-title">Survey</h3>
                    <input type="hidden" name="selected_company" id="selected_company_dashboard"/>
                    <div class="check1 check2" style="margin:0">   
                        <select>
                            <option>Select Challenge</option>
                            <option>The Great Gatsby</option>  
                            <option>V for Vendetta</option>
                            <option>The Wolf of Wallstreet</option>
                            <option>Quantum of Solace</option>
                        </select>
                    </div>
                </div>
                <p class="static" rel="1" style="display:none"></p>
                <div class='no-survey' style="text-align: center;display:none">No Survey Selected for this game</div>
                <div class="survey-present">
                    <!--div class="col-md-12 col-sm-12 no-padding" style="background-color: #fff;"> 
                        <input type="hidden" name="selected_company" id="selected_company_dashboard"/>
                        <div class="check1 check2">   
                            <select>
                                <option>Select Challenge</option>
                                <option>The Great Gatsby</option>  
                                <option>V for Vendetta</option>
                                <option>The Wolf of Wallstreet</option>
                                <option>Quantum of Solace</option>
                            </select>
                        </div>
                    </div-->
                    <div class="col-sm-3 col-sm-3 no-padding future question22" style="height:134px">



                        <div class="pull-left cont col-md-6 col-sm-6">
                            1.What is the biggest benefit you've received from this challenge?     
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="overlay" style="display:none;font-size: 42px;margin:158px">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div id="donut-chart1" style="height: 160px;position:inherit;top:-18px"></div>  
                            <!--canvas id="pieChart1" style="height: 100px; position: inherit; padding: 0px;"></canvas-->
                            <p id="pie11" style="display:none">40</p>
                            <p id="pie21" style="display:none">40</p>
                        </div>
                        <div class="col-md-3 col-sm-3" style="margin:40px 0px;display:none">
                            <span class="reports_dashboard"><b>Filled - </b><p class="filled_question22" style="color:#f89422">40%</p></span>
                            <span class="reports_dashboard"><b>Not Filled - </b><p class="notfilled_question22" style="color:#6B8363">40%</p></span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-3 no-padding future question23" style="height:134px">


                        <div class="pull-left cont col-md-6 col-sm-6 ">
                            2.Would you like to do another challenge like this in future? 
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="overlay" style="display:none;font-size: 42px;margin:158px">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div id="donut-chart2" style="height: 160px;position:inherit;top:-18px"></div>
                            <!--canvas id="pieChart2" style="height: 100px; position: inherit; padding: 0px;"></canvas-->
                            <p id="pie12" style="display:none">70</p>
                            <p id="pie22" style="display:none"></p>
                            <p id="pie32" style="display:none">20</p>
                            <p id="pie42" style="display:none">20</p>
                            <p id="pie52" style="display:none">20</p>
                        </div>
                        <div class="col-md-3 col-sm-3" style="display:none">
                            <span class="reports_dashboard"><b>Agree - </b><p class="agree23"style="color:#f89422">70%</p></span>
                            <span class="reports_dashboard"><b>Somewhat Agree - </b><p class="somewhatagree23" style="color:#6B8363">-</p></span>
                            <span class="reports_dashboard"><b>Neutral - </b><p class="neutral23" style="color:#D2D7DD">20%</p></span>
                            <span class="reports_dashboard"><b>Somewhat Disagree - </b><p class="somewhatdisagree23" style="color:#0073B7">20%</p></span>
                            <span class="reports_dashboard"><b>Disagree - </b><p class="disagree23" style="color:#00C0EF">20%</p></span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-3 no-padding future question24" style="height:134px">


                        <div class="pull-left cont col-md-6 col-sm-6">
                            3.This Challenge increased your effectiveness at work. 
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="overlay" style="display:none;font-size: 42px;margin:158px">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div id="donut-chart3" style="height: 160px;position:inherit;top:-18px"></div>
                            <!--canvas id="pieChart3" style="height: 100px; position: inherit; padding: 0px;"></canvas-->
                            <p id="pie13" style="display:none">40</p>
                            <p id="pie23" style="display:none">40</p>
                            <p id="pie33" style="display:none">20</p>
                            <p id="pie43" style="display:none">20</p>
                            <p id="pie53" style="display:none">20</p>
                        </div>
                        <div class="col-md-3 col-sm-3" style="display:none">
                            <span class="reports_dashboard"><b>Agree - </b><p class="agree24"style="color:#f89422">70%</p></span>
                            <span class="reports_dashboard"><b>Somewhat Agree - </b><p class="somewhatagree24" style="color:#6B8363">-</p></span>
                            <span class="reports_dashboard"><b>Neutral - </b><p class="neutral24" style="color:#D2D7DD">20%</p></span>
                            <span class="reports_dashboard"><b>Somewhat Disagree - </b><p class="somewhatdisagree24" style="color:#0073B7">20%</p></span>
                            <span class="reports_dashboard"><b>Disagree - </b><p class="disagree24" style="color:#00C0EF">20%</p></span>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-3 no-padding future question25" style="height:134px">


                        <div class="pull-left cont col-md-6 col-sm-6">
                            4.Did this challenge help reinforce your learnings?
                        </div>

                        <div class="col-md-6 col-sm-6">      
                            <div class="overlay" style="display:none;font-size: 42px;margin:158px">
                                <i class="fa fa-refresh fa-spin"></i>
                            </div>
                            <div id="donut-chart4" style="height: 160px;position:inherit;top:-18px"></div>
                            <!--canvas id="pieChart4" style="height: 100px; position: inherit; padding: 0px;"></canvas-->
                            <p id="pie14" style="display:none">0</p>
                            <p id="pie24" style="display:none">0</p>
                            <p id="pie34" style="display:none">100</p>
                        </div>
                        <div class="col-md-3 col-sm-3" style="margin:40px 0px;display:none">
                            <span class="reports_dashboard"><b>Filled - </b><p class="filled_question25" style="color:#f89422">40%</p></span>
                            <span class="reports_dashboard"><b>Not Filled - </b><p class="notfilled_question25" style="color:#6B8363">40%</p></span>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 no-padding" style="background-color: #fff;"> 
                        <div class="check1">   <div class="align"> <div style="background-color:#f89422;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px" class="red"></div><span class="reporttext">Agree</span></div>
                            <div class="align"> <div style="background-color:#6B8363;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px" class="red"></div><span class="reporttext">Somewhat Agree</span></div>
                            <div class="align"> <div style="background-color:#D2D7DD;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px" class="red"></div><span class="reporttext">Neutral</span></div>
                            <div class="align"> <div style="background-color:#0073B7;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px" class="red"></div><span class="reporttext">Somewhat Disagree</span></div>
                            <div class="align"> <div style="background-color:#00C0EF;width:11px;height: 13px;float: left; margin:4px 5px 4px 5px" class="red"></div><span class="reporttext">Disagree</span></div>
                        </div>
                    </div>
                </div>
                <p class="staticlast" rel="4" style="display:none"></p>

            </div>
        </div>
    </div>
    <div class="row">
        <!--div class="col-md-4">
            < DIRECT CHAT>
            <div class="box box-warning direct-chat direct-chat-warning" style="/*height: 380px;*/">
                <div class="box-header with-border">
                    <h3 class="box-title">Direct Chat</h3>

                    <div class="box-tools pull-right">
                        <span class="badge bg-yellow" title="" data-toggle="tooltip" data-original-title="3 New Messages">3</span>
                        <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i>
                        </button>
                        <button data-widget="chat-pane-toggle" title="" data-toggle="tooltip" class="btn btn-box-tool" type="button" data-original-title="Contacts">
                            <i class="fa fa-comments"></i></button>
                        <button data-widget="remove" class="btn btn-box-tool" type="button"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <box-header>
                <div class="box-body dashboardbody">
                    <!-- Conversations are loaded here >
                    <div class="direct-chat-messages">


                    </div>
                    < /.direct-chat-pane>
                </div>
                <!-- /.box-body -->
                <!--div class="box-footer">
                    <form method="post" action="#">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type Message ..." name="message">
                            <span class="input-group-btn">
                                <button class="btn btn-warning btn-flat" type="button">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
                < /.box-foote>
            </div>
            <!--/.direct-chat>
        </div-->
        <div class="col-md-4">
            <div class="box box-info" style="/*height: 380px;*/">
                <div class="box-header with-border">
                    <h3 class="box-title">Total Users</h3>

                    <div class="box-tools pull-right">
                        <!--span class="label label-danger">8 New Members</span-->
                        <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i></button>
                        <button data-widget="remove" class="btn btn-box-tool" type="button"><i class="fa fa-times"></i></button>
                    </div>
                </div>

                <div class="box-body no-padding dashboardbody">
                    <ul class="users-list clearfix dashboard-table"></ul>
                    <!--tr>
                        <th>Rank</th>
                        <th>Profile Pic</th>
                        <th>Name</th>
                        <th>Points</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/599e1cb94f0fb.jpg" alt=""></div></td>
                        <td><p style="margin-top:10px;">Nancy Bannon</p></td>
                        <td><p style="margin-top:10px;color:#E17167;"><b>5840 Pts</b></p></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/1505189931_59b7602b3a080.jpg" alt=""></div></td>
                        <td><p style="margin-top:10px;">Holly Bennett Etzell</p></td>
                        <td><p style="margin-top:10px;color:#E17167"><b>5480 Pts</b></p></td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/59a65e9e66a8a.png" alt=""></div></td>
                        <td><p style="margin-top:10px;">Linda LoRe</p></td>
                        <td><p style="margin-top:10px;color:#E17167"><b>4580 Pts</b></p></td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/599ef7e599761.jpg" alt=""></div></td>
                        <td><p style="margin-top:10px;">Simona Bot</p></td>
                        <td><p style="margin-top:10px;color:#E17167"><b>4380 Pts</b></p></td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/599efaf9ca7de.jpg" alt=""></div></td>
                        <td><p style="margin-top:10px;">Phil Dixon</p></td>
                        <td><p style="margin-top:10px;color:#E17167"><b>3565 Pts</b></p></td>
                    </tr-->
                </div>
                <!-- /.box-body-->

            </div>
        </div>
        <div class="col-md-4">
            <!--div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">User Percentage</h3>
                </div>
                <div class="box-body no-padding">
            <!--tr>
                <th>Rank</th>
                <th>Profile Pic</th>
                <th>Name</th>
                <th>Points</th>
            </tr>
            <tr>
                <td>1</td>
                <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/599e1cb94f0fb.jpg" alt=""></div></td>
                <td><p style="margin-top:10px;">Nancy Bannon</p></td>
                <td><p style="margin-top:10px;color:#E17167;"><b>5840 Pts</b></p></td>
            </tr>
            <tr>
                <td>2</td>
                <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/1505189931_59b7602b3a080.jpg" alt=""></div></td>
                <td><p style="margin-top:10px;">Holly Bennett Etzell</p></td>
                <td><p style="margin-top:10px;color:#E17167"><b>5480 Pts</b></p></td>
            </tr>
            <tr>
                <td>3</td>
                <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/59a65e9e66a8a.png" alt=""></div></td>
                <td><p style="margin-top:10px;">Linda LoRe</p></td>
                <td><p style="margin-top:10px;color:#E17167"><b>4580 Pts</b></p></td>
            </tr>
            <tr>
                <td>4</td>
                <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/599ef7e599761.jpg" alt=""></div></td>
                <td><p style="margin-top:10px;">Simona Bot</p></td>
                <td><p style="margin-top:10px;color:#E17167"><b>4380 Pts</b></p></td>
            </tr>
            <tr>
                <td>5</td>
                <td><div class="image-wrapper"><img width="100" src="/pilot/frontend/web/uploads/599efaf9ca7de.jpg" alt=""></div></td>
                <td><p style="margin-top:10px;">Phil Dixon</p></td>
                <td><p style="margin-top:10px;color:#E17167"><b>3565 Pts</b></p></td>
            </tr>
</div>
</div-->
            <div class="box box-default" style="/*height: 380px;*/">
                <div class="box-header with-border">
                    <h3 class="box-title">User Participation</h3>

                    <div class="box-tools pull-right">
                        <button data-widget="collapse" class="btn btn-box-tool" type="button"><i class="fa fa-minus"></i>
                        </button>
                        <button data-widget="remove" class="btn btn-box-tool" type="button"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding dashboardbody">
                    <div class="col-md-9 no-padding chart-responsive">
                        <canvas id="pieChart" style="height:400px;width:300px;" ></canvas>
                    </div>
                    <div class="col-md-3 no-padding">
                        <ul class="chart-legend clearfix">
                            <li><i class="fa fa-circle-o text-red"></i> 20%</li>
                            <li><i class="fa fa-circle-o text-light-blue"></i> 40%</li>
                            <li><i class="fa fa-circle-o text-yellow"></i> 60%</li>
                            <li><i class="fa fa-circle-o text-aqua"></i> 80%</li>
                            <li><i class="fa fa-circle-o text-green"></i> 100%</li>
                        </ul>
                    </div>
                </div>
                <!--div class="box-footer no-padding">
                    <ul class="nav nav-pills nav-stacked percentage">
                        <li><a href="#">United States of America
                                <span class="pull-right text-red"> 12%</span></a></li>
                        <li><a href="#">India <span class="pull-right text-green"> 4%</span></a>
                        </li>
                        <li><a href="#">China
                                <span class="pull-right text-yellow"> 0%</span></a></li>
                    </ul>
                </div-->
                <!-- /.box-body -->
                <!--div class="box-footer no-padding">
                  <ul class="nav nav-pills nav-stacked">
                    <li><a href="#">United States of America
                      <span class="pull-right text-red"><i class="fa fa-angle-down"></i> 12%</span></a></li>
                    <li><a href="#">India <span class="pull-right text-green"><i class="fa fa-angle-up"></i> 4%</span></a>
                    </li>
                    <li><a href="#">China
                      <span class="pull-right text-yellow"><i class="fa fa-angle-left"></i> 0%</span></a></li>
                  </ul>
                </div-->
                <!-- /.footer -->
            </div>
        </div>
    </div>
</section>
<style>
    #pieChart1,#pieChart2,#pieChart3,#pieChart4 {
        height:100px;
        width:300px;
    }
    .cont
    {
        font-size:15px;
    }
    .future{
        background-color:#fff;
        border:none;
        margin-bottom: 0;
    }
    .check1{
        float:left;
    }
</style>