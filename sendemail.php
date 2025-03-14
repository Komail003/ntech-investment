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
        $companyName = isset($input['company_name']) ? $input['company_name'] : '';
        $country = isset($input['country']) ? $input['country'] : '';
        $contactNumber = isset($input['contact_number']) ? $input['contact_number'] : '';
        $email = isset($input['email']) ? $input['email'] : '';
        $contactInfo = isset($input['contact_info']) ? $input['contact_info'] : '';
        $message = isset($input['message']) ? $input['message'] : '';

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

        $mail->Subject = 'New Client Inquiry';
        $mail->Body = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Inquiry</title>
        </head>
        <body style="font-family: Arial, sans-serif;">
        
        <div style="max-width: 600px; margin: 0 auto;">
            <h1 style="text-align: center;">Inquiry Regarding Further Details and Collaboration Opportunity</h1>
            <p><strong>To Ntech Investments,</strong></p>
            <p>I hope this email finds you well. My name is ' . $name . ' and I am reaching out to you on behalf of ' . $companyName . '. We recently came across your website and were impressed by the services you offer.</p>
            <p>Would it be possible for you to schedule a call or meeting at your earliest convenience? We are flexible with timing and are willing to accommodate your schedule.</p>
            <p><strong>Message:</strong></p>
            <p>' . $message . '</p>
            <p>Please follow up with the client at your earliest convenience to address their inquiry.</p>
            <p>Warm regards,</p>
            <p>' . $name . '<br>
            ' . $contactNumber . '<br>
            ' . $companyName . '<br>
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