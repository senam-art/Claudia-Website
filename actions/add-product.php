<?php
session_start();
include '../db/config.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['username'])) {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    
    $product_price = filter_var($_POST['product_price'], FILTER_VALIDATE_FLOAT);
    if ($product_price === false) {
        echo "Invalid price format. Please enter a valid number.";
        exit();
    }

    // Handle file upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === 0) {
        $image_name = $_FILES['product_image']['name'];
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_size = $_FILES['product_image']['size'];

        if ($image_size <= 15000000) { // 15MB limit
            $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($image_ext, $allowed_ext)) {
                $new_image_name = uniqid('', true) . '.' . $image_ext;
                $image_upload_path = '../uploads/products/' . $new_image_name;

                if (move_uploaded_file($image_tmp, $image_upload_path)) {
                    // Use prepared statements
                    $stmt = $conn->prepare("INSERT INTO products (product_name, product_description, product_price, image_url) VALUES (?, ?, ?, ?)");
                    $image_path = 'uploads/products/' . $new_image_name;
                    $stmt->bind_param("ssds", $product_name, $product_description, $product_price, $image_path);

                    if ($stmt->execute()) {
                        header("Location: ../view/admin/product-management.php");
                        exit();
                    } else {
                        error_log("Database Error: " . $stmt->error, 3, "../logs/errors.log");
                        echo "An error occurred while adding the product.";
                    }
                    $stmt->close();
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid image format. Only JPG, JPEG, PNG, and GIF are allowed.";
            }
        } else {
            echo "Image size exceeds the limit (5MB).";
        }
    } else {
        echo "Error with image upload. Error code: " . $_FILES['product_image']['error'];
    }
}
?>
