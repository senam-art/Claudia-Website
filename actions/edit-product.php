<?php
session_start();
include '../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $customer_id = $_POST['customer_id'];
    $first_name = $_POST['customerFName'];
    $last_name = $_POST['customerLName'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $customer_address = $_POST['customer_address'];

    // Ensure data is safe for database insertion
    $first_name= $conn->real_escape_string($first_name);
    $last_name= $conn->real_escape_string($last_name);
    $customer_email = $conn->real_escape_string($customer_email);
    $customer_phone = $conn->real_escape_string($customer_phone);
    $customer_address = $conn->real_escape_string($customer_address);

    // Update customer details in the database
    $update_query = "UPDATE customers 
                     SET fname = ?,lname = ?,, email = ?, phone = ?,  address = ? 
                     WHERE customer_id = ?";
    
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $first_name,$last_name, $customer_email, $customer_phone,$customer_address, $customer_id);

    if ($stmt->execute()) {
        // Redirect to customer management page on success
        header("Location: ../view/admin/customer-management.php");
        exit();
    } else {
        echo "Error updating customer: " . $conn->error;
    }
}
?>
