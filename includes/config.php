<?php
// Database connection (MySQL via mysqli)
// Adjust credentials as needed for your local XAMPP/phpMyAdmin setup
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'sentinel_site';

$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
if ($mysqli->connect_errno) {
    // Fail quietly to user-facing pages; log minimal info
    error_log('DB connection failed: ' . $mysqli->connect_error);
    // Do not echo raw errors to end users
}

if ($mysqli && !$mysqli->connect_errno) {
    $mysqli->set_charset('utf8mb4');
}
?>

