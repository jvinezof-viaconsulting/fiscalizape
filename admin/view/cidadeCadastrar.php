<?php
	require_once '../util/config.php';	
?>
<!DOCTYPE html>
<html>
	<head>
		<?php require_once('includes/head.php') ?>
		<title>Cadastrar nova cidade - Painel | FiscalizaPE</title>
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
									<h3>Cadastrar nova cidade</h3>
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

									<form method="POST" action="../controller/incluirCidade.php" class="form-horizontal row-fluid">
										<div class="control-group">
											<label class="control-label" for="cidade">Nome</label>
											<div class="controls">
												<input type="text" class="span8" id="cidade" name="cidade" placeholder="Digite um nome..." required>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="estado">Estado</label>
											<div class="controls">
												<select id="estado" name="estado">
									                <option value="" disabled selected hidden>Escolha um estado</option>
									                <option value="PE">Pernambuco</option> 
									            </select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="area">Área</label>
											<div class="controls">
												<input type="text" id="area" name="area" min="0" max="159.533.328" placeholder="ex: 218,435 (recife)" onkeyup="mascara('###,###,###', this, event, true)">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="populacao">População</label>
											<div class="controls">
												<input type="text" id="populacao" name="populacao" min="0" placeholder="ex: 1,637,834 (recife)" onkeyup="mascara('###,###,###', this, event, true)">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="prefeito">Prefeito</label>
											<div class="controls">
												<input type="text" id="prefeito" name="prefeito" placeholder="Digite o nome do prefeito" value="">
											</div>
										</div>

										<div class="control-group">
											<div class="controls">
												<input type="submit" class="btn btn-primary" value="Cadastrar">
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
