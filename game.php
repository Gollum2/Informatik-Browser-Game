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
    echo ("<p>" . $_SESSION["pass"] . " - " . $_SESSION["id"] . " - " . $_SESSION["user"] . "</p>");
    ?>
    <div id="maindiv" style="position:absolute;">
        <div class="feld" id="1">1</div>
    </div>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <!--<script src=script.js></script>-->
    <script>
        class feld {
            constructor(farbcode) {
                this.x = 0;
                this.y = 0;
                this.fieldcolor = farbcode;
            }
            move(xx, yy) {
                this.x = this.x + xx;
                this.y = this.y + yy;
            }
        }
        
        function setup() {
            console.log("resize");
            var newWidth = window.innerWidth;
            var newHeight = window.innerHeight;
            //console.log(newHeight);
            fieldcoutheight = parseInt((newHeight / fieldsize), 10);
            fieldcoutwidth = parseInt((newWidth / fieldsize), 10);
            heightmargin = (newHeight - fieldcoutheight * fieldsize) / 2;
            widthmargin = (newWidth - fieldcoutwidth * fieldsize) / 2;
            if (fieldcoutheight % 2 == 0) {
                fieldcoutheight -= 1;
                heightmargin += fieldsize / 2;
            }
            if (fieldcoutwidth % 2 == 0) {
                fieldcoutwidth -= 1;
                widthmargin += fieldsize / 2;
            }
            console.log(fieldcoutheight + " ist die hohe");
            console.log(fieldcoutwidth + " ist die breite");
            //'#'+Math.floor(Math.random()*16777215).toString(16); //random color 
            let temp = [];
            for (var i = 0; i < fieldcoutheight + 2; i++) {
                let temp2 = [];
                for (var j = 0; j < fieldcoutwidth + 2; j++) {
                    let randoclor = '#' + Math.floor(Math.random() * 16777215).toString(16); //random color
                    let fff;
                    if ((fieldcoutheight + 1) / 2 == i && (fieldcoutwidth + 1) / 2 == j) {
                        //console.log("mitte bei " + i + " " + j);
                        fff = new feld("#000000");
                    } else {
                        fff = new feld(randoclor);
                    }
                    fff.x = j;
                    fff.y = i;
                    temp2.push(fff);
                }
                temp.push(temp2);
            }
            //console.log(temp);
            /*temp.forEach(element => {
                console.log(JSON.stringify(element));
            });*/
            allefelder = temp;
            let test = document.getElementById("maindiv");
            test.innerHTML = "";
            for (var i = 0; i < (fieldcoutheight + 2); i++) {
                for (var j = 0; j < (fieldcoutwidth + 2); j++) {
                    let temp = document.createElement("div");
                    temp.className = "feld";
                    temp.setAttribute("class", "feld");
                    temp.style.position = "absolute";
                    //console.log(i + " -- " + j);
                    //console.log(allefelder[i][j].x * fieldsize);
                    //console.log(allefelder[i][j].y * fieldsize);
                    //console.log(JSON.stringify(allefelder[i][j]));
                    temp.style.left = (allefelder[i][j].x * fieldsize) + "px";
                    temp.style.top = (allefelder[i][j].y * fieldsize) + "px";
                    temp.style.backgroundColor = allefelder[i][j].fieldcolor;
                    test.appendChild(temp);
                }
            }
            test.style.left = -(fieldsize - widthmargin) + "px";
            test.style.top = -(fieldsize - heightmargin) + "px";
            coordsx = document.getElementById("maindiv").style.left;
            coordsy = document.getElementById("maindiv").style.top;
            /*
            console.log(coordsx);
            console.log(coordsy + " fffffffffffffffffffffffffffffff");
            coordsx = coordsx.replace("px", "");
            coordsy = coordsy.replace("px", "");
            console.log(coordsx);
            console.log(coordsy + " fffffff");
            */
            $(".feld").on("mouseover", function() {
                console.log("mouseonfield");
                $(this).css("border", "1px solid black")
            });
            $(".feld").on("mouseout", function() {
                console.log("mouseonfield");
                $(this).css("border", "none")
            });
        }
        console.log("scritp start");

        var allefelder = [];
        allefelder.push([]);
        var width = 0;
        var height = 0;
        var fieldcoutheight = 0;
        var fieldcoutwidth = 0;
        var widthmargin = 0;
        var heightmargin = 0;
        var fieldsize = 100;
        var coordsx = 0;
        var coordsy = 0;
        var tasten = {};

        document.addEventListener('keydown', function(e) {
            tasten[e.keyCode || e.which] = true;
        }, true);
        document.addEventListener('keyup', function(e) {
            tasten[e.keyCode || e.which] = false;
        }, true);
        
        document.addEventListener("scroll", function(e) {
            //onscroll 
            //fieldsize = (int)(fieldsize * 0.8)
            console.log("gescrollt");

        }, true);
        setup();
        window.addEventListener('resize', function(event) {
            setup();
        });
        let speed = 5;

        function gameloop() {
            //console.log("---");
            let vertikal = 0;
            let horizonzal = 0;
            if (tasten[87] == true) {
                //  console.log("WWWWWWWWW");
                vertikal -= speed;
            }
            if (tasten[65] == true) {
                //console.log("AAAAAAA");
                horizonzal -= speed;
            }
            if (tasten[83] == true) {
                //console.log("SSSSSSsss");
                vertikal += speed;
            }
            if (tasten[68] == true) {
                //console.log("DDDDDDDD");
                horizonzal += speed;
            }



            coordsx = parseInt(coordsx) + horizonzal;
            coordsy = parseInt(coordsy) + vertikal;

            //let top = parseInt(parseInt(test.style.top.replace("px", "")) + vertikal) + "px"
            //let left = parseInt(parseInt(test.style.left.replace("px", "")) + horizonzal) + "px";

            //console.log(coordsx);
            //console.log(coordsy);

            $("#maindiv").css("left", (coordsx + "px"));
            $("#maindiv").css("top", (coordsy + "px"));
            setTimeout(gameloop, 10); //update intervall in ms
        }
        gameloop();
    </script>
</body>

</html>