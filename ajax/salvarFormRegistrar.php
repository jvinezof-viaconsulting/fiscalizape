<?php

if (isset($_POST['nome']) && isset($_POST['sobrenome']) && isset($_POST['email']) && isset($_POST['cpf'])) {
	require_once '../Autoload.php';
	$load = new \fiscalizape\Autoload('util', 'Util');
	$util = new \fiscalizape\util\Util();

	// Filtrando inputs
	$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cpf = $util->somenteNumeros(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

	setcookie("registrar[nome]", $nome, time()+60*10, "/fiscalizape/view/registrar.php");
	setcookie("registrar[sobrenome]", $sobrenome, time()+60*10, "/fiscalizape/view/registrar.php");
	setcookie("registrar[email]", $email, time()+60*10, "/fiscalizape/view/registrar.php");
	setcookie("registrar[cpf]", $cpf, time()+60*10, "/fiscalizape/view/registrar.php");
	exit;
}


/*
 * Gerando erro (acesso negado)
*/
$pagina = $_COOKIE['paginaVoltar'];
$codigoErro = 001;
// Verificando se já existe algum cookie de erro.
if (isset($_COOKIE['array_erros_'.$pagina])) {
	$cookieErros = unserialize($_COOKIE['array_erros_'.$pagina]);
	$jaExiste = false;
	for ($i = 0; $i < count($cookieErros); $i++) {
		if ($cookieErros[$i][1] == $codigoErro) {
			$jaExiste = true;
		}
	}
	if (!$jaExiste) {
		$end = count($cookieErros);
		array_push($cookieErros[$end], 'Seu acesso foi negado, então trouxemos você aqui', 001);
	}
} else {
	$cookieErros = [ ['Seu acesso foi negado, então trouxemos você aqui', $codigoErro] ];
}


setcookie('array_erros_'.$pagina, serialize($cookieErros), time()+60, '/fiscalizape/view/' . $pagina);
header('Location: ../view/' . $pagina);
exit;