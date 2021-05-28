<?php


namespace app\modules\system\models\notifications;

use Yii;

/**
 * Class NotifyMail
 * @package app\models\notifications
 *
 *
 *
 */
class NotifyMail extends Notify
{
    public $subject;

    public function __construct()
    {
        $this->method = 'email';
    }

    public function send(){

        @Yii::$app->mailer->compose()
            ->setTo($this->to)
            ->setFrom(['no-reply@dokumenti.site' => $this->type])
            ->setSubject($this->subject)
            ->setTextBody($this->message)
            ->send();

        return true;

    }

    /**
     * Нужно указать 'data' (subject && body), 'to', '
     * [
     *  'to' => '',
     *  'message' => '',
     *  'subject' => '',
     *  'type' => ''
     * ]
     *
     * @param array $config
     * @return $this|mixed
     */
    public function set($config = []){

        $this->to = $config['to'];
        $this->message = $config['message'];
        $this->type = $config['type'];
        $this->subject= $config['subject'];

        return $this;
    }

    /**
     * Создание тела email сообщения;
     *
     * @param string $fileString
     * @return PHPMailer
     * @throws Exception
     */
    private function create($fileString = ''){

        if( empty($this->subject) )
            throw new Exception("Notify:: тема сообщение не задана");

        if( empty($this->message) )
            throw new Exception("Notify:: пустое сообщение");

        $site =  Main::getParams('sitename');
        $from =  Main::getParams('infoMail');

        $mail = new PHPMailer();
        $mail->From = $from;
        $mail->FromName = iconv('UTF-8','WINDOWS-1251',$site);
        $mail->Subject  = iconv('UTF-8','WINDOWS-1251',$this->subject.' '.$site);
        $mail->CharSet  = 'Windows-1251';
        $mail->SingleTo	= true;
        $mail->ContentType = 'text/html';
        $mail->SMTPDebug  = 0;
        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->Host       = Main::getParams('smtpHost'); // sets the SMTP server
        $mail->Username   = Main::getParams('smtpUsername'); // SMTP account username
        $mail->Password   = Main::getParams('smtpPassword');        // SMTP account password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;        /** https://yandex.ru/turbo/dextra.ru/s/about/forclients/mail_configuration/ */
        $mail->MsgHTML(iconv('UTF-8','WINDOWS-1251',$this->message));

        if($fileString){
            $mail->AddEmbeddedImage($fileString, 'base64', 'image/jpeg');
            //$mail->addStringAttachment($fileString, 'BanketofRU.pdf', 'base64', 'application/pdf');
        }

        return $mail;
    }
}