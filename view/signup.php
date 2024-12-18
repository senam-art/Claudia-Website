<?php
include '../db/config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session to store errors
session_start();

// Assume this array will hold the errors
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $confirmPassword = $_POST['confirmPassword'];

    // Backend Validation for each field
    if (empty($fname)) {
        $errors['fname'] = "First Name is required.";
    }

    if (empty($lname)) {
        $errors['lname'] = "Last Name is required.";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    // Check if email already exists
    if (empty($errors)) {
        $emailCheckQuery = "SELECT * FROM customers WHERE email = '$email'";
        $result = mysqli_query($conn, $emailCheckQuery);

        if (mysqli_num_rows($result) > 0) {
            $errors['email'] = "Email is already registered.";
        }
    }

    if (empty($username)) {
        $errors['username'] = "Username is required.";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } elseif ($password !== $confirmPassword) {
        $errors['confirmPassword'] = "Passwords do not match.";
    }

    // If there are no errors, process the form (e.g., save to database)
    if (empty($errors)) {
        // Hash the password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        //insert into db
        $insertQuery = "INSERT INTO customers (fname, lname, email, username, phone, address, password) VALUES ('$fname', '$lname', '$email','$username', '$phone' ,'$address', '$hashedPassword')";

        if (mysqli_query($conn, $insertQuery)) {
            // Account created successfully, redirect using JavaScript
            echo "<script>
                    alert('Account created successfully!');
                    window.location.replace('welcome.php'); // Redirect to a welcome or login page
                  </script>";
            exit; // Stop further execution of PHP code after redirect
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
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
    <link rel="stylesheet" href="../css/style.css"> <!-- Your custom styles -->
    <link rel="stylesheet" href="../css/authstyle.css">
    <style>
        body {
            background: linear-gradient(135deg,#c0c4b5,#282a20, #000000);
            background-size: fit;
            background-position: center;
            background-repeat: no-repeat;
        }
        .error-message {
            color: #ff6b6b;
            font-size: 0.9em;
            margin-top: 5px;
        }

        .is-invalid {
            border: 2px solid #ff6b6b; /* Red border */
            outline: none;
        }
    </style>
</head>

<body class="bg-dark">
    <nav class="navbar navbar-expand-lg bg-body-tertiary custom-navbar">
        <div class="container-fluid d-flex flex-column align-items-center justify-content-center">
            <a class="navbar-brand" href="../index.php">claudia</a>
        </div>
    </nav>
    <main>
        <section class="login-section d-flex align-items-center justify-content-center vh-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5 login-side p-4 d-flex flex-column justify-content-center text-white">
                        <h2 class="text-center mb-3">Create Your Account</h2>
                        <h3 class="text-center mb-3">Sign up to get started</h3>
                          <!-- Success Message Section -->
                          <?php if (!empty($successMessage)): ?>
                            <div class="alert alert-success">
                                <?php echo $successMessage; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Error Message Section: Display only after submission -->
                        <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo $error; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="" method="POST" id="signupForm" class="form-container">
                            <!-- First and Last Name -->
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="firstName" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                                </div>
                            </div>

                            <!-- Email and Username -->
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email"  name="email" required>
                                    <div class="error-message"></div>
                                </div>

                                <div class="col-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"  required>
                                    <div class="error-message"></div>
                                </div>
                            </div>

                            <!-- Phone and Address -->
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <div class="error-message"></div>
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                <div class="error-message"></div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                        </form>

                        <div class="mt-3 text-center">
                            <a href="Userlogin.php" class="text-decoration-none">Already have an account? Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2024 Claudia | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("signupForm");

            // Input Fields
            const firstName = document.getElementById("firstName");
            const lastName = document.getElementById("lastName");
            const email = document.getElementById("email");
            const username = document.getElementById("username");
            const password = document.getElementById("password");
            const phone = document.getElementById("phone");
            const address = document.getElementById("address");
            const confirmPassword = document.getElementById("confirmPassword");

            // Validation Rules
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{6,}$/;

            // Helper to Show Error
            function showError(input, message) {
                const errorDiv = input.nextElementSibling;
                input.classList.add("is-invalid");
                errorDiv.textContent = message;
            }

            // Helper to Clear Error
            function clearError(input) {
                const errorDiv = input.nextElementSibling;
                input.classList.remove("is-invalid");
                errorDiv.textContent = "";
            }

            // Field Validation Functions
            function validateEmail() {
                if (!emailRegex.test(email.value)) {
                    showError(email, "Please enter a valid email address.");
                } else {
                    clearError(email);
                }
            }

          
            function validatePassword() {
                if (!passwordRegex.test(password.value)) {
                    showError(password, "Password must be at least 6 characters, include 1 uppercase, 1 lowercase letter, and 1 number.");
                } else {
                    clearError(password);
                }
            }

            function validateConfirmPassword() {
                if (password.value !== confirmPassword.value) {
                    showError(confirmPassword, "Passwords do not match.");
                } else {
                    clearError(confirmPassword);
                }
            }

            // Real-Time Validation with Blur Events
            firstName.addEventListener("blur", () => firstName.value.trim() === "" ? showError(firstName, "First Name is required.") : clearError(firstName));
            lastName.addEventListener("blur", () => lastName.value.trim() === "" ? showError(lastName, "Last Name is required.") : clearError(lastName));
            phone.addEventListener("blur", () => phone.value.trim() === "" ? showError(phone, "Phone No. is required.") : clearError(phone));
            address.addEventListener("blur", () => address.value.trim() === "" ? showError(address, "Address is required.") : clearError(address));
            username.addEventListener("blur",() => {
                const usernameValue = username.value.trim();
                // Check if the username is less than 4 characters
                if (usernameValue.length < 4){
                    showError(username, "Username must be at least 4 characters long.");
                } else {
                    clearError(username);
                }
            });

            email.addEventListener("blur", validateEmail);
            password.addEventListener("blur", validatePassword);
            confirmPassword.addEventListener("blur", validateConfirmPassword);

            // Form Submission Validation
            form.addEventListener("submit", function (e) {
                let isValid = true;

                // Validate First Name
                if (firstName.value.trim() === "") {
                    showError(firstName, "First Name is required.");
                    isValid = false;
                }

                // Validate Last Name
                if (lastName.value.trim() === "") {
                    showError(lastName, "Last Name is required.");
                    isValid = false;
                }

                // Validate Email
                if (!emailRegex.test(email.value)) {
                    showError(email, "Please enter a valid email address.");
                    isValid = false;
                }

                // Validate Password
                if (!passwordRegex.test(password.value)) {
                    showError(password, "Password must be at least 6 characters, include 1 uppercase, 1 lowercase letter, and 1 number.");
                    isValid = false;
                }

                // Validate Confirm Password
                if (password.value !== confirmPassword.value) {
                    showError(confirmPassword, "Passwords do not match.");
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault(); // Stop form submission if validation fails
                }
            });
        });
    </script>
</body>

</html>
