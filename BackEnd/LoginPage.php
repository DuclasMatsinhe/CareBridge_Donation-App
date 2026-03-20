<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Care Bridge - Login</title>
  <link rel="stylesheet" href="Styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-pQfjx9lw1y3Dw12C0PclV7P3mf3gMXvmS7twON2xF7CulJcG+YQOX8v+1xH7gYj2EzqchK4m4+mjYZiDx1QF+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
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
      letter-spacing: 1px;
    }
    nav {
      position: relative;
    }
    .menu-button {
      font-size: 36px;
      cursor: pointer;
      background: none;
      border: none;
      color: white;
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
      max-height: 0;
      transition: max-height 0.3s ease;
    }
    .dropdown.show {
      display: flex;
      max-height: 500px;
    }
    .dropdown a {
      display: block;
      padding: 10px 20px;
      color: #3d2a26;
      text-decoration: none;
      border-bottom: 1px solid #eee;
    }
    .dropdown a:hover {
      background-color: #f0e0e3;
    }
    .form-container {
      background-color: #fff;
      max-width: 500px;
      margin: 50px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      font-family: 'Poppins', sans-serif;
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
    .form-container input[type="email"],
    .form-container input[type="password"] {
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
    .form-container a {
      color: #d88c9a;
      text-decoration: none;
    }
    footer {
      text-align: center;
      padding: 20px;
      background-color: #f5eaea;
      color: #3d2a26;
      font-size: 0.9rem;
    }
  </style>
  <script>
    function toggleMenu() {
      const menu = document.getElementById("dropdownMenu");
      menu.classList.toggle("show");
    }
  </script>
</head>
<body>
  <header>
    <div class="logo">
      <img src="images/logo.png" alt="CareBridge Logo">
      <span>Care Bridge</span>
    </div>
    <nav>
      <button class="menu-button" onclick="toggleMenu()">&#9776;</button>
      <div class="dropdown" id="dropdownMenu">
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="RegistrationPage.html">Sign Up</a>
      </div>
    </nav>
  </header>

  <section class="form-container">
    <h2>Login</h2>

    <?php if (isset($_GET['error'])): ?>
      <p style="color: red; text-align: center; font-weight: bold;">
        <?php
          switch ($_GET['error']) {
            case 'emptyfields': echo "Please fill in all fields."; break;
            case 'invalidpassword': echo "Invalid password."; break;
            case 'emailnotfound': echo "Email not found."; break;
            case 'dberror': echo "Database error. Please try again."; break;
            default: echo "An unknown error occurred."; break;
          }
        ?>
      </p>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
      <p><a href="#">Forgot Password?</a></p>
      <p>Don't have an account? <a href="RegistrationPage.html">Sign Up</a></p>
    </form>
  </section>

  <footer>
    <p>&copy; 2025 Care Bridge. By Duclas Matsinhe.</p>
  </footer>
</body>
</html>
