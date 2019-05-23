<?php
	require_once '../../Autoload.php';
	new \fiscalizape\Autoload('persistence', 'Sessao');

	use \fiscalizape\persistence\Sessao;

	$sessao = new Sessao();
	$usuario = $sessao->getSessaoUsuario();
?>
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-inverse-collapse">
				<i class="icon-reorder shaded"></i>
            </a>
            <a class="brand" href="index.php">Painel | FiscalizaPE </a>
			<div class="nav-collapse collapse navbar-inverse-collapse">
				<ul class="nav pull-right">
					<li class="nav-user dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="../../imagens/avatars/<?php echo $usuario->getFoto(); ?>" class="nav-avatar" />
						<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="../../view/index.php">Voltar para o site</a></li>
							<li><a href="../../view/editarperfil.php">Editar meu usuário</a></li>
							<li class="divider"></li>
							<li><a href="../../view/sair.php"><i class="fas fa-sign-out-alt"></i>Sair </a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
