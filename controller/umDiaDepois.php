<?php
	date_default_timezone_set("America/Recife");
	if (isset($_POST['data'])) {
		$dataPost = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$time = strtotime($dataPost) + 60*60*24;
		echo date('Y-m-d', $time);
		exit;
	}

	/*
	 * Gerando erro (acesso negado)
	*/
	require_once '../Autoload.php';
	new \fiscalizape\Autoload('model', 'Erros');

	$pagina = $_COOKIE['paginaVoltar'];
	$dono = explode('.', $pagina);
	$objerros = new \fiscalizape\model\Erros($dono[0], 60);

	$erro = "Acesso negado!";

	if ($objerros->existeCookie()) {
		$erros = $objerros->getCookie(false);
		if (!in_array($erro, $erros)) {
			$objerros->adicionarErro($erro);
		}
	} else {
		$objerros->adicionarErro($erro);
	}

	header('Location: ../view/' . $pagina);
	exit;