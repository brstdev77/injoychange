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
        <div class="weekly_audio">
            <div class="audio_image">
                <?php if (!empty($gettoknow_obj1->first_user_profile)): ?>
                    <img src="<?= Yii::getAlias('@back_end') . '/img/knowtheteam/' . $gettoknow_obj1->first_user_profile; ?>">
                <?php else: ?>
                    <img src="<?= Yii::getAlias('@back_end') . '/img/knowtheteam/user_icon.png'; ?>">
                <?php endif; ?>
            </div>
            <div class="audio_image1">
                <?php if ($gettoknow_obj1->first_user_answer == 0): ?>
                    <img src="../images/incorrect.png">
                <?php else: ?>
                    <img src="../images/correct.png">
                <?php endif; ?>
            </div>
            <p class="question_username"><?= $gettoknow_obj1->first_user; ?></p>
            <p class="user_hobby"><?= $gettoknow_obj1->first_user_description; ?>.</p>
            <!--p class="hobby_description">I love diwali festival and always wait for this holiday. Because it is festival of lights, people do home decoration, shopping and gifts for each other. People all get together, wear new clothes and cook delicious dishes which spreads happiness among people.</p-->
        </div>
    </div>
    <div class="modal-footer">
        <?php if ($gettoknow_obj1->first_user_answer == 1): ?>
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <?php if (empty($answer_entry)): ?>
                <button class="sub-btn btn btn-warning save_answer" type="submit">Submit 20 pts</button>     
            <?php endif; ?>
            <div class="dummy-text" style='font-size:13px'>
                Note: <span style="font-weight:500">Congratulations! You got this question correct but if you haven't already, please check out the rest of the team's answers.</span>
            </div>
        <?php else: ?>
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>  
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (isset($answer2_model)): ?>
    <div class="modal-body">
        <div style="text-align: center;" class="container-fluid"></div>
        <div class="weekly_audio">
            <div class="audio_image">
                <?php if (!empty($gettoknow_obj2->first_user_profile)): ?>
                    <img src="<?= Yii::getAlias('@back_end') . '/img/knowtheteam/' . $gettoknow_obj2->second_user_profile; ?>">
                <?php else: ?>
                    <img src="<?= Yii::getAlias('@back_end') . '/img/knowtheteam/user_icon.png'; ?>">
                <?php endif; ?>
            </div>
            <div class="audio_image1">
                <?php if ($gettoknow_obj2->second_user_answer == 0): ?>
                    <img src="../images/incorrect.png">
                <?php else: ?>
                    <img src="../images/correct.png">
                <?php endif; ?>
            </div>
            <p class="question_username"><?= $gettoknow_obj2->second_user; ?></p>
            <p class="user_hobby"><?= $gettoknow_obj2->second_user_description; ?>.</p>
            <!--p class="hobby_description">I love diwali festival and always wait for this holiday. Because it is festival of lights, people do home decoration, shopping and gifts for each other. People all get together, wear new clothes and cook delicious dishes which spreads happiness among people.</p-->
        </div>
    </div>
    <div class="modal-footer">
        <?php if ($gettoknow_obj2->second_user_answer == 1): ?>
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <?php if (empty($answer_entry)): ?>
                <button class="sub-btn btn btn-warning save_answer" type="submit">Submit 20 pts</button>     
            <?php endif; ?>
            <div class="dummy-text" style='font-size:13px'>
                Note: <span style="font-weight:500">Congratulations! You got this question correct but if you haven't already, please check out the rest of the team's answers.</span>
            </div>
        <?php else: ?>
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>  
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if (isset($answer3_model)): ?>
    <div class="modal-body">
        <div style="text-align: center;" class="container-fluid"></div>
        <div class="weekly_audio">
            <div class="audio_image">
                <?php if (!empty($gettoknow_obj3->first_user_profile)): ?>
                    <img src="<?= Yii::getAlias('@back_end') . '/img/knowtheteam/' . $gettoknow_obj3->third_user_profile; ?>">
                <?php else: ?>
                    <img src="<?= Yii::getAlias('@back_end') . '/img/knowtheteam/user_icon.png'; ?>">
                <?php endif; ?>
            </div>
            <div class="audio_image1">
                <?php if ($gettoknow_obj3->third_user_answer == 0): ?>
                    <img src="../images/incorrect.png">
                <?php else: ?>
                    <img src="../images/correct.png">
                <?php endif; ?>
            </div>
            <p class="question_username"><?= $gettoknow_obj3->third_user; ?></p>
            <p class="user_hobby"><?= $gettoknow_obj3->third_user_description; ?></p>
            <!--p class="hobby_description">I love diwali festival and always wait for this holiday. Because it is festival of lights, people do home decoration, shopping and gifts for each other. People all get together, wear new clothes and cook delicious dishes which spreads happiness among people.</p-->
        </div>
    </div>
    <div class="modal-footer">
        <?php if ($gettoknow_obj3->third_user_answer == 1): ?>
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <?php if (empty($answer_entry)): ?>
                <button class="sub-btn btn btn-warning save_answer" type="submit">Submit 20 pts</button>     
            <?php endif; ?>
            <div class="dummy-text" style='font-size:13px'>
                Note: <span style="font-weight:500">Congratulations! You got this question correct but if you haven't already, please check out the rest of the team's answers.</span>
            </div>
        <?php else: ?>
            <input type='hidden' name='tip_pos' id='tip_pos' value='<?= $tip_pos; ?>' />
            <button class="sub-btn btn btn-warning" type="button" data-dismiss="modal">Try Again</button>  
        <?php endif; ?>
    </div>
<?php endif; ?>