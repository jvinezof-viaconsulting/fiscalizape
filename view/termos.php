<!DOCTYPE html>
<html>
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>

	<title>Termos de uso</title>
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
			<div class="row">
				<div class="col-12 col-md-8">
					<h3>Termos de uso</h3>
					<hr>

					<textarea class="form-control" style="resize: none;height: 400px" name="termos" id="termos" readonly>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque quis tortor ac risus vestibulum tincidunt vel a dui. Sed semper malesuada orci, ac condimentum orci tristique at. Suspendisse accumsan risus ante, vitae condimentum metus efficitur et. Morbi metus ante, consectetur sit amet tortor quis, varius luctus felis. In eget ligula sit amet lorem eleifend pharetra at ut sapien. Pellentesque volutpat ex vulputate lectus condimentum, sit amet viverra est aliquet. Nam ullamcorper nunc sit amet diam volutpat, consequat blandit magna iaculis. Maecenas eget nisl nunc. Maecenas porttitor nunc metus. Ut pulvinar leo id odio mattis, in tincidunt enim placerat.

Donec at condimentum lorem. Ut placerat, augue a blandit convallis, dui est molestie quam, vel sagittis felis diam euismod est. Nullam volutpat accumsan dolor et congue. Nunc et odio libero. Proin ipsum risus, dapibus ut lorem eu, facilisis suscipit ligula. Curabitur facilisis molestie lacus eget pellentesque. In hac habitasse platea dictumst. Maecenas bibendum neque non ornare rhoncus. Nulla gravida eu neque vel placerat. Nullam pellentesque nisi quis urna rutrum, a fermentum nisl imperdiet. Ut et erat molestie sem molestie auctor. Proin et tincidunt risus, vitae commodo turpis. Mauris lobortis eros non libero porttitor sodales. Quisque vel rutrum erat. Quisque purus ante, vestibulum non pharetra ullamcorper, faucibus sit amet augue.
					</textarea>

					<div class="mt-2">
						<a href="registrar.php"><button class="btn btn-success float-right">Concordo >></button></a>
						<a href="index.php"><button class="btn btn-danger float-left">Cancelar</button></a>
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
</body>
</html>