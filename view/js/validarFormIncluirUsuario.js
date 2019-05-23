function enviarForm() {
	var nome = document.getElementById('nome');
	var sobrenome = document.getElementById('sobrenome');
	var email = document.getElementById('email');
	var cpf = document.getElementById('cpf');
	var senha = document.getElementById('senha');
	var senhaRepita = document.getElementById('senhaRepita');

	if (validarNome(nome) &&
		validarSobrenome(sobrenome) &&
		validarEmail(email) &&
		ajudaSenha(senha) &&
		fSenhaRepita(senhaRepita)
	) {
		return true;
	}

	return false;
}

function contemNumero(string) {
	var re = /[0-9]/;
	if (re.test(string)) {
		return true
	}

	return false;
}

function validarNome(input) {
	var numNomes = document.getElementById('numNomes');
	var numLetras = input.value.length;

	// Verificando se tem números
	if (contemNumero(input.value)) {
		if (input.className != 'form-control is-invalid') {
			input.className = 'form-control is-invalid';
		}

		if (numNomes.innerHTML != 'Seu nome não pode conter números') {
			numNomes.innerHTML = 'Seu nome não pode conter números';
		}

		return false;
	} else if (numLetras < 4) {
		// Verificando se tem pelo menos 4 caracteres
		if (input.className != 'form-control is-invalid') {
			input.className = 'form-control is-invalid';
		}

		numNomes.innerHTML = 'Faltam ' + (4-numLetras) + ' letras';

		return false;
	} else {
		if (input.className != 'form-control is-valid') {
			input.className = 'form-control is-valid';
		}
	}

	return true;
}

function validarSobrenome(input) {
	var erro = document.getElementById('invalid-sobrenome');
	var numLetras = input.value.length;

	// Verifica se contém números
	if (contemNumero(input.value)) {
		if (!input.classList.contains('is-invalid')) {
			input.className += ' is-invalid';
		}

		if (erro.innerHTML != 'Seu sobrenome não pode conter números') {
			erro.innerHTML = 'Seu sobrenome não pode conter números';
		}

		return false;
	} else if (numLetras < 4) {
		// Verificando se tem pelo menos 4 caracteres
		if (!input.classList.contains('is-invalid')) {
			input.className = 'form-control is-invalid';
		}

		erro.innerHTML = 'Faltam ' + (4-numLetras) + ' letras';

		return false;
	} else {
		if (input.className != 'form-control is-valid') {
			input.className = 'form-control is-valid';
		}
	}

	return true;
}

function validarEmail(input) {
	var erro = document.getElementById('invalid-email');

	usuario = input.value.substring(0, input.value.indexOf("@"));
	dominio = input.value.substring(input.value.indexOf("@")+ 1, input.value.length);

	if ((usuario.length >=1) &&
	(dominio.length >=3) &&
	(usuario.search("@")==-1) &&
	(dominio.search("@")==-1) &&
	(usuario.search(" ")==-1) &&
	(dominio.search(" ")==-1) &&
	(dominio.search(".")!=-1) &&
	(dominio.indexOf(".") >=1)&&
	(dominio.lastIndexOf(".") < dominio.length - 1)) {
		if (input.classList.contains('is-invalid')) {
			input.className = 'form-control is-valid';

			return true;
		}
	}
	else if (!input.classList.contains('is-invalid')) {
		input.className = 'form-control is-invalid';
		erro.innerHTML="E-mail inválido, siga o padrão \"usuario@dominio.com\"";

		return false;
	}
}

function ajudaSenha(input) {
	texto = document.getElementById('ajudaSenha');
	count = input.value.length;
	min = 8;
	part1 = 'No mínimo ' + min + ' caracteres. ';
	part2 = 'Faltam ' + (min-count) + '.';

	if (min-count > 0) {
		texto.innerHTML = part1 + part2;

		return true;
	} else {
		if (!input.classList.contains('is-valid')) {
			input.className = 'form-control is-valid';
		}

		texto.innerHTML = part1;

		return false;
	}
}

function fSenhaRepita(input) {
	senha = document.getElementById('senha');
	if (senha.value != input.value) {
		if (!input.classList.contains('is-invalid')) {
			input.className = 'form-control is-invalid';

			return false;
		}
	} else if (!input.classList.contains('is-valid')) {
		input.className = 'form-control is-valid';

		return true;
	}
}