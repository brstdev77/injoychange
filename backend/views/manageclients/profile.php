<?php

use yii\helpers\html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;
use kartik\file\FileInput;

$this->title = 'Profile';
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-warning">
            <h3>Thomson Reuters</h3>
            <hr>
            <div><i class="fa fa-calendar"></i>&nbsp;&nbsp;Start Date<div class="pull-right">25 May Thu,2017</div></div>
            <hr>
            <div><i class="fa fa-calendar"></i>&nbsp;&nbsp;End Date<div class="pull-right">25 May Thu,2017</div></div>
            <hr>
            <div><i class="fa fa-users"></i>&nbsp;&nbsp;Team<div class="pull-right">Team A,Team B</div></div>
            <hr>
            <div>
                <div><i class="fa fa-envelope" aria-hidden="true"></i>
                    &nbsp;&nbsp;
                    Include sms Reminder</div>
                <div><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;&nbsp;
                    Sms High hive Notification</div>
                <div><i class="fa fa-envelope-square" aria-hidden="true"></i>&nbsp;&nbsp;
                    Email High hive Notification</div>
            </div>
            <hr>
            <div><i class="fa fa-calendar"></i>&nbsp;&nbsp;Winner Posted Date
                <div class="pull-right">26 April Tue,2017</div>
            </div>
            <hr>
            <div><i class="fa fa-calendar"></i>&nbsp;&nbsp;Survey Date
                <div class="pull-right">25 May Thu,2017</div>
            </div>
            <hr>
            <div><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;&nbsp;

                Reports 
                <div class="pull-right"><div>First email-holly@injoyglobal</div>
                    <div>Second email-Clea@injoyglobal</div>
                </div>
            </div>
        </div>
        <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title">Top 7 Members</h3>
            </div>
            <div class="box-body no-padding">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <th>Rank</th>
                            <th>Profile Pic & Name</th>
                            <th>Points</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><img class="member_img" src="<?php echo Yii::$app->homeUrl ?>img/user1-128x128.jpg">Mechelle Sims</td>
                            <td>9620</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td><img class="member_img" src="<?php echo Yii::$app->homeUrl ?>img/user1-128x128.jpg">Mechelle Sims</td>
                            <td>9620</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td><img class="member_img" src="<?php echo Yii::$app->homeUrl ?>img/user1-128x128.jpg">Mechelle Sims</td>
                            <td>9620</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td><img class="member_img" src="<?php echo Yii::$app->homeUrl ?>img/user1-128x128.jpg">Mechelle Sims</td>
                            <td>9620</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td><img class="member_img" src="<?php echo Yii::$app->homeUrl ?>img/user1-128x128.jpg">Mechelle Sims</td>
                            <td>9620</td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td><img class="member_img" src="<?php echo Yii::$app->homeUrl ?>img/user1-128x128.jpg">Mechelle Sims</td>
                            <td>9620</td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td><img class="member_img" src="<?php echo Yii::$app->homeUrl ?>img/user1-128x128.jpg">Mechelle Sims</td>
                            <td>9620</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="digital_high"><span class="color_white"><span class="font_size">1020</span> Digital High Five</span>
            <div class="pull-right icon_width"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            </div>
        </div>
        <div class="share_win"><span class="color_white"><span class="font_size">620</span>  Share a Win</span>
            <div class="pull-right icon_width"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            </div>
        </div>
        <div class="weekly_chall"><span class="color_white"><span class="font_size">480</span>  Weekly Challenge</span>
            <div class="pull-right icon_width"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>
            </div>
        </div>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Reports</h3>
            </div>
            <div class="box-body no-padding">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <th>Date</th>
                            <th>Week</th>
                            <th>Download</th>
                        </tr>
                        <tr>
                            <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;26 April Tue,2017</td>
                            <td>1st Week</td>
                            <td><a href="#" class="btn btn-default custom_btn"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;Download</a></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;26 April Tue,2017</td>
                            <td>2nd Week</td>
                            <td><a href="#" class="btn btn-default custom_btn"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;Download</a></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;26 April Tue,2017</td>
                            <td>3rd Week</td>
                            <td><a href="#" class="btn btn-default custom_btn"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;Download</a></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-calendar"></i>&nbsp;&nbsp;26 April Tue,2017</td>
                            <td>4th Week</td>
                            <td><a href="#" class="btn btn-default custom_btn"><i aria-hidden="true" class="fa fa-file-excel-o"></i>&nbsp;Download</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box box-info survey">
            <div class="box-header with-border">
                <h3 class="box-title">Survey</h3>
            </div>
            <div class="future">
                <div class="pull-left cont">
                    Would you like to do another challenge like this in future?
                    <div class="check">   <div> <div class="red" style="background-color:#EE3B24;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Agree</div>
                        <div> <div class="red" style="background-color:#FF9C00;width:19px;height: 16px;float: left; margin-right: 5px;"></div>No</div>
                        <div> <div class="red" style="background-color:#45BFF2;width:19px;height: 16px;float: left; margin-right: 5px;"></div>May be</div>
                    </div> 
                </div>
                <div class="pull-right bar">

                    <div class="sparkline">
                        13,15,16,0

                    </div> 
                </div>
            </div>
            <div class="personal">
                <div class="pull-left cont">
                    This culture challenge increased your effectiveness personally?
                    <div class="check">
                        <div> <div class="red" style="background-color:#EE3B24;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Agree</div>
                        <div> <div class="red" style="background-color:#FF9C00;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Somewhat agree</div>
                        <div> <div class="red" style="background-color:#45BFF2;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Neutral</div>


                    </div>
                    <div class="inner_check">
                        <div> <div class="red" style="background-color:#13B89A;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Somewhat Disagree</div>
                        <div> <div class="red" style="background-color:#9D9D9D;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Disagree</div>
                    </div>
                </div>
                <div class="pull-right bar">

                    <div class="sparkline">
                        16,15,13,10,8,0

                    </div> 
                </div>
            </div>
            <div class="work">
                <div class="pull-left cont">This culture challenge increased your effectiveness at work? 
                    <div class="check">
                        <div> <div class="red" style="background-color:#EE3B24;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Agree</div>
                        <div> <div class="red" style="background-color:#FF9C00;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Somewhat agree</div>
                        <div> <div class="red" style="background-color:#45BFF2;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Neutral</div>


                    </div>
                    <div class="inner_check">
                        <div> <div class="red" style="background-color:#13B89A;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Somewhat Disagree</div>
                        <div> <div class="red" style="background-color:#9D9D9D;width:19px;height: 16px;float: left; margin-right: 5px;"></div>Disagree</div>
                    </div>
                </div>
                <div class="pull-right bar">

                    <div class="sparkline">
                        16,15,13,10,8,0

                    </div> 
                </div>
            </div>


        </div>
    </div>
</div>

