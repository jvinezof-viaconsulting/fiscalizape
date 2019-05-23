<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload(['persistence', 'model'], ['DaoObra', ['ControleDeAcesso', 'Breadcrumb', 'Erros', 'Avisos'] ]);

	use \fiscalizape\persistence\DaoObra;
	use \fiscalizape\model\ControleDeAcesso;
	use \fiscalizape\model\Breadcrumb as bc;
	use \fiscalizape\model\Erros;
	use \fiscalizape\model\Avisos;

	$acesso = new ControleDeAcesso();
	$objErros = new Erros('obra', 0);
	$objErrosObras= new Erros('obras', 120);
	$objAvisos = new Avisos('obra', 0);

	$key = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$daoObra = new DaoObra();
	$obra = $daoObra->procurarObra($key);

	if ($obra == false) {
		$objErrosObras->adicionarErro("Obra Inválida!");
		header('Location: obras.php?erro=404');
		exit;
	}

	$erros = $objErros->getCookie();
	$avisos = $objAvisos->getCookie();
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>
	<title><?php echo $obra->getTitulo(); ?> - FiscalizaPE</title>

	<style type="text/css">
		.scrolling-wrapper {
			overflow-x: scroll;
			overflow-y: hidden;
			white-space: nowrap;
			-webkit-overflow-scrolling: touch;

			&::-webkit-scrollbar {
				display: none;
				}
		}

		.card {
			display: inline-block;
		}
	</style>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
</head>
<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<main role="main">
		<div class="container mt-3 mb-5">
			<?php bc::gerar([ bc::obras(), bc::obra($obra->getTitulo(), $obra->getKey()) ]) ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<?php $objErros->gerarMensagem($erros); ?>
					<?php $objAvisos->gerarMensagem($avisos); ?>
					<h3>
						<?php
							echo $obra->getTitulo();
							if ($sessao->estaLogado()) {
								if ($obra->getContribuidor()->getId() == $usuario->getId() || $controle->acessoAdministrativo($usuario->getId())) {
									echo '
									<a title="Editar titulo da obra" href="editarobra.php?view='. $obra->getKey() .'&editar=titulo" class="text-muted" style="text-decoration: none; font-size: 12px;">
										Editar <i class="fas fa-edit"></i>
									</a>
									';
								}
							}
						?>
						<div class="float-right">
							<a href="novadenuncia.php?viewObra=<?php echo $obra->getKey(); ?>"><button class="btn btn-danger btn-sm" title="Algo de errado com a obra? faça uma denuncia!">Denunciar</button></a>
						</div>
					</h3>
					<hr>
					<div class="mb-4">
						<div class="mb-1">
							<?php echo $obra->getDescricao(); ?>
						</div>

					<?php
						if ($sessao->estaLogado()) {
							if ($obra->getContribuidor()->getId() == $usuario->getId() || $controle->acessoAdministrativo($usuario->getId())) {
								echo '<a title="Editar descrição da obra" href="editarobra.php?view='. $obra->getKey() .'&editar=descricao" class="text-muted" style="text-decoration: none; font-size: 12px;">Editar <i class="fas fa-edit"></i></a>';
							}
						}
					?>
					</div>

					<?php if (count($obra->getImagens()) > 0): ?>
					<div class="mb-5">
						<div class="scrolling-wrapper">
							<?php foreach ($obra->getImagens() as $i): ?>
								<?php if ($i != false): ?>
								<div class="card">
									<a href="<?php echo '../imagens/uploads/obras/' . $i->getImagem(); ?>" data-toggle="lightbox" data-gallery="imagensObra">
										<img style="height: 200px" src="<?php echo '../imagens/uploads/obras/' . $i->getImagem(); ?>" class="img-fluid" title="Clique para ampliar a imagem">
									</a>
								</div>
								<?php endif; ?>
							<?php endforeach; ?>
  						</div>
  						<?php
  							if ($sessao->estaLogado()) {
								if ($obra->getContribuidor()->getId() == $usuario->getId() || $controle->acessoAdministrativo($usuario->getId())) {
									echo '<a title="Editar imagens da obra" href="editarobra.php?view='. $obra->getKey() .'&editar=imagens" class="text-muted" style="text-decoration: none; font-size: 12px;">Editar <i class="fas fa-edit"></i></a>';
								}
							}
  						?>
					</div>
					<?php else: ?>
					<a href="editarobra.php?view=<?php echo $obra->getKey(); ?>&editar=imagens">Adicionar Imagens</a><br><br>
					<?php endif; ?>

					<div class="mb-3">
						<h5>
							Local:
							<?php
	  							if ($sessao->estaLogado()) {
									if ($obra->getContribuidor()->getId() == $usuario->getId() || $controle->acessoAdministrativo($usuario->getId())) {
										echo '<a title="Editar local da obra" href="editarobra.php?view='. $obra->getKey() .'&editar=local" class="text-muted" style="text-decoration: none; font-size: 12px;">Editar <i class="fas fa-edit"></i></a>';
									}
								}
  							?>
						</h5>
						<p class="text-secondary">
							<strong>
								<?php
									echo $obra->getRua() . ', ' . $obra->getBairro() . ' - ' . $obra->getCidade()->getNome() . '.';

									if ($obra->getCep() != null) {
										echo 'Cep: ' . $obra->getCep();
									}
								?>
							</strong>
						</p>
						<div class="embed-responsive">
							<div class="mapouter"><div class="gmap_canvas"><iframe id="mapa" width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $obra->getRua() . ',%20' . $obra->getBairro() . '%20-%20' . $obra->getCidade()->getNome(); ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.pureblack.de"></a></div><style>.mapouter{text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style>Google Maps by <a href="https://www.embedgooglemap.net" rel="nofollow" target="_blank">Embedgooglemap.net</a></div>
						</div>
					</div>

					<div class="mb-3">
						<h5>
							Informações Oficiais:
							<?php
	  							if ($sessao->estaLogado()) {
									if ($obra->getContribuidor()->getId() == $usuario->getId() || $controle->acessoAdministrativo($usuario->getId())) {
										echo '<a title="Editar informações oficiais da obra" href="editarobra.php?view='. $obra->getKey() .'&editar=informacoesOficiais" class="text-muted" style="text-decoration: none; font-size: 12px;">Editar <i class="fas fa-edit"></i></a>';
									}
								}
  							?>
						</h5>
						<p>
							<div class="mb-1">
								<strong>Cidade:</strong> <a href="./cidade.php?v=<?php echo $obra->getCidade()->getId(); ?>"><?php echo $obra->getCidade()->getNome(); ?></a>
							</div>

							<div class="mb-1">
								<strong>Data de Inicio Prevista:</strong> <?php echo date('d/m/Y', strtotime($obra->getDataInicioPrevista())); ?>
							</div>

							<div class="mb-1">
								<strong>Data de Conclusão Prevista:</strong> <?php echo date('d/m/Y', strtotime($obra->getDataFinalPrevista())); ?>
							</div>

							<div class="mb-1">
								<strong>Verba inicial:</strong> <?php echo 'R$ ' . number_format($obra->getOrcamentoPrevisto(), 2, ',', '.'); ?>
							</div>
						</p>
					</div>

					<div class="mb-5">
						<h5>
							Informações Extras:
							<?php
	  							if ($sessao->estaLogado()) {
									if ($obra->getContribuidor()->getId() == $usuario->getId() || $controle->acessoAdministrativo($usuario->getId())) {
										echo '<a title="Editar informações extras da obra" href="editarobra.php?view='. $obra->getKey() .'&editar=informacoesExtras" class="text-muted" style="text-decoration: none; font-size: 12px;">Editar <i class="fas fa-edit"></i></a>';
									}
								}
	  						?>
						</h5>
						<p>
							<div class="mb-1">
								<strong>Data de Inicio:</strong>
								<?php
									if ($obra->getDataInicio() == null) {
										echo "<span class=\"text-muted\">Desconhecido</span>";
									} else {
										echo date('d/m/Y', strtotime($obra->getDataInicio()));
									}
								?>
							</div>

							<div class="mb-1">
								<strong>Data de Final:</strong>
								<?php
									if ($obra->getDataInicio() == null) {
										echo "<span class=\"text-muted\">Desconhecido</span>";
									} else {
										echo date('d/m/Y', strtotime($obra->getDataFinal()));
									}
								?>
							</div>

							<div class="mb-1">
								<strong>Orgão Responsável:</strong>
								<?php
									if ($obra->getOrgaoResponsavel() == null) {
										echo "<span class=\"text-muted\">Desconhecido</span>";
									} else {
										echo $obra->getOrgaoResponsavel();
									}
								?>
							</div>

							<div class="mb-1">
								<strong>Dinheiro gasto:</strong>
								<?php
									if ($obra->getDinheiroGasto() == null) {
										echo "<span class=\"text-muted\">Desconhecido</span>";
									} else {
										echo number_format($obra->getDinheiroGasto(), 2, ',', '.');
									}
								?>
							</div>

							<div class="mb-1">
								<strong>Situação Atual:</strong>
								<?php
									if ($obra->getSituacao() == null) {
										echo "<span class=\"text-muted\">Desconhecido</span>";
									} else {
										echo $obra->getSituacao();
									}
								?>
							</div>
						</p>
					</div>
					<br>

					<div>
						<p>
							<span class="text-muted"><?php echo date('d/m/Y', strtotime($obra->getCriadoEm())); ?></span>
							|
							<a href="perfil.php?p=<?php echo $obra->getContribuidor()->getId(); ?>">
								<?php echo $obra->getContribuidor()->getNome() . ' ' . $obra->getContribuidor()->getSobrenome(); ?>
							</a>
							|
							<?php
								// Definindo classe, onclick e title
								$classe = 'badge-';
								if ($sessao->estaLogado()) {
									$titleVerdade = 'Assinalar esta obra como uma verdade';
									$titleMentira = 'Assinalar esta obra como uma mentira';
									$onclickVerdade = 'marcarVerdade(\'' . md5($obra->getId()) . '\');mudarTitulo(this);return(false);';
									$onclickMentira = 'marcarMentira(\'' . md5($obra->getId()) . '\');mudarTitulo(this);return(false);';
									if ($daoObra->jaVotei($usuario->getId(), $obra->getVerdades()) != false) {
										$voto = $daoObra->jaVotei($usuario->getId(), $obra->getVerdades());
										if ($voto->getVoto() == "0") {
											$classeMentira = $classe . 'danger';
											$classeVerdade = $classe . 'secondary';
										} else {
											$classeVerdade = $classe . 'success';
											$classeMentira = $classe . 'secondary';
										}
									} else {
										$classeVerdade = $classe . 'secondary';
										$classeMentira = $classe . 'secondary';
									}
								} else {
									$classeVerdade = $classe . 'success';
									$classeMentira = $classe . 'danger';
									$onclickVerdade = 'return(false);';
									$onclickMentira = 'return(false);';
									$titleVerdade = 'Faça o login para assinalar esta obra como uma verdade';
									$titleMentira = 'Faça o login para assinalar esta obra como uma mentira';
								}
							?>
							<a id="aVerdade" rel="verdade" href="" style="text-decoration: none;" onclick="<?php echo $onclickVerdade ?>" title="<?php echo $titleVerdade; ?>">
								<span id="verdade" class="badge <?php echo $classeVerdade ?>" style="font-family: 'Roboto Mono', monospace; font-size: 15px">
									<strong id="numVerdades"><?php echo $daoObra->numeroVerdades($obra->getVerdades());; ?></strong>V
								</span>
							</a>

							<a id="aMentira" rel="mentira" href="" style="text-decoration: none;" onclick="<?php echo $onclickMentira ?>" title="<?php echo $titleMentira; ?>">
								<span id="mentira" class="badge <?php echo $classeMentira ?>" style="font-family: 'Roboto Mono', monospace; font-size: 15px">
									<strong id="numMentiras"><?php echo $daoObra->numeroMentiras($obra->getVerdades()); ?></strong>F
								</span>
							</a>
						</p>
					</div>

					<div class="text-right">
						<div class="fixed-bottom mb-4 mr-2">
							<?php
								if ($sessao->estaLogado()) {
									if ($obra->getContribuidor()->getId() == $usuario->getId() || $controle->acessoAdministrativo($usuario->getId())) {
										echo '<a href="editarobra.php?view='. $obra->getKey() .'&editar=editar" title="Editar está obra" class="btn btn-info rounded-circle mb-1" style="margin-right: 2px;"><i class="fas fa-edit"></i></a>';
									}
								}
							?>
							<br>
							<a href="./novadenuncia.php?viewObra=<?php echo $obra->getKey(); ?>" title="Fazer uma denúncia" class="btn btn-danger btn-lg rounded-circle"><i class="fas fa-exclamation-circle"></i></a>
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

	<?php if ($sessao->estaLogado()): ?>
	<!-- Sistema de votos (incluindo ajax) -->
	<script src="js/zepto.min.js"></script>
	<script src="js/sistemaVotos.js"></script>
	<?php endif; ?>

	<!-- Footer -->
	<?php require_once "includes/footer.php" ?>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>

	<script type="text/javascript">
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox();
		});

		var navObras = document.getElementById("navObras");
		navObras.classList.add("active");
	</script>
</body>
</html>