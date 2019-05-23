<?php
namespace fiscalizape\model;

class Href {
	private $root;
	private $carregar;

	public function __construct($caminho = '', $arquivo = '') {
		$this->root = str_replace("\\", "/", __DIR__);
		if ($caminho <> '' && $arquivo <> '') {
			$this->load($caminho, $arquivo);
		}
	}

	public function load($caminho, $arquivo, $msg = '') {
		// Se um dos paremetros forem array, retornamos false.
		if (is_array($caminho) || is_array($arquivo)) {
			return false;
		}

		// Se hover mensagem adicionamos ela
		if ($msg != '') {
			return $this->carregar = $this->root . '/' . $caminho . '/' . $arquivo . '.php?' + $msg;
		}

		return $this->carregar = $this->root . '/' . $caminho . '/' . $arquivo . '.php';
	}
}