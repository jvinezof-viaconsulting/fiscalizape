function mostrar(icone, div) {
	div.style.display = 'block';
	icone.classList.remove("fa-caret-down");
	icone.classList.add("fa-caret-up");
}

function esconder(icone, div) {
	div.style.display = 'none';
	icone.classList.remove("fa-caret-up");
	icone.classList.add("fa-caret-down");
}

function mudarEstado(icone) {
	var div = document.getElementById("informacoes-opcionais");

	if (div.style.display == 'none') {
		mostrar(icone, div);
	} else {
		esconder(icone, div);
	}
}