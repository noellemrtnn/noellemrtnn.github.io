<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Adjust this path

// Validate and sanitize input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = clean_input($_POST['name']);
    $email = filter_var(clean_input($_POST['email']), FILTER_VALIDATE_EMAIL);
    $subject = clean_input($_POST['subject']);
    $message = clean_input($_POST['message']);

    if (!$email) {
        die("Invalid email format.");
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = '## // Use an environment variable
        $mail->Password = '$$'; // Use an App Password instead of the real one
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Content
        $mail->setFrom($email, $name);
        $mail->addAddress('recipient@example.com'); 
        $mail->Subject = $subject;
        $mail->Body = "From: $name\nEmail: $email\n\nMessage:\n$message";

        if ($mail->send()) {
            echo "Message sent successfully.";
        } else {
            echo "Failed to send message.";
        }
    } catch (Exception $e) {
        echo "Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
