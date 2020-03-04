<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader

require 'vendor/autoload.php';
 

function sendNotification($subject = "" , $name= "" , $address = "", $body = "" , $altBody ="") {

$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = getenv('MAIL_SERVER_HOST');                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = getenv('MAIL_SERVER_USERNAME');                     // SMTP username
    $mail->Password   = getenv('MAIL_SERVER_TOKEN');                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
    $mail->Port       = getenv('MAIL_SERVER_PORT');;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('from@example.com', 'Mailer');
    $mail->addAddress($address, $name);     // Add a recipient
    /* $mail->addAddress('ellen@example.com');               // Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com'); */

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    $mail->AltBody = $altBody;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

}

//function sendNotification($subject = "" , $name= "" , $address = "", $body = "" , $altBody ="") {
sendNotification( "New film has been created", "ALexander", "santari@gmail.com", "<h1>New film has been added to DB</h1>", "New film has been added to DB"); 

?>