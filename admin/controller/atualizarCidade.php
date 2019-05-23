<?php

require_once '../util/config.php';
new \fiscalizape\Autoload(['persistence', 'persistence'], ['DaoCidade', 'DaoConexao']);

use Respect\Validation\Validator as v;
use \fiscalizape\persistence\DaoCidade;
use \fiscalizape\persistence\DaoConexao;
$daoConexao = new DaoConexao();

// Dados enviados pelo formulario
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_SPECIAL_CHARS);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$populacao = filter_input(INPUT_POST, 'populacao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$prefeito = filter_input(INPUT_POST, 'prefeito', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Pegamos a cidade antiga para verificar se os dados foram modificados
$daoCidade = new DaoCidade();
$cidadeAntiga = $daoCidade->procurarCidade($id);

// Criamos um array que vai guardar todos os dados que devem ser atualizados e os campos
$campos = [];
$valores = [];


// Mas antes verificamos se algum dado foi passado em branco
// Caso foi passado um valor em branco nós mantemos os dados antigos
if (v::notBlank()->validate($nome) && $nome != $cidadeAntiga->getNome()) {
    // Se não estiver em branco e for diferente do antigo atualizamos ele
	array_push($campos, 'cidade_nome');
	array_push($valores, $nome);
}

// Verificamos o proximo
if (v::notBlank()->validate($estado) && $estado != $cidadeAntiga->getEstado()) {
    array_push($campos, 'cidade_estado');
    array_push($valores, $estado);
}


// Verificamos o proximo
if (v::notBlank()->validate($area) && $area != $cidadeAntiga->getArea()) {
    array_push($campos, 'cidade_area');
    array_push($valores, $area);
}

// Vericamos o proximo
if (v::notBlank()->validate($populacao) && $populacao != $cidadeAntiga->getPopulacao()) {
    array_push($campos, 'cidade_populacao');
    array_push($valores, $populacao);
}

// Ultimo
if (v::notBlank()->validate($prefeito) && $prefeito != $cidadeAntiga->getPrefeito()) {
    array_push($campos, 'cidade_prefeito');
    array_push($valores, $prefeito);
}

// Verificando se os dados da atualização são similar a alguma já cadastrada
$todosNomes = $daoConexao->selecionarFetch(['cidade_nome', 'cidade_estado'], 'cidades', 'cidade_nome = ? AND cidade_estado = ?', [$nome, $estado]);
// Se retornar alguma coisa, não atualizamos e exibimos um erro
if ($todosNomes) {
    header('Location: ../view/cidadeEditar.php?h=' . $cidadeAntiga->getId() . '&aviso=Encontramos%20uma%20ciade%20parecida%20com%20essa: ' . $nome);
	exit;
}

if ($daoCidade->atualizarCidade($id, $campos, $valores)) {
    header('Location: ../view/cidadeEditar.php?h=' . $cidadeAntiga->getId() . '&sucesso=' . $nome);
    exit;
} else {
    header('Location: ../view/cidadeEditar.php?h=' . $cidadeAntiga->getId() . '&erro=HouveAlgumProblema');
    exit;
}