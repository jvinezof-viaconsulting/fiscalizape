<?php
	require_once '../Autoload.php';
	new \fiscalizape\Autoload(['persistence', 'model'], ['DaoCidade', ['ControleDeAcesso', 'Erros', 'Avisos', 'Breadcrumb'] ]);

	use \fiscalizape\persistence\DaoCidade;
	use \fiscalizape\model\ControleDeAcesso;
	use \fiscalizape\model\Erros;
	use \fiscalizape\model\Avisos;
	use \fiscalizape\model\Breadcrumb as bc;

	$controle = new ControleDeAcesso();
	$daoCidade = new DaoCidade();
	$objErros = new Erros('novaobra', 0);
	$objAvisos = new Avisos('novaobra', 0);

	// Caso não esteja logado este metodo statico leva o usuario para uma view, definida no parametro
	$controle->permitirUsuario('novaobra.php');
	$cidades = $daoCidade->listarCidades();
	$erros = $objErros->getCookie();
	$avisos = $objAvisos->getCookie();

	// Apagando cookies
	setcookie('form[titulo]', '', time()-1);
	setcookie('form[descricao]', '', time()-1);
	setcookie('form[cidade]', '', time()-1);
	setcookie('form[verbaInicial]', '', time()-1);
	setcookie('form[cep]', '', time()-1);
	setcookie('form[rua]', '', time()-1);
	setcookie('form[bairro]', '', time()-1);
	setcookie('form[dataInicialPrevista]', '', time()-1);
	setcookie('form[dataFinalPrevista]', '', time()-1);
	setcookie('form[orgao]', '', time()-1);
	setcookie('form[verbaUtilizada]', '', time()-1);
	setcookie('form[situacao]', '', time()-1);
	setcookie('form[dataInicial]', '', time()-1);
	setcookie('form[dataFinal]', '', time()-1);
?>
<!DOCTYPE html>
<html>
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>

	<title>Nova Obra</title>
	<style type="text/css">
		.imagens-obra {

		}

		.imagens-obra img {
			width: 150px;
			height: 150px;
		}
	</style>

	<!-- Radio Button Style -->
	<link rel="stylesheet" type="text/css" href="css/radio.css">
</head>
<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<main role="main">
		<div class="container ml-5">
			<?php bc::gerar([ bc::obras(), bc::novaObra() ]); ?>
			<?php $objErros->gerarMensagem($erros); ?>
			<?php $objAvisos->gerarMensagem($avisos); ?>
			<div class="row">
				<!-- Conteudo INICIO -->
				<div class="col-12 col-md-12">
					<h3>Nova Obra</h3>
					<hr>
					<small class="text-muted">Campos marcados com <span class="text-danger">*</span> (asteristico) são obrigatórios</small>

					<form id="formObra" method="post" action="../controller/incluirObra.php" class="needs-validation" novalidate enctype="multipart/form-data">
						<div class="mb-3">
							<label for="titulo" class="mt-3">Título da Obra<span class="text-danger" title="Este campo é obrigatório">*</span></label>
							<small class="text-muted">Esse título identifica sua obra no site.</small>
							<input type="text" name="titulo" class="form-control" required="true" placeholder="ex: Operação tampa buraco" autofocus onkeyup="ajudaTitulo(this);" minlength="5" maxlength="50" value="<?php echo (isset($_COOKIE['form'])) ? $_COOKIE['form']['titulo'] : '' ?>">
							<small class="form-text text-muted" id="ajuda-titulo">Digite um título descritivo, você tem 50 letras.</small>
						</div>

						<div class="mb-3">
							<label for="descricao">Descrição<span class="text-danger" title="Este campo é obrigatório">*</span></label>
							<small class="text-muted">Não adicione imagens aqui.</small>
							<br>
							<textarea id="editor" name="descricao" required maxlength="3000" minlength="10" onkeyup="ajudaDescricao(this);"></textarea>
							<small id="ajuda-descricao" class="form-text text-muted">Você tem 3000 letras.</small>
						</div>

						<div class="mb-3">
							<label for="imagens">Imagens:</label> <br>
							<div class="imagens-obra d-inline mb-2" id="div-imagens-obra">
								<label class="custom-file d-inline mb-2" id="adicionar-nova-imagem">
									<input type="file" id="imagensObra" name="imagensObra[]" class="custom-file-input" hidden="true" multiple="true" onchange="readUrl(this)" accept="image/png, image/jpeg, image/jpg">
									<span class="custom-file-control">
										<figure class="figure">
											<img class="rounded" src="../imagens/sistema/util/mais.png" alt="Adicionar imagem a obra">
											<figcaption class="figure-caption text-center">Adicione Outra</figcaption>
										</figure>
									</span>
								</label>
							</div>
						</div>
						<hr>

						<div class="mb-3">
							<h5>Informações Oficiais</h5>

							<div class="row">
								<div class="col mb-2">
									<label for="cidade">Cidade<span class="text-danger" title="Este campo é obrigatório">*</span></label>
									<select class="form-control" id="cidadeId" name="cidade" required onchange="atualizarCidade()">
										<option selected hidden>Selecione a cidade da obra</option>
										<?php foreach ($cidades as $cidade) { ?>
										<option value="<?php echo $cidade->getId(); ?>"><?php echo $cidade->getNome(); ?></option>
										<?php } ?>
										<option value="-1">Não tem minha cidade</option>
									</select>
								</div>

								<div class="col">
									<label for="verbaInicial">Verba Inicial<span class="text-danger" title="Este campo é obrigatório">*</span></label>
									<div class="input-group">
										<div class="input-group-prepend">
											 <span class="input-group-text">R$</span>
										</div>
										<input type="text" name="verbaInicial" value="0" minlength="0" maxlength="12" class="form-control" onKeyPress="return(MascaraMoeda(this,'.',',',event))" required>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col">
									<label for="dataInicioPrevista">Data Prevista para Inicio<span class="text-danger" title="Este campo é obrigatório">*</span></label>
									<input type="date" name="dataInicioPrevista" id="dataInicioPrevista" class="form-control" required min="1851-01-01" max="<?php echo date('Y-m-d', time()+60*60*24*180); ?>" title="A obra não pode ser inserida 6 meses antes da data prevista de inicio." onchange="ajudaData(this);">
									<small class="form-text text-muted" id="ajuda-data-inicio-oficial">Não pode ser maior que <?php echo date('d/m/Y', time()+60*60*24*180); // Data maxima é daqui a 6 meses ?> ou menor que 01/01/1851.</small>
								</div>

								<div class="col">
									<label for="dataEncerramentoPrevista">Data Previsata para Encerramento<span class="text-danger" title="Este campo é obrigatório">*</span></label>
									<input type="date" name="dataEncerramentoPrevista" id="dataEncerramentoPrevista" class="form-control" required min="1851-01-01" max="<?php echo date('Y-m-d', time()+60*60*24*360*15); ?>" title="Não pode durar mais de 15 anos.">
									<small class="form-text text-muted" id="ajuda-data-final-oficial">Não pode ser menor que a data de inicio.</small>
								</div>
							</div>
						</div>
						<hr>

						<div class="mb-3">
							<h5>Informações Opcionais <i id="drop-icon" class="fas fa-caret-down" onclick="mudarEstado(this)"></i></h5>
							<div id="informacoes-opcionais" style="display: none">
								<div class="mb-2">
									<div class="row">
										<div class="col">
											<label for="dataIncioReal">Data de Inicio <small class="text-muted">(data em que as obras de fato começaram)</small></label>
											<input type="date" name="dataIncioReal" class="form-control">
										</div>

										<div class="col">
											<label for="DataEncerramentoReal">Data de Encerramento <small class="text-muted">(data em que as obras de fato se encerraram)</small></label>
											<input type="date" name="dataEncerramentoReal" class="form-control">
										</div>
									</div>
								</div>

								<div class="mb-2">
									<div class="row">
										<div class="col">
											<label for="orgaoResponsavel">Orgão Responsavel</label>
											<input type="text" name="orgaoResponsavel" minlength="0" maxlength="50" class="form-control">
										</div>

										<div class="col">
											<label for="verbaUtilizada">Verba Utilizada</label>
											<div class="input-group">
												<div class="input-group-prepend">
													 <span class="input-group-text">R$</span>
												</div>
												<input type="text" name="verbaUtilizada" value="0"class="form-control" onKeyPress="return(MascaraMoeda(this,'.',',',event))">
											</div>
										</div>
									</div>
								</div>

								<div class="mb-2">
									<label for="estadoAtual">Situação Atual da Obra</label>

									<label class="radio-container">Ainda não começou
										<input type="radio" name="estadoAtual" value="Não Iniciada">
										<span class="radio-checkmark"></span>
									</label>

									<label class="radio-container">Começou, mas está parada
										<input type="radio" name="estadoAtual" value="Parada">
										<span class="radio-checkmark"></span>
									</label>

									<label class="radio-container">Começou, em andamento
										<input type="radio" name="estadoAtual" value="Em Andamento">
										<span class="radio-checkmark"></span>
									</label>

									<label class="radio-container">Obra Concluida
										<input type="radio" name="estadoAtual" value="Finalizada">
										<span class="radio-checkmark"></span>
									</label>
								</div>
							</div>
						</div>
						<br>

						<div class="mb-3" hidden>
							<h1>tres</h1>
						</div>

						<div class="mb-3">
							<h5>Localização<span class="text-danger" title="Este campo é obrigatório">*</span>:</h5>

							<div id="divEndereco" hidden="true">
								<label for="endereco">
									Endereço
									<a href="#" onclick="mostrarEsconderEnd();return(false);" style="text-decoration: none;"><small class="text-muted">prefiro digitar o cep</small></a>
								</label>

								<div class="row mb-3">
									<div class="col">
										<input type="text" name="rua" id="rua" class="form-control mr-2" placeholder="Nome da rua" required>
									</div>

									<div class="col">
										<input type="text" name="bairro" id="bairro" class="form-control mr-2" placeholder="Nome do bairro" required>
									</div>

									<div class="col">
										<input type="text" name="cidadeNome" id="cidade" class="form-control mr-2" placeholder="Nome da cidade" disabled required>
									</div>

									<div class="col-1">
										<a href="" class="btn btn-success" id="btn-localizacao" onclick="pesquisarNoMapa(false);return(false);"><i class="fas fa-search"></i></a>
									</div>
								</div>
							</div>

							<div id="divCep" class="mb-3">
								<label for="cep">
									Cep
									<a href="#" onclick="mostrarEsconderEnd();return(false);" style="text-decoration: none;"><small class="text-muted">não sei o cep</small></a>
								</label>

								<div class="input-group" style="width: 40%">
									<input type="text" name="cep" id="cep" class="form-control mr-2">

									<a href="" class="btn btn-success" id="btn-localizacao" onclick="pesquisarNoMapa(true);return(false);"><i class="fas fa-search"></i></a>
								</div>
								<small class="text-muted" id="avisoInfo"></small>
							</div>

							<div class="embed-responsive">
								<div class="mapouter"><div class="gmap_canvas"><iframe id="mapa" width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=recife%20Centro&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://www.pureblack.de"></a></div><style>.mapouter{text-align:right;height:500px;width:600px;}.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style>Google Maps by <a href="https://www.embedgooglemap.net" rel="nofollow" target="_blank">Embedgooglemap.net</a></div>
							</div>
						</div>

						<input class="btn btn-primary btn-lg mt-5" type="submit" value="Adicionar Obra">
					</form>
				</div>
				<!-- Conteudo FIM -->
			</div>
		</div>
	</main>

	<!-- Footer -->
	<?php require_once "includes/footer.php" ?>

	<!-- Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido. -->
	<script src="js/invalid_form.js"></script>
	<!-- Sistema de preview de imagens -->
	<script src="js/fotosObrasPreview.js"></script>
	<!-- Mascara Moeda -->
	<script src="js/mascaraMoeda.js"></script>
	<!-- Mostrar/Esconder Informações Opcionais do Form -->
	<script src="js/mostrarEsconderInfo.js"></script>
	<!-- Pega dados do cep IMPORTANTE: PRECISA VIR ANTES DE pesquisarNoMapa.js -->
	<script src="js/cepToString.js"></script>
	<!-- Função que pesquisa no mapa -->
	<script src="js/pesquisarNoMapa.js"></script>
	<!-- Função que mostra/esconde a div do endereço -->
	<script src="js/mostrarEsconderEnd.js"></script>
	<!-- Atualizando nome da cidade na pesquisa com a cidade do select -->
	<script src="js/atualizarNomeCidade.js"></script>
	<!-- Script Dicas Input -->
	<script type="text/javascript">
		function ajudaTitulo(input) {
			var small = document.getElementById('ajuda-titulo');
			var max = 50;
			var count = input.value.length;
			part1 = 'Digite um título descritivo, ';
			if (count == 0) {
				part2 = 'você tem ' + max + ' letras.';
			} else {
				if (max-count > 0) {
					part2 = 'restam ' + (max-count) + '.';
				} else {
					part2 = 'restam 0.';
				}
			}

			small.innerHTML = part1 + part2;
		}

		function ajudaDescricao(input) {
			var small = document.getElementById('ajuda-titulo');
			var max = 3000;
			var count = input.value.length;
			if (count == 0) {
				texto = 'você tem ' + max + ' letras.';
			} else {
				if (max-count > 0) {
					texto = 'restam ' + (max-count) + '.';
				} else {
					texto = 'restam 0.';
				}
			}

			small.innerHTML = texto;
		}


		function ajudaData(input) {
			var textoAjudaFinal = document.getElementById('ajuda-data-final-oficial');
			var inputFinal = document.getElementById('dataEncerramentoPrevista');
			if (input.value != '') {
				// Exemplo de requisição POST
				var ajax = new XMLHttpRequest();

				// Seta tipo de requisição: Post e a URL da API
				ajax.open("POST", "../controller/umDiaDepois.php", true);
				ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

				// Seta paramêtros da requisição e envia a requisição
				stringDados = 'data='+input.value;
				ajax.send(stringDados);

				// Cria um evento para receber o retorno.
				ajax.onreadystatechange = function() {
					// Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
					if (ajax.readyState == 4 && ajax.status == 200) {
						// Retorno do Ajax
						var data = ajax.responseText;
						parts = data.split('-');
						textoAjudaFinal.innerHTML = 'Não pode ser menor que ' + parts[2] + '/' + parts[1] + '/' + parts[0] + ', não pode durar mais de 15 anos.';
						inputFinal.min = data;
						if (inputFinal == '' || inputFinal.value <= input.value) {
							inputFinal.value = data;
						}
					}
				}
			} else {
				textoAjudaFinal.innerHTML = 'Não pode ser menor que a data de inicio, não pode durar mais de 15 anos.';
			}
		}
	</script>

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

		editor.events.on('change', function (change) {
			var textoAjuda = document.getElementById('ajuda-descricao');
			var texto = '';
			var max = 3000;
			var count = change.length;
			if (count == 0) {
				texto = 'você tem ' + max + ' letras.';
			} else {
				if (max-count > 0) {
					texto = '<span class="text-success">você tem ' + (max-count) + ' letras.</span>';
				} else {
					if (max-count < 0) {
						texto = '<span class="text-danger">você tem 0 letras. (passou: ' + (-1*(max-count)) + ')</span>';
					} else {
						texto = '<span class="text-success">você tem 0 letras.</span>';
					}
				}
			}

			textoAjuda.innerHTML = texto;
		});
	</script>
</body>
</html>