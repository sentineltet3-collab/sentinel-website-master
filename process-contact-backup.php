<?php
// Backup Contact Form Processing Script
// This script handles the contact form submission with alternative email methods

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
    
    // If no errors, proceed with email sending
    if (empty($errors)) {
        
        // Email configuration
        $to = "rikdanielleargarin@sentinelphils.com";
        $subject = "New Contact Form Submission - Sentinel Security Services";
        
        // Create email body (plain text version for better compatibility)
        $email_body = "New Contact Form Submission\n";
        $email_body .= "==========================\n\n";
        $email_body .= "Name: " . $first_name . " " . $last_name . "\n";
        $email_body .= "Email: " . $email . "\n";
        $email_body .= "Message:\n" . $message . "\n\n";
        $email_body .= "Submission Date: " . date('F j, Y \a\t g:i A') . "\n";
        $email_body .= "IP Address: " . $_SERVER['REMOTE_ADDR'] . "\n\n";
        $email_body .= "This email was sent from the contact form on the Sentinel Integrated Security Services website.\n";
        $email_body .= "Please respond directly to the sender's email address: " . $email . "\n";
        
        // Try multiple email methods
        $email_sent = false;
        
        // Method 1: Simple mail with minimal headers
        $headers1 = "From: " . $email . "\r\n";
        $headers1 .= "Reply-To: " . $email . "\r\n";
        
        if (mail($to, $subject, $email_body, $headers1)) {
            $email_sent = true;
        }
        
        // Method 2: Try with different From address
        if (!$email_sent) {
            $headers2 = "From: noreply@sentinelphils.com\r\n";
            $headers2 .= "Reply-To: " . $email . "\r\n";
            
            if (mail($to, $subject, $email_body, $headers2)) {
                $email_sent = true;
            }
        }
        
        // Method 3: Try with webmaster@localhost
        if (!$email_sent) {
            $headers3 = "From: webmaster@localhost\r\n";
            $headers3 .= "Reply-To: " . $email . "\r\n";
            
            if (mail($to, $subject, $email_body, $headers3)) {
                $email_sent = true;
            }
        }
        
        if ($email_sent) {
            // Success - redirect back to contact page with success message
            header("Location: contact.php?status=success");
            exit();
        } else {
            // All email methods failed - provide alternative contact method
            $errors[] = "Sorry, there was an error sending your message. Please contact us directly at services@sentinelphils.com or call +(632) 8896-4169";
        }
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
