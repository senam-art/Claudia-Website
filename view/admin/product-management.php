<?php
session_start(); 
include '../../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not authenticated
    header("Location: admin-login.php");
    exit;
}

// Fetch products from the database
$product_query = "SELECT * FROM products";
$result = $conn->query($product_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management - Claudia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <style>
        .description-column {
        max-width: 200px; /* Adjust width as needed */
        word-wrap: break-word; /* Ensures long words wrap */
        white-space: normal; /* Allow wrapping */
    }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="admin-dashboard.php">Claudia Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="admin-dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active1" href="product-management.php">Product Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order-management.php">Order Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer-management.php">Customer Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="measurements.php">Measurements</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact-management.php">Contact Form</a>
                    </li>
                </ul>
                <!-- Log Out -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../actions/log-out-admin.php?logout=true">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Kente Fabric Strip -->
        <div class="kente-strip"></div>
    </nav>

    <main>
        <div class="container">
            <h1 class="my-4 page_header">Manage Products</h1>
            <a href="#" class="btn btn-primary mb-4" onclick="openAddProductModal()">Add New Product</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th class="description-column">Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any products
                    if ($result->num_rows > 0) {
                        $count=1;
                        // Loop through each product and display it in the table
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($count) . '</td>';
                            echo '<td>' . htmlspecialchars($row['product_id']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                            echo '<td class="description-column">' . htmlspecialchars($row['product_description']) . '</td>';
                            echo '<td>GH¢ ' . number_format($row['product_price'], 2) . '</td>';
                            echo '<td>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditProductModal(' . $row['product_id'] . ')">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteProduct(' . $row['product_id'] . ')">Delete</button>
                                  </td>';
                            echo '</tr>';
                            $count++;
                        }
                        
                    } else {
                        echo '<tr><td colspan="5" class="text-center">No products available</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal for Add/Edit Product -->
        <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="productForm" action="../../actions/add-product.php" method="POST" enctype="multipart/form-data">
                            <!-- Hidden input for product ID (for editing) -->
                            <input type="hidden" id="product_id" name="product_id">
                            <input type="hidden" id="existing_image_url" name="existing_image_url">

                            <!-- Product Name -->
                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" rows="3" name="product_name" required>
                            </div>

                            <!-- Product Description -->
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Product Description</label>
                                <textarea class="form-control" id="productDescription" name="product_description" rows="3" required></textarea>
                            </div>

                            <!-- Product Price -->
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price</label>
                                <input type="number" class="form-control" id="productPrice" name="product_price" step="0.01" required>
                            </div>

                            <!-- Product Image -->
                            <div id="product-image" class="mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <!-- Show the existing image -->
                                <img id="existingImage" src="" alt="Existing Product Image" class="img-fluid mb-3" width="150" style="display:none;">
                                <input type="file" class="form-control" id="productImage" name="product_image" accept="image/*">
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary" id="submitBtn">Add Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openAddProductModal() {
                    // Reset form fields
            document.getElementById("productForm").reset();
            document.getElementById("product_id").value = ""; // Clear product ID
            document.getElementById("existing_image_url").value = "";
            document.getElementById("existingImage").style.display = "none";

            // Reset form attributes for adding
            document.getElementById("productForm").action = "../../actions/add-product.php"; // Add product endpoint
            document.getElementById("submitBtn").innerText = "Add Product"; // Change button text

            // Show the modal
            $('#productModal').modal('show');
        }
        function openEditProductModal(productId) {
            $.ajax({
                url: "../../actions/get-product.php", // Endpoint to fetch the product details
                type: "GET",
                data: { id: productId },
                success: function(response) {
                    console.log(response); // Log the response to the console
                    const product = JSON.parse(response);

                    // Check for errors in the response
                    if (product.error) {
                        alert(product.error);
                        return;
                    }

                    // Populate modal fields with the product data
                    document.getElementById("product_id").value = product.product_id;
                    document.getElementById("productName").value = product.product_name;
                    document.getElementById("productDescription").value = product.product_description;
                    document.getElementById("productPrice").value = product.product_price;

                     // Set existing image
                    if (product.image_url) {
                        document.getElementById("existingImage").src = "../../" + product.image_url;
                        document.getElementById("existingImage").style.display = "block"; // Show image
                        document.getElementById("existing_image_url").value = product.image_url;
                    } else {
                        document.getElementById("existingImage").style.display = "none";
                        document.getElementById("existing_image_url").value = "";
                    }
                
                    // Update form attributes for editing
                    document.getElementById("productForm").action = "../../actions/update-product.php"; // Change action
                    document.getElementById("submitBtn").innerText = "Update Product"; // Change button text


                    // Change the modal title and submit button text
                    document.getElementById("productModalLabel").innerText = "Edit Product";
                    document.getElementById("submitBtn").innerText = "Update Product";

                    // Show the modal
                    $('#productModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                    alert("Error fetching product details.");
                }
            });
        }

        function confirmDeleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                // Redirect to the script in another directory
                window.location.href = '../../actions/delete-product.php?product_id=' + productId;
            }
        }

    </script>
</body>

</html>
