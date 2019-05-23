<?php
/*
 ESTA DANDO ERRO PORQUE O CODIGO É UMA STRING, MODIFICAR ISTO NO BANCO DE DADOS,
 OU VER UMA MANEIRA DE TORNAR ISTO VIAVEL.
*/

require_once '../../Autoload.php';
new \fiscalizape\Autoload("persistence", "DaoConexao");

use \fiscalizape\persistence\DaoConexao;

$daoConexao = new DaoConexao();

$codigoInput = filter_input(INPUT_POST, 'codigo', FILTER_VALIDATE_INT);
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

$prefixo = $codigoInput . '%';

$resultado = $daoConexao->selecionar('codigo', 'erros', "codigo LIKE '$prefixo'")->fetchAll();
$ultimo_indice = count($resultado) - 1;
$codigoString = $resultado[$ultimo_indice]["codigo"];
$codigoArray = explode("-", $codigoString);
$codigoArray[1]++;
$codigo = implode("-", $codigoArray);

# Vamos inserir no banco de dados
$daoConexao->inserir('erros', 'codigo, descricao', array($codigo, $descricao));
var_dump($daoConexao);

# Agora vamos verificar se incluiu no banco de dados
$resultadoVerificacao = $daoConexao->selecionar('codigo', 'erros', "codigo LIKE '$prefixo'")->fetchAll();
$ultimo_indiceVerificacao = count($resultado) - 1;
$codigoStringVerificacao = $resultado[$ultimo_indice]["codigo"];

if($codigoStringVerificacao == $codigo) {
	#header('Location: ../view/erroListar.php?sucesso');
	#exit();
} else {
	#header('Location: ../view/erroListar.php?erro');
	#exit();
}

