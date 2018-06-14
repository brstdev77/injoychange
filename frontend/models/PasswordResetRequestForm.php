<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use frontend\models\PilotFrontUser;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model {

  public $emailaddress;
  public $captcha;

  /**
   * @inheritdoc
   */
  public function rules() {
    return [
      ['emailaddress', 'trim'],
      ['emailaddress', 'required'],
      ['emailaddress', 'email'],
      ['captcha', 'required'],
      ['emailaddress', 'exist',
        'targetClass' => '\frontend\models\PilotFrontUser',
        'filter' => ['status' => PilotFrontUser::STATUS_ACTIVE],
        'message' => 'There is no user with this email address.'
      ],
    ];
  }

  public function attributeLabels() {
    return [

      'emailaddress' => 'Email Address',
    ];
  }

  /**
   * Sends an email with a link, for resetting the password.
   *
   * @return bool whether the email was send
   */
  public function sendEmail() {
    /* @var $user PilotFrontUser */
    $user = PilotFrontUser::findOne([
          'status' => PilotFrontUser::STATUS_ACTIVE,
          'emailaddress' => $this->emailaddress,
    ]);

    if (!$user) {
      return false;
    }

    if (!PilotFrontUser::isPasswordResetTokenValid($user->password_reset_token)) {
      $user->generatePasswordResetToken();
      if (!$user->save(false)) {
        return false;
      }
    }

    $resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/reset-password', 'token' => $user->password_reset_token]);
    $email_message = 'Hello ' . $user->username . '<br><br>';
    $email_message .='Follow the link below to reset your password:<br><br>';
    $email_message .= '<a href=' . $resetLink . '>' . $resetLink . '</a><br><br>';
    $email_message .= 'Kindly Regards<br>';
    $email_message .= 'Injoy Team<br>';

    return Yii::$app
            ->mailer
            ->compose()
            ->setFrom([Yii::$app->params['supportEmail'] => ' Injoy'])
            ->setTo($user->emailaddress)
            ->setSubject('Password reset for InjoyChange')
            ->setHtmlBody($email_message)
            ->send();


//    return Yii::$app
//            ->mailer
//            ->compose(
//                ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], ['user' => $user]
//            )
//            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
//            ->setTo($user->emailaddress)
//            ->setSubject('Password reset for InjoyGlobal')
//            ->send();
  }

}
