<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "web_system_Finals";

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error); // log error
    die("Database connection failed. Please try again later.");
}

// Optional: Set character set to UTF-8
$conn->set_charset("utf8");

// Optional: function to safely close connection
function closeConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>
