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
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];
    $existing_image = $_POST['existing_image_url']; // Existing image URL

    // Check if a new image file was uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $image_name = $_FILES['product_image']['name'];
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_size = $_FILES['product_image']['size'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        // Validate image size and type
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if ($image_size <= 5000000 && in_array($image_ext, $allowed_ext)) {
            // Generate a unique name for the image
            $new_image_name = uniqid('', true) . '.' . $image_ext;
            $target_directory = '../uploads/products/';
            $target_file = $target_directory . $new_image_name;

            // Move the uploaded file
            if (move_uploaded_file($image_tmp, $target_file)) {
                // Optional: Delete the old image file
                if (!empty($existing_image) && file_exists($target_directory . $existing_image)) {
                    unlink($target_directory . $existing_image);
                }
                $final_image = $new_image_name; // Use new image
            } else {
                echo "Failed to upload the new image.";
                exit();
            }
        } else {
            echo "Invalid image. Ensure it is JPG, JPEG, PNG, GIF and under 5MB.";
            exit();
        }
    } else {
        // If no new file uploaded, keep the existing image
        $final_image = $existing_image;
    }

    // Update product details in the database
    $update_query = "UPDATE products 
                     SET product_name = ?, product_description = ?, product_price = ?, image_url = ? 
                     WHERE product_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssdsi", $product_name, $product_description, $product_price, $final_image, $product_id);

    if ($stmt->execute()) {
        header("Location: ../view/admin/product-management.php");
        exit();
    } else {
        echo "Error updating product: " . $conn->error;
    }
}
?>
