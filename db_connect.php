<?php
// Database connection details
$servername = "localhost";  // Usually 'localhost', unless your database is on another server
$username = "root";         // Your MySQL username
$password = "";             // Your MySQL password (usually empty for localhost)
$dbname = "toys";    // Your database name

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If you want to ensure UTF-8 encoding is used:
mysqli_set_charset($conn, "utf8");

?>
