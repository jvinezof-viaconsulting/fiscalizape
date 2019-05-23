<?php
require_once '../Autoload.php';
new fiscalizape\Autoload(['persistence'], ['DaoConexao']);

use fiscalizape\persistence\DaoConexao;
use fiscalizape\persistence\Sessao;

// Setando o horario de recife
date_default_timezone_set('America/Recife');

// Variaveis importantes
$daoConexao = new DaoConexao();
$dataAgora = date("Y-m-d G:i:s", time());

// LEGENDA:
// h = hash md5 do id do usuario;
// v = hash md5 do email do usuario; (v de validador)
$h = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$v = filter_input(INPUT_GET, 'v', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$tokenEmail = filter_input(INPUT_GET, 'tokenEmail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


// Definindo redirecionamentos
$sucesso = 'Location: ../view/sair.php';
$erro = 'Location: ../view/index.php?erro=';

// Retornando dados do email a partir do token
$dadosEmail = $daoConexao->selecionar(['*'], 'email_enviados', 'email_token = ?', [$tokenEmail])->fetch(\PDO::FETCH_ASSOC);

// Se não retornar nada já deu ruim
if (count($dadosEmail) == 0) {
	header($erro . 'naoConseguimosRecuperarDadosDoSeuEmail&dica=facaOhLoginAndTenteMudarOhEmailNovamente');
	exit;
}

// Verificando se o Id (h) é igual ao Foreign Key (email_usuario_id)
if ($h != md5($dadosEmail['email_id_usuario'])) {
	header($erro . 'houveUmProblemaNoLink&favor=constatarFatoAosAdministradores');
	exit;
}

// Verificando data de validade
if ($dataAgora > $dadosEmail['email_data_validade']) {
	header($erro . 'emailVencido&dica=RefacaOhProcessoDeTroca');
	exit;
}

// Verificando se o email recebido já foi usado
if ($dadosEmail['email_utilizado'] != 0) {
	header($erro . 'EsteEmailJaFoiUtilizado');
	exit;
}

// Pegando o email pendente e o email atual
$emailUsuario = $daoConexao->selecionar(['usuario_email', 'usuario_email_pendente'], 'usuarios', 'usuario_id = ?', [$dadosEmail['email_id_usuario']])->fetch(\PDO::FETCH_ASSOC);

// Verificando se não é vazio
if ($emailUsuario['usuario_email_pendente'] == null) {
	header($erro . 'houveUmProblemaAndNaoConseguimosAtualizarSeuEmail');
	exit;
}

// Verificando se é igual ao passado no link
if (md5($emailUsuario['usuario_email']) != $v) {
	header($erro . 'houveUmProblemaComOhLinkAndPorIssoNaoConseguimosAtualizarSeuEmail');
	exit;
}

// Verificando se algum usuario já possui o novo email
$todosEmailsUsuarios = $daoConexao->selecionar(['usuario_email'], 'usuarios');
foreach($todosEmailsUsuarios as $emailAtual) {
	if ($emailUsuario['usuario_email_pendente'] == $emailAtual['usuario_email']) {
		header($erro . 'emailJaCadastrado');
		exit;
	}
}

// Finalmente vamos atualizar essa bagaça
$daoConexao->atualizar('usuarios', ['usuario_email', 'usuario_email_pendente'], [$emailUsuario['usuario_email_pendente'], null], 'usuario_id = ?', [$dadosEmail['email_id_usuario']]);

if ($daoConexao->linhasAfetadas() == 0) {
	header($erro . 'houveUmProblemaAndNaoConseguimosAtualizarAsInformacoes');
	exit;
}

// Setamos o email como utilizado para evitar que o processo se repita
$daoConexao->atualizar('email_enviados', ['email_utilizado'], [1], 'email_token = ?', [$tokenEmail]);

header($sucesso);
exit;