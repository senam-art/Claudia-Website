<?php
session_start();
include '../../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not authenticated
    header("Location: admin-login.php");
    exit;
}

// Fetch orders from the database
$orders_query = "SELECT * FROM orders";
$result = $conn->query($orders_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management - Claudia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/adminstyle.css">
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
                        <a class="nav-link active1" href="order-management.php">Order Management</a>
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
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../../actions/log-out-admin.php?logout=true">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="kente-strip"></div>
    </nav>

    <main>
        <div class="container">
            <h1 class="my-4 page_header">Manage Orders</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order ID</th>
                        <th>User ID</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                        <th>Order Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($result->num_rows > 0) {
                            $count = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($count) . '</td>';
                                echo '<td>' . htmlspecialchars($row['order_id']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['customer_id']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['product_id']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                                echo '<td>GH¢ ' . number_format($row['total_price'], 2) . '</td>';
                                echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                                echo '<td>
                                        <button type="button" class="btn btn-warning btn-sm" data-order-id="' . $row['order_id'] . '" onclick="openUpdateStatusModal(' . $row['order_id'] . ')">Update Status</button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteOrder(' . $row['order_id'] . ')">Delete</button>
                                    </td>';
                                echo '</tr>';
                                $count++;
                            }
                        } else {
                            echo '<tr><td colspan="8" class="text-center">No orders available</td></tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal for Update Status -->
        <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateStatusLabel">Update Order Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <button type="button" class="btn btn-success" data-name="Completed" onclick="updateStatus(this)">Completed</button>
                        <button type="button" class="btn btn-danger" data-name="Cancelled" onclick="updateStatus(this)">Cancelled</button>
                        <button type="button" class="btn btn-warning" data-name="Confirmed" onclick="updateStatus(this)">Confirmed</button>
                    </div>
                </div>
            </div>
        </div>
        <div>
    </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var currentOrderId = null;  // Global variable to hold the current order ID for status update

        function openUpdateStatusModal(orderId) {
            // Store the order ID to be used when updating the status
            currentOrderId = orderId;
            // Show the modal
            $('#updateStatusModal').modal('show');
        }

        function updateStatus(button) {
            var status = button.getAttribute('data-name');
            var orderId = currentOrderId;  // Ensure this is set

            console.log('Order ID:', orderId);  // Log the order ID
            console.log('Status:', status);     // Log the status
            
            // Send the status update to the server using AJAX
            $.ajax({
                url: '../../actions/update-order-status.php',  // PHP script to handle the status update
                method: 'POST',
                data: {
                    order_id: orderId,
                    status: status
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.success) {
                        alert(data.message);  // Show success message
                        location.reload();  // Reload the page to reflect the changes
                    } else {
                        alert(data.message);  // Show error message
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error updating order status:', error);
                    console.error('Response Text:', xhr.responseText);  // Log the response text to check the error details
                    alert('There was an error updating the order status.');
                }
            });

            // Close the modal after the update
            $('#updateStatusModal').modal('hide');
        }


        function confirmDeleteOrder(orderId) {
            if (confirm('Are you sure you want to delete this order? Delete is allowed for only orders that are set to "cancelled"')) {
                // Send an AJAX request to delete the order from the database
                $.ajax({
                    url: '../../actions/delete-order.php',  // Endpoint for deleting the order
                    method: 'POST',
                    data: { order_id: orderId },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            alert(data.message);
                            location.reload();  // Reload the page to show updated data
                        } else {
                            alert(data.message);  // Show failure message
                        }
                    },
                    error: function() {
                        alert('Error deleting the order');
                    }
                });
            }
        }

    </script>
</body>

</html>
