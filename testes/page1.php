<?php
require './classeExemplo.php';

$teste = new Exemplo(5, 2);
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form action="page2.php" method="post">
		<input type="checkbox" name="teste[]" value="1">
		<input type="checkbox" name="teste[]" value="2">
		<input type="checkbox" name="teste[]" value="3">
		<input type="submit" name="e">
	</form>
</body>
</html>