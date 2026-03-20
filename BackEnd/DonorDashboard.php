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
  <title>Care Bridge - Donor Dashboard</title>
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
    }

    .dropdown {
      display: none;
      flex-direction: column;
      position: absolute;
      top: 40px;
      right: 0;
      background-color: white;
      color: #3d2a26;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
      border-radius: 5px;
      z-index: 1000;
      overflow: hidden;
    }

    .dropdown.show {
      display: flex;
    }

    .dropdown a {
      padding: 10px 20px;
      color: #3d2a26;
      text-decoration: none;
      border-bottom: 1px solid #eee;
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

    .product-card input,
    .product-card button {
      margin-top: 8px;
      padding: 6px 10px;
      width: 100%;
      font-size: 1rem;
    }

    .product-card button {
      background-color: #d88c9a;
      color: white;
      border: none;
      cursor: pointer;
    }

    .product-card button:hover {
      background-color: #c46f83;
    }

    .cart, .donation-history {
      margin-top: 40px;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      width: 100%;
    }

    .cart ul {
      list-style: none;
      padding: 0;
    }

    .cart li {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 8px 0;
      border-bottom: 1px solid #eee;
    }

    .cart li span {
      flex: 1;
    }

    .remove-btn {
      background-color: #ff5c5c;
      color: white;
      border: none;
      padding: 6px 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    .remove-btn:hover {
      background-color: #e04e4e;
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
      <a href="LoginPage.php">Login</a>
      <a href="DonorDashboard.php">Donate</a>
      <a href="ReceptorDashboard.php">Request</a>
    </div>
  </nav>
</header>

<section class="dashboard-container">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
  <p>Thank you for supporting menstrual health and helping eradicate period poverty. Select products below to donate and help us build a bridge.</p>

  <div class="products">
    <div class="product-card">
      <img src="images/Pads.jpg" alt="Pads" />
      <h3>Pads</h3>
      <input type="number" placeholder="Quantity" min="1" id="padsQty" />
      <button onclick="addToCart('Pads')">Add to Cart</button>
    </div>

    <div class="product-card">
      <img src="images/Tampon.jpg" alt="Tampons" />
      <h3>Tampons</h3>
      <input type="number" placeholder="Quantity" min="1" id="tamponsQty" />
      <button onclick="addToCart('Tampons')">Add to Cart</button>
    </div>

    <div class="product-card">
      <img src="images/Menstrual Colector.jpg" alt="Menstrual Cups" />
      <h3>Menstrual Cups</h3>
      <input type="number" placeholder="Quantity" min="1" id="menstrualcupsQty" />
      <button onclick="addToCart('Menstrual Cups')">Add to Cart</button>
    </div>

    <div class="product-card">
      <img src="images/wipes.jpg" alt="Wipes" />
      <h3>Wipes</h3>
      <input type="number" placeholder="Quantity" min="1" id="wipesQty" />
      <button onclick="addToCart('Wipes')">Add to Cart</button>
    </div>
  </div>

  <div class="cart">
    <h2>Your Donation Cart</h2>
    <ul id="cartList"></ul>
    <button onclick="submitDonation()">Submit Donation</button>
  </div>

  <div class="donation-history">
    <h2>Past Contributions</h2>
    <ul>
      <li>March 2025 - 10 Pads, 5 Tampons</li>
      <li>February 2025 - 3 Menstrual Cups</li>
    </ul>
  </div>
</section>

<footer>
  <p>&copy; 2025 Care Bridge. By Duclas Matsinhe.</p>
</footer>

<script>
  function toggleMenu() {
    const menu = document.getElementById("dropdownMenu");
    menu.classList.toggle("show");
  }

  const cart = {};

  function addToCart(product) {
    const inputId = product.toLowerCase().replace(/\s+/g, '') + "Qty";
    const qtyInput = document.getElementById(inputId);
    const qty = parseInt(qtyInput.value);

    if (!qty || qty < 1) {
      alert("Please enter a valid quantity.");
      return;
    }

    if (cart[product]) {
      cart[product] += qty;
    } else {
      cart[product] = qty;
    }

    qtyInput.value = '';
    updateCartUI();
  }

  function removeFromCart(product) {
    if (cart[product]) {
      delete cart[product];
      updateCartUI();
    }
  }

  function updateCartUI() {
    const cartList = document.getElementById("cartList");
    cartList.innerHTML = '';

    for (let item in cart) {
      const li = document.createElement('li');
      li.innerHTML = `<span>${item}: ${cart[item]}</span>
                      <button class="remove-btn" onclick="removeFromCart('${item}')">Remove</button>`;
      cartList.appendChild(li);
    }
  }

  function submitDonation() {
    if (Object.keys(cart).length === 0) {
      alert("Your cart is empty!");
      return;
    }

    fetch('donation_process.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(cart)
    })
    .then(response => response.json())
    .then(data => {
      if(data.status === "success"){
        alert("Donation submitted! Thank you.");
        for (let item in cart) {
          delete cart[item];
        }
        updateCartUI();
      } else {
        alert("Error: " + data.message);
      }
    })
    .catch(err => {
      alert("Failed to submit donation.");
      console.error(err);
    });
  }
</script>

</body>
</html>
