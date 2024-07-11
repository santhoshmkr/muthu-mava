<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $msg = '';

    // Log the incoming POST data for debugging
    error_log(print_r($_POST, true));

    // Check if all required POST variables are set
    if (isset($_POST['name'], $_POST['email'], $_POST['phone'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'santhoshkalidoss.sellerrocket@gmail.com'; // Your Gmail username
            $mail->Password = 'xsfbigeiuzllkrck'; // Your Gmail password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->SMTPDebug = 2; // Enable detailed debug output (change to 0 for production)

            // Recipients
            $mail->setFrom('support@sellerrocket.in', 'Website');
            $mail->addAddress('santhoshmkr0723@gmail.com', 'Kannan'); // Recipient's email and name
            // Add more recipients if needed
            // $mail->addAddress('kannan@sellerrocket.in', 'Kannan');
            // $mail->addAddress('marketing@sellerrocket.in', 'Market');

            // Add reply-to
            if ($mail->addReplyTo($email, $name)) {
                // Content
                $mail->isHTML(false);
                $mail->Subject = 'Landing Page Leads';
                $mail->Body = <<<EOT
Name: {$name}
Email: {$email}
Phone: {$phone}
EOT;

                if ($mail->send()) {
                    echo "<script>alert('Email sent successfully. We will get back to you soon.');</script>";
                } else {
                    $msg = 'Mailer Error: ' . $mail->ErrorInfo;
                }
            } else {
                $msg = 'Invalid reply-to email address provided.';
            }
        } catch (Exception $e) {
            $msg = 'Mailer Error: ' . $mail->ErrorInfo;
        }
    } else {
        $msg = 'Please fill in all required fields.';
    }

    if ($msg) {
        echo "<script>alert('$msg');</script>";
    }
}
?>
