<div class="p-3 text-center carrossel" id="carrossel">
	<main role="main" style="padding-top: 50px">
		<div id="areaBusca">
			<h1 id="texto" style="color: black; text-shadow: 0px 0px 20px black">
				FiscalizaPE
			</h1>
			<p class="lead" style="color: black; text-shadow: 0px 0px 20px black;">
				Seja você um fiscal das obras públicas, denuncie, cobre e faça do Brasil um país melhor e mais justo para todos!
			</p>

			<div id="index">
				<p class="lead">
					<div class="input-wrap">
						<form action="search.php" class="form-box d-flex justify-content-between" method="GET" onsubmit="return q.value!=''">
							<input type="text" placeholder="Procure por cidades, bairros ou obras..." maxlength="256" class="form-control" name="q">
							<button type="submit" class="mybtn" id="indexbtnsearch">Buscar</button>
						</form>
					</div>
				</p>
			</div>
		</div>

		<a class="float-left ml-2" id="antBtn" onclick="ant()">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
		</a>

		<a class="float-right mr-2" id="proxBtn" onclick="prox()">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Próximo</span>
		</a>
	</main>
</div>

<script src="js/carrossel.js"></script>

<?php if ($sessao->estaLogado()): ?>
	<!-- MODAL INICIO -->
	<div class="modal fade" id="modalSucesso" tabindex="-1" role="dialog" aria-labelledby="sucessoMsodalLabel" aria-hidden="true">
		<div class="modal-dialog alert alert-success" role="document">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
			<span>Bem-Vindo de volta <?php echo $usuario->getNome(); ?>!</span>
		</div>
	</div>
	<!-- MODAL FIM -->
<?php endif; ?>