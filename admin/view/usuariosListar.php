<?php
	require_once '../util/config.php';
	new \fiscalizape\Autoload('persistence', 'DaoUsuario');

	use \fiscalizape\persistence\DaoUsuario;

	$daoUsuario = new DaoUsuario();
	$usuarios = $daoUsuario->listarUsuarios();
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
									<h3>Todas os usuarios</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display"
										width="100%">
										<thead>
											<tr>
												<th>Nome</th>
												<th>Sobrenome</th>
												<th>CPF</th>
												<th>Email</th>
                                                <th>Email Ativado</th>
                                                <th>Ultimo Acesso</th>
                                                <th>Online</th>
												<th colspan="2">Ações</th>
											</tr>
										</thead>
										<tbody>
											<?php
                                                for ($i = 0; $i < count($usuarios); $i++) {
                                                    $u = $usuarios[$i];
                                            ?>
                                            <tr>
                                                <td><?php echo $u->getNome(); ?></td>
                                                <td><?php echo $u->getSobrenome(); ?></td>
                                                <td><?php echo $u->getCpf(); ?></td>
                                                <td><?php echo $u->getEmail(); ?></td>
                                                <td><?php echo $u->getEmailAtivado(); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($u->getUltimoAcesso())); ?></td>
                                                <td><?php echo $u->getOnline(); ?></td>
                                                <td><a class="btn btn-primary" href="./usuariosEditar.php?id=<?php echo $u->getId(); ?>">Editar</a></td>
                                            </tr>
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

		<script type="text/javascript">
			function confirmarExcluir(link, cidade) {
				if (confirm('Tem certeza que deseja excluir: ' + cidade + '?')) {
					window.location.href = link;
				}
			}
		</script>
	</body>
</html>
