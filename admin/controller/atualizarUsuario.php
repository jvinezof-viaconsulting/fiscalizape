<?php
require_once '../util/config.php';
new \fiscalizape\Autoload(['persistence', 'util'], [ ['DaoUsuario', 'DaoConexao'], 'Util' ]);

use Respect\Validation\Validator as v;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\persistence\DaoUsuario;
use \fiscalizape\util\Util;

$daoConexao = new DaoConexao();
$daoUsuario = new DaoUsuario();
$ut = new Util();

$inputs = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Redirecionamentos
$sucesso = 'location: ../view/usuariosListar.php?sucesso=UsuarioEditado';
$lerro = 'location: ../view/usuariosEditar.php?id=' . $inputs['id'];
$erro = $lerro;

// DADOS DO USUARIO ANTIGO
$filtros = [
	[ 'AND md5(usuario_id) = ?', $inputs['id'] ]
];
$uA = $daoUsuario->listarUsuarios($filtros)[0];

if ($uA == false) {
	$ut->h($erro);
}

// nome
if (v::stringType()->length(4, 50)->validate($inputs['nome'])) {
	if ($inputs['nome'] != $uA->getNome()) {
		$daoConexao->atualizar('usuarios', ['usuario_nome'], [$inputs['nome']], 'md5(usuario_id) = ?', [$inputs['id']]);
		if ($daoConexao->linhasAfetadas() == 0) {
			$erro .= '&bdErro=nome';
		}
	}
} else {
	$erro .= '&campo=nomeInvalido';
}

if (v::stringType()->length(4, 50)->validate($inputs['sobrenome'])) {
	if ($inputs['sobrenome'] != $uA->getSobrenome()) {
		$daoConexao->atualizar('usuarios', ['usuario_sobrenome'], [$inputs['sobrenome']], 'md5(usuario_id) = ?', [$inputs['id']]);
		if ($daoConexao->linhasAfetadas() == 0) {
			$erro .= '&bdErro=sobrenome';
		}
	}
} else {
	$erro .= '&campo=sobrenomeInvalido';
}

if ($erro != $lerro) {
	$ut->h($erro);
}

$ut->h($sucesso);