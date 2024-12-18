<?php
// Start session if needed (optional)
session_start();

// Include the database connection
include('../db/config.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data and sanitize it
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate that required fields are not empty
    if (empty($name) || empty($email) || empty($message)) {
        echo "<script>alert('All fields are required!'); history.back();</script>";
        exit();
    }

    // Prepare an SQL query to insert data into the `form-fill` table
    $stmt = $conn->prepare("INSERT INTO `form-fill` (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>
                window.location.href = '../view/thank-you.php'; // Redirect to a thank-you page
              </script>";
    } else {
        echo "<script>alert('Error: Could not submit your message. Please try again.');</script>";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    // If the form wasn't submitted, redirect to the contact form page
    header("Location: contact.php");
    exit();
}
?>
