<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = "Admin Login";
    $heading = "Administrator Access";
    $legend = "ADMIN LOGIN";
    $usernameLabel = "Username";
    $passwordLabel = "Password";
    $loginButtonText = "Login";
    $homeLinkText = "Home";
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/formStyle.css">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <header>
        <h1><?php echo $heading; ?></h1>
    </header>
    <form method="post" action="admin_login_proc.php">
        <fieldset>
            <legend><?php echo $legend; ?></legend>
            <label for="username"><?php echo $usernameLabel; ?></label>
            <input type="text" id="username" name="username" required />
            <br>
            <label for="password"><?php echo $passwordLabel; ?></label>
            <input type="password" id="password" name="password" required />
            <br><br>
            <input type="submit" value="<?php echo $loginButtonText; ?>" />
        </fieldset>
    </form>
    <footer>
        <a id="home" href="index.php"><?php echo $homeLinkText; ?></a>
    </footer>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
