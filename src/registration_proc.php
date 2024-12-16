<?php
    session_start();

    include('db_connect.php');

    $redirectUrl = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Create password hash
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Duplicate check
    $check_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Duplicate username
        echo "<script>
                    alert(\"This username already exists. Please enter a different username.\");
                    history.back();
                </script>";
    } else {
        // Insert user info into Users table
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        $insert_result = mysqli_query($conn, $insert_sql);

        if ($insert_result) {
            // Sign up successful
            echo "<script>
                    alert(\"Registration has been successfully completed.\");
                </script>";
            header("Location: login.php?redirect=$redirectUrl");
        } else {
            // Sign up failed
            echo "<script>
                    alert(\"Sign up failed. Please try again.\");
                    history.back();
                </script>";
        }
    }
?>