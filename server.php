<?php

    $servername = "us-cdbr-east-03.cleardb.com";
    $username = "b4979cf2d0482c";
    $password = "3f255760";
    $dbname = "heroku_241f063056e839a";
    $dbname2 = "heroku_241f063056e839a";

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
    $conn->set_charset("utf8");
    $db->exec("set names utf8");
?>