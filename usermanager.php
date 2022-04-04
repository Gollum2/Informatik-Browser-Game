<?php
session_start();
if (isset($_REQUEST['name'])) {
    if ($_REQUEST['name'] == "Gollum") {
        echo "Bin ich";
    } else {
        echo "kein gollum";
    }
}
if (isset($_REQUEST['setseed'])) {
    $_SESSION["currentseed"] = $_REQUEST['setseed'];
}
if (isset($_REQUEST["dataupdate"])) {
    $servername = "localhost:3306";
    $username = "root";
    $password = "admin";
    // Create connection
    $conn = new mysqli($servername, $username, $password);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
}
