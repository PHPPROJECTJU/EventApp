/*--Hamburger menu------------*/


var menu = document.getElementById("mainmenu");
var hamb = document.getElementById("hamb");



function openNav() {
		menu.style.width = "250px";
}

function closeNav() {
		menu.style.width = "0px";
}


/*--Show "to top"-button when having scrolled----*/
/*--Code found and customized from W3Schools: https://www.w3schools.com/howto/howto_js_scroll_to_top.asp 23/10-17*/

var topButton = document.getElementById("topButton");


window.onscroll = function userScrolled() {
	if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200){
		topButton.style.display = 'block';
	} else {
    topButton.style.display = "none";
  }
};

function goToTop() {
    document.body.scrollTop = 0; // For Chrome, Safari and Opera
    document.documentElement.scrollTop = 0; // For IE and Firefox
}


/*--Displayed only on About page--------*/

var aboutBox = document.getElementById("aboutBox");

function showAbout() {
		if (aboutBox.style.display == "block") {
			aboutBox.style.display = "none";
		} else {
			aboutBox.style.display = "block";
		}
}

/*--Choose location in event feed------*/

var regionmenu = document.getElementById("regionmenu");



document.querySelector('.chooselocation').addEventListener('click', function() {
  document.querySelector('#regionmenu').classList.toggle('collapsed');
});





/*function showregion() {
		if (regionmenu.style.height == "500px") {
			regionmenu.style.height = "0px";

		} else {
			regionmenu.style.height = "500px";

		}
}*/
// -----------------Modal functionalities-----------------

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
