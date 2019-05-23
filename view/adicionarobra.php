<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Adicionar Obra</title>
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
					<h3>Adicionar Obra</h3>
					<hr>
                    <form class="needs-validation" novalidate method="post">
						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="cidade_obra">Selecione a cidade:</label>
        						<select class="custom-select d-block w-100" id="cidade_obra" required>
    								<option value="" selected>Selecione...</option>
    								<option value="jaboatao">Jaboatão dos Guararapes</option>
                                    <option value="recife">Recife</option>
    							</select>
								<div class="invalid-feedback">
									É obrigatório selecionar uma cidade.
								</div>
							</div>
							<div class="col-md-6 mb-3">
								<label for="bairro_obra">Selecione o bairro:</label>
            					<select class="custom-select d-block w-100" id="bairro_obra" required>
    								<option value="" selected>Selecione...</option>
                                    <option value="vila_rica">Vila Rica</option>
                                    <option value="boa_viagem">Boa Viagem</option>
    							</select>
								<div class="invalid-feedback">
									É obrigatório selecionar um bairro.
								</div>
							</div>
						</div>

						<div class="mb-3">
							<label for="endereco_obra">Endereço</label>
							<input type="text" name="endereco_obra_n" class="form-control" id="endereco_obra" placeholder="Ex.: R. Boa Viagem, 10" required>
							<div class="invalid-feedback">
								Por favor, insira um endereço válido.
							</div>
						</div>

                        <div class="mb-3">
    						<label for="titulo_obra">Título (nome)</label>
							<input type="text" name="titulo_obra_n" class="form-control" id="titulo_obra" placeholder="Ex.: UPA 24H" required>
							<div class="invalid-feedback">
								Por favor, insira um título válido.
							</div>
						</div>

                        <div class="form-group">
    					  <label for="descricao_nova_obra">Descrição (opcional)</label>
						  <textarea class="form-control" rows="5" id="descricao_nova_obra" name="descricao_nova_obra_n" placeholder="Fale um pouco mais sobre a obra..." style="margin-top: 0px; margin-bottom: 0px; height: 128px;"></textarea>
						</div>

                        <div class="mb-3">
        					<label for="data_inicio_prevista_obra">Data prevista para o início da obra</label>
							<input type="text" name="data_inicio_prevista_obra_n" class="form-control" id="data_inicio_prevista_obra" placeholder="dd/mm/aaaa" required maxlength="10">
							<div class="invalid-feedback">
								Por favor, insira uma data válida.
							</div>
						</div>

                        <div class="mb-3">
            				<label for="data_inicio_obra">Data de início da obra (opcional)</label>
							<input type="text" name="data_inicio_obra_n" class="form-control" id="data_inicio_obra" placeholder="dd/mm/aaaa" maxlength="10">
						</div>

                        <div class="mb-3">
            				<label for="data_final_prevista_obra">Data prevista para o final da obra (opcional)</label>
							<input type="text" name="data_final_prevista_obra_n" class="form-control" id="data_final_prevista_obra" placeholder="dd/mm/aaaa" maxlength="10">
						</div>

                        <div class="mb-3">
            				<label for="data_final_obra">Data de final (opcional)</label>
							<input type="text" name="data_final_obra_n" class="form-control" id="data_final_obra" placeholder="dd/mm/aaaa" maxlength="10">
						</div>

						<hr class="mb-4">

						<!-- ao clicar deve redirecionar para a página "registro.php" -->
						<input type="submit" name="add_obra" value="Adicionar Obra" class="btn btn-primary btn-lg btn-block">
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

	<!-- Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido. -->
	<script src="js/invalid_form.js"></script>
</body>
</html>
