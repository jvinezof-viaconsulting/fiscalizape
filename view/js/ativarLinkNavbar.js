var titulo = document.title,
paginas = document.getElementsByClassName("nav-link");

for (let x = 0; x < paginas.length; x++) {
	if (paginas[x].innerHTML == titulo) {
		paginas[x].classList.add("active");
	}
}