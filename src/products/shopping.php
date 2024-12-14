<?php
session_start();
require '../db_connect.php'; // Make sure this path is correct, if needed

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Check if user is blocked
$isBlocked = false;
if ($username) {
    $stmt = $conn->prepare("SELECT blocked FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userRow = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($userRow) {
        $isBlocked = $userRow['blocked'] == 1;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle item removal
    if (isset($_POST['remove'])) {
        $pidToRemove = $_POST['pid'];
        foreach ($cart as $key => $item) {
            if ($item['pid'] === $pidToRemove) {
                unset($cart[$key]);
                break;
            }
        }
        $_SESSION['cart'] = array_values($cart); // Re-index array after removal
    }

    // Handle quantity update
    if (isset($_POST['update'])) {
        $pidToUpdate = $_POST['pid'];
        $newQuantity = (int)$_POST['quantity'];

        foreach ($cart as &$item) {
            if ($item['pid'] === $pidToUpdate) {
                if ($newQuantity < 1) {
                    $newQuantity = 1; // Ensure quantity is at least 1
                }
                $item['quantity'] = $newQuantity;
                break;
            }
        }
        $_SESSION['cart'] = $cart; // Update the session cart
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/shopping.css">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Your Shopping Cart</h1>

    <?php if (!empty($cart)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price (€)</th>
                    <th>Quantity</th>
                    <th>Subtotal (€)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $total = 0; // Initialize total sum
            foreach ($cart as $item): 
                $price = isset($item['price']) ? (float)$item['price'] : 0; // Original price
                $priceWithTax = isset($item['price_with_tax']) ? (float)$item['price_with_tax'] : $price; // Price with tax if available
                $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;

                $subtotal = $priceWithTax * $quantity; // Use price with tax for subtotal
                $total += $subtotal; // Add to total sum
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo number_format($price, 2); ?></td> 
                    <td>
                        <form action="shopping.php" method="POST" style="display:inline;">
                            <input type="hidden" name="pid" value="<?php echo $item['pid']; ?>">
                            <input type="number" name="quantity" value="<?php echo $quantity; ?>" min="1">
                            <input type="submit" name="update" value="Update Quantity">
                        </form>
                    </td>
                    <td><?php echo number_format($subtotal, 2); ?></td> 
                    <td>
                        <form action="shopping.php" method="POST" style="display:inline;">
                            <input type="hidden" name="pid" value="<?php echo $item['pid']; ?>">
                            <input type="submit" name="remove" value="Remove Item">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
        <p><strong>Total: €<?php echo number_format($total, 2); ?></strong></p>

        <?php if ($isBlocked): ?>
            <p style="color:red;">Your account is blocked by the administrator. You cannot place new orders.</p>
        <?php else: ?>
            <form method="POST" action="checkout.php">
                <button type="submit">Checkout</button>
            </form>
        <?php endif; ?>

        <form action="clearCart.php" method="POST">
            <button type="submit">Clear Cart</button> 
        </form>
    <?php else: ?>
        <p>Your cart is empty!</p>
    <?php endif; ?>

    <footer>
        <a href="../index.php">Continue Shopping</a>
    </footer>

    <img id="dark-mode" src="../../assets/moon.png" alt="Dark Mode" data-img-path="../../assets/"/>
    <script src="../scripts/darkMode.js"></script>
    <script src="../scripts/screenWidth.js"></script>
</body>
</html>
