<?php
require_once '../vendor/autoload.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload(["persistence", "util", "model"], ["DaoConexao","Util", "Erros"]);

use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\util\Util;
use Respect\Validation\Validator as v;
use \fiscalizape\model\Erros;

$util = new Util();
$daoConexao = new DaoConexao();
$objErros = new Erros("registrar", 60);

/*
 * Limpando os inputs
*/
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cpf = $util->somenteNumeros(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$email = strtolower(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$senhaRepita = filter_input(INPUT_POST, 'senhaRepita', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$termos = filter_input(INPUT_POST, 'termos', FILTER_VALIDATE_INT);

setcookie("registrar[nome]", $nome, time()+60*10, "/fiscalizape/view/registrar.php");
setcookie("registrar[sobrenome]", $sobrenome, time()+60*10, "/fiscalizape/view/registrar.php");
setcookie("registrar[email]", $email, time()+60*10, "/fiscalizape/view/registrar.php");
setcookie("registrar[cpf]", $cpf, time()+60*10, "/fiscalizape/view/registrar.php");

// Gerando informações adicionais
// Pegando o ip
$ip = $util->getUserIP();
// Usuaremos esta string para redericionar o usuario para a pagina de registro e iremos contatenar com o erro
$paginaRegistro = 'Location: ../view/registrar.php';

/*
 * Sistema de erros.
*/
$pagina = "registrar.php";
// Verificando se já existe algum cookie de erro.
if ($objErros->existeCookie()) {
	$cookieErros = $objErros->getCookie();
} else {
	$cookieErros = array();
}

/*
 * Verificando os campos (tamanho, validade, etc...)
*/
$erro = false;

// Nome
if (strlen($nome) < 4) {
	$erro = true;
	array_push($cookieErros, "Nome inválido, deve conter no mínimo 4 letras.");
} else if (strlen($nome) > 25) {
	$erro = true;
	array_push($cookieErros, "Nome inválido, deve conter no máximo 25 letras.");
}

// Sobrenome
if (strlen($sobrenome) < 4) {
	$erro = true;
	array_push($cookieErros, "Sobrenome inválido, deve conter no mínimo 4 letras.");
} else if (strlen($sobrenome) > 25) {
	$erro = true;
	array_push($cookieErros, "Sobrenome inválido, deve conter no máximo 25 letras.");
}

// CPF
if (strlen($cpf) === 11) {
	if ($util->validarCPF($cpf)) {
		$cpfs = $daoConexao->selecionar(['usuario_cpf'], 'usuarios')->fetchAll(\PDO::FETCH_ASSOC);
		foreach ($cpfs as $cpfAtual) {
			if ($cpfAtual['usuario_cpf'] == $cpf) {
				$erro = true;
				array_push($cookieErros, "CPF já cadastrado.");
			}
		}
	} else {
		$erro = true;
		array_push($cookieErros, "CPF inválido! Digite um CPF real.");
	}
} else {
	$erro = true;
	array_push($cookieErros, "o CPF deve conter 11 digitos. (ignorando pontuações e separador)");
}

// Email
if (strlen($email) < 4) {
	$erro = true;
	array_push($cookieErros, "Email inválido, deve conter no mínimo 4 letras.");
} else if (strlen($email) > 100) {
	$erro = true;
	array_push($cookieErros, "Email inválido, deve conter no máximo 100 letras.");
} else if (!v::email()->validate($email)) {
	$erro = true;
	array_push($cookieErros, "Email inválido! Digite um email real.");
} else {
	$emails = $daoConexao->selecionar(['usuario_email'], 'usuarios')->fetchAll(\PDO::FETCH_ASSOC);
	foreach ($emails as $emailAtual) {
		// Se algum email bater, rederecionamos para a pagina de registro
		if ($emailAtual['usuario_email'] == $email) {
			$erro = true;
			array_push($cookieErros, "Email já cadastrado.");
		}
	}
}

// Senhas
if (strlen($senha) < 8) {
	$erro = true;
	array_push($cookieErros, "Senha inválida, por segurança sua senha deve conter no mínimo 8 caracteres.");
} else if (strlen($senha) > 30) {
	$erro = true;
	array_push($cookieErros, "Senha inválida, para evitar perdas sua senha deve conter no máximo 30 caracteres.");
} else if ($senha != $senhaRepita) {
	$erro = true;
	array_push($cookieErros, "Senha inválida, senhas não conferem!");
}

// Termo aceito
if ($termos != "1") {
	$erro = true;
	array_push($cookieErros, "Por favor, leia nossos termos de uso.");
}

/*
 * HEADER
 * deu erro! vamos voltar pro formulario.
*/
if ($erro) {
	$objErros->setErros($cookieErros);
	$objErros->salvarCookie();
	header($paginaRegistro);
	exit;
}

/*
 * Incluindo o usuario.
 * negamos $erro para que o if seja executado somente quando não hover erros.
*/
if (!$erros) {
	$daoConexao->inserir('usuarios', ['usuario_nome, usuario_sobrenome, usuario_cpf, usuario_email, usuario_senha, usuario_token, usuario_registro_ip, usuario_ultimo_ip'], [$nome, $sobrenome, $cpf, $email, $hashSenha, $token, $ip, $ip]);
	if ($daoConexao->linhasAfetadas() > 0) {
		session_start();
		$_SESSION ['logado'] = 1;
		$_SESSION ['email'] = $email;
		$_SESSION ['senha'] = $senha;
		header('Location: loginIniciar.php');
		exit;
	}

	setcookie("array_erros_registrar.php", serialize(['Houve algum problema e não conseguimos concluir o registro. Tente novamente, se pesistir contate os administradores.']));
	header($paginaRegistro);
	exit;
}