function atualizarCidade() {
	var cidadeId = document.getElementById("cidadeId");
	var cidadeIdText = cidadeId.selectedOptions[0].innerText;
	var cidadeNome = document.getElementById("cidade");

	if (cidadeId.value != "-1") {
		cidadeNome.disabled = true;
		cidadeNome.value = cidadeIdText;
	} else {
		cidadeNome.disabled = false;
	}
}