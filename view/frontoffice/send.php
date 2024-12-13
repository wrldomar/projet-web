
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php'; 

if (isset($_POST["send"])) {
    try {
        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = 2; 
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'itzhoucem@gmail.com';
        $mail->Password = 'nppl uecx qtmp bwiv';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('itzhoucem@gmail.com');
        $mail->addAddress($_POST["email"]);
        $mail->isHTML(true);
        $mail->Subject = $_POST["subject"];
        $mail->Body = $_POST["message"];

        $mail->send();

        echo '
        <script>
        alert("Mail sent successfully!");
        window.location.href = "mail.php";
        </script>
        ';
    } 
    catch (Exception $e) {
        echo '
        <script>
        alert("Mail could not be sent. Error: ' . $mail->ErrorInfo . '");
        window.location.href = "mail.php";
        </script>
        ';
    }
}

?>
