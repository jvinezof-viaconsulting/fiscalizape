<?php
namespace fiscalizape\model;

class Obra {
	private $id;
	private $key;
	private $titulo;
	private $descricao;
	private $imagens; // Array de objetos ObraImagem
	private $dataInicioPrevista;
	private $dataFinalPrevista;
	private $dataInicio;
	private $dataFinal;
	private $situacao;
	private $orgaoResponsavel;
	private $empresaResponsavel;
	private $orcamentoPrevisto;
	private $dinheiroGasto;
	private $verdades; // Array contendo objetos verdades
	private $contribuidor; // Objeto usuario com o perfil do contribuidor
	private $cep;
	private $rua;
	private $bairro;
	private $cidade; // Objeto cidade
	private $criadoEm;

	public function __construct($id, $key, $titulo, $descricao, $imagens, $dataInicioPrevista, $dataFinalPrevista, $orcamentoPrevisto, $contribuidor, $rua, $bairro, $cidade, $criadoEm, $dataInicio = '', $dataFinal = '', $situacao = '', $orgaoResponsavel = '', $empresaResponsavel = '', $dinheiroGasto = '', $verdades = array(), $cep = '') {
		$this->id = $id;
		$this->key = $key;
		$this->titulo = $titulo;
		$this->descricao = $descricao;
		$this->imagens = $imagens;
		$this->dataInicioPrevista = $dataInicioPrevista;
		$this->dataFinalPrevista = $dataFinalPrevista;
		$this->dataInicio = $dataInicio;
		$this->dataFinal = $dataFinal;
		$this->situacao = $situacao;
		$this->orgaoResponsavel = $orgaoResponsavel;
		$this->empresaResponsavel = $empresaResponsavel;
		$this->orcamentoPrevisto = $orcamentoPrevisto;
		$this->dinheiroGasto = $dinheiroGasto;
		$this->verdades = $verdades;
		$this->contribuidor = $contribuidor;
		$this->cep = $cep;
		$this->rua = $rua;
		$this->bairro = $bairro;
		$this->cidade = $cidade;
		$this->criadoEm = $criadoEm;
	}

	/*
	 * Getters
	*/

	public function getId() {
		return $this->id;
	}

	public function getKey() {
		return $this->key;
	}

	public function getContribuidor() {
		return $this->contribuidor;
	}

	public function getCriadoEm() {
		return $this->criadoEm;
	}

	public function getCidade() {
		return $this->cidade;
	}

	public function getTitulo() {
		return $this->titulo;
	}

	public function getDescricao() {
		return $this->descricao;
	}

	public function getImagens() {
		return $this->imagens;
	}

	public function getDataInicioPrevista() {
		return $this->dataInicioPrevista;
	}

	public function getDataFinalPrevista() {
		return $this->dataFinalPrevista;
	}

	public function getDataInicio() {
		return $this->dataInicio;
	}

	public function getDataFinal() {
		return $this->dataFinal;
	}

	public function getSituacao() {
		return $this->situacao;
	}

	public function getOrgaoResponsavel() {
		return $this->orgaoResponsavel;
	}

	public function getEmpresaResponsavel() {
		return $this->empresaResponsavel;
	}

	public function getOrcamentoPrevisto() {
		return $this->orcamentoPrevisto;
	}

	public function getDinheiroGasto() {
		return $this->dinheiroGasto;
	}

	public function getVerdades() {
		return $this->verdades;
	}

	public function getCep() {
		return $this->cep;
	}

	public function getRua() {
		return $this->rua;
	}

	public function getBairro() {
		return $this->bairro;
	}

	/*
	* Setters
	*/

	public function setCidade($cidade) {
		$this->cidade = $cidade;
	}

	public function setTitulo($titulo) {
		$this->titulo = $titulo;
	}

	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}

	public function setImagens($imagens) {
		$this->imagens = $imagens;
	}

	public function setDataInicioPrevista($dataInicioPrevista) {
		$this->dataInicioPrevista = $dataInicioPrevista;
	}

	public function setDataFinalPrevista($dataFinalPrevista) {
		$this->dataFinalPrevista = $dataFinalPrevista;
	}

	public function setDataInicio($dataInicio) {
		$this->dataInicio = $dataInicio;
	}

	public function setDataFinal($dataFinal) {
		$this->dataFinal = $dataFinal;
	}

	public function setSituacao($situacao) {
		$this->situacao = $situacao;
	}

	public function setOrgaoResponsavel($orgaoResponsavel) {
		$this->orgaoResponsavel = $orgaoResponsavel;
	}

	public function setEmpresaResponsavel($empresaResponsavel) {
		$this->empresaResponsavel = $empresaResponsavel;
	}

	public function setOrcamentoPrevisto($orcamentoPrevisto) {
		$this->orcamentoPrevisto = $orcamentoPrevisto;
	}

	public function setDinheiroGasto($dinheiroGasto) {
		$this->dinheiroGasto = $dinheiroGasto;
	}

	public function setVerdades($verdades) {
		$this->verdades = $verdades;
	}

	public function setCep($cep) {
		$this->cep = $cep;
	}

	public function setRua($rua) {
		$this->rua = $rua;
	}

	public function setBairro($bairro) {
		$this->bairro = $bairro;
	}
}