<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total quantity of items in the cart
$cart_quantity = 0;
foreach ($cart as $item) {
    $cart_quantity += $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./css/aboutStyle.css">
    <title>About Us - Our Tech Shop</title>
</head>
<body>
    <?php
    $headerTitle = "About Our Tech Shop";
    $missionTitle = "Our Mission";
    $missionText = "At Our Tech Shop, we provide the best selection of smartphones from brands like Samsung, Apple, and Google. Our mission is to offer the latest technology and customer service.";
    $contactTitle = "Contact Us";
    $contactText = "Need assistance? Reach out to our customer service team at <a href='mailto:support@techshop.com'>support@techshop.com</a>.";
    $homeLink = "Home";
    ?>
    <header>
        <h1><?php echo $headerTitle; ?></h1>
        <div id="header-right">
            <a id="login" href="login.php">Login</a>
            <a id="shoppingcart" href="/myWebShop/src/products/shopping.php"><img src="../assets/shopping-cart.png" alt="shoppingcart"></a>
            <span><?php echo $cart_quantity; ?></span>
            <a id="profile" href="customer.php"><img src="../assets/user.png" alt="profile"></a>
        </div>
    </header>
    <section>
        <h2><?php echo $missionTitle; ?></h2>
        <p><?php echo $missionText; ?></p>
        <h2><?php echo $contactTitle; ?></h2>
        <p><?php echo $contactText; ?></p>
    </section>
    <form action="submit_feedback.php" method="POST" id="feedbackForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea>
        <br>
        <input type="submit" value="Submit Feedback">
    </form>
    <footer>
        <a id="home" href="/myWebShop/src/index.php"><?php echo $homeLink; ?></a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
