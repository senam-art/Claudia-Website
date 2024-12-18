<?php
session_start(); // Start the session

// // Prevent caching of the page to avoid back button issue
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Pragma: no-cache");
// header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Set a date in the past


// Check if the 'logout' parameter is set
if (isset($_GET['logout'])) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: ../view/admin/admin-login.php"); // Redirect to login page
    exit();
}
?>