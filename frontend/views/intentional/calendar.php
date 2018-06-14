<?phpuse yii\helpers\Html;use yii\web\View;use yii\widgets\ActiveForm;use backend\models\PilotCreateGame;/* @var $this yii\web\View */$comp_id = Yii::$app->user->identity->company_id;$challenge_id = Yii::$app->user->identity->challenge_id;$game_obj = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $comp_id, 'status' => 1])->one();$text1 = $game_obj->banner_text_1;$text2 = strtolower($game_obj->banner_text_2);$contents = explode(' ', $text1);$content1 = strtolower(end($contents));$title = ucwords($content1.' '.$text2);$this->title = 'Calendar | '.$title;$baseurl = Yii::$app->request->baseurl;$events = '';$this->registerJsFile($baseUrl . "/js/custom.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);$this->registerJsFile($baseUrl . "/js/responsive-calendar.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);$this->registerCssFile($baseUrl . "/css/responsive-calendar.css", ['depends' => ['frontend\assets\AppAsset']]);$this->registerCssFile($baseUrl . "/css/style.css", ['depends' => ['frontend\assets\AppAsset']]);$this->registerJsFile($baseurl . "/js/scroll.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);//Points for Each Date of Calendar as per Game Challenge Start Date to Till Today//echo '<pre>';//print_r($pointsArr);//die;foreach ($pointsArr as $key => $value) {  if ($value == '0'):    $events .= '"' . $key . '": {' . '"number": "0"}, ';  elseif ($value == 'disabled'):    $events .= '"' . $key . '": {"class": "disabled"}, ';  elseif ($value == 'enabled'):    $events .= '"' . $key . '": {"class": "enabled"}, ';  else:    $events .= '"' . $key . '": {' . '"number": ' . $value . '}, ';  endif;}$this->registerJs('$(".responsive-calendar").responsiveCalendar({            addLeadingZero: true,            time: "' . date('Y-m') . '",            events: { ' . $events . ' },            onDayClick: function(events){                $("#my-modal").on("show.bs.modal", function (event) {                  var button = $(event.relatedTarget) // Button that triggered the modal                  var date = String(button.data("date"));                  var year = parseInt(button.data("year"));                  var month = parseInt(button.data("month"));                  var day = parseInt(button.data("day"));                  var fulldate = month+"/"+day+"/"+year;                  if(events[date]==undefined){                        alert("Record does not exists");                        document.location.href = window.location.href;                        return false;                    } else {                        var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];                        var a = new Date(fulldate);                        var dayName = weekday[a.getDay()];                        var monthNames = ["January", "February", "March", "April", "May", "June",                                            "July", "August", "September", "October", "November", "December"                                          ];                        var monthName = monthNames[a.getMonth()];                        var ordinal = getOrdinalNum(day);                        var html = dayName + "," + monthName + " " + day +"<sup>"+ordinal+"</sup>";                        $("#showDate").html(html);                                                //AJAX to Get the Check-In Section Data                        $.ajax({                            type  : "POST",                            cache : false,                            url   : "get-cal-record",                            data  : {                                "date" : date,                              },                            success : function(response) {                               $("#my-modal .modal-form").html(response);                            },                            error : function(response){                                document.location.href = window.location.href;                            }                        });                      }                });                },                onMonthChange : function(){                    var game_start_month = $("#game_start_month").val();                    var game_end_month = $("#game_end_month").val();                    var changed_month = parseInt(this.currentMonth) + 1;                    if(changed_month == game_start_month){                      $(".pull-left").hide();                    }else{                      $(".pull-left").show();                    }                    if(changed_month == game_end_month){                     $(".pull-right").hide();                    } else{                    $(".pull-right").show();                    }                }                });                                //Function to get Ordinals as per the date                function getOrdinalNum(n) {                   return (n > 0 ? ["th", "st", "nd", "rd"][(n > 3 && n < 21) || n % 10 > 3 ? 0 : n % 10] : "");                }                $("#my-modal").on("hide.bs.modal", function (event) {                 document.location.href = window.location.href;                });                               //Disable Calendar Check in Modal Button if Clicked to prevent double click              $(document).on("click", "#form-today_values .mdl-btn1", function (e) {                  var comment_val = $("#form-today_values textarea").val();                   var core_val = $("#form-today_values #new-user-email").val();                  if (comment_val != "" && core_val != "") {                      $(this).attr("disabled", "disabled");                      $(this).addClass("disable_btn");                      $("#form-today_values").submit();                  }              });                    ');$this->registerJs('    $(window).load(function () {                     $(".responsive-calendar .days .past").each(function (index,value) {                      if(!$(this).hasClass("active")){                       // $(this).addClass("disabled");                      }                  });                                    });    $(document).ready(function() {        $(document).on("copy paste cut", "#core_value_area", function (e) {            e.preventDefault(); //disable cut,copy,paste           });    });    ');?><div id="game-core" class="game-wrapper">    <input type="hidden" id="game_start_month" value=<?= $game_start_month ?> />    <input type="hidden" id="game_end_month" value=<?= $game_end_month ?> />    <div class="container">        <div class="row">            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                <div class="padding-0 responsive-calendar col-lg-12 col-md-12 col-sm-12 col-xs-12  ">                    <div class="padding-16 col-lg-12 col-md-12 col-sm-12 col-xs-12">                        <a href="/intentional/dashboard" class="btn btn-warning dashboard">&lt; Dashboard</a>                    </div>                    <div class="controls col-lg-12 col-md-12 col-sm-12 col-xs-12 ">                        <?php if ($game_month == 'differ'): ?>                          <a class="pull-left" data-go="prev" style="display: none;"><div class="btn btn-warning dashboard">Prev</div></a>                        <?php endif; ?>                        <h4 style="color:#184473;"><span data-head-month></span> <span data-head-year></span></h4>                        <?php if ($game_month == 'differ'): ?>                          <a class="pull-right" data-go="next"><div class="btn btn-warning dashboard">Next</div></a>                        <?php endif; ?>                    </div><hr/>                    <div class="day-headers padding-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">                        <div class="day header">Mon</div>                        <div class="day header">Tue</div>                        <div class="day header">Wed</div>                        <div class="day header">Thu</div>                        <div class="day header">Fri</div>                        <div class="day header">Sat</div>                        <div class="day header">Sun</div>                    </div>                    <div class="days padding-0 col-lg-12 col-md-12 col-sm-12 col-xs-12" data-group="days">                    </div>                </div>            </div>        </div>    </div></div><!-- Check In Modal HTML--><div class="modal fade" role="dialog" id="my-modal">    <div class="modal-dialog">        <div class="modal-content">            <div class="modal-header">                <button type="button" class="close" data-dismiss="modal"></button>                <h4 class="modal-title">Check-In With Yourself</h4>                <h5 id="showDate">                    <?= date('l, M j') ?>                    <sup><?= date('S') ?></sup>                </h5>            </div>            <div class="modal-form">                <div class="modal-ajax-loader">                      <img src="../images/ajax-loader.gif"/>                </div>            </div>        </div>    </div></div><?php $this->registerJsFile($baseurl . "/js/score.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]); ?><?php echo $this->render('prize_modal'); ?>