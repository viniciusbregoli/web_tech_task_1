<?php
session_start();
require 'db_connect.php';

// Check if admin is logged in
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header("Location: admin_login.php");
    exit;
}

// Handle updates to order status and blocking/unblocking users
if (isset($_GET['new_status']) && isset($_POST['order_id'])) {
    $orderId = (int)$_POST['order_id'];
    $newStatus = $_GET['new_status'];
    $rejectionReason = $_POST['rejection_reason'] ?? null;

    $stmt = $conn->prepare("UPDATE orders SET status = ?, rejection_reason = ? WHERE order_id = ?");
    $stmt->bind_param("ssi", $newStatus, $rejectionReason, $orderId);
    $stmt->execute();
    $stmt->close();
}

// Block/Unblock Users
if (isset($_POST['block_user']) && isset($_POST['username'])) {
    $usernameToBlock = $_POST['username'];
    $blockStmt = $conn->prepare("UPDATE users SET blocked = 1 WHERE username = ?");
    $blockStmt->bind_param("s", $usernameToBlock);
    $blockStmt->execute();
    $blockStmt->close();
}

if (isset($_POST['unblock_user']) && isset($_POST['username'])) {
    $usernameToUnblock = $_POST['username'];
    $unblockStmt = $conn->prepare("UPDATE users SET blocked = 0 WHERE username = ?");
    $unblockStmt->bind_param("s", $usernameToUnblock);
    $unblockStmt->execute();
    $unblockStmt->close();
}

// Fetch orders by status
function fetchOrdersByStatus($conn, $status) {
    $stmt = $conn->prepare("SELECT order_id, username, total_price, order_date, status, rejection_reason FROM orders WHERE status = ? ORDER BY order_date DESC");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    return $stmt->get_result();
}

$newOrders = fetchOrdersByStatus($conn, 'new');
$inProcessOrders = fetchOrdersByStatus($conn, 'in_process');
$shippedOrders = fetchOrdersByStatus($conn, 'shipped');
$rejectedOrders = fetchOrdersByStatus($conn, 'rejected');
$finishedOrders = fetchOrdersByStatus($conn, 'finished');

// Fetch all users for blocking/unblocking
$users = $conn->query("SELECT username, blocked, is_admin FROM users");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <!-- Link to the CSS file with @import and styling similar to given snippet -->
    <link rel="stylesheet" type="text/css" href="./css/shopping.css">
</head>
<body>
<header>    
    <h1>Welcome Admin: <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h1>
    <a href="logout.php">Logout</a>
</header>


<h2>New Orders</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total (€)</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($order = $newOrders->fetch_assoc()): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo htmlspecialchars($order['username']); ?></td>
            <td><?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo $order['order_date']; ?></td>
            <td>
                <form method="POST" action="?new_status=in_process" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                    <button type="submit">Set In Process</button>
                </form>
                <form method="POST" action="?new_status=rejected" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                    <input type="text" name="rejection_reason" placeholder="Rejection Reason">
                    <button type="submit">Reject</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<h2>In Process Orders</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total (€)</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($order = $inProcessOrders->fetch_assoc()): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo htmlspecialchars($order['username']); ?></td>
            <td><?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo $order['order_date']; ?></td>
            <td>
                <form method="POST" action="?new_status=shipped" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                    <button type="submit">Set Shipped</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<h2>Shipped Orders</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total (€)</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($order = $shippedOrders->fetch_assoc()): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo htmlspecialchars($order['username']); ?></td>
            <td><?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo $order['order_date']; ?></td>
            <td>
                <form method="POST" action="?new_status=finished" style="display:inline;">
                    <input type="hidden" name="order_id" value="<?php echo $order['order_id']; ?>">
                    <button type="submit">Set Finished</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<h2>Rejected Orders</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total (€)</th>
            <th>Date</th>
            <th>Reason</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($order = $rejectedOrders->fetch_assoc()): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo htmlspecialchars($order['username']); ?></td>
            <td><?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo $order['order_date']; ?></td>
            <td><?php echo htmlspecialchars($order['rejection_reason']); ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<h2>Finished Orders</h2>
<table>
    <thead>
        <tr>
            <th>Order ID</th>
            <th>User</th>
            <th>Total (€)</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($order = $finishedOrders->fetch_assoc()): ?>
        <tr>
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo htmlspecialchars($order['username']); ?></td>
            <td><?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo $order['order_date']; ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<h2>Manage Customers (Block/Unblock)</h2>
<table>
    <thead>
        <tr>
            <th>Username</th>
            <th>Blocked Status</th>
            <th>Admin?</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td><?php echo $user['blocked'] ? "Blocked" : "Active"; ?></td>
            <td><?php echo $user['is_admin'] ? "Yes" : "No"; ?></td>
            <td>
                <?php if (!$user['is_admin']): // Don't allow blocking admins ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
                        <?php if ($user['blocked']): ?>
                            <button type="submit" name="unblock_user">Unblock</button>
                        <?php else: ?>
                            <button type="submit" name="block_user">Block</button>
                        <?php endif; ?>
                    </form>
                <?php else: ?>
                    <p>Can't block admins</p>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
<script src="./scripts/darkMode.js"></script>
</body>
</html>
