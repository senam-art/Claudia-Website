<?php
// Start session
session_start();

// Database connection
include '../db/config.php'; // Ensure you have your db connection in this file



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    

    // Prepare the SQL query to fetch the users data
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // User found
        $row = $result->fetch_assoc();
        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Password is correct, start session and redirect to admin dashboard
            $_SESSION['user_id'] = $row['customer_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            header('Location: ../index.php');
            exit();
        } else {
            // Invalid password
            $error = "Invalid username or password.";
        }
    } else {
        // No customer found with the given username
        $error = "Account does not exist";
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
    <title>Login & Sign Up - Claudia</title>
    <!-- Linking to your existing styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="stylesheet" href="../css/authstyle.css">
    <style>
        body {
            background-image: url('/images/background3.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .login-section {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-body-tertiary custom-navbar">
        <div class="container-fluid d-flex flex-column align-items-center justify-content-center">
            <!-- Claudia Logo -->
            <a class="navbar-brand" href="../index.php">claudia</a>
            <!-- Kente Fabric Strip -->
            <div class="kente-strip"></div>
    </nav>

    <main>
        <!-- Login Section -->
        <section class="login-section d-flex align-items-center justify-content-end vh-100">
            <div class="login-container">
                <div class="row w-100">
                    <!-- Right side: Login Form -->
                    <div class="col-md-10 login-side p-5 d-flex flex-column justify-content-center text-white">
                        <h2 class="text-center mb-4">Welcome Back</h2>
                        <h3 class="text-center mb-4">Login to your account</h3>
                         <!-- Error Message Section: Display only after submission -->
                         <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <li><?php echo $error; ?></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form method="POST" class="form-container">
                            <div class="mb-3">
                                <label for="username" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <!-- <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Remember me</label>
                            </div> -->
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                        <div class="mt-3 text-center">
                            <a href="forgot-password.html" class="text-decoration-none">Forgot your password?</a>
                        </div>
                        <div class="text-center mt-4 brown-button">
                            <a href="signup.php" class="btn w-100 ">New to Claudia?<br> Create an
                                Account</a>
                        </div>
                    </div>
                    <!-- Left side: Background or Empty -->
                    <div class="col-md-6 bg-image d-none d-md-block">
                    </div>
                </div>
            </div>
        </section>
    </main>


    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>