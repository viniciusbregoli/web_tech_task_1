<?php
    // Get the brand and model id from the URL
    $brand = isset($_GET['brandId']) ? $_GET['brandId'] : 'Unknown';
    $category = isset($_GET['categoryId']) ? $_GET['categoryId'] : 'Unknown';
    $generalProductLink = "product.php?pid=";

    include('../db_connect.php');

    $sql = "SELECT id, name FROM products WHERE category_id = $category;";
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
    $categoryName = 'Unknown';

    $brandSql = "SELECT name FROM brands WHERE id = $brand;";
    $brandResult = mysqli_query($conn, $brandSql);
        
    if ($brandResult->num_rows > 0) {
        $brandRow = $brandResult->fetch_assoc();
        $brandName = $brandRow['name'];
    }

    $categorySql = "SELECT name FROM categories WHERE id = $category";
    $categoryResult = mysqli_query($conn, $categorySql);
        
    if ($categoryResult->num_rows > 0) {
        $categoryRow = $categoryResult->fetch_assoc();
        $categoryName = $categoryRow['name'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="../css/productListStyle.css">
    <title><?php echo $brandName . " " . $categoryName; ?></title>
</head>
<body>
    <header class="container">
        <h1><?php echo $brandName . " " . $categoryName; ?></h1>
        <div id="header-right">
            <a id="login" href="../login.php">Login</a>
            <a id="profile" href="../customer.php"><img src="../../assets/user.png" alt="profile"></a>
        </div>
    </header>
    <hr />
    <ul>
        <?php foreach ($products as $product): ?>
            <li>
                <a href="<?php echo $generalProductLink . $product['id']; ?>"><?php echo $product['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
    <footer>
        <a id="home" href="../index.php">Home</a>
    </footer>
    <img id="dark-mode" src="../../assets/moon.png" alt="Dark Mode" data-img-path="../../assets/" />
    <script src="../scripts/darkMode.js"></script>
</body>
</html>
