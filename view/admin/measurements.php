<?php
session_start();
include '../../db/config.php';

// Redirect if not logged in
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../view/admin/admin-login.php");
    exit;
}

// Fetch all customers
$customer_query = "SELECT customer_id, fname, lname FROM customers";
$customers = $conn->query($customer_query);

// Fetch measurements for a selected customer
$selected_customer = null;
$measurements = null;

if (isset($_GET['customer_id'])) {
    $selected_customer = intval($_GET['customer_id']);
    $measurements_query = "SELECT * FROM measurements WHERE customer_id = ?";
    $stmt = $conn->prepare($measurements_query);
    $stmt->bind_param("i", $selected_customer);
    $stmt->execute();
    $measurements = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Measurements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link" href="order-management.php">Order Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer-management.php">Customer Management</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active1" href="measurements.php">Measurements</a>
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
        <div class="container mt-5">
            <h2>Manage Customer Measurements</h2>
            
            <!-- Dropdown to Select Customer -->
            <form method="GET" class="mb-4">
                <label for="customerDropdown" class="form-label measurements-titles">Select Customer</label>
                <select name="customer_id" id="customerDropdown" class="form-select measurements-label" required onchange="this.form.submit()">
                    <option value="">-- Select Customer --</option>
                    <?php while ($row = $customers->fetch_assoc()): ?>
                        <option value="<?php echo $row['customer_id']; ?>" 
                            <?php echo ($row['customer_id'] == $selected_customer) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>

            <!-- Measurement Form -->
            <?php if ($selected_customer): ?>
                <form method="POST" action="../../actions/save-measurements.php">
                    <input type="hidden" name="customer_id" value="<?php echo $selected_customer; ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bust" class="form-label measurements-titles">Bust</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="bust" id="bust" class="form-control measurements-label" 
                                    value="<?php echo $measurements['bust'] ?? ''; ?>">
                                <span class="input-group-text measurements-titles">cm</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="waist" class="form-label measurements-titles">Waist</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="waist" id="waist" class="form-control measurements-label" 
                                    value="<?php echo $measurements['waist'] ?? ''; ?>">
                                <span class="input-group-text measurements-titles ">cm</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hips" class="form-label measurements-titles">Hips</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="hips" id="hips" class="form-control measurements-label" 
                                    value="<?php echo $measurements['hips'] ?? ''; ?>">
                                <span class="input-group-text measurements-titles ">cm</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="height" class="form-label measurements-titles">Height</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="height" id="height" class="form-control measurements-label" 
                                    value="<?php echo $measurements['height'] ?? ''; ?>">
                                <span class="input-group-text measurements-titles ">in</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="additional_details" class="form-label measurements-titles">Additional Details</label>
                        <textarea name="additional_details" id="additional_details" class="form-control measurements-label" rows="3"><?php echo $measurements['additional_details'] ?? ''; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success measurements-titles">Save Measurements</button>
                    <?php if ($measurements): ?>
                        <a href="../../actions/delete-measurements.php?customer_id=<?php echo $selected_customer; ?>" 
                            class="btn btn-danger measurements-titles"
                            onclick="return confirm('Are you sure you want to delete the measurements?');">Delete Measurements</a>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </div>

    </main>
    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
