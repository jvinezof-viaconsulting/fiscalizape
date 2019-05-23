<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Fiscalizar Obra</title>

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
					<form method="post">
						<h3>Fazer denúncia</h3>
						<hr>
						Logo abaixo você pode enviar imagens da obra UPA 24H do bairro Boa Viagem da cidade Jaboatão dos Guararapes e escrever uma descrição.<br><br>
						Selecione uma ou mais imagens do atual estado da obra UPA 24H para enviar:<br>
						<div class="upload" style="padding: 8px; margin-top: 10px; margin-bottom: 20px; background-color: #ececec;">
							<input type="file" />
						</div>
						A obra está em andamento?<br>
						<input type="radio" name="obraandamento" id="obraAsim">
						<label for="obraAsim">Sim, a obra está em andamento.</label><br>

						<input type="radio" name="obraandamento" id="obraAnao">
						<label for="obraAnao">Não, a obra está parada.</label><br><br>
						<div class="form-group">
						  <label for="comment">Descrição:</label>
						  <textarea class="form-control" rows="5" id="comment" name="descricaodenunciaobra" placeholder="Elogie, reclame, ou digite a sua opinião..."></textarea>
						</div>
						<input type="submit" class="btn" value="Enviar denúncia!">
					</form>
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