<?php
	require_once '../util/config.php';
	new \fiscalizape\Autoload('persistence', 'DaoCidade');

	use \fiscalizape\persistence\DaoCidade;

	$daoCidade = new DaoCidade();
	$cidades = $daoCidade->listarCidades();
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
									<h3>Todas as cidades</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display"
										width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>Nome</th>
												<th>Estado</th>
												<th>Área</th>
												<th>População</th>
                                                <th>Prefeito</th>
                                                <th>Obras</th>
												<th colspan="2">Ações</th>
											</tr>
										</thead>
										<tbody>
											<?php
                                                for ($i = 0; $i < count($cidades); $i++) {
                                                    $cidadeAtual = $cidades[$i];
                                            ?>
                                            <tr>
                                                <td><?php echo $cidadeAtual->getId() ?></td>
                                                <td><?php echo $cidadeAtual->getNome() ?></td>
                                                <td><?php echo $cidadeAtual->getEstado() ?></td>
                                                <td><?php echo $cidadeAtual->getArea() ?></td>
                                                <td><?php echo $cidadeAtual->getPopulacao() ?></td>
                                                <td><?php echo $cidadeAtual->getPrefeito() ?></td>
                                                <td><?php echo $daoCidade->getNumeroObras($cidadeAtual->getId()); ?></td>
                                                <td><a class="btn btn-primary" href="./cidadeEditar.php?h=<?php echo md5($cidadeAtual->getId()) ?>">Editar</a></td>
                                                <td><a href="../controller/removerCidade.php?h=<?php echo md5($cidadeAtual->getId()); ?>" class="btn btn-danger" onclick="confirmarExcluir('../controller/removerCidade.php?h=<?php echo md5($cidadeAtual->getId()); ?>', '<?php echo $cidadeAtual->getNome(); ?>');return(false)">Excluir</a></td>
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
