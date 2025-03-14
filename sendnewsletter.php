<?php
// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require './vendor/autoload.php';

// Read JSON input from the request body
$inputJSON = file_get_contents('php://input');

// Decode JSON input into PHP array
$input = json_decode($inputJSON, true);

// Check if required fields are present
if (isset($input['email'])) {

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Retrieve form data from JSON
        $name = isset($input['name']) ? $input['name'] : '';
        $email = isset($input['email']) ? $input['email'] : '';
        $phone = isset($input['phone']) ? $input['phone'] : '';

        // Configure PHPMailer
        $mail->isSMTP(); // Send using SMTP
        $mail->Host = 'mail.ntechinvestments.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'no_reply@ntechinvestments.com'; // SMTP username
        $mail->Password = 'bEOzBrILFjBDHt'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 465; // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        // Set email recipients and content
        $mail->isHTML(true);
        $mail->setFrom("no_reply@ntechinvestments.com", $name);
        $mail->addAddress("no_reply@ntechinvestments.com"); // Add a recipient

        $mail->Subject = 'Request to Subscribe to Newsletter';
        $mail->Body = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Inquiry</title>
        </head>
        <body style="font-family: Arial, sans-serif;">
        
        <div style="max-width: 600px; margin: 0 auto;">
            <h1 style="text-align: center;">Request to Subscribe to Newsletter</h1>
            <p><strong>To Ntech Investments,</strong></p>
           <p> I hope this email finds you well. I am a frequent visitor to your website and have been enjoying the valuable content and updates you provide.</p>
           <p>I am writing to inquire about subscribing to your newsletter. I believe that receiving regular updates directly in my inbox would greatly enhance my experience with your website and keep me informed about any new developments, articles, or promotions you offer.</p>
           <p>Could you please guide me on how to subscribe to your newsletter? If there is a specific process or form I need to fill out, please provide me with the necessary steps or link.</p>
           <p>I am eager to stay connected with your platform and look forward to being part of your community through the newsletter.</p>
            <p>Thank you for your attention to this request. I appreciate your assistance and prompt response.</p>
            <p>Warm regards,</p>
            <p>' . $name . '<br>
            ' . $phone . '<br>
            ' . $email . '</p>
        </div>
        
        </body>
        </html>';
        // Send email
        $mail->send();
        // Return success status along with input data
        echo json_encode(['status' => 'success', 'data' => $input]);
    } catch (Exception $e) {
        // Return error message
        echo json_encode(['status' => 'error', 'message' => "Message could not be sent."]);
    }
} else {
    // Required fields are missing
    echo json_encode(['status' => 'error', 'message' => 'Required fields are missing']);
}
?>