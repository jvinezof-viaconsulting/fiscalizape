<!DOCTYPE html>
<html>
<head>
	<!-- Configurações -->
	<?php require_once "includes/head.php"; ?>

	<title>Sucesso</title>
</head>
<body>
    <!-- NAVBAR -->
    <?php require_once "includes/navbar.php"; ?>

    <header>
            <!-- CARROSSEL -->
            <?php require_once "includes/carrossel.php"; ?>
    </header>

    <?php
        if ($usuario->getEmailAtivado() == 1) {
            header('Location: ../view/index.php?jaAtivou');
            exit();
        }
    ?>
        
    <main role="main">
        <div class="container mt-3 mb-5">
            <div class="row">
                <div class="col-12 col-md-8">
                    <div class="text-center">
                        <div class="float-left text-success m-3">
                            <i class="far fa-check-circle fa-9x"></i>
                        </div>

                        <h2 class="text-success">Sucesso!</h2>	
                        <h3 class="text-secondary">Olá, <?php echo $usuario->getSobrenome() ?>.</h3>
                        <p class="lead text-justify">Obrigado por se cadastrar no nosso site. Enviamos um email de confirmação para "<?php echo $usuario->getEmail();  ?>" entre no seu email e confirme seu cadastro. Faça você um Pernambuco melhor!</p>
                    </div>

                    <div class="text-center">
                        <form action="../controller/emailReEnviarConfirmacao.php" method="post">
                            <label class="d-inline" for="reenviar">Re-enviar email:</label>
                            <input type="hidden" value="1" name="confirmacao">
                            <input class="form-control col-6 d-inline" type="email" name="novoEmail">
                            <input class="btn btn-primary mb-1" type="submit" value="reenviar">
                        </form>
                    </div>

                    <br>
                    <span class="text-secondary">O email pode demorar alguns minutos pra chegar</span>
                </div>										

                <div class="col-6 col-md-4">
                    <h3>Publicidade</h3>
                    <hr>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <?php require_once "includes/footer.php" ?>
</body>
</html>