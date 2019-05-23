function readUrl(input) {
	var divImagensObra = document.getElementById("div-imagens-obra");
	var adicionarNovaImagem = document.getElementById("adicionar-nova-imagem");

	if (input.files && input.files[0]) {
		for (var x = 0; x < input.files.length; x++) {
			var reader = new FileReader();
			reader.onload = function(e) {
				var figure = document.createElement("figure");
				figure.className = "figure";

				var novaImagem = document.createElement("img");
				novaImagem.src = e.target.result;
				novaImagem.className = "rounded mr-2 imagem-remover";

				figcaption = document.createElement("figcaption");
				figcaption.className = "figure-caption";
				figcaption.style = "text-align: center";
				figcaption.innerHTML = "Remover <i class=\"fas fa-times\"></i>&nbsp;&nbsp;&nbsp;";

				linkRemover = document.createElement("a");
				linkRemover.className = "link-remover";
				linkRemover.href = "javascript:void(0)";
				linkRemover.style = "text-decoration: none;";
				linkRemover.appendChild(figcaption);

				figure.appendChild(novaImagem);
				figure.appendChild(linkRemover);

				divImagensObra.appendChild(figure);
				divImagensObra.appendChild(adicionarNovaImagem);

				linkRemover.addEventListener("click", function() {
					figure.parentNode.removeChild(figure);
				});
			}

			reader.readAsDataURL(input.files[x]);
		}
	}
}