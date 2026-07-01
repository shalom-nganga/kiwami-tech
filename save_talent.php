<?php
header('Content-Type: application/json');
require_once 'db_connect.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method"
    ]);
    exit;
}

// Get data
$company = trim($_POST['company'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$talent = trim($_POST['talent'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
if (!$company || !$email || !$talent || !$message) {
    echo json_encode([
        "status" => "error",
        "message" => "Missing required fields"
    ]);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email address"
    ]);
    exit;
}

// Insert into DB
$sql = "INSERT INTO talent_requests (company, email, phone, talent, message)
        VALUES (?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error"
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sssss", $company, $email, $phone, $talent, $message);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success",
        "message" => "Request sent successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save request"
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);