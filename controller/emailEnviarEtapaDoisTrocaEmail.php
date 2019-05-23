<?php
require_once '../Autoload.php';
new \fiscalizape\Autoload(['model', 'persistence'], ['Email', 'DaoConexao']);

use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\model\Email;

// Setando o horario de recife
date_default_timezone_set('America/Recife');

// Variaveis importantes
$daoConexao = new DaoConexao();

// LEGENDA:
// h = hash md5 do id do usuario;
// v = hash md5 do email do usuario; (v de validador)
$h = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$v = filter_input(INPUT_GET, 'v', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tokenEmailGet = filter_input(INPUT_GET, 'tokenEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Definindo redirecionamentos
$sucesso = 'Location: ../view/instrucoes.php?sucesso=enviamosUmNovoEmail';
$lErro = 'Location: ../view/index.php?erro=';

// Retornando dados do email a partir do token
$dadosEmail = $daoConexao->selecionar(['*'], 'email_enviados', 'email_token = ?', [$tokenEmailGet])->fetch(\PDO::FETCH_ASSOC);

// Se não retornar nada já deu ruim
if (count($dadosEmail) == 0) {
	header($lErro . 'naoConseguimosRecuperarDadosDoSeuEmail&dica=facaOhLoginAndTenteMudarOhEmailNovamente');
	exit;
}

// Verificando data atual e comparando com a data de envio
$dataAgora = date("Y-m-d H:i-s", time());
if ($dataAgora < $dadosEmail['email_data_envio']) {
	header($lErro . 'houveUmProblemaGrave&espereUmPouco&TenteNovamente');
	exit;
}


// Verificando se o Id (h) é igual ao Foreign Key (email_usuario_id)
if ($h != md5($dadosEmail['email_id_usuario'])) {
	header($lEerro . 'houveUmProblemaNoLink&favor=constatarFatoAosAdministradores');
	exit;
}

// Verificando data de validade
if ($dataAgora > $dadosEmail['email_data_validade']) {
	header($lErro . 'emailVencido&dica=RefacaOhProcessoDeTroca');
	exit;
}

// Verificando se o email recebido já foi usado
if ($dadosEmail['email_utilizado'] != 0) {
	header($lErro . 'EsteEmailJaFoiUtilizado');
	exit;
}

// Verificando se o email recebido já foi usado
if ($dadosEmail['email_utilizado'] != 0) {
	header($lErro . 'EsteEmailJaFoiUtilizado');
	exit;
}

// Pegando o sobre nome do usuario, email pendente e o email atual
$dadosUsuario = $daoConexao->selecionar(['usuario_sobrenome', 'usuario_email', 'usuario_email_pendente'], 'usuarios', 'usuario_id = ?', [$dadosEmail['email_id_usuario']])->fetch(\PDO::FETCH_ASSOC);


// Verificando se não é vazio
if ($dadosUsuario['usuario_email_pendente'] == null) {
	header($lErro . 'houveUmProblemaAndNaoConseguimosAtualizarSeuEmail');
	exit;
}

// Verificando se é igual ao passado no link
if (md5($dadosUsuario['usuario_email']) != $v) {
	header($lErro . 'houveUmProblemaComOhLinkAndPorIssoNaoConseguimosAtualizarSeuEmail');
	exit;
}

// Verificando se algum usuario já possui o novo email
$todosEmailsUsuarios = $daoConexao->selecionar(['usuario_email'], 'usuarios');
foreach($todosEmailsUsuarios as $emailAtual) {
	if ($dadosUsuario['usuario_email_pendente'] == $emailAtual['usuario_email']) {
		header($lErro . 'emailJaCadastrado');
		exit;
	}
}

// Agora vamos enviar um email para o email pendente
$tokenEmail = md5(uniqid(mt_rand(), true));
$assunto = "Troca de Email - FiscalizaPE";
ob_start();
require '../templates/confirmacaoTrocaEmailPendente.php';
$body = ob_get_clean();
$para = [$dadosUsuario['usuario_email_pendente'], $dadosUsuario['usuario_sobrenome']];

// Configurando e enviando email
$mailer = new Email();
$mensagem = $mailer->mensagem($assunto, $body, $para);
$resultado = $mailer->enviar($mensagem);

if ($resultado) {
	// Inserindo email enviado na tabela de emails enviados
	//
	// Precisamos do id real do usuario por isso damos select e pegamos e id
	$resultadoId = $daoConexao->selecionar(['usuario_id'], 'usuarios', 'md5(usuario_id) = ?', [$h])->fetch(\PDO::FETCH_ASSOC);

	$idReal = $resultadoId['usuario_id'];
	$dataValidadeTime = strtotime("+2 days");
	$dataValidade = date("Y-m-d G:i:s", $dataValidadeTime);

	$daoConexao->inserir('email_enviados', ['email_token', 'email_id_usuario', 'email_data_validade'], [$tokenEmail, $idReal, $dataValidade]);

	// Setando campo email_utilizado do email que foi utilizado para chegar aq como true
	$daoConexao->atualizar('email_enviados', ['email_utilizado'], [1], 'email_token = ?', [$tokenEmailGet]);

	header($sucesso);
	exit;
} else {
	header($erro . 'naoConseguimosEnviarSeuEmail');
	exit;
}