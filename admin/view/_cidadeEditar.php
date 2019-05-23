<?php
require_once '../util/config.php';
new \fiscalizape\Autoload('persistence', 'DaoCidade');
use \fiscalizape\persistence\DaoCidade;

$id = filter_input(INPUT_GET, 'h', FILTER_SANITIZE_SPECIAL_CHARS);

if(empty($id)) {
    header('Location: ../view/cidadeListar.php?selecioneUmaCidadeParaEditar');
    exit;
}

$daoCidade = new DaoCidade();
$cidade = $daoCidade->procurarCidade($id);

if ($cidade->getId() == NULL) {
    header('Location: ../view/cidadeListar.php?cidadeInvalida');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FiscalizaPE - Atualizar (admin)</title>
</head>
<body>
    <h2>Atualizar Cidade:</h2>
    <p>Entre com os dados <b>novos</b> de <b><?php echo $cidade->getNome() ?></b></p>
    <form method="post" action="../controller/atualizarCidade.php">
            <input type="text" name="id" hidden="true" value="<?php echo $cidade->getId(); ?>">
            <label>Nome</label>
            <input type="text" name="cidade" placeholder="Digite o nome da cidade" value="<?php echo $cidade->getNome(); ?>">
            <br> <br>

            <label>Estado</label>
            <select name="estado">
                <option value="" disabled hidden <?php echo $cidade->getEstado() == "" ? 'selected' : ''; ?>>Escolha um estado</option>
				<option value="PE" <?php echo $cidade->getEstado() == "PE" ? 'selected' : ''; ?>>Pernambuco</option>
            </select>
            <br> <br>

            <label>Area</label>
            <input type="text" name="area" min="0" max="159.533.328" placeholder="ex: 218,435 (recife)" onkeyup="mascara('###,###,###', this, event, true)" value="<?php echo $cidade->getArea() ?>">
            <br> <br>

            <label>População</label>
            <input type="text" name="populacao" min="0" placeholder="ex: 1,637,834 (recife)" onkeyup="mascara('###,###,###', this, event, true)" value="<?php echo $cidade->getPopulacao() ?>">
            <br> <br>

            <label>Prefeito</label>
            <input type="text" name="prefeito" placeholder="Digite o nome do prefeito" value="<?php echo $cidade->getPrefeito() ?>">
            <br> <br>

            <input type="submit" name="Enviar">
    </form>

    <!-- Mascara JS -->
    <script src="./js/mascara.min.js"></script>
</body>
</html>