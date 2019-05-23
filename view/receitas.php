<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Receitas: Recife</title>

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
		<div class="container">
			<!-- Exemplo de linha de colunas -->
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Receitas: <a href="cidade.php">Recife</a></h3>
					<hr>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="bairro">Selecione um bairro:</label>
							<select class="custom-select d-block w-100" id="bairro">
								<option value="">Selecione...</option>
								<option selected>Boa Viagem</option>
							</select>
						</div>
						<div class="col-md-6 mb-3">
							<label for="obra">Selecione a obra:</label>
							<select class="custom-select d-block w-100" id="obra">
								<option value="">Selecione...</option>
								<option selected>UPA 24H</option>
							</select>
						</div>
						<div class="col-md-12 mb-3">
							<table id="tabela" border="1" width="100%">
								<th width="21%">Data</th>
								<th width="79%">Acontecimento</th>
								<tr>
									<td>Setembro de 2018</td>
									<td>
										<p>Investimento do governo para o início da obra: R$ 1,7 milhões de reais</p>
									</td>
								</tr>
								<tr>
									<td>Outubro de 2018</td>
									<td>
										<p>Pagamento mensal dos funcionários: R$57,000 reais.</p>
										<p>Contratação de mais 4 funcionários: R$6,200 reais.</p>
										<p>Compra de todos os materiais de construção: R$450,000 reais.</p>
									</td>
								</tr>
								<tr>
									<td>Novembro de 2018</td>
									<td>
										<p>Investimento do governo de mais R$187,000 reais.</p>
									</td>
								</tr>
							</table>
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

	<?php require_once "includes/footer.php" ?>
</body>
</html>