<?php
require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence'], [ ['Sessao', 'DaoObra'] ]);

use \fiscalizape\persistence\Sessao;
use \fiscalizape\persistence\DaoObra;

$sessao = new Sessao();
$daoObra = new DaoObra();

if ($sessao->estaLogado()) {
	if (isset($_POST['idObra']) && isset($_POST['voto']) && isset($_POST['acao'])) {
		$idObra = filter_input(INPUT_POST, 'idObra', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$voto = filter_input(INPUT_POST, 'voto', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$acao = filter_input(INPUT_POST, 'acao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$usuario = $sessao->getSessaoUsuario();

		if($daoObra->adicionarVerdade($usuario->getId(), $idObra, $voto, $acao)) {
			return true;
		} else {
			return false;
		}

		exit;
	}

	exit;
}

exit;