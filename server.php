<?php

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "register_db";
    // $dbname2 = "pdo_crud_db";

    $servername = "us-cdbr-east-03.cleardb.com";
    $username = "b4979cf2d0482c";
    $password = "3f255760";
    $dbname = "heroku_241f063056e839a";
    $dbname2 = "heroku_241f063056e839a";
    // $dbname = "register_db";
    // $dbname2 = "pdo_crud_db";

    // Create Connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    try {
        $db = new PDO("mysql:host={$servername}; dbname={$dbname2}", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOEXCEPTION $e) {
        $e->getMessage();
    }
    
    mysql_query("SET character_set_results=utf8");
    mysql_query("SET character_set_client=utf8");
    mysql_query("SET character_set_connection=utf8");

    // Check Connection
    if (!$conn) {
        die("Connection Failed" . mysqli_connect_error());
    }
?>