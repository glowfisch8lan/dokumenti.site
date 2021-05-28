<?php


namespace app\models;


use Yii;
use yii\base\Model;
use app\modules\system\models\users\Users;

class PasswordResetRequestForm extends Model
{
  public $email;

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      ['email', 'trim'],
      ['email', 'required'],
      ['email', 'email'],
      ['email', 'exist',
        'targetClass' => '\app\modules\system\models\users\Users',
        'filter' => ['status' => Users::STATUS_ACTIVE],
        'message' => 'There is no user with such email.'
      ],
    ];
  }

  /**
   * Sends an email with a link, for resetting the password.
   *
   * @return bool whether the email was send
   */
  public function sendEmail()
  {
    /* @var $user Users */
    $user = Users::findOne([
      'status' => Users::STATUS_ACTIVE,
      'email' => $this->email,
    ]);

    if (!$user) {
      return false;
    }

    if (!Users::isPasswordResetTokenValid($user->password_reset_token)) {
      $user->generatePasswordResetToken();
      if (!$user->save()) {
        return false;
      }
    }

    return Yii::$app
      ->mailer
      ->compose('password-reset-request',
        ['user' => $user]
      )
      ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['siteName'] . ' robot'])
      ->setTo($this->email)
      ->setSubject('Сброс пароля для сайта ' . Yii::$app->params['siteName'])
      ->send();
  }

}