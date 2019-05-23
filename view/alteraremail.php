<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Preferências</title>

	<style type="text/css">
		div#editar a#alteraremail {
			background-color: rgba(0,0,0,0.3);
			border-radius: .3rem;
		}
		.infoleft {
			padding: 8px;
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
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Preferências</h3>
					<hr>
					<div class="row">
						<div class="col-sm-4">
							<div class="infoleft">
								<div class="sobreperfil">
									<div id="editar">
										<a href="editarperfil.php" class="btn btn-secondary btn-lg active" id="editarperfil" role="button" aria-pressed="true">Perfil</a>
										<a href="editarprivacidade.php" class="btn btn-secondary btn-lg active" id="editarprivacidade" role="button" aria-pressed="true">Privacidade</a>
										<a href="alteraremail.php" class="btn btn-secondary btn-lg active" id="alteraremail" role="button" aria-pressed="true">Alterar email</a>
										<a href="alterarsenha.php" class="btn btn-secondary btn-lg active" id="alterarsenha" role="button" aria-pressed="true">Alterar senha</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="inforight" id="editarperfil">
								<b>Alterar email</b>
								<hr style="margin-top: 4px;">

								<form class="needs-validation" novalidate method="post" action="../controller/emailEnviarConfirmacaoTrocaEmail.php">
									<div class="mb-3">
										<label for="email">Novo Email</label>
										<input type="email" name="email" class="form-control" id="email" placeholder="fulano@exemplo.com" required>
										<div class="invalid-feedback">
											Por favor, insira um endereço de e-mail válido.
										</div>
									</div>
									<div class="mb-3">
										<label for="senha">Sua Senha</label>
										<input type="password" name="senha" class="form-control" id="senha" placeholder="Digite sua senha" required>
										<div class="invalid-feedback">
											Por favor, digite a sua senha atual.
										</div>
									</div>

									<input class="btn btn-primary btn-lg btn-block" type="submit" value="Salvar preferências">
								</form>
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

	<!-- Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido. -->
	<script src="js/invalid_form.js"></script>
</body>
</html>