<!-- INICIO carousel -->
<div id="carrossel" class="carousel slide" data-ride="carousel" style="height: 300px; display: none;">
	<div class="carousel-inner" style="min-height: 200px; max-height: 400px">
		<div class="carousel-item active">
			<img class="d-block w-100" style="height: 30%" src="http://www.somrecordsweb.com.br/images/Mercado.jpg" alt="Obra em Andamento">
		</div>
		
		<div class="carousel-item">
			<img class="d-block w-100" src="http://www.al.es.gov.br/appdata/imagens_site/capa_34108_obraspublicasJunior-Silgueiro.jpg" alt="Obra Parada">
		</div>
		
		<div class="carousel-item">
			<img class="d-block w-100" src="https://organicsnewsbrasil.com.br/wp-content/uploads/2016/09/frevo_prefeitura_de_olinda-1.jpg">
		</div>
		
		<div class="carousel-caption d-none d-md-block" id="buscar">
			<h1>FiscalizaPE</h1>
			<h5>Seja você um fiscal das obras públicas, denuncie, cobre e faça do Brasil um país melhor e mais justo para todos!</h5>
			<form action="#" method="get">
				<div class="input-group">
					<input name="buscar" type="text" class="form-control" placeholder="Procure por cidades, bairros ou obras...">
					<div class="input-group-btn">
						<button type="submit" class="btn rounded-0 btn-success">Procurar</button>
					</div>	
				</div>										
			</form>
		</div>
		
		<a class="carousel-control-prev" href="#carrossel" role="button" data-slide="prev">
			<span class="carousel-control-prev-icon" aria-hidden="true"></span>
			<span class="sr-only">Anterior</span>
			</a>
		
		<a class="carousel-control-next" href="#carrossel" role="button" data-slide="next">
			<span class="carousel-control-next-icon" aria-hidden="true"></span>
			<span class="sr-only">Próximo</span>
			</a>
	</div>
</div>

<!-- INICIO Pesquisa para dispositivos moveis -->
<div id="pesquisa" class="container" style="display: none;">
	<h1 style="text-align: center">FiscalizaPE</h1>
	<form action="#">
		<div class="input-group">
			<input name="buscar" type="text" class="form-control" placeholder="Procure por cidades, bairros ou obras...">
			<div class="input-group-btn">
				<button type="submit" class="btn rounded-0 btn-success">Procurar</button>
			</div>	
		</div>
	</form>
</div>
<!-- FIM Pesquisa para dispositivos moveis -->

<script src="js/visibilidadeCarrossel.js"></script>
<!-- FIM carousel -->