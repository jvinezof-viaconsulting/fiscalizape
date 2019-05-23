<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload('model', 'Breadcrumb');
	use \fiscalizape\model\Breadcrumb as bc;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>

	<title>Sobre Nós</title>
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
			<?php bc::gerar([ ['texto' => 'Sobre nós', 'link' => 'sobrenos.php'] ]); ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Sobre nós</h3>
					<hr>
					<p>O <i>FiscalizaPE</i> é um site que tem como objetivo mostrar ao cidadão informações detalhadas e precisas das diversas obras que estão sendo feitas nas cidades Pernambucanas de forma objetiva. <i>O FiscalizaPE</i> permite que o cidadão acompanhe e compartilhe o atual status de uma determinada obra do seu bairro em nosso próprio site, compartilhamento esse que poderá ser visto e comentado por outros usuários.</p>
					<p>Mas de onde vem todos esses dados? O governo oferece através do site <a href="http://seila.com" target="_blank">seila.com</a> todos os dados que precisamos, nós organizamos tudo e categorizamos em nosso banco de dados.</p>
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