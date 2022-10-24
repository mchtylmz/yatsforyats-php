<?php

namespace App\Modules;

require __DIR__ . '/PHPMailer/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use \Core\Model;
use \App\Session;
/**
 * Example Mailer model
 *
 * PHP version 7.0
 */
class Mailer
{

  public function sendDeveloper($message = '')
  {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);
    /*
    "host" => "smtp.yandex.com",
    "username" => "myagroup@yandex.com",
    "password" => "xbvyhcjawvnhgyps"
    */
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.yandex.com';                      // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'myagroup@yandex.com';                  // SMTP username
    $mail->Password   = 'xbvyhcjawvnhgyps';                     // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->setLanguage('tr');

    //Recipients
    $mail->setFrom($mail->Username, $_SERVER['HTTP_HOST']);
    $mail->addAddress('mchtylmz149@gmail.com', $_SERVER['HTTP_HOST']);     // Add a recipient

    // Content
    $mail->isHTML(false);                                  // Set email format to HTML
    $mail->Subject = 'Geri Bildirim';
    $mail->Body    = $message;

    $mail->send();
  }

  public function send($email, $subject, $message = '')
  {
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
      //Server settings
      //  $mail->SMTPDebug = 2;                   // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = site_setting('mail_host') ? site_setting('mail_host'):'mail.yatsforyats.com';
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = site_setting('mail_username') ? site_setting('mail_username'):'hello@yatsforyats.com';
      $mail->Password   = site_setting('mail_password') ? site_setting('mail_password'):'siteYacht_2021';
      $mail->SMTPSecure = site_setting('mail_secure') ? site_setting('mail_secure'):'tls';
      $mail->Port       = site_setting('mail_port') ? intval(site_setting('mail_port')):587;
      $mail->SetLanguage("tr", "phpmailer/language");
      $mail->CharSet  ="utf-8";
      $mail->Encoding ="base64";

      //Recipients
      //$mail->Username
      $mail->setFrom($mail->Username, site_setting('mail_title'));
      $mail->addAddress($email, site_setting('mail_title'));

      // settings
      if ($mail_reply = site_setting('mail_reply')) {
        $explode_mail = explode(',', $mail_reply);
        if ($explode_mail) {
          foreach ($explode_mail as $key => $exp_mail) {
            $mail->addReplyTo(trim($exp_mail), site_config('title'));
          } // foreach
        } // $explode_mail
      } // $mail_reply

      // mail
      $mail->isHTML(false);                                  // Set email format to HTML
      $mail->Subject = $subject;
      $mail->Body    = $message;

      $mail->send();

      self::logs(
        $email . ' email adresine mail gönderimi yapıldı. Mail içeriği: ' . $message
      );

      return true;
    } catch (\Exception $e) {
      return false;
    }
  }

  // logs
  private static function logs($content)
  {
    $insertArray = array(
      'table_name' => 'email',
      'content'    => $content
    );
    return \App\Models\LogsModel::add($insertArray);
  }
}
