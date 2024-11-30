<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" type="text/css" href="./css/aboutStyle.css">
    <title>About Us - Our Tech Shop</title>
</head>
<body>
    <header>
        <h1>About Our Tech Shop</h1>
        <div id="header-right">
            <a id="login" href="login.php">Login</a>
            <a id="profile" href="customer.php"><img src="../assets/user.png" alt="profile"></a>
        </div>
    </header>
    <section>
        <?php
        $mission = "At Our Tech Shop, we provide the best selection of smartphones from brands like Samsung, Apple, and Google. Our mission is to offer the latest technology and customer service.";
        $contact = "Need assistance? Reach out to our customer service team at <a href='mailto:support@techshop.com'>support@techshop.com</a>.";
        ?>
        <h2>Our Mission</h2>
        <p><?php echo $mission; ?></p>
        <h2>Contact Us</h2>
        <p><?php echo $contact; ?></p>

    </section>
    <footer>
        <a id="home" href="/myWebShop/src/index.php">Home</a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/darkMode.js"></script>
    <script src="../scripts/screenWidth.js"></script>
</body>
</html>
