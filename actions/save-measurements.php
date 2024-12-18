<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['username']) || $_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

$customer_id = intval($_POST['customer_id']);
$bust = $_POST['bust'] ?? null;
$waist = $_POST['waist'] ?? null;
$hips = $_POST['hips'] ?? null;
$height = $_POST['height'] ?? null;
$additional_details = $_POST['additional_details'] ?? null;

// Save or update measurements
$query = "INSERT INTO measurements (customer_id, bust, waist, hips, height, additional_details)
          VALUES (?, ?, ?, ?, ?, ?)
          ON DUPLICATE KEY UPDATE bust=?, waist=?, hips=?, height=?, additional_details=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("idddssdddss", $customer_id, $bust, $waist, $hips, $height, $additional_details, 
                  $bust, $waist, $hips, $height, $additional_details);
$stmt->execute();

header("Location: ../view/admin/measurements.php?customer_id=$customer_id");
exit();
?>
