<?php
session_start(); // Start the session

// Check if the 'logout' parameter is set
if (isset($_GET['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../index.php"); // Redirect to login page
    exit();
}
?>