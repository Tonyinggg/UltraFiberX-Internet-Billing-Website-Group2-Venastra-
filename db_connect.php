<?php
/**
 * Database Connection File for ConnectPH Network Business
 * XAMPP Configuration: localhost, root user, no password
 */

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "networkdb";

// Create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8 for proper character encoding
$conn->set_charset("utf8");

// Optional: Display success message for testing (remove in production)
// echo "Connected successfully to database: " . $dbname;
?>
