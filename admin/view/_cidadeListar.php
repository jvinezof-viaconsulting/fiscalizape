<?php
require_once '../util/config.php';
new \fiscalizape\Autoload('persistence', 'DaoCidade');

use \fiscalizape\persistence\DaoCidade;

$daoCidade = new DaoCidade();
$cidades = $daoCidade->listarCidades();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>FiscalizaPE - Listar Cidades (admin)</title>
</head>
<body>
    <table>
        <tr>
            <th>ID</th>
            <th>Cidade</th>
            <th>Estado</th>
            <th>Area</th>
            <th>População</th>
            <th>Prefeito</th>
            <th>Editar</th>
            <th>Excluir</th>
        </tr>
        <?php 
            for ($i = 0; $i < count($cidades); $i++) {
                $cidadeAtual = $cidades[$i];
        ?>
        <tr>
            <td><?php echo $cidadeAtual->getId() ?></td>
            <td><?php echo $cidadeAtual->getNome() ?></td>
            <td><?php echo $cidadeAtual->getEstado() ?></td>
            <td><?php echo $cidadeAtual->getArea() ?></td>
            <td><?php echo $cidadeAtual->getPopulacao() ?></td>
            <td><?php echo $cidadeAtual->getPrefeito() ?></td>
            <td><a href="./_cidadeEditar.php?h=<?= md5($cidadeAtual->getId()) ?>">Editar</a></td>
            <td><a href="../controller/removerCidade.php?h=<?= md5($cidadeAtual->getId()) ?>">Excluir</a></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>