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
    $conn = new mysqli($servername, $username, $password,"infoprojekt");
    if ($conn->connect_error) {
        echo " ups";
    }
    $id = $_SESSION["worldid"];
    $rawData=file_get_contents('php://input');
    $data = $rawData;
    $stmt2=$conn->prepare("select * from welten where welten.idwelten=?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $result = $stmt2->get_result();
    $erg = $result->fetch_all();
    $erg = $erg[0];
    $olddata=$erg[5];
    $stmt = $conn->prepare("update welten set welten.data=? where welten.idwelten=?");
    $stmt->bind_param("si", $data, $id);
    $stmt->execute();
    $conn->close();
}
if(isset($_REQUEST["playerid"])){
    $servername = "localhost";
    $username = "root";
    $password = "admin";
    $conn = new mysqli($servername, $username, $password,"infoprojekt");
    if ($conn->connect_error) {
        echo " ups";
    }
    $id = $_SESSION["worldid"];
    $rawData=file_get_contents('php://input');
    $data = $rawData;
    $stmt = $conn->prepare("insert into world_player_data (playerid,worldid,playerpositionx,playerpositiony,inventory) values (?,?,?,?,?)");
    $stmt->bind_param("iiiis", $_SESSION["id"], $id,$_REQUEST["xpos"],$_REQUEST["ypos"],$data);
    $stmt->execute();
    $conn->close();
    echo "fffff";
}
?>
