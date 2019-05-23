function meu_callback(conteudo) {
	if (!("erro" in conteudo)) {
		document.getElementById('rua').value=(conteudo.logradouro);
		document.getElementById('bairro').value=(conteudo.bairro);
		document.getElementById("avisoInfo").innerHTML = "Talvez o mapa não ache seu local, <span class=\"text-success\">mas não se preocupe estamos guardando seu local</span>. (digitando as informações manualmente as chances são maiores <a href=\"javascript:void(0)\" onclick=\"mostrarEsconderEnd()\">clique aqui</a>)";
	} else {
		document.getElementById('rua').value = "";
		document.getElementById('bairro').value = "";
		document.getElementById("avisoInfo").innerHTML = "<span class=\"text-danger\">Cep inválido</span>";
	}
}

function pesquisaCep(pesquisa) {
	//Nova variável "cep" somente com dígitos.
	var cep = pesquisa.replace(/\D/g, "");

	if (cep != "") {
		//Expressão regular para validar o CEP.
		var validacep = /^[0-9]{8}$/;

		//Valida o formato do CEP.
		if (validacep.test(cep)) {
			scriptAntigo = document.getElementById("scriptValores");
			if (scriptAntigo != null) {
				scriptAntigo.parentNode.removeChild(scriptAntigo);
			}

			//Cria um elemento javascript.
			script = document.createElement('script');
			script.id = "scriptValores";

			//Sincroniza com o callback.
			script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

			//Insere script no documento e carrega o conteúdo.
			document.body.appendChild(script);
		} else {
			document.getElementById('rua').value = "false";
			document.getElementById('bairro').value = "false";
			document.getElementById('cidade').value = "false";
			document.getElementById("avisoInfo").innerHTML = "<span class=\"text-danger\">Cep inválido</span>";
		}
	}
}