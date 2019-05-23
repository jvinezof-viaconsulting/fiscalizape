<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload(['persistence', 'model'], [ ['DaoObra', 'DaoCidade', 'Sessao'], ['ControleDeAcesso', 'Breadcrumb', 'Erros', 'Avisos'] ]);

	use \fiscalizape\persistence\DaoObra;
	use \fiscalizape\model\ControleDeAcesso;
	use \fiscalizape\persistence\DaoCidade;
	use \fiscalizape\model\Breadcrumb as bc;
	use \fiscalizape\persistence\Sessao;
	use \fiscalizape\model\Erros;
	use \fiscalizape\model\Avisos;

	$controle = new ControleDeAcesso();
	$daoCidade = new DaoCidade();
	$daoObra = new DaoObra();
	$sessao = new Sessao();
	$objErros = new Erros('editarobra', 0);
	$objAvisos = new Avisos('editarobra', 0);
	$objErrosObras = new Erros('obras', 120);

	$usuario = $sessao->getSessaoUsuario();

	$key = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$editar = filter_input(INPUT_GET, 'editar', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	$objErrosObra = new Erros('obra', 60);

	$cidades = $daoCidade->listarCidades();
	$obra = $daoObra->procurarObra($key);

	$edicoes = ['titulo', 'descricao', 'imagens', 'local', 'informacoesOficiais', 'informacoesExtras'];
	if (!in_array($editar, $edicoes)) {
		$editar = 'editar';
	}

	if ($obra == false) {
		$objErrosObras->adicionarErro("Obra Inválida!");
		header('Location: obras.php?erro=404');
		exit;
	}

	$focus = ($editar != 'editar') ? $editar : 'titulo';
	$titulo = ($editar != 'editar') ? $editar : '';
	if (empty($titulo)) {
		$titulo = 'Editar tudo: ' . $obra->getTitulo();
	} else {
		$titulo = 'Editar ' . $titulo . ': ' . $obra->getTitulo();
	}

	$controle->permitirUsuario("editarobra.php?view=" . $key . "&editar=" . $editar . '#' . $focus);
	if ( !( $controle->acessoNivelA($usuario->getId()) || $controle->acessoNivelB($usuario->getId()) ) && $usuario->getId() != $obra->getContribuidor()->getId() ) {
		$objErrosObra->adicionarErro("Você não tem permissão para editar esta obra.");
		header('Location: obra.php?view=' . $key);
		exit;
	}

	$query = $obra->getRua() . ", " . $obra->getBairro() . ", " . $obra->getCidade()->getNome() . " - Pernambuco";

	$imagensAntigas = '';

	$erros = $objErros->getCookie();
	$avisos = $objAvisos->getCookie();

	/*
	 * Definindo variavies
	*/
	$inputTitulo = (isset($_COOKIE['form']['titulo'])) ? filter_var($_COOKIE['form']['titulo'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getTitulo();
	$descricao = (isset($_COOKIE['form']['descricao'])) ? filter_var($_COOKIE['form']['descricao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDescricao();
	$cidadeId = (isset($_COOKIE['form']['cidadeId'])) ? filter_var($_COOKIE['form']['cidadeId'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getCidade()->getId();
	$cidadeNome = (isset($_COOKIE['form']['cidadeNome'])) ? filter_var($_COOKIE['form']['cidadeNome'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getCidade()->getNome();
	$verbaInicial = (isset($_COOKIE['form']['verbaInicial'])) ? filter_var($_COOKIE['form']['verbaInicial'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getOrcamentoPrevisto();
	$dataInicioPrevista = (isset($_COOKIE['form']['dataInicioPrevista'])) ? filter_var($_COOKIE['form']['dataInicioPrevista'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataInicioPrevista();
	$dataEncerramentoPrevista = (isset($_COOKIE['form']['dataEncerramentoPrevista'])) ? filter_var($_COOKIE['form']['dataEncerramentoPrevista'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataFinalPrevista();
	$dataIncioReal = (isset($_COOKIE['form']['dataIncioReal'])) ? filter_var($_COOKIE['form']['dataIncioReal'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataInicio();
	$dataEncerramentoReal = (isset($_COOKIE['form']['dataEncerramentoReal'])) ? filter_var($_COOKIE['form']['dataEncerramentoReal'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataFinal();
	$orgaoResponsavel = (isset($_COOKIE['form']['orgaoResponsavel'])) ? filter_var($_COOKIE['form']['orgaoResponsavel'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getOrgaoResponsavel();
	$verbaUtilizada = (isset($_COOKIE['form']['verbaUtilizada'])) ? filter_var($_COOKIE['form']['verbaUtilizada'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDinheiroGasto();
	$situacao = (isset($_COOKIE['form']['situacao'])) ? filter_var($_COOKIE['form']['situacao'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getSituacao();
	$rua = (isset($_COOKIE['form']['rua'])) ? filter_var($_COOKIE['form']['rua'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getRua();
	$bairro = (isset($_COOKIE['form']['bairro'])) ? filter_var($_COOKIE['form']['bairro'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getBairro();
	$cep = (isset($_COOKIE['form']['cep'])) ? filter_var($_COOKIE['form']['cep'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getCep();

	/*
	 * Apagando os cookies
	*/
	$path = '/fiscalizape/view/editarobra.php';
	setcookie('form[titulo]', '', time()-1, $path);
	setcookie('form[descricao]', '', time()-1, $path);
	setcookie('form[cidadeId]', '', time()-1, $path);
	setcookie('form[cidadeNome]', '', time()-1, $path);
	setcookie('form[verbaInicial]', '', time()-1, $path);
	setcookie('form[dataInicioPrevista]', '', time()-1, $path);
	setcookie('form[dataEncerramentoPrevista]', '', time()-1, $path);
	setcookie('form[dataIncioReal]', '', time()-1, $path);
	setcookie('form[dataEncerramentoReal]', '', time()-1, $path);
	setcookie('form[orgaoResponsavel]', '', time()-1, $path);
	setcookie('form[verbaUtilizada]', '', time()-1, $path);
	setcookie('form[situacao]', '', time()-1, $path);
	setcookie('form[rua]', '', time()-1, $path);
	setcookie('form[bairro]', '', time()-1, $path);
	setcookie('form[cep]', '', time()-1, $path);
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>
	<title><?php echo $titulo; ?></title>

	<style type="text/css">
		.scrolling-wrapper {
			height: 200px;
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

		.card img {
			width: 200px;
			height: 200px;
		}
	</style>

	<!-- Radio Button Style -->
	<link rel="stylesheet" type="text/css" href="css/radio.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
</head>
<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<a href="#<?php echo $focus; ?>" class="hidden" id="ancora"></a>
	<main role="main">
		<div class="container mt-3 mb-5">
			<?php bc::gerar([ bc::obras(), bc::obra($obra->getTitulo(), $obra->getKey()), bc::editarObra() ]); ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<h3><?php echo $titulo ?></h3>
					<?php $objErros->gerarMensagem($erros); ?>
					<?php $objAvisos->gerarMensagem($avisos); ?>
					<form action="../controller/editarObra.php" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
						<input type="hidden" name="view" value="<?php echo $key; ?>">
						<input type="hidden" name="editar" value="<?php echo $editar; ?>">

						<?php if ($editar == 'titulo' || $editar == 'editar'): ?>
						<div class="mb-3">
							<label for="titulo">Titulo da Obra</label>
							<input id="titulo" type="text" name="titulo" class="form-control" required="true" placeholder="ex: Operação tampa buraco" value="<?php echo $inputTitulo; ?>">
							<small class="form-text text-muted">Digite um titulo descritivo, porém não muito grande.</small>
						</div>
						<?php endif; ?>

						<?php if ($editar == 'descricao' || $editar == 'editar'): ?>
						<div class="mb-3">
							<label for="descricao">Descrição</label> <br>
							<textarea id="editor" name="descricao" required><?php echo $descricao; ?></textarea>
							<small class="form-text text-muted">obs: Você pode adicionar imagens em seguida.</small>
						</div>
						<?php endif; ?>

						<?php if ($editar == 'imagens' || $editar == 'editar') { ?>
						<div class="mb-3" id="imagens">
							<div class="scrolling-wrapper" id="imagensDiv">
								<?php if (count($obra->getImagens()) > 0) { ?>
									<?php foreach ($obra->getImagens() as $imagem): ?>
										<?php $imagensAntigas .= '&' . $imagem->getImagem(); ?>
										<div class="card imagem-pre-upada">
											<a href="<?php echo '../imagens/uploads/obras/' . $imagem->getImagem(); ?>" data-toggle="lightbox" data-gallery="imagensObra">
												<img src="<?php echo '../imagens/uploads/obras/' . $imagem->getImagem(); ?>" class="img-fluid img-para-excluir" title="Clique para ampliar a imagem">
											</a>

											<input class="form-check-input" type="checkbox" value="<?php echo $imagem->getImagem(); ?>" id="checkApagarImagem" onclick="apagarImagem(this)" name="imagensApagadas[]">
										</div>
									<?php endforeach; ?>
								<?php } ?>
							</div>

							<div class="card">
								<input type="hidden" name="novasImagens" id="novasImagens">
								<label class="custom-file d-inline mb-2" id="adicionar-nova-imagem">
									<input type="file" id="imagensObra" name="imagensObra[]" class="custom-file-input" hidden="true" multiple="true" accept="image/png, image/jpeg, image/jpg" onchange="readURL(this);">
									<span class="custom-file-control">
										<figure class="figure ">
											<img style="width: 150px;height: 150px;" class="rounded figure-img" src="../imagens/sistema/util/mais.png" title="Adicionar imagem a obra">
											<figcaption class="figure-caption text-center">Adicionar nova imagem</figcaption>
										</figure>
									</span>
								</label>
							</div>
						</div>
						<?php } ?>

						<?php if ($editar == 'informacoesOficiais' || $editar == 'editar'): ?>
						<div class="mb-3">
							<h5>Informações Oficiais</h5>

							<div class="row">
								<div class="col mb-2">
									<label for="cidade">Cidade</label>
									<select class="form-control" id="cidadeId" name="cidadeId" required onchange="atualizarCidade()">
										<option selected hidden>Selecione a cidade da obra</option>
										<?php foreach ($cidades as $cidade) { ?>
										<option <?php  if ($cidadeId == md5($cidade->getId())) echo 'selected'; ?> value="<?php echo $cidade->getId(); ?>"><?php echo $cidade->getNome(); ?></option>
										<?php } ?>
										<option value="-1">Não tem minha cidade</option>
									</select>
								</div>

								<div class="col">
									<label for="verbaInicial">Verba Inicial</label>
									<div class="input-group">
										<div class="input-group-prepend">
											 <span class="input-group-text">R$</span>
										</div>
										<input type="text" name="verbaInicial" value="<?php echo number_format($verbaInicial, 2, ',', '.'); ?>" minlength="0" maxlength="12" class="form-control" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<label for="dataInicioPrevista">Data Prevista para Inicio</label>
									<input type="date" name="dataInicioPrevista" id="dataInicioPrevista" class="form-control" value="<?php echo $dataInicioPrevista; ?>" required>
								</div>

								<div class="col">
									<label for="dataEncerramentoPrevista">Data Previsata para Encerramento</label>
									<input type="date" name="dataEncerramentoPrevista" id="dataEncerramentoPrevista" class="form-control" value="<?php echo $dataEncerramentoPrevista; ?>" required>
								</div>
							</div>
						</div>
						<?php endif; ?>

						<?php if ($editar == 'informacoesExtras' || $editar == 'editar'): ?>
						<div class="mb-3">
							<h5>Informações Opcionais</h5>
							<div id="informacoes-opcionais">
								<div class="mb-2">
									<div class="row">
										<div class="col">
											<label for="dataIncioReal">Data de Inicio <small class="text-muted">(data em que as obras de fato começaram)</small></label>
											<input type="date" name="dataIncioReal" class="form-control" value="<?php echo $dataIncioReal; ?>">
										</div>

										<div class="col">
											<label for="dataEncerramentoReal">Data de Encerramento <small class="text-muted">(data em que as obras de fato se encerraram)</small></label>
											<input type="date" name="dataEncerramentoReal" class="form-control" value="<?php echo $dataEncerramentoReal; ?>">
										</div>
									</div>
								</div>

								<div class="mb-2">
									<div class="row">
										<div class="col">
											<label for="orgaoResponsavel">Orgão Responsavel</label>
											<input type="text" name="orgaoResponsavel" minlength="0" maxlength="50" class="form-control" value="<?php echo $orgaoResponsavel; ?>">
										</div>

										<div class="col">
											<label for="verbaUtilizada">Verba Utilizada</label>
											<div class="input-group">
												<div class="input-group-prepend">
													 <span class="input-group-text">R$</span>
												</div>
												<input type="text" name="verbaUtilizada" value="<?php echo number_format($verbaUtilizada, 2, ',', '.'); ?>" class="form-control" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
											</div>
										</div>
									</div>
								</div>

								<div class="mb-2">
									<label for="estadoAtual">Situação Atual da Obra</label>

									<label class="radio-container">Ainda não começou
										<input type="radio" name="estadoAtual" value="Não Iniciada" <?php if ($situacao == 'Não Iniciada') echo 'checked' ?>>
										<span class="radio-checkmark"></span>
									</label>

									<label class="radio-container">Começou, mas está parada
										<input type="radio" name="estadoAtual" value="Parada" <?php if ($situacao == 'Parada') echo 'checked'; ?>>
										<span class="radio-checkmark"></span>
									</label>

									<label class="radio-container">Começou, em andamento
										<input type="radio" name="estadoAtual" value="Em Andamento" <?php if ($situacao == 'Em Andamento') echo 'checked'; ?>>
										<span class="radio-checkmark"></span>
									</label>

									<label class="radio-container">Obra Concluida
										<input type="radio" name="estadoAtual" value="Finalizada" <?php if ($situacao == 'Finalizada') echo 'checked'; ?>>
										<span class="radio-checkmark"></span>
									</label>
								</div>
							</div>
						</div>
						<?php endif; ?>

						<?php if ($editar == 'local' || $editar == 'editar'): ?>
						<div class="mb-3">
							<h5>Localização:</h5>

							<div id="divEndereco" hidden="true">
								<label for="endereco">
									Endereço
									<a href="" onclick="mostrarEsconderEnd();return(false)" style="text-decoration: none;"><small class="text-muted">prefiro digitar o cep</small></a>
								</label>

								<div class="row mb-3">
									<div class="col">
										<input type="text" name="rua" id="rua" class="form-control mr-2" placeholder="Nome da rua" value="<?php echo $rua; ?>" required>
									</div>

									<div class="col">
										<input type="text" name="bairro" id="bairro" class="form-control mr-2" placeholder="Nome do bairro" value="<?php echo $bairro; ?>" required>
									</div>

									<div class="col">
										<input class="form-control" type="text" id="cidade" name="cidadeNome" value="<?php echo $cidadeNome ?>" readonly>
									</div>

									<div class="col-1">
										<a href="" class="btn btn-success" id="btn-localizacao" onclick="pesquisarNoMapa(false);return(false);"><i class="fas fa-search"></i></a>
									</div>
								</div>
							</div>

							<div id="divCep" class="mb-3">
								<label for="cep">
									Cep
									<a href="" onclick="mostrarEsconderEnd();return(false);" style="text-decoration: none;"><small class="text-muted">não sei o cep</small></a>
								</label>

								<div class="input-group" style="width: 40%">
									<input type="text" name="cep" id="cep" class="form-control mr-2" value="<?php echo $obra->getCep(); ?>">

									<a href="" class="btn btn-success" id="btn-localizacao" onclick="pesquisarNoMapa(true);return(false);"><i class="fas fa-search"></i></a>
								</div>
								<small class="text-muted" id="avisoInfo"></small>
							</div>

							<div class="embed-responsive">
								<div class="mapouter"><div class="gmap_canvas"><iframe id="mapa" width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=<?php echo $query ?>&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.pureblack.de"></a></div><style>.mapouter{text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style>Google Maps by <a href="https://www.embedgooglemap.net" rel="nofollow" target="_blank">Embedgooglemap.net</a></div>
							</div>
						</div>
						<?php endif; ?>

						<a href="obra.php?view=<?php echo $obra->getKey(); ?>" class="btn btn-danger">Cancelar <i class="fas fa-times"></i></a>

						<button type="submit" class="btn btn-success">Salvar <i class="fas fa-check"></i></button>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>

	<script type="text/javascript">
		$(document).on('click', '[data-toggle="lightbox"]', function(event) {
			event.preventDefault();
			$(this).ekkoLightbox();
		});
	</script>

	<script>
		function inputFocus() {
			var focus = "<?php echo $focus; ?>";
			var inputFocus = document.getElementById(focus);
			if (inputFocus.tagName == 'DIV') {
				document.getElementById('ancora').click();
			}
			var inputValue = inputFocus.value;
			inputFocus.value = '';
			inputFocus.focus();
			inputFocus.value = inputValue;
		}

		window.onload = inputFocus();
	</script>

	<!-- Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido. -->
	<script src="js/invalid_form.js"></script>
	<!-- Mascara Moeda -->
	<script src="js/mascaraMoeda.js"></script>
	<!-- Pega dados do cep IMPORTANTE: PRECISA VIR ANTES DE pesquisarNoMapa.js -->
	<script src="js/cepToString.js"></script>
	<!-- Função que pesquisa no mapa -->
	<script src="js/pesquisarNoMapa.js"></script>
	<!-- Função que mostra/esconde a div do endereço -->
	<script src="js/mostrarEsconderEnd.js"></script>
	<!-- Atualizando nome da cidade na pesquisa com a cidade do select -->
	<script src="js/atualizarNomeCidade.js"></script>
		<!-- preview da imagem upada -->
	<script src="js/editarObraFotoPreview.js"></script>

	<!-- Jodit -->
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/jodit/3.1.39/jodit.min.js"></script>

	<!-- Editor de texto Configurações -->
	<script type="text/javascript">
		var imagens;

		var editor = new Jodit('#editor', {
			buttons: ['fullsize', '|', 'paragraph', 'fontsize', 'align', 'font', '|', 'bold', 'strikethrough', 'underline', 'italic', '|', 'outdent', 'indent', '|', 'undo', 'redo', '|', 'source'],
			buttonsSM: ['fullsize', '|', 'paragraph', 'font', 'bold'],
			buttonsMD: ['fullsize', '|', 'paragraph', 'fontsize', 'align', 'font', '|', 'bold', 'strikethrough', 'underline', 'italic', '|', 'outdent', 'indent', '|', 'undo', 'redo', '|', 'source'],
			buttonsXS: ['fullsize', 'bold', 'fullsize'],
			height: 400,
			placeholder: "Digite uma descrição para a obra, não utilize imagens nesse momento, tente descrever de forma organizada pontos da obra e seus objetivos.",
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