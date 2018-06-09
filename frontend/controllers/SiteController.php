<?php

namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use yii\imagine\Image;
use yii\web\Session;
use common\models\LoginForm_Front;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\PilotFrontUser;
use frontend\models\PilotFrontUserNotificationsSettings;
use backend\models\Company;
use backend\models\PilotCompanyTeams;
use backend\models\PilotGameChallengeName;
use backend\models\PilotCreateGame;
use backend\models\PilotCreateGameFeatures;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'uploadPhoto', 'send-notifications', 'my-profile', 'privacy-policy', 'terms-condition'],
                'rules' => [
                    [
                        'actions' => ['uploadPhoto', 'send-notifications'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['uploadPhoto', 'logout', 'my-profile', 'privacy-policy', 'terms-condition'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
//      'error' => [
//        'class' => 'yii\web\ErrorAction',
//      ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'uploadPhoto' => [
                'class' => 'budyaga\cropper\actions\UploadAction',
                'url' => Yii::$app->request->baseurl . '/uploads/',
                'path' => '@uploads/',
                'maxSize' => 10485760,
            ]
        ];
    }

    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        $this->layout = 'error_layout';
        if ($exception !== null) {
            if ($exception->statusCode == 404):
                return $this->render('error404', ['exception' => $exception]);
            else:
                return $this->render('error500', ['exception' => $exception]);
            endif;
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex($comp = NULL) {
        //get compamy name from url
        $curentUrl = Yii::$app->request->hostInfo;
        $url = parse_url($curentUrl, PHP_URL_HOST);
        $explodedUrl = explode('.', $url);
        //save company name into $comp
        $comp = $explodedUrl[0];

        $this->layout = 'above';
        $session = Yii::$app->session;
        //Company Welcome Page
        if ($comp != NULL):
            //If User is Logged In
            if (!Yii::$app->user->isGuest):
                $loggedin_user_compId = Yii::$app->user->identity->company_id;
                $active_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $loggedin_user_compId, 'status' => 1])->one();
                $challenge_id = Yii::$app->user->identity->challenge_id;
                if (!empty($active_challenge)):
                    $challenge_teams = explode(',', $active_challenge->challenge_teams);
                    $challenge_features = explode(',', $active_challenge->features);
                    //if (in_array($user_team_id, $challenge_teams)):
                    //Active Challenge Redirection for User
                    if (!empty($challenge_id)):
                        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
                        $active_challenge_name = $challenge_obj->challenge_name;
                        $active_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                    else:
                        $active_challenge_id = $active_challenge->challenge_id;
                        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $active_challenge_id])->one();
                        $active_challenge_name = $challenge_obj->challenge_name;
                        $active_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                    endif;
                    //Define Active Challenge Template - Features
                    foreach ($challenge_features as $key => $val):
                        $feature = PilotCreateGameFeatures::find()->where(['id' => $val])->one();
                        $fea[] = [
                            'feature_id' => $feature->id,
                            'feature_name' => $feature->name
                        ];
                    endforeach;
                    $session[$active_challenge_abbr_name . '_Template'] = [
                        'features' => $fea
                    ];

                    $company_obj = Company::find()->where(['id' => $user_company_id])->one();
                    $company_name = str_replace(' ', '-', strtolower($company_obj->company_name));


                    $session['company_name'] = $company_name;
                    $session['challenge_name'] = $active_challenge_abbr_name;
                    return $this->redirect(Url::to(['/' . $active_challenge_abbr_name . '/dashboard']));
                endif;
                $company_obj = Company::find()->where(['id' => $loggedin_user_compId])->one();
                $check_comp = str_replace(' ', '-', strtolower($company_obj->company_name));
                if ($check_comp != $comp):
                    return $this->redirect(Url::to(['/service/dashboard']));
                //return $this->redirect('http://'. $check_comp .'.injoychange.com');
                else:
                    //Get all Companies(Clients)
                    $companies = Company::find()->all();
                    if (!empty($companies)):
                        $comp_code_array = [];
                        foreach ($companies as $company):
                            $company_name = $company->company_name;
                            $company_code = str_replace(' ', '-', strtolower($company_name));
                            if ($company_code == $comp):
                                $comp_id = $company->id;
                                $comp_name = $company->company_name;
                                $company_logo = $company->image;
                            endif;
                            array_push($comp_code_array, $company_code);
                        endforeach;
                        $session->set('company_logo', $company_logo);
                        $session->set('company_name', $comp);
                        $session->set('comp_name', $comp_name);
                        $session->set('company_id', $comp_id);

                        //Check URL Param is a Company Code or not
                        if (in_array($comp, $comp_code_array)):
                            return $this->render('companyWelcomePage', [
                                        'company_id' => $comp_id,
                                        'company_name' => $comp_name,
                                        'comp' => $comp,
                                        'company_logo' => $company_logo
                            ]);
                        else:
                            $this->layout = 'error_layout';
                            return $this->render('error404');
                        endif;
                    else:
                        $this->layout = 'error_layout';
                        return $this->render('error404');
                    endif;
                endif;
            //If User is not Logged In
            else:
                //Get all Companies(Clients)
                $companies = Company::find()->all();
                if (!empty($companies)):
                    $comp_code_array = [];
                    foreach ($companies as $company):
                        $company_name = $company->company_name;
                        $company_code = str_replace(' ', '-', strtolower($company_name));
                        if ($company_code == $comp):
                            $comp_id = $company->id;
                            $comp_name = $company->company_name;
                            $company_logo = $company->image;
                        endif;
                        array_push($comp_code_array, $company_code);
                    endforeach;
                    $session->set('company_logo', $company_logo);
                    $session->set('company_name', $comp);
                    $session->set('comp_name', $comp_name);
                    $session->set('company_id', $comp_id);

                    //Check URL Param is a Company Code or not
                    if (in_array($comp, $comp_code_array)):
                        return $this->render('companyWelcomePage', [
                                    'company_id' => $comp_id,
                                    'company_name' => $comp_name,
                                    'comp' => $comp,
                                    'company_logo' => $company_logo
                        ]);
                    else:
                        $this->layout = 'error_layout';
                        return $this->render('error404');
                    endif;
                else:
                    $this->layout = 'error_layout';
                    return $this->render('error404');
                endif;
            endif;
        else:
            //Redirect the Index Page to Company Landing Page
            if (!Yii::$app->user->isGuest):
                $loggedin_user_compId = Yii::$app->user->identity->company_id;
                $company_obj = Company::find()->where(['id' => $loggedin_user_compId])->one();
                $check_comp = str_replace(' ', '-', strtolower($company_obj->company_name));
                return $this->redirect(Url::to(['/']));
            else:
                return $this->redirect(Url::to(['/']));
            endif;
        //return $this->render('index');
        endif;
    }

    public function actionChallenge($name) {
        //get compamy name from url
        if ($name == 'aboveandbeyond'):
            $name = 'leads';
        endif;
        if ($name == 'learning'):
            $name = 'test';
        endif;
        $curentUrl = Yii::$app->request->hostInfo;
        $url = parse_url($curentUrl, PHP_URL_HOST);
        $explodedUrl = explode('.', $url);
        //save company name into $comp
        $comp = $explodedUrl[0];

        $session = Yii::$app->session;
        $this->layout = 'above';
        $challenge_id = 0;
        if ($name != NULL) {
            $challenge1 = PilotGameChallengeName::find()->select('id')->where(['challenge_abbr_name' => $name])->one();
            $challenge_id = $challenge1->id;
        }
        $companies = Company::find()->all();
        if (!empty($companies)):
            $comp_code_array = [];
            foreach ($companies as $company):
                $company_name = $company->company_name;
                $company_code = str_replace(' ', '-', strtolower($company_name));
                if ($company_code == $comp):
                    $comp_id = $company->id;
                    $comp_name = $company->company_name;
                    $company_logo = $company->image;
                endif;
                array_push($comp_code_array, $company_code);
            endforeach;
            $session->set('company_logo', $company_logo);
            $session->set('company_name', $comp);
            $session->set('comp_name', $comp_name);
            $session->set('company_id', $comp_id);
            $session->set('challenge_id', $challenge_id);
            $session->set('challenge_id', $challenge_id);
            $session->set('challengename', $name);

            //Check URL Param is a Company Code or not
            if (in_array($comp, $comp_code_array)):
                return $this->render('challenge', [
                            'company_id' => $comp_id,
                            'company_name' => $comp_name,
                            'comp' => $comp,
                            'company_logo' => $company_logo,
                            'challenge_id' => $challenge_id,
                            'challenge' => $name,
                ]);
            endif;
        endif;
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        //get compamy name from url
        $curentUrl = Yii::$app->request->hostInfo;
        $url = parse_url($curentUrl, PHP_URL_HOST);
        $explodedUrl = explode('.', $url);
        //save company name into $comp
        $comp = $explodedUrl[0];
        $action = Yii::$app->controller->action->id;
        $session = Yii::$app->session;
        $this->layout = 'register';
        $model = new LoginForm_Front();
        if ($model->load(Yii::$app->request->post()) && $model->login()) :
//            echo '<pre>';print_r(Yii::$app->request->post());
//            
//            echo '<pre>';print_r($_COOKIE);
//            echo '<pre>';print_r($_SESSION);die;
            // Check The Active Game for Company & Team of User 
            $model_update = PilotFrontUser::findOne(Yii::$app->user->identity->id);
            if (!empty($model_update)):
                $user_company_id = Yii::$app->user->identity->company_id;
                $challenge_id = Yii::$app->user->identity->challenge_id;
                $active_challenge1 = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $user_company_id, 'status' => [1]])->one();
                if (!empty($active_challenge1)):
                    $model_update->challenge_id = $active_challenge1->challenge_id;
                endif;
                $model_update->last_access_time = time();
                $model_update->updated = time();
                $model_update->ip_address = $_SERVER['REMOTE_ADDR'];
                $model_update->browser = PilotFrontUser::getBrowser();
                $model_update->device = PilotFrontUser::getDeviceName();
                $model_update->save(false);
            endif;
            $user_company_id = Yii::$app->user->identity->company_id;
            $user_team_id = Yii::$app->user->identity->team_id;
            $challenge_id = Yii::$app->user->identity->challenge_id;
            $active_challenge = PilotCreateGame::find()->where(['challenge_id' => $challenge_id, 'challenge_company_id' => $user_company_id, 'status' => 1])->one();
            $session->set('action', $action);
            if (!empty($active_challenge)):
                $challenge_teams = explode(',', $active_challenge->challenge_teams);
                $challenge_features = explode(',', $active_challenge->features);
                //if (in_array($user_team_id, $challenge_teams)):
                //Active Challenge Redirection for User
                if (!empty($challenge_id)):
                    $challenge_obj = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
                    $active_challenge_name = $challenge_obj->challenge_name;
                    $active_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                else:
                    $active_challenge_id = $active_challenge->challenge_id;
                    $challenge_obj = PilotGameChallengeName::find()->where(['id' => $active_challenge_id])->one();
                    $active_challenge_name = $challenge_obj->challenge_name;
                    $active_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                endif;
                //Define Active Challenge Template - Features
                foreach ($challenge_features as $key => $val):
                    $feature = PilotCreateGameFeatures::find()->where(['id' => $val])->one();
                    $fea[] = [
                        'feature_id' => $feature->id,
                        'feature_name' => $feature->name
                    ];
                endforeach;
                $session[$active_challenge_abbr_name . '_Template'] = [
                    'features' => $fea
                ];

                $company_obj = Company::find()->where(['id' => $user_company_id])->one();
                $company_name = str_replace(' ', '-', strtolower($company_obj->company_name));


                $session['company_name'] = $company_name;
                $session['challenge_name'] = $active_challenge_abbr_name;
                return $this->redirect(Url::to(['/' . $active_challenge_abbr_name . '/dashboard']));
            else:
                //Fetch the Most Recent Upcoming Challenge
                $upcoming_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $user_company_id, 'status' => 0])
                        ->orderBy(['challenge_start_date' => SORT_ASC])
                        ->one();
                $challenge_teams = explode(',', $upcoming_challenge->challenge_teams);
                if (!empty($upcoming_challenge)):
                    //Upcoming Challenge Redirection for User
                    $challenge_obj = PilotGameChallengeName::find()->where(['id' => $upcoming_challenge->challenge_id])->one();
                    $upcoming_challenge = $challenge_obj->challenge_abbr_name;
                    return $this->redirect(Url::to(['/' . $upcoming_challenge . '/dashboard']));
                else:
                    return $this->goBack();
                endif;
            endif;
        else :
            if (!Yii::$app->user->isGuest):
                $loggedin_user_compId = Yii::$app->user->identity->company_id;
                $company_obj = Company::find()->where(['id' => $loggedin_user_compId])->one();
                $check_comp = str_replace(' ', '-', strtolower($company_obj->company_name));

                $challenge_id = Yii::$app->user->identity->challenge_id;
                if (!empty($challenge_id)):
                    $challenge_obj = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
                    $active_challenge_name = $challenge_obj->challenge_name;
                    $active_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                    return $this->redirect(Url::to(['/' . $active_challenge_abbr_name . '/dashboard']));
                else:
                    return $this->goHome();
                endif;

            else:
                //Rendering Login Page
                $companies = Company::find()->all();
                if ($comp == 'site'): //Normal Login Page
                    return $this->render('login', [
                                'model' => $model,
                                'comp' => $comp,
                    ]);
                else: //Login Page as per Company 
                    if (!empty($companies)):
                        $comp_code_array = [];
                        foreach ($companies as $company):
                            $company_name = $company->company_name;
                            $company_code = str_replace(' ', '-', strtolower($company_name));
                            if ($company_code == $comp):
                                $comp_id = $company->id;
                                $comp_name = $company->company_name;
                            endif;
                            array_push($comp_code_array, $company_code);
                        endforeach;
                        //Check URL Param is a Company Code or not
                        if (in_array($comp, $comp_code_array)):
                            //Fetch Company Logo
                            $company_obj = Company::find()->where(['id' => $comp_id])->one();
                            $company_logo = $company_obj->image;
                            $session->set('company_logo', $company_logo);
                            $session->set('company_name', $comp);

                            return $this->render('login', [
                                        'company_id' => $comp_id,
                                        'company_logo' => $company_logo,
                                        'model' => $model,
                                        'comp' => $comp
                            ]);
                        else:
                            $this->layout = 'error_layout';
                            return $this->render('error404');
                        endif;
                    else:
                        $this->layout = 'error_layout';
                        return $this->render('error404');
                    endif;
                endif;
            endif;
        endif;
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        $challenge_obj = PilotGameChallengeName::find()->where(['id' => Yii::$app->user->identity->challenge_id])->one();
        $active_challenge_name = $challenge_obj->challenge_abbr_name;
        Yii::$app->user->logout();
        return $this->redirect('/' . $active_challenge_name);
        //return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }
            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup($challenge) {
        //get compamy name from url
        $curentUrl = Yii::$app->request->hostInfo;
        $url = parse_url($curentUrl, PHP_URL_HOST);
        $explodedUrl = explode('.', $url);
        //save company name into $comp
        $comp = $explodedUrl[0];
        if ($challenge == 'aboveandbeyond'):
            $challenge = 'leads';
        endif;
        if ($challenge == 'learning'):
            $challenge = 'test';
        endif;
        $this->layout = 'register';
        if ($challenge != NULL) {
            $challenge1 = PilotGameChallengeName::find()->where(['challenge_abbr_name' => $challenge])->one();
            $challenge_id = $challenge1->id;
        }
        $session = Yii::$app->session;
        $model = new PilotFrontUser();
        $model->scenario = 'user_signup';
        $notif_settings_model = new PilotFrontUserNotificationsSettings();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) :
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        endif;
        if (Yii::$app->request->post()) :
            $postedData = Yii::$app->request->post();
            $model->load(Yii::$app->request->post());
            $model->emailaddress = trim($model->emailaddress, ' ');
            $model->username = ucfirst($model->firstname) . ' ' . ucfirst($model->lastname);
            $model->role = 'Company User';
            $model->setPassword(Yii::$app->request->post()['PilotFrontUser']['password_hash']);
            $model->generateAuthKey();
            if (Yii::$app->request->post()['PilotFrontUser']['profile_pic'] != ""):
                $userimg_path = Yii::$app->request->post()['PilotFrontUser']['profile_pic'];
                $profile_image = substr($userimg_path, strrpos($userimg_path, '/') + 1);
                $pimg_save = Image::thumbnail(Yii::getAlias('@uploads/' . $profile_image), 71, 71)
                        ->save(Yii::getAlias('@uploads/thumb_' . $profile_image), ['quality' => 100]);
                $model->profile_pic = $profile_image;
            else:
                if (Yii::$app->request->post()['base64_pic'] != ''):
                    $base64_pic = Yii::$app->request->post()['base64_pic'];
                    $imgData = explode(',', $code_base64);
                    $decoded_img = base64_decode($imgData[1]);
                    $base64_pic = str_replace('data:image/png;base64,', '', $base64_pic);
                    $base64_pic = str_replace('data:image/jpeg;base64,', '', $base64_pic);
                    $base64_pic = str_replace(' ', '+', $base64_pic);
                    $decoded_img = base64_decode($base64_pic);
                    $new_image_name = time() . '.jpg';
                    $new_path = Yii::getAlias('@uploads/' . $new_image_name);
                    //Save Image to folder
                    $file = file_put_contents($new_path, $decoded_img);
                    //rotating the image if contains exif data
                    $DefaultTargetPath = Yii::getAlias('@uploads/') . $new_image_name;
                    //get resorce id of image uploaded by extenstion
                    $resouceID = imagecreatefromstring(file_get_contents($DefaultTargetPath));
                    //rotate image according to exif angle
                    $rotateImage = imagerotate($resouceID, Yii::$app->request->post()['exif_angle'], 0);
                    $newName = time() . '_' . $new_image_name;
                    $targetPathNew = Yii::getAlias('@uploads/') . $newName;
                    //get image extension
                    $ext = pathinfo($new_image_name, PATHINFO_EXTENSION);

                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG' || $ext == 'JPEG'):
                        $a = imagejpeg($rotateImage, $targetPathNew, 100);
                    endif;
                    if ($ext == 'png' || $ext == 'PNG'):
                        $a = imagepng($rotateImage, $targetPathNew, 0);
                    endif;
                    imagedestroy($rotateImage);

                    //remove default saved file
                    unlink($DefaultTargetPath);
                    $profile_image = substr($targetPathNew, strrpos($targetPathNew, '/') + 1);
                    //Generate Thumbnail of the image
                    $pimg_save = Image::thumbnail(Yii::getAlias('@uploads/' . $profile_image), 71, 71)
                            ->save(Yii::getAlias('@uploads/thumb_' . $profile_image), ['quality' => 100]);
                    $model->profile_pic = $profile_image;
                endif;
            endif;
            $model->last_access_time = time();
            $model->created = time();
            $model->updated = time();
            $model->ip_address = $_SERVER['REMOTE_ADDR'];
            $model->browser = PilotFrontUser::getBrowser();
            $model->device = PilotFrontUser::getDeviceName();
            $model->agree_terms = Yii::$app->request->post()['PilotFrontUser']['agree_terms'];
            $model->challenge_id = $challenge_id;
            $model->save(false);

            //Save Signup User Notifications Settings
            $signup_user_id = $model->id;
            $notif_postedData = Yii::$app->request->post()['PilotFrontUserNotificationsSettings'];
            if ($postedData['check_notif_shout_out'] == 'checked'):
                $notif_type = 'Shout Out';
                //Get Notification Delivery Method
                $shout_delivery_method = $notif_postedData['notif_delivery_method'][0];
                //Get Delivery Frequency
                $shout_delivery_freq = $notif_postedData['notif_frequency'][0];
                //Save the settings for Shout out
                $model_shout = new PilotFrontUserNotificationsSettings();
                $model_shout->user_id = $signup_user_id;
                $model_shout->notif_type = $notif_type;
                $model_shout->notif_delivery_method = $shout_delivery_method;
                $model_shout->notif_frequency = $shout_delivery_freq;
                $model_shout->created = time();
                $model_shout->updated = time();
                $model_shout->save(false);
            endif;

            if ($postedData['check_notif_check_in'] == 'checked'):
                $notif_type = 'Check In';
                //Get Notification Delivery Method
                $checkin_delivery_method = $notif_postedData['notif_delivery_method'][1];
                //Get Delivery Frequency
                $checkin_delivery_freq = $notif_postedData['notif_frequency'][1];
                //Save the settings for Check in to Game Challenge
                $model_checkin = new PilotFrontUserNotificationsSettings();
                $model_checkin->user_id = $signup_user_id;
                $model_checkin->notif_type = $notif_type;
                $model_checkin->notif_delivery_method = $checkin_delivery_method;
                $model_checkin->notif_frequency = $checkin_delivery_freq;
                $model_checkin->created = time();
                $model_checkin->updated = time();
                $model_checkin->save(false);
            endif;

            //Signup User Login
            $email = trim(Yii::$app->request->post()['PilotFrontUser']['emailaddress'], ' ');
            $user = PilotFrontUser::findByEmailaddress($email);
            if (Yii::$app->user->login($user)) :

                Yii::$app->session->setFlash('success', 'Thank you for Registration.');
                // Check The Active Game for Company & Team of User 
                $user_company_id = Yii::$app->user->identity->company_id;
                $user_team_id = Yii::$app->user->identity->team_id;
                $active_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $user_company_id, 'status' => 1])->one();
                $challenge_id = Yii::$app->user->identity->challenge_id;
                if (!empty($active_challenge)): //If there is an Ongoing Challenge for the Company

                    $action = Yii::$app->controller->action->id;
                    $session->set('action', $action);
                    $challenge_teams = explode(',', $active_challenge->challenge_teams);
                    $challenge_features = explode(',', $active_challenge->features);
//                    if (in_array($user_team_id, $challenge_teams)):
                    //Active Challenge Redirection for User
                    if (!empty($challenge_id)):
                        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
                        $active_challenge_name = $challenge_obj->challenge_name;
                        $active_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                    else:
                        $active_challenge_id = $active_challenge->challenge_id;
                        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $active_challenge_id])->one();
                        $active_challenge_name = $challenge_obj->challenge_name;
                        $active_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                    endif;

                    //Define Active Challenge Template - Features
                    foreach ($challenge_features as $key => $val):
                        $feature = PilotCreateGameFeatures::find()->where(['id' => $val])->one();
                        $fea[] = [
                            'feature_id' => $feature->id,
                            'feature_name' => $feature->name
                        ];
                    endforeach;
                    $session[$active_challenge_abbr_name . '_Template'] = [
                        'features' => $fea
                    ];
                    return $this->redirect(Url::to(['/' . $active_challenge_abbr_name . '/dashboard']));
//                    else:
//                        return $this->goBack();
//                    endif;

                else: //If there is Upcoming Challenge for the Company
                    //Fetch the Most Recent Upcoming Challenge
                    $upcoming_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $user_company_id, 'status' => 0])
                            ->orderBy(['challenge_start_date' => SORT_ASC])
                            ->one();
                    $challenge_teams = explode(',', $upcoming_challenge->challenge_teams);
                    if (in_array($user_team_id, $challenge_teams)):
                        //Upcoming Challenge Redirection for User
                        $upcoming_challenge_id = $upcoming_challenge->challenge_id;
                        $challenge_obj = PilotGameChallengeName::find()->where(['id' => $upcoming_challenge_id])->one();
                        $upcoming_challenge_name = $challenge_obj->challenge_name;
                        $upcoming_challenge_abbr_name = $challenge_obj->challenge_abbr_name;
                        return $this->redirect(Url::to(['/' . $upcoming_challenge_abbr_name . '/welcome']));
                    else:
                        return $this->goBack();
                    endif;

                endif;

            endif;
        endif;
        if (!Yii::$app->user->isGuest):
            $loggedin_user_compId = Yii::$app->user->identity->company_id;
            $company_obj = Company::find()->where(['id' => $loggedin_user_compId])->one();
            $check_comp = str_replace(' ', '-', strtolower($company_obj->company_name));
            //return $this->redirect(Url::to(['/' . $check_comp]));
            return $this->goHome();
        else:
            //Rendering Sign Up Page
            $companies = Company::find()->all();
            $compData = ArrayHelper::map($companies, 'id', 'company_name');
            if ($comp == 'site'): //Normal Sign up Page
                return $this->render('signup', [
                            'compData' => $compData,
                            'model' => $model,
                ]);
            else: //Sign up Page as per Company 
                if (!empty($companies)):
                    $comp_code_array = [];
                    foreach ($companies as $company):
                        $company_name = $company->company_name;
                        $company_code = str_replace(' ', '-', strtolower($company_name));
                        if ($company_code == $comp):
                            $comp_id = $company->id;
                            $comp_name = $company->company_name;
                        endif;
                        array_push($comp_code_array, $company_code);
                    endforeach;
                    //Check URL Param is a Company Code or not
                    if (in_array($comp, $comp_code_array)):
                        $active_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $comp_id, 'status' => 1])->one();
                        if (!empty($active_challenge)):
                            $challenge_teams = explode(',', $active_challenge->challenge_teams);
                            $challenge_features = explode(',', $active_challenge->features);
                        else:
                            //Fetch the Most Recent Upcoming Challenge
                            $upcoming_challenge = PilotCreateGame::find()->where(['challenge_company_id' => $comp_id, 'status' => 0])
                                    ->orderBy(['challenge_start_date' => SORT_ASC])
                                    ->one();
                            $challenge_teams = explode(',', $upcoming_challenge->challenge_teams);
                            $challenge_features = explode(',', $upcoming_challenge->features);
                        endif;
                        $teamsData = [];
                        //Teams for which the Active Challenge of Company is available
                        foreach ($challenge_teams as $key => $val):
                            $team_obj = PilotCompanyTeams::find()->where(['id' => $val])->one();
                            if (!empty($team_obj)):
                                $teamsData[$team_obj->id] = $team_obj->team_name;
                            endif;
                        endforeach;

                        //Challenge Features
                        foreach ($challenge_features as $key => $val):
                            $feature = PilotCreateGameFeatures::find()->where(['id' => $val])->one();
                            $features[] = $feature->name;
                        endforeach;

                        //Fetch Company Logo
                        $company_obj = Company::find()->where(['id' => $comp_id])->one();
                        $company_logo = $company_obj->image;
                        $session->set('company_logo', $company_logo);
                        $session->set('company_name', $comp);
                        return $this->render('signup', [
                                    'company_id' => $comp_id,
                                    'teamsData' => $teamsData,
                                    'features' => $features,
                                    'company_logo' => $company_logo,
                                    'model' => $model,
                                    'notif_settings_model' => $notif_settings_model,
                                    'comp' => $comp
                        ]);
                    else:
                        $this->layout = 'error_layout';
                        return $this->render('error404');
                    endif;
                else:
                    $this->layout = 'error_layout';
                    return $this->render('error404');
                endif;
            endif;
        endif;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        //get compamy name from url
        $curentUrl = Yii::$app->request->hostInfo;
        $url = parse_url($curentUrl, PHP_URL_HOST);
        $explodedUrl = explode('.', $url);
        //save company name into $comp
        $comp = $explodedUrl[0];

        $this->layout = 'register';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()):
            if ($model->sendEmail($comp)):
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->redirect('login');
            else :
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            endif;
        else:
            $session = Yii::$app->session;
//Rendering Login Page
            $companies = Company::find()->all();
            if ($comp == 'site'): //Normal Login Page
                return $this->render('requestPasswordResetToken', [
                            'model' => $model,
                ]);
            else: //Login Page as per Company 
                if (!empty($companies)):
                    $comp_code_array = [];
                    foreach ($companies as $company):
                        $company_name = $company->company_name;
                        $company_code = str_replace(' ', '-', strtolower($company_name));
                        if ($company_code == $comp):
                            $comp_id = $company->id;
                            $comp_name = $company->company_name;
                        endif;
                        array_push($comp_code_array, $company_code);
                    endforeach;
                    //Check URL Param is a Company Code or not
                    if (in_array($comp, $comp_code_array)):
                        //Fetch Company Logo
                        $company_obj = Company::find()->where(['id' => $comp_id])->one();
                        $company_logo = $company_obj->image;
                        $session->set('company_logo', $company_logo);
                        $session->set('company_name', $comp);

                        return $this->render('requestPasswordResetToken', [
                                    'company_id' => $comp_id,
                                    'company_logo' => $company_logo,
                                    'model' => $model,
                                    'comp' => $comp
                        ]);
                    else:
                        $this->layout = 'error_layout';
                        return $this->render('error404');
                    endif;
                else:
                    $this->layout = 'error_layout';
                    return $this->render('error404');
                endif;
            endif;
        endif;
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        $this->layout = 'register';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');
            //return $this->goHome();
            return $this->redirect('login');
        }
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionPrivacyPolicy() {
        $this->layout = 'register';
        return $this->render('privacy');
    }

    public function actionTermsCondition() {
        $this->layout = 'register';
        return $this->render('terms');
    }

    public function actionCompanyTeams() {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $user_company_id = $parents[0];
                $teams = PilotCompanyTeams::find()->where(['company_id' => $user_company_id])->all();
                $teams_array = [];
                $i = 0;
                foreach ($teams as $team):
                    $teams_array[$i]['id'] = $team->id;
                    $teams_array[$i]['name'] = $team->team_name;
                    $i++;
                endforeach;
                echo json_encode(['output' => $teams_array, 'selected' => '']);
                return;
            }
        }
        echo json_encode(['output' => '', 'selected' => '']);
    }

    /**
     * User Profile Edit Page
     */
    public function actionMyProfile($comp = NULL) {
        $this->layout = 'profile';
        $user_id = Yii::$app->user->identity->id;
        $user_company_id = Yii::$app->user->identity->company_id;
        $user_obj_model = PilotFrontUser::find()->where(['id' => $user_id])->one();
        $user_obj_model->scenario = 'user_update';
        $user_pswd = $user_obj_model->password_hash;
        $user_obj_model->password_hash = '';
        /* Profile Update Form Submitted */
        if (Yii::$app->request->post()):
            // echo "<pre>";print_r(Yii::$app->request->post());die('sas');
            $postedData = Yii::$app->request->post();
            $user_obj_model->load(Yii::$app->request->post());
            $user_obj_model->username = ucfirst($user_obj_model->firstname) . ' ' . ucfirst($user_obj_model->lastname);
            if ($postedData['PilotFrontUser']['password_hash'] == ''): //Password not updated Case
                $user_obj_model->password_hash = $user_pswd;
            else: //Password updated Case
                $user_obj_model->setPassword($postedData['PilotFrontUser']['password_hash']);
            endif;
            if ($postedData['PilotFrontUser']['profile_pic'] != ""):
                $userimg_path = Yii::$app->request->post()['PilotFrontUser']['profile_pic'];
                $profile_image = substr($userimg_path, strrpos($userimg_path, '/') + 1);
                $pimg_save = Image::thumbnail(Yii::getAlias('@uploads/' . $profile_image), 71, 71)
                        ->save(Yii::getAlias('@uploads/thumb_' . $profile_image), ['quality' => 100]);
                $user_obj_model->profile_pic = $profile_image;
            else:
                //echo "<pre>"; print_r(Yii::$app->request->post()); die(" herer");
                if (Yii::$app->request->post()['base64_pic'] != ''):
                    $base64_pic = Yii::$app->request->post()['base64_pic'];
                    $imgData = explode(',', $code_base64);
                    $decoded_img = base64_decode($imgData[1]);
                    $base64_pic = str_replace('data:image/png;base64,', '', $base64_pic);
                    $base64_pic = str_replace('data:image/jpeg;base64,', '', $base64_pic);
                    $base64_pic = str_replace(' ', '+', $base64_pic);
                    $decoded_img = base64_decode($base64_pic);
                    $new_image_name = time() . '.jpg';
                    $new_path = Yii::getAlias('@uploads/' . $new_image_name);
                    //Save Image to folder
                    $file = file_put_contents($new_path, $decoded_img);
                    //rotating the image if contains exif data
                    $DefaultTargetPath = Yii::getAlias('@uploads/') . $new_image_name;
                    //get resorce id of image uploaded by extenstion
                    $resouceID = imagecreatefromstring(file_get_contents($DefaultTargetPath));
                    //rotate image according to exif angle
                    $rotateImage = imagerotate($resouceID, Yii::$app->request->post()['exif_angle'], 0);
                    $newName = time() . '_' . $new_image_name;
                    $targetPathNew = Yii::getAlias('@uploads/') . $newName;
                    //get image extension
                    $ext = pathinfo($new_image_name, PATHINFO_EXTENSION);

                    if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG' || $ext == 'JPEG'):
                        $a = imagejpeg($rotateImage, $targetPathNew, 100);
                    endif;
                    if ($ext == 'png' || $ext == 'PNG'):
                        $a = imagepng($rotateImage, $targetPathNew, 0);
                    endif;
                    imagedestroy($rotateImage);

                    //remove default saved file
                    unlink($DefaultTargetPath);
                    $profile_image = substr($targetPathNew, strrpos($targetPathNew, '/') + 1);
                    //Generate Thumbnail of the image
                    $pimg_save = Image::thumbnail(Yii::getAlias('@uploads/' . $profile_image), 71, 71)
                            ->save(Yii::getAlias('@uploads/thumb_' . $profile_image), ['quality' => 100]);
                    $user_obj_model->profile_pic = $profile_image;
                endif;
            endif;
            $user_obj_model->country = $postedData['PilotFrontUser']['country'];
            $user_obj_model->timezone = $postedData['PilotFrontUser']['timezone'];
            $user_obj_model->ip_address = $_SERVER['REMOTE_ADDR'];
            $user_obj_model->device = PilotFrontUser::getDeviceName();
            $user_obj_model->browser = PilotFrontUser::getBrowser();
            $user_obj_model->last_access_time = time();
            $user_obj_model->updated = time();
            $user_obj_model->save(false);

            Yii::$app->session->setFlash('success', 'Profile has been updated!');
            $this->refresh();
            return false;
        endif;

        return $this->render('my_profile', [
                    'user_obj_model' => $user_obj_model,
        ]);
    }

    /**
     * Cron URL for Sending Email & SMS Notifications
     */
    public function actionSendNotifications() {
        $active_challenges = PilotCreateGame::find()->where(['status' => 1])->all();
        $current_day_name = date('l');
        //if there is any Active Challenges
        if (!empty($active_challenges)):
            foreach ($active_challenges as $challenge):
                $game_id = $challenge->challenge_id;
                $comp_id = $challenge->challenge_company_id;
                $challenge_teams = explode(',', $challenge->challenge_teams);
                $reg_date_timestamp = $challenge->challenge_registration_date;
                $start_date_timestamp = $challenge->challenge_start_date;
                $end_date_timestamp = $challenge->challenge_end_date;
                //Get all users of the Active Challenge
                $company_users = PilotFrontUser::find()->where(['company_id' => $comp_id])
                        ->andWhere(['between', 'created', $reg_date_timestamp, $end_date_timestamp]) //if only users registered for current challenge of company
                        ->all();
                if (!empty($company_users)):
                    foreach ($company_users as $comp_user):
                        //User Details
                        $comp_user_id = $comp_user->id;
                        $comp_user_name = $comp_user->username;
                        $comp_user_email = $comp_user->emailaddress;
                        $comp_user_team = $comp_user->team_id;
                        $comp_user_phone_number = $comp_user->phone_number;

                        //If Challenge is active for User Team only then we have to check the Notification settings of User
                        if (in_array($comp_user_team, $challenge_teams)):
                            //Get the Notification settings of the User
                            $user_notif_settings = PilotFrontUserNotificationsSettings::find()->where(['user_id' => $comp_user_id])->all();
                            if (!empty($user_notif_settings))://If user have enabled Notification Settings
                                foreach ($user_notif_settings as $user_notif):
                                    //Get the Notif Type
                                    $user_notif_type = $user_notif->notif_type;

                                    if ($user_notif_type == 'Check In') :
                                        //Get the Notification Method (SMS or EMAIL)
                                        $check_in_notif_method = $user_notif->notif_delivery_method;
                                        //Get the Frequency of Notification
                                        $check_in_notif_freq = $user_notif->notif_frequency;
                                        //Send As Email
                                        if ($check_in_notif_method == 'Email'): //If Email Notification for Check In has been selected by User
                                            if ($check_in_notif_freq == 'Daily'):
                                                //Send Email Daily
                                                $send_email = PilotFrontUser::send_email_notification($challenge, $comp_user, $user_notif_type);
                                            elseif ($check_in_notif_freq == 'Weekly (Monday)'):
                                                //Send Email Only on Monday
                                                if ($current_day_name == 'Monday'):
                                                    $send_email = PilotFrontUser::send_email_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            elseif ($check_in_notif_freq == 'Monday/Wednesday/Friday'):
                                                //Send Email Only on Monday,Wednesday & Friday 
                                                if ($current_day_name == 'Monday' || $current_day_name == 'Wednesday' || $current_day_name == 'Friday'):
                                                    $send_email = PilotFrontUser::send_email_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            endif;
                                        elseif ($check_in_notif_method == 'SMS/Text Message'): //If SMS Notification for Check In has been selected by User
                                            if ($check_in_notif_freq == 'Daily'):
                                                //Send SMS Daily
                                                $send_sms = PilotFrontUser::send_sms_notification($challenge, $comp_user, $user_notif_type);
                                            elseif ($check_in_notif_freq == 'Weekly (Monday)'):
                                                //Send SMS Only on Monday
                                                if ($current_day_name == 'Monday'):
                                                    $send_sms = PilotFrontUser::send_sms_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            elseif ($check_in_notif_freq == 'Monday/Wednesday/Friday'):
                                                //Send SMS Only on Monday,Wednesday & Friday
                                                if ($current_day_name == 'Monday' || $current_day_name == 'Wednesday' || $current_day_name == 'Friday'):
                                                    $send_sms = PilotFrontUser::send_sms_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            endif;
                                        endif;
                                    endif;

                                    if ($user_notif_type == 'Shout Out') :
                                        //Get the Notification Method (SMS or EMAIL)
                                        $shout_out_notif_method = $user_notif->notif_delivery_method;
                                        //Get the Frequency of Notification
                                        $shout_out_notif_freq = $user_notif->notif_frequency;
                                        if ($shout_out_notif_method == 'Email'): //If Email Notification for Shout Out  has been selected by User
                                            if ($shout_out_notif_freq == 'Daily'):
                                                //Send Email Daily
                                                $send_email = PilotFrontUser::send_email_notification($challenge, $comp_user, $user_notif_type);
                                            elseif ($shout_out_notif_freq == 'Weekly (Friday)'):
                                                //Send Email Only on Friday 
                                                if ($current_day_name == 'Friday'):
                                                    $send_email = PilotFrontUser::send_email_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            elseif ($shout_out_notif_freq == 'Monday/Wednesday/Friday'):
                                                //Send Email Only on Monday,Wednesday & Friday 
                                                if ($current_day_name == 'Monday' || $current_day_name == 'Wednesday' || $current_day_name == 'Friday'):
                                                    $send_email = PilotFrontUser::send_email_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            endif;
                                        elseif ($shout_out_notif_method == 'SMS/Text Message'): //If SMS Notification for Shout Out has been selected by User
                                            if ($shout_out_notif_freq == 'Daily'):
                                                //Send SMS Daily
                                                $send_sms = PilotFrontUser::send_sms_notification($challenge, $comp_user, $user_notif_type);
                                            elseif ($shout_out_notif_freq == 'Weekly (Friday)'):
                                                //Send SMS Only on Friday
                                                if ($current_day_name == 'Friday'):
                                                    $send_sms = PilotFrontUser::send_sms_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            elseif ($shout_out_notif_freq == 'Monday/Wednesday/Friday'):
                                                //Send SMS Only on Monday,Wednesday & Friday
                                                if ($current_day_name == 'Monday' || $current_day_name == 'Wednesday' || $current_day_name == 'Friday'):
                                                    $send_sms = PilotFrontUser::send_sms_notification($challenge, $comp_user, $user_notif_type);
                                                endif;
                                            endif;
                                        endif;
                                    endif;

                                endforeach;
                            //End Fetching User Notifications Settings
                            endif;
                        //End Notifications Check
                        endif;
                        //End User Team Check
                    endforeach;
                //End Fetching Users Data
                endif;
                //End Company User Check
            endforeach;
        //End Fetching Challenges Data
        endif;
        //End Active Challenges Check
    }

    public function actionAjaxgettimezone() {
        $arr = array();
        $html = '';
        $countrycode = $_POST['countrycode'];
        $countryname = ucwords(strtolower($_POST['countryname']));
        $timezone = $_POST['timezone'];
        $gmtdata = \backend\models\Company::childTimezone();
        foreach ($gmtdata as $key => $value) {
            $str = substr($key, 0, strpos($key, '/'));
            if ($str == $countryname) {
                $continent = \backend\models\Company::country_to_continent($countrycode);
                $timezoneArr = explode('/', $key);
                $timezoneNew = end($timezoneArr);
                if ($timezone == $continent . '/' . $timezoneNew) {
                    if ($timezoneNew == 'Honolulu') {
                        $html .= '<option selected value="Pacific/' . $timezoneNew . '">' . $value . '</option>';
                    } else {
                        $html .= '<option selected value="' . $continent . '/' . $timezoneNew . '">' . $value . '</option>';
                    }
                } else {
                    if ($timezoneNew == 'Honolulu') {
                        $html .= '<option selected value="Pacific/' . $timezoneNew . '">' . $value . '</option>';
                    } else {
                        $html .= '<option value="' . $continent . '/' . $timezoneNew . '">' . $value . '</option>';
                    }
                }
            }
        }
        return \yii\helpers\Json::encode($html);
    }

    public function actionFullImage() {
        $base64_pic = $_POST['base64_pic'];
        $base64_pic = str_replace('data:image/png;base64,', '', $base64_pic);
        $base64_pic = str_replace('data:image/jpeg;base64,', '', $base64_pic);
        $base64_pic = str_replace(' ', '+', $base64_pic);
        $decoded_img = base64_decode($base64_pic);
        $new_image_name = time() . '.jpg';
        $new_path = Yii::getAlias('@uploads/' . $new_image_name);
        //Save Image to folder
        $file = file_put_contents($new_path, $decoded_img);
        return $new_image_name;
        //Generate Thumbnail of the image
        $pimg_save = Image::thumbnail(Yii::getAlias('@uploads/' . $new_image_name), 71, 71)
                ->save(Yii::getAlias('@uploads/thumb_' . $new_image_name), ['quality' => 100]);
        return \yii\helpers\Json::encode($new_image_name);
        ;
    }

    public function actionUploadImage() {
        echo '<pre>';
        print_r($_FILES);
        die;
    }

}
