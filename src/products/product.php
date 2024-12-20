<?php

session_start();
$product1 = null;
$product2 = null;

$redirectUrl="products/product.php";

include('../db_connect.php');


if (isset($_GET["pid"])) {
    $pid = $_GET["pid"];
    if (empty($pid)) {
        header("location: ../error.php");
    } else {
        $redirectUrl="products/product.php?pid=$pid";
        $sql = "SELECT * FROM products WHERE id = $pid;";
        $result1 = mysqli_query($conn, $sql);
        
        $product1 = mysqli_fetch_assoc($result1);

        $product_data1 = json_decode($product1['data'], true);
        $description1 = $product_data1['description'];
        $imagepath1 = $product_data1['imagepath'];
        $colors1 = $product_data1['colors'];
        $storage1 = $product_data1['storage'];
    }
} else {
    header("location: ../error.php");
}


if (isset($_GET["pid2"])) {
    $pid2 = $_GET["pid2"];
    if (empty($pid2)) {
        header("location: ../error.php");
    } else {
        $redirectUrl="products/product.php?pid=$pid&pid2=$pid2";
        $sql = "SELECT * FROM products WHERE id = $pid2;";
        $result2 = mysqli_query($conn, $sql);

        $product2 = mysqli_fetch_assoc($result2);

        $product_data2 = json_decode($product2['data'], true);
        $description2 = $product_data2['description'];
        $imagepath2 = $product_data2['imagepath'];
        $colors2 = $product_data2['colors'];
        $storage2 = $product_data2['storage'];
    }
}

if (!$product1 && !$product2) {
    header("location: ../error.php");
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Calculate total quantity of items in the cart
$cart_quantity = 0;
foreach ($cart as $item) {
    $cart_quantity += $item['quantity'];
}

// Fetch reviews for the product
$reviews = [];
if ($product1) {
    $reviewStmt1 = $conn->prepare("SELECT * FROM reviews WHERE product_id = ?");
    $reviewStmt1->bind_param("i", $pid);
    $reviewStmt1->execute();
    $reviewsResult1 = $reviewStmt1->get_result();
    while ($row = $reviewsResult1->fetch_assoc()) {
        $reviews[] = $row;
    }
    $reviewStmt1->close();
}

if ($product2) {
    $reviewStmt2 = $conn->prepare("SELECT * FROM reviews WHERE product_id = ?");
    $reviewStmt2->bind_param("i", $pid2);
    $reviewStmt2->execute();
    $reviewsResult2 = $reviewStmt2->get_result();
    while ($row = $reviewsResult2->fetch_assoc()) {
        $reviews[] = $row;
    }
    $reviewStmt2->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/productDetailStyle.css">
    <title>
        <?php
        if ($product1 && $product2) {
            echo $product1['name'] . " & " . $product2['name'];
        } elseif ($product1) {
            echo $product1['name'];
        } elseif ($product2) {
            echo $product2['name'];
        }
        ?>
    </title>
</head>

<body>
    <header class="container">
        <h1>
            <?php
            if ($product1 && $product2) {
                echo $product1['name'] . " & " . $product2['name'];
            } elseif ($product1) {
                echo $product1['name'];
            } elseif ($product2) {
                echo $product2['name'];
            }
            ?>
        </h1>
        <div id="header-right">
        <?php
                // Check whether user is logged in
                $href = isset($_SESSION['username']) ? "../logout.php" : "../login.php?redirect=$redirectUrl";
                $text = isset($_SESSION['username']) ? "Logout" : "Login";
            
                echo "<a href=$href>$text</a>";

                $profileHref = isset($_SESSION['username']) ? "../customer.php" : "../login.php?redirect=customer.php";
                echo "<a id=\"shoppingcart\" href=\"/myWebShop/src/products/shopping.php\"><img src=\"../../assets/shopping-cart.png\" alt=\"shoppingcart\"></a>
                        <span>$cart_quantity</span>";
                echo "<a id=\"profile\" href=$profileHref><img src=\"../../assets/user.png\" alt=\"Profile\"></a>";
            ?>
        </div>
    </header>
    <div id="product-info">
        <?php if ($product1): ?>
            <div id="product-container">
                <img src="<?php echo $imagepath1; ?>" alt="Product Image">
                <div id="product-option">
                    <label for="priceWOTax1">Price without taxes (€):</label>
                    <input type="number" id="priceWOTax1" step="100" value="<?php echo $product1['price']; ?>" data-original-price="<?php echo $product1['price']; ?>" oninput="updatePrices()">
                    <p id="priceWithTax1"></p>
                    <form action="addToCart.php" method="POST">
                        <fieldset>
                            <legend>OPTIONS</legend>
                            <label for="color1">Color</label>
                            </br>
                            <select id="color1">
                                <?php foreach ($colors1 as $color): ?>
                                    <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                                <?php endforeach; ?>
                            </select>
                            </br>
                            <span id="storage1">Storage</span>
                            </br>
                            <?php foreach ($storage1 as $storage): ?>
                                <input type="radio" id="storage1_<?php echo $storage; ?>" name="storage1" value="<?php echo $storage; ?>" checked>
                                <label for="storage1_<?php echo $storage; ?>"><?php echo $storage; ?>GB</label>
                            <?php endforeach; ?>
                            </br>
                            </br>
                            <input id="cart1" type="submit" value="Add to Cart">
                            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($product1['name']); ?>">
                            <input type="hidden" name="price" value="<?php echo $product1['price']; ?>">
                            <input type="hidden" id="priceWithTaxInput1" name="priceWithTax" value=""> <!-- Price with tax -->
                            <label for="quantity1">Quantity:</label>
                            <input type="number" id="quantity1" name="quantity" min="1" max="5" value="1">

                            <button type="button" id="add-to-collection1" onclick="addToCollection('product1')">Add to Collection List</button>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div>
                <table>
                    <caption>Features</caption>
                    <!-- Display in a table with two columns -->
                    <?php $i = 0; ?>
                    <?php foreach ($description1 as $feature): ?>
                        <?php if ($i % 2 == 0): ?>
                            <tr>
                            <?php endif; ?>
                            <td><?php echo $feature; ?></td>
                            <?php if ($i % 2 == 1): ?>
                            </tr>
                        <?php endif; ?>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
        <?php if ($product2): ?>
            <div id="product-container">
                <img src="<?php echo $imagepath2; ?>" alt="Product Image">
                <div id="product-option">
                    <label for="priceWOTax2">Price without taxes (€):</label>
                    <input type="number" id="priceWOTax2" step="100" value="<?php echo $product2['price']; ?>" data-original-price="<?php echo $product2['price']; ?>" oninput="updatePrices()">
                    <p id="priceWithTax2"></p>
                    <button type="button" id="apply-discount2">Apply 10% Discount</button>
                    <button type="button" id="reset-prices2">Reset Prices</button>
                    <form action="addToCart.php" method="POST">
                        <fieldset>
                            <legend>OPTIONS</legend>
                            <label for="color2">Color</label>
                            </br>
                            <select id="color2">
                                <?php foreach ($colors2 as $color): ?>
                                    <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                                <?php endforeach; ?>
                            </select>
                            </br>
                            <span id="storage2">Storage</span>
                            </br>
                            <?php foreach ($storage2 as $storage): ?>
                                <input type="radio" id="storage2_<?php echo $storage; ?>" name="storage2" value="<?php echo $storage; ?>" checked>
                                <label for="storage2_<?php echo $storage; ?>"><?php echo $storage; ?>GB</label>
                            <?php endforeach; ?>
                            </br>
                            </br>
                            <input type="hidden" name="pid" value="<?php echo $pid2; ?>">
                            <input type="hidden" name="name" value="<?php echo htmlspecialchars($product2['name']); ?>">
                            <input type="hidden" name="price" value="<?php echo $product2['price']; ?>">
                            <input id="cart2" type="submit" value="Add to Cart">
                            <label for="quantity2">Quantity:</label>
                            <input type="number" id="quantity2" name="quantity2" min="1" max="5" value="1">
                            <button type="button" id="add-to-collection2" onclick="addToCollection('product2')">Add to Collection List</button>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div>
                <table>
                    <caption>Features</caption>
                    <!-- Display in a table with two columns -->
                    <?php $i = 0; ?>
                    <?php foreach ($description2 as $feature): ?>
                        <?php if ($i % 2 == 0): ?>
                            <tr>
                            <?php endif; ?>
                            <td><?php echo $feature; ?></td>
                            <?php if ($i % 2 == 1): ?>
                            </tr>
                        <?php endif; ?>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
    <div id="collection-list">
        <h2>Collection List</h2>
        <ul id="collection-items"></ul>
        <button type="button" onclick="clearCollection()">Clear Collection List</button>
    </div>
    <!-- Review Form -->
    <div id="review-form">
        <h2>Leave a Review</h2>
        <form action="submitReview.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
            <label for="rating">Rating:</label>
            <select id="rating" name="rating" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <br>
            <label for="review">Review:</label>
            <textarea id="review" name="review" required></textarea>
            <br>
            <input type="submit" value="Submit Review">
        </form>
    </div>

    <!-- Display Reviews -->
    <div id="reviews">
        <h2>Reviews</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p><strong><?php echo htmlspecialchars($review['username']); ?></strong> (<?php echo $review['rating']; ?>/5)</p>
                    <p><?php echo htmlspecialchars($review['review']); ?></p>
                    <p><small><?php echo $review['review_date']; ?></small></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>
    </div>
    <footer>
        <a id="home" href="../index.php">Home</a>
    </footer>
    <img id="dark-mode" src="../../assets/moon.png" alt="Dark Mode" data-img-path="../../assets/" />
    <script src="../scripts/collectionList.js"></script>
    <script src="../scripts/darkMode.js"></script>
    <script src="../scripts/screenWidth.js"></script>
</body>

</html>