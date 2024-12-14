<?php
session_start();

// Initialize the cart if not already set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Retrieve the product details from the POST request
$pid = $_POST['pid'] ?? null;
$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// Ensure the quantity is valid
if ($quantity < 1) {
    $quantity = 1;
}

if ($pid) {
    $found = false;

    // Check if the product already exists in the cart
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['pid'] === $pid) {
            $item['quantity'] += $quantity; // Add the new quantity to the existing one
            $found = true;
            break;
        }
    }

    // If the product is not in the cart, add it as a new item
    if (!$found) {
        $_SESSION['cart'][] = [
            'pid' => $pid,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
        ];
    }
}

// Redirect back to the previous page or cart page
header('Location: shopping.php');
exit;
?>
