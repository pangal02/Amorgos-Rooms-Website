<?php
session_start();

$to = $_SESSION["email"];
$subject = "Test Mail";
$message = "This is a test email sent from PHP script";
$headers = "From: dit20033@go.uop.gr";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully to ".$to;
} else {
    echo "Failed to send email to ".$to;
}
