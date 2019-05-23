<?php
require_once '../controller/verificarPreLogin.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title> (Admin) Login - FiscalizaPE </title>
    </head>
    <body>
        <form action="../controller/permitirAcesso.php" method="post">
            <input type="text" name="email" placeholder="Digite seu email">
            <input type="password" name="senha" placeholder="Digite sua senha">
            <input type="submit">
        </form>
    </body>
</html>