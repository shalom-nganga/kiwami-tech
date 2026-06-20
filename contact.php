<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("X-Debug-Test: hello123");
// Database credentials
$servername = "localhost";     // Use your server name, e.g., "localhost"
$username = "jewaprop_tenants";   // Your MySQL username
$password = "J@m!!8.net";   // Your MySQL password
$dbname = "jewaprop_kiwami";     // Your database name

// DB_HOST=localhost
// DB_PORT=3306
// DB_DATABASE=jewaprop_commercial
// DB_USERNAME=jewaprop_tenants
// DB_PASSWORD=J@m!!8.net
// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);

}
  date_default_timezone_set('Africa/Nairobi');
             $date_created = date('Y-m-d H:i');
             

    // $value1 = $_POST['Token'];
// $value1 ="hjh";
    // Prepare the SQL statement
//   $value1 = $conn->real_escape_string($value1);  // Sanitize input to prevent SQL injection
$name= isset($_POST['name']) ? $_POST['name'] : 'wa';
$email= isset($_POST['email']) ? $_POST['email'] : 'wa';
$subject = isset($_POST['subject']) ? $_POST['subject'] : 'wa';
$message = isset($_POST['message']) ? $_POST['message'] : 'wa';


    // Create the SQL query
    $sql = "INSERT INTO comments (name,email,subject,message,created_at) VALUES ('$name','$email','$subject','$message','$date_created')";
    
    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $conn->error;
    }

//     // Close the statement and connection
//     $stmt->close();
// } else {
//     echo "Invalid request method.";
// }

$conn->close();
?>
