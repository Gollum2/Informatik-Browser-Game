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
        var xxx = 0;
        var yyy = 0;
        let y = 0;
        var fieldsize = 100;
        let c;
        var fieldcountwidth = 0;
        var fieldcountheight = 0;
        var leftofsett = 0;
        var topofsett = 0;
        var tilemap = [];
        var displaywindow = [];
        let renderdistance = 1;
        var loadedchunks = []; // all chunks that are stored are inside as chunk objekt
        var masterseed=42;
        class Tile {
            content;
            posx;
            posy;
            type;
            color;
        }
        class Chunk {
            tiles = []
            chunkposx;
            chnnkposy;
        }

        function setup() {
            c = createCanvas(width, height);
            //console.log(getchunk(42, 0, 0));
            loadchunk(0,0);
            //noLoop();
            c.position(0, 0);
            stroke(255); // Set line drawing color to white
            frameRate(30);
            print("test1");
            adaptsizes(width, height);
            print("test2");
        }

        function draw() {
            for (let i = 0; i < fieldcountheight; i++) {
                for (let j = 0; j < fieldcountwidth; j++) {
                    fill(tilemap[i][j].color);
                    rect(j * (fieldsize) + leftofsett, i * (fieldsize) + topofsett, fieldsize, fieldsize);
                }
            }
        }

        function windowResized() {
            resizeCanvas(windowWidth, windowHeight);
            adaptsizes(windowWidth, windowHeight);
        }

        function mouseWheel(event) {
            print("event.delta");
        }
        3

        function adaptsizes(width, height) {
            fieldcountwidth = round(width / fieldsize);
            fieldcountheight = round(height / fieldsize);
            leftofsett = (width - fieldcountwidth * fieldsize) / 2;
            topofsett = (height - fieldcountheight * fieldsize) / 2;
            if (fieldcountheight % 2 == 0) {
                fieldcountheight -= 1;
                topofsett = round(topofsett + fieldsize / 2);
            }
            if (fieldcountwidth % 2 == 0) {
                fieldcountwidth -= 1;
                leftofsett = round(leftofsett + fieldsize / 2);
            }
            //print("adapt function" + leftofsett + " " + fieldcountwidth);
            tilemap = [];
            for (let i = 0; i < fieldcountheight; i++) {
                let temp = []
                for (let j = 0; j < fieldcountwidth; j++) {
                    t = new Tile;
                    r = random(0, 255);
                    g = random(0, 255);
                    b = random(0, 255);
                    col = "#" + hex(r, 2) + "" + hex(g, 2) + "" + hex(b, 2);
                    t.color = col;
                    //      print(t.color);
                    temp.push(t);
                }
                tilemap.push(temp);
            }
        }

        async function loaddinger(seed, cx, cy) {
            console.log("very funny");
            url = 'http://localhost:4444/chunk/' + seed + "/" + cx + "/" + cy;
            console.log(url);
            const response = await fetch(url);
            myJson = await response.json(); //extract JSON from the http response
            console.log(myJson.className);
            return myJson;
        }

        function getchunk(seed, cx, cy) {
            let ttt = null;
            console.log("ouput is funny");
            var prom = new Promise(function(resolve, reject) {
                try {
                    resolve(loaddinger(seed, cx, cy));
                } catch {
                    reject("error loading chunk");
                }
            });
            prom.then(function(result) {
                console.log("chunk " + cx + "/" + cy + " arrived");
                console.log(result);
                loadedchunks.push(result);
            }, function(err) {
                console.log(err);
            });
        }

        function loadchunk(cx, cy) {
            let ccc = null;
            let lol=0;
            while (ccc == null) {
                for (let i = 0; i < loadedchunks.length; i++) { //todo optimise by searching backwords because last added chunk will be at he end
                    if (loadedchunks[i].chunkposx == cx && loadedchunks[i].chunkposy == cy) {
                        ccc = loadedchunks[i];
                        break;
                    }
                }
                console.log("in der while");
                if (ccc == null && lol==0) {
                    getchunk(masterseed, cx, cy)
                    lol=1;
                } 
            }
            let ccy=0;
            for (let i = cy * 8; i < (cy + 1) * 8; i++) {
                //todo memory usage can be shity because 
                //i set array at certain values and it fills al the oters
                console.log("in der for schelife");
                let ccx=0;
                tilemap[i] = [];
                for (let j = cx * 8; j < (cx + 1) * 8; j++,ccx++) {
                    tilemap[i][j] = ccc.tile[ccy][ccy];
                }
            }
            console.log(tilemap);
        }
    </script>
    <?php
    //todo get seed and update it
    //echo "<script>seed=".wert."</script>
    ?>
</body>

</html>