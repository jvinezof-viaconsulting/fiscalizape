<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Gastos: Recife</title>

	<style type="text/css">
		.panel-default {
			border-color: #ddd;
		}
		.panel {
			margin-bottom: 20px;
			background-color: #fff;
			border: 1px solid #ddd;
			border-radius: 4px;
			-webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
			box-shadow: 0 1px 1px rgba(0,0,0,.05);
		}
		.panel-default>.panel-heading {
			color: #333;
			background-color: #f5f5f5;
			border-color: #ddd;
		}
		.panel-heading {
			padding: 10px 15px;
			border-bottom: 1px solid transparent;
			border-top-left-radius: 3px;
			border-top-right-radius: 3px;
		}
		* {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
		}
		.panel-body {
			padding: 15px;
		}
		.pull-right {
			float: right!important;
		}
	</style>
	<!-- Gráficos -->
    <!-- Morris Charts CSS -->
    <link href="/../css/graficos/vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/../css/graficos/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="/../css/graficos/vendor/jquery/jquery.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="/../css/graficos/vendor/raphael/raphael.min.js"></script>
    <script src="/../css/graficos/vendor/morrisjs/morris.min.js"></script>
    <script src="/../css/graficos/data/morris-data.js"></script>
	<!-- -->
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
					<h3>Gastos: <a href="cidade.php">Recife</a></h3>
					<hr>
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-bar-chart-o fa-fw"></i> Total de gastos em obras públicas
							<div class="pull-right">
								
							</div>
						</div>
						<!-- /.panel-heading -->
						<div class="panel-body">
							<div id="morris-area-chart"></div>
						</div>
						<div class="row">
							<div class="col-md-12 mb-3" style="padding-left: 30px; padding-right: 30px;">
								<label for="ano">Ano</label>
								<select class="custom-select d-block w-100" id="ano">
									<option value="">Selecione um ano...</option>
									<option>2018</option>
									<option>2017</option>
									<option>2016</option>
								</select>
							</div>
						</div>
						<!-- /.panel-body -->
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