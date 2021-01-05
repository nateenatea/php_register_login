<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "register_db";
    $dbname2 = "pdo_crud_db";

    // Create Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    try {
        $db = new PDO("mysql:host={$servername}; dbname={$dbname2}", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }

    // Check Connection
    if (!$conn) {
        die("Connection Failed" . mysqli_connect_error());
    }
?>