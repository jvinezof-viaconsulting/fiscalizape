<?php
new \fiscalizape\Autoload(['persistence', 'util'], ['Sessao', 'Util']);
use \fiscalizape\persistence\Sessao;
use \fiscalizape\util\Util;

$sessao = new Sessao();
$util = new Util();

if ($sessao->estaLogado()) {
	$usuario = $sessao->getSessaoUsuario();
	$script = $util->scriptPai();

	if ($usuario->getEmailAtivado() != 1 && $script != "sucesso.php") {
		header('Location: sucesso.php?ativeSeuEmail');
		exit;
	}
}
