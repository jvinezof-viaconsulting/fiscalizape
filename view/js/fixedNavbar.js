var navbar = document.getElementById("navbar");
var pub = document.getElementById('publicidade');
y = 0;

window.addEventListener("scroll", function() {
	y = window.scrollY;
	if (y > 0) {
		navbar.classList.add("fixed-top");
		if (pub != null) {
			if (y > 350) {
				pub.className = "position-fixed";
				pub.style = "top: 150px";
			} else {
				pub.className = "";
				pub.style = "";
			}
		}
	} else {
		navbar.classList.remove("fixed-top");
	}
});