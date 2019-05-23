var cr = document.getElementById("carrossel"),
antBtn = document.getElementById("antBtn"),
proxBtn = document.getElementById("proxBtn");

var tempo=0, bgAtual=0, bgAnt=0, bgProx=0;
// Primeiro o SRC e dps o ALT
var bgs=["http://www.al.es.gov.br/appdata/imagens_site/capa_34108_obraspublicasJunior-Silgueiro.jpg", "https://organicsnewsbrasil.com.br/wp-content/uploads/2016/09/frevo_prefeitura_de_olinda-1.jpg", "http://www.somrecordsweb.com.br/images/Mercado.jpg"];

var bgInicial = "url( " + bgs[0] + ")";
cr.style.backgroundImage = bgInicial;

var x=0, numBgs=bgs.length;

function bg(bg) {
	return "url(" + bg + ")";
}

function modBg() {
	if(x == numBgs || x > numBgs) {
		x = 0;
	} else if(x < 0) {
		x = numBgs-1;
	}
	return bg(bgs[x]);
}

function ant() {
	x--;
	cr.style.backgroundImage = modBg();
}

function prox() {
	x++;
	cr.style.backgroundImage = modBg();
}

window.setInterval(function(){
	if (x == numBgs) {
		x = 0;
	}
	cr.style.backgroundImage = modBg();
	x++;
}, 3500);