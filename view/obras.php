<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload(['persistence', 'util', 'model'], ['DaoObra', 'Data', ['Breadcrumb', 'Erros', 'Avisos'] ]);

	use \fiscalizape\persistence\DaoObra;
	use \fiscalizape\util\Data;
	use \fiscalizape\model\Breadcrumb as bc;
	use \fiscalizape\model\Erros;
	use \fiscalizape\model\Avisos;

	$objErros = new Erros('obras', 0);
	$objAvisos = new Avisos('obras', 0);

	$erros = $objErros->getCookie();
	$avisos = $objAvisos->getCookie();

	// Setando fuso-horario e pegando data atual
	date_default_timezone_set("America/Recife");
	$data = new Data();

	$daoObra = new DaoObra();
	$filtros = [
		'ORDER BY obra_id DESC'
	];
	$obras = $daoObra->listarObras($filtros);
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Configurações -->
    <?php require_once "includes/head.php"; ?>

	<title>Obras</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
</head>
<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<main role="main">
		<div class="container mt-3 mb-5" style="overflow: hidden;">
			<?php bc::gerar([ bc::obras() ]); ?>
			<div class="row">
				<div class="col-9">
					<?php $objErros->gerarMensagem($erros); ?>
					<?php $objAvisos->gerarMensagem($avisos); ?>
					<?php $laco = 0; ?>
					<?php foreach ($obras as $b) { ?>
						<div class="card">
							<!-- Cabeçalho -->
							<div class="card-header bg-primary text-white">
								<h5><strong><?php echo $b->getTitulo(); ?></strong></h5>
							</div>

							<?php if ($b->getImagens() != false): ?>
							<!-- Carrosel -->
							<div id="previewCarrossel<?php echo ++$laco ?>" class="carousel slide carousel-fade" data-ride="carousel">
								<div class="carousel-inner">
								<?php
									$i = 0;
									foreach ($b->getImagens() as $imagem):
								?>
										<?php if ($i++ == 0): ?>
 										<div class="carousel-item active">
											<img class="d-block w-100" src="<?php echo '../imagens/uploads/obras/' . $imagem->getImagem(); ?>" style="height: 250px">
										</div>
										<?php else: ?>
										<div class="carousel-item">
											<img class="d-block w-100" src="<?php echo '../imagens/uploads/obras/' . $imagem->getImagem(); ?>" style="height: 250px">
										</div>
										<?php endif; ?>
								<?php endforeach; ?>
								</div>

								<a class="carousel-control-prev" href="#previewCarrossel<?php echo $laco ?>" role="button" data-slide="prev">
									<span class="carousel-control-prev-icon" aria-hidden="true"></span>
									<span class="sr-only">Anterior</span>
								</a>

								<a class="carousel-control-next" href="#previewCarrossel<?php echo $laco ?>" role="button" data-slide="next">
									<span class="carousel-control-next-icon" aria-hidden="true"></span>
									<span class="sr-only">Próximo</span>
								</a>
							</div>
							<?php endif; ?>

							<div class="card-body">
								<h5 class="card-title">Descrição</h5>
								<p class="card-text"><?php echo mb_strimwidth($b->getDescricao(), 0, 200, "..."); ?></p>

								<div>
									<strong>Inicio previsto:</strong> <?php echo date('d/m/Y', strtotime($b->getDataInicioPrevista())); ?>
								</div>

								<div>
									<strong>Situação:</strong>
									<?php if($b->getSituacao() == ""): ?>
									<span class="text-muted font-italic">Desconhecido</span>
									<?php
										else:
											echo $b->getSituacao();
										endif;
									?>
								</div>

								<div>
									<strong>Cidade:</strong> <?php echo $b->getCidade()->getNome(); ?>
								</div>

								<div class="mb-4">
									<strong>Contribuidor:</strong>
									<a href="perfil.php?p=<?php echo $b->getContribuidor()->getId(); ?>">
										<?php echo $b->getContribuidor()->getNome() . ' ' . $b->getContribuidor()->getSobrenome(); ?>
									</a>
								</div>

								<div class="float-right mt-4">
									<a class="btn btn-primary" href="obra.php?view=<?php echo $b->getKey(); ?>">Ver Obra</a>
								</div>

								<br>
								<!-- Verdades / Mentiras -->
								<div style="margin-top: 14px">
									<span class="badge badge-success mr-2" style="font-family: 'Roboto Mono', monospace; font-size: 15px">
										<strong><?php echo $daoObra->numeroVerdades($b->getVerdades()); ?></strong>V
									</span>

									<span class="badge badge-danger" style="font-family: 'Roboto Mono', monospace; font-size: 15px">
										<strong><?php echo $daoObra->numeroMentiras($b->getVerdades()); ?></strong>F
									</span>
								</div>
							</div>
						</div>
						<!-- Imprimindo tempo da postagem INICIO -->
						<small class="text-muted float-left">
							<?php
								echo $data->intervaloPorExtenso($b->getCriadoEm());
							?>
						</small>
						<br><br>
						<!-- Imprimindo tempo da postagem FIM -->
					<?php } ?>

					<div class="text-right">
						<div class="fixed-bottom mb-4 mr-1">
							<a href="novaobra.php" class="btn btn-primary btn-lg rounded-circle" title="Adicionar Nova Obra"><i class="fas fa-plus"></i></a>
						</div>
					</div>
				</div>

				<div class="col">
					<div id="publicidade">
						<h3>Publicidade</h3>
						<hr>
						<img src="https://fakeimg.pl/200x450/?text=Publicidade">
					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="./js/fixedNavbar.js"></script>
	<!-- Footer -->
	<?php require_once "includes/footer.php" ?>
</body>
</html>