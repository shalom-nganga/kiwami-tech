<?php

header('Content-Type: application/json');

require_once 'db_connect.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request."
    ]);
    exit;
}

// Ensure database connection is available
if (!isset($conn) || !$conn) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection not available."
    ]);
    exit;
}

// Honeypot check
if (!empty($_POST['website'])) {
    echo json_encode([
        "status" => "error",
        "message" => "Spam detected."
    ]);
    exit;
}

// Get form data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode([
        "status" => "error",
        "message" => "Please fill in all required fields."
    ]);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "Please enter a valid email address."
    ]);
    exit;
}

// Prepare SQL
$sql = "INSERT INTO `contact us` (name, email, subject, message)
        VALUES (?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error."
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $subject, $message);

if (mysqli_stmt_execute($stmt)) {

    echo json_encode([
        "status" => "success",
        "message" => "Your message has been sent successfully."
    ]);

} else {

    echo json_encode([
        "status" => "error",
        "message" => "Failed to save your message."
    ]);

}

mysqli_stmt_close($stmt);
mysqli_close($conn);