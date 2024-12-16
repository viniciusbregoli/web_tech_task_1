<?php
session_start();
require '../db_connect.php'; // Include DB connection

$redirectUrl='./products/shopping.php';

if (!isset($_SESSION['username'])) {
    echo "<script>
        alert(\"You need to be logged in to place an order.\");
        location.href=\"../login.php?redirect=$redirectUrl\";
    </script>";
    exit;
}

$username = $_SESSION['username'];

// Check if user is blocked
$stmt = $conn->prepare("SELECT blocked, user_order_count FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$userRow = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$userRow) {
    die("User not found.");
}

if ($userRow['blocked'] == 1) {
    die("Your account is blocked by the administrator. You cannot place new orders.");
}

// Ensure the cart is set and not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Your cart is empty!");
}

$cart = $_SESSION['cart'];
$total_price = 0;

// Calculate total price using price_with_tax if available
foreach ($cart as $item) {
    $price = isset($item['price']) ? (float)$item['price'] : 0;
    $priceWithTax = isset($item['price_with_tax']) ? (float)$item['price_with_tax'] : $price;
    $quantity = (int)$item['quantity'];
    $subtotal = $priceWithTax * $quantity;
    $total_price += $subtotal;
}

// Determine discount based on the user's order count
$currentOrderCount = (int)$userRow['user_order_count'] + 1; // This will be the user's next order number
$discount = 0;

if ($currentOrderCount % 20 == 0) {
    $discount = 0.20; // 20% discount on every 20th order
} elseif ($currentOrderCount % 10 == 0) {
    $discount = 0.10; // 10% discount on every 10th order
}

if ($discount > 0) {
    $total_price = $total_price - ($total_price * $discount);
}

$conn->begin_transaction();
try {
    // Insert order
    $order_stmt = $conn->prepare("INSERT INTO orders (username, total_price) VALUES (?, ?)");
    $order_stmt->bind_param("sd", $username, $total_price);
    $order_stmt->execute();
    $order_id = $order_stmt->insert_id;
    $order_stmt->close();

    // Insert each product into order_items
    $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, price_with_tax) VALUES (?, ?, ?, ?, ?)");
    foreach ($cart as $item) {
        $product_id = $item['pid'];
        $quantity = (int)$item['quantity'];
        $price = isset($item['price']) ? (float)$item['price'] : 0;
        $priceWithTax = isset($item['price_with_tax']) ? (float)$item['price_with_tax'] : $price;
        $item_stmt->bind_param("iiidd", $order_id, $product_id, $quantity, $price, $priceWithTax);
        $item_stmt->execute();
    }
    $item_stmt->close();

    // Update user_order_count for the user
    $update_user = $conn->prepare("UPDATE users SET user_order_count = user_order_count + 1 WHERE username = ?");
    $update_user->bind_param("s", $username);
    $update_user->execute();
    $update_user->close();

    $conn->commit();
    unset($_SESSION['cart']); // Clear the cart after checkout
    header("Location: ../customer.php");
    exit;
} catch (Exception $e) {
    $conn->rollback();
    echo "Failed to place order: " . $e->getMessage();
}
