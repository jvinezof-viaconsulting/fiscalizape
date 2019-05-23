function mostrarEsconderEnd() {
	var divEndereco = document.getElementById("divEndereco");
	var divCep = document.getElementById("divCep");

	if (divEndereco.hidden == true) {
		divEndereco.hidden = false;
		divCep.hidden = true;
	} else {
		divEndereco.hidden = true;
		divCep.hidden = false;
	}
}