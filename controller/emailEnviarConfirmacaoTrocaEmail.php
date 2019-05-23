<?php
require_once '../Autoload.php';
new \fiscalizape\autoload(['vendor', 'controller', 'persistence', 'util', 'persistence', 'model'], ['autoload', 'verificarAcessoUsuarioPermitido', 'Sessao', 'Util', 'DaoConexao', 'Email']);

use fiscalizape\util\Util;
use fiscalizape\persistence\DaoConexao;
use fiscalizape\persistence\Sessao;
use fiscalizape\model\Email;
use Respect\Validation\Validator as v;

// Setando o horario de recife
date_default_timezone_set('America/Recife');

// Definindo redirecionamentos
$sucesso = 'Location: ../view/alteraremail.php?sucesso=EmailModificado&ps=exibirInstrucoes';
$lErro = 'Location: ../view/alteraremail.php?erro=';

// Variaveis importantes
$util = new Util();
$sessao = new Sessao();
$daoConexao = new DaoConexao;
$usuario = $sessao->getSessaoUsuario();

// Limpando input's
$novoEmail = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Verificando se a senha está correta
$senhaUsuario = $daoConexao->selecionar(['usuario_senha'], 'usuarios', 'md5(usuario_id) = ?', [$usuario->getId()])->fetch(\PDO::FETCH_ASSOC);
if (!$util->compararHash($senha, $senhaUsuario['usuario_senha'])) {
	header($lErro . 'houveUmProblema&ps=TaMtoNaCaraQueOhErroFoiAhSenhaMasDpsTiraIssoPf');
	exit;
}

// Verificando se o input tá vazio ou os emails são iguais, a verificação são pra dados validos por isso precisamos nega-lá
if (!v::stringType()->notBlank()->email()->validate($novoEmail) || $usuario->getEmail() == $novoEmail) {
	if ($usuario->getEmail() == $novoEmail) {
		header($lErro . 'esteJaEhSeuEnderecoDeEmail');
	} else {
		header($lErro . 'emailInvalido');
	}

	exit;
}

// Verificando se já é o email de um outro usuario
$emails = $daoConexao->selecionar(['usuario_email'], 'usuarios')->fetchAll(\PDO::FETCH_ASSOC);
foreach ($emails as $emailAtual) {
	if ($novoEmail == $emailAtual['usuario_email']) {
		header($lErro . 'emailJaCadastrado');
		exit;
	}
}


// Tudo teoricamente certo, vamos fazer a pseudo troca.
$daoConexao->atualizar('usuarios', ['usuario_email_pendente'], [$novoEmail], 'md5(usuario_id) = ?', [$usuario->getId()]);

// Verificando se conseguimos atualizar no banco
if ($daoConexao->linhasAfetadas() == 0) {
        $emailTemp = $daoConexao->selecionar(['usuario_email_pendente'], 'usuarios', 'md5(usuario_id) = ?', [$usuario->getId()])->fetch(\PDO::FETCH_ASSOC);

        if ($emailTemp['usuario_email_pendente'] == $novoEmail) {
            $daoConexao->atualizar('usuarios', ['usuario_email_pendente'], [null], 'md5(usuario_id) = ?', [$usuario->getId()]);
        }

	header($lErro . 'houveUmProblema&tenteNovamente');
	exit;
}

// Enviando o email de confirmação
$tokenEmail = md5(uniqid(mt_rand(), true));
$assunto = "Troca de Email - FiscalizaPE";
ob_start();
require '../templates/emailConfirmacaoTrocaEmail.php';
$body = ob_get_clean();
$para = [$usuario->getEmail(), $usuario->getSobrenome()];

// Configurando e enviando email
$mailer = new Email();
$mensagem = $mailer->mensagem($assunto, $body, $para);
$resultado = $mailer->enviar($mensagem);

if ($resultado) {
	// Inserindo email enviado na tabela de emails enviados
	//
	// Precisamos do id real do usuario por isso damos select e pegamos e id
	$resultadoId = $daoConexao->selecionar(['usuario_id'], 'usuarios', 'md5(usuario_id) = ?', [$usuario->getId()])->fetch(\PDO::FETCH_ASSOC);

	$idReal = $resultadoId['usuario_id'];
	$dataValidadeTime = strtotime("+2 days");
	$dataValidade = date("Y-m-d G:i:s", $dataValidadeTime);

	$daoConexao->inserir('email_enviados', ['email_token', 'email_id_usuario', 'email_data_validade'], [$tokenEmail, $idReal, $dataValidade]);

	header($sucesso);
	exit;
} else {
	header($erro . 'naoConseguimosEnviarSeuEmail');
	exit;
}