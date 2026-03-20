<?php
require 'config.php'; // Your DB connection

function showHeader() {
    echo '
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #fef6f6;
            margin: 0;
            padding: 0;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #d88c9a;
            padding: 10px 20px;
            color: white;
        }
        .logo {
            display: flex;
            align-items: center;
        }
        .logo img {
            height: 80px;
            width: auto;
            max-width: 250px;
            margin-right: 10px;
        }
        .logo span {
            font-size: 2rem;
            font-weight: bold;
            color: white;
        }
        .form-container {
            background-color: #fff;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            text-align: center;
            color: #d88c9a;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .form-container input {
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }
        .form-container button {
            padding: 12px;
            background-color: #d88c9a;
            color: white;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #c27887;
        }
        .form-container p {
            text-align: center;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #f5eaea;
            color: #3d2a26;
            font-size: 0.9rem;
            margin-top: 40px;
        }
    </style>

    <header>
        <div class="logo">
            <img src="images/logo.png" alt="CareBridge Logo">
            <span>Care Bridge</span>
        </div>
    </header>
    ';
}

function showFooter() {
    echo '
    <footer>
        <p>&copy; 2025 Care Bridge. By Duclas Matsinhe.</p>
    </footer>
    ';
}

function showResetRequestForm() {
    echo '
    <section class="form-container">
        <h2>Forgot Password</h2>
        <form method="POST" action="password_recovery.php">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
            <p><a href="LoginPage.html">Back to Login</a></p>
        </form>
    </section>';
}

function showNewPasswordForm($token) {
    $token = htmlspecialchars($token);
    echo '
    <section class="form-container">
        <h2>Reset Your Password</h2>
        <form method="POST" action="password_recovery.php">
            <input type="hidden" name="token" value="' . $token . '">
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>
    </section>';
}

// === MAIN LOGIC ===

echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Password Recovery</title></head><body>';
showHeader();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));
    $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        $reset_link = "http://yourdomain.com/password_recovery.php?token=$token";
        $subject = "Password Reset Request - Care Bridge";
        $message = "Hi,\n\nClick the link below to reset your password:\n\n$reset_link\n\nThis link will expire in 1 hour.";
        $headers = "From: support@carebridge.com";

        mail($email, $subject, $message, $headers);
        echo '<section class="form-container"><p>Password reset link sent to your email.</p></section>';
    } else {
        echo '<section class="form-container"><p>Email not found in our system.</p></section>';
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['token'], $_POST['new_password'], $_POST['confirm_password'])) {
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo '<section class="form-container"><p>Passwords do not match.</p></section>';
        showNewPasswordForm($token);
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND token_expiry >= NOW()");
        $stmt->execute([$token]);
        $user = $stmt->fetch();

        if ($user) {
            $hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?");
            $stmt->execute([$hashed, $token]);

            echo '<section class="form-container"><p>Password successfully updated. <a href="LoginPage.html">Login</a></p></section>';
        } else {
            echo '<section class="form-container"><p>Invalid or expired token.</p></section>';
        }
    }

} elseif (isset($_GET['token'])) {
    showNewPasswordForm($_GET['token']);
} else {
    showResetRequestForm();
}

showFooter();
echo '</body></html>';
?>
