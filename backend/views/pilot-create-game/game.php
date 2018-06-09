<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\ActiveForm;
use backend\models\Company;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PilotWeeklyCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->registerCssFile(Yii::$app->homeUrl . 'css/game.css');
$this->registerJsFile(Yii::$app->homeUrl . 'js/game.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile(Yii::$app->homeUrl . 'js/jquery.cropit.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);

$this->title = 'Manage Challenge';
$this->params['breadcrumbs'][] = ['label' => 'Pilot Manage Challenges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php
$form = ActiveForm::begin([
            'id' => 'manage-game',])
?>
<div class="manage-game">
    <div class="box box-warning getstarted">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">1) Get Started </h3>
        </div>
        <div class="box-body body-getstarted">
            <div class="col-md-3" style="padding-top: 15px;font-size:16px">
                What kind of Challenge would you like to create?
            </div>
            <div class="col-md-9">
                <?=
                $form->field($model, 'getstarted')->radioList([
                    'express' => 'Express',
                    'custom' => 'Custom',
                ])->label(false);
                ?>
                <div class="col-md-8 express" style="display:none">
                    <?php
                    $challenge_ids = array();
                    $challenge = backend\models\PilotGameChallengeName::find()->all();
                    foreach ($challenge as $challenges):
                        $challenge_ids[] = $challenges->category_id;
                    endforeach;
                    $challenge_string = implode(',', $challenge_ids);
                    $companyname2 = ArrayHelper::map(backend\models\Categories::find()->orderBy('Category_name', 'DESC')->all(), 'id', 'Category_name');
                    $categoryexpreess = array_map('ucfirst', $companyname2);
                    ?>
                    <?=
                    $form->field($model, 'categoryexpreess', [
                        'inputTemplate' => '<div class="input-group">{input}<i class ="fa fa-refresh fa-spin myloader"></i ></div>'
                    ])->dropDownList(
                            $categoryexpreess, ['prompt' => 'Select Category', 'style' => 'width:200px;']
                    )->label('Category');
                    ?>
                    <div id="challenge_string" rel="<?= $challenge_string; ?>"></div>
                </div>
                <div class="col-md-8 custom" style="display:none">
                    <?php
                    $challenge_ids = array();
                    $challenge = backend\models\PilotGameChallengeName::find()->all();
                    foreach ($challenge as $challenges):
                        $challenge_ids[] = $challenges->client_id;
                    endforeach;
                    $challenge_string = implode(',', $challenge_ids);
                    $companyname2 = ArrayHelper::map(backend\models\Company::find()->where(['id' => $challenge_ids])->orderBy('company_name', 'DESC')->all(), 'id', 'company_name');
                    $companynamecustom = array_map('ucfirst', $companyname2);
                    ?>
                    <?=
                    $form->field($model, 'companynamecustom', [
                        'inputTemplate' => '<div class="input-group">{input}<i class ="fa fa-refresh fa-spin myloader"></i ></div>'
                    ])->dropDownList(
                            $companynamecustom, ['prompt' => 'Select Company Name', 'style' => 'width:200px;']
                    )->label('Company Name');
                    ?>
                    <div id="challenge_string" rel="<?= $challenge_string; ?>"></div>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'get-started-select']) ?>
            </div>
        </div>
    </div>
    <div class="box box-warning challenge gamechallenge">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">2) Select Your Challenge </h3>
        </div>
        <div class="box-body body-challenge">
            <div class="col-md-4" style="padding-top: 15px;font-size:16px">
                Select the look & feel of your Challenge.
            </div>
            <div class="col-md-8 selected_custom">

                <div class="selected_game2" style="display:none"><div class="overlay"><i class="fa fa-refresh fa-spin"></i> </div></div>
                <?=
                $form->field($model, 'challenge_id')->radioList(ArrayHelper::map(backend\models\PilotGameChallengeName::find()->where(['client_id' => 0])->all(), 'id', 'challenge_name'), ['disabled' => true])->label(false);
                ?>
                <?php
                $challenge = backend\models\PilotGameChallengeName::find()->where(['client_id' => 0, 'category_id' => 0])->all();
                foreach ($challenge as $challenges):
                    $html .= '<div class="selected_game"><div class="my-show"><i class="fa fa-check"></i><span class="selected_shadow_text">Selected</span><span class="selected_shadow"> </span></div><img  rel="' . $challenges->id . '" src="' . Yii::$app->homeUrl . 'img/game/' . $challenges->challenge_image . '"></div>';
                endforeach;
                echo $html;
                ?>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'game-challenge-select']) ?>
            </div>
        </div>

    </div>

    <div class="box box-success challenge bannerchange">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">3) Change Your Challenge Banner Design </h3>
        </div>
        <div class="box-body body-banner">
            <div class="col-md-12">
                <div class="col-md-3" style="padding-top: 15px;font-size:16px;">
                    Customize the challenge banner image. You can upload your own banner image or edit the text on the predesigned banner.
                    <div><a href="<?= Yii::$app->request->baseurl; ?>/image/sampleimage.jpg" download style="text-decoration:underline">Download Demo Image</a>
                    </div>
                </div>
                <div class="col-md-3" style="padding-top: 15px;">
                    <input type='text' name="banner_text_1" class="form-control name" id='name1' value='' placeholder="First line text" maxlength="26" style="margin-bottom:10px">
                    <input type='text' name="banner_text_2" id='name2' class='form-control name' value='' placeholder="Second line text" maxlength="26" style="margin-bottom:10px">
                    <input type="hidden" name="banner_image" id="banner_image">
                    <input type="hidden" name="thankyou_image" id="thankyou_image">
                    <hr style="border:none">
                    <!--input type="file" name="banner_image1" id="file_image"--> 
                </div>
                <div class="col-md-6">
                    <canvas id="myCanvas" width="1180" height="390"></canvas>
                    <canvas id="mycanvas1" width='1180' height='390' style="display:none"></canvas>
                    <canvas id="mycanvas2" width='1180' height='390' style="display:none"></canvas>
                    <div class="delete_icon"><span id="delete_image" style="cursor:pointer"><i class="fa fa-trash-o" aria-hidden="true" style="padding:0px 6px;color:#f00;"></i></span></div>
                </div>
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <?= $form->field($model, 'banner_image1')->fileInput(['multiple' => false])->label('Upload Banner Image');
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'game-banner-select']) ?>
            </div>
        </div>

    </div>

    <div class="box box-info challenge start_date">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title"> 4) Challenge Start Date </h3>
        </div>

        <div class="box-body body-startdate">
            <div class="col-md-3" style="padding-top: 15px;font-size:16px;">
                Select the Challenge Start Date, End Date, and Registration Date. Note: Registration date is usually set on the Monday before the Challenge starts.
            </div>
            <div class="col-md-9">
                <div class="col-md-6 ">
                    <?=
                    $form->field($model, 'challenge_start_date', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                    ])->textInput(['id' => 'challengedate', 'style' => 'width:300px'])->label('Challenge Start Date' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?=
                    $form->field($model, 'challenge_registration_date', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                    ])->textInput(['id' => 'challengeregistration', 'style' => 'width:300px'])->label('Challenge Registration Date' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                </div>
                <div class="col-md-6 ">
                    <?=
                    $form->field($model, 'challenge_end_date', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                    ])->textInput(['style' => 'width:300px'])->label('Challenge End Date' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"class='count_date'></p>
                    <p class='count_date_extra'></p>
                    <div class='hide-makeup' style="display:none;">
                        <?=
                        $form->field($model, 'makeup_days', [
                            'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                        ])->textInput(['style' => 'width:300px'])->label('Makeup Days' . Html::tag('span', '*', ['class' => 'required']));
                        ?>
                    </div>
                    <p class='makupdate_info'></p>
                </div>
            </div>   
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'start-date-select']) ?>
            </div>
        </div>
    </div>
    <div class="box box-danger challenge select_company">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus" ></i>
            <h3 class="box-title">5) Challenge Company Name </h3>
        </div>

        <div class="box-body body-companyname">
            <div class="col-md-3" style="padding-top: 15px;font-size:16px;">
                Select the Company Name from the drop-down.
                Note: if your company does not appear in the Drop Down, please add it in the <q>Add a company</q> section.
            </div>
            <div class="col-md-9">
                <div class="col-md-12 ">
                    <?php
                    $companyname = ArrayHelper::map(backend\models\Company::find()->orderBy('company_name', 'DESC')->all(), 'id', 'company_name');
                    $companynamearray = array_map('ucfirst', $companyname);
                    ?>
                    <?=
                    $form->field($model, 'challenge_company_id', [
                        'inputTemplate' => '<div class="input-group">{input}<i class ="fa fa-refresh fa-spin myloader"></i ></div>'
                    ])->dropDownList(
                            $companynamearray, ['prompt' => 'Select Company Name', 'style' => 'width:540px;']
                    )->label('Challenge Company Name' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?php
                    if ($model->challenge_teams)
                        $model->challenge_teams = explode(",", $model->challenge_teams);
                    ?>
                    <?=
                    $form->field($model, 'challenge_teams')->checkboxList([
                        '1' => 'Team A',
                        '2' => 'Team B',
                        '3' => 'Team C',
                        '4' => 'Team D',
                            ], ['style' => 'display:none'])->label('Select Teams (Optional)', ['style' => 'display:none']);
                    ?>

                </div>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'company-name-select']) ?>
            </div>
        </div>
    </div>

    <div class="box box-warning challenge content_assignment">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">6)Select Challenge Content </h3>
        </div>
        <div class="box-body body-content">
            <div class="col-md-12">
                <div class="col-md-6">
                    <?php
                    $dailyinspiration = backend\models\PilotDailyinspirationCategory::find()->all();
                    foreach ($dailyinspiration as $category) {
                        $dailyimages = count(backend\models\PilotDailyinspirationImage::find()->where(['category_id' => $category->id])->all());
                        $dailyarray[$category->id] = $category->category_name . ' (' . $dailyimages . ' images' . ')';
                    }
                    ?>
                    <?=
                    $form->field($model, 'daily_inspiration_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="daily_inspiration_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $dailyarray, ['prompt' => 'Select Daily Inspiration', 'style' => 'width:361px;']
                    )->label('Daily Inspiration Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="dailydaysrequired"></p>

                    <?php
                    $weeklychallenge = backend\models\PilotWeeklyCategory::find()->all();
                    foreach ($weeklychallenge as $category) {
                        $weeklyvideo = count(backend\models\PilotWeeklyChallenge::find()->where(['category_id' => $category])->all());
                        $weeklyarray[$category->id] = $category->category_name . ' (' . $weeklyvideo . ' video' . ')';
                    }
                    ?>
                    <?=
                    $form->field($model, 'weekly_challenge_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="weekly_challenge_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $weeklyarray, ['prompt' => 'Select Weekly Challenge', 'style' => 'width:361px;']
                    )->label('Weekly Challenge Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="weeklyvideorequired"></p>

                    <?php
                    $checkdata = backend\models\PilotCheckinYourselfCategory::find()->all();

                    foreach ($checkdata as $category) {
                        $checkdatacount = count(backend\models\PilotCheckinYourselfData::find()->where(['category_id' => $category->id])->all());
                        $checkinarray[$category->id] = $category->category_name . ' (' . $checkdatacount . ' Checkin Values' . ')';
                    }
                    ?>
                    <?=
                    $form->field($model, 'checkin_yourself_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="checkin_value_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $checkinarray, ['prompt' => 'Select Checkin Yourself', 'style' => 'width:361px;']
                    )->label('Checkin Yourself Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="chickinrequired"></p>

                    <?php
                    $how_it_data = array();
                    $howitworkdata = backend\models\PilotHowItWork::find()->all();
                    foreach ($howitworkdata as $how) {
                        $how_it_data[$how->id] = $how->category_name;
                    }
                    ?>
                    <?=
                    $form->field($model, 'howitwork_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="how_it_work_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $how_it_data, ['prompt' => 'Select How It Work Contant', 'style' => 'width:361px;']
                    )->label('How It Work Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="howitworkrequired"></p>

                    <?php
                    $gettoknow = backend\models\PilotGettoknowCategory::find()->all();
                    $gettoknowcategorydat = array();
                    foreach ($gettoknow as $data) {
                        $leadersipcorner = count(backend\models\PilotGettoknowCorner::find()->where(['category_id' => $data->id])->all());
                        $gettoknowcategorydat[$data->id] = $data->category_name . ' (' . $leadersipcorner . ' corners' . ')';
                        ;
                    }
                    ?>
                    <?=
                    $form->field($model, 'get_to_know_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="know_value_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $gettoknowcategorydat, ['prompt' => 'Select Get to Know Content', 'style' => 'width:361px;']
                    )->label('Get To know Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="gettoknowrequired"></p>

                    <?php
                    $voicematters = backend\models\PilotActionmattersCategory::find()->all();
                    $voicematterscategorydat = array();
                    foreach ($voicematters as $data) {
                        $leadersipcorner = count(backend\models\PilotActionmattersChallenge::find()->where(['category_id' => $data->id])->all());
                        $voicematterscategorydat[$data->id] = $data->category_name . ' (' . $leadersipcorner . ' Questions' . ')';
                    }
                    ?>
                    <?=
                    $form->field($model, 'voicematters_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="voice_value_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $voicematterscategorydat, ['prompt' => 'Select Voice Matters Content', 'style' => 'width:361px;']
                    )->label('Voice Matters Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="voicemattersrequired"></p>

                </div>
                <div class="col-md-6">
                    <?php
                    $modal = backend\models\PilotLeadershipCategory::find()->all();
                    foreach ($modal as $val) {
                        $leadersipcorner = count(backend\models\PilotLeadershipCorner::find()->where(['category_id' => $val->id])->all());
                        $leadershiparray[$val->id] = $val->category_name . ' (' . $leadersipcorner . ' corner' . ')';
                    }
                    ?>
                    <?=
                    $form->field($model, 'leadership_corner_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="leadership_corner_change" href="">View Content</a></div>'
                    ])->dropDownList($leadershiparray, ['prompt' => 'Select Leadership Corner', 'style' => 'width:361px;'])->label('Leadership Corner Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="leadershipcornerrequired"></p>
                    <?php
                    $modal = backend\models\PilotTodayslessonCategory::find()->all();
                    foreach ($modal as $val) {
                        $lessoncorner = count(backend\models\PilotTodayslessonCorner::find()->where(['category_id' => $val->id])->all());
                        $lessonarray[$val->id] = $val->category_name . ' (' . $lessoncorner . ' corner' . ')';
                    }
                    ?>
                    <?=
                    $form->field($model, 'todays_lesson_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="lesson_corner_change" href="">View Content</a></div>'
                    ])->dropDownList($lessonarray, ['prompt' => 'Select Lesson Corner', 'style' => 'width:361px;'])->label("Today's Lesson Content" . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="lessoncornerrequired"></p>
                    <?php
                    $modal = backend\models\PilotCorevalues::find()->all();
                    foreach ($modal as $val) {
                        $company = backend\models\Company::find()->where(['id' => $val->company_id])->one();
                        $values = count(backend\models\PilotCompanyCorevaluesname::find()->where(['company_id' => $val->company_id])->all());
                        // $Companyid[] = $val->client_listing;
                        $corevaluearray[$val->company_id] = $company->company_name . ' (' . $values . ' core values' . ')';
                    }
                    ?>
                    <?=
                    $form->field($model, 'core_value_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="core_value_change" href="">View Content</a></div>'
                    ])->dropDownList($corevaluearray, ['prompt' => 'Select Core Value', 'style' => 'width:361px;'])->label('Core Value Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="corevaluerequired"></p>

                    <?php
                    $pricedata = backend\models\PilotPrizesCategory::find()->all();
                    $pricecategorydat = array();
                    foreach ($pricedata as $data) {
                        $pricecategorydat[$data->id] = $data->category_name;
                    }
                    ?>
                    <?=
                    $form->field($model, 'prize_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="prize_value_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $pricecategorydat, ['prompt' => 'Select Prize Content', 'style' => 'width:361px;']
                    )->label('Prize Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="prizerequired"></p>

                    <?php
                    $didyouknow = backend\models\PilotDidyouknowCategory::find()->all();
                    $didyouknowcategorydat = array();
                    foreach ($didyouknow as $data) {
                        $leadersipcorner = count(backend\models\PilotDidyouknowCorner::find()->where(['category_id' => $data->id])->all());
                        $didyouknowcategorydat[$data->id] = $data->category_name . ' (' . $leadersipcorner . ' corner' . ')';
                        ;
                    }
                    ?>
                    <?=
                    $form->field($model, 'did_you_know_content', [
                        'inputTemplate' => '<div class="input-group">{input}<a style="margin-left:10px;display:none;float:left;margin-top:6px;" target="_blank" id="did_value_change" href="">View Content</a></div>'
                    ])->dropDownList(
                            $didyouknowcategorydat, ['prompt' => 'Select Did You Know Content', 'style' => 'width:361px;']
                    )->label('Did You know Content' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <p style="color:#dd4b39;"id="didyourequired"></p>
                </div>
                <div class="col-md-12 no-padding">
                    <div class="col-md-6">
                        <?= $form->field($model, 'welcome_msg')->textarea(['rows' => 5, 'maxlength' => true])->label('Welcome Message' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'thankyou_msg')->textarea(['rows' => 5, 'maxlength' => true])->label('Thankyou Message' . Html::tag('span', '*', ['class' => 'required'])); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'content-select']) ?>
            </div>
        </div>

    </div>

    <div class="box box-success challenge text_management">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">7) Header Text </h3>
        </div>
        <div class="box-body body-text">
            <div class="col-md-4" style="padding-top: 15px;">
                <img src="/backend/web/img/game/highfiveheading.png" style="max-width: 100%;">
                <div class="col-md-12 no-padding">
                    <?= $form->field($model, 'highfive_heading')->textInput(['maxlength' => true, 'value' => "SHOUT OUTS & DIGITAL HIGH 5's"])->label('ShoutOut Heading' . Html::tag('span', '*', ['class' => 'required'])); ?>
                </div>
            </div>
            <div class="col-md-4" style="padding-top: 15px;">
                <img src="/backend/web/img/game/placeholder.jpg" style="max-width: 100%;">
                <div class="col-md-12 no-padding">
                    <?= $form->field($model, 'highfive_placeholder')->textInput(['maxlength' => true, 'value' => 'Share an appreciation for a team member'])->label('ShoutOut Placeholder' . Html::tag('span', '*', ['class' => 'required'])); ?>
                </div>
            </div>
            <div class="col-md-4" style="padding-top: 15px;">
                <img src="/backend/web/img/game/scorecard.png" style="max-width: 100%;">
                <div class="col-md-12 no-padding">
                    <?= $form->field($model, 'scorecard_bottom')->textInput(['maxlength' => true, 'value' => 'Total Actions'])->label('Scorecard Text' . Html::tag('span', '*', ['class' => 'required'])); ?>
                </div>
            </div>

            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'text-select']) ?>
            </div>
        </div>

    </div>

    <div class="box box-danger challenge select_corevalue">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus" ></i>
            <h3 class="box-title">8) Challenge Values Section </h3>
        </div>

        <div class="box-body body-corevalue">
            <div class="col-md-3" style="padding-top: 15px;font-size:16px;">
                Here you can customize what will appear in the Values section on the Dashboard. You can edit the header text and change the image that appears in the circle.
            </div>
            <div class="col-md-9">
                <div class="col-md-12 ">
                    <div class="core-preview">
                        <p class='core-heading'>Core Value</p>
                        <div class="image-editor">
                            <input type="file" class="cropit-image-input">
                            <div class="cropit-preview"></div>
                            <div class="image-size-label">
                                Resize image
                            </div>
                            <input type="range" class="cropit-image-zoom-input">
                            <div class="btn btn-default export">Save</div>
                        </div>
                        <div class="submitcore">
                            <div class="checkbox checkbox1 core_value">
                                <div class="label1"><input type="checkbox">
                                    <label class="unchecked"> </label>
                                    <span>Submit 5 Pts</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='core-value-setup'>
                        <?=
                        $form->field($model, 'core_heading', [
                            'inputTemplate' => '<div class="input-group">{input}</div>'
                        ])->textInput(['id' => 'core_headding', 'style' => 'width:300px'])->label('Set Core Heading');
                        ?>
                    </div>
                    <div class='update-cpre-img'>
                        <div class="selected_game1"><div class="my-show1"><i class="fa fa-check"></i><span class="selected_shadow_text1">Selected</span><span class="selected_shadow1"> </span></div><img alt="test" src="/backend/web/img/game/core_value1.jpg"></div>
                        <div class="selected_game1"><div class="my-show1"><i class="fa fa-check"></i><span class="selected_shadow_text1">Selected</span><span class="selected_shadow1"> </span></div><img alt="test" src="/backend/web/img/game/index.png"></div>
                        <div class="selected_game1"><div class="my-show1"><i class="fa fa-check"></i><span class="selected_shadow_text1">Selected</span><span class="selected_shadow1"> </span></div><img alt="test" src="/backend/web/img/game/Core-Value2.png"></div>
                        <div class="selected_game1"><div class="my-show1 active"><i class="fa fa-check"></i><span class="selected_shadow_text1">Selected</span><span class="selected_shadow1"> </span></div><img alt="test" src="/backend/web/img/game/core_value/core.png"></div>
                        <input type="hidden" name="core_image" id="core_image">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'core-select']) ?>
            </div>
        </div>
    </div>

    <div class="box box-success challenge features">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">9) Features</h3>
        </div>

        <div class="box-body body-features">
            <div class="col-md-3" style="padding-top: 15px;font-size:16px;">
                Select the Features that you would like to include in this Challenge.
            </div>
            <div class="col-md-9">
                <div class="col-md-12 ">
                    <?php
                    $a = backend\models\PilotCreateGameFeatures::find()->all();
                    foreach ($a as $id)
                        $c[$id->id] = "<i class=' $id->font_awesome_class'></i>" . $id->name;
                    ?>
                    <?php
                    if ($model->features)
                        $model->features = explode(",", $model->features);
                    ?>
                    <?=
                    $form->field($model, 'features')->checkboxList($c)->label('Features' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <div class="col-md-offset-6 col-md-4 form-group s11" style="display:none">
                        <label class="control-label checked"> Toggle Button Heading</label>
                        <div class="input-group" style="width: 100%"><input type="text" aria-invalid="true" id="button_text" class="form-control" name="button_text" aria-required="true" value="5S in action"></div>
                        <p style="display: none;" class="help-block help-block-error"></p>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'features-select']) ?>
            </div>
        </div>
    </div>
    <div class="box box-default challenge survey">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">10) Survey </h3>
        </div>

        <div class="box-body body-survey">
            <div class="col-md-3" style="padding-top: 15px;font-size:16px;">
                Create a Challenge Pulse Survey. Note: The survey date usually one week before the Challenge end date.
            </div>
            <div class="col-md-9">

                <div class="form-group col-md-12">

                    <h4>Is a survey needed in this Challenge?</h4>
                    <?=
                    $form->field($model, 'survey')->radioList([
                        '1' => 'Yes',
                        '0' => 'No',
                    ])->label(false);
                    ?>
                    <? //= $form->field($model, 'survey')->checkbox(['class' => 'survey-check form-group'])->label(false); ?>
                    <?=
                    $form->field($model, 'challenge_survey_date', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-calendar"></i></div>{input}</div>'
                    ])->textInput(['id' => 'challengesurveydate', 'style' => 'width:300px;']);
                    ?>
                    <div class='display-on-check-survey' style='display:none;'>                      
                        <?php $a = ArrayHelper::map(backend\models\PilotSurveyQuestion::find()->orderBy(['created' => SORT_ASC])->all(), "id", "question"); ?>
                        <?php
                        if ($model->survey_questions)
                            $model->survey_questions = explode(",", $model->survey_questions);
                        ?>
                        <?=
                        $form->field($model, 'survey_questions')->checkboxList(
                                $a
                        )->label(false);
                        ?>




                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'survey-select']) ?>
            </div>
        </div>
    </div>

    <div class="box box-info challenge reports">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">11) Send Reports To </h3>
        </div>

        <div class="box-body body-reports">
            <div class="col-md-3" style="padding-top: 15px;font-size:16px;">
                Select who you would like the reports for this Challenge sent to.
            </div>
            <div class="col-md-9">
                <div class="col-md-6">
                    <h4>Company Manager</h4>
                    <?=
                    $form->field($model, 'executive_email_1', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                    ])->textInput(['class' => array('report form-control')])->label('Email 1' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?=
                    $form->field($model, 'executive_email_2', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                    ])->textInput();
                    ?>
                    <?=
                    $form->field($model, 'executive_email_3', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                    ])->textInput();
                    ?>
                </div>
                <div class="col-md-6">
                    <h4>Inhouse Manager</h4>
                    <?=
                    $form->field($model, 'inhouse_email_1', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                    ])->textInput()->label('Email 1' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                    <?=
                    $form->field($model, 'inhouse_email_2', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                    ])->textInput();
                    ?>
                    <?=
                    $form->field($model, 'inhouse_email_3', [
                        'inputTemplate' => '<div class="input-group"><div class="input-group-addon"><i class="fa fa-envelope"></i></div>{input}</div>'
                    ])->textInput();
                    ?>
                </div>
            </div>
            <div class="col-md-12">
                <?= Html::a('<img class="rotate" src="/backend/web/img/game/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'reports-select']) ?>
            </div>
        </div>
    </div>
    <div class="box box-primary challenge game_challenge">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">12) Bottom Left Corner Element </h3>
        </div>

        <div class="box-body body-leadershipcoach">
            <?=
            $form->field($model, 'corners')->radioList([
                '1' => 'Leadership Corner',
                '2' => 'Coach Corner',
                '3' => 'Toolbox'
            ])->label(false);
            ?>
            <div class="col-md-12">
                <div class="col-md-2" style="padding:0px;">
                    <p style="font-size:16px;"> Select which element you would like to include in the bottom left corner (Leadership Corner, Coach Corner or Toolbox.</p>
                </div>
                <div class="col-md-3">
                    <?=
                    $form->field($model, 'left_corner_heading', [
                        'inputTemplate' => '<div class="input-group">{input}</div>'
                    ])->textInput(['style' => 'width:300px', 'value' => 'Leadership Corner'])->label('Set Left Corner Heading');
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'left_corner_type')->radioList(array(1 => 'First,Second,Third', 0 => '1 , 2 , 3'))->label('Set Left Corner Type' . Html::tag('span', '*', ['class' => 'required'])); ?>
                </div>
            </div>
            <div class="col-md-2">
                <img style="height:200px; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/game/IMG_16062017_165058_0 2.png"> 
            </div>
            <div class="col-md-6">
                <div class="col-md-4" id="leadership">
                    <div class="parent_shadow"> 
                        <div class="content-leadership"><i class="fa fa-check"></i><span class="leadership_shadow_text">Selected</span><span class="leadership_shadow"> </span></div> 
                        <img style="width:100%; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/1.jpg"> 
                    </div>
                </div>        
                <!--div class="col-md-4" id="coach">
                    <div class="parent_shadow">
                        <div class="content-coach"><i class="fa fa-check"></i><span class="coach_shadow_text">Selected</span><span class="coach_shadow"> </span></div>
                        <img style="width:100%; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/6.jpg"> 
                    </div>
                </div>
                <div class="col-md-4" id="toolbox">
                    <div class="parent_shadow">
                        <div class="content-toolbox"><i class="fa fa-check"></i><span class="toolbox_shadow_text">Selected</span><span class="toolbox_shadow"> </span></div>
                        <img style="width:100%; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/5.jpg"> 
                    </div>
                </div-->
            </div>
            <!--div class="col-md-6">
                    <div class="col-md-4" id="share">
                        <div class="parent_shadow">
                         <div class="content-share"><i class="fa fa-check"></i><span class="share_shadow_text">Selected</span><span class="share_shadow"> </span></div> 
                       <img style="width:100%; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/2.jpg"> 
                   </div>
                   </div>
                    <div class="col-md-4"id="stress">
                        <div class="parent_shadow">
                         <div class="content-stress"><i class="fa fa-check"></i><span class="stress_shadow_text">Selected</span><span class="stress_shadow"> </span></div> 
                       <img style="width:100%; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/4.jpg"> 
                   </div>
                   </div>
                    <div class="col-md-4" id="share_win">
                        <div class="parent_shadow">
                         <div class="content-share_win"><i class="fa fa-check"></i><span class="share_win_shadow_text">Selected</span><span class="share_win_shadow"> </span></div> 
                       <img style="width:100%; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/2.jpg"> 
                   </div>
                   </div>
               </div-->
            <div class="col-md-12">
                <?= Html::a('<img src="/backend/web/image/next.png">', null, ['href' => 'javascript:void(0);', 'class' => 'pull-right', 'id' => 'leadership-coach-select']) ?>
            </div>
        </div>
    </div>
    <div class="box box-success challenge game_challenge_corner">
        <div class="box-header with-border" data-widget="collapse">
            <i class="fa pull-right fa-minus"></i>
            <h3 class="box-title">13) Bottom Right Corner Element </h3>
        </div>

        <div class="box-body body-shareawin">
            <?=
            $form->field($model, 'right_corners')->radioList([
                '1' => 'share',
                '2' => 'stress',
                '3' => 'share a win'
            ])->label(false);
            ?>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="col-md-4" style="padding:0px;">
                        <p style="font-size:16px;"> Select which element you would like to include in the bottom Right corner (Sharea a win ,Stress).</p>
                    </div>
                    <div class="col-md-6">
                        <?=
                        $form->field($model, 'right_corner_heading', [
                            'inputTemplate' => '<div class="input-group">{input}</div>'
                        ])->textInput(['style' => 'width:300px', 'value' => 'Share a Win'])->label('Set Right Corner Heading');
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <img style="height:200px; border: 3px solid #cccc;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/7.png"> 
            </div>
            <div class="col-md-6">
                <div class="col-md-4" id="share">
                    <div class="parent_shadow">
                        <div class="content-share"><i class="fa fa-check"></i><span class="share_shadow_text">Selected</span><span class="share_shadow"> </span></div> 
                        <img style="width:100%; border: 3px solid #cccc;height:206px;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/2.jpg"> 
                    </div>
                </div>
                <div class="col-md-4"id="stress">
                    <div class="parent_shadow">
                        <div class="content-stress"><i class="fa fa-check"></i><span class="stress_shadow_text">Selected</span><span class="stress_shadow"> </span></div> 
                        <img style="width:100%; border: 3px solid #cccc;height:206px;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/image/Screen Shot 2018-04-25 at 5.13.03 PM.png"> 
                    </div>
                </div>
                <div class="col-md-4" id="share_win">
                    <div class="parent_shadow">
                        <div class="content-share_win"><i class="fa fa-check"></i><span class="share_win_shadow_text">Selected</span><span class="share_win_shadow"> </span></div> 
                        <img style="width:100%; border: 3px solid #cccc;height:206px;"alt="Injoy-Green-3-Teamwork Challenge - B" src="/backend/web/img/share3.png"> 
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="form-group action-save">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success', 'id' => 'submit-hit', 'style' => 'display:none;']) ?>
        <span class="cancel_btn" style="margin-left: 16px;">
            <?= Html::a('Preview', null, ['href' => 'javascript:void(0);', 'class' => 'btn btn-primary game-preview']) ?>
        </span>
        <span class="cancel_btn">
            <?= Html::a('Cancel', ['index'], ['class' => 'btn btn-default']) ?>
        </span>
    </div>
    <?php ActiveForm::end(); ?>

</div>


<!--bootstrap model start here  -->

<div class="container">
    <div class="modal fade" id="preview" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Summary</h4>
                </div>
                <div style="background-color: #ECEFF4;"class="modal-body">
                    <div class="row">
                        <div id="game-img-src" class="col-md-6">
                            <img style ="margin-bottom:7px; width: 100%; margin-right: 10px;" src="">
                            <br>
                            <a id ="gameid" style="font-weight: bold;color:#000000;font-size:15px" href="" target="_blank"></a>
                        </div>
                        <div class="col-md-6">
                            <h4 id ="game-name" style="font-weight: bold; margin-top: 0;">30 Day Core Values challenge</h4>
                            <p id="company-name-preview">Thomson Reuters</p>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #ccc; margin:0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Team</h4>
                            <div id="selected-team"></div>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #ccc; margin:0px;">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 style="color:#45C0EC">Start Date</h4>
                            <p  style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="start-date"></span></p>
                            <h4 style="color:#45C0EC">Survey Date</h4>
                            <p  style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="survey-date-preview">June 25 wed,2017</span></p>
                        </div>
                        <div class="col-md-6">
                            <h4 style="color:#45C0EC">Registration Start From</h4>
                            <p style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="registration-date"></span></p>
                            <h4 style="color:#45C0EC">End Date</h4>
                            <p style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-calendar"></i><span id="end-date"></span></p>
                        </div>
                        <div class="col-md-12 makupdays game-makeup-days"></div>
                    </div>


                    <hr style="border-bottom: 1px solid #ccc;margin:0px;">
                    <div class="row">
                        <h4 style="color:#11B89A;padding-left:15px;">Content</h4>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p> <b>Daily Inspiration Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="daily"></span><a target="_blank" id="daily_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                            <hr style="border-bottom: 1px solid #ccc; margin:0px;"> 
                        </div>
                        <div class="col-md-12 videocontent">
                            <div class="row">
                                <div class="col-md-6">
                                    <p> <b>Weekly Challenge Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="weekly"></span><a target="_blank" id="weekly_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                            <hr style="border-bottom: 1px solid #ccc; margin:0px;"> 
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 leadershipcontent">
                                    <p><b>Leadership Corner Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="corner"></span><a target="_blank" id="corner_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                            <hr style="border-bottom: 1px solid #ccc; margin:0px;"> 
                        </div>
                        <div class="col-md-12 lessoncontent">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Today's Lesson Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="lesson"></span><a target="_blank" id="lesson_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                            <hr style="border-bottom: 1px solid #ccc; margin:0px;"> 
                        </div>
                        <div class="col-md-12 corecontent">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Core Value Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="core"></span><a target="_blank" id="core_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 checkin">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Checkin Yourself Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="checkin"></span><a target="_blank" id="checkin_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>How It Work Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="howit"></span><a target="_blank" id="howit_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Prize Content</b></p> 
                                </div>
                                <div class="col-md-6">
                                    <p><span id="prize"></span><a target="_blank" id="prize_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 didyou">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Did You Know Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="didyouknow"></span><a target="_blank" id="did_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 knowteam">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Know the Team Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="gettoknow"></span><a target="_blank" id="know_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 voicematters">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><b>Voice Matters Content</b></p>
                                </div>
                                <div class="col-md-6">
                                    <p><span id="voicematters"></span><a target="_blank" id="voice_href" style="padding-left:5px" href="">View Content</a></p>
                                </div>
                            </div>
                        </div>
                        <!--div class="col-md-6">
                            <p><span id="daily"></span><a target="_blank" id="daily_href" style="padding-left:5px" href="">View Content</a></p>
                            <p><span id="weekly"></span><a target="_blank" id="weekly_href" style="padding-left:5px" href="">View Content</a></p>
                            <p><span id="corner"></span><a target="_blank" id="corner_href" style="padding-left:5px" href="">View Content</a></p>
                            <p><span id="core"></span><a target="_blank" id="core_href" style="padding-left:5px" href="">View Content</a></p>
                        </div-->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Features</h4>
                            <div  id="features">
                                <p style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-envelope"></i>Include sms Reminder</p>
                                <p style="font-weight: bold;font-size: 14px;"><i style="margin-right:5px;" class="fa fa-envelope"></i>Sms high hive Notification  </p>
                            </div>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #ccc;margin:0px;">
                    <div class="row">
                        <div class="col-md-6" id="survey"></div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Survey</h4>
                            <div  id="survey-questions"></div>
                        </div>
                    </div>
                    <hr style="border-bottom: 1px solid #ccc;margin:0px;">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="color:#11B89A">Reports</h4>
                            <div id="reports"></div>
                        </div>
                    </div>


                </div>
                <div class="modal-footer" style="text-align: center;background-color: #ECEFF4;border-top:1px solid #ccc; ">

                    <!-- <button id="get-started" type="button" class="btn btn-info" data-dismiss="modal">Get Started</button>-->
                    <button data-toggle = 'modal' data-target = '#reminder_on_creategame' id="get-started" type="button" class="btn btn-info" data-dismiss="modal">Get Started</button>
                </div>

            </div>
        </div>
    </div>
</div>


<!--Reminder popup model show on above modl click-->
<div class="container">
    <div class="modal fade" id="reminder_on_creategame" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content"  style="width:100%;float:left;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Email Reminders</h4>
                </div>
                <div class="modal-body" style="width:100%;float:left;">
                    <div class="modal-contant">
                        <div class='row'>
                            <table class="table table-striped table-bordered" style='margin-bottom: 0px;'>
                                <tr><td><ul><li><span id="sevendayreminder_reminder"></span> the game start reminder</li></ul></td></tr>
                                <tr><td><ul><li><span id="fivedayreminder_reminder"></span> the game content ready on reminder </li></ul></td></tr>
                                <tr><td><ul><li><span id="threedayreminder_reminder"></span> the game will start in three days</li></ul></td></tr>
                                <tr><td><ul><li><span id="startdate_reminder"></span> the game start date reminder</li></ul></td></tr>
                                <tr><td><ul><li><span id="surveydate_reminder"></span> the survey live on reminder</li></ul></td></tr>
                                <tr><td><ul><li><span id="enddate_reminder"></span> the game end date reminder</li></ul></td></tr>
                                <tr><td></td></tr>   
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="width:100%;float:left;text-align: center;">
                    <button  type="button" class="btn btn-info game_save_reminder" data-dismiss="modal">Proceed</button>
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                </div>

            </div>
        </div>
    </div>
</div>
<style>
    #myCanvas
    {
        width:355px;
        height:120px;
    }
    .selected_game2 {
        float: left;
        margin-bottom: 2%;
        margin-right: 2%;
        position: relative;
        width: 14%;
        min-height:222px;
    }
</style>

