<?php
header("Access-Control-Allow-Origin: *");
header(
    "Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept"
);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

$name = $_POST["name"];
$email = $_POST["email"];
$message = $_POST["feedback"];

$mail = new PHPMailer();
try {
    $mail->SMTPKeepAlive = true;
    $mail->Mailer = "smtp";
    $mail->Host = "smtp.gmail.com;";
    $mail->SMTPAuth = true;
    $mail->Username = "tatipallishashank@gmail.com";
    $mail->Password = "kfjy gwcl madi rmnb";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->setFrom("tatipallishashank@gmail.com", "info@skillbridge.com");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Re: Your Feedback";
    $mail->Body =
        "Name: " .
        $name .
        "<br><br> Email: " .
        $email .
        "<br><br> Message: " .
        $message;

    $mail->AltBody = "Body in plain text for non-HTML mail clients";
    $mail->send();

} catch (Exception $e) {
    echo "Email not sent";
}

echo "Email Sent";
?>
