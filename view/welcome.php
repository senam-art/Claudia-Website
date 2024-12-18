<?php
session_start();  // Start the session to retrieve the success message
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Claudia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css"> 
    <link rel="stylesheet" href="../css/authstyle.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary custom-navbar">
        <div class="container-fluid d-flex flex-column align-items-center justify-content-center">
            <!-- Claudia Logo -->
            <a class="navbar-brand" href="../index.html">claudia</a>
            <!-- Kente Fabric Strip -->
            <div class="kente-strip"></div>
    </nav>

    <div class="container mt-5">

        <h1>Welcome to Claudia's Website!</h1>
        <p>Your account has been successfully created.</p>

        <a href="Userlogin.php" class="btn btn-primary">Go to Login</a>
    </div>

</body>

</html>
