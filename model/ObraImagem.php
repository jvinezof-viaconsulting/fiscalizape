<?php
namespace fiscalizape\model;

class ObraImagem {
	private $id;
	private $imagem;

	public function __construct($id, $imagem) {
		$this->id = $id;
		$this->imagem = $imagem;
	}

	public function getId() {
		return $this->id;
	}

	public function getImagem() {
		return $this->imagem;
	}
}