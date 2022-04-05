<?php
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
if (isset($_REQUEST['name'])) {
    if ($_REQUEST['name'] == "Gollum") {
        echo "Bin ich";
    } else {
        echo "kein gollum";
    }
}
if (isset($_REQUEST['setseed'])) {
    $_SESSION["currentseed"] = $_REQUEST['setseed'];
    $_SESSION["worldid"] = $_REQUEST["id"];
}
if (isset($_REQUEST["dataupdate"])) {
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    // Create connection
    $conn = new mysqli($servername, $username, $password,"infoprojekt");
    // Check connection
    if ($conn->connect_error) {
        echo " ups";
    }
    echo "connecion sucessfull";
    $id = $_SESSION["worldid"];
    $rawData=file_get_contents('php://input');
    echo "xxxxxxxxxxxxxxxxxxxxxxxxxx";
    //var_dump($_SERVER);
    $data = $rawData;
    var_dump($rawData);
    $stmt2=$conn->prepare("select * from welten where welten.idwelten=?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $erg = $result->fetch_all();
    $erg = $erg[0];
    //var_dump($data);
    echo "\n";
    $olddata=$erg[5];
    //$data=$olddata.$data;
    //todo check if things are placed
    /*
    for esample if on positin 3/3 there is a object 
    and i placed one ther and saved i schould update it so that there is ony 
    one and not multiple objects at that position positon 
    3/3
    */
    $stmt = $conn->prepare("update welten set welten.data=? where welten.idwelten=?");
    //echo "id data " . $id . " " . $data;
    $stmt->bind_param("si", $data, $id);
    //echo " rofl";
    $stmt->execute();
    //echo " executed";
    $conn->close();
    /*
    echo "save worked";
    */
}
