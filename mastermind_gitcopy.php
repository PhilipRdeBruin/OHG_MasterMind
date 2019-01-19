
<!doctype html>
<html>
    
    <script>
        host = "localhost";
        host = "192.168.2.84"; // CodeGorilla
        host = "192.168.2.9";  // De Knolle
        host = "192.168.2.12"; // De Ljurk
    </script>
    
    <head>
            <meta charset=utf-8>
            <title>MasterMind_OHG</title>
            <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
            
            <script src="http://192.168.2.9/mijnprojecten/OHGSockets/MasterMind/JS-MM_042.js"></script>
            <script src="http://192.168.2.9/mijnprojecten/OHGSockets/MasterMind/JS-MMfuncties_042.js"></script>
            <script src="http://192.168.2.9/mijnprojecten/OHGSockets/MasterMind/JQuery-MM_042.js"></script>
            <link rel="stylesheet" href="http://192.168.2.9/mijnprojecten/OHGSockets/MasterMind/CSS-MM_042.css">
            <?php require_once "MasterMind/php-MMfuncties.php"; ?>
    </head>

    <body>
        <h1 id="turns">Waiting for turn...</h1>
        <script src="http://192.168.2.9:3000/socket.io/socket.io.js"></script>
        <button onclick="makeMove('testing moves')">Send test move</button>

<!-- *********************************************************************************************************** -->

    <?php
            session_start();

            $sel_4pos = ""; $sel_5pos = ""; $sel_6pos = "";
            $sel_6kleur = ""; $sel_7kleur = ""; $sel_8kleur = ""; $sel_9kleur = "";
            $chk_legepos = ""; $chk_multkleur = ""; $chk_handcheck = ""; $chk_1spel = ""; $chk_2spel = ""; 
            if (isset($_POST["invoeren"])) {
                $npos = str_replace("pos", "", $_POST["npos"]);
                $nkleur = str_replace("kleur", "", $_POST["nkleur"]);
                $legepos = (isset($_POST["legepos"])) ? 1 : 0;
                $multkleur = (isset($_POST["multkleur"])) ? 1 : 0;
                $handcheck = (isset($_POST["handcheck"])) ? 1 : 0;
                $nspel = ($_POST["xspel"] == "1spel") ? 1 : 2;

                $arg = $npos . "," . $nkleur . "," . $legepos . "," . $multkleur . "," . $handcheck . "," . $nspel;

                switch ($_POST["npos"]) {
                    case 4:
                        $sel_4pos = "selected";
                        break;
                    case 5:
                        $sel_5pos = "selected";
                        break;
                    case 6:
                        $sel_6pos = "selected";
                }
                switch ($_POST["nkleur"]) {
                    case 6:
                        $sel_6kleur = "selected";
                        break;
                    case 7:
                        $sel_7kleur = "selected";
                        break;
                    case 8:
                        $sel_8kleur = "selected";
                        break;
                    case 9:
                        $sel_9kleur = "selected";
                }
                $chk_legepos = (isset($_POST["legepos"])) ? "checked" : "";
                $chk_multkleur = (isset($_POST["multkleur"])) ? "checked" : "";
                $chk_handcheck = (isset($_POST["handcheck"])) ? "checked" : "";
                if ($nspel == 1) { 
                    $chk_1spel = "checked";
                    $chk_2spel = "";
                } else {
                    $chk_1spel = "";
                    $chk_2spel = "checked";
                } 
            } else {
                $sel_4pos = ""; $sel_6pos = "";
                $sel_5pos = "selected";
                $sel_6kleur = ""; $sel_7kleur = ""; $sel_9kleur = "";
                $sel_8kleur = "selected";
                $chk_legepos = "checked";
                $chk_multkleur = "checked";
                $chk_handcheck = "checked";
                $chk_2spel = "checked";
            }

        ?>
            <script>
                var statusstring = new Array(10);
                initStatusStrings();
            </script>

            <div id="spelbord">
                <div id="gaatjes1"><script>drawrondjes();</script></div>
                <div id="gaatjes2"><script>drawpinnetjes();</script></div>
                <div id="cover"></div>
                <div id="covertgl"></div>
            </div>
            <div id="knoppen"><script>drawbuttons();</script></div>
            <div id="doosjes">
                <div id="kleurenpalet"> <div id="hulppalet"><script>drawcolors();</script></div></div>
                <div id="pinnen"><script>drawblackwhite();</script></div>


                <div id="speldata">
                    <p>spelinvoerdata:<span id="initdata"></span></p>
                    <p>spelstatusdata:</p><p id="statusdata"></p>
                </div>

            </div>


            <form id="formulier" name="formulier" method="POST" action="#">
<!--
            <div>
                    <span style="font-size:14px">your name:</span><input type="text" id="naam" name="naam">
                </div>
                <div>
                    <span style="font-size:14px">email-adress:</span><input type="text" id="pmail" name="pmail">
                </div>
                <br/><hr/>
-->
                <p><u><i>game parameters</i></u></p>
                <table>

                    <tr class="rij">
                        <td class="kolom1">number of positions:</td>
                        <td class="kolom2">
                            <select required  name="npos">
                                <option value="4pos" <?php echo $sel_4pos ?>>4</option>
                                <option value="5pos" <?php echo $sel_5pos ?>>5</option>
                                <option value="6pos" <?php echo $sel_6pos ?>>6</option>
                            </select>
                        </td>
                    </tr>
                    <tr class="rij">
                        <td class="kolom1">number of colors:</td>
                        <td class="kolom2">
                            <select required  name="nkleur">
                                <option value="6kleur" <?php echo $sel_6kleur ?>>6</option>
                                <option value="7kleur" <?php echo $sel_7kleur ?>>7</option>
                                <option value="8kleur" <?php echo $sel_8kleur ?>>8</option>
                                <option value="9kleur" <?php echo $sel_9kleur ?>>9</option>
                            </select>
                        </td>
                    </tr>


                
                    <tr class="rij"><td class="kolom1">allow empty position(s)</td><td class="kolom2"><input type="checkbox"  name="legepos" value="legepos" <?php echo $chk_legepos ?>></td></tr>
                    <tr class="rij"><td class="kolom1">allow multiple colors</td><td class="kolom2"><input type="checkbox"  name="multkleur" value="multkleur" <?php echo $chk_multkleur ?>></td></tr>
                    <tr class="rij"><td class="kolom1">handmatige controle</td><td class="kolom2"><input type="checkbox"  name="handcheck" value="handcheck" <?php echo $chk_handcheck ?> ></td></tr>

                    <tr class="rij"><td colspan="2" style="font-size:14px">
                        <input type="radio" name="xspel" value="1spel" <?php echo $chk_1spel ?>>1 spel
                        <input type="radio" name="xspel" value="2spel" <?php echo $chk_2spel ?>>2 spellen tegelijk
                    </td></tr>
                </table>

                <hr/>
                <input type="submit" id="invoeren" name="invoeren" value="Submit">
            </form>
            <div id="nieuwspel">
                <p><input type="button" id="nwspelknop"value="Another Game" onClick="window.location.reload()"></p>
            </div>
        </body>

    <?php
        if (isset($_POST["invoeren"])) {
            echo "<script>vulinitdata('$arg')</script>";
        }
    ?>

<!-- *********************************************************************************************************** -->

<script>
            var lh = location.hash.split('#')[1];
            var lhValues = lh.split('&');
            var room = lhValues[1];
            var user = lhValues[2];
            var game = lhValues[0];
            var socket = io('http://192.168.2.9:3000');
            var gameData = {room: room, game: game, user: user};
            socket.emit('join room', gameData);
            
            socket.on('game state', function(gamestate){
                npos = 5;
                l = gamestate.length - 1;
                brt = gamestate[l][1];

                for (j=1; j<=npos; j++) {
                    ij = 10 * brt + j; 

                    xkl = gamestate[l][j+1];
                    if (xkl > 0) {
                        knopje = document.getElementById("dragid" + xkl);
                        dropje = document.getElementById("dropid" + ij);
                        knopkloon = knopje.cloneNode(true);
                        deleterondje (ij);
                        dropje.appendChild(knopkloon);
                    }
                }
            
            
            
            
            });




            socket.on('game turn', function(turn){
                if(turn == 1){
                    document.getElementById("turns").innerHTML = "Make a move!"
                } else if (turn == 0) {
                    document.getElementById("turns").innerHTML = "Waiting for turn.."
                } else if (turn == 2) {
                    document.getElementById("turns").innerHTML = "Game ended"
                }
            });
            function makeMove(moveData) {
                socket.emit('game move', moveData)
            };
        </script>
        
    </body>
</html>
