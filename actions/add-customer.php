<?php
session_start();
include '../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $first_name = $_POST['customerFName'];
    $last_name = $_POST['customerLName'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $customer_address = $_POST['customer_address'];


    // Ensure data is safe for database insertion
    $first_name = $conn->real_escape_string($first_name);
    $last_name = $conn->real_escape_string($last_name);
    $customer_email = $conn->real_escape_string($customer_email);
    $customer_phone = $conn->real_escape_string($customer_phone);
    $customer_address = $conn->real_escape_string($customer_address);


    // Insert customer into the database
    $insert_query = "INSERT INTO customers (fname,lname, email, phone, address)
                     VALUES ('$first_name','$last_name' ,'$customer_email', '$customer_phone', '$customer_address')";

    if ($conn->query($insert_query) === TRUE) {
        // Redirect on success
        header("Location: ../view/admin/customer-management.php");
        exit();
    } else {
        // Log database error
        error_log("Database Error: " . $conn->error, 3, "../logs/errors.log");
        echo "An error occurred while adding the customer.";
    }
}
?>
