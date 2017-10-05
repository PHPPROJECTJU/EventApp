


var menu = document.getElementById("mainmenu");
var hamb = document.getElementById("hamb");



function openNav() {
		menu.style.width = "250px";
}

function closeNav() {
		menu.style.width = "0px";
}

var aboutBubble = document.getElementById("about");
var aboutButton = document.getElementById("aboutbutton");

function showAbout() {
		if (aboutBubble.style.display == "block") {
			aboutBubble.style.display = "none";
		} else {
			aboutBubble.style.display = "block";
		}
}
