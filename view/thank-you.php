<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You!</title>
    <!-- Optional: Add Bootstrap or custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="../css/authstyle.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
    
        h1 {
            color: #28a745;
        }
    </style>
</head>
<body>


    <div class="thank-you-container">
        <h1>Thank You!</h1>
        <p>Your message has been received successfully.</p>
        <p>We will get back to you as soon as possible.</p>
        <a href="../index.php" class="btn btn-primary mt-3">Return to Home</a>
    </div>
</body>
</html>
