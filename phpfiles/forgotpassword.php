<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mysqli = new mysqli("sxt9335.uta.cloud", "sxt9335_skillbridge", "skillbridge@007", "sxt9335_SkillBridge");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

    $email = $_POST['email'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    
    $result = mysqli_query($mysqli, $sql);
    if ($result->num_rows != 0) {
        $row  = mysqli_fetch_array($result);
        extract($row);
        $fname = $row['first_name'];
        $lname = $row['last_name'];
        $otp = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 8)), 0, 8);
        $q1 = "UPDATE `users` SET `password`='$otp' WHERE `email`='$email'";
        if ($mysqli->query($q1) === TRUE) {
            $mail = new PHPMailer();
            try {
                $mail->SMTPKeepAlive = true;
                $mail->Mailer = 'smtp';
                $mail->Host       = 'smtp.gmail.com;';
                $mail->SMTPAuth   = true;
                $mail->Username = "tatipallishashank@gmail.com";
    $mail->Password = "kfjy gwcl madi rmnb";
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
                $mail->setFrom('tatipallishashank@gmail.com', 'info@skillbridge.com');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Request for temporary password';
                $mail->Body    = "Hi " . $fname . " " . $lname . ", <br><br> Need to reset your password? <br><br> Use your secret code! <br><br> <b>'" . $otp . "'</b><br><br> Use the above one time secret code to login to your account. <br><br> If you did not request a new password, please let us know
immediately by replying to this email. <br><br> Sincerely, <br> The SkillBridge Team";
                $mail->AltBody = 'Body in plain text for non-HTML mail clients';
                $mail->send();
                
                echo "Email Sent";
            } catch(Exception $e) {
                echo "Email not sent";
            }
        } else {
            echo "Something went wrong";
        }
    }
    else {
            echo "Not a registered user";
        }
    
?>