<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<form action="../controller/incluirErro.php" method="post" id="form">
		<input type="text" name="prefixo" id="prefixo" hidden="true">

		<label for="gravidade">Gravidade:</label>
		<select name="gravidade" id="gravidade">
			<option value="00">Mais Grave</option>
			<option value="01">Mediano</option>
			<option value="02">Menos Grave</option>
		</select> <br><br>

		<label for="Visibilidade">Visibilidade:</label>
		<select name="visibilidade" id="visibilidade">
			<option value="00">Somente fundadores</option>
			<option value="01">Administradores</option>
			<option value="02">Moderadores</option>
			<option value="03">Usuarios</option>
		</select> <br><br>

		<label for="categoria">Categoria</label>
		<select name="categoria" id="categoria">
			<option value="00">Login</option>
			<option value="01">Registro</option>
			<option value="02">Incluir Usuario</option>
		</select> <br>
		<a href="#">Adicionar nova categoria</a> <br> <br>

		<label for="descricao">Descrição</label> <br>
		<textarea name="descricao" id="descricao" cols="30" rows="10"></textarea> <br>

		<input type="submit" value="Enviar">
	</form>

	<script>
		var form = document.getElementById("form");
		form.addEventListener("submit", function(){
			var prefixo = document.getElementById("prefixo");
			var opcoes = document.getElementsByTagName("select");
			var gravidade = opcoes[0].value;
			var visibilidade = opcoes[1].value;
			var categoria = opcoes[2].value;
			prefixo.value = gravidade + visibilidade + categoria;
			alert(prefixo.value);
		});
	</script>
</body>
</html>