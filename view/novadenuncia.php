<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload(['persistence', 'model'], [ ['DaoCidade', 'DaoObra'], ['ControleDeAcesso', 'Breadcrumb', 'Erros', 'Avisos']]);

	use \fiscalizape\persistence\DaoCidade;
	use \fiscalizape\persistence\DaoObra;
	use \fiscalizape\model\ControleDeAcesso;
	use \fiscalizape\model\Breadcrumb as bc;
	use \fiscalizape\model\Avisos;
	use \fiscalizape\model\Erros;

	$keyObra = filter_input(INPUT_GET, 'viewObra', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$daoCidade = new DaoCidade();
	$daoObra = new DaoObra();
	$controle = new ControleDeAcesso();
	$objErros = new Erros('novadenuncia', 0);
	$objAvisos = new Avisos('novadenuncia', 0);

	// verificando acesso permitido
	$controle->permitirUsuario('novadenuncia.php?viewObra='.$keyObra);

	$cidades = $daoCidade->listarCidades();
	$obra = $daoObra->procurarObra($keyObra);
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>
	<title>Nova Denuncia - FiscalizaPE</title>
</head>
<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<main>
		<div class="container mt-3 mb-5">
			<?php bc::gerar([ bc::denuncias(), bc::obra($obra->getTitulo(), $obra->getKey()), bc::novaDenunciaObra() ]); ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Nova Denuncia</h3>
					<hr>
					<small class="text-muted">Campos marcados com <span class="text-danger">*</span> (asteristico) são obrigatórios</small>

					<form action="incluirDenuncia.php" method="post">
						<div class="mb-3">
							<label for="titulo">Título<span class="text-danger">*</span></label>
							<input type="text" name="titulo" class="form-control" required minlength="4" maxlength="60" placeholder="Digite um título para indentificar sua denúncia">
							<small class="text-muted">Digite um título de no maxímo 60 letras.</small>
						</div>	

						<div class="mb-3">
							<label for="descricao">Denúncia<span class="text-danger">*</span></label>
							<textarea id="editor" name="denuncia"></textarea>
							<small class="text-muted">Dígite uma descrição de no maxímo 3000 letras.</small>
						</div>

						<div class="mb-4">
							<div class="form-group row">
								<label for="dataProblema" class="col-sm-2 col-form-label">Data do Problema<span class="text-danger">*</span></label>
								<div class="col-sm-10 mt-2">
									<input type="date" name="dataProblema" class="form-control">
								</div>
							</div>
						</div>

						<div class="text-center">
							<div class="btn-group d-flex">
								<button class="btn btn-danger rounded mr-2">Cancelar</button>
								<input type="submit" class="btn btn-success rounded w-100" value="Denúnciar" name="denunciar">
							</div>
						</div>
					</form>
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

	<!-- Jodit -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>

	<script>
		var navDenuncias = document.getElementById("navDenuncias");
		navDenuncias.classList.add("active");
	</script>

	<!-- Editor de texto Configurações -->
	<script type="text/javascript">
		var imagens;

		var editor = new Jodit('#editor', {
			buttons: ['fullsize', '|', 'paragraph', 'fontsize', 'align', 'font', '|', 'bold', 'strikethrough', 'underline', 'italic', '|', 'outdent', 'indent', '|', 'undo', 'redo', '|', 'source'],
			buttonsSM: ['fullsize', '|', 'paragraph', 'font', 'bold'],
			buttonsMD: ['fullsize', '|', 'paragraph', 'fontsize', 'align', 'font', '|', 'bold', 'strikethrough', 'underline', 'italic', '|', 'outdent', 'indent', '|', 'undo', 'redo', '|', 'source'],
			buttonsXS: ['fullsize', 'bold', 'fullsize'],
			height: 400,
			placeholder: "Digite sua denúncia para a obra, não utilize imagens nesse momento, tente descrever de forma organizada quais problemas estão ocorrendo.",
		});

		editor.events.on('paste', function () {
			imagens = document.getElementsByTagName("img");
			imagens[1].parentNode.removeChild(imagens[1]);
		});

		editor.events.on('afterInsertImage', function (image) {
			image.parentNode.removeChild(image);
		});
	</script>
</body>
</html>