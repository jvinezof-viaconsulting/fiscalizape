<?php
namespace fiscalizape\model;

class Erros {
	private $dono;
	private $nome;
	private $path;
	private $erros;
	private $validade;

	/**
	 * Construtor que inicia as configurações de erros
	 *
	 * @param string $dono Nome da pagina em que o cookie será visível, SEM a extensão.
	 * @param int $validade Tempo em segundos em que a pagina irá expirar.
	*/
	public function __construct($dono, $validade) {
		$this->dono = $dono;
		$this->nome = "array_erros_" . $this->dono;
		$this->path = "/fiscalizape/view/" . $this->dono . ".php";
		$this->setValidade($validade);
		if (!$this->existeCookie()) {
			$this->erros = array();
		} else {
			$this->erros = unserialize($_COOKIE[$this->nome]);
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
	 * Define os erros e, por padrão, depois salva o cookie.
	 *
	 * @param string[] $erros Vetor de strings contendo os erros.
	 * @param boolean $salvar (Opcional, default: TRUE) Se definido como True salva os cookies após definir os erros.
	*/
	public function setErros($erros, $salvar = true) {
		if (is_array($erros)) {
			$this->erros = $erros;

			if ($salvar) {
				$this->salvarCookie();
			}
		}
	}

	public function getErros() {
		return $this->erros;
	}

	/**
	 * Esta função pode utilizar setcookie por isso deve ser utilizada antes de qualquer saida.
	 *
	 * @param boolean $apagar (opcional, default: true) Define se o cookie será apagado depois de capturado.
	 *
	 * @return mix[] array contendo todos os erros.
	*/
	public function getCookie($apagar = true) {
		if ($this->existeCookie()) {
			if ($apagar) {
				$this->apagarCookie();
			}

			for ($i = 0; $i < count($_COOKIE[$this->nome]); $i++) {
				$this->erros[$i] = filter_var($this->erros[$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			}

			return $this->erros;
		}

		return $this->erros;
	}

	/**
	 * Verifica se existe algum cookie de erros já criado e
	 *
	 * @return boolean indica se existe ou não o cookie.
	*/
	public function existeCookie() {
		if (isset($_COOKIE[$this->nome])) {
			$erros = unserialize($_COOKIE[$this->nome]);
			if (is_array($erros)) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Salvar um cookie com o array erros.
	*/
	public function salvarCookie() {
		setcookie($this->nome, serialize($this->erros), $this->validade, $this->path);
	}

	/**
	 * Apaga o cookie criado.
	*/
	public function apagarCookie() {
		setcookie($this->nome, '', time()-1, $this->path);
	}

	/**
	 * Adiciona um erro no array erros e em seguida salva o cookie.
	 *
	 * @param string $erro Mensagem do erro que será exibida.
	*/
	public function adicionarErro($erro) {
		array_push($this->erros, $erro);
		$this->salvarCookie();
	}

	/**
	 * Gera e imprime a mensagem que será exibida, contendo todo o html.
	*/
	public function gerarMensagem($erros) {
		for($i = 0; $i < count($erros); $i++) {
			echo '<div title="Erro!" class="alert alert-danger alert-dismissible fade show" role="alert"><i class="fas fa-exclamation-circle"></i> <span>'
				. $erros[$i] .
				'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true" title="Fechar">&times;</span>
				</button>
			</div>';
		}
	}
}