<?php
require_once '../Autoload.php';
new fiscalizape\Autoload(["model", "persistence"], ["Email", "Sessao"]);

use fiscalizape\model\Email;
use fiscalizape\persistence\Sessao;

// Iniciando o objeto sessao
$sessao = new Sessao();

// Verificando se tem uma sessao iniciada
if ($sessao->estaLogado()) {
	// se sim passamos o objeto usuario para a variavel
	$usuario = unserialize($_SESSION['usuario']);
} else {
	// Se não voltamos para a pagina inicial
	header('Location: ../view/index.php');
	exit();
}

// Criando mensagem
$assunto = "Confirme seu cadastro - FiscalizaPE";
ob_start();
require '../templates/emailConfirmacao.php';
$mensagem = ob_get_clean();
$para = [$usuario->getEmail(), $usuario->getSobrenome()];

// Configurando e enviando email
$mailer = new Email();
$mensagem = $mailer->mensagem($assunto, $mensagem, $para);
$resultado = $mailer->enviar($mensagem);

if ($resultado) {
	header('Location: ../view/sucesso.php?sucesso=emailReEnviadoComSucesso');
	exit;
} else {
	header('Location: ../view/sucesso.php?erro=naoConseguimosEnviarSeuEmail');
	exit;
}