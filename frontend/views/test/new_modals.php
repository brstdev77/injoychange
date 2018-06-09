<?php

use yii\helpers\Html;
use yii\web\Request;
use yii\widgets\ActiveForm;
use yii\web\View;
use yii\helpers\Url;
use frontend\models\PilotFrontUser;
use backend\models\PilotCompanyCorevaluesname;
use backend\models\PilotCheckinYourselfData;

$baseurl = Yii::$app->request->baseurl;
?>
<!-- Daily Inspirations Modal-->
<?php if (isset($answer1_model)): ?>
    <div class="modal-body">
        <div style="text-align: center;" class="container-fluid"></div>
        <?php if ($tip_pos == 'first'): ?>
            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="http://injoyglobal.com/wp-content/uploads/2017/02/8.jpg">
                </div>
                <div class="audio_image1">
                    <img src="../images/correct.png">
                </div>
                <p class="question_username">Holly Bennett Etzell</p>
                <p class="user_hobby">Correct!  Holly did NOT mention sleeping.</p>
                <p class="hobby_description">Most people don't know I was very involved in the arts growing up...I was in choir, show choir, band, dance and theater in high school.</p>
                <!--div class="hobby_image">
                    <img src="/images/clea_chicken.png">
                </div-->
            </div>
        <?php endif; ?>
        <?php if ($tip_pos == 'second'): ?>
             <div class="weekly_audio">
                <div class="audio_image">
                    <img src="http://injoyglobal.com/wp-content/uploads/2017/02/rakesh.jpg">
                </div>
                <div class="audio_image1">
                    <img src="../images/incorrect.png">
                </div>
                <p class="question_username">Rakesh Sanghvi</p>
                <p class="user_hobby">Try Again! Rakesh was not a tennis star.</p>
                <p class="hobby_description">Most people do not know that I love travelling and visiting new places</p>
            </div>
        <?php endif; ?>
        <?php if ($tip_pos == 'third'): ?>
            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="/images/know_rajat.png">
                </div>
                <div class="audio_image1">
                    <img src="../images/incorrect.png">
                </div>
                <p class="question_username">Rajat Saini</p>
                <p class="user_hobby">Try Again! Rajat's favorite holiday is Christmas.</p>
                <p class="hobby_description">Ever since I was a kid, I have been super into Christmas. The holiday has always been my favorite time of the year for more reasons than just one. Christmas is by far the best holiday in terms of presents which is just one of the many reasons I love Christmas.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($tip_pos == 'first'): ?>
       <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <?php if (empty($answer_entry)): ?>
                <button class="sub-btn btn btn-warning save_answer" type="submit">Submit 20 pts</button>     
            <?php endif; ?>
            <div class="dummy-text" style='font-size:13px'>
                Note: <span style="font-weight:500">Congratulations! You got this question correct but if you haven't already, please check out the rest of the team's answers.</span>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($tip_pos == 'second'): ?>
       <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>      
        </div>
    <?php endif; ?>
    <?php if ($tip_pos == 'third'): ?>
        <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>      
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($answer2_model)): ?>
    <div class="modal-body">
        <div style="text-align: center;" class="container-fluid"></div>
        <?php if ($tip_pos == 'first'): ?>
            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="/uploads/1512029219_5a1fbc2342032.png">
                </div>
                <div class="audio_image1">
                    <img src="../images/incorrect.png">
                </div>
                <p class="question_username">Pradeep Sharma</p>
                <p class="user_hobby">Try Again! Pradeep did mention sleeping.</p>
                <p class="hobby_description">I love to sleep.</p>
                <!--div class="hobby_image">
                    <img src="/images/brady_apple.png">
                </div-->
            </div>
        <?php endif; ?>
        <?php if ($tip_pos == 'second'): ?>
            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="http://injoyglobal.com/wp-content/uploads/2017/02/jeff2.jpg">
                </div>
                <div class="audio_image1">
                    <img src="../images/correct.png">
                </div>
                <p class="question_username">Jeff Baietto</p>
                <p class="user_hobby">Correct! Most people don't know that Jeff was a tennis star.</p>
                <p class="hobby_description">I was the #1 ranked paddle tennis player in the United States (Division 3, lowest division : ) for a full 48 hours : )</p>
            </div>
        <?php endif; ?>
        <?php if ($tip_pos == 'third'): ?>

            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="/uploads/1512029219_5a1fbc2342032.png">
                </div>
                <div class="audio_image1">
                    <img src="../images/correct.png">
                </div>
                <p class="question_username">Pradeep Kumar</p>
                <p class="user_hobby">Correct! Pradeep's favorite holiday is NOT Christmas.</p>
                <p class="hobby_description">Diwali is one of the India's biggest festivals. The word 'Diwali' means rows of lighted lamps. It is a festival of lights. During this festival, people light up their houses.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($tip_pos == 'first'): ?>
        <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>      
        </div>
    <?php endif; ?>
    <?php if ($tip_pos == 'second'): ?>
        <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <?php if (empty($answer_entry)): ?>
                <button class="sub-btn btn btn-warning save_answer" type="submit">Submit 20 pts</button>     
            <?php endif; ?>
            <div class="dummy-text" style='font-size:13px'>
                Note: <span style="font-weight:500">Congratulations! You got this question correct but if you haven't already, please check out the rest of the team's answers.</span>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($tip_pos == 'third'): ?>
        <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <?php if (empty($answer_entry)): ?>
                <button class="sub-btn btn btn-warning save_answer" type="submit">Submit 20 pts</button>     
            <?php endif; ?>
            <div class="dummy-text" style='font-size:13px'>
                Note: <span style="font-weight:500">Congratulations! You got this question correct but if you haven't already, please check out the rest of the team's answers.</span>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($answer3_model)): ?>
    <div class="modal-body">
        <div style="text-align: center;" class="container-fluid"></div>
        <?php if ($tip_pos == 'first'): ?>
            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="/uploads/1509688959_59fc067f478f7.png">
                </div>
                <div class="audio_image1">
                    <img src="../images/incorrect.png">
                </div>
                <p class="question_username">Kunal Khullar</p>
                <p class="user_hobby">Try Again! Kunal did mention sleeping.</p>
                <p class="hobby_description">I love to sleep and I am very lazy.</p>
                <!--div class="hobby_image">
                    <img src="/images/varun_chicken.png">
                </div-->
            </div>
        <?php endif; ?>
        <?php if ($tip_pos == 'second'): ?>
            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="http://injoyglobal.com/wp-content/uploads/2017/02/6.jpg">
                </div>
                <div class="audio_image1">
                    <img src="../images/incorrect.png">
                </div>
                <p class="question_username">Elly Bannon</p>
                <p class="user_hobby">Try again! Elly Bannon was not a tennis star.</p>
                <p class="hobby_description">Most people don't know that I have an INSANE sense of smell. I can smell what you had for lunch, a flower from across the house, cookies that were baked a week ago and probably a ladybug fart.</p>
            </div>
        <?php endif; ?>
        <?php if ($tip_pos == 'third'): ?>

            <div class="weekly_audio">
                <div class="audio_image">
                    <img src="http://injoyglobal.com/wp-content/uploads/2017/02/linda2.jpg">
                </div>
                <div class="audio_image1">
                    <img src="../images/incorrect.png">
                </div>
                <p class="question_username">Linda LoRe</p>
                <p class="user_hobby">Try Again! Linda’s favorite holiday is Christmas.</p>
                <p class="hobby_description">Christmas is my favorite holiday! The infamous Cookie Party, the Family Gatherings (especially the funny gift exchange with my 10 siblings, mom, and dad) and all of the gatherings in between! We cannot forget all of the decorations... If you know, you KNOW!</p>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($tip_pos == 'first'): ?>
        <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>      
        </div>
    <?php endif; ?>
    <?php if ($tip_pos == 'second'): ?>
        <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>      
        </div>
    <?php endif; ?>
    <?php if ($tip_pos == 'third'): ?>
        <div class="modal-footer">
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>      
        </div>
    <?php endif; ?>
<?php endif; ?>