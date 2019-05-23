<?php
require_once '../../Autoload.php';
require_once './vericarJaEstaLogado.php';

new \fiscalizape\Autoload(array("util", "persistence", "persistence", "admin/model", "admin/model", "admin/persistence"), array("Util", "DaoConexao", "sessao", "ControleDeAcesso", "Log", "DaoAdminOnline"));
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\admin\model\ControleDeAcesso;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\util\Util;
use \fiscalizape\admin\model\Log;

$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

$daoConexao = new DaoConexao();
$sessao = new Sessao();
$util = new Util();
$controle = new ControleDeAcesso("../../view/index.php?voceNaoTemPermissaoParaAcesserAquelaPagina");
$log = new Log();
$usuario = $sessao->getSessaoUsuario;

$resultado = $daoConexao->selecionar("usuario_email, usuario_senha", "usuarios", "usuario_email = {$email}")->feth(PDO::FETCH_ASSOC);

// Verificando se o usuario existe de fato
if ($util->compararHash($senha, $resultado['usuario_senha'])) {
    // Verificando se o usuario que logou é o mesmo que está logado
    if ($usuario->getEmail() == $email) {
        // Finalmente verificamos se o usuario tem o nivel de acesso
        $id = $usuario->getId();
        if($controle->acessoNivelA($id)) {
            $_SESSION['acessoPermitido'] = 1;
            header('Location: ../view/index.php');
            exit;
        }
    } else {
        $log->logEmailDiferente();
        header('Location: ../../view/index.php?EmailDiferente');
        exit;
    }
} else {
    header('Location ../view/login.php?emailOuSenhaInvalidos');
    exit;
}