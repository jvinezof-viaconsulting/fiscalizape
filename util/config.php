<?php
require_once '../Autoload.php';
$autoLoad = new \fiscalizape\Autoload(['persistence', 'model', 'controller'], ['Sessao', 'ControleDeAcesso', 'lembrarDeMim']);
use \fiscalizape\persistence\Sessao;

$sessao = new Sessao();
if($sessao->estaLogado()) {
    $_SESSION['paginaAtual'] = basename(__FILE__);
    $autoLoad->load("controller", "verificarEmailAtivado");
    $usuario = $sessao->getSessaoUsuario();
    $controle = new fiscalizape\model\ControleDeAcesso('./index.php?erro=voceNaoTemPermissao');
}