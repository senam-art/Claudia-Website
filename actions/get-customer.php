<?php
session_start();
include '../db/config.php';

if (isset($_GET['id'])) {
    $customerId = $_GET['id'];

    // Fetch the product data from the database
    $query = "SELECT * FROM customers WHERE customer_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $customer = $result->fetch_assoc();
            echo json_encode($customer); // Send back product data as JSON
        } else {
            echo json_encode(['error' => 'Customer not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the query']);
    }
} else {
    echo json_encode(['error' => 'No customer ID provided']);
}
?>
