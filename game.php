<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <title>Browser Game</title>
    <link href="style.css" rel="stylesheet" />
    <style>

    </style>
</head>

<body style="overflow:hidden" scroll="no">
    <!--style="overflow:hidden" scroll="no"-->

    <?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();
    if (!isset($_SESSION["id"])) {
        header("Location: /index.php");
    }
    if (!isset($_SESSION["currentseed"])) {
        header("Location: /index.php");
    }
    ?>
    <div style="z-index: 10;">
        <div id="settings" style="background-color: rgba(150, 150, 150, 0.75);position: fixed;top: 0px;left: 0px;width: 100%;height: 100%;display: none;">
            <div class="settings">
                <button onclick="saveworld()" style="width:50%;height:10%;font-size: 5.5vw;">saveworld</button>
            </div>
        </div>
        <div id="craftmenu" class="craftmenu">
            <div class="inventory" id="inventory">
                <div class="inventoryspace" id="i1" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i2" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i3" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i4" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i5" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i6" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i7" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i8" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i9" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i10" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i11" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i12" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i13" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i14" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
                <div class="inventoryspace" id="i15" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            </div>
            <div class="craftarea" id="craftarea">
                <button class="recipe" id="stonetodrill" onclick='craft("5 stone=1 drill")'>5 * Stone to 1*Drill</button>
            </div>
        </div>
        <div id="taskbar" class="taskbar">
            <div id="u1" class="itemu1" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u2" class="itemu2" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u3" class="itemu3" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u4" class="itemu4" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u5" class="itemu5" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u6" class="itemu6" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u7" class="itemu7" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u8" class="itemu8" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u9" class="itemu9" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="u10" class="itemu10" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d1" class="itemd1" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d2" class="itemd2" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d3" class="itemd3" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d4" class="itemd4" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d5" class="itemd5" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d6" class="itemd6" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d7" class="itemd7" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d8" class="itemd8" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d9" class="itemd9" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
            <div id="d10" class="itemd10" ondrop="cusomdrop(event)" ondragover="allowDrop(event)"></div>
        </div>
    </div>

    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
    <script> var masterseed=<?php echo $_SESSION["currentseed"] ?> </script>
    <script src="script.js"></script>
    <script src="p5/p5.js"></script>
 

</body>

</html>