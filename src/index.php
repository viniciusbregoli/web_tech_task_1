<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="./css/homeStyle.css">
    <title>Welcome to Our Tech Shop</title>
</head>
<body>
    <?php 
    // associative array
    $navItems = [
        "Samsung" => [
            "logo" => "https://cdn.icon-icons.com/icons2/3914/PNG/512/samsung_logo_icon_248596.png",
            "generalLink" => "/myWebShop/src/products/productList.php?brand=Samsung",  
            "models" => [
                "Galaxy Note" => "/myWebShop/src/products/productLineList.php?brand=Samsung&model=Galaxy+Note",
                "Galaxy Z Flip" => "/myWebShop/src/products/productLineList.php?brand=Samsung&model=Galaxy+Z+Flip"
            ]
        ],
        "Apple" => [
            "logo" => "https://cdn-icons-png.flaticon.com/512/0/747.png",
            "generalLink" => "/myWebShop/src/products/productList.php?brand=Apple",  
            "models" => [
                "iPhone MINI" => "/myWebShop/src/products/productLineList.php?brand=Apple&model=iPhone+MINI",
                "iPhone PRO" => "/myWebShop/src/products/productLineList.php?brand=Apple&model=iPhone+PRO",
                "iPhone SE" => "/myWebShop/src/products/productLineList.php?brand=Apple&model=iPhone+SE"
            ]
        ],
        "Google" => [
            "logo" => "https://brandlogo.org/wp-content/uploads/2024/05/Google-Pixel-Logo.png",
            "generalLink" => "/myWebShop/src/products/productList.php?brand=Google",  
            "models" => [
                "Pixel" => "/myWebShop/src/products/productLineList.php?brand=Google&model=Pixel",
                "Pixel PRO" => "/myWebShop/src/products/productLineList.php?brand=Google&model=Pixel+PRO"
            ]
        ]
    ];
    ?>
    <header class="container">
        <h1>Welcome to Our Tech Shop</h1>
        <div id="header-right">
            <?php
                // Check whether user is logged in
                session_start();

                $href = isset($_SESSION['username']) ? "logout.php" : "login.php";
                $text = isset($_SESSION['username']) ? "Logout" : "Login";
                echo "<a href=$href>$text</a>";

                $profileHref = isset($_SESSION['username']) ? "customer.php" : "login.php";
                echo "<a id=\"profile\" href=$profileHref><img src=\"../assets/user.png\" alt=\"Profile\"></a>";
            ?>
        </div>
    </header>
    <nav>
        <ul id="brand-container">
            <?php foreach ($navItems as $brand => $details): ?>
                <li class="list-brand">
                    <a href="<?php echo $details['generalLink']; ?>">
                        <img src="<?php echo $details['logo']; ?>" alt="<?php echo $brand . ' logo'; ?>">
                    </a>

                    <ul>
                        <?php foreach ($details['models'] as $category): ?>
                            <?php 
                                $categoryLink = sprintf("/myWebShop/src/products/productLineList.php?brand=%s&model=%s", $brand, $category);
                            ?>
                            <li class="list-brand-model">
                               <a href="<?php echo $categoryLink; ?>"><?php echo $category; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <footer>
        <a href="about.php">About Us</a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
