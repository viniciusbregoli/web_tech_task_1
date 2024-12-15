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
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="./css/homeStyle.css">
    <title>Welcome to Our Tech Shop</title>
</head>
<body>
    <?php 
        $generalProductLink = "/myWebShop/src/products/productList.php?brandId=";

        include('db_connect.php');

        $brandsSql = "SELECT id, name, logo FROM brands";
        $brandsResult = mysqli_query($conn, $brandsSql);

        // Save result with associative array
        $brands = [];

        if ($brandsResult->num_rows > 0) {
            // Take each row as an associative array and add it to the $brands list
            while($row = $brandsResult->fetch_assoc()) {
                $brands[] = $row;
            }
        } else {
            echo "Data Not Found.";
        }

        $categoriesSql = "SELECT id, brand_id, name FROM categories ORDER BY brand_id";
        $categoriesResult = mysqli_query($conn, $categoriesSql);

        $brandCategories = [];

        while ($row = $categoriesResult->fetch_assoc()) {
            $categoryId = $row['id'];
            $brandId = $row['brand_id'];
            $categoryName = $row['name'];

            // Check if brand_id already exists in the array
            if (!isset($brandCategories[$brandId])) {
                $brandCategories[$brandId] = [];
            }

            $brandCategories[$brandId][$categoryId] = $categoryName;
        }

    ?>
    <header class="container">
        <h1>Welcome to Our Tech Shop</h1>
        <div id="header-right">
            <a id="shoppingcart" href="/myWebShop/src/products/shopping.php"><img src="../assets/shopping-cart.png" alt="shoppingcart"></a>
            <span><?php echo $cart_quantity; ?></span>
            <?php
                // Check whether user is logged in

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
            <?php foreach ($brands as $brand): ?>
                <li class="list-brand">
                    <a href="<?php echo $generalProductLink . $brand['id']; ?>">
                        <img class="brand-img" src="<?php echo $brand['logo']; ?>" alt="<?php echo $brand['name'] . ' logo'; ?>">
                    </a>

                    <ul>
                        <?php foreach ($brandCategories[$brand['id']] as $categoryId => $categoryName): ?>
                            <?php 
                                $categoryLink = sprintf("/myWebShop/src/products/productLineList.php?brandId=%s&categoryId=%s", $brand['id'], $categoryId);
                            ?>
                            <li class="list-brand-model">
                               <a href="<?php echo $categoryLink; ?>"><?php echo $categoryName; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <button id="openChatBtn">Chat with Support</button>

    <div id="chatWindow" class="chat-window">
        <div class="chat-header">
            <span>Support Chat</span>
            <button id="closeChatBtn">&times;</button>
        </div>
        <div class="chat-body">
            <p>Welcome to support chat!</p>
        </div>
        <div class="chat-footer">
            <input type="text" placeholder="Type your message...">
            <button>Send</button>
        </div>
    </div>
    <footer>
        <a href="about.php">About Us</a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/darkMode.js"></script>
    <script src="./scripts/chat.js"></script>
</body>
</html>
