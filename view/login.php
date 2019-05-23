<?php
require_once '../Autoload.php';
$load = new \fiscalizape\Autoload(['persistence', 'util', 'model'], ['Sessao', 'Script', ['Breadcrumb', 'Erros', 'Avisos'] ]);

use \fiscalizape\persistence\Sessao;
use \fiscalizape\util\Script;
use \fiscalizape\model\Breadcrumb as bc;
use \fiscalizape\model\Erros;
use \fiscalizape\model\Avisos;

$script = new Script();
$sessao = new Sessao();
$objErros = new Erros('login', 0);
$objAvisos = new Avisos('login', 0);

if ($sessao->estaLogado()) {
	if (isset($_COOKIE['paginaVoltar'])) {
		if ($_COOKIE['paginaVoltar'] != 'login.php') {
			header('Location: ./' . filter_var($_COOKIE['paginaVoltar'], FILTER_SANITIZE_FULL_SPECIAL_CHARS));
		} else {
			header('Location: ./index.php');
		}
		exit;
	} else {
		header('Location: ./index.php');
		exit;
	}
}

$erros = $objErros->getCookie();
$avisos = $objAvisos->getCookie();

// Valores dos campos
setcookie('formulario[email]', '', time()-1, '/fiscalizape/view/login.php');
setcookie('formulario[lembrarDeMim]', '', time()-1, '/fiscalizape/view/login.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>

	<title>Fazer login</title>
</head>

<body>
	<!-- NAVBAR -->
	<?php require_once "includes/navbar.php"; ?>

	<header>
		<!-- CARROSSEL -->
		<?php require_once "includes/carrossel.php"; ?>
	</header>

	<main role="main">
		<div class="container mt-3 mb-5">
			<?php bc::gerar([ bc::login() ]); ?>
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Fazer login</h3>
					<hr>
					<?php $objErros->gerarMensagem($erros); ?>
					<?php $objAvisos->gerarMensagem($avisos); ?>
					<form method="post" action="../controller/loginIniciar.php" class="needs-validation" novalidate>
						<div class="mb-3">
							<label for="email">Email</label>
							<input type="email" name="email" class="form-control" id="email" placeholder="fulano@exemplo.com" required autofocus value="<?php echo (isset($_COOKIE['formulario']['email']))? $_COOKIE['formulario']['email'] : '' ?>">
							<div class="invalid-feedback">
								Por favor, insira um endereço de e-mail válido.
							</div>
						</div>

						<div class="mb-3">
							<label for="senha">Senha</label>
							<input type="password" name="senha" class="form-control" id="senha" placeholder="Senha..." required>
							<div class="invalid-feedback">
								Por favor, insira a sua senha.
							</div>
						</div>

						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="lembrarDeMim" class="custom-control-input" id="remember-me" value="1" <?php if (isset($_COOKIE['formulario']['lembrarDeMim'])) echo ($_COOKIE['formulario']['lembrarDeMim'] == 1) ? 'checked="true"' : '' ?>>
							<label class="custom-control-label" for="remember-me">
								Lembrar de mim.
							</label>
						</div>
						<hr class="mb-4">

						<button class="btn btn-primary btn-lg btn-block" type="submit">Entrar</button><br>
					</form>

					<div id="loginFacebook">
						<?php
						require_once 'lib/Facebook/autoload.php';
						$fb = new Facebook\Facebook([
							'app_id' => '1662237970544663',
							'app_secret' => '1662237970544663',
							'default_graph_version' => 'v2.2',
						]);
						$helper = $fb->getRedirectLoginHelper();
  //var_dump($helper);
  $permissions = ['email']; // Permissões opcionais

  try {
  	if(isset($_SESSION['facebook_access_token'])){
  		$accessToken = $_SESSION['facebook_access_token'];
  	}else{
  		$accessToken = $helper->getAccessToken();
  	}

  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // Quando Graph retorna um erro
  	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // Quando a validação falha ou outros problemas locais
  	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
  }
  if (! isset($accessToken)) {
  	$url_login = 'http://localhost/view/loginFacebook.php?paraceQueHouveAlgumErro';
  	$loginUrl = $helper->getLoginUrl($url_login, $permissions);
  }else{
  	$url_login = 'http://localhost/view/index.php?loginFeitoComFacebook';
  	$loginUrl = $helper->getLoginUrl($url_login, $permissions);
    //usuario ja autenticado
  	if(isset($_SESSION['facebook_access_token'])){
  		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }//usuario nao autenticado
    else{
    	$_SESSION['facebook_access_token'] = (string) $accessToken;
    	$oAuth2Client = $fb->getOAuth2Client();

    	$_SESSION['facebook_access_token'] = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
    	$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    try {
    // Returns a `Facebook\FacebookResponse` object
    	$response = $fb->get('/me?fields=name, picture,email');
    	$user = $response->getGraphUser();
    	var_dump($user);
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
    	echo 'Graph returned an error: ' . $e->getMessage();
    	exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
    	echo 'Facebook SDK returned an error: ' . $e->getMessage();
    	exit;
    }
}
?>
<button  class="btn btn-primary btn-lg btn-block" onclick="location.href='<?php echo $loginUrl; ?>'">Entrar com Facebook</button>
</div>
</div>
<div class="col-6 col-md-4">
	<h3>Publicidade</h3>
	<hr>
</div>
</div>
</div>
</main>

<!-- Footer -->
<?php require_once "includes/footer.php" ?>

<!-- Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido. -->
<script src="js/invalid_form.js"></script>
</body>
</html>