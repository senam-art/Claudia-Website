<!DOCTYPE html>
<html lang="en">

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Include your database connection file
include('../db/config.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    // If user is not logged in, redirect to login page
    header("Location: Userlogin.php");  // Change login.php to your actual login page path
    exit(); // Ensure no further code is executed after redirection
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']) ? true : false;

// Query to fetch all products from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);

// If user is logged in, fetch their details (optional)
if ($is_logged_in) {
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session
    // You can fetch user details here if needed
    // $user_query = "SELECT * FROM users WHERE user_id = $user_id";
    // $user_result = $conn->query($user_query);
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Your Custom Design - Claudia's Creations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <!-- Claudia Logo -->
            <a class="navbar-brand" href="../index.php">claudia</a>

            <!-- Toggler for smaller screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Collapsible Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#catalog">Shop Now</a>
                    </li>
                </ul>
                <!-- Login and Account Links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../actions/user-logout.php?logout=true">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Kente Fabric Strip -->
        <div class="kente-strip"></div>
    </nav>

    <section id="catalog" class="catalog-section">
        <div class="container">
            <h2 class="section-title">Choose Your Design</h2>
          
            <div class="catalog-gallery">
    
            <?php
                // Check if products are available
                if ($result->num_rows > 0) {
                    // Loop through each product and display it
                    while ($product = $result->fetch_assoc()) : ?>
                        <div class="catalog-item">
                            <a href="product-detail.php?product_id=<?php echo $product['product_id']; ?>" style="text-decoration: none; color: black">
                                <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                                <h2 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h2>
                            </a>
                        </div>
                <?php
                    endwhile;
                } else {
                    echo "<p>No products found in the catalog.</p>";
                }
            ?>

    </section>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>