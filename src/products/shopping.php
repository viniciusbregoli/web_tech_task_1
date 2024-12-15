<?php
session_start();
require '../db_connect.php'; // Make sure this path is correct

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

// Check if user is blocked and get user_order_count
$isBlocked = false;
$user_order_count = 0;
if ($username) {
    $stmt = $conn->prepare("SELECT blocked, user_order_count FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $userRow = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if ($userRow) {
        $isBlocked = $userRow['blocked'] == 1;
        $user_order_count = (int)$userRow['user_order_count'];
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
        $_SESSION['cart'] = array_values($cart); 
    }

    // Handle quantity update
    if (isset($_POST['update'])) {
        $pidToUpdate = $_POST['pid'];
        $newQuantity = (int)$_POST['quantity'];

        foreach ($cart as &$item) {
            if ($item['pid'] === $pidToUpdate) {
                if ($newQuantity < 1) {
                    $newQuantity = 1; 
                }
                $item['quantity'] = $newQuantity;
                break;
            }
        }
        $_SESSION['cart'] = $cart; 
    }
}

// Determine if next order qualifies for a discount
$nextOrderCount = $user_order_count + 1;
$discountMessage = "";
$discount = 0;
if ($nextOrderCount % 20 == 0) {
    $discountMessage = "Great news! Your next order (this one) will receive a 20% discount at checkout.";
    $discount = 0.20;
} elseif ($nextOrderCount % 10 == 0) {
    $discountMessage = "Great news! Your next order (this one) will receive a 10% discount at checkout.";
    $discount = 0.10;
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
        <?php if ($discountMessage): ?>
            <p style="color: green; font-weight:bold;"><?php echo $discountMessage; ?></p>
        <?php endif; ?>
        
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
            $total = 0; 
            foreach ($cart as $item): 
                $price = isset($item['price']) ? (float)$item['price'] : 0; 
                $priceWithTax = isset($item['price_with_tax']) ? (float)$item['price_with_tax'] : $price; 
                $quantity = isset($item['quantity']) ? (int)$item['quantity'] : 1;

                $subtotal = $priceWithTax * $quantity; 
                $total += $subtotal; 
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

        <?php if ($discount > 0): ?>
            <?php $discountedTotal = $total - ($total * $discount); ?>
            <p><strong>Total (without discount): €<?php echo number_format($total, 2); ?></strong></p>
            <p style="color:green;"><strong>Discounted Total: €<?php echo number_format($discountedTotal, 2); ?></strong></p>
        <?php else: ?>
            <p><strong>Total: €<?php echo number_format($total, 2); ?></strong></p>
        <?php endif; ?>

        <?php if ($isBlocked): ?>
            <p style="color:red;">Your account is blocked by the administrator. You cannot place new orders.</p>
        <?php else: ?>
            <form method="POST" action="checkout.php">
                <button type="submit">Checkout</button>
            </form>
        <?php endif; ?>

        <form action="clearCart.php" method="POST">
            <input type="submit" value="Clear Cart">
        </form>
    <?php else: ?>
        <p>Your cart is empty!</p>
    <?php endif; ?>

    <footer>
        <a href="javascript:history.back();">Continue Shopping</a>
    </footer>

    <img id="dark-mode" src="../../assets/moon.png" alt="Dark Mode" data-img-path="../../assets/"/>
    <script src="../scripts/darkMode.js"></script>
    <script src="../scripts/screenWidth.js"></script>
</body>
</html>
