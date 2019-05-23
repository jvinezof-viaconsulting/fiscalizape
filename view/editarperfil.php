<?php
require_once '../controller/verificarAcessoUsuarioPermitido.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Preferências</title>

	<style type="text/css">
		div#editar a#editarperfil {
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
	<?php
		require_once "includes/navbar.php";

		// Verificando se o usario tem foto de perfil
		$perfil = $usuario;
		require_once '../controller/verificarFotoPerfil.php';
	?>

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
								<b>Editar perfil</b>
								<hr style="margin-top: 4px;">

								<form class="needs-validation" novalidate method="post" action="../controller/perfilEditar.php" enctype="multipart/form-data">
									<input type="text" name="id" hidden="true" value="<?php echo $usuario->getId(); ?>">
									<div class="row text-center">
										<img src="../imagens/avatars/<?php echo $usuario->getFoto(); ?>" alt="fotoPerfil.php" class="rounded-circle mx-auto d-block" id="fotoPerfil" style="width: 250px; height: 250px;">
										<label class="custom-file">
						                	<input type="file" id="arquivoFoto" name="arquivoFoto" class="custom-file-input" hidden="true" onchange="readUrl(this)" accept="image/png, image/jpeg, image/jpg">
						                	<span class="custom-file-control">Mudar Foto</span>
						                </label>
									</div>
									<br>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="primeiroNome">Nome</label>
											<input type="text" name="nome" class="form-control" id="primeiroNome" placeholder="Nome..." value="<?php echo $usuario->getNome(); ?>">
											<div class="invalid-feedback">
												É obrigatório inserir um nome.
											</div>
										</div>
										<div class="col-md-6 mb-3">
											<label for="sobrenome">Sobrenome</label>
											<input type="text" name="sobrenome" class="form-control" id="sobrenome" placeholder="Sobrenome..." value="<?php echo $usuario->getSobrenome(); ?>" required>
											<div class="invalid-feedback">
												É obrigatório inserir um sobrenome.
											</div>
										</div>
									</div>

									<div class="mb-3">
										<label for="nickname">Nome de usuário</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">@</span>
											</div>
											<input type="text" name="nomeUsuario" class="form-control" id="nickname" placeholder="Nome de usuário..." value="<?php echo $usuario->getNomeUsuario(); ?>" minlength="3" maxlength="32">
											<div class="invalid-feedback" style="width: 100%;">
												É obrigatório inserir um nome de usuário válido (no mínimo 3 caracteres).
											</div>
										</div>
										<small class="text-muted">Pode conter letras, números, pontos e _</small>
									</div>
									<div class="row">
										<div class="col-md-6 mb-3">
											<label for="estado">Estado</label>
											<select class="custom-select d-block w-100" id="estado" name="estado">
												<option value="">Selecione um estado...</option>
												<option value="PE" <?php echo ($usuario->getEstado() == "PE") ? "Selected" : "" ?>>Pernambuco</option>
											</select>
										</div>
										<div class="col-md-6 mb-3">
											<label for="cep">CEP</label>
											<input type="text" name="cep" class="form-control" id="cep" placeholder="Sem traços (-)" minlength="8" maxlength="8" value="<?php echo $usuario->getCep(); ?>">
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
	<script src="js/fotoPerfilPreview.js"></script>
</body>
</html>