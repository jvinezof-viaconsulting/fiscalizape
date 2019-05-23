<?php
require_once '../vendor/autoload.php';
require_once '../Autoload.php';
new fiscalizape\Autoload(['persistence', 'model'], ['DaoUsuario', 'Breadcrumb']);

use \fiscalizape\persistence\DaoUsuario;
use \fiscalizape\model\Breadcrumb as bc;

if (isset($_GET['p'])) {
	$daoUsuario = new DaoUsuario();

	$id = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$perfil = $daoUsuario->procurarPerfil($id);

	if ($perfil->getEmail() == NULL) {
		header('Location: index.php?erro=perfilInvalido');
		exit;
	}

	require_once '../controller/verificarFotoPerfil.php';
} else {
    header('Location: ./perfilNaoEncontrado.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<?php require_once "includes/head.php"; ?>

	<title>FiscalizaPE - Perfil de <?php echo $perfil->getSobrenome(); ?></title>
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
			<?php bc::gerar([ bc::usuarios(), bc::perfil($perfil->getNome() . ' ' . $perfil->getSobrenome(), $id) ]); ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Perfil de <?php echo $perfil->getSobrenome(); ?></h3>
					<hr>
					<div class="row">
						<div class="col-sm-4">
							<div class="infoleft">
								<div class="fotoperfil">
                                    <img src="<?php echo '../imagens/avatars/' . $perfil->getFoto() ?>" width="100%" height="100%">
								</div>
								<div class="sobreperfil">
									<span style="font-size: 15pt; text-align: center;"><b><?php echo $perfil->getNome() . ' ' . $perfil->getSobrenome(); ?></b></span><br><br>
									<span style="font-size: 10pt;"><b>Entrou em:</b> <?php echo date("d/m/y", strtotime($perfil->getRegistroData())); ?></span><br>
									<span style="font-size: 10pt;"><b>Último login:</b> <?php echo date("d/m/y", strtotime($perfil->getUltimoAcesso())); ?></span><br><br>
									<span style="font-size: 10pt;">
										<?php
											if ($sessao->estaLogado()) {
												if ($id == $usuario->getId()) {
													echo '<a href="./editarperfil.php">Editar meu perfil</a>';
												}
											}
										?>
									</span>
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="inforight">
								<b>Fiscalizações</b>
								<hr style="margin-top: 4px;">
								<i><?php echo $perfil->getSobrenome(); ?></i> não fiscalizou nenhuma obra.
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
</body>
</html>