<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: LoginPage.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Care Bridge - Receptor Dashboard</title>
  <style>
    body {
      font-family: 'Times New Roman', Times, serif;
      margin: 0;
      padding: 0;
      background-color: #fff0f3;
      color: #3d2a26;
      font-size: 1.1rem;
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
      width: 100px;
      margin-right: 10px;
    }

    .logo span {
      font-size: 2rem;
      font-weight: bold;
      color: white;
      letter-spacing: 1px;
    }

    nav {
      position: relative;
    }

    .menu-button {
      font-size: 30px;
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      user-select: none;
      outline: none;
      padding: 0;
      line-height: 1;
    }

    .dropdown {
      display: none;
      position: absolute;
      top: 40px;
      right: 0;
      background-color: white;
      color: #3d2a26;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      border-radius: 5px;
      z-index: 1000;
      overflow: hidden;
      min-width: 140px;
    }

    .dropdown.show {
      display: block;
    }

    .dropdown a {
      display: block;
      padding: 10px 20px;
      color: #3d2a26;
      text-decoration: none;
      border-bottom: 1px solid #eee;
      white-space: nowrap;
    }

    .dropdown a:hover {
      background-color: #f0e0e3;
    }

    .dashboard-container {
      padding: 20px;
      max-width: 100%;
    }

    h2 {
      color: #d88c9a;
    }

    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: space-evenly;
      width: 100%;
      margin-bottom: 30px;
    }

    .product-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 10px;
      padding: 15px;
      flex: 1 1 250px;
      max-width: 300px;
      text-align: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .product-card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-radius: 5px;
    }

    .product-card h3 {
      margin-top: 10px;
      font-family: 'Times New Roman', serif;
      font-size: 1.1rem;
    }

    .product-card input {
      margin-top: 8px;
      padding: 6px 10px;
      width: 100%;
      font-size: 1rem;
    }

    button[type="submit"] {
      background-color: #d88c9a;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 1.1rem;
      cursor: pointer;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
      background-color: #c46f83;
    }

    .request-history {
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      margin-top: 30px;
    }

    footer {
      text-align: center;
      padding: 20px;
      background-color: #d88c9a;
      color: white;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<header>
  <div class="logo">
    <img src="images/logo.png" alt="CareBridge Logo" />
    <span>CareBridge</span>
  </div>
  <nav>
    <button class="menu-button" onclick="toggleMenu()">&#9776;</button>
    <div class="dropdown" id="dropdownMenu">
      <a href="index.html">Home</a>
      <a href="RegistrationPage.html">Sign Up</a>
      <a href="LoginPage.html">Login</a>
      <a href="DonorDashboard.php">Donate</a>
      <a href="ReceptorDashboard.php">Request</a>
    </div>
  </nav>
</header>

<section class="dashboard-container">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
  <p>Select products and quantities to request:</p>

  <form action="receptor_process.php" method="POST">
    <div class="products">
      <div class="product-card">
        <img src="images/Pads.jpg" alt="Pads" />
        <h3>Pads</h3>
        <input type="number" name="requests[Pads]" placeholder="Quantity" min="1" />
      </div>
      <div class="product-card">
        <img src="images/Tampon.jpg" alt="Tampons" />
        <h3>Tampons</h3>
        <input type="number" name="requests[Tampons]" placeholder="Quantity" min="1" />
      </div>
      <div class="product-card">
        <img src="images/Menstrual Colector.jpg" alt="Menstrual Cups" />
        <h3>Menstrual Cups</h3>
        <input type="number" name="requests[Menstrual Cups]" placeholder="Quantity" min="1" />
      </div>
      <div class="product-card">
        <img src="images/wipes.jpg" alt="Wipes" />
        <h3>Wipes</h3>
        <input type="number" name="requests[Wipes]" placeholder="Quantity" min="1" />
      </div>
    </div>
    <button type="submit">Submit Request</button>
  </form>

  <div class="request-history">
    <h2>Your Request History</h2>
    <?php include 'receptor_history.php'; ?>
  </div>
</section>

<footer>
  <p>&copy; 2025 CareBridge. By Duclas Matsinhe.</p>
</footer>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menuButton');
    const dropdown = document.getElementById('dropdownMenu');
    
    menuButton.addEventListener('click', function(e) {
      e.stopPropagation();
      dropdown.classList.toggle('show');
    });
    
    // Close dropdown when clicking anywhere else
    document.addEventListener('click', function() {
      dropdown.classList.remove('show');
    });
    
    // Prevent dropdown clicks from closing the dropdown
    dropdown.addEventListener('click', function(e) {
      e.stopPropagation();
    });
  });
</script>

</body>
</html>