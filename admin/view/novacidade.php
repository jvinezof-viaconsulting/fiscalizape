<?php
require_once '../util/config.php';	
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FiscalizaPE - Nova Cidade (admin)</title>
</head>
<body>
	<h2>Nova Cidade:</h2>
	<p>Entre com os dados da nova cidade</p>
	<form method="post" action="../controller/incluirCidade.php">
		<label>Nome</label>
		<input type="text" name="cidade" placeholder="Digite o nome da cidade"> 
		<br> <br>

		<label>Estado</label>
		<select name="estado">
			<option value="PE">Pernambuco</option> 
		</select>
		<br> <br>

		<label>Area</label>
		<input type="number" name="area" placeholder="Somente números">
		<br> <br>

		<label>População</label>
		<input type="number" name="populacao" placeholder="Somente números">
		<br> <br>

		<label>Prefeito</label>
		<input type="text" name="prefeito" placeholder="Digite o nome do prefeito">
		<br> <br>

		<input type="submit" name="Enviar">
	</form>
</body>
</html>