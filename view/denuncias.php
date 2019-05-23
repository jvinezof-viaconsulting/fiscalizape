<?php
	require_once '../Autoload.php';
	$load = new \fiscalizape\Autoload('model', 'Breadcrumb');

	use \fiscalizape\model\Breadcrumb as bc;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>

	<title>Denúncias</title>

	<style type="text/css">
		table#tabela th {
			background-color: #D3D7FD;
			padding: 5px;
		}
		table#tabela td {
			padding: 5px;
		}
	</style>
</head>

<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<main role="main">
		<div class="container mt-3">
			<?php bc::gerar([ bc::denuncias() ]) ?>
			<!-- Exemplo de linha de colunas -->
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Denúncias</h3>
					<hr>
					<div class="row">
						<div class="col-md-4 mb-3">
							<label for="bairro">Selecione um bairro:</label>
							<select class="custom-select d-block w-100" id="bairro">
								<option value="">Selecione...</option>
								<option selected>Boa Viagem</option>
							</select>
						</div>
						<div class="col-md-4 mb-3">
							<label for="obra">Selecione a obra:</label>
							<select class="custom-select d-block w-100" id="obra">
								<option value="">Selecione...</option>
								<option selected>UPA 24H</option>
							</select>
						</div>
						<div class="col-md-4 mb-3">
							<label for="obra">Ordernar por:</label>
							<select class="custom-select d-block w-100" id="obra">
								<option selected>Mais denunciadas</option>
								<option>Maior investimento</option>
							</select>
						</div>
						<div class="col-md-12 mb-3">
							<b>Obras denúnciadas</b>
							<hr style="margin-top: 4px;">
							<div class="obrasatuais" style="margin-top: 15px;">
								<div class="fotoobraatual" style="margin-bottom: 10px;">
									<img src="img/cidade/fotodaobra.png" width="100%" height="100%">
								</div>
								<div>
									<p>
										<span style="font-size: 15pt;"><b>UPA 24H</b></span><br>
										<b>Bairro:</b> Boa Viagem<br>
										<b>Ínicio:</b> 00/00/0000<br>
										<b>Status:</b> Em andamento<br>
										<b>Total de denúncias:</b> 3
									</p>
									<a href="#"><i>Clique aqui para ver mais</i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-6 col-md-4">
					<h3>Publicidade</h3>
					<hr>
				</div>
			</div>
		</div>
	</main>

	<!-- Footer -->
	<?php require_once "includes/footer.php" ?>
</body>
</html>