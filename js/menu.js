


var menu = document.getElementById("mainmenu");
var hamb = document.getElementById("hamb");



function openNav() {
		menu.style.width = "250px";
}

function closeNav() {
		menu.style.width = "0px";
}


var aboutBox = document.getElementById("aboutBox");

function showAbout() {
		if (aboutBox.style.display == "block") {
			aboutBox.style.display = "none";
		} else {
			aboutBox.style.display = "block";
		}
}

var regionmenu = document.getElementById("regionmenu");

function showregion() {
		if (regionmenu.style.display == "block") {
			regionmenu.style.display = "none";
		} else {
			regionmenu.style.display = "block";
		}
}
