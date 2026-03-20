<?php
include 'db.php';
session_start();

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        header("Location: LoginPage.php?error=emptyfields");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // ✅ Use correct lowercase 'password'
            if (isset($user['password']) && password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user['fullname'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['fullname']; 
                $_SESSION['role'] = $user['role'];

                if ($user['role'] === 'donor') {
                    header("Location: DonorDashboard.php");
                } else {
                    header("Location: ReceptorDashboard.php");
                }
                exit();
            } else {
                header("Location: LoginPage.php?error=invalidpassword");
                exit();
            }
        } else {
            header("Location: LoginPage.php?error=emailnotfound");
            exit();
        }

        $stmt->close();
    } else {
        header("Location: LoginPage.php?error=dberror");
        exit();
    }
} else {
    header("Location: LoginPage.php");
    exit();
}
?>
