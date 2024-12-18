<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../db/config.php');

// Check if product_id is passed in the URL
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'customer') {
    if (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) {
        $product_id = $_GET['product_id'];

        // Query to fetch product details
        $query = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $product = $result->fetch_assoc();
        } else {
            header("Location: catalog.php");
            exit();
        }
    } else {
        header("Location: catalog.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Claudia's Creations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/adminstyle.css">
    <style>
        .product-image { max-width: 100%; height: auto; border-radius: 10px; }
        .product-details { padding: 20px; }
        .price { font-size: 1.5rem; color: #e63946; margin-bottom: 20px; }
        .btn-back { margin-top: 20px; }

        /* Overall body and form styling */
body {
    background-color: #f9f9f9; /* Light grey background for a soft appearance */
    font-family: 'Arial', sans-serif;
    color: #333; /* Dark grey text for readability */
}

/* Form container */
#customDesignForm {
    background-color: #ffffff; /* White background for the form */
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Soft shadow for subtle depth */
    max-width: 800px;
    margin: 0 auto; /* Center form on the page */
}

/* Form labels */
.form-label {
    font-size: 1.1rem;
    color: #555; /* Slightly muted dark grey for labels */
    font-weight: 500;
}

/* Form inputs */
.form-control {
    border-radius: 5px;
    border: 1px solid #ddd; /* Light grey border */
    padding: 10px;
    font-size: 1rem;
    color: #333;
    background-color: #f8f8f8; /* Light grey background for input fields */
}

.form-control:focus {
    border-color: #007bff; /* Blue focus border for interactivity */
    background-color: #fff; /* White background on focus */
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.2); /* Soft blue shadow */
}

/* Input group (unit label next to input) */
.input-group-text {
    background-color: #f0f0f0; /* Light grey background for unit label */
    border: 1px solid #ddd;
    color: #555;
}

/* Form sections (spacing between rows) */
.mb-3 {
    margin-bottom: 20px;
}

/* Submit button */
.btn-primary {
    background-color: #5d4d7a; /* Elegant purple tone */
    border-color: #5d4d7a;
    padding: 10px 20px;
    font-size: 1.1rem;
    border-radius: 5px;
    color: #fff;
    text-transform: uppercase;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #4c3c5d; /* Slightly darker purple for hover effect */
    border-color: #4c3c5d;
    cursor: pointer;
}

/* File input and textareas */
#measurements {
    border-radius: 5px;
    background-color: #f8f8f8;
    border: 1px solid #ddd;
}

textarea.form-control {
    resize: vertical;
    padding: 12px;
}

/* Custom design section heading */
h3 {
    font-size: 1.5rem;
    color: #5d4d7a; /* Elegant purple for headings */
    margin-bottom: 20px;
}

/* Additional input spacing */
input[type="file"] {
    padding: 10px;
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    border-radius: 5px;
    color: #555;
}

/* Additional information text area */
textarea.form-control {
    padding: 12px;
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    border-radius: 5px;
    color: #333;
}

    </style>
</head>
<body class="product-detail">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">claudia</a>
            <a class="nav-link" href="catalog.php">Back to Catalog</a>
        </div>
    </nav>

    <!-- Product Detail Section -->
    <section id="product-detail" class="container mt-5">
        <div class="row">
            <!-- Product Image Section -->
            <div class="col-md-6">
                <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" class="product-image" alt="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>

            <!-- Product Details Section -->
            <div class="col-md-6 custom-design-form ">
                <h2><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <p class="price">GH¢<?php echo number_format($product['product_price'], 2); ?></p>
                <p><?php echo nl2br(htmlspecialchars($product['product_description'])); ?></p>

                <h3 style="text-align: center;">Custom Design Request</h3>
                <p>Like this design? Fill in the details below and upload your measurements or pictures to get started.</p>

                <!-- Custom Design Form -->
                <form id="customDesignForm" action="../actions/submit-design.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bust" class="form-label">Bust</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="bust" step="0.01" name="bust" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="waist" class="form-label">Waist</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="waist" step="0.01" name="waist" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="hips" class="form-label">Hips</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="hips" step="0.01" name="hips" required>
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="height" class="form-label">Height</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="height" step="0.01" name="height" required>
                                <span class="input-group-text">in</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="quantity" step="1" name="quantity" required>
                                <span class="input-group-text">pieces</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="measurements" class="form-label">Upload Your Pictures (Optional)</label>
                        <input type="file" class="form-control" id="measurements" name="measurements">
                    </div>
                    <div class="mb-3">
                        <label for="additionalInfo" class="form-label">Additional Information</label>
                        <textarea class="form-control" id="additionalInfo" name="additionalInfo" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit Design Request</button>
                </form>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function confirmSubmit() {
        // Show a confirmation dialog
        var confirmation = confirm("Are you sure you want to submit this design request?");
        
        // If the user clicks "OK", submit the form
        if (confirmation) {
            document.getElementById("customDesignForm").submit();
        } else {
            // If the user clicks "Cancel", do nothing
            return false;
        }
    }
</script>
</body>
</html>
