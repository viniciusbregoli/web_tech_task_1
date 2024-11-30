<?php
// Define product data (this can be expanded or fetched from a database)
$products = [
    "iphone_16_pro" => [
        "name" => "iPhone 16 Pro",
        "image" => "https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/iphone-compare-iphone-16-pro-202409?wid=384&hei=512&fmt=jpeg&qlt=90&.v=1724187552442",
        "price" => 1199,
        "description" => [
            "<strong>6.3″ Display</strong><br><br>Super Retina XDR display
            <br>ProMotion technology
            <br>Always-On display",

            "<strong>A18 Pro chip with 6-core GPU</strong>",

            "<strong>Camera Control</strong></br></br>
            Easier way to capture</br>
            Faster access to photo and video tools</br>",

            "<strong>Pro camera system</strong></br></br>
            48MP Fusion | 48MP Ultra Wide | Telephoto</br>
            Super-high-resolution photos</br>
            (24MP and 48MP)</br>
            Next-generation portraits with Focus and Depth Control</br>
            48MP macro photography</br>
            Dolby Vision up to 4K at 120 fps</br>
            Spatial photos and videos</br>
            Latest-generation Photographic Styles",

            "<strong>Up to 10x optical zoom range</strong>",
            "<strong>Dynamic Island</strong></br></br>
            A magical way to interact with iPhone</br>",

            "strong>Up to 33 hours video playback</strong>",

            "<strong>USB‑C Supports USB 3</strong>",

            "<strong>Face ID</strong>",
        ],
        "colors" => ["Desert Titanium", "Natural Titanium", "White Titanium", "Black Titanium"],
        "storage" => [128, 256, 512, 1000] // GB options
    ],
];

// Get the product from the query parameter (e.g., ?product=iphone_16_pro)
$productKey = isset($_GET['product']) ? $_GET['product'] : 'iphone_16_pro'; // Default to iPhone 16 Pro if no product is selected

// Check if the product exists
if (!array_key_exists($productKey, $products)) {
    $productKey = 'iphone_16_pro'; // Fallback to iPhone 16 Pro if the product is not found
}

$product = $products[$productKey];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/productDetailStyle.css">
    <title><?php echo $product['name']; ?></title>
</head>
<body>
    <header class="container">
        <h1><?php echo $product['name']; ?></h1>
        <div id="header-right">
            <a id="login" href="../login.php">Login</a>
            <a id="profile" href="../customer.php"><img src="../../assets/user.png" alt="profile"></a>
        </div>
    </header>
    <div id="product-info">
        <div id="product-container">
            <img src="<?php echo $product['image']; ?>" alt="Product Image">
            <div id="product-option">
                <label for="priceWOTax">Price without taxes (€):</label>
                <input type="number" id="priceWOTax" step="100" value="<?php echo $product['price']; ?>" oninput="updatePrices()">
                <p id="priceWithTax"></p>
                <button type="button" id="apply-discount">Apply 10% Discount</button>
                <button type="button" id="reset-prices">Reset Prices</button>
                <form>
                    <fieldset>
                        <legend>OPTIONS</legend>
                        <label for="color">Color</label>
                        </br>
                        <select id="color">
                            <?php foreach ($product['colors'] as $color): ?>
                                <option value="<?php echo $color; ?>"><?php echo $color; ?></option>
                            <?php endforeach; ?>
                        </select>
                        </br>
                        <span id="storage">Storage</span>
                        </br>
                        <?php foreach ($product['storage'] as $storage): ?>
                            <input type="radio" id="storage_<?php echo $storage; ?>" name="storage" value="<?php echo $storage; ?>" checked>
                            <label for="storage_<?php echo $storage; ?>"><?php echo $storage; ?>GB</label>
                        <?php endforeach; ?>
                        </br>
                        </br>
                        <input id="cart" type="submit" value="Add to Cart">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" min="1" max="5" value="1">
                        <button type="button" id="add-to-collection" onclick="addToCollection()">Add to Collection List</button>
                        <button type="button" id="clear-collection" onclick="clearCollection()">Clear Collection List</button>
                    </fieldset>
                </form>
                <div id="collection-list">
                    <h2>Collection List</h2>
                    <ul id="collection-items"></ul>
                </div>
            </div>
        </div>
        <div>
            <table>
                <caption>Features</caption>
                <?php foreach ($product['description'] as $feature): ?>
                    <tr>
                        <td><?php echo $feature; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
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
