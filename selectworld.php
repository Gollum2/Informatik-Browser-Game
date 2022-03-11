<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <link href="style2.css" rel="stylesheet" />
</head>

<body>
    <?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();
    $servername = "localhost";
    $usernamedb = "root";
    $passworddb = "admin";
    $dbname = "infoprojekt";
    // Create connection
    $conn = new mysqli($servername, $usernamedb, $passworddb, $dbname);
    // Check connection
    var_dump($_POST);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if (isset($_POST["seed"]) && isset($_POST["name"])) {
        //echo "ffffffffffffffffffffffffffffffffff";
        //echo $_POST["seed"] . "-----------" . $_SESSION["id"] . "-----------" . $_POST["visibility"];
        $stmt = $conn->prepare("SELECT count(*) FROM welten WHERE weltname=?");
        $stmt->bind_param("s", $_POST["name"]);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_row();
        $value = $row[0] ?? false;
        //echo ($value);
        //echo "<br>fadfasdfasdfasdfasdf<br>";
        if ($value == 0) {
            $stmt = $conn->prepare('INSERT INTO welten (seed, creatorid, visibility,weltname) value (?,?,?,?)');
            //echo "<br><br><br>";
            //echo $_POST["seed"] . " ## " . $_SESSION["id"] . " ## " . $_POST["visibility"] . " ## " . $_POST["name"];
            $stmt->bind_param("iiss", $_POST["seed"], $_SESSION["id"], $_POST["visibility"], $_POST["name"]);
            $stmt->execute();
            //echo "dddddddddddddddddddddddddddd";
        }
    }
    //echo ("<p>" . $_SESSION["pass"] . " pass - " . $_SESSION["id"] . " id - " . $_SESSION["user"] . " user</p>");
    $stmt = $conn->prepare("SELECT * FROM welten WHERE creatorid=?");
    $stmt->bind_param("i", $_SESSION["id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    $erg = $result->fetch_all();
    echo "qwertzuiop<br>";

    var_dump($erg);

    echo "qwertzuiop<br>";
    var_dump($erg[0]);
    $selection = "";
    for ($i = 0; $i < count($erg); $i++) {
        $temp = '<div class="worlddiv" id=""><h1>' . $erg[$i][7] . '</h1><h2>' . $erg[$i][1] . '</h2><p>creator' . $erg[$i][2] . '  Visits' . $erg[$i][3] . '  Timespend:' . $erg[$i][4] . '</p><p>' . $erg[$i][6] . '</p></div>';
        $selection .= $temp;
    }
    //var_dump($erg);
    echo $selection;
    ?>
    <br><button id="newwordbutton" onclick="shownewworld()">Create New World</button>
    <div id="newworldsetting" style='display:none'>
        <form method="POST" id="generateform" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input name="seed" type="number" id="seedinput2" placeholder="seed" value="" />
            <input name="name" type="text" id="nameinput" placeholder="Name" value="" /><br>
            <label onclick="box(document.getElementById(privatecheckbox))" for="privatecheckbox">Private</label><input onchange="box(this)" id="privatecheckbox" type="checkbox" name="visibility" value="private">
            <label onclick="box(document.getElementById(publiccheckbox))" for="publiccheckbox">Public</label><input onchange="box(this)" id="publiccheckbox" type="checkbox" name="visibility" value="public">
            <label onclick="box(document.getElementById(onlyforfriends))" for="onlyforfriends">Friends Only</label><input onchange="box(this)" id="onlyforfriends" type="checkbox" name="visibility" value="frieds">
            <input id="submitbutton" type="submit" value="Erstellen" disabled>
        </form>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
        $(".worlddiv").click(function() {
            window.location.href = "/localhost:81/game.php";
        });

        function shownewworld() {
            if (document.getElementById("newworldsetting").style.display == "none") {
                document.getElementById("newworldsetting").style.display = "block";
            } else {
                document.getElementById("newworldsetting").style.display = "none";
            }
        }

        function box(a) {
            document.getElementById("privatecheckbox").checked = false;
            document.getElementById("publiccheckbox").checked = false;
            document.getElementById("onlyforfriends").checked = false;
            a.checked = true;
        }
        var form = document.getElementById("generateform");
        form.addEventListener('change', function() {
            let a = document.getElementById("privatecheckbox").checked;
            let b = document.getElementById("publiccheckbox").checked;
            let c = document.getElementById("onlyforfriends").checked;
            console.log("onchagn");
            let d = document.getElementById("seedinput2").value;
            let e = document.getElementById("nameinput").value;
            if ((a || b || c) && d != "" && e != "") {
                document.getElementById("submitbutton").disabled = false;
            }
        });
    </script>
</body>

</html>