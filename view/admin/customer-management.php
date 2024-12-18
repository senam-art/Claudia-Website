<?php
session_start(); 
include '../../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not authenticated
    header("Location: admin-login.php");
    exit;
}

// Fetch customers from the database
$customer_query = "SELECT * FROM customers";
$result = $conn->query($customer_query);

// Check if the 'status' parameter is in the URL for a success message
if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    $showMessage = true;
} else {
    $showMessage = false;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management - Claudia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/adminstyle.css">

    <script>
        window.onload = function() {
            <?php if ($showMessage) { ?>
                alert("Customer successfully deleted!"); // Show the alert
            <?php } ?>
        }
    </script>
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
                        <a class="nav-link" href="product-management.php">Product Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="order-management.php">Order Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active1" href="customer-management.php">Customer Management</a>
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
            <h1 class="my-4 page_header">Manage Customers</h1>
            <a href="#" class="btn btn-primary mb-4" onclick="openAddCustomerModal()">Add New Customer</a>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any customers
                    if ($result->num_rows > 0) {
                        $count = 1;
                        // Loop through each customer and display it in the table
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . htmlspecialchars($count) . '</td>';
                            echo '<td>' . htmlspecialchars($row['customer_id']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['fname']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['lname']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['phone']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['address']) . '</td>';
                            echo '<td>
                                    <button type="button" class="btn btn-warning btn-sm" onclick="openEditCustomerModal(' . $row['customer_id'] . ')">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteCustomer(' . $row['customer_id'] . ')">Delete</button>
                                  </td>';
                            echo '</tr>';
                            $count++;
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">No customers available</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal for Add/Edit Customer -->
        <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="customerModalLabel">Add New Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="customerForm" action="../../actions/add-customer.php" method="POST">
                            <!-- Hidden input for customer ID (for editing) -->
                            <input type="hidden" id="customer_id" name="customer_id">

                            <!-- Customer Name -->
                            <div class="row">
                                <div class="col-6 mb-3">
                                <label for="customerFName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="customerFName" name="customerFName" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="customerLName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="customerLName" name="customerLName" required>
                                </div>
                            </div>

                            <!-- Customer Email -->
                            <div class="mb-3">
                                <label for="customerEmail" class="form-label">Customer Email</label>
                                <input type="email" class="form-control" id="customerEmail" name="customer_email" required>
                            </div>

                            <!-- Customer Phone -->
                            <div class="mb-3">
                                <label for="customerPhone" class="form-label">Customer Phone</label>
                                <input type="text" class="form-control" id="customerPhone" name="customer_phone" required>
                            </div>

                            <!-- Customer Address -->
                            <div class="mb-3">
                                <label for="customer_address" class="form-label">Customer Address</label>
                                <input type="text" class="form-control" id="customer_address" name="customer_address" required>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary" id="submitBtn">Add Customer</button>
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
        function openAddCustomerModal() {
            // Reset form fields
            document.getElementById("customerForm").reset();
            document.getElementById("customer_id").value = ""; // Clear customer ID

            // Reset form attributes for adding
            document.getElementById("customerForm").action = "../../actions/add-customer.php"; // Add customer endpoint
            document.getElementById("submitBtn").innerText = "Add Customer"; // Change button text

            // Show the modal
            $('#customerModal').modal('show');
        }

        function openEditCustomerModal(customerId) {
            $.ajax({
                url: "../../actions/get-customer.php", // Endpoint to fetch customer details
                type: "GET",
                data: { id: customerId },
                success: function(response) {
                    const customer = JSON.parse(response);

                    // Check for errors in the response
                    if (customer.error) {
                        alert(customer.error);
                        return;
                    }

                    // Populate modal fields with customer data
                    document.getElementById("customer_id").value = customer.customer_id;
                    document.getElementById("customerFName").value = customer.fname;
                    document.getElementById("customerLName").value = customer.lname;
                    document.getElementById("customerEmail").value = customer.email;
                    document.getElementById("customerPhone").value = customer.phone;
                    document.getElementById("customer_address").value = customer.address;

                    // Update form attributes for editing
                    document.getElementById("customerForm").action = "../../actions/update-customer.php"; // Change action
                    document.getElementById("submitBtn").innerText = "Update Customer"; // Change button text

                    // Change the modal title and submit button text
                    document.getElementById("customerModalLabel").innerText = "Edit Customer";
                    document.getElementById("submitBtn").innerText = "Update Customer";

                    // Show the modal
                    $('#customerModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error: ' + error);
                    alert("Error fetching customer details.");
                }
            });
        }

        function confirmDeleteCustomer(customerId) {
            if (confirm('Are you sure you want to delete this customer?')) {
                // Redirect to the script in another directory
                window.location.href = '../../actions/delete-customer.php?customer_id=' + customerId;
            }
        }
    </script>
</body>

</html>
