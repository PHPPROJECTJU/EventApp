//Modal functionality taken and modified from W3Schools Nov 9th 2017

// Get the modal
var attmodal = document.getElementById('attModal');

// Get the button that opens the modal
var attbtn = document.getElementById("seeattenders");

// Get the <span> element that closes the modal
var closeatt = document.getElementsByClassName("attclose")[0];

// When the user clicks on the button, open the modal
attbtn.onclick = function() {
    attmodal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
closeatt.onclick = function() {
    attmodal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == attmodal) {
        attmodal.style.display = "none";
    }
}
