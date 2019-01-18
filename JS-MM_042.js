
var gamestatus = new Array;
var teller = 0;

var dragitem; var dragid; var dragparent;
var dropitem; var dropid;
var ouder; var kloon;
var bauto;

var speltype;
var beurt; var dum;

var klix = ["red", "#3b91ff", "#39aa39", "yellow", "#f0f0f0", "black", "#ff66d9", "#f60", "#c9f"];

var xgis = new Array(6);
var ygis = new Array(6)


function drawrondjes() {
	var ij;

	for (i=1; i<=10; i++) {
		for (j=1; j<=5; j++) {
			ij = 10 * i + j;
			document.write ('	<div class="dropholder" >');
			document.write ('		<div  class="dropid" id="dropid' + ij + '" ondrop="drop(event)" ondragover="allowDrop(event)">');
			document.write ('		</div>');
			document.write ('	</div>');
		}
	}

		for (j=1; j<=5; j++) {
			document.write ('	<div class="dropholder0" >');
			document.write ('		<div  class="dropid" id="dropid0' + j + '" ondrop="drop(event)" ondragover="allowDrop(event)">');
			document.write ('		</div>');
			document.write ('	</div>');
		}
}

function drawpinnetjes() {
	var ij;

	for (i=1; i<=10; i++) {
		document.write ('	<div class="pinrij" >');
		for (j=1; j<=5; j++) {
			ij = 10 * i + j;
			document.write ('	<div class="pinholder" >');
			document.write ('		<div  class="pinid" id="pinid' + ij + '" ondrop="drop(event)" ondragover="allowDrop(event)">');
			document.write ('		</div>');
			document.write ('	</div>');
		}
		document.write ('	</div>');
	}
}

function drawbuttons() {
	for (i=1; i<=10; i++)  {
		document.write ('<p><button class="knoppen" id = "knop' + i + '" />Enter</button></p>');
	}
	document.write ('<p><button class="knop0" id = "knop0" />Enter</button></p>');
}

function drawcolors() {

	for (i=1; i<=3; i++) {
		document.write ('<div class="paletrij">');
		for (j=1; j<=3; j++) {
			var ij = 3 * (i - 1) + j;
			document.write ('<div class="paletkol">');
			document.write ('	<div id = "dragidd' + ij + '">');
			document.write ('	<div class = "dragcl" id="dragid' + ij + '" draggable="true" ondragstart="drag(event)">');
			document.write ('		<svg class="pinkleur">');
			document.write ('			<circle id="kleur" cx="11" cy="11" r="11" fill="' + klix[ij-1] + '" />');
			document.write ('		</svg>');
			document.write ('	</div>');
			document.write ('	</div>');
			document.write ('</div>');
		}
		document.write ('</div>');
	}
}

function drawblackwhite() {
	var klix = ["black", "#e8e8e8"];

	for (i=1; i<=2; i++) {
		document.write ('<div class="zwartwitrij">');
		for (j=1; j<=5; j++) {
			var ij = 5 * (i - 1) + j;
			document.write ('<div class="zwartwitkol">');
			document.write ('	<div id = "zwdd' + ij + '">');
			document.write ('	<div class = "blackwhite" id="zwartwitid' + ij + '" draggable="true" ondragstart="drag(event)">');
			document.write ('		<svg class = "pinzw">');
			document.write ('			<circle id="zwwi" cx="5" cy="5" r="5" fill="' + klix[i-1] + '" />');
			document.write ('		</svg>');
			document.write ('	</div>');
			document.write ('	</div>');
			document.write ('</div>');
		}
		document.write ('</div>');
	}
}


//	Drag & Drop functions

function allowDrop(ev) {
	ev.preventDefault();
}

function drag(ev) {
	dragitem = ev.target;
	dragparent = dragitem.parentNode.id
	dragid = dragitem.id;

	if (speltype == "handmatig" || dragid.substr (0, 4) == "drag") {
		var bdrop = 0;
		if (dragparent.substr (0, 4) == "drop") {
			jj = dragparent.replace ("dropid", "") * 1;
			jj = (jj - jj % 10) / 10;

			if (jj != beurt) { bdrop = 1; }
		}
		if (bdrop == 0) {
			bauto = 1;
			ev.dataTransfer.setData("text", ev.target.id);

			ouder = document.getElementById(dragid).parentElement.id;
			kloon = dragitem.cloneNode(true);
		} }
	else {
		bauto = 0;
	}
}

function drop(ev) {
	dropitem = ev.target;
	dropid = dropitem.id;

	if (dropid.substr (0, 4) == "drop") {
		ii = dropid.replace ("dropid", "") * 1;
		ii = (ii - ii % 10) / 10;
	}
	if (dropid.substr (0, 3) == "pin") { ii = dropid.substr (5, 1); }

	if ((dropid.substr (0, 4) == "drop" && dragid.substr (0, 4) == "drag") || (dropid.substr (0, 3) == "pin" && dragid.substr (0, 5) == "zwart")) {
		if (dropid.substr (0, 4) == "drop" && dragid.substr (0, 4) == "drag") { x = 0; }
		if (dropid.substr (0, 3) == "pin" && dragid.substr (0, 5) == "zwart") { x = 1; }

		b = 1; }
	else {
		b = 0;
	}

	if (b == 1 && ii == beurt - x) {
		ev.preventDefault();
		var data = ev.dataTransfer.getData("text");
		ev.target.appendChild(document.getElementById(data));

		document.getElementById(ouder).appendChild(kloon);

		if (dropid.substr (0, 4) == "drop" && dragid.substr (0, 4) == "drag") {
			var jj = dropid.substr (7,1);
			var kl = dragid.substr (6,1);
			ygis[jj] = kl;
		}

		if (dropid.substr (0, 4) == "drop" && dragparent.substr (0, 4) == "drop") {
			var jj = dragparent.replace ("dropid", "") ;
			var j = jj % 10;
			$("#dropid" + jj).empty();
			ygis[j] = 0;
		}
	}
	else {
		if (bauto==1) {
			alert ("You cannot enter pins on this row or in this section."); }
		else {
			alert ("Pins will be placed automatically...");
		}
	}

	gamestatus = updStatus("speler", 0, 0, beurt, 0, 0);
	alert ("gamestatus = " + gamestatus);
	makeMove(gamestatus);
}


function initStatusStrings() {
	for (i=0; i<10; i++) {
		brt = fmt00(i);
		statusstring[i] = "0," + brt + ", , , , , , ,0,0";
	}
}

function updStatus(tp, spelstat, stat, i, nzw, nwi) {
	ss = "";
	brt = fmt00(i);

	if (tp == "speler") {
		if (i == 0) {
			for (j=1; j<=5; j++) {
				ss = ss + xgis[j] + ",";
			}
		} else {
			for (j=1; j<=5; j++) {
				ss = ss + ygis[j] + ",";
			}
		}

		statusstring[i]	= "[" + stat + "," + brt + "," + ss + ",0,0]";
	} else if (tp == "knop") {
		ri = statusstring[i].substr(2);
		statusstring[i]	= "[" + stat + ri;
	} else if (tp == "contr") {
		l = statusstring[i].length - 4;
		statusstring[i] = statusstring[i].substr(0, l) + nzw + "," + nwi + "]";
	}

//	statusout="[" + spelstat + ",";
	statusout="[";
	for (ii=0; ii<=i; ii++) {
		statusout = statusout + statusstring[ii] + ",";
	}

	l = statusout.length - 1;
	statusout = statusout.substr(0, l) + "]";

	document.getElementById("statusdata").innerHTML = statusout;

	return statusout;

	//convtoArray(statusout);

}

function fmt00(i) {
	i00 = (i<10) ? "0" + i : i;
	return i00;
}

function convtoArray(stat) {
	var statout = new Array;

	teller = teller + 1;
	console.log(teller);

	// i = 0;
	// l = stat.length;
	// stat = stat.substring(1, l);
	
	// while (stat.indexOf("]") > 0 && stat != "" && i<12) {
	// 	p = stat.indexOf("]")
	// 	statout[i] = stat.substring(0,p + 1);

	// 	alert ("statout[" + i + "] = " + statout[i]);

	// 	stat = stat.substring(p + 2);
	// 	alert ("restant = " + stat);
	// 	i++;
	// }

	// alert("nu buiten while-loop");

	// for (i=1; i<statout.length; i++) {
	// 	alert ("statout[" + i + "] = " + statout[i]);
	// }

	// return statout;
}
