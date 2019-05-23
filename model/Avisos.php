<?php
namespace fiscalizape\model;

class Avisos {
	private $dono;
	private $nome;
	private $path;
	private $avisos;
	private $validade;

	/**
	 * Construtor que inicia as configurações de avisos
	 *
	 * @param string $dono Nome da pagina em que o cookie será visível sem a extensão.
	 * @param int $validade Tempo em segundos em que a pagina irá expirar.
	*/
	public function __construct($dono, $validade) {
		$this->dono = $dono;
		$this->nome = "array_avisos_" . $this->dono;
		$this->path = "/fiscalizape/view/" . $this->dono . ".php";
		$this->setValidade($validade);
		if (!$this->existeCookie()) {
			$this->avisos = array();
		} else {
			$this->avisos = unserialize($_COOKIE[$this->nome]);
		}
	}

	/**
	 * Altera a validade dos novos cookies, só altera a validade dos cookies já criados se for chamada a função salvarCookie.
	 * Para apagar um cookie é recomendado usar a função apagarCookie.
	 *
	 * @param int $validade Número inteiro que vai ser somado com a função time();
	*/
	public function setValidade($validade) {
		if (is_int($validade)) {
			$this->validade = time() + $validade;
		} else {
			$this->validade = time() + 60;
		}
	}

	public function getValidade() {
		return $this->validade;
	}

	/**
	 * Define os avisos e, por padrão, depois salva o cookie.
	 *
	 * @param string[] $avisos Vetor de strings contendo os avisos.
	 * @param boolean $salvar (Opcional, default: TRUE) Se definido como True salva os cookies após definir os avisos.
	*/
	public function setAvisos($avisos, $salvar = true) {
		if (is_array($avisos)) {
			$this->avisos = $avisos;

			if ($salvar) {
				$this->salvarCookie();
			}
		}
	}

	public function getAvisos() {
		return $this->avisos;
	}

	/**
	 * Esta função pode utilizar setcookie por isso deve ser utilizada antes de qualquer saida.
	 *
	 * @param boolean $apagar (opcional, default: true) Define se o cookie será apagado depois de capturado.
	 *
	 * @return mix[] array contendo todos os avisos.
	*/
	public function getCookie($apagar = true) {
		if ($this->existeCookie()) {
			if ($apagar) {
				$this->apagarCookie();
			}

			for ($i = 0; $i < count($_COOKIE[$this->nome]); $i++) {
				$this->avisos[$i] = filter_var($this->avisos[$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			return $this->avisos;
		}

		return $this->avisos;
	}

	/**
	 * Verifica se existe algum cookie de avisos já criado
	 *
	 * @return boolean indica se existe ou não o cookie.
	*/
	public function existeCookie() {
		if (isset($_COOKIE[$this->nome])) {
			$this->avisos = unserialize($_COOKIE[$this->nome]);
			if (is_array($this->avisos)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Salvar um cookie com o array avisos.
	*/
	public function salvarCookie() {
		setcookie($this->nome, serialize($this->avisos), $this->validade, $this->path);
	}

	/**
	 * Apaga o cookie criado.
	*/
	public function apagarCookie() {
		setcookie($this->nome, '', time()-1, $this->path);
	}

	/**
	 * Adiciona um aviso no array avisos e em seguida salva o cookie.
	 *
	 * @param string $aviso Mensagem do aviso que será exibida.
	*/
	public function adicionarAviso($aviso) {
		array_push($this->avisos, $aviso);
		$this->salvarCookie();
	}

	/**
	 * Gera e imprime a mensagem que será exibida, contendo todo o html.
	*/
	public function gerarMensagem($avisos) {
		for($i = 0; $i < count($avisos); $i++) {
			echo '<div title="aviso!" class="alert alert-warning alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-triangle"></i> <span>'
				. $avisos[$i] .
				'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true" title="Fechar">&times;</span>
				</button>
			</div>';
		}
	}
}