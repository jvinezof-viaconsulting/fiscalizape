<!DOCTYPE html>
<html>
	<head>
		<?php require_once('includes/head.php') ?>
		<title>Início - Painel | FiscalizaPE</title>
	</head>
	<body>
		<?php require_once('includes/navbar-top.php') ?>
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<?php require_once('includes/navbar-left.php') ?>
					<div class="span9">
						<div class="content">
							<div class="btn-controls">
								<div class="btn-box-row row-fluid">
									<a href="#" class="btn-box big span4">
										<i class=" icon-random"></i>
										<b>65%</b>
										<p class="text-muted">Growth</p>
									</a>
									<a href="#" class="btn-box big span4">
										<i class="icon-user"></i>
										<b>2<!-- aqui fica a contagem de usuário registrados --></b>
										<p class="text-muted">Usuários registrados</p>
									</a>
									<a href="#" class="btn-box big span4"><i class="icon-money"></i><b>15,152</b>
										<p class="text-muted">Profit</p>
									</a>
								</div>
							</div>
							<div class="module">
								<div class="module-head">
									<h3>Todos os usuários</h3>
								</div>
								<div class="module-body table">
									<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped  display"
										width="100%">
										<thead>
											<tr>
												<th>ID</th>
												<th>Nome</th>
												<th>Sobrenome</th>
												<th>Cargo</th>
												<th>Último acesso</th>
											</tr>
										</thead>
										<tbody>
										<!-- aqui fica uma lista breve de usuários registrados -->
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<footer>
			<?php require_once('includes/footer.php') ?>
		</footer>
	</body>
</html>
