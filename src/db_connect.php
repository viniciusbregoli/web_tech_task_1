<?php
    // MySQL connection info
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "webshop_database";

    // MySQL connection attempt
    $conn = mysqli_connect($host, $username, $password, $database);
    if (!$conn) {
        exit("MySQL connection failure: " . mysqli_connect_error()); // get error msg 
    }
?>