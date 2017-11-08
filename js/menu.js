/*--Hamburger menu------------*/


var menu = document.getElementById("mainmenu");
var hamb = document.getElementById("hamb");



function openNav() {
		menu.style.width = "250px";
}

function closeNav() {
		menu.style.width = "0px";
}


/*--Displayed only on not logged in pages--------*/

var aboutBox = document.getElementById("aboutBox");

function showAbout() {
		if (aboutBox.style.display == "block") {
			aboutBox.style.display = "none";
		} else {
			aboutBox.style.display = "block";
		}
}

/*--Show attenders on hostedevents.php*/

function showAttenders() {
	var attenderbox = document.getElementById("attenderbox");
	if (attenderbox.style.display == "block") {
		attenderbox.style.display = "none";
	} else {
		attenderbox.style.display = "block";
	}
}




/*function showregion() {
		if (regionmenu.style.height == "500px") {
			regionmenu.style.height = "0px";

		} else {
			regionmenu.style.height = "500px";

		}
}*/


// -----------------Modal functionalities-----------------
// Following lines are borrowed from https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal2 24 october 2017.
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
        //modal.style.display = "none";
    }
}
