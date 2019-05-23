<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload(['persistence', 'model'], [ ['DaoCidade', 'DaoObra'], 'Breadcrumb' ]);

	use \fiscalizape\persistence\DaoCidade;
	use \fiscalizape\persistence\DaoObra;
	use \fiscalizape\model\Breadcrumb as bc;

	$daoCidade = new DaoCidade();
	$daoObra = new DaoObra();

	$id = filter_input(INPUT_GET, 'v', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$cidade = $daoCidade->procurarCidade($id);

	if ($cidade == false) {
		header('Location: index.php?erro=404');
		exit;
	} else if ($cidade->getNome() == NULL || $cidade->getEstado() == NULL || $cidade->getPrefeito() == NULL) {
		header('Location: index.php?erro=404');
		exit;
	}

	$filtros = [
		['AND md5(obra_id_cidade) = ?', $id],
		'ORDER BY obra_id DESC'
	];
	$obras = $daoObra->listarObras($filtros);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - <?php echo $cidade->getNome(); ?></title>

	<style>

		.fotoobraatual {
			width: 100%;
			height: 300px;
			display: block;
			margin-left: auto;
			margin-right: auto;
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
			<?php bc::gerar([ bc::cidades(), bc::cidade($cidade->getNome(), $id) ]); ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Cidade: <?php echo $cidade->getNome(); ?></h3>
					<hr>
					<div class="row">
						<div class="col-sm-4">
							<div class="infoleft">
									<b>Informações</b>
									<hr style="margin-top: 4px;">
									<span style="font-size: 10pt;"><b>Área:</b> <?php echo $cidade->getArea(); ?> km²</span><br>
									<span style="font-size: 10pt;"><b>População:</b> <?php echo $cidade->getPopulacao(); ?></span><br>
									<span style="font-size: 10pt;"><b>Prefeito:</b> <a href="https://www.google.com.br/search?q=<?php echo str_replace(' ', '+', $cidade->getPrefeito()) . '+prefeito+do+' . str_replace(' ', '+', $cidade->getNome()) ; ?>" target="_blank"><?php echo $cidade->getPrefeito(); ?></a></span><br>
									<br>
									<span style="font-size: 10pt;"><b>Obras em andamento:</b> <?php echo $daoCidade->getObrasEmAndamento($id); ?></span><br>
									<span style="font-size: 10pt;"><b>Obras paradas:</b> <?php echo $daoCidade->getObrasParadas($id); ?></span><br>
									<span style="font-size: 10pt;"><b>Total de denúncias:</b> 13 <a href="denuncias">Ver</a></span><br>
									<span style="font-size: 10pt;"><b>Receitas:</b> <a href="#">Ver</a></span><br>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="inforight">
								<b>Obras atuais</b>
								<hr style="margin-top: 4px;">
								<?php if ($obras != false) { ?>
									<?php foreach ($obras as $obra): ?>
									<div class="obrasatuais" style="margin-top: 15px;">
										<div class="fotoobraatual text-center" style="margin-bottom: 10px;">
											<img width="100%" height="100%"
												src="<?php
													if ($obra->getImagens()[0] == null) {
														echo '../imagens/sistema/util/noimage.png';
													} else {
														echo '../imagens/uploads/obras/' . $obra->getImagens()[0]->getImagem();
													}
												?>">
										</div>
										<div>
											<p>
												<span style="font-size: 15pt;"><b><?php echo $obra->getTitulo(); ?></b></span><br>
												<b>Bairro:</b> <?php echo $obra->getBairro(); ?><br>
												<b>Ínicio:</b> <?php echo date('d/m/Y', strtotime($obra->getDataInicio())); ?> <br>
												<b>Status:</b> <?php echo ($obra->getSituacao() != null) ? $obra->getSituacao() : '<span class="text-muted">Desconhecido</span>'; ?>
											</p>
											<a href="./obra.php?view=<?php echo $obra->getKey(); ?>"><i>Clique aqui para ver mais</i></a>
										</div>
									</div>
									<?php endforeach; ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<h3>Publicidade</h3>
					<hr>
				</div>
			</div>
		</div>
	</main>

	<?php require_once "includes/footer.php" ?>
</body>
</html>