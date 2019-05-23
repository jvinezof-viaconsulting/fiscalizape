/*
 * Funções sleep
*/
function sleep(ms) {
	return new Promise(resolve => setTimeout(resolve, ms));
}


/*
 * Funções voto
 * async é necessario para a função sleep funcionar
*/
var votando = false;

// Elemento numVerdades e NumMentiras
var eNumVerdades = document.getElementById('numVerdades');
var eNumMentiras = document.getElementById('numMentiras');

// Valor numVerdades e numMentiras
var numV = eNumVerdades.innerText;
var numM = eNumMentiras.innerText;

function realizarVoto(idObra, voto, acao) {
	// Exemplo de requisição POST
	var ajax = new XMLHttpRequest();

	// Seta tipo de requisição: Post e a URL da API
	ajax.open("POST", "../controller/mudarVotoVerdade.php", true);
	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	// Seta paramêtros da requisição e envia a requisição
	stringDados = 'idObra=' + idObra + '&voto=' + voto + '&acao=' + acao;
	ajax.send(stringDados);

	// Cria um evento para receber o retorno.
	ajax.onreadystatechange = function() {
		// Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
		if (ajax.readyState == 4 && ajax.status == 200) {
			var data = ajax.responseText;
			// Retorno do Ajax
			votando = false;
		}
	}
}

async function marcarVerdade(idObra) {
	if (!votando) {
		votando = true;
		var verdade = document.getElementById('verdade');
		var mentira = document.getElementById('mentira');

		// Verificando se ja votou
		if (verdade.classList.contains('badge-success') || mentira.classList.contains('badge-danger')) {
			// Verificando em quem ele já votou
			if (verdade.classList.contains('badge-success')) {
				// Se ele votou em verdade e está votando de novo removemos o voto
				realizarVoto(idObra, 0, '-');
				verdade.classList.remove('badge-success');
				verdade.classList.add('badge-secondary');
				eNumVerdades.innerText = --numV;
			} else {
				// Se ele tinha votado em mentira antes, mudamos o voto
				if (mentira.classList.contains('badge-danger')) {
					mentira.classList.remove('badge-danger');
					mentira.classList.add('badge-secondary');
					eNumMentiras.innerText = --numM;
				}
				realizarVoto(idObra, 1, '+');
				verdade.classList.remove('badge-secondary');
				verdade.classList.add('badge-success');
				eNumVerdades.innerText = ++numV;
			}
		} else {
			realizarVoto(idObra, 1, '+');
			verdade.classList.remove('badge-secondary');
			verdade.classList.add('badge-success');
			eNumVerdades.innerText = ++numV;
		}
	}
}

async function marcarMentira(idObra) {
	if (!votando) {
		votando = true;
		var verdade = document.getElementById('verdade');
		var mentira = document.getElementById('mentira');

		// Verificando se ja votou
		if (verdade.classList.contains('badge-success') || mentira.classList.contains('badge-danger')) {
			// Verificando em quem ele já votou
			if (mentira.classList.contains('badge-danger')) {
				// Se ele votou em mentira e está votando de novo removemos o voto
				realizarVoto(idObra, 0, '-');
				mentira.classList.remove('badge-danger');
				mentira.classList.add('badge-secondary');
				eNumMentiras.innerText = --numM;
			} else {
				// Se ele tinha votado em verdade antes, mudamos o voto
				if (verdade.classList.contains('badge-success')) {
					verdade.classList.remove('badge-success');
					verdade.classList.add('badge-secondary');
					eNumVerdades.innerText = --numV;
				}
				realizarVoto(idObra, 0, '+');
				mentira.classList.remove('badge-secondary');
				mentira.classList.add('badge-danger');
				eNumMentiras.innerText = ++numM;
			}
		} else {
			realizarVoto(idObra, 0, '+');
			mentira.classList.remove('badge-secondary');
			mentira.classList.add('badge-danger');
			eNumMentiras.innerText = ++numM;
		}
	}
}

async function mudarTitulo(by) {
	var aVerdade = document.getElementById('aVerdade');
	var aMentira = document.getElementById('aMentira');

	if (aVerdade.title != "Votando..." && aMentira.title != "Votando...") {
		if (by == aVerdade) {
			var tituloAntigo = aVerdade.title;
		} else if (by == aMentira) {
			var tituloAntigo = aMentira.title;
		}

		by.title = "Votando...";
		await sleep(2000);
		by.title = tituloAntigo;
	}
}