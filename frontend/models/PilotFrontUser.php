<?php

namespace frontend\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\models\Company;
use backend\models\PilotCompanyTeams;
use backend\models\PilotGameChallengeName;
use yii\validators\EmailValidator;

/**
 * This is the model class for table "pilot_front_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $emailaddress
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $role
 * @property string $company_id
 * @property string $team_id
 * @property string $last_login_id
 * @property integer $last_access_time
 * @property string $firstname
 * @property string $lastname
 * @property string $phone_number
 * @property string $phone_number_type
 * @property string $phone_number_country
 * @property string $phone_number_country_iso_code
 * @property string $phone_number_country_dial_code
 * @property string $profile_pic
 * @property string $dob
 * @property string $address
 * @property string $gender
 * @property string $height
 * @property string $weight
 * @property string $stride
 * @property string $access_token
 * @property string $refresh_token
 * @property string $expires_in
 * @property string $browser
 * @property string $ip_address
 * @property integer $agree_terms
 * @property integer $status
 * @property integer $created
 * @property integer $updated
 */
class PilotFrontUser extends \yii\db\ActiveRecord implements IdentityInterface {

    public $confirm_password;
    public $captcha;

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pilot_front_user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['emailaddress', 'password_hash', 'confirm_password', 'company_id', 'team_id', 'firstname', 'lastname', 'gender', 'height', 'weight', 'stride', 'access_token', 'refresh_token', 'expires_in', 'captcha', 'country', 'timezone'], 'required', 'on' => 'user_signup'],
            ['agree_terms', 'compare', 'compareValue' => 1, 'message' => 'You have to check this checkbox'],
            [['last_access_time', 'created', 'updated', 'challenge_id'], 'integer'],
            [['emailaddress'], 'validateEmail'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password_hash', 'message' => "Passwords don't match"],
            //[['emailaddress'], 'unique', 'message' => 'This email address is already registered.'],
            [['username', 'emailaddress', 'password_hash', 'role', 'company_id', 'team_id', 'last_login_id', 'phone_number', 'phone_number_type', 'phone_number_country', 'phone_number_country_iso_code', 'phone_number_country_dial_code', 'profile_pic', 'dob', 'gender', 'height', 'weight', 'stride', 'access_token', 'refresh_token', 'expires_in', 'ip_address', 'browser', 'address'], 'string', 'max' => 255],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['password_hash', 'string', 'min' => 6],
            [['emailaddress', 'firstname', 'lastname', 'gender', 'team_id', 'weight', 'stride', 'country', 'timezone'], 'required', 'on' => 'update'],
            ['confirm_password', 'required', 'when' => function ($model) {
                    return $model->password_hash !== '';
                }, 'whenClient' => "function (attribute, value) {
                return $('#pilotfrontuser-password_hash').val() !== '';
                }",
                'on' => 'update'],
            [['emailaddress', 'firstname', 'lastname', 'gender', 'height', 'weight', 'stride', 'country', 'timezone'], 'required', 'on' => 'user_update'],
            ['confirm_password', 'required', 'when' => function ($model) {
                    return $model->password_hash !== '';
                }, 'whenClient' => "function (attribute, value) {
                return $('#pilotfrontuser-password_hash').val() !== '';
                }",
                'on' => 'user_update'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'emailaddress' => 'Email address',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'role' => 'Role',
            'company_id' => 'Company ID',
            'team_id' => 'Team ID',
            'last_login_id' => 'Last Login ID',
            'last_access_time' => 'Last Access Time',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'phone_number' => 'Phone Number',
            'phone_number_type' => 'Phone Number Type',
            'phone_number_country' => 'Phone Number Country',
            'phone_number_country_iso_code' => 'Phone Number Country Iso Code',
            'phone_number_country_dial_code' => 'Phone Number Country Dial Code',
            'profile_pic' => 'Profile Pic',
            'dob' => 'Dob',
            'address' => 'Address',
            'gender' => 'Gender',
            'height' => 'Height',
            'weight' => 'Weight',
            'stride' => 'Stride',
            'access_token' => 'Access Token',
            'refresh_token' => 'Refresh Token',
            'expires_in' => 'Expires In',
            'browser' => 'Browser',
            'ip_address' => 'Ip Address',
            'agree_terms' => 'Agree Terms',
            'challenge_id' => 'Challenge Id',
            'country' => 'Country',
            'timezone' => 'Timezone',
            'status' => 'Status',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }

    public function validateEmail($attribute, $params, $validator) {
        $email = trim($this->$attribute, ' ');
        $validator = new EmailValidator();
        if (!($validator->validate($email, $error))) {
            $this->addError($attribute, 'Email address is not a valid email address.');
        }
        $email1 = PilotFrontUser::find()->where(['emailaddress' => $email])->all();
        if (!empty($email1)) {
            $this->addError($attribute, 'This email address is already registered.');
        }
    }

    /*  public function validateFirstname($attribute, $params, $validator)
      {
      if (strlen($this->$attribute) > 10) {
      $this->addError($attribute, 'Firstname must not contain more than 10 Characters');
      }
      }
      public function validateLastname($attribute, $params, $validator)
      {
      if (strlen($this->$attribute) > 10) {
      $this->addError($attribute, 'Lastname must not contain more than 10 Characters');
      }
      } */

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
//    $user = static::findOne(['username' => $token]);
//    return $user;
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by EmailAddress
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmailaddress($email) {
        return static::findOne(['emailaddress' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * Get User's Browser Information
     */
    public static function getBrowser() {
        $u_agent = $_SERVER['HTTP_USER_AGENT'];

        $browser_name = 'Unknown';
        $platform = 'Unknown';
        $version = "";

        if (preg_match('/linux/i', $u_agent)) {
            $platform = 'linux';
        } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
            $platform = 'mac';
        } elseif (preg_match('/windows|win32/i', $u_agent)) {
            $platform = 'windows';
        }
        // Next get the name of the useragent yes seperately and for good reason
        if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
            $browser_name = 'Internet Explorer';
            $ub = "MSIE";
        } elseif (preg_match('/Firefox/i', $u_agent)) {
            $browser_name = 'Mozilla Firefox';
            $ub = "Firefox";
        } elseif (preg_match('/Chrome/i', $u_agent)) {
            $browser_name = 'Google Chrome';
            $ub = "Chrome";
        } elseif (preg_match('/Safari/i', $u_agent)) {
            $browser_name = 'Apple Safari';
            $ub = "Safari";
        } elseif (preg_match('/Opera/i', $u_agent)) {
            $browser_name = 'Opera';
            $ub = "Opera";
        } elseif (preg_match('/Netscape/i', $u_agent)) {
            $browser_name = 'Netscape';
            $ub = "Netscape";
        }
        // finally get the correct version number
        $known = array('Version', $ub, 'other');
        $pattern = '#(?<browser>' . join('|', $known) .
                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
        if (!preg_match_all($pattern, $u_agent, $matches)) {
            // we have no matching number just continue
        }
        // see how many we have
        $i = count($matches['browser']);
        if ($i != 1) {
            //we will have two since we are not using 'other' argument yet
            //see if version is before or after the name
            if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                $version = $matches['version'][0];
            } else {
                $version = $matches['version'][1];
            }
        } else {
            $version = $matches['version'][0];
        }
        // check if we have a number
        if ($version == null || $version == "") {
            $version = "?";
        }
        $info = $browser_name . "," . $platform . "," . $version;
        return $info;
    }

    /**
     * get Device Type
     */
    public static function getDeviceName() {

        require_once 'Mobile_Detect.php';
        $detect = new Mobile_Detect;
        $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'Tablet' : 'Mobile') : 'Computer');
        return $deviceType;
    }

    /**
     * Get Company Id according to code
     * 
     * @returns Company Id
     */
    public static function getCompanyID($comp_code = NULL) {
        //Get all Companies(Clients)
        $companies = Company::find()->all();
        if (!empty($companies)):
            $comp_code_array = [];
            foreach ($companies as $company):
                $company_name = $company->company_name;
                $company_code = str_replace(' ', '-', strtolower($company_name));
                if ($company_code == $comp_code):
                    $comp_id = $company->id;
                endif;
                array_push($comp_code_array, $company_code);
            endforeach;
        endif;

        return $comp_id;
    }

    /**
     * Get Game Id according to Game Abbr
     * 
     * @returns Game Id
     */
    public static function getGameID($game_abbr = NULL) {
        //Get Game Object
        $game_obj = PilotGameChallengeName::find()->where(['challenge_abbr_name' => $game_abbr])->one();

        return $game_obj->id;
    }

    /**
     * Get Game Week no as per the Game Start and End Date
     * 
     * @returns Current Week of Game
     */
    public static function getGameWeek($game_obj = NULL) {
        //Total Weeks between Game Start & End Date
        $game_start_date = date('Y-m-d', $game_obj->challenge_start_date);
        $firstday = date('l', $game_obj->challenge_start_date);
        $game_end_date = date('Y-m-d', $game_obj->challenge_end_date);
        $dateToArray = self::GetDateListDateRange($game_start_date, $game_end_date);
       // echo '<pre>';print_r($dateToArray);die;
        //Total Days of Challenge
        $total_days = count($dateToArray);
        $total_weeks = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
        $week = array();
        $game_week = 1;
        $prev_day_of_week = '';
        //Game Weeks & Days as per Weeks
        foreach ($dateToArray as $cdate):
            $day_of_week = date('l', strtotime($cdate));
            //if ($day_of_week == 'Monday' and Date('j', strtotime($cdate)) !== '1'):
            if ($day_of_week == $firstday):
                if ($prev_day_of_week != ''):
                    $game_week ++;
                endif;
            endif;
            $week[$game_week][$day_of_week] = $cdate;
            $prev_date = $cdate;
            $prev_day_of_week = date('l', strtotime($prev_date));
        endforeach;
        foreach ($total_weeks as $week_no):
            if ($week_no > $game_week)
                unset($week[$week_no]);
        endforeach;
        //echo '<pre>';print_r($week);die;
        //Get Current Week of the Game
        $current_date = date('Y-m-d', time());
        $i = 1;
        $current_week_no = 0;
        foreach ($week as $week_no):
            foreach ($week_no as $key => $value):
                if ($value == $current_date):
                    $current_week_no = $i;
                endif;
            endforeach;
            $i++;
        endforeach;
        //echo$current_week_no;die;
        return $current_week_no;
    }

    /**
     * Get Game Week no as per the Game Start and End Date
     * 
     * @returns Current Week of Game
     */
    public static function getGameWeekAsPerDate($game_obj = NULL, $datetocheck) {
        //Total Weeks between Game Start & End Date
        $game_start_date = date('Y-m-d', $game_obj->challenge_start_date);
        $firstday = date('l', $game_obj->challenge_start_date);
        $game_end_date = date('Y-m-d', $game_obj->challenge_end_date);
        $dateToArray = self::GetDateListDateRange($game_start_date, $game_end_date);
        //Total Days of Challenge
        $total_days = count($dateToArray);

        $total_weeks = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '10');
        $week = array();
        $game_week = 1;
        $prev_day_of_week = '';
        //Game Weeks & Days as per Weeks
        foreach ($dateToArray as $cdate):
            $day_of_week = date('l', strtotime($cdate));
            if ($day_of_week == $firstday):
                if ($prev_day_of_week != ''):
                    $game_week ++;
                endif;
            endif;
            $week[$game_week][$day_of_week] = $cdate;
            $prev_date = $cdate;
            $prev_day_of_week = date('l', strtotime($prev_date));
        endforeach;

        foreach ($total_weeks as $week_no):
            if ($week_no > $game_week)
                unset($week[$week_no]);
        endforeach;

        //Get Current Week of the Game

        $i = 1;
        $date_week_no = 0;
        foreach ($week as $week_no):
            foreach ($week_no as $key => $value):
                if ($value == $datetocheck):
                    $date_week_no = $i;
                endif;
            endforeach;
            $i++;
        endforeach;

        return $date_week_no;
    }

    /**
     *  Takes two dates formatted as YYYY-MM-DD and creates an
     *  inclusive array of the dates between the from and to dates.
     */
    public static function GetDateListDateRange($strDateFrom, $strDateTo) {
        $aryRange = array();

        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));

        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom)); // first entry
            while ($iDateFrom < $iDateTo) {
                $iDateFrom += 86400; // add 24 hours
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }

        return $aryRange;
    }

    /**
     * Get Day no as per the Game Start and End Date
     * 
     * @returns Current Day of Game
     */
    public static function getGameDay($game_obj = NULL) {
        //Total Weeks between Game Start & End Date
        $game_start_date = date('Y-m-d', $game_obj->challenge_start_date);
        $game_end_date = date('Y-m-d', $game_obj->challenge_end_date);
        $dateToArray = self::GetDateListDateRange($game_start_date, $game_end_date);
        //Total Days of Challenge
        $total_days = count($dateToArray);
        //Get Current Week of the Game
        $current_date = date('Y-m-d', time());
        // Get the Day no 
        $current_day_no = 1;
        foreach ($dateToArray as $key => $value):
            if ($value == $current_date):
                $current_day_no = $key + 1;
            endif;
        endforeach;

        return $current_day_no;
    }

    /**
     * Get Day no as per the Game Start and End Date
     * 
     * @returns YouTube Video Default Image
     */
    public static function getYoutubeImage($url) {
        $queryString = parse_url($url);
        $video_array = explode('/', $queryString['path']);
        $video_id = $video_array[2];
        //YouTube High Quality Default Image of Video URL
        $video_thumb_image = 'https://img.youtube.com/vi/' . $video_id . '/hqdefault.jpg';

        return $video_thumb_image;
    }

    /**
     * Count the Total Points of the User for Game Challenge
     */
    public static function getUserPoints($game_obj) {
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = $game_obj->challenge_id;
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        $week_no = self::getGameWeek($game_obj);
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        $dayset = date('Y-m-d');
        $game_end_date_timestamp = strtotime('+1 day', $game_end_date_timestamp);
        // $game_end_date_timestamp = 1512806400;
        //Points Variables
        $total_points = 0;
        $daily_points = 0;
        $check_in_points = 0;
        $high_five_points = 0;
        $corner_tips_points = 0;
        $weekly_points = 0;
        $share_a_win_points = 0;

        //Dynamically declare the Challenge Models
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';
        $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $share_a_win_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';

        //Points of Daily Inspiration Section
        $daily_points = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->sum('points');

        //Points of Check In Section
        $check_in_points = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->sum('points');

        //Points of High Five Section
        $high_five_points = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->sum('points');

        //Points of Corner Tips Section
        $corner_tips_points = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->sum('points');

        //Points of Weekly Challenge Section
        $weekly_points = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->sum('points');

        //Points of Share A Win Section
        $share_a_win_points = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->sum('points');

        //Total Points
        $total_points = $daily_points + $check_in_points + $high_five_points + $corner_tips_points + $weekly_points + $share_a_win_points;

        return $total_points;
    }

    /**
     * Count the Total Actions of the User for Game Challenge
     */
    public static function getUserActions($game_obj) {
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = $game_obj->challenge_id;
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        $week_no = self::getGameWeek($game_obj);
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        $dayset = date('Y-m-d');

        //Points Variables
        $total_actions = 0;
        $daily_actions = 0;
        $check_in_actions = 0;
        $high_five_actions = 0;
        $corner_tips_actions = 0;
        $weekly_actions = 0;
        $share_a_win_actions = 0;

        //Dynamically declare the Challenge Models
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';
        $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $share_a_win_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';

        //Actions of Daily Inspiration Section
        $daily_actions = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->all();

        //Actions of Check In Section
        $check_in_actions = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->all();

        //Actions of High Five Section
        $high_five_actions = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->all();

        //Actions of Corner Tips Section
        $corner_tips_actions = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->all();

        //Actions of Weekly Challenge Section
        $weekly_actions = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->all();

        //Actions of Share A Win Section
        $share_a_win_actions = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['between', 'created', $game_start_date_timestamp, $game_end_date_timestamp])
                ->all();

        //Total Points
        $total_actions = count($daily_actions) + count($check_in_actions) + count($high_five_actions) + count($corner_tips_actions) + count($weekly_actions) + count($share_a_win_actions);

        return $total_actions;
    }

    /**
     * Send Email Notifications for the Active Challenge of User as per Company & Team wise
     * 
     */
    public static function send_email_notification($challenge_obj, $comp_user_obj, $notif_type) {
        //Get the Challenge details
        $challenge_id = $challenge_obj->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
        $challenge_name = $challenge_obj->challenge_name;
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //Get User Details
        $comp_user_id = $comp_user_obj->id;
        $comp_user_name = $comp_user_obj->username;
        $comp_user_email = $comp_user_obj->emailaddress;
        $comp_id = $comp_user_obj->company_id;
        //Content of Email Message
        $email_from = 'injoyglobal@test.com';
        $email_to = $comp_user_email;

        //Timestamps
        $current_timestamp = time();
        $pre_day_timestamp = strtotime("yesterday");
        $send_email = 0;
        if ($notif_type == 'Shout Out'):
            $email_subject = 'Notification for ' . $notif_type . '-' . $challenge_name;
            //Check for the Comments & Likes for User's Shout Out Section
            $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
            $check_shout_comments = $high_five_model_name::find()->where(['game_id' => $challenge_id, 'user_id' => $comp_user_id, 'company_id' => $comp_id])
                    ->all();
            $email_flag = 'false';
            foreach ($check_shout_comments as $user_shout_comment):
                $cmnt_id = $user_shout_comment->id;
                $check_comment_like = $high_five_model_name::find()->where(['linked_feature_id' => $cmnt_id])
                        ->andWhere(['!=', 'user_id', $comp_user_id])
                        ->andWhere(['between', 'created', $pre_day_timestamp, $current_timestamp])
                        ->all();
                if (!empty($check_comment_like)):
                    $email_flag = 'true';
                endif;
            endforeach;
            $email_message = 'Hello ' . $comp_user_name . '<br> There is an comment or like for your ' . $notif_type . ' : ' . $challenge_name . '.';
        else:
            $email_flag = 'true';
            $email_subject = 'Reminder for ' . $notif_type . '-' . $challenge_name;
            $email_message = 'Hello ' . $comp_user_name . '<br> This is Test mail for Reminder for ' . $notif_type . ' : ' . $challenge_name . '.';
        endif;
        //if Email FLAG:TRUE Only then Send Email
        if ($email_flag = 'true'):
            $send_email = Yii::$app
                    ->mailer
                    ->compose()
                    ->setFrom($email_from)
                    ->setTo($email_to)
                    ->setSubject($email_subject)
                    ->setHtmlBody($email_message)
                    ->send();
        endif;
        echo $send_email;
        return $send_email;
    }

    /**
     * Send SMS Notifications using Plivo API 
     * Send SMS Notifications for the Active Challenge of User as per Company & Team wise
     */
    public static function send_sms_notification($challenge_obj, $comp_user_obj, $notif_type) {
        //Get the Challenge details
        $challenge_id = $challenge_obj->challenge_id;
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $challenge_id])->one();
        $challenge_name = $challenge_obj->challenge_name;
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);
        //Get User Details
        $comp_user_id = $comp_user_obj->id;
        $comp_user_name = $comp_user_obj->username;
        $comp_user_phone_number = $comp_user_obj->phone_number;
        $comp_id = $comp_user_obj->company_id;
        //Timestamps
        $current_timestamp = time();
        $pre_day_timestamp = strtotime("yesterday");
        $response = 0;
        if ($notif_type == 'Shout Out'):
            //Check for the Comments & Likes for User's Shout Out Section
            $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
            $check_shout_comments = $high_five_model_name::find()->where(['game_id' => $challenge_id, 'user_id' => $comp_user_id, 'company_id' => $comp_id])
                    ->all();
            $sms_flag = 'false';
            foreach ($check_shout_comments as $user_shout_comment):
                $cmnt_id = $user_shout_comment->id;
                $check_comment_like = $high_five_model_name::find()->where(['linked_feature_id' => $cmnt_id])
                        ->andWhere(['!=', 'user_id', $comp_user_id])
                        ->andWhere(['between', 'created', $pre_day_timestamp, $current_timestamp])
                        ->all();
                if (!empty($check_comment_like)):
                    $sms_flag = 'true';
                endif;
            endforeach;
            //Content of SMS Message
            $sms_message = 'Hello ' . $comp_user_name . ', There is an comment or like for your ' . $notif_type . ' : ' . $challenge_name . '.';
        else:
            $sms_flag = 'true';
            //Content of SMS Message
            $sms_message = 'Hello ' . $comp_user_name . ', This is Test SMS for Reminder for ' . $notif_type . ' : ' . $challenge_name . '.';
        endif;
        //if SMS FLAG:TRUE Only then Send SMS
        if ($sms_flag == 'true'):
            $AUTH_ID = 'MANZNIZJA3OGVHZDG1NM';
            $AUTH_TOKEN = 'YTQxY2U0MGIzMWQ1ZTZjMTE0NDllNjMxYjQ0YTM3';
            $src = '+18885379152';
            $dst = $comp_user_phone_number;
            $text = $sms_message;
            $url = 'https://api.plivo.com/v1/Account/' . $AUTH_ID . '/Message/';
            $data = array("src" => "$src", "dst" => "$dst", "text" => "$text");
            $data_string = json_encode($data);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
            curl_setopt($ch, CURLOPT_USERPWD, $AUTH_ID . ":" . $AUTH_TOKEN);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            curl_close($ch);
        endif;
        print_r($response);
        return $response;
    }

    /**
     * 
     * @return string
     */
    public function getPassword() {
        return '';
    }

    /**
     * Count the Total Points of the User for Game Challenge as Per Weeks
     */
    public static function getUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week) {
        $user_id = $user->id;
        //Points Variables
        $total_points = 0;
        $daily_points = 0;
        $check_in_points = 0;
        $high_five_points = 0;
        $corner_tips_points = 0;
        $weekly_points = 0;
        $share_a_win_points = 0;
        $game_obj = \backend\models\PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        //echo $game_id;die;
        //Dynamically declare the Challenge Models
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';
        $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $share_a_win_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';

        //Points of Daily Inspiration Section
        $daily_points = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Check In Section
        $check_in_points = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of High Five Section
        $high_five_points = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Corner Tips Section
        $corner_tips_points = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Weekly Challenge Section
        $weekly_points = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Share A Win Section
        $share_a_win_points = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Fitness Steps
//        $total_steps = \frontend\models\PilotFrontCoreStepsApiData::find()->where(['user_id' => $user_id])
//                ->andWhere(['<=', 'week_no', $week])
//                //->andWhere(['between', 'time', $week_start, $week_end])
//                ->sum('steps');

        //If User reached 10K Steps
        //$raffle_add = floor($total_steps / 10000);
       // $steps_points = 100 * $raffle_add; //Additional 100 Points for Each 10K Steps
        //Total Points
        $total_points = $daily_points + $check_in_points + $high_five_points + $corner_tips_points + $weekly_points + $share_a_win_points + $steps_points;
        return $total_points;
    }

    /*
      count the no. of sat and sunday
     */

    public static function gameoffdays($startDate, $endDate, $weekdayNumber) {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        $dateArr = array();

        do {
            if (date("w", $startDate) != $weekdayNumber) {
                $startDate += (24 * 3600); // add 1 day
            }
        } while (date("w", $startDate) != $weekdayNumber);


        while ($startDate <= $endDate) {
            $dateArr[] = date('Y-m-d', $startDate);
            $startDate += (7 * 24 * 3600); // add 7 days
        }

        return(count($dateArr));
    }

    /*
      get the difference between start date and end date
     */

    public static function datediff($start, $end1) {
//        $diff = abs($end - $start);
//        $years = floor($diff / (365 * 60 * 60 * 24));
//        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
//        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24)) + 1;
        $startdate = date('Y-m-d', $start);
        $end = strtotime("+1 days", $end1);
        $enddate = date('Y-m-d', $end);
        /* $date = new DateTime($startdate);
          $now = new DateTime(); */
        $date1 = date_create($startdate);
        $date2 = date_create($enddate);
        $diff = date_diff($date1, $date2);
        $days = $diff->format("%R%a days");
        return $days;
    }

    public static function numofweeks($start, $end1) {
//        $diff = abs($end - $start);
//        $years = floor($diff / (365 * 60 * 60 * 24));
//        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
//        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24)) + 1;
        $startdate = date('Y-m-d', $start);
        $end = strtotime("+1 days", $end1);
        $enddate = date('Y-m-d', $end);
        /* $date = new DateTime($startdate);
          $now = new DateTime(); */
        $date1 = date_create($startdate);
        $date2 = date_create($enddate);
        $diff = date_diff($date1, $date2);
        $days = $diff->format("%R%a days");
        $week1 = $days / 7;
        if (strpos($week1, ".") !== false) {
            $weeksarray = explode('.', $week1);
            return $weeksarray[0] + 1;
        }
        return $week1;
    }

    /**
     * Count the Total Actions of the User for Game Challenge as Per Weeks
     */
    public static function getUserWeeklyActions($user_id, $challenge_obj, $game, $comp_id, $week) {
        //Points Variables
        $total_actions = 0;
        $daily_actions = 0;
        $check_in_actions = 0;
        $high_five_actions = 0;
        $corner_tips_actions = 0;
        $weekly_actions = 0;
        $share_a_win_actions = 0;
        $game_obj = \backend\models\PilotCreateGame::find()->where(['challenge_id' => $game, 'challenge_company_id' => $comp_id, 'status' => 1])->one();
        $game_id = $game_obj->id;
        //Dynamically declare the Challenge Models
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $check_in_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Checkin';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $corner_tips_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Leadershipcorner';
        $weekly_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $share_a_win_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Shareawin';

        //Actions of Daily Inspiration Section
        $daily_actions = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of Check In Section
        $check_in_actions = $check_in_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of High Five Section
        $high_five_actions = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of Corner Tips Section
        $corner_tips_actions = $corner_tips_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of Weekly Challenge Section
        $weekly_actions = $weekly_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of Share A Win Section
        $share_a_win_actions = $share_a_win_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id, 'challenge_id' => $game_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Total Points
        $total_actions = count($daily_actions) + count($check_in_actions) + count($high_five_actions) + count($corner_tips_actions) + count($weekly_actions) + count($share_a_win_actions);

        return $total_actions;
    }

    public static function getweek($week_no, $total_weeks_data) {
        $diff = $week_no - $total_weeks_data;
        if ($diff > $total_weeks_data):
            $diff1 = PilotFrontUser::getweek($diff, $total_weeks_data);
            if ($diff1 < 3):
                return $diff1;
            endif;
            $diff1 = $diff1 / 3;
            $diffarray = explode('.', $diff1);
            return $diffarray[0];
        endif;
        if ($diff < 3):
            return $diff;
        endif;
        $diff1 = $diff / 3;
        $diffarray = explode('.', $diff1);
        return $diffarray[0];
    }

    public static function getdays($day_no, $total_data) {
        $diff = $day_no - $total_data;
        if ($diff < 0):
            $diff2 = $total_data - $day_no;
            if ($diff2 > $total_data):
                $diff1 = PilotFrontUser::getdays($diff2, $total_data);
                return $diff1;
            endif;
            return $diff2;
        endif;
        if ($diff > $total_data):
            $diff1 = PilotFrontUser::getdays($diff, $total_data);
            return $diff1;
        endif;
        return $diff;
    }

    public static function getvideoweek($week_no, $weekly_challenge_count) {
        $diff = $week_no - $weekly_challenge_count;
        if ($diff < 0):
            $diff2 = $total_data - $day_no;
            if ($diff2 > $total_data):
                $diff1 = PilotFrontUser::getvideoweek($diff2, $total_data);
                return $diff1;
            endif;
            return $diff2;
        endif;
        if ($diff > $weekly_challenge_count):
            $diff1 = PilotFrontUser::getvideoweek($diff, $weekly_challenge_count);
            return $diff1;
        endif;
        return $diff;
    }

    public static function getcompanyname($cid) {
        $model = Company::find()->where(['id' => $cid])->one();
        return $model->company_name;
    }

    public static function getteamname($cid, $id) {

        $team = PilotCompanyTeams::find()->where(['id' => $id, 'company_id' => $cid])->one();
        return $team->team_name;

        //return '<div class="image-wrapper"><img width="100" alt="" src="/backend/web/img/uploads/' . $image . '"></div>' . $model->company_name . '<br/><span class="small">' . $teamsNames . '</span>';
    }

    public static function getTimeago($ptime) {
        $estimate_time = time() - $ptime;
        if ($estimate_time < 1) {
            return 'less than 1 second ago';
        }
        $condition = array(
            12 * 30 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($condition as $secs => $str) {
            $d = $estimate_time / $secs;
            if ($d >= 1) {
                $r = round($d);
                return 'about ' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
            }
        }
    }
    /**
     * Count the Total Points of the User for Game Challenge
     */
    public static function getlearningUserPoints($game_obj) {
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = $game_obj->challenge_id;
         $game_id = $game_obj->id;
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        $week_no = self::getGameWeek($game_obj);
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        $dayset = date('Y-m-d');
        $game_end_date_timestamp = strtotime('+1 day', $game_end_date_timestamp);
        // $game_end_date_timestamp = 1512806400;
        //Points Variables
        $total_points = 0;
        $daily_points = 0;
        $audio_model_points = 0;
        $high_five_points = 0;
        $did_you_points = 0;
        $question_modal_points =0;
        
        //Dynamically declare the Challenge Models
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $audio_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $did_you_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Knowcorner';
        $question_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Question';

        //Points of Daily Inspiration Section
        $daily_points = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->sum('points');

        //Points of High Five Section
        $high_five_points = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->sum('points');

        //Points of Corner Tips Section
        $audio_model_points = $audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->sum('points');

        //Points of Weekly Challenge Section
        
        $did_you_points = $did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->sum('points');
        //Points of Weekly Challenge Section
        $question_modal_points = $question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->sum('points');


        //Total Points
        $total_points = $daily_points + $audio_model_points + $high_five_points + $did_you_points +$question_modal_points;
        return $total_points;
    }
    public static function getlearningUserActions($game_obj) {
        $user_id = Yii::$app->user->identity->id;
        //Get the Challenge(Game) ID
        $game = $game_obj->challenge_id;
         $game_id = $game_obj->id;
        //User Company ID
        $comp_id = Yii::$app->user->identity->company_id;
        $week_no = self::getGameWeek($game_obj);
        $game_start_date_timestamp = $game_obj->challenge_start_date;
        $game_end_date_timestamp = $game_obj->challenge_end_date;
        $dayset = date('Y-m-d');
        $game_end_date_timestamp = strtotime('+1 day', $game_end_date_timestamp);
        // $game_end_date_timestamp = 1512806400;
        //Points Variables
        $total_actions = 0;
        $daily_actions = 0;
        $audio_model_actions = 0;
        $high_five_actions = 0;
        $did_you_actions = 0;
        $question_actions = 0;

        //Dynamically declare the Challenge Models
        $challenge_obj = \backend\models\PilotGameChallengeName::find()->where(['id' => $game])->one();
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $audio_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $did_you_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Knowcorner';
        $question_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Question';

        //Actions of Daily Inspiration Section
        $daily_actions = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->all();

        //Actions of Check In Section
        $high_five_actions = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->all();

        //Actions of High Five Section
        $audio_model_actions = $audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->all();

        //Actions of Corner Tips Section
        $did_you_actions = $did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->all();

        //Actions of Weekly Challenge Section
        $question_actions = $question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id,'challenge_id' => $game_id])
                ->all();
        
        //Total Points
        $total_actions = count($daily_actions) + count($audio_model_actions) + count($high_five_actions) + count($did_you_actions) + count($question_actions); 

        return $total_actions;
    }
    public static function getlearningWeeklyActions($user_id, $challenge_obj, $game, $comp_id, $week) {
        //Points Variables
        $total_actions = 0;
        $daily_actions = 0;
        $audio_model_actions = 0;
        $high_five_actions = 0;
        $did_you_actions = 0;
        $question_actions = 0;

        //Dynamically declare the Challenge Models
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $audio_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $did_you_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Knowcorner';
        $question_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Question';

        //Actions of Daily Inspiration Section
        $daily_actions = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of Check In Section
        $audio_model_actions = $audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of High Five Section
        $high_five_actions = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of Corner Tips Section
        $did_you_actions = $did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Actions of Weekly Challenge Section
        $question_actions = $question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->all();

        //Total Points
        $total_actions = count($daily_actions) + count($audio_model_actions) + count($high_five_actions) + count($did_you_actions) + count($question_actions);

        return $total_actions;
    }
    public static function getlearningUserWeeklyPoints($user, $challenge_obj, $game, $comp_id, $week) {
        $user_id = $user->id;
        //Points Variables
        $total_points = 0;
        $daily_points = 0;
        $check_in_points = 0;
        $high_five_points = 0;
        $corner_tips_points = 0;
        $weekly_points = 0;
        $share_a_win_points = 0;

        //Dynamically declare the Challenge Models
        $challenge_abr = ucfirst($challenge_obj->challenge_abbr_name);

        $daily_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Dailyinspiration';
        $high_five_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Highfive';
        $audio_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Weeklychallenge';
        $did_you_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Knowcorner';
        $question_model_name = '\frontend\\models\\PilotFront' . $challenge_abr . 'Question';

        //Points of Daily Inspiration Section
        $daily_points = $daily_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Check In Section
        $check_in_points = $audio_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of High Five Section
        $high_five_points = $high_five_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Weekly Challenge Section
        $weekly_points = $did_you_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Share A Win Section
        $share_a_win_points = $question_model_name::find()->where(['game_id' => $game, 'user_id' => $user_id, 'company_id' => $comp_id])
                ->andWhere(['<=', 'week_no', $week])
                ->sum('points');

        //Points of Fitness Steps
        $total_steps = \frontend\models\PilotFrontCoreStepsApiData::find()->where(['user_id' => $user_id])
                ->andWhere(['<=', 'week_no', $week])
                //->andWhere(['between', 'time', $week_start, $week_end])
                ->sum('steps');

        //If User reached 10K Steps
        $raffle_add = floor($total_steps / 10000);
        $steps_points = 100 * $raffle_add; //Additional 100 Points for Each 10K Steps
        //Total Points
        $total_points = $daily_points + $check_in_points + $high_five_points + $corner_tips_points + $weekly_points + $share_a_win_points + $steps_points;

        return $total_points;
    }
}
