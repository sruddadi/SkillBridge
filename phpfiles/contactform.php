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
$subject = $_POST["subject"];
$message = $_POST["message"];

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
    $mail->addAddress("tatipallishashank@gmail.com");
    $mail->isHTML(true);
    $mail->Subject = $subject;
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

$mail = new PHPMailer();
$ref = substr(str_shuffle(str_repeat("0123456789", 12)), 0, 12);
try {
    $mail->SMTPKeepAlive = true;
    $mail->Mailer = "smtp";
    $mail->Host = "smtp.gmail.com;";
    $mail->SMTPAuth = true;
    $mail->Username = "srikar.honey123@gmail.com";
    $mail->Password = "grtl rlnr eyoz ddtw";
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->setFrom("srikar.honey123@gmail.com", "info@skillbridge.com");
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = "Re: Your Inquiry";
    $mail->Body =
        "Dear " .
        $name .
        ", <br><br> Thank you for contacting SkillBridge. We appreciate your inquiry and the opportunity to assist you.<br><br>

Your message has been received, and our team is reviewing your request. We aim to respond to your inquiry within 24-48 hours. Please note that our business hours are 9am - 5pm CST, and responses may be delayed outside of these hours.<br><br>

In the meantime, here is a reference number for your inquiry:<b>'" . $ref . "'</b>. Please use this number when communicating with us regarding this matter.<br><br> 

If you have any urgent concerns or require immediate assistance, please feel free to contact us at +1 234 123 1234 during our business hours or contactus@skillbridge.com at any time.<br><br> 

Thank you for considering SkillBridge. We look forward to assisting you.<br><br> 

Sincerely,<br>
The SkillBridge Team";

    $mail->AltBody = "Body in plain text for non-HTML mail clients";
    $mail->send();

} catch (Exception $e) {
    echo "Email not sent";
}
echo "Email Sent";
?>
