<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
require 'vendor/autoload.php';

// Load Composer's autoloader
// Load Composer's autoloader

// Create an instance; passing `true` enables exceptions
$phpmailer = new PHPMailer();
$phpmailer->isSMTP();
$phpmailer->Host = 'sandbox.smtp.mailtrap.io';
$phpmailer->SMTPAuth = true;
$phpmailer->Port = 2525;
$phpmailer->Username = '1369b1c4900a67';
$phpmailer->Password = '000c46aa0c3e72';
// Content format
$phpmailer->isHTML(true);                                   // Set email format to HTML
$phpmailer->CharSet = "UTF-8";
$phpmailer->setFrom('mohammadkhallaf2002@gmail.com', 'Your Name');
$phpmailer->addAddress('recipient_email@example.com', 'Recipient Name');


    // Your mail configuration and settings here

    // Send mail
    $phpmailer->send();
 
?>