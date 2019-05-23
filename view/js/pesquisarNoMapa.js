function pesquisarNoMapa(isCep) {
	if (isCep) {
		var cep = document.getElementById("cep").value;
		pesquisaCep(cep);
	}

	var rua = document.getElementById("rua").value;
	var bairro = document.getElementById("bairro").value;
	var cidade = document.getElementById("cidade").value;

	var pesquisa = rua + ", " + bairro + ", " + cidade + " - Pernambuco";

	pesquisa = pesquisa.replace(/\s/g, '%20');

	var link = "https://maps.google.com/maps?q=" + pesquisa + "&t=&z=13&ie=UTF8&iwloc=&output=embed";

	var mapa = document.getElementById("mapa");
	mapa.src = link;
}
