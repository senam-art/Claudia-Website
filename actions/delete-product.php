<?php
session_start();
include '../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

// Check if the product ID is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Step 1: Fetch the image name from the database
    $query = "SELECT image_url FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $image_name = $row['image_url'];
        $image_path = "../uploads/products/" . $image_name;

        // Delete the product from the database
        $delete_query = "DELETE FROM products WHERE product_id = ?";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bind_param("i", $product_id);

        if ($delete_stmt->execute()) {
            // Step 2: Delete the image file (if it exists)
            if (!empty($image_name) && file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }

            // Redirect back to product management page
            header("Location: ../view/admin/product-management.php?status=deleted");
            exit();
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    } else {
        echo "Product not found.";
    }
} else {
    echo "No product ID provided.";
}
?>
