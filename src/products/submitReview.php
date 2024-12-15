<?php
session_start();
require '../db_connect.php';

if (!isset($_SESSION['username'])) {
    die("You need to log in to leave a review.");
}

$username = $_SESSION['username'];
$product_id = $_POST['product_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];

$stmt = $conn->prepare("INSERT INTO reviews (product_id, username, rating, review) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $product_id, $username, $rating, $review);
$stmt->execute();
$stmt->close();

header("Location: product.php?pid=$product_id");
exit;
