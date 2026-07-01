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
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$role = trim($_POST['role'] ?? '');
$link = trim($_POST['link'] ?? '');
$message = trim($_POST['message'] ?? '');

// Validation
if (!$name || !$email || !$role || !$message) {
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

// Insert into DB (table name can be changed by your manager)
$sql = "INSERT INTO job_applications (name, email, phone, role, link, message)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    echo json_encode([
        "status" => "error",
        "message" => "Database error"
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "ssssss", $name, $email, $phone, $role, $link, $message);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success",
        "message" => "Application submitted successfully"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Failed to save application"
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);