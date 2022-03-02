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
    <p id="errcode">--dfasdfadsf-</p>
    <?php
    session_start();
    //echo ("<p>" . $_SESSION["pass"] . " - " . $_SESSION["id"] . " - " . $_SESSION["user"] . "</p>");
    ?>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
    <!--<script src=script.js></script>-->
    <div>
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
        var masterseed = 42;
        var chunksize = 8;
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
            noiseSeed(masterseed);
            //console.log(getchunk(42, 0, 0));
            //loadchunk(0, 0);
            //noLoop();
            console.log(tilemap);
            c.position(0, 0);
            stroke(255); // Set line drawing color to white
            frameRate(3);
            //print("test1");
            adaptsizes(width, height);
            background("#202020");
            let invchunk = involvedchunks();
            console.log(invchunk);
            console.log(invchunk.length);
            for (let i = 0; i < invchunk.length; i++) {
                print(i + " i");
                loadchunk(invchunk[i][0], invchunk[i][1]);
            }
            console.log("-------------------------------------");
            setTimeout(function() {
                console.log(tilemap);
            }, 2000);
        }

        function draw() {
            leftborder = xxx - ceil(fieldcountwidth / 2);
            topborder = yyy - ceil(fieldcountheight / 2);
            for (let i = -1; i < fieldcountheight + 1; i++) {
                for (let j = -1; j < fieldcountwidth + 1; j++) {
                    //console.log((topborder + i)+" "+(leftborder + j));
                    //console.log(tilemap);
                    //console.log(tilemap[topborder + i][leftborder + j]);
                    try {
                        fill(tilemap[topborder + i][leftborder + j].color);
                        stroke(tilemap[topborder + i][leftborder + j].color);

                        //print(j * (fieldsize) + leftofsett);
                        //fill("#ff00ff")
                        if (i == floor(fieldcountheight / 2) && j == floor(fieldcountwidth / 2)) {
                            fill("#00ff00");
                            console.log((leftborder + j) + " -- " + (topborder + i));
                        }
                        rect(j * (fieldsize) + leftofsett, i * (fieldsize) + topofsett, fieldsize, fieldsize);
                        textSize(15);
                        fill("#ffffff");
                        //console.log();

                        text((tilemap[topborder + i][leftborder + j].value).toFixed(2) + " " +
                            tilemap[topborder + i][leftborder + j].posx + " -- " + (tilemap[topborder + i][leftborder + j].posy),
                            j * (fieldsize) + leftofsett, (i + 1) * (fieldsize) + topofsett);
                    } catch (error) {
                        console.log(error);
                    }
                }
            }
        }

        Array.prototype.containsArray = function(val) {
            var hash = {};
            for (var i = 0; i < this.length; i++) {
                hash[this[i]] = i;
            }
            return hash.hasOwnProperty(val);
        }

        function windowResized() {
            //tilemap=[];
            resizeCanvas(windowWidth, windowHeight);
            adaptsizes(windowWidth, windowHeight);
            let invchunk = involvedchunks();
            console.log(invchunk);
            console.log(invchunk.length + " count involved chunks");
            for (let i = 0; i < invchunk.length; i++) {
                print(i + " i");
                loadchunk(invchunk[i][0], invchunk[i][1]);
            }
            console.log(tilemap);
            console.log("tsefasdlfjaslöd");
        }

        function mouseWheel(event) {
            print("event.delta");
        }

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

        }

        function keyPressed() {
            console.log(key + " wurde gedruckt"); //keypressed things
            if (key == "d") {
                console.log("ffffffffffffffff");
                moveright();
            }
            if (key == "s") {
                movedown();
            }
            if (key == "w") {
                moveup();
            }
            if (key == "a") {
                moveleft();
            }
            if(keyCode===ESCAPE){
                console.log("settings");
            }
        }
        
        function removeunusedchunks() {

        }

        function moveleft() {
            let invchunk = involvedchunks();
            let erg = [];
            let rightchunk = floor((xxx - (floor(fieldcountwidth / 2) + 3)) / chunksize);
            console.log(invchunk);
            console.log([rightchunk, invchunk[0][1]]);
            if (invchunk.containsArray([rightchunk, invchunk[0][1]])) {
                console.log("chunk is already loaded no need for more before moving right");
            } else {
                let topborder = yyy - ceil(fieldcountheight / 2);
                let bottomborder = yyy + ceil(fieldcountheight / 2);
                for (let j = topborder; j <= bottomborder; j += 7) {
                    let cpy = floor(j / chunksize);
                    if (erg.containsArray([rightchunk, cpy]) == false) {
                        erg.push([rightchunk, cpy]);
                    }
                }
                if (erg.containsArray([rightchunk, (bottomborder / chunksize)]) == false) {
                    erg.push([rightchunk, floor((bottomborder / chunksize))]);
                }
                console.log("########################");
                console.log(erg);
                for (let i = 0; i < erg.length; i++) {
                    loadchunk(erg[i][0], erg[i][1]);
                }
            }
            xxx--;
        }

        function moveright() {
            let invchunk = involvedchunks();
            let erg = [];
            let rightchunk = floor((xxx + (floor(fieldcountwidth / 2) + 3)) / chunksize);
            console.log(invchunk);
            console.log([rightchunk, invchunk[0][1]]);
            if (invchunk.containsArray([rightchunk, invchunk[0][1]])) {
                console.log("chunk is already loaded no need for more before moving right");
            } else {
                let topborder = yyy - ceil(fieldcountheight / 2);
                let bottomborder = yyy + ceil(fieldcountheight / 2);
                for (let j = topborder; j <= bottomborder; j += 7) {
                    let cpy = floor(j / chunksize);
                    if (erg.containsArray([rightchunk, cpy]) == false) {
                        erg.push([rightchunk, cpy]);
                    }
                }
                if (erg.containsArray([rightchunk, (bottomborder / chunksize)]) == false) {
                    erg.push([rightchunk, floor((bottomborder / chunksize))]);
                }
                console.log("########################");
                console.log(erg);
                for (let i = 0; i < erg.length; i++) {
                    loadchunk(erg[i][0], erg[i][1]);
                }
            }
            xxx++;
        }

        function movedown() {
            let invchunk = involvedchunks();
            let erg = [];
            let topchunk = floor((yyy + (floor(fieldcountheight / 2) + 3)) / chunksize);
            console.log(invchunk);
            console.log([topchunk, invchunk[0][1]]);
            if (invchunk.containsArray([invchunk[0][1]], topchunk)) {
                console.log("chunk is already loaded no need for more before moving right");
            } else {
                let leftborder = xxx - ceil(fieldcountwidth / 2);
                let topborder = yyy - ceil(fieldcountheight / 2);
                let rightborder = xxx + ceil(fieldcountwidth / 2);
                let bottomborder = yyy + ceil(fieldcountheight / 2);
                for (let j = leftborder; j <= rightborder; j += 7) {
                    let cpx = floor(j / chunksize);
                    if (erg.containsArray([cpx, topchunk]) == false) {
                        erg.push([cpx, topchunk]);
                    }
                }
                if (erg.containsArray([floor(rightborder / chunksize), topchunk]) == false) {
                    erg.push([floor(rightborder / chunksize), topchunk]);
                }
                console.log("########################");
                console.log(erg);
                for (let i = 0; i < erg.length; i++) {
                    loadchunk(erg[i][0], erg[i][1]);
                }
            }
            yyy++;
        }

        function moveup() {
            let invchunk = involvedchunks();
            let erg = [];
            let topchunk = floor((yyy - (floor(fieldcountheight / 2) + 3)) / chunksize);
            console.log(invchunk);
            console.log([topchunk, invchunk[0][1]]);
            if (invchunk.containsArray([invchunk[0][1]], topchunk)) {
                console.log("chunk is already loaded no need for more before moving right");
            } else {
                let leftborder = xxx - ceil(fieldcountwidth / 2);
                let topborder = yyy - ceil(fieldcountheight / 2);
                let rightborder = xxx + ceil(fieldcountwidth / 2);
                let bottomborder = yyy + ceil(fieldcountheight / 2);
                for (let j = leftborder; j <= rightborder; j += 7) {
                    let cpx = floor(j / chunksize);
                    if (erg.containsArray([cpx, topchunk]) == false) {
                        erg.push([cpx, topchunk]);
                    }
                }
                if (erg.containsArray([floor(rightborder / chunksize), topchunk]) == false) {
                    erg.push([floor(rightborder / chunksize), topchunk]);
                }
                console.log("########################");
                console.log(erg);
                for (let i = 0; i < erg.length; i++) {
                    loadchunk(erg[i][0], erg[i][1]);
                }
            }
            yyy--;
        }

        function loadchunk(cx, cy) {
            let ccc = null;
            let lol = 0;
            let ccy = 0;
            for (let i = cy * 8; i < (cy + 1) * 8; i++) {
                let ccx = 0;
                if (Array.isArray(tilemap[i]) == false) {
                    tilemap[i] = [];
                }
                for (let j = cx * 8; j < (cx + 1) * 8; j++) {
                    //console.log(i+" "+j+" is a known coordinate");
                    let t = new Tile();
                    t.value = noise(i / 8, j / 8);
                    if(i==1){
                    console.log(t.value + " uwu" + i/8 + " --- " + j/8);
                    }
                    h = parseInt((t.value) * 250, 10).toString(16)
                    t.posx = j;
                    t.posy = i;
                    t.type = "generated";
                    if (0.1 < t.value && t.value < 0.2) {
                        t.color = "#" + h.padStart(6, "0");
                    } else {
                        h = h + "00";
                        h = h.padStart(6, "0")
                        t.color = "#" + h;
                    }

                    tilemap[i][j] = t;
                }
            }
            /*//console.log("tstadfasdfa");
            for (let i = cy * 8; i < (cy + 1) * 8; i++) {
                //todo memory usage can be shity because 
                //i set array at certain values and it fills al the oters
                //console.log("in der for schelife");
                let ccx = 0;
                if (Array.isArray(tilemap[i]) == false) {
                    tilemap[i] = [];
                    print("array hinzugefugt")
                }
                for (let j = cx * 8; j < (cx + 1) * 8; j++, ccx++) {
                    lol = new Tile();
                    lol.type = "FogOfWar";
                    lol.posx = j;
                    lol.posy = i;
                    lol.color = "#808080"
                    tilemap[i][j] = lol;
                }
            }
            for (let i = 0; i < loadedchunks.length; i++) { //todo optimise by searching backwords because last added chunk will be at he end
                if (loadedchunks[i].chunkposx == cx && loadedchunks[i].chunkposy == cy) {
                    ccc = loadedchunks[i];
                    console.log("chunk already stored no need to get it");
                    let ccy = 0;
                    for (let i = cy * 8; i < (cy + 1) * 8; i++, ccy++) {
                        //todo memory usage can be shity because 
                        //i set array at certain values and it fills al the oters
                        let ccx = 0;
                        if (Array.isArray(tilemap[i]) == false) {
                            tilemap[i] = [];
                        }
                        for (let j = cx * 8; j < (cx + 1) * 8; j++, ccx++) {
                            //console.log(i+" "+j+" is a known coordinate");
                            tilemap[i][j] = ccc.tile[ccy][ccx];
                        }
                    }
                    break;
                }
            }
            if (ccc == null) {
                getchunk(masterseed, cx, cy)
                console.log("chunk not found");
            }*/
            print(tilemap);
        }

        function chunkoftile(x, y) {
            let a = floor(x / chunksize);
            let b = floor(y / chunksize);
            return [a, b];
        }

        function involvedchunks() {
            erg = [];
            //print(xxx + " " + yyy + " " + fieldcountwidth + " " + fieldcountheight + " involvedchungs");
            let leftborder = xxx - ceil(fieldcountwidth / 2);
            let topborder = yyy - ceil(fieldcountheight / 2);
            let rightborder = xxx + ceil(fieldcountwidth / 2);
            let bottomborder = yyy + ceil(fieldcountheight / 2);
            //print(leftborder + " " + rightborder + " " + topborder + " " + bottomborder + " da lfjal");
            for (let i = topborder - 1; i <= bottomborder + 1; i += 7) { //todo check distanz einstellen 
                for (let j = leftborder - 1; j <= rightborder + 1; j += 7) {
                    let cpy = floor(i / chunksize);
                    let cpx = floor(j / chunksize);
                    if (erg.containsArray([cpx, cpy]) == false) {
                        erg.push([cpx, cpy]);
                    }
                }
            }
            let cpy = floor(bottomborder / chunksize);
            let cpx = floor(rightborder / chunksize);
            if (erg.containsArray([cpx, cpy]) == false) {
                erg.push([cpx, cpy]);
            }
            return erg;
        }
    </script>
    </div>
    <div>
    <h1 style="position:fixed;top: 10px;left: 10px;"    >Test</h1>
    </div>
    <?php
    //todo get seed and update it
    //echo "<script>seed=".wert."</script>
    ?>
</body>

</html>