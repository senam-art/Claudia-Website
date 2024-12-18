<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include '../db/config.php';

// Check if the required data is sent via POST
if (isset($_POST['order_id']) && isset($_POST['status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    // Sanitize the inputs (for security)
    $order_id = intval($order_id);
    $status = mysqli_real_escape_string($conn, $status);

    // Update the status in the database
    $update_query = "UPDATE orders SET status = '$status' WHERE order_id = $order_id";
    
    if ($conn->query($update_query) === TRUE) {
        // If successful, return a success response
        echo json_encode(['success' => true, 'message' => 'Order status updated successfully.']);
    } else {
        // If there's an error, return an error message
        echo json_encode(['success' => false, 'message' => 'Error updating the order status: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}
?>
