<?php
// Job Application Form Processing Script
// This script handles the application form submission and sends emails with resume attachments

// Start session for potential CSRF protection
session_start();

// TEMP: Show errors for debugging blank page
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

// Function to validate file upload
function validate_file_upload($file) {
    $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    $max_size = 5 * 1024 * 1024; // 5MB
    
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return "File upload error: " . $file['error'];
    }
    
    if ($file['size'] > $max_size) {
        return "File size too large. Maximum size is 5MB.";
    }
    
    if (!in_array($file['type'], $allowed_types)) {
        return "Invalid file type. Please upload PDF, DOC, or DOCX files only.";
    }
    
    return true;
}

// Check if form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get and sanitize form data
    $name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
    $mobile = isset($_POST['mobile']) ? sanitize_input($_POST['mobile']) : '';
    $position = isset($_POST['position']) ? sanitize_input($_POST['position']) : '';
    $message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';
    
    // Validation
    $errors = array();
    
    // Check required fields
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!is_valid_email($email)) {
        $errors[] = "Please enter a valid email address.";
    }
    
    if (empty($mobile)) {
        $errors[] = "Mobile number is required.";
    }
    
    if (empty($position)) {
        $errors[] = "Position is required.";
    }
    
    // Validate file upload
    if (!isset($_FILES['resume']) || $_FILES['resume']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Resume file is required.";
    } else {
        $file_validation = validate_file_upload($_FILES['resume']);
        if ($file_validation !== true) {
            $errors[] = $file_validation;
        }
    }
    
    // If no errors, proceed with processing
    if (empty($errors)) {
        
        // Create uploads directory if it doesn't exist
        $upload_dir = 'uploads/resumes/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
        $filename = 'resume_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.' . $file_extension;
        $filepath = $upload_dir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['resume']['tmp_name'], $filepath)) {
            // Save to database (best-effort)
            require_once __DIR__ . '/includes/config.php';
            if (isset($mysqli) && $mysqli instanceof mysqli && !$mysqli->connect_errno) {
                // Ensure table exists
                $mysqli->query("CREATE TABLE IF NOT EXISTS job_applications (\n                    id INT AUTO_INCREMENT PRIMARY KEY,\n                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

                // Ensure required columns exist (handles previously created tables)
                $desiredColumns = [
                    'name' => 'VARCHAR(160)',
                    'first_name' => 'VARCHAR(120)',
                    'last_name' => 'VARCHAR(160)',
                    'email' => 'VARCHAR(160)',
                    'mobile' => 'VARCHAR(40)',
                    'position' => 'VARCHAR(160)',
                    'message' => 'TEXT',
                    'resume_path' => 'VARCHAR(255)',
                    'status' => "ENUM('new','review','done') DEFAULT 'new'"
                ];

                $existing = [];
                if ($res = $mysqli->query("SHOW COLUMNS FROM job_applications")) {
                    while ($row = $res->fetch_assoc()) { $existing[$row['Field']] = true; }
                    $res->close();
                }
                foreach ($desiredColumns as $cName => $cType) {
                    if (!isset($existing[$cName])) {
                        $mysqli->query("ALTER TABLE job_applications ADD COLUMN `{$cName}` {$cType}");
                    }
                }

                // Compute first_name / last_name from single name field
                $first_name_part = '';
                $last_name_part = '';
                $trimmed = trim($name);
                if ($trimmed !== '') {
                    $parts = preg_split('/\s+/', $trimmed);
                    if (count($parts) > 1) {
                        $last_name_part = array_pop($parts);
                        $first_name_part = implode(' ', $parts);
                    } else {
                        $first_name_part = $trimmed;
                    }
                }

                // Insert row (including split names when columns exist)
                $stmt = $mysqli->prepare("INSERT INTO job_applications (`name`,`first_name`,`last_name`,`email`,`mobile`,`position`,`message`,`resume_path`) VALUES (?,?,?,?,?,?,?,?)");
                if ($stmt) {
                    $stmt->bind_param("ssssssss", $name, $first_name_part, $last_name_part, $email, $mobile, $position, $message, $filepath);
                    $stmt->execute();
                    $stmt->close();
                }
            }
            
            // Email configuration
            $to = "rikdanielleargarin@sentinelphils.com";
            $subject = "New Job Application - " . $position . " - " . $name;
            
            // Create email body
            $email_body = "
            <html>
            <head>
                <title>New Job Application</title>
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
                        <h2>New Job Application</h2>
                        <p>Sentinel Integrated Security Services</p>
                    </div>
                    <div class='content'>
                        <div class='field'>
                            <span class='label'>Name:</span>
                            <span class='value'>" . $name . "</span>
                        </div>
                        <div class='field'>
                            <span class='label'>Email:</span>
                            <span class='value'>" . $email . "</span>
                        </div>
                        <div class='field'>
                            <span class='label'>Mobile:</span>
                            <span class='value'>" . $mobile . "</span>
                        </div>
                        <div class='field'>
                            <span class='label'>Position Applied:</span>
                            <span class='value'>" . $position . "</span>
                        </div>";
            
            if (!empty($message)) {
                $email_body .= "
                        <div class='field'>
                            <span class='label'>Message:</span>
                            <div class='value' style='margin-top: 10px; padding: 10px; background: white; border-left: 3px solid #2E7D32;'>" . nl2br($message) . "</div>
                        </div>";
            }
            
            $email_body .= "
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
                        <p>This application was submitted from the careers page on the Sentinel Integrated Security Services website.</p>
                        <p>Resume file: " . $_FILES['resume']['name'] . "</p>
                        <p>Please respond directly to the applicant's email address: " . $email . "</p>
                    </div>
                </div>
            </body>
            </html>";
            
            // Email headers
            $headers = array();
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/html; charset=UTF-8";
            $headers[] = "From: " . $email;
            $headers[] = "Reply-To: " . $email;
            $headers[] = "X-Mailer: PHP/" . phpversion();
            
            // Send email (best-effort; do not block on localhost)
            $mail_sent = @mail($to, $subject, $email_body, implode("\r\n", $headers));
            if (!$mail_sent) {
                $alt_headers = "From: noreply@sentinelphils.com\r\n";
                $alt_headers .= "Reply-To: " . $email . "\r\n";
                $alt_headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $alt_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
                @mail($to, $subject, $email_body, $alt_headers);
            }

            // Always treat as success if we reached this point
            header("Location: careers.php?status=success&message=application");
            exit();
            
        } else {
            $errors[] = "Sorry, there was an error uploading your resume. Please try again.";
        }
    }
    
    // If there are errors, redirect back with error messages
    if (!empty($errors)) {
        $error_string = urlencode(implode(" ", $errors));
        header("Location: careers.php?status=error&message=" . $error_string);
        exit();
    }
    
} else {
    // If not POST request, redirect to careers page
    header("Location: careers.php");
    exit();
}
?>
