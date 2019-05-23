<?php
	require_once '../util/config.php';
	new \fiscalizape\Autoload('persistence', 'DaoCidade');
	use \fiscalizape\persistence\DaoCidade;

	$id = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_SPECIAL_CHARS);

	if(empty($id)) {
	    header('Location: ../view/cidadeListar.php?selecioneUmaCidadeParaEditar');
	    exit;
	}

	$daoCidade = new DaoCidade();
	$cidade = $daoCidade->procurarCidade($id);

	if ($cidade->getId() == NULL) {
	    header('Location: ../view/cidadeListar.php?cidadeInvalida');
	    exit;
	}

	if (isset($_GET['sucesso'])) {
		$sucesso = filter_input(INPUT_GET, 'sucesso', FILTER_SANITIZE_SPECIAL_CHARS);
	}

	if (isset($_GET['aviso'])) {
		$erro = filter_input(INPUT_GET, 'aviso', FILTER_SANITIZE_SPECIAL_CHARS);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once('includes/head.php') ?>
		<title>Editando a cidade: <?php echo $cidade->getNome() ?> - Painel | FiscalizaPE</title>
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
									<h3>Editando a cidade: <?php echo $cidade->getNome() ?></h3>
								</div>
								<div class="module-body">
									<!-- verifica se a variável $erro existe (ela é criada quando recebe algum erro via GET) -->
									<?php if(isset($erro)) { ?>
										<div class="alert alert-error">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Erro!</strong> <?php echo $erro ?>
										</div>
									<?php } ?>
									<!-- verifica se a variável $sucesso existe -->
									<?php if(isset($sucesso)) { ?>
										<div class="alert alert-success">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong><?php echo $sucesso ?></strong>
										</div>
									<?php } ?>

									<form method="post" action="../controller/atualizarCidade.php" class="form-horizontal row-fluid">
										<input type="hidden" name="id" value="<?php echo $cidade->getId(); ?>">

										<div class="control-group">
											<label class="control-label" for="nome">Nome</label>
											<div class="controls">
												<input type="text" class="span8" id="nome" name="nome" value="<?php echo $cidade->getNome(); ?>" placeholder="Digite um nome..." required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="estado">Estado</label>
											<div class="controls">
												<select id="estado" name="estado">
									                <option value="" disabled hidden <?php echo $cidade->getEstado() == "" ? 'selected' : ''; ?>>Escolha um estado</option>
													<option value="PE" <?php echo $cidade->getEstado() == "PE" ? 'selected' : ''; ?>>Pernambuco</option>
									            </select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="area">Área</label>
											<div class="controls">
												<input type="text" class="span8" id="area" name="area" min="0" max="159.533.328" placeholder="ex: 218,435 (recife)" onkeyup="mascara('###,###,###', this, event, true)" value="<?php echo $cidade->getArea() ?>">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="populacao">População</label>
											<div class="controls">
												<input type="text" class="span8" id="populacao" name="populacao" min="0" placeholder="ex: 1,637,834 (recife)" onkeyup="mascara('###,###,###', this, event, true)" value="<?php echo $cidade->getPopulacao() ?>">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="prefeito">Prefeito</label>
											<div class="controls">
												<input type="text" class="span8" id="prefeito" name="prefeito" placeholder="Digite o nome do prefeito" value="<?php echo $cidade->getPrefeito() ?>">
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<input type="submit" class="btn btn-primary" value="Atualizar">
												<a class="btn btn-danger" href="./cidadeListar.php">Cancelar</a>
											</div>
										</div>
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
	</body>
</html>
