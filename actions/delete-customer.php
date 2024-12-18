<?php
session_start();
include '../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

// Check if the customer ID is provided
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];

    // Prepare the deletion query
    $delete_query = "DELETE FROM customers WHERE customer_id = ?";
    $delete_stmt = $conn->prepare($delete_query);
    $delete_stmt->bind_param("i", $customer_id);

    // Execute the query
    if ($delete_stmt->execute()) {
        // Redirect to customer management page with a success message
        header("Location: ../view/admin/customer-management.php?status=deleted");
        exit();
    } else {
        echo "Error deleting customer: " . $conn->error;
    }
} else {
    echo "No customer ID provided.";
}
?>

