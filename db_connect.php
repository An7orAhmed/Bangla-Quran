<?php
    // Prepare variables for database connection
    $username = "PUT USERNAME HERE";
    $password = "PUT PASSWORD HERE";
    $server = "localhost";
    $database = "kitsskif_quran";

    // Create connection
    $conn = new mysqli($server, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
       die("Connection failed: " . $conn->connect_error);
    } 
?>