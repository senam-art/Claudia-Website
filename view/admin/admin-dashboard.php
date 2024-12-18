<?php
session_start();

include '../../db/config.php';

// Check if the user is logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page if not authenticated
    header("Location: admin-login.php");
    exit;
}



$user_name = $_SESSION['username'];


// fetch data for summary cards
$total_products_query = "SELECT COUNT(*) AS total_products FROM products";
$total_users_query = "SELECT COUNT(*) AS total_customers FROM customers";
$total_orders_query = "SELECT COUNT(*) AS total_orders FROM orders";
$total_forms_query = "SELECT COUNT(*) AS total_forms FROM form_fill";

$total_products = $conn->query($total_products_query)->fetch_assoc()['total_products'];
$total_users = $conn->query($total_users_query)->fetch_assoc()['total_customers'];
$total_orders = $conn->query($total_orders_query)->fetch_assoc()['total_orders'];
$total_forms = $conn->query($total_forms_query)->fetch_assoc()['total_forms'];


$sales_data_query = "SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, SUM(total_price) AS order_amount,count(product_id) as product_count
                     FROM orders 
                     WHERE created_at >= NOW() - INTERVAL 7 MONTH
                     GROUP BY month
                     ORDER BY month";

$result = $conn->query($sales_data_query);

$months = [];
$revenues = [];
$product_count = [];

while ($row = $result->fetch_assoc()) {
    // Convert month from 'YYYY-MM' to 'Month' (e.g., '2024-01' to 'January')
    $date = DateTime::createFromFormat('Y-m', $row['month']);
    $month_name = $date->format('F'); // 'F' gives the full month name

    $months[] = $month_name;
    $revenues[] = $row['order_amount'];
    $product_count[] = $row['product_count'];
}

// Encode data for charts
$months_json = json_encode($months);
$revenues_json = json_encode($revenues);
$product_count_json = json_encode($product_count);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Claudia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Claudia Admin</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active1" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product-management.php">Product Management</a>
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
                    <p class="nav-link">Welcome, <?php echo $user_name ?></p>
                    <li class="nav-item">
                        <a class="nav-link" href="../../actions/log-out-admin.php?logout=true">Log Out</a>
                    </li>
                   
                </ul>
            </div>
        </div>
        <!-- Kente Fabric Strip -->
        <div class="kente-strip"></div>
    </nav>

    <!-- Main Content -->

    <main>
        <div class="container mt-4">
            <h1 class="my-4 page_header">Admin Dashboard</h1>
            <div class="row">
                <!-- Total Products -->
                <div class="col-md-3 col-sm-6">
                    <div class="admin-card">
                        <h5 class="card-title">Total Products</h5>
                        <p class="card-text"><?php echo $total_products; ?></p>
                    </div>
                </div>
            
                <!-- Total Users -->
                <div class="col-md-3 col-sm-6">
                    <div class="admin-card">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text"><?php echo $total_users; ?></p>
                    </div>
                </div>
            
                <!-- Total Orders -->
                <div class="col-md-3 col-sm-6">
                    <div class="admin-card">
                        <h5 class="card-title">Total Orders</h5>
                        <p class="card-text"><?php echo $total_orders; ?></p>
                    </div>
                </div>
            
                <!-- Total Form Fills -->
                <div class="col-md-3 col-sm-6">
                    <div class="admin-card">
                        <h5 class="card-title">Total Form Fills</h5>
                        <p class="card-text"><?php echo $total_forms; ?></p>
                    </div>
                </div>
            </div>
            

            <!-- Charts Row -->
            <div class="row mt-5">
                <!-- Sales Revenue Bar Chart -->
                <div class="col-md-6">
                    <canvas id="salesRevenueChart"></canvas>
                </div>
                <!-- Sales Line Chart -->
                <div class="col-md-6">
                    <canvas id="salesLineChart"></canvas>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>

            // Fetch chart data from PHP
        var chartLabels = <?php echo $months_json; ?>;
        var lineChartData = <?php echo $revenues_json; ?>;
        var barChartData = <?php echo $product_count_json?>;

        // Sales Count (Bar Chart)
        var ctx1 = document.getElementById('salesRevenueChart').getContext('2d');
        var salesRevenueChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Sales Revenue',
                    data: barChartData,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Sales count Per Month'  // This is the chart header
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Sales Line Chart (Line Chart)
        var ctx2 = document.getElementById('salesLineChart').getContext('2d');
        var salesLineChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Sales Trend',
                    data: lineChartData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Sales Per Month'  // This is the chart header
                    }
                },scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>