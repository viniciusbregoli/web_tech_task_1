<!DOCTYPE html>
<html lang="en">
<?php
    $pageTitle = "Registration";
    $heading = "Join Us";
    $legend = "REGISTRATION";
    $usernameLabel = "Username";
    $passwordLabel = "Password";
    $confirmPasswordLabel = "Confirm Password";
    $submitButtonText = "Submit";
    $backToLoginButtonText = "Back to Login";z
    ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/formStyle.css">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <h1><?php echo $heading; ?></h1>
    <form method="post" action="registration_proc.php">
        <fieldset>
            <legend><?php echo $legend; ?></legend>
            <label for="username"><?php echo $usernameLabel; ?></label>
            <input type="text" id="username" name="username" required />
            <br>
            <label for="password"><?php echo $passwordLabel; ?></label>
            <input type="password" id="password" name="password" required />
            <br>
            <label for="confirm_password"><?php echo $confirmPasswordLabel; ?></label>
            <input type="password" id="confirm_password" required />
            <br><br>
            <input type="submit" value="<?php echo $submitButtonText; ?>" />
            <button type="button" onclick="location.href='login.php'"><?php echo $backToLoginButtonText; ?></button>
        </fieldset>
    </form>
    <img id="dark-mode" src="../assets/moon.png" alt="Dark Mode" data-img-path="../assets/"/>
    <script src="./scripts/check.js"></script>
    <script src="./scripts/darkMode.js"></script>
</body>
</html>
