<?php

require_once '../util/config.php';
new \fiscalizape\Autoload("persistence", "DaoConexao");

use Respect\Validation\Validator as v;
use fiscalizape\persistence\DaoConexao;

$nome = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$populacao = filter_input(INPUT_POST, 'populacao', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$prefeito = filter_input(INPUT_POST, 'prefeito', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$escape = 'Location: ../view/cidadeCadastrar.php?';
if (v::stringType()->length(4, 50)->validate($nome)) {
    if (v::stringType()->length(2, 2)->validate($estado)) {
        if (v::stringType()->length(0, 12)->validate($area)) {
            if (v::stringType()->length(0, 12)->validate($populacao)) {
                if (v::stringType()->length(4, 50)->validate($prefeito)) {
                    $daoConexao = new DaoConexao();

                    // Verificando se já possui uma cidade com o mesmo nome no mesmo estado
                    $todosNomes = $daoConexao->selecionarFetch(['cidade_nome', 'cidade_estado'], 'cidades', 'cidade_nome = ? AND cidade_estado = ?', [$nome, $estado]);
                    if ($todosNomes != false) {
                    	header('Location: ../view/cidadeListar.php?aviso=JaTemosUmaCidadeCadastradaComEsseNome');
                    	exit;
                    }

                    $daoConexao->inserir('cidades', ['cidade_nome', 'cidade_estado', 'cidade_area', 'cidade_populacao', 'cidade_prefeito'], [$nome, $estado, $area, $populacao, $prefeito]);

                    if ($daoConexao->linhasAfetadas() > 1) {
                        header($escape . 'sucesso=inserimosNoBanco&erro=houveUmProblemaGrave');
                        exit;
                    } else if ($daoConexao->linhasAfetadas() == 1) {
                        header('Location: ../view/cidadeListar?sucesso=inserimosNoBanco');
                        exit;
                    } else {
                        header($escape . 'erro=naoConseguimosInserirNoBancoDeDados');
                        exit;
                    }
                } else {
                    header($escape . 'erro=prefeitoInvalido');
                }
            } else {
                header($escape . 'erro=populacaoInvalida');
                exit;
            }
        } else {
            header($escape . 'erro=areaInvalida');
            exit;
        }
    } else {
       header($escape . 'erro=estadoInvalido');
    exit;
    }
} else {
    header($escape . 'erro=nomeInvalido');
    exit;
}