<?php
require_once '../util/config.php';
new \fiscalizape\Autoload('persistence', 'DaoCidade');

use fiscalizape\persistence\DaoCidade;

$id = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_SPECIAL_CHARS);

if (empty($id)) {
    // Se o id for vazio redirecionamos para a pagina de listar cidades
    header('Location: ../view/cidadeListar.php?erro=CidadeNaoEncontrada');
    exit;
}


$daoCidade = new DaoCidade();

// Deletamos a cidade
if($daoCidade->deletarCidade($id)) {
    header('Location: ../view/cidadeListar.php?sucesso=CidadeRemovidaComSucesso');
    exit;
} else {
    header('Location: ../view/cidadeListar.php?erro=NaoConseguimosRemover&aviso=MuitoProvavelmenteExistemObrasNessaCidade');
    exit;
}