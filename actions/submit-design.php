<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Include the database connection file
include('../db/config.php');

// Set the maximum file size (in bytes, 15MB in this case)
define('MAX_FILE_SIZE',15000000);  // 15MB

// Check if the user is logged in (ensure customer_id exists in the session)
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Get customer_id from session
$customer_id = $_SESSION['user_id'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $bust = $_POST['bust'];
    $waist = $_POST['waist'];
    $hips = $_POST['hips'];
    $height = $_POST['height'];
    $additionalInfo = $_POST['additionalInfo'];
    $quantity = $_POST['quantity'];  // Added quantity from the form
    $product_id = $_POST['product_id'];  // Get product_id from the form

    // Handle file upload (if a file was uploaded)
    $file = $_FILES['measurements'];

    // Set up variables for file upload
    $file_name = null;
    $file_path = null;

    // Check if file is uploaded and there is no error
    if ($file && $file['error'] == 0) {
        // Check if the file size is within the allowed limit
        if ($file['size'] > MAX_FILE_SIZE) {
            echo "File size exceeds the maximum limit of 15MB.";
            exit();
        }

        // Set the file path (you can change the folder name as needed)
        $upload_dir = '../uploads/submissions';
        $file_name = basename($file['name']);
        $file_path = $upload_dir . '/' . $file_name;

        // Move the uploaded file to the server folder
        if (!move_uploaded_file($file['tmp_name'], $file_path)) {
            echo "File upload failed.";
            exit();
        }
    }

    // Check if the customer already has a submission in the 'measurements' table
    $stmt = $conn->prepare("SELECT * FROM measurements WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If a record exists, update it; otherwise, insert a new record
    if ($result->num_rows > 0) {
        // Update the existing record in measurements table
        $stmt = $conn->prepare("UPDATE measurements SET bust = ?, waist = ?, hips = ?, height = ?, additional_details = ?, image_url = ?, updated_at = NOW() WHERE customer_id = ?");
        $stmt->bind_param("dddddsi", $bust, $waist, $hips, $height, $additionalInfo, $file_name, $customer_id);
    } else {
        // Insert a new record in measurements table
        $stmt = $conn->prepare("INSERT INTO measurements (customer_id, bust, waist, hips, height, additional_details, image_url) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("idddsss", $customer_id, $bust, $waist, $hips, $height, $additionalInfo, $file_name);
    }

    // Execute the measurements table statement
    if ($stmt->execute()) {
        // Now update or insert into the 'orders' table
        // Check if there's already an existing order for this customer and product
        $stmt = $conn->prepare("SELECT * FROM orders WHERE customer_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $customer_id, $product_id);
        $stmt->execute();
        $order_result = $stmt->get_result();

        if ($order_result->num_rows > 0) {
            // Update the existing order
            $stmt = $conn->prepare("UPDATE orders SET quantity = ?, updated_at = NOW() WHERE customer_id = ? AND product_id = ?");
            $stmt->bind_param("iii", $quantity, $customer_id, $product_id);
        } else {
            // Insert a new order
            // Calculate the total price (assuming you have a price field in the products table)
            $stmt = $conn->prepare("SELECT product_price FROM products WHERE product_id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $product_result = $stmt->get_result();
            $product = $product_result->fetch_assoc();
            $total_price = $product['product_price'] * $quantity;

            $stmt = $conn->prepare("INSERT INTO orders (customer_id, product_id, quantity, total_price, status) 
                                    VALUES (?, ?, ?, ?, 'Pending')");
            $stmt->bind_param("iiid", $customer_id, $product_id, $quantity, $total_price);
        }

        // Execute the orders table statement
        if ($stmt->execute()) {
            // Success, show the alert and redirect to the details page
            echo "<script>
                    alert('Design request submitted successfully!');
                    window.location.href = '../view/product-detail.php?product_id=" . $product_id . "';
                  </script>";
            exit();
        } else {
            // Handle SQL errors for orders table
            echo "Error: " . $stmt->error;
        }
    } else {
        // Handle SQL errors for measurements table update/insert
        echo "Error: " . $stmt->error;
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If the form wasn't submitted, redirect or show an error
    echo "Invalid request.";
}
?>
