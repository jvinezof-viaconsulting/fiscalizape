<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php
		require_once "includes/head.php";

		$busca = $_GET["q"];
		if ($busca == null) {
			header("location: index.php");
		}
	?>
	<title><?php echo $busca ?> - Pesquisa FiscalizaPE</title>
</head>

<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<main role="main">
		<div class="container">
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Resultados da busca</h3>
					<hr>
					<div id="index">
						<p class="lead">
							<div class="input-wrap">
								<form action="search.php" class="form-box d-flex justify-content-between" method="GET" onsubmit="return q.value!=''">
									<input type="text" placeholder="Procure por cidades, bairros ou obras..." maxlength="256" class="form-control" name="q" value="<?php echo $busca ?>">
									<button type="submit" class="mybtn" id="indexbtnsearch">Buscar</button>
								</form>
							</div>
						</p>
					</div>
					...
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