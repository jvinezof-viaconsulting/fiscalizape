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
                <option value="" disabled selected hidden>Escolha um estado</option>
                <option value="PE">Pernambuco</option> 
            </select>
            <br> <br>

            <label>Area</label>
            <input type="text" name="area" min="0" max="159.533.328" placeholder="ex: 218,435 (recife)" onkeyup="mascara('###,###,###', this, event, true)">
            <br> <br>

            <label>População</label>
            <input type="text" name="populacao" min="0" placeholder="ex: 1,637,834 (recife)" onkeyup="mascara('###,###,###', this, event, true)">
            <br> <br>

            <label>Prefeito</label>
            <input type="text" name="prefeito" placeholder="Digite o nome do prefeito" value="">
            <br> <br>

            <input type="submit" name="Enviar">
    </form>

    <!-- Mascara JS -->
    <script src="./js/mascara.min.js"></script>
</body>
</html>