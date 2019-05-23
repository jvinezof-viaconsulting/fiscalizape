<?php
	require_once '../util/config.php';
	new \fiscalizape\Autoload(['persistence', 'util'], ['DaoUsuario', 'Util']);

	use \fiscalizape\persistence\DaoUsuario;
	use \fiscalizape\util\Util;

	$ut = new Util();
	$daoUsuario = new DaoUsuario();

	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$filtros = [ ['AND md5(usuario_id) = ?', $id] ];
	$u = $daoUsuario->listarUsuarios($filtros)[0];
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once('includes/head.php') ?>
		<title>Início - Painel | FiscalizaPE</title>
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
									<h3>Editar Usuario: <?php echo $u->getNome() . ' ' . $u->getSobrenome(); ?></h3>
								</div>
								<div class="module-body form">
									<form action="../controller/atualizarUsuario.php" method="post">
										<div class="form-inline">
											<label for="id">ID: </label>
											<input style="width: 40%;" type="text" name="id" value="<?php echo $u->getId(); ?>" readonly>
										</div>
										<br>

										<div class="form-inline">
											<label for="nome">Nome: </label>
											<input style="width: 40%;" class="form-control" type="text" name="nome" value="<?php echo $u->getNome(); ?>">
										</div>
										<br>

										<div class="form-inline">
											<label for="sobrenome">Sobrenome:</label>
											<input style="width: 40%;" class="form-control" type="text" name="sobrenome" value="<?php echo $u->getSobrenome(); ?>">
										</div>
										<br>

										<div class="form-inline">
											<label for="nomeUsuario">Usuario: </label>
											<input style="width: 40%;" class="form-control" type="text" name="nomeUsuario" value="<?php echo $u->getNomeUsuario(); ?>">
										</div>
										<br>

										<div class="form-inline">
											<label for="cpf">CPF:</label>
											<input style="width: 40%;" class="form-control" type="text" name="cpf" value="<?php echo $ut->mascara('###.###.###-##', $u->getCpf()); ?>">
										</div>
										<br>

										<div class="form-inline">
											<label for="email">Email</label>
											<input style="width: 40%;" class="form-control" type="text" name="email" value="<?php echo $u->getEmail(); ?>">
										</div>
										<br>

										<div class="form-inline">
											<label>Senha:</label>
											<input style="width: 40%;" type="text" name="senha">
										</div>
										<br>

										<div class="form-inline">
											<label for="emailPendente">Email Pendente:</label>
											<input style="width: 40%;" class="form-control" type="text" name="emailPendente" value="<?php echo $u->getEmailPendente(); ?>">
										</div>
										<br>

										<div class="form-inline">
											<label for="emailAtiviado">Email Ativado:</label> <br>
											<input class="form-check-input" type="radio" name="emailAtiviado" value="1" <?php echo ($u->getEmailAtivado() == 1) ? 'checked' : '' ?>> <label>Sim</label> <br>
											<input class="form-check-input" type="radio" name="emailAtiviado" value="0" <?php echo ($u->getEmailAtivado() == 0) ? 'checked' : '' ?>> <label>Não</label>
										</div>
										<br>

										<div class="form-inline">
											<label for="token">Token:</label>
											<input style="width: 40%;" class="form-control" type="text" id="token" value="<?php echo $u->getToken(); ?>" disabled>
										</div>
										<br>

										<div class="form-inline">
											<label for="cargo">Cargo: </label>
											<select name="cargo">
												<option value="B">Administrador</option>
												<option value="1">Usuario</option>
											</select>
										</div>
										<br>

										<div class="form-inline">
											<label for="registroData">Data de Registro:</label>
											<input type="date" id="registroData" value="<?php echo date('Y-m-d', strtotime($u->getRegistroData())); ?>" disabled>
										</div>
										<br>

										<div class="form-inline">
											<label for="registroIP">IP de Registro:</label>
											<input type="text" id="registroIP" value="<?php echo $u->getRegistroIP(); ?>" disabled>
										</div>
										<br>

										<div class="form-inline">
											<label for="ultimoAcesso">Ultimo Acesso:</label>
											<input type="datetime-local" id="ultimoAcesso" value="<?php echo $u->getUltimoAcesso(); ?>" disabled>
										</div>
										<br>

										<div class="form-inline">
											<label for="ultimoIP">Ultimo IP:</label>
											<input type="text" id="ultimoIP" value="<?php $u->getUltimoIP(); ?>" disabled>
										</div>
										<br>

										<div class="form-inline">
											<label for="online">Online:</label> <br>
											<input value="1" type="radio" name="online" <?php echo ($u->getOnline() == 1) ? 'checked' : '' ?>> <label>Sim</label> <br>
											<input value="0" type="radio" name="online" <?php echo ($u->getOnline() == 0) ? 'checked' : '' ?>> <label>Não</label>
										</div>
										<br>

										<div>
											<img style="width: 250px; height: 250px" src="../../imagens/avatars/<?php echo $u->getFoto(); ?>"> <br><br>
											<a class="btn btn-primary" href="#" onclick="return(false)">Alterar <i class="fas fa-edit"></i></a>
											<a class="btn btn-danger" href="#" onclick="return(false)">Apagar <i class="fas fa-times"></i></a>
										</div>
										<br>

										<div class="form-inline">
											<label for="verificado">Verificado: </label>
											<input type="radio" name="verificado" value="1" <?php echo ($u->getVerificado() == 1) ? 'checked' : '' ?>> <label>Sim</label>
											<input type="radio" name="verificado" value="0" <?php echo ($u->getVerificado() == 0) ? 'checked' : '' ?>> <label>Não</label>
										</div>
										<br>

										<div class="form-inline">
											<label for="estado">Estado: </label>
											<select name="estado">
												<option value="PE">Pernambuco</option>
											</select>
										</div>
										<br>

										<div class="form-inline">
											<label for="cidade">Cidade: </label>
											<input type="text" name="cidade" value="<?php $u->getCidade(); ?>">
										</div>
										<br>

										<div class="form-inline">
											<label for="cep">Cep: </label>
											<input type="text" name="cep" value="<?php echo $ut->mascara('#####-###', $u->getCep()); ?>">
										</div>
										<br>

										<input type="submit" name="enviar" class="btn btn-info" value="Atualizar">
									</form>
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

		<script type="text/javascript">
			function confirmarExcluir(link, cidade) {
				if (confirm('Tem certeza que deseja excluir: ' + cidade + '?')) {
					window.location.href = link;
				}
			}
		</script>
	</body>
</html>
