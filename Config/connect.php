<?php
    $server = "localhost";
    $username = "u21s4j7n6y8o_BanHocTapNCKHBIT";
    $password = "BITbanhoctapnckh@2025";
    $database = "u21s4j7n6y8o_luadetsudo";

    $conn = new mysqli($server, $username, $password,$database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>