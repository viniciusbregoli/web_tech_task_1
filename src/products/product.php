<?php

$json = file_get_contents('../json/product.json');
$products = json_decode($json, true);
$product = null;

if(isset($_GET["pid"])) {
    $pid = $_GET["pid"];
    if(empty($pid)) {
        //echo "No value fo the parameter!";
        header("location: ../error.php");
    } else {
        if(isset($products['product'])) {
            foreach($products['product'] as $p) {
                if($p['pid'] == $pid) {
                    $product = $p;
                    break;
                }
            }
        }
    }
} else {
    //echo "Parameter is missing!";
    header("location: ../error.php");
}
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
            <img src="<?php echo $product['imagepath']; ?>" alt="Product Image">
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

                <!-- Display in a table with two columns -->
                <?php $i = 0; ?>
                <?php foreach ($product['description'] as $feature): ?>
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
