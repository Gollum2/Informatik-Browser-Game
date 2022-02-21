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
    <p>paragraf</p>
    <?php
    session_start();
    //echo ("<p>" . $_SESSION["pass"] . " - " . $_SESSION["id"] . " - " . $_SESSION["user"] . "</p>");
    ?>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
    <!--<script src=script.js></script>-->
    <script src="p5/p5.js"></script>
    <script>
        let width = window.innerWidth;
        let height = window.innerHeight;
        let y = 0;
        var fieldsize = 100;
        let c;
        fieldcountwidth=0;
        fiendcountheight=0;

        class Tile{
            content;
            posx;
            posy;
            type;

        }

        function setup() {
            c = createCanvas(width, height);
            c.position(0, 0);
            stroke(255); // Set line drawing color to white
            frameRate(30);
        }

        function draw() {
            console.log(width);
            //background(0); // Set the background to black
            y = y - 1;
            if (y < 0) {
                y = height;
            }
            line(0, y, width, y);
        }

        function windowResized() {
            resizeCanvas(windowWidth, windowHeight);
        }

        function mouseWheel(event) {
            print("event.delta");
            //move the square according to the vertical scroll amount
           
            //uncomment to block page scrolling
            //return false;
        }
    </script>
</body>

</html>