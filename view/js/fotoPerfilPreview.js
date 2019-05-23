function readUrl(input) {
	if (input.files && input.files[0]) {
		var img = document.getElementById("fotoPerfil");
		var reader = new FileReader();
		reader.onload = function(e) {
			img.src = e.target.result;
		}

		reader.readAsDataURL(input.files[0]);
	}
}