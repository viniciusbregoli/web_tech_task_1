<?php
// Define product data for each brand
$brandProducts = [
    "Apple" => [
        "iPhone MINI 12" => "product.php?pid=220",
        "iPhone MINI 13" => "product.php?pid=221",
        "iPhone PRO 16" => "product.php?pid=200",
        "iPhone PRO 16 Max" => "product.php?pid=201",
        "iPhone SE 2" => "product.php?pid=210",
        "iPhone SE 3" => "product.php?pid=211",
    ],
    "Samsung" => [
        "Galaxy Note 10" => "product.php?pid=100",
        "Galaxy Note 20" => "product.php?pid=101",
        "Galaxy Z Flip 5" => "product.php?pid=110",
        "Galaxy Z Flip 6" => "product.php?pid=111",
    ],
    "Google" => [
        "Pixel 8" => "product.php?pid=300",
        "Pixel 9" => "product.php?pid=301",
        "Pixel 9 Pro" => "product.php?pid=310",
        "Pixel 9 Pro Fold" => "product.php?pid=311",
    ]
];

// Get the brand from the query parameter
$brandId = isset($_GET['brandId']) ? $_GET['brandId'] : 1;  // Default to Galexy if no brand is selected
$generalProductLink = "product.php?pid=";

include('../db_connect.php');

$sql = "SELECT id, name FROM products WHERE brand_id = $brandId;";
$result = mysqli_query($conn, $sql);

// Save result with associative array
$products = [];

if ($result->num_rows > 0) {
    // Take each row as an associative array and add it to the $products list
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$brandName = 'Unknown';

$brandSql = "SELECT name FROM brands WHERE id = $brandId;";
$brandResult = mysqli_query($conn, $brandSql);
    
if ($brandResult->num_rows > 0) {
    $brandRow = $brandResult->fetch_assoc();
    $brandName = $brandRow['name'];
}

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
        <?php foreach ($products as $product): ?>
            <li>
                <a href="<?php echo $generalProductLink . $product['id']; ?>">
                    <?php echo $product['name']; ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    <footer>
        <a id="home" href="/myWebShop/src/index.php">Home</a>
    </footer>
    <img id="dark-mode" src="../../assets/moon.png" alt="Dark Mode" data-img-path="../../assets/"/>
    <script src="../scripts/darkMode.js"></script>
</body>
</html>
