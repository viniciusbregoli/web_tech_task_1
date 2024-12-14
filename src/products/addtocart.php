<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$pid = $_POST['pid'] ?? null;
$name = $_POST['name'] ?? '';
$price = $_POST['price'] ?? 0;
$priceWithTax = $_POST['priceWithTax'] ?? $price;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

if ($quantity < 1) {
    $quantity = 1;
}

if ($pid) {
    $found = false;

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['pid'] === $pid) {
            $item['quantity'] += $quantity; 
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION['cart'][] = [
            'pid' => $pid,
            'name' => $name,
            'price' => $price, // Original price
            'price_with_tax' => $priceWithTax,
            'quantity' => $quantity,
        ];
    }
}

header('Location: shopping.php');
exit;
?>
