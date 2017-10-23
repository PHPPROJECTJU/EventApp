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

/*--Choose location in event feed------*/

var regionmenu = document.getElementById("regionmenu");



document.querySelector('.chooselocation').addEventListener('click', function() {
  document.querySelector('#regionmenu').classList.toggle('collapsed');
});
