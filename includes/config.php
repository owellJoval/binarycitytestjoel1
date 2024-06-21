<?php
// Database configuration
define('DB_HOST', 'localhost');  // Database host
define('DB_USER', 'root');       // Database username
define('DB_PASS', '');           // Database password
define('DB_NAME', 'binarycitytest'); // Database name

// Try to connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
