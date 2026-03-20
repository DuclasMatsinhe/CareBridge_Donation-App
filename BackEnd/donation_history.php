<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$donor_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT product_name, quantity, DATE_FORMAT(donation_date, '%M %Y') as donation_date FROM donations WHERE donor_id = ? ORDER BY donation_date DESC");
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();

$donations = [];
while ($row = $result->fetch_assoc()) {
    $donations[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($donations);
?>
