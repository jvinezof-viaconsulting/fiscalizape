<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta charset="utf-8">

<!-- Favicon -->
<link rel="icon" type="imagem/jpg" href="img/favicon.jpg" />

<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">

<!-- CSS Carrossel --->
<link rel="stylesheet" type="text/css" href="css/carrossel.css?<?php echo rand(0, 999999) ?>">

<!-- Alguns estilos das páginas -->
<link href="css/style.css?<?php echo rand(0, 999999) ?>" rel="stylesheet">

<?php
	require_once '../Autoload.php';
	$load = new \fiscalizape\Autoload();
	$load->load('util', 'paginaAnterior');
?>