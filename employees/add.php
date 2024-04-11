<?php
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include '../incl/header.incl.php';
include '../incl/conn.incl.php';
include '../incl/functions.php';


if ($current_user['role'] != 'Manager') {
    echo "Sorry, you are not allowed to access this module";
    exit();
}

$e_payroll_no = '';
if (isset($_POST['submitted'])) {
    foreach ($_POST AS $key => $value) {
        $_POST[$key] = mysqli_real_escape_string($conn, $value);
    }

    // Create a PHPMailer object
    $mail = new PHPMailer(true);

    // Configure PHPMailer for sending emails
    $mail->isSMTP();
    $mail->Host = 'sandbox.smtp.mailtrap.io'; // Replace with your SMTP server details
    $mail->SMTPAuth = true;
    $mail->Username = '4c43e662776cd8'; // Mailtrap username
    $mail->Password = 'f74e58193b522d'; // Mailtrap password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use SSL or TLS, depending on your SMTP server
    $mail->Port = 587; // Replace with your SMTP server port

    $mail->setFrom('christelle.kayembe@strathmore.edu', 'Your Name');
    $mail->addAddress($_POST['e_mail'], $_POST['e_name']);
    $mail->isHTML(true);
    $mail->Subject = 'Email Verification';

    // Generate the verification code
    $verificationCode = generateVerificationCode();

    $message = 'Click the following button to verify your email: <a href="http://localhost/Dairy/verification/verify_email.php?code=' . $verificationCode . '"><button btn-sm btn-primary>Verify Email</button></a>';

    $mail->Body = $message;

    // Send the email
    if ($mail->send()) {
        echo "Employee added, and a verification email has been sent.<br />";
    } else {
        echo "Error sending the verification email.<br />";
    }

    $hashed_pass = md5($_POST['e_pass']);

    $sql = "INSERT INTO `employees` (
        `e_name`,
        `e_mail`,
        `e_pass`,
        `e_role`,
        `e_payroll_no`,
        `email_verification_code`
    ) VALUES (
        '{$_POST['e_name']}',
        '{$_POST['e_mail']}',
        '{$hashed_pass}',
        '{$_POST['e_role']}',
        '{$_POST['e_payroll_no']}',
        '$verificationCode'
    )";
    
    if (mysqli_query($conn, $sql)) {
        // Send an email with the verification link
        $mail ->Subject = 'Dairy Email Verification';
        $mail->Body = '<p>Click the following button to verify your email:</p><br />';
        $mail->Body .= '<a href="http://localhost/Dairy/verification/verify_email.php?code=' . $verificationCode . '"><button btn-sm btn-primary>Verify Email</button></a>';
    
        // Create a PHPMailer instance
        $mail = new PHPMailer();
    
        // Use SMTP for sending
        $mail->isSMTP();
    
        // Replace these with your Mailtrap credentials
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Mailtrap SMTP host
        $mail->Port = 587 ; // Mailtrap SMTP port
        $mail->Username = '4c43e662776cd8'; // Mailtrap username
        $mail->Password = 'f74e58193b522d'; // Mailtrap password
    
        // Enable debugging if needed
        // $mail->SMTPDebug = 2;
    
        // Recipients
        $mail->setFrom('christelle.kayembe@strathmore.edu', 'Your Name'); // Replace with your information
        $mail->addAddress($_POST['e_mail']); // Recipient's email address
    
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Dairy Email Verification';
        $mail->Body = $message;
    
        // Try to send the email
        try {
            $mail->send();
            echo "Employee added, and a verification email has been sent.<br />";
            exit();
        } catch (Exception $e) {
            echo "Error sending the verification email: {$mail->ErrorInfo}<br />";
        }
    } else {
        echo "Error adding employee to the database.<br />";
    }
}
  
$row = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM `employees` WHERE `e_payroll_no` = '$e_payroll_no'"));
include 'form.php';

?>
