<?php

// Start session
session_start();

// Database connection
include '../../db/config.php'; // Ensure you have your db connection in this file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    // Prepare the SQL query to fetch the users data
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password_hash'])) {
            // Password is correct, start session and redirect to admin dashboard
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] =$row['role'];
            header('Location: admin-dashboard.php');
            exit();
        } else {
            // Invalid password
            $error = "Invalid username or password.";
        }
    } else {
        // No admin found with the given username
        $error = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Claudia</title>
    <!-- Linking to your existing styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css"> <!-- Your custom styles -->
    <link rel="stylesheet" href="../../css/authstyle.css">
</head>

<body class="bg-light" style="background-image: url('../../images/kente_strip.jpg');">
    <nav class="navbar navbar-expand-lg bg-body-tertiary custom-navbar">
        <div class="container-fluid d-flex flex-column align-items-center justify-content-center">
            <!-- Claudia Logo -->
            <a class="navbar-brand logo" href="../../index.php">claudia</a>
        </div>
    </nav>

    <!-- Admin Login Section -->
    <section class="forgot-password-section d-flex align-items-center justify-content-center vh-100">
        <div class="container">
            <div class="row justify-content-center w-100">
                <!-- Forgot Password Form -->
                <div class="col-md-6 login-side p-5 d-flex flex-column justify-content-center text-white">
                    <h2 class="text-center mb-4">Management Login</h2>
                    <h3 class="text-center mb-4">Login to your account</h3>

                    <!-- Display error message if exists -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="form-container">
                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
