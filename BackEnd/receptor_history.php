<?php
include 'db.php';
session_start();

if (!isset($_SESSION['username'])) {
    echo "<p>Please log in to see your request history.</p>";
    return;
}

$username = $_SESSION['username'];
$conn = connectDatabase();

$sql = "SELECT product_name, quantity, requested_at FROM receptor_requests WHERE username = ? ORDER BY requested_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li><strong>{$row['product_name']}</strong> - {$row['quantity']} units on " . date("F j, Y, g:i a", strtotime($row['requested_at'])) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No requests made yet.</p>";
}

$stmt->close();
$conn->close();
?>
