<?php
session_start();
require '../db_connect.php'; // Include DB connection

if (!isset($_SESSION['username'])) {
    die("You need to be logged in to place an order.");
}

$username = $_SESSION['username'];

// Check if user is blocked
$stmt = $conn->prepare("SELECT blocked FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$userRow = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($userRow && $userRow['blocked'] == 1) {
    die("Your account is blocked by the administrator. You cannot place new orders.");
}

// Ensure the cart is set and not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    die("Your cart is empty!");
}

// cart is an array of items: ['pid', 'name', 'price', 'price_with_tax', 'quantity']
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

// Start transaction
$conn->begin_transaction();
try {
    // Insert into orders table (status defaults to 'new')
    $order_stmt = $conn->prepare("INSERT INTO orders (username, total_price) VALUES (?, ?)");
    $order_stmt->bind_param("sd", $username, $total_price);
    $order_stmt->execute();
    $order_id = $order_stmt->insert_id;

    // Insert each product into order_items, including price_with_tax
    $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price, price_with_tax) VALUES (?, ?, ?, ?, ?)");

    foreach ($cart as $item) {
        $product_id = $item['pid'];
        $quantity = (int)$item['quantity'];
        $price = isset($item['price']) ? (float)$item['price'] : 0;
        $priceWithTax = isset($item['price_with_tax']) ? (float)$item['price_with_tax'] : $price;

        $item_stmt->bind_param("iiidd", $order_id, $product_id, $quantity, $price, $priceWithTax);
        $item_stmt->execute();
    }

    $conn->commit();
    unset($_SESSION['cart']); // Clear the cart after checkout
    header("Location: ../customer.php");
    exit;
} catch (Exception $e) {
    $conn->rollback();
    echo "Failed to place order: " . $e->getMessage();
}
?>