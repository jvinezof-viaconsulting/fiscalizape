<?php
namespace fiscalizape\model;

new \fiscalizape\Autoload(['persistence', 'admin/model', 'model'], [ ['DaoConexao', 'Sessao'], 'Log', ['Erros', 'Avisos'] ]);

use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\admin\model\Log;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\model\Erros;
use \fiscalizape\model\Avisos;

/**
* <b>CLASSE DE CONTROLE DE ACESSO<b>
*
* Esta classe controla quem pode acessar determinadas coisas.
* O nível mais baixo é o A que tem todos os acessos possíveis,
* e vai aumentando conforme necessidade, pode também existir niveis personalizados
*
*/
class ControleDeAcesso {
	private $escape;
	private $conexao;
	private $log;
	private $pesquisa;
	private $erros;

	/**
	 * @deprecated 0.1.0 Não usar setar escape, estar em desuso
	*/
	public function __construct($escape='') {
		$this->escape = $escape;
		$this->conexao = new DaoConexao();
		$this->log = new Log();
	}

	public function setEscape($escape) {
		$this->escape = $escape;
	}

	private function pesquisar($id) {
		return $this->conexao->selecionar(['usuario_cargo'], 'usuarios', "md5(usuario_id) = ?", [$id])->fetch(\PDO::FETCH_ASSOC);
	}

	public function acessoAdministrativo($id) {
		if ($this->acessoNivelA($id) || $this->acessoNivelB($id)) {
			return true;
		}

		return false;
	}

	public function acessoUsuario() {
		$sessao = new Sessao();
		if ($sessao->estaLogado()) {
			return true;
		}

		return false;
	}

	public function acessoNivelA($id) {
		$this->pesquisa = $this->pesquisar($id);
		if ($this->pesquisa['usuario_cargo'] == 'A') {
	        #$this->log->logLoginRealizado($id);
			return true;
		} else {
	        #$this->log->logUsuarioSemNivelDeAcesso();
			return false;
		}
	}

	public function acessoNivelB($id) {
		$this->pesquisa = $this->pesquisar($id);
		if ($this->pesquisa['usuario_cargo'] == 'B') {
	        #$this->log->logLoginRealizado($id);
			return true;
		} else {
	        #$this->log->logUsuarioSemNivelDeAcesso();
			return false;
		}
	}

	public function permitirUsuario($retorno) {
		if (!$this->acessoUsuario()) {
			setcookie("paginaVoltarx2", serialize($retorno), time()+60*10, '/');

			$objAvisos = new Avisos('login', 60);
			$objAvisos->adicionarAviso('Faça o login para ter acesso a pagina, você será levado de volta a pagina anterior.');

			header('location: login.php');
			exit;
		}
	}

	public function bloquearAcesso($retorno) {
		// Não podemos salvar cookie com a string =, então se tiver removemos para salvar o cookie.
		if (strpos($retorno, '?') !== FALSE) {
			$semIgual = explode('?', $retorno);
			$semIgual = $semIgual[0];
		} else {
			$semIgual = $retorno;
		}

		$objAvisos = new Avisos('login', 60);
		$objAvisos->adicionarAviso('Faça o login para ter acesso a pagina, você será levado de volta a pagina anterior.');

	}
}