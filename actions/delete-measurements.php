<?php
session_start();
include '../db/config.php';

if (!isset($_SESSION['username']) || !isset($_GET['customer_id'])) {
    header("Location: ../view/admin/admin-login.php");
    exit();
}

$customer_id = intval($_GET['customer_id']);
$delete_query = "DELETE FROM measurements WHERE customer_id = ?";
$stmt = $conn->prepare($delete_query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();

header("Location: ../view/admin/measurements.php?status=deleted");
exit();
?>
