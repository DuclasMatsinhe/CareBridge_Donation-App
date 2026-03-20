<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "User not logged in"]);
    exit();
}

require_once 'db.php'; // Make sure this connects to your MySQL database correctly

$donor_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !is_array($data)) {
    echo json_encode(["status" => "error", "message" => "Invalid data"]);
    exit();
}

// Prepare statement outside the loop for efficiency
$stmt = $conn->prepare("INSERT INTO donations (donor_id, product_name, quantity) VALUES (?, ?, ?)");

if (!$stmt) {
    echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    exit();
}

foreach ($data as $product => $quantity) {
    // Validate quantity as integer > 0
    $quantity = intval($quantity);
    if ($quantity < 1) continue;

    $stmt->bind_param("isi", $donor_id, $product, $quantity);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(["status" => "success", "message" => "Donation saved!"]);
?>
