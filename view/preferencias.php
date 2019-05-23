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
						<div class="col-4">
							<div class="list-group" id="list-tab" role="tablist">
								<a class="list-group-item list-group-item-action active" id="editar-perfil" data-toggle="list" href="#prefsperfil" role="tab" aria-controls="perfil">Perfil</a>
								<a class="list-group-item list-group-item-action" id="editar-privacidade" data-toggle="list" href="#prefsprivacidade" role="tab" aria-controls="privacidade">Privacidade</a>
								<a class="list-group-item list-group-item-action" id="alterar-email" data-toggle="list" href="#prefsemail" role="tab" aria-controls="email">Alterar email</a>
								<a class="list-group-item list-group-item-action" id="alterar-senha" data-toggle="list" href="#prefssenha" role="tab" aria-controls="senha">Alterar senha</a>
							</div>
						</div>
						<div class="col-8">
							<div class="tab-content" id="nav-tabContent">

								<div class="tab-pane fade show active" id="prefsperfil" role="tabpanel" aria-labelledby="editar-perfil">
									<div class="inforight" id="editarperfil">
										<b>Editar perfil</b>
										<hr style="margin-top: 4px;">

										<form class="needs-validation" novalidate method="post">
											<div class="row">
												<div class="col-md-6 mb-3">
													<label for="primeiroNome">Nome</label>
													<input type="text" name="nome" class="form-control" id="primeiroNome" placeholder="Nome..." value="Jurubeba" required>
													<div class="invalid-feedback">
														É obrigatório inserir um nome.
													</div>
												</div>
												<div class="col-md-6 mb-3">
													<label for="sobrenome">Sobrenome</label>
													<input type="text" name="sobrenome" class="form-control" id="sobrenome" placeholder="Sobrenome..." value="Junior" required>
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
													<input type="text" name="nomeUsuario" class="form-control" id="nickname" placeholder="Nome de usuário..." value="Jurubeba123" required minlength="3" maxlength="32">
													<div class="invalid-feedback" style="width: 100%;">
														É obrigatório inserir um nome de usuário válido (no mínimo 3 caracteres).
													</div>
												</div>
												<small class="text-muted">Pode conter letras (a-z), números(0-9), pontos (.) e underline (_)</small>
											</div>

											<div class="row">
												<div class="col-md-12 mb-3">
													<label for="estado">Estado</label>
													<select class="custom-select d-block w-100" id="estado">
														<option value="">Selecione um estado...</option>
														<option>Pernambuco</option>
													</select>
												</div>
												<div class="col-md-6 mb-3">
													<label for="estado">Cidade</label>
													<select class="custom-select d-block w-100" id="estado">
														<option value="">Selecione uma cidade...</option>
														<option>Recife</option>
													</select>
												</div>
												<div class="col-md-6 mb-3">
													<label for="cep">CEP</label>
													<input type="text" name="cep" class="form-control" id="cep" placeholder="Sem traços (-)" minlength="8" maxlength="8">
												</div>
											</div>

											<button class="btn btn-primary btn-lg btn-block" type="submit" id="submit_perfil">Salvar preferências de perfil</button>
										</form>
									</div>
								</div>

								<div class="tab-pane fade" id="prefsprivacidade" role="tabpanel" aria-labelledby="editar-privacidade">
									<div class="inforight" id="editarperfil">
										<b>Editar privacidade</b>
										<hr style="margin-top: 4px;">

										<form class="needs-validation" novalidate method="post">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="mostrar-estado">
												<label class="custom-control-label" for="mostrar-estado">
													Mostrar o estado que eu moro no meu perfil.
												</label>
											</div>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="mostrar-bairro">
												<label class="custom-control-label" for="mostrar-bairro">
													Mostrar o bairro que eu moro no meu perfil.
												</label>
											</div><br>

											<button class="btn btn-primary btn-lg btn-block" type="submit" id="submit_privacidade">Salvar preferências de privacidade</button>
										</form>
									</div>
								</div>

								<div class="tab-pane fade" id="prefsemail" role="tabpanel" aria-labelledby="alterar-email">
									<div class="inforight" id="editarperfil">
										<b>Alterar email</b>
										<hr style="margin-top: 4px;">

										<form class="needs-validation" novalidate method="post">
											<div class="mb-3">
												<label for="senha_atual_email">Senha atual</label>
												<input type="password" name="senha_atual_email" class="form-control" id="senha_atual_email" placeholder="Senha atual..." required>
												<div class="invalid-feedback">
													Por favor, digite a sua senha atual.
												</div>
											</div>
											<div class="mb-3">
												<label for="email">Novo Email</label>
												<input type="email" name="email" class="form-control" id="email" placeholder="fulano@exemplo.com" required>
												<div class="invalid-feedback">
													Por favor, insira um endereço de e-mail válido.
												</div>
											</div>

											<button class="btn btn-primary btn-lg btn-block" type="submit" id="submit_email">Alterar email</button>
										</form>
									</div>
								</div>

								<div class="tab-pane fade" id="prefssenha" role="tabpanel" aria-labelledby="alterar-senha">
									<div class="inforight" id="editarperfil">
										<b>Alterar senha</b>
										<hr style="margin-top: 4px;">

										<form class="needs-validation" novalidate method="post">
											<div class="mb-3">
												<label for="senha_atual_senha">Senha atual</label>
												<input type="password" name="senha_atual_senha" class="form-control" id="senha_atual_senha" placeholder="Senha atual..." required>
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

											<button class="btn btn-primary btn-lg btn-block" type="submit" id="submit_senha">Alterar senha</button>
										</form>
									</div>
								</div>

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