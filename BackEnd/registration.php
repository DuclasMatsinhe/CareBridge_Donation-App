<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "carebridge";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and validate form data
$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$password_plain = $_POST['password'];
$role = trim($_POST['role']);
$address = trim($_POST['address']);

// Basic validation
if (empty($fullname) || empty($email) || empty($password_plain) || empty($role) || empty($address)) {
    die("Please fill all required fields.");
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    die("Email is already registered. Please use another email or login.");
}
$stmt->close();

// Hash the password
$hashed_password = password_hash($password_plain, PASSWORD_DEFAULT);

// Prepare insert statement
$stmt = $conn->prepare("INSERT INTO users (fullname, email, password, role, address) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $fullname, $email, $hashed_password, $role, $address);

if ($stmt->execute()) {
    header("Location: LoginPage.html");
    exit();
} else {
    echo "Registration failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

