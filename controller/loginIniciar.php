<?php

/*
 * OBJETOS NÃO PODEM SER PASSADOS DE UMA PAGINA PARA OUTRA PQ DAR ERRO
 * USAMOS O SERIALIZE PARA TRANSFORMAR ESSE OBJETO EM UMA STRING
 * E DEPOIS USAMOS UNSERIALIZE PARA TRANSFORMAR EM UM OBJETO NOVAMENTE
*/

require_once '../Autoload.php';
new fiscalizape\Autoload( ["persistence", "util", "persistence", "model"], ["DaoUsuario", "Util", "Sessao", "Erros"] );

use \fiscalizape\persistence\DaoUsuario;
use \fiscalizape\util\Util;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\model\Erros;

$util = new Util();
$sessao = new Sessao();
$objErros = new Erros('login', 60);

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);
$lembrarDeMim = (int) filter_input(INPUT_POST, 'lembrarDeMim', FILTER_SANITIZE_NUMBER_INT);


setcookie('formulario[email]', $email, time()+60*5, '/fiscalizape/view/login.php');
setcookie('formulario[lembrarDeMim]', $lembrarDeMim, time()+60*5, '/fiscalizape/view/login.php');

// Verificando se um dos campos é nulo
if (!isset($_POST['email']) && !isset($_POST['senha'])) {
	if ($sessao->estaLogado()) {
		$email = $_SESSION['email'];
		$senha = $_SESSION['senha'];
		$sessao->destruirSessao();
	} else {
		header('Location: ../view.php?vocePrecisaPreencherOsCampos');
		exit;
	}
} else if (!isset($_POST['email']) || !isset($_POST['senha'])) {
	header('Location: ../view/index.php?relatarErro');
	exit();
}

$daoUsuario = new DaoUsuario();

if($daoUsuario->fazerLogin($email, $senha)) {
	$usuario = unserialize($daoUsuario->getUsuario());

    // Setando o horario de recife
	date_default_timezone_set('America/Recife');

    // Definimos logado como true
	$_SESSION['logado'] = true;
    // sessão do usuario, esta sessão guarda o objeto usuario
	$_SESSION['usuario'] = serialize($usuario);

	if ($usuario->getEmailAtivado() == 0) {
		header('Location: emailEnviarConfirmacao.php');
		exit;
	}

	if ($lembrarDeMim == 1) {
		setcookie('logado', $_SESSION['logado'], time()+60*60*24*365, '/');
		setcookie('usuario', $_SESSION['usuario'], time()+60*60*24*365, '/');
	}

	// Apagando cookies
	setcookie('formulario[email]', $email, time()-1, '/fiscalizape/view/login.php');
	setcookie('formulario[lembrarDeMim]', $lembrarDeMim, time()-1, '/fiscalizape/view/login.php');

	// Sucesso, redirecionando
	if (isset($_COOKIE['paginaVoltarx2'])) {
		$retorno = filter_var(unserialize($_COOKIE['paginaVoltarx2']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$retorno = str_replace('amp;', '', $retorno);
		if (strpos($retorno, '?') !== FALSE) {
			header('Location: ../view/' . $retorno . '&login=sucesso');
		} else {
			header('Location: ../view/' . $retorno . '?login=sucesso');
		}
	} else {
		header('Location: ../view/index.php?login=sucesso');
	}
	exit;
} else {
	$objErros->adicionarErro('Email e/ou senha inválidos');
	header('Location: ../view/login.php');
	exit;
}