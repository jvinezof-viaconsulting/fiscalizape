<?php
require_once '../Autoload.php';
new \fiscalizape\Autoload(['controller', 'persistence', 'persistence', 'persistence', 'util'], ['verificarAcessoUsuarioPermitido', 'DaoUsuario', 'Sessao', 'DaoConexao', 'Util']);


use \fiscalizape\persistence\DaoUsuario;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\util\Util;

// Definindo redirecionamentos
$location = 'Location: ../view/alterarsenha.php?';
$sucesso = 'Location: ../view/login.php?sucesso=conseguimosAlterarSuaSenha';
$erro = $location . 'erro=NaoFoiPossivelAterarSuaSenha';

$senhaAtual = filter_input(INPUT_POST, 'senhaAtual', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$novaSenha = filter_input(INPUT_POST, 'novaSenha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$novaSenhaRepita = filter_input(INPUT_POST, 'novaSenhaRepita', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$daoUsuario = new DaoUsuario();
$sessao = new Sessao();
$usuario = $sessao->getSessaoUsuario();

// Verifica se a senha atual estar correta
if ($daoUsuario->verificarSenha($usuario->getId(), $senhaAtual)) {
	// Verifica se as duas senhas digitadas são iguais
	if ($novaSenha === $novaSenhaRepita) {
		$util = new Util();
		$daoConexao = new DaoConexao();

		$novaSenhaHash = $util->gerarHash($novaSenha);
		$daoConexao->atualizar('usuarios', ['usuario_senha'], [$novaSenhaHash], 'md5(usuario_id) = ?', [$usuario->getId()]);

		if ($daoConexao->linhasAfetadas() > 0) {
			$daoUsuario->deslogar($usuario);
			header($sucesso);
			exit;
		} else {
			header($erro);
			exit;
		}
	} else {
		header($erro . '&erro=AsSenhasNaoConferem');
		exit;
	}
} else {
	header($erro);
	exit;
}