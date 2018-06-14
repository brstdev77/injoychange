<?php

namespace common\models;

use Yii;
use yii\base\Model;
use frontend\models\PilotFrontUser;

/**
 * Login form
 */
class LoginForm_Front extends Model {

  // public $username;
  public $emailaddress;
  public $password;
  public $rememberMe = true;
  public $captcha;
  private $_user;

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      // username and password are both required
      //  [['username', 'password','googlecap'], 'required'],
      [['emailaddress', 'password', 'captcha'], 'required'],
      [['emailaddress'], 'email'],
      [['emailaddress'], 'checkEmail'],
      // rememberMe must be a boolean value
      ['rememberMe', 'boolean'],
      // password is validated by validatePassword()
      ['password', 'validatePassword'],
    ];
  }

  /**
   * @inheritdoc
   */
  public function attributeLabels() {
    return [
      'emailaddress' => 'Email Address',
      'passsword' => 'Passsword',
    ];
  }

  /**
   * Validates the password.
   * This method serves as the inline validation for password.
   *
   * @param string $attribute the attribute currently being validated
   * @param array $params the additional name-value pairs given in the rule
   */
  public function validatePassword($attribute, $params) {
    if (!$this->hasErrors()) {
      $user = $this->getUser();
      if (!$user || !$user->validatePassword($this->password)) {
        $this->addError($attribute, 'Incorrect username or password.');
      }
    }
  }

  /**
   * Logs in a user using the provided username and password.
   *
   * @return bool whether the user is logged in successfully
   */
  public function login() {

    if ($this->validate()) {
      return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
    }
    else {
      return false;
    }
  }

  /**
   * Checks User Exists for a Company or not
   *
   * @return bool whether the user is logged in successfully
   */
  public function checkEmail($attribute, $params) {
    $user_email = $this->emailaddress;
    //$query_params = Yii::$app->request->queryParams;
    //$comp_code = $query_params['comp'];
    
    //get compamy name from url
    $curentUrl = Yii::$app->request->hostInfo;
    $url = parse_url($curentUrl, PHP_URL_HOST);
    $explodedUrl = explode('.', $url);
    //save company name into $comp
    $comp_code = $explodedUrl[0];

    //Get the id of company
    $comp_id = PilotFrontUser::getCompanyID($comp_code);
    $user = $this->getUser();
    if (!$user || $user->company_id != $comp_id):
      $this->addError('emailaddress', 'No account exists with this email address for this game.');
    endif;
  }

  /**
   * Finds user by [[username]]
   *
   * @return User|null
   */
  protected function getUser() {
    if ($this->_user === null) {
      $this->_user = PilotFrontUser::findByEmailaddress($this->emailaddress);
    }
    return $this->_user;
  }

}
