
let inventory = [];
let width = window.innerWidth;
let height = window.innerHeight;
var xxx = 0;
var yyy = 0;
let y = 0;
var fieldsize = 50;
let c;
var fieldcountwidth = 0;
var fieldcountheight = 0;
var leftofsett = 0;
var topofsett = 0;
var tilemap = [];
var displaywindow = [];
let renderdistance = 1;
var loadedchunks = []; // all chunks that are stored are inside as chunk objekt
//var masterseed = 42;
var chunksize = 8;
var placedthingsstring = [];
var selected = null;
var quickbar = [
    [],
    []
];
var ids = 0;
var allthingsthatareitemsandidontwantthisnametobeusedagain = document.querySelector('.Thing');

class Tile {
    content;
    posx;
    posy;
    type;
    color;
    resource;
    resourceamout;
}
class Chunk {
    tiles = []
    chunkposx;
    chnnkposy;
}
class Item {
    name;
    amount;
    color;
    icon;
}

class Thing extends Item {
    image;
    storage;
    openmashine() {
        console.log("open maschine insides to get things");
    }
}


class Drill extends Thing {
    icon = "/data/drill.gif";
}


function setup() {
    for (let i = 0; i < 10; i++) {
        quickbar[1][i] = "";
        quickbar[0][i] = "";
    }
    for (let i = 0; i < 15; i++) {
        inventory.push([]);
    }
    c = createCanvas(width, height);
    //console.log(getchunk(42, 0, 0));
    //loadchunk(0, 0);
    //noLoop();
    document.getElementById("craftmenu").style.display = "none";
    document.getElementById("settings").style.display = "none";
    c.style('z-index', -10);
    console.log(tilemap);
    c.position(0, 0);
    c.mouseOver(function () {
        console.log("dies ist ein test sobald die maus auf canvas geht");
    });
    c.mousePressed(angeklickt);
    stroke(255); // Set line drawing color to white
    frameRate(5);
    //print("test1");
    adaptsizes(width, height);
    background("#202020");
    let invchunk = involvedchunks();
    console.log(invchunk);
    console.log(invchunk.length);
    for (let i = 0; i < invchunk.length; i++) {
        //print(i + " i");
        loadchunk(invchunk[i][0], invchunk[i][1]);
    }
    console.log("-------------------------------------");
    setTimeout(function () {
        console.log("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
        console.log(tilemap);
        console.log(masterseed + "qqqwertzuiopüäölkjhgfdsaayxcvbnm");
    }, 10000);
    updatequickbar();
}

function draw() {
    leftborder = xxx - ceil(fieldcountwidth / 2);
    topborder = yyy - ceil(fieldcountheight / 2);
    mouseoverx = leftborder + floor((mouseX - leftofsett) / fieldsize);
    mouseovery = topborder + floor((mouseY - topofsett) / fieldsize);

    //updatequickbar();
    for (let i = -1; i < fieldcountheight + 1; i++) {
        for (let j = -1; j < fieldcountwidth + 1; j++) {

            try {
                fill(tilemap[topborder + i][leftborder + j].color);
                stroke(tilemap[topborder + i][leftborder + j].color);
                if (i == floor(fieldcountheight / 2) && j == floor(fieldcountwidth / 2)) {
                    fill("#00ff00");
                    //console.log((leftborder + j) + " -- " + (topborder + i));
                }
                rect(j * (fieldsize) + leftofsett, i * (fieldsize) + topofsett, fieldsize, fieldsize);
                if (tilemap[topborder + i][leftborder + j].content instanceof Thing) {
                    //console.log("thing lost");
                    fill("#ffff00"); // set to icon of thing 
                    if (tilemap[topborder + i][leftborder + j].content.image != null && tilemap[topborder + i][leftborder + j].content.image != "" &&
                        isNaN(tilemap[topborder + i][leftborder + j].content.image)) {
                        //console.log("ffffffffffffffffffffffffffffffffffffffff");
                        image(tilemap[topborder + i][leftborder + j].content.image, j * (fieldsize) + leftofsett, i * (fieldsize) + topofsett, fieldsize, fieldsize);
                    }
                    //rect(j * (fieldsize) + leftofsett, i * (fieldsize) + topofsett, fieldsize, fieldsize)
                }
                //textSize(5);
                //fill("#ffffff");
                //text((tilemap[topborder + i][leftborder + j].value).toFixed(2) + " " + (leftborder + j) + " -- " + (topborder + i),
                //   j * (fieldsize) + leftofsett, (i + 1) * (fieldsize) + topofsett);
            } catch (error) {
                console.log("thing not found");
                //console.log(error);
                //console.log(involvedchunks());
            }
        }
    }
    if (selected instanceof Thing) {
        //console.log(mouseoverx + " / " + mouseovery + "   " + selected + " ## " + leftborder + "/" + topborder);
        //console.log((abs(leftborder) + mouseoverx) + "//" + (abs(topborder) + mouseovery));
        fill("#ff0000");
        rect((abs(leftborder) + mouseoverx) * fieldsize + leftofsett, (abs(topborder) + mouseovery) * fieldsize + topofsett, fieldsize, fieldsize);
    }
}

function saveworld() {
    console.log("saveworld");
    console.log(placedthingsstring);
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function () {
        //todo confirm that save was succesfull
    }
    xmlhttp.open("GET", "usermanager.php?dataupdate=" + string);
    xmlhttp.send();


}

function craft(a) {

    function selectitem(ding) {
        console.log("selected functoin");
        //console.log(ding);
        //console.log(ding.parentNode);
        //ding.style.opacity = 0.8;
        let temp = ding.parentNode.id;
        console.log(temp);
        if (temp[0] == "u") {
            console.log("upper");
            selected = quickbar[0][temp[1] - 1];
        }
        if (temp[0] == "d") {
            selected = quickbar[1][temp[1] - 1];
        }
        if (temp[0] == "i") {
            selected = inventory[temp[1] - 1];
        }
        console.log(selected);
        //ding.style.opacity = 0.5;
    }

    function updatequickbar() {
        //console.log(quickbar);
        for (let i = 0; i < quickbar[0].length; i++) {
            slot = document.getElementById("u" + (i + 1));
            if (quickbar[0][i] instanceof Item) {
                //console.log(quickbar[0][i].icon);
                if (quickbar[0][i].amount > 0) {
                    slot.innerHTML = '<div id="divlost' + ids + '" draggable="true" ondragstart="drag(event)" onclick="selectitem(this)" style="width:50px;height:50px;position:absolute">' +
                        '<img src=' + quickbar[0][i].icon + ' class="icon" width="50" height="50" id="picture' + ids + '" draggable="false" ondrop="customdrop2(event) ondragstart="false;">' +
                        '<p style="position:absolute;top:-10px;right:0px">' + quickbar[0][i].amount + "</p></div>";
                    ids++;
                } else {
                    quickbar[0][i] = "";
                }
            } else {
                slot.innerHTML = "";
            }
            slot = document.getElementById("d" + (i + 1));
            if (quickbar[1][i] instanceof Item) {
                //console.log(quickbar[1][i].icon);
                if (quickbar[1][i].amount > 1) {
                    slot.innerHTML = '<div id="downquickbarlost' + ids + '" draggable="true" ondragstart="drag(event)" onclick="selectitem(this)" style="width:50px;height:50px;position:absolute">' +
                        '<img src=' + quickbar[1][i].icon + ' class="icon" width="50" height="50" id="picture2' + ids + '"  draggable="false" ondrop="customdrop2(event)" ondragstart="false;">' +
                        '<p style="position:absolute;top:-10px;right:0px">' + quickbar[1][i].amount + "</p></div>";
                    ids++;
                } else {
                    quickbar[1][i] = "";
                }
            } else {
                slot.innerHTML = "";
            }
        }
        for (let i = 0; i < inventory.length; i++) {
            slot = document.getElementById("i" + (i + 1));
            if (inventory[i] instanceof Item) {
                //console.log(inventory[i].icon);
                if (inventory[i].amount > 0) {
                    slot.innerHTML = '<div id="downquickbarlost' + ids + '" draggable="true" ondragstart="drag(event)" onclick="selectitem()" style="width:50px;height:50px;position:absolute">' +
                        '<img src=' + inventory[i].icon + ' class="icon" width="50" height="50" id="inventor' + ids + '"ondrop="customdrop2(event) draggable="false" ondragstart="false;">' +
                        '<p style="position:absolute;top:-10px;right:0px">' + inventory[i].amount + "</p></div>";
                    ids++;
                } else {
                    inventory[i] = "";
                }
            } else {
                slot.innerHTML = "";
            }

        }
        //console.log(quickbar);
    }

    function angeklickt() {

        console.log("angeklickt");
        mouseoverx = leftborder + floor((mouseX - leftofsett) / fieldsize);
        mouseovery = topborder + floor((mouseY - topofsett) / fieldsize);
        console.log(mouseoverx + "///" + mouseovery);
        console.log(tilemap[mouseovery][mouseoverx].resource + " lalalalallalalal");
        if (selected instanceof Thing) {
            //console.log(" selected is an instance of thing noice ");
            if (tilemap[mouseovery][mouseoverx].content == "" || tilemap[mouseovery][mouseoverx].content == null || isNaN(tilemap[mouseovery][mouseoverx].content)) {
                tilemap[mouseovery][mouseoverx].content = selected;
                selected.amount--;
                if (selected.amount <= 0) {
                    selected = "";
                }
                console.log(tilemap[mouseovery][mouseoverx].content + " content");
                console.log(tilemap[mouseovery][mouseoverx].content);
                let tempimage;
                let cloned;
                tempimage = tilemap[mouseovery][mouseoverx].content.image;
                tilemap[mouseovery][mouseoverx].content.image = null;
                cloned = JSON.stringify(tilemap[mouseovery][mouseoverx]);
                tilemap[mouseovery][mouseoverx].content.image = tempimage;
                console.log(tilemap[mouseovery][mouseoverx]);
                console.log(cloned);
                console.log("ende von angeklickt");
                placedthingsstring.push(cloned);
                //tilemap[mouseovery][mouseoverx].content.openmashine();
            }
        } else if (tilemap[mouseovery][mouseoverx].resource == "stone") {
            console.log("add stone");
            let temp = new Item();
            temp.name = "stone";
            temp.amount = 1;
            temp.color = "#aaaaaa";
            temp.icon = "/data/stone_icon.png";
            addtoinventory(temp);
        }
        updatequickbar();
    }


    function addtoinventory(temp) {
        for (let i = 0; i < quickbar[0].length; i++) {
            if (quickbar[0][i].name == temp.name) {
                quickbar[0][i].amount++;
                updatequickbar();
                return;
            }
        }
        for (let i = 0; i < quickbar[0].length; i++) {
            if (quickbar[1][i].name == temp.name) {
                quickbar[1][i].amount++;
                updatequickbar();
                return;
            }
        }
        for (let i = 0; i < inventory.length; i++) {
            if (inventory[i].name == temp.name) {
                inventory[1].amount++;
                updatequickbar();
                return;
            }
        }
        for (let i = 0; i < quickbar[0].length; i++) {
            if (quickbar[0][i] == "" || quickbar[0][i] == null) {
                quickbar[0][i] = temp;
                updatequickbar();
                return;
            }
        }
        for (let i = 0; i < quickbar[0].length; i++) {
            if (quickbar[1][i] == "" || quickbar[1][i] == null) {
                quickbar[1][i] = temp;
                updatequickbar();
                return;
            }
        }
        for (let i = 0; i < inventory.length; i++) {
            if (inventory[i] == "" || inventory[i] == null) {
                inventory[i] = temp;
                updatequickbar();
                return;
            }
        }
        updatequickbar();
    }

    Array.prototype.containsArray = function (val) {
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
        console.log("windows getting resized");
        //console.log(invchunk.length + " count involved chunks");
        for (let i = 0; i < invchunk.length; i++) {
            //print(i + " i");
            loadchunk(invchunk[i][0], invchunk[i][1]);
        }
        //console.log(tilemap);
        //console.log("tsefasdlfjaslöd");
    }

    function mouseWheel(event) {
        event.preventDefault();
        print("event.delta honk" + event.deltaY);
        if (event.deltaY > 0) {
            if (fieldsize > 10) {
                fieldsize -= 1;
            }
        } else {
            if (fieldsize < 200) {
                fieldsize += 1;
            }
        }
        windowResized();
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

    async function loaddinger(seed, cx, cy) {
        //console.log("very funny");
        url = 'http://localhost:4444/chunk/' + seed + "/" + cx + "/" + cy;
        //console.log(url);
        try {
            const response = await fetch(url);
            myJson = await response.json(); //extract JSON from the http response
            //console.log(myJson.className);
            return myJson;
        } catch (err) {
            remove();
            let a = document.getElementById("errcode");
            a.innerHTML = "server not reachable";
            throw new Error("server not reachable");
            process.exit();
        }
    }

    function getchunk(seed, cx, cy) {
        let ttt = null;
        //console.log("ouput is funny");
        var prom = new Promise(function (resolve, reject) {
            try {

                resolve(loaddinger(seed, cx, cy));
            } catch (err) {
                reject("error loading chunk");
            }
        });
        prom.then(function (result) {
            console.log("chunk " + cx + "/" + cy + " arrived");
            //console.log(result);
            loadedchunks.push(result);
            let ccy = 0;
            for (let i = cy * 8; i < (cy + 1) * 8; i++, ccy++) {
                //todo memory usage can be shity because 
                //i set array at certain values and it fills al the oters
                //console.log("in der for schelife");
                let ccx = 0;
                //console.log(Array.isArray(tilemap[i]));
                if (Array.isArray(tilemap[i]) == false) {
                    tilemap[i] = [];
                    //print("array hinzugefugt")
                }
                for (let j = cx * 8; j < (cx + 1) * 8; j++, ccx++) {
                    tilemap[i][j] = result.tile[ccy][ccx];
                    //console.log(i+" "+j+" is a known coordinate");
                }
            }
        }, function (err) {
            console.log(err);
        });
    }

    function keyPressed() {
        //console.log(key + " wurde gedruckt"); //keypressed things
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
            moverleft();
        }
        if (key == "q") {
            if (selected instanceof Item) {
                selected = "";
            } else {
                var x = document.getElementById("craftmenu");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        }
        if (keyCode === ESCAPE) {
            console.log("settings");
            var x = document.getElementById("settings");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
        if (keyCode === 113) { //F2 key is pressed
            console.log("debug mode not working");
        }
    }

    function removeunusedchunks() { //todo 

    }

    function moverleft() {
        let invchunk = involvedchunks();
        let erg = [];
        let rightchunk = floor((xxx - (floor(fieldcountwidth / 2) + 3)) / chunksize);
        //console.log(invchunk);
        //console.log([rightchunk, invchunk[0][1]]);
        if (invchunk.containsArray([rightchunk, invchunk[0][1]])) {
            //console.log("chunk is already loaded no need for more before moving right");
        } else {
            let topborder = yyy - ceil(fieldcountheight / 2);
            let bottomborder = yyy + ceil(fieldcountheight / 2);
            for (let j = topborder; j <= bottomborder; j++) {
                let cpy = floor(j / chunksize);
                if (erg.containsArray([rightchunk, cpy]) == false) {
                    erg.push([rightchunk, cpy]);
                }
            }
            if (erg.containsArray([rightchunk, (bottomborder / chunksize)]) == false) {
                erg.push([rightchunk, floor((bottomborder / chunksize))]);
            }
            //console.log("########################");
            //console.log(erg);
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
        //console.log(invchunk);
        //console.log([rightchunk, invchunk[0][1]]);
        if (invchunk.containsArray([rightchunk, invchunk[0][1]])) {
            //  console.log("chunk is already loaded no need for more before moving right");
        } else {
            let topborder = yyy - ceil(fieldcountheight / 2);
            let bottomborder = yyy + ceil(fieldcountheight / 2);
            for (let j = topborder; j <= bottomborder; j++) {
                let cpy = floor(j / chunksize);
                if (erg.containsArray([rightchunk, cpy]) == false) {
                    erg.push([rightchunk, cpy]);
                }
            }
            if (erg.containsArray([rightchunk, (bottomborder / chunksize)]) == false) {
                erg.push([rightchunk, floor((bottomborder / chunksize))]);
            }
            //console.log("########################");
            //console.log(erg);
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
        //console.log(invchunk);
        //console.log([topchunk, invchunk[0][1]]);
        if (invchunk.containsArray([invchunk[0][1]], topchunk)) {
            //console.log("chunk is already loaded no need for more before moving right");
        } else {
            let leftborder = xxx - ceil(fieldcountwidth / 2);
            let topborder = yyy - ceil(fieldcountheight / 2);
            let rightborder = xxx + ceil(fieldcountwidth / 2);
            let bottomborder = yyy + ceil(fieldcountheight / 2);
            for (let j = leftborder; j <= rightborder; j++) {
                let cpx = floor(j / chunksize);
                if (erg.containsArray([cpx, topchunk]) == false) {
                    erg.push([cpx, topchunk]);
                }
            }
            if (erg.containsArray([floor(rightborder / chunksize), topchunk]) == false) {
                erg.push([floor(rightborder / chunksize), topchunk]);
            }
            //console.log("########################");
            //console.log(erg);
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
        //console.log(invchunk);
        //console.log([topchunk, invchunk[0][1]]);
        if (invchunk.containsArray([invchunk[0][1]], topchunk)) {
            //console.log("chunk is already loaded no need for more before moving right");
        } else {
            let leftborder = xxx - ceil(fieldcountwidth / 2);
            let topborder = yyy - ceil(fieldcountheight / 2);
            let rightborder = xxx + ceil(fieldcountwidth / 2);
            let bottomborder = yyy + ceil(fieldcountheight / 2);
            for (let j = leftborder; j <= rightborder; j++) {
                let cpx = floor(j / chunksize);
                if (erg.containsArray([cpx, topchunk]) == false) {
                    erg.push([cpx, topchunk]);
                }
            }
            if (erg.containsArray([floor(rightborder / chunksize), topchunk]) == false) {
                erg.push([floor(rightborder / chunksize), topchunk]);
            }
            //console.log("########################");
            //console.log(erg);
            for (let i = 0; i < erg.length; i++) {
                loadchunk(erg[i][0], erg[i][1]);
            }
        }
        yyy--;
    }

    function loadchunk(cx, cy) {
        let ccc = null;
        let lol = 0;
        //console.log("tstadfasdfa");
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
        }
        //print(tilemap);
    }

    function chunkoftile(x, y) {
        let a = floor(x / chunksize);
        let b = floor(y / chunksize);
        return [a, b];
    }

    function involvedchunks() {
        let leftborder = xxx - ceil(fieldcountwidth / 2);
        let topborder = yyy - ceil(fieldcountheight / 2);
        let rightborder = xxx + ceil(fieldcountwidth / 2);
        let bottomborder = yyy + ceil(fieldcountheight / 2);

        let mincpy = floor(topborder / chunksize);
        let maxcpy = floor(bottomborder / chunksize);
        let maxcpx = floor(rightborder / chunksize);
        let mincpx = floor(leftborder / chunksize);
        //console.log(maxcpy + " " + maxcpx + " " + mincpy + " " + mincpx);
        erg = [];
        for (let i = mincpy; i <= maxcpy; i++) {
            for (let j = mincpx; j <= maxcpx; j++) {
                erg.push([j, i]);
            }
        }
        //console.log(erg);
        //erg = [];
        /*
        //print(xxx + " " + yyy + " " + fieldcountwidth + " " + fieldcountheight + " involvedchungs");
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
        }*/
        return erg;
    }

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.id);
        source = ev.target.id;
        //console.log(source);
    }

    function cusomdrop(ev) {
        ev.preventDefault();
        //console.log(ev);
        var data = ev.dataTransfer.getData("text");
        let source = document.getElementById(data).parentNode.id;
        let destination = ev.target.id;
        let temp;
        //console.log(source + "#########--" + destination + "--#######" + data);
        let sindex = source.substring(1);
        let dindex = destination.substring(1);
        if (source[0] == "i") {
            temp = inventory[sindex - 1];
            inventory[sindex - 1] = "";
            //console.log("from inventory");
        }
        if (source[0] == "u") {
            temp = quickbar[0][sindex - 1];
            quickbar[0][sindex - 1] = "";
            //console.log("from upper quckbar");
        }
        if (source[0] == "d") {
            temp = quickbar[1][sindex - 1];
            quickbar[1][sindex - 1] = "";
            //console.log("form lower quickbar");
        }

        //console.log(typeof(dindex));
        //console.log(dindex + " dindex");
        let lostgen = ev.target;
        while (isNaN(dindex)) {
            //console.log("ist not a number ");
            lostgen = lostgen.parentNode;
            destination = lostgen.id;
            //console.log(destination + " destin atno ");
            dindex = destination.substring(1);
            //console.log(dindex + " new index");
            dindex = parseInt(dindex);
            //console.log(typeof(dindex) + " typeof in while");

        }
        //console.log("we get : " + dindex);
        //console.log(temp);
        if (destination[0] == "i") {
            if (inventory[dindex - 1] != "") {
                //console.log(" kombined with " + inventory[dindex - 1]);

                if (inventory[dindex - 1].name == temp.name) {
                    inventory[dindex - 1].amount += temp.amount;
                    //console.log("same name");
                    const node = document.getElementById(data);
                    node.parentNode.removeChild(node);
                    updatequickbar();
                    return;
                }
            }
            inventory[dindex - 1] = temp;
            //console.log("to inv");
        }
        if (destination[0] == "u") {
            //console.log("upper hinzufügen {" + quickbar[0][dindex - 1] + "} " + quickbar[0][dindex - 1] != "");
            if (quickbar[0][dindex - 1] != "") {
                //console.log(" not empty");
                //console.log(quickbar[0][dindex - 1]);
                //console.log(" kombinert mit ");
                //console.log(temp);
                if (quickbar[0][dindex - 1].name == temp.name) {
                    //console.log("same name");
                    //console.log(quickbar[0][dindex - 1].amount+" + "+temp.amount+" ==");
                    quickbar[0][dindex - 1].amount = quickbar[0][dindex - 1].amount + temp.amount;
                    //console.log(quickbar[0][dindex - 1].amount);
                    const node = document.getElementById(data);
                    node.parentNode.removeChild(node);
                    updatequickbar();
                    return;
                }
            }
            quickbar[0][dindex - 1] = temp;
            //console.log(" to upper quickabr");
        }
        if (destination[0] == "d") {
            if (quickbar[1][dindex - 1] != "") {
                //console.log(quickbar[1][dindex - 1] + "  kombinert mit " + temp);
                if (quickbar[1][dindex - 1].name == temp.name) {
                    quickbar[1][dindex - 1].amount += temp.amount;
                    //console.log("same name");
                    const node = document.getElementById(data);
                    node.parentNode.removeChild(node);
                    updatequickbar();
                    return;
                }
            }
            quickbar[1][dindex - 1] = temp;
            //console.log(" ot lower quckabr");
        }
        //console.log(inventory);
        //console.log(quickbar);
        updatequickbar();
    }
    window.addEventListener('beforeunload', function (e) {
        e.preventDefault();
        console.log("bist du sicher");
        this.alert("Bist du sicher?");
        e.returnValue = '';
    })
}
/*
window.onbeforeunload = (e) => {
    e.preventDefault();
    e.returnValue = '';
    return "Do you want to exit this page?";
}
*/
