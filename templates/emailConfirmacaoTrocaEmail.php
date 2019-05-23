<main>
	<section>
		<div>
			<h2>Olá <?php echo $usuario->getNome() . ' ' . $usuario->getSobrenome(); ?></h2>

			<p>Parece que você quer mudar de email, mas precisamos confirmar que é você mesmo. Tenha em mente que você deverar usar o novo email para login e que toda comunicação entre você e o fiscalizape será feita no mesmo. Clique no botão ou no link para confirmar que é você.</p>

			<p>Ao clicar no botão ou link enviaremos um email de confirmação para <?php echo $usuario->getEmailPendente(); ?></p>
		</div>

		<a href="http://localhost/fiscalizape/controller/emailEnviarEtapaDoisTrocaEmail.php?h=<?php echo $usuario->getId(); ?>&v=<?php echo md5($usuario->getEmail()); ?>&tokenEmail=<?php echo $tokenEmail ?>"><button>Sim sou eu, trocar meu email!</button></a>

		<div>
			<p>Clique no botão ou copie e cole o link no seu navegador (caso o botão não funcionar)</p>
		</div>
		<div>
			<a href="http://localhost/fiscalizape/controller/emailEnviarEtapaDoisTrocaEmail.php?h=<?php echo $usuario->getId(); ?>&v=<?php echo md5($usuario->getEmail()); ?>&tokenEmail=<?php echo $tokenEmail ?>">http://localhost/fiscalizape/controller/emailEnviarEtapaDoisTrocaEmail.php?h=<?php echo $usuario->getId(); ?>&v=<?php echo md5($usuario->getEmail()); ?>&tokenEmail=<?php echo $tokenEmail ?></a>
		</div>

		<br><br>
		<strong>Importante:</strong> Se não foi você que solicitou a troca de email, sua conta pode ter sido invadida recomendamos a troca da senha. <a href="#">Quero mudar minha senha</a>
	</section>

	<br>
	<footer>
		<div>
			<strong>&copy; FiscalizaPE</strong> 2018-2019. Alguns direitos reservados.
		</div>
	</footer>
</main>