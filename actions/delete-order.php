<?php
session_start();
include '../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

// Check if the order ID is provided via POST
if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];

    // Step 1: Fetch the order details from the database
    $query = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($row['status'] == "Cancelled") {
            // Delete the order from the database
            $delete_query = "DELETE FROM orders WHERE order_id = ?";
            $delete_stmt = $conn->prepare($delete_query);
            $delete_stmt->bind_param("i", $order_id);

            if ($delete_stmt->execute()) {
                // Check if any rows were affected by the deletion
                if ($delete_stmt->affected_rows > 0) {
                    echo json_encode(['success' => true, 'message' => 'Order deleted successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'No rows were deleted. Please ensure the order exists and is not already deleted.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error deleting order: ' . $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Cannot delete order: Order status is not "Cancelled".']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Order not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No order ID provided.']);
}
?>
