<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = "Logout";
    $heading = "LOGGED OUT";
    $message = "Thank you for using <strong>Tech Shop</strong>";
    $loginButtonText = "Login";
    $homeButtonText = "Home";

    
    session_start(); 

    // Clear all session variables
    session_unset(); 

    // Ends the session
    session_destroy();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/logoutStyle.css">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <header>
        <h1><?php echo $heading; ?></h1>
    </header>
    <div id="logout-block">
        <p><?php echo $message; ?></p>
        <button id="login" onclick="location.href='login.php'"><?php echo $loginButtonText; ?></button>
        <button onclick="location.href='index.php'"><?php echo $homeButtonText; ?></button>
    </div>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
