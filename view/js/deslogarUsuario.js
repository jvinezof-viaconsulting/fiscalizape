var linkSair = document.getElementById('link-sair');
linkSair.addEventListener("click", function(event) {
    if(confirm('Tem certeza que deseja sair?')) {
        linkSair.href = "./sair.php";
    } else {
        // Verificando se o browser tem suporte a preventDefault
        if (event.preventDefault) {
            event.preventDefault();
        } else {
            return false;
        }
    }
});