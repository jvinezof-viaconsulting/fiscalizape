function apagarImagem(check) {
	imagem = check.parentNode.children[0].children[0];
	if (confirm('Tem certeza que deseja excluir está foto?')) {
		imagem.parentNode.removeChild(imagem);
		check.style = 'display: none;'
		check.checked = true;
	} else {
		check.checked = false;
	}
}

function readURL(input) {
	divImagens = document.getElementById('imagensDiv');

	if (input.files && input.files[0]) {
		for (var x = 0; x < input.files.length; x++) {
			var reader = new FileReader();
			reader.onload = function(e) {
				// Div card
				var divCard = document.createElement('div');
				divCard.className = 'card';

				// Checkbox que exlclui a imagem
				var checkbox = document.createElement('input');
				checkbox.type = 'checkbox';
				checkbox.className = "form-check-input checkboxTemp";

				// Link que amplia
				var a = document.createElement('a');
				a.href = e.target.result;

				// Atributo que aplia
				var toggle = document.createAttribute('data-toggle');
				toggle.value = 'lightbox';
				a.setAttributeNode(toggle);

				// Define a galeria que a imagem pertence
				var galeria = document.createAttribute('data-gallery');
				galeria.value = 'imagensObra';
				a.setAttributeNode(galeria);

				// Imagem
				var imagem = document.createElement('img');
				imagem.src = e.target.result;
				imagem.className = 'img-fluid img-para-excluir';
				imagem.title = 'Clique para ampliar';

				divImagens.appendChild(divCard);
				a.appendChild(imagem);
				divCard.appendChild(a);
				divCard.appendChild(checkbox);

				checkbox.addEventListener('click', function() {
					apagarImagem(checkbox);
				});
			}

			reader.readAsDataURL(input.files[x]);
		}
	}
}