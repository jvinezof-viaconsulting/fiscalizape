<?php

require_once '../../Autoload.php';
new fiscalizape\Autoload(["persistence", 'model'], ["Sessao", 'ControleDeAcesso']);

use \fiscalizape\persistence\Sessao;
use \fiscalizape\model\ControleDeAcesso;

$sessao = new Sessao();
$controle = new ControleDeAcesso('../../view/index.php?voceNaoTemPermissao');

$usuario = $sessao->getSessaoUsuario();
if (!$controle->acessoAdministrativo($usuario->getId())) {
	header('Location: ../../view/index.php?erro=voceNaoTemPermissao');
	exit;
}
