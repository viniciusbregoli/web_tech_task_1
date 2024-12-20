<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['username'])) {
    die("You need to log in to view your orders.");
}

$username = $_SESSION['username'];

// Check if user is blocked
$userStmt = $conn->prepare("SELECT blocked FROM users WHERE username = ?");
$userStmt->bind_param("s", $username);
$userStmt->execute();
$userResult = $userStmt->get_result()->fetch_assoc();
$isBlocked = $userResult['blocked'] == 1;
$userStmt->close();

if (isset($_POST['cancel_order'])) {
    $orderIdToCancel = (int)$_POST['order_id'];
    
    // First check if the order is in 'new' state to ensure it affects the user_order_count
    $checkOrderStatus = $conn->prepare("SELECT status FROM orders WHERE order_id = ? AND username = ?");
    $checkOrderStatus->bind_param("is", $orderIdToCancel, $username);
    $checkOrderStatus->execute();
    $statusResult = $checkOrderStatus->get_result()->fetch_assoc();
    $checkOrderStatus->close();

    if ($statusResult && $statusResult['status'] == 'new') {
        // Cancel the order
        $updateStmt = $conn->prepare("UPDATE orders SET status = 'canceled' WHERE order_id = ? AND username = ? AND status = 'new'");
        $updateStmt->bind_param("is", $orderIdToCancel, $username);
        $updateStmt->execute();
        $affectedRows = $updateStmt->affected_rows; // Check if actually updated
        $updateStmt->close();

        if ($affectedRows > 0) {
            // If the order was indeed canceled, decrement user_order_count by 1
            $decrementCount = $conn->prepare("UPDATE users SET user_order_count = user_order_count - 1 WHERE username = ? AND user_order_count > 0");
            $decrementCount->bind_param("s", $username);
            $decrementCount->execute();
            $decrementCount->close();
        }
    }
}

// Fetch orders including total_price
$query = $conn->prepare("
    SELECT o.order_id, o.order_date, o.status, o.rejection_reason, o.total_price,
           p.name AS product_name, oi.quantity, oi.price, oi.price_with_tax
    FROM orders o
    JOIN order_items oi ON o.order_id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.username = ?
    ORDER BY o.order_date DESC, o.order_id DESC
");
$query->bind_param("s", $username);
$query->execute();
$result = $query->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $order_id = $row['order_id'];
    if (!isset($orders[$order_id])) {
        $orders[$order_id] = [
            'order_id' => $order_id,
            'order_date' => $row['order_date'],
            'status' => $row['status'],
            'rejection_reason' => $row['rejection_reason'],
            'total_price' => (float)$row['total_price'], 
            'items' => []
        ];
    }

    $orders[$order_id]['items'][] = [
        'product_name' => $row['product_name'],
        'quantity' => (int)$row['quantity'],
        'price' => (float)$row['price'],
        'price_with_tax' => isset($row['price_with_tax']) ? (float)$row['price_with_tax'] : (float)$row['price']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Profile</title>
    <link rel="stylesheet" type="text/css" href="./css/customer.css">
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($username); ?></h1>
        <?php if ($isBlocked): ?>
            <p style="color:red;">Your account is blocked by the administrator. You cannot place new orders.</p>
        <?php endif; ?>
        <a href="logout.php">Logout</a>
    </header>
    <h2>Your Orders</h2>
    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <?php
            // Calculate what the total would have been without discount:
            $fullTotal = 0;
            foreach ($order['items'] as $item) {
                $fullTotal += $item['price_with_tax'] * $item['quantity'];
            }

            $discountApplied = $order['total_price'] < $fullTotal;
            ?>
            <div class="order" style="margin-bottom: 20px;">
                <h3>
                    Order ID: <?php echo $order['order_id']; ?> | 
                    Date: <?php echo $order['order_date']; ?>
                </h3>
                <p>Status: <?php echo htmlspecialchars($order['status']); ?></p>
                <?php if ($order['status'] == 'rejected'): ?>
                    <p>Reason: <?php echo htmlspecialchars($order['rejection_reason']); ?></p>
                <?php endif; ?>

                <table border="1" style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Price (€)</th>
                            <th>Quantity</th>
                            <th>Subtotal (€)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($order['items'] as $item): 
                            $price = $item['price'];
                            $priceWithTax = $item['price_with_tax'];
                            $quantity = $item['quantity'];
                            $subtotal = $priceWithTax * $quantity; 
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td><?php echo number_format($price, 2); ?></td>
                                <td><?php echo $quantity; ?></td>
                                <td><?php echo number_format($subtotal, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p><strong>Total: €<?php echo number_format($order['total_price'], 2); ?></strong>
                <?php if ($discountApplied): ?>
                    <span style="color:green; font-weight:bold;">(Discount Applied!)</span>
                <?php endif; ?>
                </p>

                <?php if ($order['status'] == 'new'): ?>
                    <form method="POST">
                        <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                        <button type="submit" name="cancel_order">Cancel Order</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>You have no orders.</p>
    <?php endif; ?>

    <footer>
        <a href="index.php">Home</a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/check.js"></script>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
