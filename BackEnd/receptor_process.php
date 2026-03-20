<?php
session_start();
include 'db.php'; // make sure this file connects to MySQL

if (!isset($_SESSION['username'])) {
    header("Location: LoginPage.html");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requests'])) {
    $requests = $_POST['requests'];

    $conn = connectDatabase();

    $stmt = $conn->prepare("INSERT INTO receptor_requests (username, product_name, quantity) VALUES (?, ?, ?)");

    foreach ($requests as $product => $quantity) {
        if (!empty($quantity) && intval($quantity) > 0) {
            $stmt->bind_param("ssi", $username, $product, $quantity);
            $stmt->execute();
        }
    }

    $stmt->close();
    $conn->close();
}

// Redirect back to the dashboard
header("Location: ReceptorDashboard.php");
exit();
?>
