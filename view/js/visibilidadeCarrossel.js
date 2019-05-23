var carrossel = document.getElementById("carrossel"),
pesquisa = document.getElementById("pesquisa"),
larguraAtual = window.innerWidth;

window.addEventListener("load", function(){
	if(larguraAtual < 760) {
		carrossel.style.display = 'none';
		pesquisa.style.display = 'block';
	} else {
		carrossel.style.display = 'block';
		pesquisa.style.display = 'none';
	}
});

window.addEventListener("resize", function() {
	larguraAtual = window.innerWidth;
	
	if(larguraAtual < 760) {
		carrossel.style.display = 'none';
		pesquisa.style.display = 'block';
	} else {
		carrossel.style.display = 'block';
		pesquisa.style.display = 'none';
	}
});