<?php
$servername = "localhost";
$username = "root";  // Default username
$password = "";      // Default password
$dbname = "userdb";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>