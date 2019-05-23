<?php
require_once '../Autoload.php';
new \fiscalizape\Autoload(array("persistence", "persistence"), array("Sessao", "DaoUsuario"));

use \fiscalizape\persistence\Sessao;
use \fiscalizape\persistence\DaoUsuario;

$sessao = new Sessao();

if ($sessao->estaLogado()) {
    $daoUsuario = new DaoUsuario();
    $usuario = unserialize($_SESSION['usuario']);
    $id = md5(session_id());
    $get = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($id === $get) {
        $daoUsuario->deslogar($usuario);
        setcookie('logado', $_SESSION['logado'], time()-1, '/');
        setcookie('usuario', $_SESSION['usuario'], time()-1, '/');
        header('Location: ../view/index.php?sucesso=logout&msg=volteSempre');
        exit;
    } else {
        header('Location: ../view/index.php');
        exit;
    }
} else {
    header('Location: ../view/index.php');
    exit;
}

