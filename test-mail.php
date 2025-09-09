<?php
// Simple mail test to check if server mail function is working
echo "<h2>Mail Function Test</h2>";

// Check if mail function exists
if (function_exists('mail')) {
    echo "<p>✅ Mail function exists</p>";
} else {
    echo "<p>❌ Mail function does not exist</p>";
    exit;
}

// Test basic mail sending
$to = "rikdanielleargarin@sentinelphils.com";
$subject = "Test Email from Website";
$message = "This is a test email to check if the mail function is working.";
$headers = "From: noreply@sentinelphils.com\r\n";

echo "<p>Attempting to send test email...</p>";

$result = mail($to, $subject, $message, $headers);

if ($result) {
    echo "<p>✅ Test email sent successfully!</p>";
} else {
    echo "<p>❌ Test email failed to send</p>";
    
    // Get error information
    $error_info = error_get_last();
    if ($error_info) {
        echo "<p>Error details: " . $error_info['message'] . "</p>";
    }
    
    echo "<h3>Possible Solutions:</h3>";
    echo "<ul>";
    echo "<li>Check if your hosting provider has mail services enabled</li>";
    echo "<li>Contact your hosting provider to enable SMTP</li>";
    echo "<li>Consider using a third-party email service like SendGrid or Mailgun</li>";
    echo "<li>Use PHP's PHPMailer library for better email handling</li>";
    echo "</ul>";
}

// Check PHP mail configuration
echo "<h3>PHP Mail Configuration:</h3>";
echo "<p>SMTP: " . ini_get('SMTP') . "</p>";
echo "<p>SMTP Port: " . ini_get('smtp_port') . "</p>";
echo "<p>Sendmail Path: " . ini_get('sendmail_path') . "</p>";
?>
