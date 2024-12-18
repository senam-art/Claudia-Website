<?php
// Database connection
include '../db/config.php'; // Ensure this file contains your connection settings

// Check if the connection is successful
if ($conn->connect_error) {
    // If connection fails, display an error message
    die("Connection failed: " . $conn->connect_error);
} else {
    // If connection is successful
    echo "Connection successful!";
}
?>