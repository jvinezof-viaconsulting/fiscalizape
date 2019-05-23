<?php
require_once '../Autoload.php';
$load = new \fiscalizape\Autoload(['persistence', 'util', 'model'], ['Sessao', 'Util', ['Erros', 'Breadcrumb'] ]);

use \fiscalizape\persistence\Sessao;
use \fiscalizape\util\Util;
use \fiscalizape\model\Erros;
use \fiscalizape\model\Breadcrumb as bc;

$sessao = new Sessao();
$util = new Util();
$objErros = new Erros("registrar", 0);
$erros = $objErros->getCookie();

if ($sessao->estaLogado()) {
	if (isset($_COOKIE['paginaVoltar'])) {
		if ($_COOKIE['paginaVoltar'] != $scriptAtual) {
			header('Location: ./' . filter_var($_COOKIE['paginaVoltar']), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		} else {
			header('Location: ./index.php');
		}
		exit;
	}
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Registrar</title>
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
			<!-- Breadcrumb -->
			<?php bc::gerar( [ bc::registrar() ] ) ?>
			<!-- Breadcrumb -->
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Registrar-se</h3>
					<hr>
					<?php for ($i = 0; $i < count($erros); $i++): ?>
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							<?php echo $erros[$i]; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php endfor; ?>
					<form class="needs-validation" novalidate action="../controller/incluirUsuario.php" method="post" onsubmit="enviarForm();">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="primeiroNome">Nome</label>
								<input type="text" name="nome" class="form-control" id="nome" placeholder="Nome..." required autofocus minlength="4" maxlength="30" onkeyup="validarNome(this)" value="<?php if (isset($_COOKIE['registrar']['nome'])) echo $_COOKIE['registrar']['nome']; ?>">
								<div id="numNomes" class="invalid-feedback">
									É obrigatório inserir um nome válido.
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="sobrenome">Sobrenome</label>
								<input type="text" name="sobrenome" class="form-control" id="sobrenome" placeholder="Sobrenome..." minlength="4" maxlength="30" required onkeyup="validarSobrenome(this)" value="<?php if (isset($_COOKIE['registrar']['sobrenome'])) echo $_COOKIE['registrar']['sobrenome']; ?>">
								<div id="invalid-sobrenome" class="invalid-feedback">
									É obrigatório inserir um sobrenome válido.
								</div>
							</div>
						</div>

						<div>

						</div>

						<div class="mb-3">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" id="email" placeholder="exemplo@fiscaliazpe.com" required onkeyup="validarEmail(this);" value="<?php if (isset($_COOKIE['registrar']['email'])) echo $_COOKIE['registrar']['email']; ?>">
							<div id="invalid-email" class="invalid-feedback">
								Por favor, insira um endereço de e-mail válido.
							</div>
						</div>

						<div class="mb-3">
							<label for="cpf">CPF</label>
							<input type="text" name="cpf" class="form-control" id="cpf" placeholder="Digite somente os números" required minlength="14" maxlength="14" onkeyup="mascaraNumeros('###.###.###-##',this,event,true)" value="<?php if (isset($_COOKIE['registrar']['cpf'])) echo $_COOKIE['registrar']['cpf']; ?>">
							<div class="invalid-feedback">
								Por favor, insira um cpf válido
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="senha">Senha</label>
								<input type="password" name="senha" class="form-control" id="senha" placeholder="Senha..." required minlength="8" maxlength="30" onkeyup="ajudaSenha(this);">
								<small id="ajudaSenha" class="form-text text-muted">No mínimo 8 caracteres.</small>
								<div class="invalid-feedback">
									Sua senha requer no minimo 8 caracteres.
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="senhaRepita">Senha (repita)</label>
								<input type="password" name="senhaRepita" class="form-control" id="senhaRepita" placeholder="Senha..." required minlength="8" maxlength="30" onkeyup="fSenhaRepita(this)">
								<div id="senhaNaoConfere" class="invalid-feedback">
									As senhas não conferem.
								</div>
							</div>
						</div>

						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="termos" class="custom-control-input" id="accept-terms" value="1" required>
							<label class="custom-control-label" for="accept-terms">
								Concordo com os <a onclick="salvarDados();return(false);" href="termos.php#termos" target="_blank" title="Nenhum dado digitado será perdido.">Termos & Condições</a>.
							</label>
							<div class="invalid-feedback">
								Você precisar concordar com os termos para se registrar.
							</div>
						</div>
						<hr class="mb-4">

						<!-- ao clicar deve redirecionar para a página "registro.php" -->
						<input type="submit" name="enviar" value="Registrar" class="btn btn-primary btn-lg btn-block">
					</form>
				</div>
				<div class="col-6 col-md-4">
					<h3>Publicidade</h3>
					<hr>
				</div>
			</div>
		</div>
	</main>

	<?php require_once "includes/footer.php" ?>

	<!-- Mascara para cpf -->
	<script src="js/mascaraNumeros.js"></script>

	<!-- Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido. -->
	<script src="js/invalid_form.js"></script>

	<!-- validar form -->
	<script src="js/validarFormIncluirUsuario.js"></script>

	<script>
		function stringDados() {
			var nome = document.getElementById('nome');
			var sobrenome = document.getElementById('sobrenome');
			var email = document.getElementById('email');
			var cpf = document.getElementById('cpf');

			return "nome="+nome.value + "&sobrenome="+sobrenome.value + "&email="+email.value + "&cpf="+cpf.value;
		}

		function salvarDados() {
			var ajax = new XMLHttpRequest();
			ajax.open("POST", "../ajax/salvarFormRegistrar.php", true);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send( stringDados() );
			ajax.onreadystatechange = function() {
				// Caso o state seja 4 e o http.status for 200, é porque a requisiçõe deu certo.
				if (ajax.readyState == 4 && ajax.status == 200) {
					window.location.href = 'termos.php#termos';
				}
			}
		}
	</script>
</body>
</html>