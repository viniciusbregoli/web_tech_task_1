<?php
session_start();

// Clear the shopping cart
unset($_SESSION['cart']);

header("Location: shopping.php");
exit();
?>
