<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload(['model'], [ ['Erros', 'Breadcrumb'] ] );

	use \fiscalizape\model\Erros;
	use \fiscalizape\model\Breadcrumb;

	$objerros = new Erros('index', 0);
	$erros = $objerros->getCookie();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>

	<title>Inicio</title>
</head>
<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<!-- INICIO Conteudo -->
	<!-- INICIO Visão geral -->
	<div class="container mt-3">
		<?php Breadcrumb::gerar([]); ?>
		<?php $objerros->gerarMensagem($erros); ?>
		<h1 style="text-align: center; margin-bottom: 20px">Visão Geral dos Gastos</h1>
		<div class="row">
			<div class="col-sm">
				<img class="img-fluid" src="https://png.pngtree.com/element_origin_min_pic/17/08/22/ce74a7009302f42854774fd1c4e49900.jpg" alt="grafico1">
			</div>

			<div class="col-sm">
				<img class="img-fluid" src="https://docs.tibco.com/pub/spotfire_web_player/6.0.0-november-2013/pt-BR/WebHelp/GUID-418B2936-C878-4771-B874-FA8ECAA39941-display.png" alt="grafico2">	
			</div>

			<div class="col-sm">
				<h3>Destaques</h3>
				<p class="lead">Saúde: Gastou R$ 10.000000,00</p>
				<p class="lead">Educação: Recebeu R$ 6.000000,00</p>
				<p class="lead">Segurança: Gastou R$ 2.000000,00</p>
				<p class="lead">Saúde: Recebeu R$ 3.000000,00</p>
			</div>
		</div>
	</div>
	<!-- FIM Visão geral -->
	<hr style="height: 10px; border: 0; box-shadow: 0 10px 10px -10px #8c8b8b inset;">

	<!-- INICIO Relatorios -->
	<div class="container" style="text-align: center; margin-bottom: 20px">
		<div class="row">
			<div class="col-sm">
				<h3>Relatórios</h3>
				<ul class="list-unstyled">
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li>Item 5</li>
				</ul>
				<a href="#">Ver todos...</a>
			</div>

			<div class="col-sm">
				<h3>Receitas</h3>
				<ul class="list-unstyled">
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li>Item 5</li>
				</ul>
				<a href="#">Ver todos...</a>
			</div>

			<div class="col-sm">
				<h3>Dispesas</h3>
				<ul class="list-unstyled">
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li>Item 5</li>
				</ul>
				<a href="#">Ver todos...</a>
			</div>

			<div class="col-sm">
				<h3>Saúde</h3>
				<ul class="list-unstyled">
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li>Item 5</li>
				</ul>
				<a href="#">Ver todos...</a>
			</div>

			<div class="col-sm">
				<h3>Segurança</h3>
				<ul class="list-unstyled">
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li>Item 5</li>
				</ul>
				<a href="#">Ver todos...</a>
			</div>

			<div class="col-sm">
				<h3>Educação</h3>
				<ul class="list-unstyled">
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li>Item 5</li>
				</ul>
				<a href="#">Ver todos...</a>
			</div>
		</div>
	</div>
	<!-- FIM Relatorio -->
	<!-- FIM conteudo -->

	<!-- Footer -->
	<?php require_once "includes/footerIndex.php" ?>
</body>
</html>