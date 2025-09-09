<?php
// Contact Form Processing Script
// This script handles the contact form submission and sends emails

// Start session for potential CSRF protection
session_start();

// Set content type
header('Content-Type: text/html; charset=UTF-8');

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function to validate email
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize form data
    $first_name = isset($_POST['first_name']) ? sanitize_input($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? sanitize_input($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';
    $terms = isset($_POST['terms']) ? $_POST['terms'] : '';
    
    // Validation
    $errors = array();
    
    // Check required fields
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!is_valid_email($email)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if (empty($message)) {
        $errors[] = "Message is required.";
    }
    
    if (empty($terms)) {
        $errors[] = "You must accept the terms and conditions.";
    }
    
    // If no errors, proceed with email sending and DB insert
    if (empty($errors)) {
        // Optional: save to database
        require_once __DIR__ . '/includes/config.php';
        if (isset($mysqli) && $mysqli instanceof mysqli && !$mysqli->connect_errno) {
            $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
            $stmt = $mysqli->prepare("CREATE TABLE IF NOT EXISTS contact_messages (\n                id INT AUTO_INCREMENT PRIMARY KEY,\n                first_name VARCHAR(80),\n                last_name VARCHAR(80),\n                email VARCHAR(160),\n                message TEXT,\n                ip VARCHAR(45),\n                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
            if ($stmt) { $stmt->execute(); $stmt->close(); }

            $stmt = $mysqli->prepare("INSERT INTO contact_messages (first_name,last_name,email,message,ip) VALUES (?,?,?,?,?)");
            if ($stmt) {
                $stmt->bind_param("sssss", $first_name, $last_name, $email, $message, $ip);
                $stmt->execute();
                $stmt->close();
            }
        }
        
        // Email configuration
        $to = "rikdanielleargarin@sentinelphils.com";
        $subject = "New Contact Form Submission - Sentinel Security Services";
        
        // Create email headers
        $headers = array();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=UTF-8";
        $headers[] = "From: " . $email;
        $headers[] = "Reply-To: " . $email;
        $headers[] = "X-Mailer: PHP/" . phpversion();
        
        // Create email body
        $email_body = "
        <html>
        <head>
            <title>New Contact Form Submission</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #2E7D32; color: white; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #2E7D32; }
                .value { margin-left: 10px; }
                .footer { background: #eee; padding: 15px; text-align: center; font-size: 12px; color: #666; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>New Contact Form Submission</h2>
                    <p>Sentinel Integrated Security Services Website</p>
                </div>
                <div class='content'>
                    <div class='field'>
                        <span class='label'>Name:</span>
                        <span class='value'>" . $first_name . " " . $last_name . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Email:</span>
                        <span class='value'>" . $email . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>Message:</span>
                        <div class='value' style='margin-top: 10px; padding: 10px; background: white; border-left: 3px solid #2E7D32;'>" . nl2br($message) . "</div>
                    </div>
                    <div class='field'>
                        <span class='label'>Submission Date:</span>
                        <span class='value'>" . date('F j, Y \a\t g:i A') . "</span>
                    </div>
                    <div class='field'>
                        <span class='label'>IP Address:</span>
                        <span class='value'>" . $_SERVER['REMOTE_ADDR'] . "</span>
                    </div>
                </div>
                <div class='footer'>
                    <p>This email was sent from the contact form on the Sentinel Integrated Security Services website.</p>
                    <p>Please respond directly to the sender's email address: " . $email . "</p>
                </div>
            </div>
        </body>
        </html>";
        
        // Try to send email (best-effort on localhost)
        $mail_sent = @mail($to, $subject, $email_body, implode("\r\n", $headers));

        if (!$mail_sent) {
            // Email failed to send - try alternative minimal headers, then proceed regardless
            $error_info = error_get_last();
            $mail_error = isset($error_info['message']) ? $error_info['message'] : 'Unknown mail error';
            error_log("Contact form mail error: " . $mail_error);

            $alt_headers = "From: noreply@sentinelphils.com\r\n";
            $alt_headers .= "Reply-To: " . $email . "\r\n";
            $alt_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $alt_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
            @mail($to, $subject, $email_body, $alt_headers);
        }

        // Always show success to the user if validation passed and DB insert attempted
        header("Location: contact.php?status=success");
        exit();
    }
    
    // If there are errors, redirect back with error messages
    if (!empty($errors)) {
        $error_string = urlencode(implode(" ", $errors));
        header("Location: contact.php?status=error&message=" . $error_string);
        exit();
    }
    
} else {
    // If not POST request, redirect to contact page
    header("Location: contact.php");
    exit();
}
?>
