<?php
require '../PHPMailer/PHPMailer/src/Exception.php';
require '../PHPMailer/PHPMailer/src/PHPMailer.php';
require '../PHPMailer/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
   // $mail->Host       = 'smtp.gmail.com';
    $mail->Host       = 'mail.tn.gov.in';
    $mail->SMTPAuth   = true;
//    $mail->Username   = 'arvindhramesh@gmail.com';
	    $mail->Username   = 'tansche.edu';
    //$mail->Password   = 'Jeswin722009$';
    //$mail->Password   = 'fbzh nkrw botq ndxr';
	$mail->Password   = 'TNsche_state@2025';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 25;

    $mail->setFrom('tansche.edu@tn.gov.in', 'Ramesh');
    $mail->addAddress('arvindh_ramesh@yahoo.co.in');
  $mail->isHTML(true);
  $mail->Subject='test mail';
$mail->Body    = '<p>Hello, this is a <strong>test email</strong> from Ramesh.</p>';
$mail->AltBody = 'Hello, this is a test email from Ramesh.';


    $mail->send();
    echo 'Email sent!';
} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
