<?php
use PHPMailer\PHPMailer\PHPMailer;
require_once 'vendor/autoload.php';
require_once 'authController.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'noreply.lite@gmail.com';
$mail->Password = '2xype{Z3,%{$Yxr.';

    function sendVerificationEmail($userEmail, $token)
    {
        $mail->setFrom('noreply.lite@gmail.com', 'No-Reply Lite');
        $mail->addAddress($email, $username);
        $mail->Subject = 'V&eacute;rifier votre courriel';
        $mail->msgHTML(file_get_contents('message.html'), __DIR__);
    }

if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'The email message was sent.';
}
?>
