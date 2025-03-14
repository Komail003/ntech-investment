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
        $name = $input['name'];
        $companyName = $input['companyNname'];
        $address = $input['address'];
        $phone = $input['phone'];
        $email = $input['email'];
        $socialmedia = $input['socialmedia'];
        $accountType = $input['accounttype'];
        $subject = $input['subject'];
        $summaryissue = $input['summaryissue'];

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

        $mail->Subject = 'Technical Support';
        $mail->Body = '<!DOCTYPE html>
        <html lang="en">
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Inquiry</title>
        </head>
        <body style="font-family: Arial, sans-serif;">
        
        <div style="max-width: 600px; margin: 0 auto;">
            <h1 style="text-align: center;"> Technical Support</h1>
            <p><strong>To Ntech Investments,</strong></p>
I hope this email finds you well. I am writing to request technical support regarding an issue I encountered while using you services.

I have attempted to troubleshoot the issue on my own , but unfortunately, I have been unable to resolve it.

<p> Summary of the issue : ' . $summaryissue . '</p>
Could you please assign a technician to investigate this matter and provide guidance on how to rectify the issue? If additional information or access to our system is needed, please let me know, and I will provide it promptly.
Thank you in advance for your attention to this matter. I look forward to your prompt response and resolution of the issue.            <p>Please follow up with the client at your earliest convenience to address their inquiry.</p>
            <p>Warm regards,</p>
            <p>' . $name . '<br>
            ' . $phone . '<br>
            ' . $companyName . '<br>
            ' . $accountType . '<br>
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