<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="index.php">FiscalizaPE</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item"> <a class="nav-link" href="/index.php">Início</a> </li>
			<li class="nav-item"> <a class="nav-link" href="/forum/index.php">Fórum</a> </li>
			<li class="nav-item"> <a class="nav-link" href="/denuncias.php">Denúncias</a> </li>
			<li class="nav-item"> <a class="nav-link" href="/sobre-nos.php">Sobre nós</a> </li>
			<li class="nav-item"> <a class="nav-link" href="/faq.php">FAQ</a> </li>
		</ul>
		<!-- Se estiver logado -->
		<!--
		<ul class="navbar-nav">
			<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">NomeDoUsuario</a>
				<div class="dropdown-menu" aria-labelledby="dropdown01" style="text-shadow: none;">
					<a class="dropdown-item" href="/perfil.php">Meu Perfil</a>
					<a class="dropdown-item" href="/editarperfil.php">Preferências</a>
					<a class="dropdown-item" href="/sair.php">Sair</a>
				</div>
			</li>
		</ul>
		-->

		<!-- Se NÃO estiver logado -->
		<ul class="navbar-nav">
			<li class="nav-item"> <a class="nav-link" href="login.php">Login</a> </li>
			<li class="nav-item"> <a class="nav-link" href="registrar.php">Registrar</a> </li>
		</ul>
	</div>
</nav>