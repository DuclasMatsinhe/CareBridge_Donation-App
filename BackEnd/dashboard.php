<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: LoginPage.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Care Bridge - Dashboard</title>
    <link rel="stylesheet" href="Styles.css">
</head>
<body>
    <header>
        <h1>Care Bridge</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="DonationPage.html">Donate</a>
            <a href="RequestPage.html">Request</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>

    <section class="form-container">
        <h2>Welcome, <?php echo $_SESSION['user']; ?>!</h2>
        <p>This is your dashboard. Use the navigation to donate, request, or log out.</p>
    </section>

    <footer>
        <p>&copy; 2025 Care Bridge. By Duclas Matsinhe.</p>
    </footer>
</body>
</html>
