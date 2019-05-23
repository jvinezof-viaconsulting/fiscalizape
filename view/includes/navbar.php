<?php

require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence', 'model', 'controller'], ['Sessao', 'ControleDeAcesso', 'verificarEmailAtivado']);

use \fiscalizape\model\ControleDeAcesso;
use \fiscalizape\persistence\Sessao;

$sessao = new Sessao();
if ($sessao->estaLogado()) {
    $usuario = $sessao->getSessaoUsuario();
    $controle = new ControleDeAcesso('../view/index.php');
} else if (isset($_COOKIE['logado'])) {
	if ($_COOKIE['logado']) {
		$usuario = unserialize($_COOKIE['usuario']);
		if (is_object($usuario)) {
			if (get_class($usuario) == "fiscalizape\model\Usuario") {
				// Definimos logado como true
				$_SESSION['logado'] = true;
				// sessão do usuario, esta sessão guarda o objeto usuario
				$_SESSION['usuario'] = serialize($usuario);
				$controle = new ControleDeAcesso('../view/index.php');
			} else {
				unset($usuario);
			}
		} else {
			unset($usuario);
		}
	}
}

$scriptName = basename($_SERVER['SCRIPT_NAME']);
?>
<!-- Inicio Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="navbar">
	<!-- Logo -->
	<a class="navbar-brand" href="index.php">
		<img src="img/logo32.png" alt="logo" class="d-inline-block align-top"> FiscalizaPE
	</a>

	<!-- Conteudo da navbar -->
	<div id="navConteudo" class="collapse navbar-collapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item"> <a id="navHome" class="nav-link" href="index.php">Inicio</a> </li>

			<li class="nav-item"> <a id="navForum" class="nav-link" href="#">Fórum</a> </li>

			<li class="nav-item"> <a id="navObras" class="nav-link" href="obras.php">Obras</a> </li>

			<li class="nav-item"> <a id="navDenuncias" class="nav-link" href="denuncias.php">Denúncias</a> </li>

			<li class="nav-item"> <a id="navSobrenos" class="nav-link" href="sobrenos.php">Sobre Nós</a> </li>

			<li class="nav-item"> <a id="navFaq" class="nav-link" href="faq.php">FAQ</a> </li>
		</ul>
		<?php if (!isset($_SESSION['logado'])) { ?>
			<!-- Login/Registro -->
			<div>
				<a href="login.php"><button type="button" class="btn <?php echo ($scriptName == 'login.php') ? 'btn-light' : 'btn-outline-light' ?>">Login</button></a>
				<span style="margin-left: 6px; margin-right: 6px;">ou</span>
				<a href="registrar.php"><button type="button" class="btn <?php echo ($scriptName == 'registrar.php') ? 'btn-warning' : 'btn-outline-warning' ?>">Registre-se</button></a>
			</div>
		<?php } ?>
	</div>

	<?php if (isset($_SESSION['logado'])) { ?>
		<ul class="navbar-nav">
                        <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php if (isset($usuario)) {echo $usuario->getSobrenome();} ?></a>
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown01" style="text-shadow: none;">
					<a class="dropdown-item" href="./perfil.php?p=<?php echo $usuario->getId(); ?>">Meu Perfil</a>
					<a class="dropdown-item" href="./editarperfil.php">Preferências</a>
                                        <?php if ($controle->acessoAdministrativo($usuario->getId())) { ?>
                                        <a class="dropdown-item" href="../admin/view/index.php">Admin</a>
                                        <?php } ?>
					<a class="dropdown-item" href="./sair.php" id="link-sair">Sair</a>
				</div>
			</li>
		</ul>
	<?php } ?>

	<!-- Botão (só aparece quando ela colapsa) -->
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navConteudo" aria-controls="navConteudo" aria-expanded="false" aria-label="Alterar Navegação">
		<span class="navbar-toggler-icon"></span>
	</button>
</nav>

<?php if (isset($usuario)) { ?>
<script src="./js/deslogarUsuario.js"></script>
<?php } ?>

<script src="./js/ativarLinkNavbar.js"></script>
<script src="./js/fixedNavbar.js"></script>
<!-- FIM Navbar -->