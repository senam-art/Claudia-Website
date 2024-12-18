<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
include '../../db/config.php';

// Check if the user is logged in as an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin-login.php");
    exit;
}

// Fetch contact form submissions from the database
$query = "SELECT * FROM form_fill ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submissions - Claudia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/adminstyle.css">
    <style>
        .message-column {
            max-width: 400px;
            word-wrap: break-word;
            white-space: normal;
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
                        <a class="nav-link active1" href="contact-management.php">Contact Form</a>
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

    <!-- Main Content -->
    <main>
        <div class="container">
            <h1 class="my-4 page_header">Contact Form Submissions</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="message-column">Message</th>
                        <th>Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if there are any submissions
                    if ($result->num_rows > 0) {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $count . '</td>';
                            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                            echo '<td class="message-column">' . htmlspecialchars($row['message']) . '</td>';
                            echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                            echo '</tr>';
                            $count++;
                        }
                    } else {
                        echo '<tr><td colspan="5" class="text-center">No submissions found</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
