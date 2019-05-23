<!-- INICIO footer -->
<footer class="footer mt-auto py-3 bg-dark">
	<div style="margin-left: 20px;">
		<span style="color: white;">&copy; FiscalizaPE 2018. Todos os direitos reservados.</span>
	</div>
</footer>
<!-- FIM footer -->

<!-- JS, JQUARY -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<?php
	if ($sessao->estaLogado()) {
		if (isset($_GET['login'])) {
			echo "<script>$('#modalSucesso').modal('show')</script>";
		}
	}
?>