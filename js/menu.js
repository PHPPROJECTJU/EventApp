var menu = document.getElementById("mainmenu");
var hamb = document.getElementById("hamb");
var close = document.getElementById("close");

close.style.display = "none";

function openNav() {
	   menu.style.display = "block";
	   hamb.style.display = "none";
	   close.style.display = "block";
}

function closeNav() {
     menu.style.display = "none";
     hamb.style.display = "block";
     close.style.display = "none";
}
