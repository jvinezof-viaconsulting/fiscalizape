<?php
	require_once('../classes/Conexao.php');
	require_once('../classes/GerenciarUsuario.php');
	require_once('../classes/GerenciarLogs.php');
	$gerenciar_usuario = new GerenciarUsuario();
	$gerenciar_logs = new GerenciarLogs();

	// permissão mínima para acessar esta página
	$permissao_minima = 2;
	// se o usuário não estiver logado...
	if (!$gerenciar_usuario->estaLogado()) {
		$msg_log = $gerenciar_usuario->obterIPUsuario().' tentou acessar o Painel (página: usuarios)';
		$gerenciar_logs->inserirLogPainelErro($msg_log);
		// redireciona para a index
		header('Location: ' .SITE_URL. '/index.php');
		exit();
	// se o usuário estiver logado mas não tiver a permissão necessária para prosseguir...
	} elseif ($gerenciar_usuario->obterUsuarioPorSessao()['permissao'] < $permissao_minima) {
		$msg_log = $gerenciar_usuario->obterUsuarioPorSessao()['nome'].' tentou acessar o Painel sem permissão (página: usuarios)';
		$gerenciar_logs->inserirLogPainelErro($msg_log);
		// redireciona para a home
		header('Location: ' .SITE_URL. '/home.php');
		exit();
	} else {
		$conexao = new Conexao();
		// busca todos os usuários do banco de dados e armazena em $busca_usuarios
		$busca_usuarios = $conexao->selecionar('*', 'usuarios', '', '', '');

		// se receber via GET alguma das variáveis a seguir...
		if (isset($_GET['id']) && !empty($_GET['id'])) {
			if (filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
				// faz uma busca no banco de dados pelo usuário que tem o ID fornecido via GET
				$buscando = $conexao->selecionar('*', 'usuarios', 'id', '=', $_GET['id']);
				// se a busca não retornar uma excessão e afetar uma linha (ou seja, o usuário existe)...
				if (!is_a($buscando, 'PDOException') && $buscando->rowCount() == 1) {
					// a variável $busca_usuarios agora será o retorno da busca acima que foi armazenada na variável $buscando
					// sendo assim, a página HTML abaixo só mostrará o usuário que tem o ID fornecido via GET
					$busca_usuarios = $buscando;
				} else {
					$erro = 'Não existe nenhum usuário com o <b>ID</b> informado.';
				}
			} else {
				$erro = 'O <b>ID</b> informado é inválido.';
			}
		} elseif (isset($_GET['nome']) && !empty($_GET['nome'])) {
			if (filter_var($_GET['nome'], FILTER_SANITIZE_SPECIAL_CHARS)) {
				// faz uma busca no banco de dados pelo usuário que tem o Nome fornecido via GET
				$buscando = $conexao->selecionar('*', 'usuarios', 'nome', '=', $_GET['nome']);
				// se a busca não retornar uma excessão e afetar uma linha (ou seja, o usuário existe)...
				if (!is_a($buscando, 'PDOException') && $buscando->rowCount() == 1) {
					// a variável $busca_usuarios agora será o retorno da busca acima que foi armazenada na variável $buscando
					// sendo assim, a página HTML abaixo só mostrará o usuário que tem o Nome fornecido via GET
					$busca_usuarios = $buscando;
				} else {
					$erro = 'Não existe nenhum usuário com o <b>Nome</b> informado.';
				}
			} else {
				$erro = 'O <b>Nome</b> informado é inválido.';
			}
		} elseif (isset($_GET['email']) && !empty($_GET['email'])) {
			if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
				// faz uma busca no banco de dados pelo usuário que tem o E-mail fornecido via GET
				$buscando = $conexao->selecionar('*', 'usuarios', 'email', '=', $_GET['email']);
				// se a busca não retornar uma excessão e afetar uma linha (ou seja, o usuário existe)...
				if (!is_a($buscando, 'PDOException') && $buscando->rowCount() == 1) {
					// a variável $busca_usuarios agora será o retorno da busca acima que foi armazenada na variável $buscando
					// sendo assim, a página HTML abaixo só mostrará o usuário que tem o E-mail fornecido via GET
					$busca_usuarios = $buscando;
				} else {
					$erro = 'Não existe nenhum usuário com o <b>E-mail</b> informado.';
				}
			} else {
				$erro = 'O <b>E-mail</b> informado é inválido.';
			}
		}

		if (isset($_GET['usuario_deletado'])) {
			$sucesso = 'Usuário excluído com sucesso!';
		}
		if (isset($_GET['impossivel'])) {
			$impossivel = 'Você não pode excluir você mesmo!';
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once('includes/head.php') ?>
		<title>Usuários - Painel | <?php echo SITE_TITULO ?></title>
	</head>
	<body>
		<?php require_once('includes/navbar-top.php') ?>
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php require_once('includes/navbar-left.php') ?>
					<div class="span9">
						<div class="content">
							<div class="module">
								<div class="module-head">
									<h3>Usuários</h3>
								</div>
								<div class="module-body table">
									<div class="module-body">
										<!-- verifica se a variável $erro existe (ela é criada quando recebe algum erro via GET) -->
										<?php if(isset($erro)) { ?>
											<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>Erro!</strong> <?php echo $erro ?>
											</div>
										<?php } ?>
										<!-- verifica se a variável $impossivel existe (ela é criada quando o usuário tenta se auto excluir) -->
										<?php if(isset($impossivel)) { ?>
											<div class="alert alert-danger">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>Erro!</strong> <?php echo $impossivel ?>
											</div>
										<?php } ?>
										<!-- verifica se a variável $sucesso existe (ela é criada quando recebe algum erro via GET) -->
										<?php if(isset($sucesso)) { ?>
											<div class="alert alert-success">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<strong>Sucesso!</strong> <?php echo $sucesso ?>
											</div>
										<?php } ?>
									</div>

									<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display"
										width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>Nome</th>
												<th>Email</th>
												<th>Permissão</th>
												<th>Último acesso</th>
												<th colspan="2">Ações</th>
											</tr>
										</thead>
										<tbody>
										<!-- só faz a busca se não houver erro -->
										<?php if (!isset($erro)) { ?>
											<?php foreach ($busca_usuarios as $linha) { ?>
												<tr class="odd gradeX">
													<td> <?php echo $linha['id'] ?> </td>
													<td> <?php echo $linha['nome'] ?> </td>
													<td> <?php echo $linha['email'] ?> </td>
													<td> <?php echo $linha['permissao'] ?> </td>
													<td> <?php echo date('d/m/Y H:i:s', strtotime($linha['ultimo_acesso'])) ?> </td>
													<td>
														<button class="btn btn-primary" onclick="location.href='usuario.php?id=<?php echo $linha['id'] ?>'">Editar</button>
													</td>
													<td>
														<form method="POST" action="util/excluirUsuario.php">
															<button type="submit" class="btn btn-danger" name="id" value="<?php echo $linha['id'] ?>">Excluir</button>
														</form>
													</td>
												</tr>
											<?php } ?>
										<?php } ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<?php require_once('includes/footer.php') ?>
		</footer>
	</body>
</html>
