<?php
// Dynamic product data (you can expand this data, or fetch it from a database)
$products = [
    "Samsung" => [
        "Galaxy Note" => [
            "Galaxy Note 10" => "product.php?pid=100",
            "Galaxy Note 20" => "product.php?pid=101",
        ],
        "Galaxy Z Flip" => [
            "Galaxy Z Flip 5" => "product.php?pid=110",
            "Galaxy Z Flip 6" => "product.php?pid=111",
        ]
    ],
    "Apple" => [
        "iPhone PRO" => [
            "iPhone PRO 16" => "product.php?pid=200",
            "iPhone PRO 16 Max" => "product.php?pid=201",
        ],
        "iPhone SE" =>[
            "iPhone SE 2" =>"product.php?pid=210",
            "iPhone SE 3"=> "product.php?pid=211"
        ],
        "iPhone MINI" => [
            "iPhone MINI 12" => "product.php?pid=220",
            "iPhone MINI 13" => "product.php?pid=221",
        ]
    ],
    "Google" => [
        "Pixel" => [
            "Pixel 8" => "product.php?pid=300",
            "Pixel 9" => "product.php?pid=301",
        ],
        "Pixel PRO" => [
            "Pixel PRO 9" => "product.php?pid=310",
            "Pixel PRO Fold" => "product.php?pid=311"
        ]
    ]
];

// Get the brand and model from the URL
$brand = isset($_GET['brand']) ? $_GET['brand'] : 'Unknown';
$model = isset($_GET['model']) ? $_GET['model'] : 'Unknown';

// Fetch the models for the selected brand
$brandModels = isset($products[$brand]) ? $products[$brand] : [];
$modelList = isset($brandModels[$model]) ? $brandModels[$model] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../css/productListStyle.css">
    <title><?php echo $brand . " " . $model; ?></title>
</head>
<body>
    <header class="container">
        <h1><?php echo $brand . " " . $model; ?></h1>
        <div id="header-right">
            <a id="login" href="../login.php">Login</a>
            <a id="profile" href="../customer.php"><img src="../../assets/user.png" alt="profile"></a>
        </div>
    </header>
    <hr />
    <ul>
        <?php foreach ($modelList as $productName => $productLink): ?>
            <li>
                <a href="<?php echo $productLink; ?>"><?php echo $productName; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <footer>
        <a id="home" href="../index.php">Home</a>
    </footer>
    <img id="dark-mode" src="../../assets/moon.png" alt="Dark Mode" data-img-path="../../assets/" />
    <script src="../scripts/darkMode.js"></script>
    <script src="../scripts/screenWidth.js"></script>
</body>
</html>
