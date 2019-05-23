<?php
require '../Autoload.php';
new \fiscalizape\Autoload('persistence', 'Sessao');
$sessao = new \fiscalizape\persistence\Sessao();

if($sessao->estaLogado()) {
    header('Location: ../controller/loginSair.php?h='. md5(session_id()));
    exit;
} else {
    header('Location: ./index.php');
    exit;
}

