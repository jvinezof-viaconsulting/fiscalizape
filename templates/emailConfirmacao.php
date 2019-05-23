<main>
	<section>
		<div>
			<div>
				<div>
					<h1><strong>Bem-Vindo</strong> <?php echo $usuario->getSobrenome() ?></h1>
				<p>
					<strong>FiscalizaPE</strong> tem o prazer em ter você conosco
				</p>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div>
			<h2>Seu Cadastro está quase pronto</h2>
			<p><strong class="has-text-grey">Falta só mais uma etepa para você se tornar um fiscal.</strong></p>

			<p>Ative seu email para ser um membro ativo e participar da comunidade FiscalizaPE ajudando Pernambuco a crescer cade vez mais, longe do mal da corrupção. Seja você também um fiscal das obras, um fator de mudança.</p>
		</div>

		<button>Ative sua conta</button>

		<div>
			<p>Clique no botão ou copie e cole o link no seu navegador (caso o botão não funcionar)</p>
		</div>
		<div>
			<a href="http://127.0.0.1/fiscalizape/controller/emailConfirmar.php?ativador=<?php echo $usuario->getId(); ?>&verificador=<?php echo md5($usuario->getEmail()) ?>">http://127.0.0.1/fiscalizape/controller/emailConfirmar.php?ativador=<?php echo $usuario->getId(); ?>&verificador=<?php echo md5($usuario->getEmail()) ?></a>
		</div>
	</section>

	<br>
	<footer>
		<div>
			<strong>&copy; FiscalizaPE</strong> 2018-2019. Alguns direitos reservados.
		</div>
	</footer>
</main>