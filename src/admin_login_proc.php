<?php
session_start();
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT username, password, is_admin FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user['password']) && $user['is_admin'] == 1) {
        $_SESSION['is_admin'] = true;
        $_SESSION['admin_username'] = $user['username'];
        header("Location: admin_dashboard.php");
        exit;
    } else {
        // Either not admin or invalid credentials
        echo "<p>Invalid credentials or you are not an admin.</p>";
        echo "<p><a href='admin_login.php'>Try again</a></p>";
    }
} else {
    header("Location: admin_login.php");
    exit;
}
echo password_hash("admin12345", PASSWORD_BCRYPT);

?>

