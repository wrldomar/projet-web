<?php
// Include PHPMailer files
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panier";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idcommande'])) {
    $idcommande = intval($_POST['idcommande']); // Securely cast to integer

    try {
        // Create PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Step 1: Update the order status to 'approved'
        $stmt = $conn->prepare("UPDATE commande SET status = 'approved' WHERE idcommande = :idcommande");
        $stmt->bindParam(':idcommande', $idcommande, PDO::PARAM_INT);
        $stmt->execute();

        // Step 2: Retrieve the email of the user who made the order
        $stmt = $conn->prepare("SELECT u.email FROM commande c JOIN user u ON c.iduser = u.iduser WHERE c.idcommande = :idcommande");
        $stmt->bindParam(':idcommande', $idcommande, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Step 3: Send email to the user using PHPMailer
        if ($user) {
            $userEmail = $user['email'];  // Adjusted to match the correct column name
            $subject = "Order Status Update - Approved";
            $message = "Dear Customer,\n\nYour order has been approved and is now being processed.\n\nThank you for shopping with us!";

            // Initialize PHPMailer
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
                $mail->SMTPAuth = true;
                $mail->Username = 'mehdibenmoussa6655@gmail.com';  // Your Gmail address
                $mail->Password = 'sczx gynt vrsv qpvs';  // Your Gmail password
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('mehdibenmoussa6655@gmail.com', 'Green Harvest');
                $mail->addAddress($userEmail);  // Add recipient's email address

                // Content
                $mail->isHTML(false);  // Set email format to plain text
                $mail->Subject = $subject;
                $mail->Body    = $message;

                // Send the email
                $mail->send();
                echo 'Order approved and email sent to user.';
            } catch (Exception $e) {
                echo "Error sending email: {$mail->ErrorInfo}";
            }
        }

        // Redirect back to the order list page
        header("Location: displaycommande.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>
