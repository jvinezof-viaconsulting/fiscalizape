var cpfInput = document.getElementById("cpf");
var cpfNovoValor;

cpfInput.addEventListener("keyup", function(){
	var cpfNovoValor = cpfInput.value.replace(/\D/g,""); // Remove letras e espaços em branco.
	cpfNovoValor = cpfInput.value.replace(/(\d{3})(\d)/,"$1.$2"); // Insere os pontos de 3 e 3 caracteres.
	cpfNovoValor = cpfInput.value.replace(/(\d{3})(\d)/,"$1.$2");
        cpfNovoValor = cpfInput.value.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
	cpfInput.value = cpfNovoValor;
});