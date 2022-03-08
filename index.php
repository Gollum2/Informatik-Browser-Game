<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="utf-8">
    <title>Browser game</title>
    <link href="style.css" rel="stylesheet" />
</head>

<body style="background-color:gray">
    <?php
    function generateRandomString($length = 25)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!§$%&/()=?';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();
    $usernamestring = "";
    $passwordstring = "";
    $hidden1 = "hidden";
    $hidden2 = "";
    $errormessage = "";
    if (isset($_SESSION["user"])) {

        $usernamestring = $_SESSION["user"];
        $passwordstring = $_SESSION["pass"];
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST["newusername"], $_POST["newpassword"])) {
            $servername = "localhost";
            $usernamedb = "root";
            $passworddb = "admin";
            $dbname = "infoprojekt";
            // Create connection
            $conn = new mysqli($servername, $usernamedb, $passworddb, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT * FROM userr where username=?");
            $stmt->bind_param("s", $_POST["newusername"]);
            $stmt->execute();
            $result = $stmt->get_result();
            if (count($result->fetch_all()) == 0) {
                $stmt = $conn->prepare('Insert into userr (username,passwort) values (?,?);');
                $stmt->bind_param("ss", $_POST["newusername"], $_POST["newpassword"]);
                $stmt->execute();
                $_SESSION["pass"] = $pass;
                $_SESSION["user"] = $username;
            }
        }
        if (isset($_POST["register"])) {
            $hidden1 = "";
            $hidden2 = "hidden";
        }
        if (isset($_POST["userpostname"]) and isset($_POST["userpassword"])) {
            $username = $_POST["userpostname"];
            $pass = $_POST["userpassword"];
            //hier überprüfen ob user gültig ist oder nicht
            $servername = "localhost";
            $usernamedb = "root";
            $passworddb = "admin";
            $dbname = "infoprojekt";
            // Create connection
            $conn = new mysqli($servername, $usernamedb, $passworddb, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $stmt = $conn->prepare("SELECT * FROM userr where username=?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            $erg = $result->fetch_all();
            $erg = $erg[0];
            $conn->close();
            //$randomString = generateRandomString(40);
            $_SESSION["pass"] = $pass;
            $_SESSION["user"] = $username;
            if ($erg[2] == $pass) {
                $_SESSION["id"] = $erg[0];
                //print_r($randomString);
                header("Location: /game.php?");
                exit;
            }
            $usernamestring = $username;
            $passwordstring = $pass;
            $errormessage = "Username or Password incorrect";
        }
    }
    ?>
    <div class="center" <?php echo $hidden2 ?>>
        <h1>Login</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="un">Username: </label><br><input id="un" name="userpostname" type="text" value="<?php echo $usernamestring ?>" /><br>
            <label for="psw">Password: </label><br><input id="psw" name="userpassword" type="password" value="<?php echo $passwordstring ?>" /><br>
            <input type="submit" value="Login" style="width:30%;height:15%;font-size:1vm" />
        </form>
        <p><?php echo $errormessage ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="register" value="" />
            <input type="submit" value="Register" style="width:30%;height:15%;font-size:1vm" />
        </form>
        <br>
    </div>
    <div class="center" <?php echo $hidden1 ?>>
        <h1>Register</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input name="newusername" type="text" value="" required placeholder="Username" onkeyup="checkifusable(this.value)" autocomplete="off"/><br>
            <input id="p2" name="new-password" type="password" value="" required placeholder="Password" oninput="checkifsame()" autocomplete="new-password"/><br>
            <input id="p1" name="newpassword2" type="password" value="" required placeholder="Confirm Password" oninput="checkifsame()"  autocomplete="new-password"/>
            <p id="error1"></p>

            <input id="registerbutton" type="submit" style="width:3em;height:1.5em;font-size:1em" />
        </form>
        <p><?php echo $errormessage ?>
        <p id="error"></p>

    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script>
        function checkifsame() {
            console.log("funny");
            let a = document.getElementById("p1");
            let b = document.getElementById("p2");
            console.log(b.value);
            console.log(a.value);
            if (a.value == b.value) {
                document.getElementById("error").textContent = ""
                document.getElementById("registerbutton").disabled = true;
                if (a.value.length < 5 || a.value.lenght > 44) {
                    document.getElementById("error").textContent = "Passwort muss zwischen 5 und 45 zeichen lang sein"
                    document.getElementById("registerbutton").disabled = true;
                }
            } else {
                document.getElementById("error").textContent = "The passwords are not equal"
                document.getElementById("registerbutton").disabled = true;
            }

        }

        function checkifusable(string) { //wollte ajax testen
            console.log("ckeck username");
            if (string.length == 0) {
                document.getElementById("error").innerHTML = "";
                return;
            } else {
                const xmlhttp = new XMLHttpRequest();
                xmlhttp.onload = function() {
                    document.getElementById("error1").innerHTML = this.responseText;
                }
                xmlhttp.open("GET", "usermanager.php?name=" + string);
                xmlhttp.send();
            }
        }
    </script>

</body>

</html>