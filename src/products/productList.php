<?php
// Define product data for each brand
$brandProducts = [
    "Apple" => [
        "iPhone MINI 12" => "product.php?brand=Apple&model=iphone_16_pro",
        "iPhone MINI 13" => "product.php?brand=Apple&model=iphone_16_pro",
        "iPhone PRO 16" => "product.php?brand=Apple&model=iphone_16_pro",
        "iPhone PRO 16 Max" => "product.php?brand=Apple&model=iphone_16_pro",
        "iPhone SE 2" => "product.php?brand=Apple&model=iphone_16_pro",
        "iPhone SE 3" => "product.php?brand=Apple&model=iphone_16_pro",
    ],
    "Samsung" => [
        "Galaxy Note 10" => "product.php?brand=Apple&model=iphone_16_pro",
        "Galaxy Note 20" => "product.php?brand=Apple&model=iphone_16_pro",
        "Galaxy Flip 5" => "product.php?brand=Apple&model=iphone_16_pro",
        "Galaxy Flip 6" => "product.php?brand=Apple&model=iphone_16_pro",
    ],
    "Google" => [
        "Pixel 8" => "product.php?brand=Apple&model=iphone_16_pro",
        "Pixel 9" => "product.php?brand=Apple&model=iphone_16_pro",
        "Pixel 9 Pro" => "product.php?brand=Apple&model=iphone_16_pro",
        "Pixel 9 Pro Fold" => "product.php?brand=Apple&model=iphone_16_pro",
    ]
];

// Get the brand from the query parameter
$brandName = isset($_GET['brand']) ? $_GET['brand'] : 'Apple';  // Default to Apple if no brand is selected

// Check if the brand exists in the array
if (!array_key_exists($brandName, $brandProducts)) {
    $brandName = 'Apple';  // Fallback to Apple if brand not found
}

// Get the list of products for the selected brand
$products = $brandProducts[$brandName];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/productListStyle.css">
    <title><?php echo $brandName . " Series"; ?></title>
</head>
<body>
    <header class="container">
        <h1><?php echo $brandName . " Series"; ?></h1>
        <div id="header-right">
            <a id="login" href="../login.php">Login</a>
            <a id="profile" href="../customer.php"><img src="../../assets/user.png" alt="profile"></a>
        </div>
    </header>
    <hr />
    <ul>
        <?php foreach ($products as $productName => $productLink): ?>
            <li>
                <a href="<?php echo $productLink; ?>">
                    <?php echo $productName; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <footer>
        <a id="home" href="/myWebShop/src/index.php">Home</a>
    </footer>
    <img id="dark-mode" src="../../assets/moon.png" alt="Dark Mode" data-img-path="../../assets/"/>
    <script src="../scripts/darkMode.js"></script>
    <script src="../scripts/screenWidth.js"></script>
</body>
</html>
