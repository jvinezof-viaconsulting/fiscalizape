<?php

require_once '../vendor/autoload.php';
require_once '../controller/verificarAcessoUsuarioPermitido.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence', 'persistence', 'persistence', 'util'], ['DaoConexao', 'Sessao', 'DaoUsuario', 'Util']);

use Respect\Validation\Validator as v;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\persistence\DaoUsuario;
use \fiscalizape\persistence\Sessao;

$daoConexao = new DaoConexao();

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$foto = $_FILES['arquivoFoto'];
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nomeUsuario = filter_input(INPUT_POST, 'nomeUsuario', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cep = filter_var(preg_replace("/[^0-9]/", "", $_POST['cep']), FILTER_SANITIZE_NUMBER_INT);



// Campos para redirecionamento
$location = 'Location: ../view/editarperfil.php?';
$sucesso = 'sucesso=perfilEditado';
$erro = 'erro=houveAlgumProblema';
$avisoMsg = '';
$aviso = false;
$modificado = false;

$sessao = new Sessao();
$usuario = $sessao->getSessaoUsuario();

// Verificando campos em branco e/ou inalterados
if (v::stringType()->length(1, null)->validate($foto['name'])) {
	if ($foto['error'] == 0) {
		$formatosPermitidos = ['png', 'jpeg', 'jpg'];
		$extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);

		if (in_array($extensao, $formatosPermitidos)) {
			// Local onde a imagem está sendo armazenada temporariamente
			$arquivoTemporario = $foto['tmp_name'];

			$diretorio = '../imagens/avatars/uploads/';
			$nomeArquivo = $usuario->getId() . '_' . uniqid() . ".$extensao";

			if (move_uploaded_file($arquivoTemporario, $diretorio . $nomeArquivo)) {
				$daoConexao->atualizar('usuarios', ['usuario_foto'], ['uploads/' . $nomeArquivo], 'md5(usuario_id) = ?', [$id]);

				if ($daoConexao->linhasAfetadas() > 0) {
					$modificado = true;
					$usuario->setFoto('uploads/' . $nomeArquivo);
					$sessao->atualizarSessaoUsuario($usuario);
				}
			} else {
				$aviso = true;
				$avisoMsg .= 'erro=naoConseguimosMoverAhImagem';
			}
		} else {
			$aviso = true;
			$avisoMsg = '&erro=formatoDaImagemInvalido';
		}
	} else {
		$aviso = true;
		$avisoMsg .= '&naoConseguimosModificarAhFotoDoPerfil';
	}
}

if (v::stringType()->length(3, 50)->validate($nome) && $nome != $usuario->getNome()) {
	$daoConexao->atualizar('usuarios', ['usuario_nome'], [$nome], 'md5(usuario_id) = ?', [$id]);

	if ($daoConexao->linhasAfetadas() > 0) {
		$modificado = true;
		$usuario->setNome($nome);
		$sessao->atualizarSessaoUsuario($usuario);
	}
}

if (v::stringType()->length(3, 50)->validate($sobrenome) && $sobrenome != $usuario->getSobrenome()) {
	$daoConexao->atualizar('usuarios', ['usuario_sobrenome'], [$sobrenome], 'md5(usuario_id) = ?', [$id]);

	if ($daoConexao->linhasAfetadas() > 0) {
		$modificado = true;
		$usuario->setSobrenome($sobrenome);
		$sessao->atualizarSessaoUsuario($usuario);
	}
}

if (v::stringType()->length(3, 50)->validate($nomeUsuario) && $nomeUsuario != $usuario->getNomeUsuario()) {
	// Pegando todos os usuarios para verificar se exister algum com o mesmo nome de usuario
	$usuarios = $daoConexao->selecionar(['usuario_nome_usuario'], 'usuarios', 'usuario_nome_usuario = ?', [$nomeUsuario])->FetchAll(\PDO::FETCH_ASSOC);
	if (count($usuarios) > 0) {
		$aviso = true;
		$avisoMsg .= '&nomeDeUsuarioJaExiste';
	} else {
		$daoConexao->atualizar('usuarios', ['usuario_nome_usuario'], [$nomeUsuario], 'md5(usuario_id) = ?', [$id]);

		if ($daoConexao->linhasAfetadas() > 0) {
			$modificado = true;
			$usuario->setNomeUsuario($nomeUsuario);
			$sessao->atualizarSessaoUsuario($usuario);
		}
	}
}

if (v::stringType()->length(2, 2)->validate($estado) && $estado != $usuario->getEstado()) {
	$daoConexao->atualizar('usuarios', ['usuario_estado'], [$estado], 'md5(usuario_id) = ?', [$id]);

	if ($daoConexao->linhasAfetadas() > 0) {
		$modificado = true;
		$usuario->setEstado($estado);
		$sessao->atualizarSessaoUsuario($usuario);
	}
}

if (v::stringType()->length(8, 8)->validate($cep) && $cep != $usuario->getCep()) {
	$daoConexao->atualizar('usuarios', ['usuario_cep'], [$cep], 'md5(usuario_id) = ?', [$id]);

	if ($daoConexao->linhasAfetadas() > 0) {
		$modificado = true;
		$usuario->setCep($cep);
		$sessao->atualizarSessaoUsuario($usuario);
	}
}

if ($modificado && $aviso) {
	header($location . $sucesso . $avisoMsg);
	exit;
} else if ($aviso) {
	header($location . $avisoMsg);
	exit;
}

if ($modificado) {
	header($location . $sucesso);
	exit;
} else {
	header($location . 'aviso=NenhumDadoFoiEditado');
	exit;
}