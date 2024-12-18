<?php
session_start();
include '../db/config.php';

if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch the product data from the database
    $query = "SELECT * FROM products WHERE product_id = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            echo json_encode($product); // Send back product data as JSON
        } else {
            echo json_encode(['error' => 'Product not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['error' => 'Failed to prepare the query']);
    }
} else {
    echo json_encode(['error' => 'No product ID provided']);
}
?>
