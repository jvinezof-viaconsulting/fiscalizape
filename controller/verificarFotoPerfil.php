<?php
require '../vendor/autoload.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence', 'persistence', 'persistence'], ['DaoUsuario', 'Sessao', 'DaoConexao']);

use YoHang88\LetterAvatar\LetterAvatar as Avatar;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\persistence\DaoConexao;

if (is_null($perfil->getFoto())) {
    $nome = ucfirst($perfil->getNome());
    $sobrenome = ucfirst($perfil->getSobrenome());
    $nomeSobrenome = $nome . ' ' . $sobrenome;
    $iniciais = $nome[0] . $sobrenome[0];
    // Verificando uma imagem para esta inicial
    if (!file_exists('../imagens/avatars' . $iniciais . '.png')) {
        // Se não existir criamos

        $avatar = new Avatar($nomeSobrenome, 'square', 250);
        $avatar->setColor('#1E90FF', '#fff');
        $avatar->saveAs('../imagens/avatars/' . $iniciais . '.png');
    }

    $sessao = new Sessao();
    if ($sessao->estaLogado()) {
        $usuario = $sessao->getSessaoUsuario();
        $usuario->setFoto($iniciais . '.png');
        $sessao->atualizarSessaoUsuario($usuario);

        // Atualizamos no banco para poupar carregamento
        $daoConexao = new DaoConexao;
        $daoConexao->atualizar('usuarios', ['usuario_foto'], [$iniciais . '.png'], 'md5(usuario_id) = ?', [$usuario->getId()]);
    }

    $perfil->setFoto($iniciais . '.png');
    sleep(1);
}