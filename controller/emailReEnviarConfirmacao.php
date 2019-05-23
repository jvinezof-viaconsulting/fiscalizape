<?php

require_once '../Autoload.php';
new fiscalizape\Autoload("persistence", "Sessao");

use \fiscalizape\persistence\Sessao;

$sessao = new Sessao();

// Variaveis auxiliares, vamos usar para rederecionar o usuario
// Sucesso caso de tudo certo e falha caso algo de errado.
$sucesso = 'Location: ../view/sucesso.php?ReEnviamosSeuEmail';
$falha = 'Location: ../view/sucesso.php?NaoConseguimosReEnviarSeuEmail';

// Para re-enviar o email é obrigatorio está logado
// Verificamos se o usuario está logado
if ($sessao->estaLogado()) {
    // Esta logado, podemos seguir.
    $usuario = $sessao->getSessaoUsuario();

    // Email passado no form de sucesso
    $novoEmail = filter_input(INPUT_POST, 'novoEmail', FILTER_SANITIZE_EMAIL);
    // Confirmacao é usada para saber se o usuario chegou nesta pagina atraves do form de sucesso.
    $confirmacao = filter_input(INPUT_POST, 'confirmacao', FILTER_VALIDATE_INT);

    // Verificamos se o usuario partiu de view/sucesso.php
    if ($confirmacao != 1) {
        header('Location: ../index.php?error');
        exit;
    }

    // Mudamos o email do usuario para o email passado
    $usuario->setEmail($novoEmail);

    // Tudo certo, mandamos o usuario para pagina controller/emailEnviarConfirmacao para de lá enviarmos o email a ele
    header('Location: emailEnviarConfirmacao.php');
    exit;
} else {
    // Não está logado, mandamos para index
    header('Location: ../view/index.php?erro');
    exit;
}

