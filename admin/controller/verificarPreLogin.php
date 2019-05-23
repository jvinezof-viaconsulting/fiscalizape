<?php

require_once '../../Autoload.php';
new \fiscalizape\Autoload("persistence", "Sessao");

use \fiscalizape\persistence\Sessao;
$sessao = new Sessao();

if (!$sessao->estaLogado()) {
    header('Location: ../../view/login.php?erro=SomenteUsuariosLogadosTemAcessoAdministrativo');
    exit;
}