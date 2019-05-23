<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Preferências</title>

	<style type="text/css">
		div#editar a#alterarsenha {
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
								<b>Alterar senha</b>
								<hr style="margin-top: 4px;">

								<form class="needs-validation" novalidate method="post">
									<div class="mb-3">
										<label for="senha">Senha atual</label>
										<input type="password" name="email" class="form-control" id="senha" placeholder="Senha atual..." required>
										<div class="invalid-feedback">
											Por favor, digite a sua senha atual.
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="novasenha">Nova senha</label>
											<input type="password" name="novasenha" class="form-control" id="novasenha" placeholder="Nova senha..." required minlength="6" maxlength="128">
											<div class="invalid-feedback">
												Por favor, insira a nova senha.
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="novasenhaRepita">Nova senha (repita)</label>
											<input type="password" name="novasenhaRepita" class="form-control" id="novasenhaRepita" placeholder="Nova senha..." required minlength="6" maxlength="128">
											<div class="invalid-feedback">
												Por favor, repita a nova senha.
											</div>
										</div>
									</div>

									<button class="btn btn-primary btn-lg btn-block" type="submit">Salvar preferências</button>
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