<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use budyaga\cropper\Widget;
use kartik\depdrop\DepDrop;
use backend\models\PilotGameChallengeName;

$actual_link = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$explodedUrl = explode('/', $actual_link);
$challenge_name = $explodedUrl[1];
if($challenge_name == 'aboveandbeyond'):
    $challenge_name = 'leads';
endif;
if($challenge_name == 'customer'):
    $class = 'customer_button';
endif;
if($challenge_name == 'peak'):
    $class = 'peak_button';
endif;
if($challenge_name == 'intentional' || $challenge_name == 'intentionalleadership'):
    $class = 'intentional_button';
endif;
$challenge = PilotGameChallengeName::find()->where(['challenge_abbr_name' => $challenge_name])->one();
$challenge_id = $challenge->id;
if($challenge_id == 6):
    $color='#cc1c1c';
endif;
$this->registerJsFile('https://rawgit.com/jseidelin/exif-js/master/exif.js', ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);

$this->title = 'Signup';
$baseurl = Yii::$app->request->baseurl;
$show_notis_reminder = 'false';
if (in_array('Email Reminder', $features) && in_array('SMS Notification', $features)):
    $show_notis_reminder = 'true';
    $notif_methods = ['Email' => 'Send as Emails', 'SMS/Text Message' => 'Send as SMS/Text Messages'];
elseif (in_array('Email Reminder', $features) && !in_array('SMS Notification', $features)):
    $show_notis_reminder = 'true';
    $notif_methods = ['Email' => 'Send as Emails'];
elseif (in_array('SMS Notification', $features) && !in_array('Email Reminder', $features)):
    $show_notis_reminder = 'true';
    $notif_methods = ['SMS/Text Message' => 'Send as SMS/Text Messages'];
endif;
$notif_frequency_shoutout = ['Daily' => 'Daily (7 days/week)', 'Weekly (Friday)' => 'Weekly (Friday)', 'Monday/Wednesday/Friday' => 'Monday/Wednesday/Friday'];
$notif_frequency_checkin = ['Daily' => 'Daily (7 days/week)', 'Weekly (Monday)' => 'Weekly (Monday)', 'Monday/Wednesday/Friday' => 'Monday/Wednesday/Friday'];
?>
<?php $this->registerCssFile($baseurl . "/css/above.css", ['position' => yii\web\View::POS_READY, 'depends' => ['yii\bootstrap\BootstrapAsset']]); ?>
<?php $this->registerCssFile("http://root.injoychange.com/vendor/jackocnr/intl-tel-input/build/css/intlTelInput.css", ['position' => yii\web\View::POS_READY, 'depends' => ['yii\bootstrap\BootstrapAsset']]); ?>
<?php
$this->registerJsFile("http://root.injoychange.com/vendor/jackocnr/intl-tel-input/build/js/intlTelInput.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
$this->registerJsFile($baseurl . "/js/custom_signup.js", ['position' => yii\web\View::POS_END, 'depends' => ['yii\web\JqueryAsset']]);
?>

<div class="site-signup">
    <div class="row">
        <div class="col-lg-12">
            <?php
            $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data'],
                        'id' => 'form-signup',
                        'enableAjaxValidation' => true,
            ]);
            ?>
            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true])->label('First Name' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true])->label('Last Name' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?= $form->field($model, 'emailaddress')->textInput(['maxlength' => true])->label('Email Address' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?= $form->field($model, 'password_hash')->passwordInput(['maxlength' => true])->label('Password' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true])->label('Confirm Password' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?//= $form->field($model, 'gender', ['options' => ['class' => 'gender_signup']])->radioList(['male' => 'Male', 'female' => 'Female'])->label('Gender' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?//= $form->field($model, 'height')->textInput(['maxlength' => true])->label('Height (Inches)' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?//= $form->field($model, 'weight')->textInput(['maxlength' => true])->label('Weight (lbs)' . Html::tag('span', '*', ['class' => 'required'])) ?>

            <?php if (isset($compData)) : ?>
                <!--Normal parent select-->
                <?= $form->field($model, 'company_id')->dropDownList($compData, ['prompt' => 'Please Select', 'id' => 'user-company'])->label('Company' . Html::tag('span', '*', ['class' => 'required'])); ?>
                <!--Dependent Dropdown-->
                <?=
                $form->field($model, 'team_id')->label('Team' . Html::tag('span', '*', ['class' => 'required']))->widget(DepDrop::classname(), [
                    'options' => ['id' => 'user-team'],
                    'pluginOptions' => [
                        'depends' => ['user-company'],
                        'placeholder' => 'Please Select',
                        'url' => Url::to(['/site/company-teams'])
                    ]
                ]);
                ?>
            <?php endif; ?>
            <?php if (isset($teamsData)): ?>

                <?= $form->field($model, 'company_id', ['inputOptions' => ['value' => $company_id], 'options' => ['class' => 'hide']])->hiddenInput()->label(false); ?>
                 <?php if(!empty($teamsData)): ?>
                    <?= $form->field($model, 'team_id')->dropDownList($teamsData, ['prompt' => 'Please Select', 'id' => 'user-team'])->label('Team' . Html::tag('span', '*', ['class' => 'required'])); ?>
                <?php endif; ?>

            <?php endif; ?>
            <?php
            $company = backend\models\Company::find()->where(['company_name' => $_SESSION['company_name']])->one();
            $challenge = backend\models\PilotGameChallengeName::find()->where(['challenge_abbr_name' => $_SESSION['challengename']])->one();
            $current_challenge = backend\models\PilotCreateGame::find()->where(['challenge_company_id' => $company->id])->andWhere(['challenge_id' => $challenge->id])->one();
            $checkedfeatures = explode(',', $current_challenge->features);
            $country_timezone = false;
            foreach ($checkedfeatures as $value) {
                if ($value == 9) {
                    $country_timezone = TRUE;
                }
            }
            if ($country_timezone == TRUE) {
                ?> 
                <?=
                $form->field($model, 'country')->dropdownList(
                        backend\models\Company::timezoneCountries(), ['prompt' => 'Please Select']
                )->label('Country' . Html::tag('span', '*', ['class' => 'required']));
                ?>
                <div class='ajax-timezone'>
                    <img src='http://gifimage.net/wp-content/uploads/2017/06/gif-upload-14.gif'>
                    <?=
                    $form->field($model, 'timezone')->dropdownList(
                            []
                    )->label('Timezone' . Html::tag('span', '*', ['class' => 'required']));
                    ?>
                </div>
            <?php } ?>
            <?=
            $form->field($model, 'profile_pic', [
                'template' => '{label}<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8 profile_image">{beginWrapper}{input}{endWrapper}</div>{error}',
            ])->widget(Widget::className(), [
                'label' => 'Upload or Drag an image here',
                'maxSize' => 10485760760,
                'uploadUrl' => Url::toRoute('/site/uploadPhoto'),
                'cropAreaWidth' => 150,
                'cropAreaHeight' => 150,
                'width' => 2400,
                'height' => 2400,
            ])->label('Profile Picture');
            ?>
            
                <textarea name="base64_pic" id="base64_pic" style="display:none"></textarea>
                <input type="hidden" value="0" name="exif_angle" id="exif_angle">
            <div class="form-group desc">
                <label class="control-label"></label>
                <div class="description">
                    Note: Maximum upload file size is 10MB.
                </div>
            </div>     


            <?php if ($show_notis_reminder == 'true'): ?>

                <!--Notifications Settings-->
                <div class="form-group">
                    <label class="control-label notif_lbl">SMS Notification Reminder Options</label>
                </div>
                <?= $form->field($notif_settings_model, 'notif_type[]')->checkbox(['id' => 'notif_shout_out'])->label('Please send me text notifications when others respond to my Wins/Shout-Outs.'); ?>
                <?= $form->field($notif_settings_model, 'notif_delivery_method[]', ['options' => ['class' => 'hidden']])->dropDownList($notif_methods, ['prompt' => 'Please Select', 'id' => 'notif_shout_out_method'])->label('Delivery Method' . Html::tag('span', '*', ['class' => 'required'])); ?> 
                <?= $form->field($notif_settings_model, 'notif_frequency[]', ['options' => ['class' => 'hidden']])->dropDownList($notif_frequency_shoutout, ['prompt' => 'Please Select', 'id' => 'notif_shout_out_freq'])->label('Frequency' . Html::tag('span', '*', ['class' => 'required'])); ?> 

                <?= $form->field($notif_settings_model, 'notif_type[]')->checkbox(['id' => 'notif_check_in'])->label('Please send me text reminders to check in on my culture challenge.'); ?>
                <?= $form->field($notif_settings_model, 'notif_delivery_method[]', ['options' => ['class' => 'hidden']])->dropDownList($notif_methods, ['prompt' => 'Please Select', 'id' => 'notif_check_in_method'])->label('Delivery Method' . Html::tag('span', '*', ['class' => 'required'])); ?> 
                <?= $form->field($notif_settings_model, 'notif_frequency[]', ['options' => ['class' => 'hidden']])->dropDownList($notif_frequency_checkin, ['prompt' => 'Please Select', 'id' => 'notif_check_in_freq'])->label('Frequency' . Html::tag('span', '*', ['class' => 'required'])); ?> 

                <!--Hidden Fields for Notifications-->
                <input type="hidden" value="unchecked" id="check_notif_shout_out" name="check_notif_shout_out"/>
                <input type="hidden" value="unchecked" id="check_notif_check_in" name="check_notif_check_in"/>

                <!--Input Field for Phone Number-->
                <div class="form-group phn_no" style="display: none;"> 
                    <label class="control-label">Phone number<span class="required">*</span></label>
                    <input type="tel" class="form-control" name="phoneNumber" id="phoneNumber" />
                    <span>
                        <p class="help-block help-block-error"></p>
                    </span>
                </div>  

                <!--Hidden Fields for Phone Number-->
                <?= $form->field($model, 'phone_number', ['options' => ['class' => 'hidden']])->hiddenInput(['id' => 'phn_no'])->label(false); ?>
                <?= $form->field($model, 'phone_number_type', ['options' => ['class' => 'hidden']])->hiddenInput(['id' => 'phn_no_type'])->label(false); ?>
                <?= $form->field($model, 'phone_number_country', ['options' => ['class' => 'hidden']])->hiddenInput(['id' => 'phn_no_country_name'])->label(false); ?>
                <?= $form->field($model, 'phone_number_country_iso_code', ['options' => ['class' => 'hidden']])->hiddenInput(['id' => 'phn_no_country_iso_code'])->label(false); ?>
                <?= $form->field($model, 'phone_number_country_dial_code', ['options' => ['class' => 'hidden']])->hiddenInput(['id' => 'phn_no_country_dial_code'])->label(false); ?>

            <?php endif; ?>
            <!--Terms of Use-->
            <div class="form-item form-type-checkbox form-item-terms-of-use">
                <fieldset class="form-wrapper" id="edit-terms-of-use"><legend><span class="fieldset-legend">Terms of Use</span></legend><div class="fieldset-wrapper">
                        <div class="main-content">
                            <div class="outer-content-page">
                                <div class="heading">
                                    Terms of Use and Conditions
                                </div>
                                <div class="description">
                                    These Terms of Use and Conditions (these "Terms of Use") apply to your use of all websites, blogs, mobile sites, and applications maintained by or on behalf of Injoy Global, Inc., including 
                                    and InJoy Global, Inc.'s Culti-vate platform (collectively, the "Website"). 
                                    The terms "we", "us", "our" and "Company" refer to InJoy Global (also known as InJoy Global, Inc.), a Nevada corporation. 
                                    "You" or "your" refers to the person or company who uses the Website or any product or service viewed or accessed at the Website. 
                                    Your use of the Website is governed by these Terms of Use as they exist at the time of your use. We reserve the right to change these Terms of Use in the future without notice.
                                    <ul>
                                        <li>Access of the Website. Your access of the Website constitutes your agreement to be bound by these Terms of Use. If you are unable or unwilling to abide by these Terms of Use, please immediately discontinue access of the Website. As a condition of your access of the Website, you represent and warrant that you will not access the Website for any purpose that is unlawful or prohibited herein. We reserve the right to terminate your right to use the Website.
                                        </li>
                                        <li>We require registration to access certain proprietary content of the Website available to Registered Users (as defined herein). Where applicable, you or your employer may elect to register and create a personal account (each, a "Registered User" and collectively, "Registered Users") and user ID ("User ID") to access the certain features of the Website and, in particular, the Culti-vate platform. Unless you become a Registered User, you have no right to access the Content provided through the Culti-vate platform. To register, you must complete the registration process by providing us with current, complete and accurate information as prompted by your account profile. In registering you agree to submit accurate, current and complete information, and to promptly update such information. Should we suspect that such information is untrue, inaccurate, not current or incomplete, we have has the right to suspend or terminate your access to the Website. Your user account cannot be shared or used by anyone other than you. By opening a user account, you are confirming that you are at least eighteen (18) years of age or are at least thirteen (13) years of age and are being supervised, while using this Website, by a parent or legal guardian who has agreed to be bound by these Terms of Use.
                                        </li> 
                                        <li>Upon registration, you will receive a User ID and personal password.  You will be responsible for keeping your User ID and password confidential. You will notify us immediately upon learning of any unauthorized use of your User ID and password.  We cannot and will not protect you from the unauthorized use of your User ID and password. You will be responsible for all activities and charges incurred through the use of your User ID and password, and any claims, liabilities, damages, losses and costs (including reasonable attorneys' fees) resulting from the unauthorized use of your User ID and password, except for unauthorized use of your User ID and password directly resulting from the gross negligence or willful misconduct of Company.
                                        </li>
                                        <li>Intellectual Property. General, Copyright, Trademark and other proprietary rights and laws protect the Website and its intellectual property. No part of our materials on the Website (the "Content"), including, but not limited to, graphics, photographs, text, images, documents, sounds, multimedia content, audiovisual content logos, games, trademarks layout, or other materials you may see or read on the Website and all related software code, may be copied, photocopied, reproduced, translated or reduced to any electronic medium or machine- readable form, in whole or in part, or used in any way other than as explicitly permitted pursuant to these Terms of Use, without our specific written permission. Subject to the terms and conditions contained in these Terms of Use, we hereby grant you a limited, revocable, personal, non-sublicensable, non- transferable, non-exclusive license to access and use the Website and the Content for your limited and personal, non-commercial access and use for real- time viewing purposes only. Except as expressly provided, nothing contained in these Terms of Use shall be construed to confer on you or any third party any license or right, by implication or under any law, rule or regulation, including, without limitation, those related to copyright, trademark or other intellectual property rights.
                                        </li> 
                                        <li>We may change, suspend or discontinue the Website at any time, including the availability of any feature, database or content.</li>  
                                        <li>Third Party Content. The Website may contain third parties materials and content. We are not responsible for and assume no liability for any statements, representations or any other form of information contained in third party content appearing on or made available through the Website. Inclusion of a third party or its, his, her content on the Website is not an endorsement thereof.<br><br>We will not be liable, under any circumstances, for the illegality, inaccuracy or error in any and all third party content. This Website contains links to other websites. We do not endorse these websites, are not responsible for them, and do not control, review, test, verify, certify, or authenticate the availability, accuracy, reliability, content, associated links, privacy and security practices, resources, or services associated with a third party site. We are not liable for any loss or damage of any sort associated with your use of third party content. Links and access to these sites are provided for your convenience only and should you choose to access such other sites you acknowledge that you do so voluntarily and assume all risk.

                                        </li>  
                                        <li>Prohibited Uses. You are solely responsible for all of your activity in connection with the Website. Any fraudulent, abusive, illegal or otherwise inappropriate activities are grounds for termination of your access the Website. Without limitation to other prohibited uses specified herein, you are prohibited from using the Website for the following purposes:
                                            <ul>
                                                <li>Accessing content or data not intended for you, or logging onto a server or account that you are not authorized to access;
                                                </li>
                                                <li>attempting to probe, scan, or test the vulnerability of the Website, or any associated system or network, or to breach security or authentication measures without proper authorization;
                                                </li>
                                                <li>interfering or attempting to interfere with service to any user, host, or network, including, without limitation, by means of submitting a virus to the Website, overloading, "flooding," "spamming," "mail bombing," or "crashing;"
                                                </li>
                                                <li>using the Website to send unsolicited e-mail, including, without limitation, promotions, or advertisements for products or services;
                                                </li>
                                                <li>forging any TCP/IP packet header or any part of the header information in any e-mail or posting;
                                                </li> 
                                                <li>attempting to modify, reverse-engineer, decompile, disassemble, or otherwise reduce or attempt to reduce to a human-perceivable form any of the source code used by us in providing the Website. Any violation of system or network security may subject you to significant civil and/or criminal liability;
                                                </li>
                                                <li>scraping, crawling or using any other automated device or manual process to harvest data from the Website;
                                                </li>
                                                <li>using the Website to transmit any false, misleading, fraudulent, harmful, threatening, abusive, harassing, tortious, defamatory, vulgar, obscene, invasive, hateful, or illegal communications or other data;
                                                </li>
                                                <li>using information obtained from the Website to solicit other Website users;
                                                </li>
                                                <li>posting or transmitting, or causing to be posted or transmitted, any communication or solicitation designed or intended to obtain password, account, or private information from any other user; and
                                                </li>
                                                <li>impersonating any person or entity or otherwise mispresent your affiliation with a person or entity.</li>
                                            </ul>
                                        </li>    
                                        <li>Use of the Website/platform is subject to our <a href="/privacy_policy">Privacy Policy</a>. </li>
                                        <li>YOU AGREE THAT YOUR USE OF THE WEBSITE AND THE CONTENT SHALL BE AT YOUR OWN RISK. THE WEBSITE/CONTENT IS PROVIDED ON AN "AS IS" AND "AS AVAILABLE" BASIS. WE EXPRESSLY DISCLAIM ALL EXPRESS OR IMPLIED WARRANTIES OF ANY KIND, INCLUDING, BUT NOT LIMITED TO, WARRANTIES OF TITLE, IMPLIED WARRANTIES OF MERCHANTAILITY, FITNESS FOR A PARTICULAR PURPOSE OR NONINFRINGEMENT. WE MAKE NO WARRANTY AS TO THE QUALITY, ACCURACY, COMPLETENESS OR VALIDITY OF ANY MATERIAL AND DO NOT WARRANT THAT THE FUNCTIONS CONTAINED ON THE WEBSITE WILL BE UNINTERRUPTED OR ERROR-FREE, OR THAT DEFECTS WILL BE CORRECTED, OR THAT THE WEBSITE IS FREE OF VIRUSES. WHERE APPLICABLE LAW DOES NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES, THE FOREGOING EXCLUSIONS WILL NOT APPLY TO YOU.
                                        </li>
                                        <li>LIMITATION OF LIABILITY. TO THE EXTENT PERMITTED BY APPLICABLE LAW, INJOY GLOBAL WILL NOT BE LIABLE TO YOU FOR ANY INDIRECT, SPECIAL, INCIDENTAL, CONSEQUENTIAL, EXEMPLARY OR PUNITIVE DAMAGES OF ANY KIND, INCLUDING WITHOUT LIMITATION LOST PROFITS (REGARDLESS OF WHETHER WE HAVE BEEN NOTIFIED THAT SUCH LOSS MAY OCCUR) AND NEGLIGENCE, BY REASON OF ANY ACT OR OMISSION IN OUR PROVISION OF THE WEBSITE UNDER THESE TERMS OF USE OR AS A RESULT OF USING, MODIFYING, CONTRIBUTING, COPYING, DISTRIBUTING OR ACCESSING THE WEBSITE OR THE CONTENT, AS WELL AS FOR ANY DAMAGES.<br><br>SUFFERED AS A RESULT OF THE INABILITY TO USE THE WEBSITE OR THE CONTENT. THE CONTENT CONTAINED ON THE WEBSITE/PLATFORM IS PROVIDED FOR INFORMATIONAL PURPOSED AND IS NOT INTENDED TO BE A SUBSTITUTE FOR PROFESSIONAL ADVICE. TO THE EXTENT PERMITTED BY APPLICABLE LAW, THE TOTAL LIABILITY OF THE COMPANY WILL BE THE AMOUNT THAT YOU PAID US TO USE THE WEBSITE, OR IF YOU DID NOT PAY ANYTHING, YOUR SOLE REMEDY WILL BE TO STOP USING THE WEBSITE. YOU UNDERSTAND THAT THIS PARAGRAPH SHALL APPLY TO YOUR USE OF THE WEBSITE AND ALL CONTENT AND SERVICES AVAILABLE THROUGH THE WEBSITE.
                                        </li>
                                        <li>Indemnification. You agree to defend, indemnify and hold harmless InJoy Global from any and all liabilities, penalties, claims, causes of action and demands brought by third parties (including the costs, expenses and attorney's fees on account thereof resulting from your use of the Website) whether based in contract or tort (including strict liability) and regardless of the form of action arising from or related to (a) your negligence, error, omission or willful misconduct, (b) your breach of any terms of these Terms of Use, or (c) your use or access of the Website or the Content.
                                        </li>
                                        <li>Remedies for Violations. We reserve the right to seek all remedies available at law and in equity for violation of these Terms of Use, including, without limitation, the right to block access from a particular Internet address to the Website.
                                        </li>
                                        <li>Modification of Terms of Use. We may modify, delete or otherwise alter these Terms of Use in our sole discretion at any time. Such modifications shall be effective immediately upon being posted to the Website. You are responsible for regularly reviewing these Terms of Use. Continued access of the Website thereafter shall constitute your consent to any modifications hereto.
                                        </li>
                                        <li>These Terms of Use shall be governed by and construed in accordance with the laws of the State of California and the laws of the United States, without giving effect to any principles of conflicts of law. You consent to the sole and exclusive jurisdiction and venue of the United States district courts sitting in the State of California and any courts of the State of California in which any suit, action or proceeding is brought arising under these Terms of Use or based on your access to the Website. Where applicable law does not permit the choice of law and jurisdiction contained in this paragraph, these choices of law and jurisdiction will not apply to you. If any provision of these Terms of Use shall be unlawful, void or for any reason unenforceable, then that provision shall be deemed severable from these Terms of Use and shall not affect the validity and enforceability of any remaining provisions. No waiver of any provision of these Terms of Use by us shall be deemed a further or continuing waiver of such provision or any other provision, and our failure to assert any right or provision under these Terms of Use shall not constitute a waiver of such right or provision. You acknowledge and agree that you have fully read and understand these Terms of Use and have had the opportunity to seek legal counsel of your choice. These Terms of Use contain the entire agreement between the parties regarding the subject matter hereof. These Terms of Use supersede all prior written and oral understandings, writings, and representations and may only be amended upon notice by us. These Terms of Use shall be binding upon and inure to the benefit of the parties hereto and their respective heirs, personal representatives, successors and assigns. You may not transfer or assign these Terms of Use or your rights and obligations hereunder.</li>

                                    </ul>

                                </div>  
                            </div>
                        </div>

                    </div></fieldset>
                <?= $form->field($model, 'agree_terms')->checkbox()->label('I agree with these terms' . Html::tag('span', '*', ['class' => 'required'])) ?>
                <?=
                $form->field($model, 'captcha')->widget(
                        \himiklab\yii2\recaptcha\ReCaptcha::className(), ['siteKey' => '6Lf0VTQUAAAAAKl7i-GglYl7sJE__-ecHgWWzxlG'])->label('Captcha' . Html::tag('span', '*', ['class' => 'required']));
                ?>
                <div class = "form-group">
                    <?= Html::submitButton('Register', ['id' => 'reg_btn', 'class' => 'btn btn-primary signup_btn '.$class, 'name' => 'signup-button','style' => 'background:'.$color])
                    ?>
                    <?= Html::a('cancel', '/'.$challenge_name, ['class' => 'btn btn-primary signup_btn '.$class,'style' => 'background:'.$color])
                    ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>

</div>