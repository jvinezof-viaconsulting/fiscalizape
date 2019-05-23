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

	<title>FAQ</title>
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
			<?php bc::gerar([ ['texto' => 'FAQ', 'link' => 'faq.php'] ]); ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>FAQ - Perguntas frequentes</h3>
					<hr>
					<h3 style="font-size: 15pt;">- Como eu posso fiscalizar uma obra no FiscalizaPE?</h3>
					<p>Para compartilhar com outros usuários o status de quaisquer obra registrada em nosso banco de dados, você precisa estar <a href="registrar.php">cadastrado</a> e <a href="login.php">logado</a>, feito isso basta procurar a obra no campo de pesquisa e ao lado dela cliclar no botão "Atualizar status da obra". Você será redirecionado(a) à página Fiscalizar Obra. Basta então enviar as fotos e digitar uma breve descrição.</p>
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