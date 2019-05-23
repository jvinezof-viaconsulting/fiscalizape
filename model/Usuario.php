<?php
namespace fiscalizape\model;

class Usuario {
	private $id;
	private $status;
	private $nome;
	private $sobrenome;
	private $cpf;
	private $nomeUsuario;
	private $email;
	private $emailPendente;
	private $emailAtivado;
	private $token;
	private $cargo;
	private $registroData;
	private $registroIP;
	private $ultimoAcesso;
	private $ultimoIP;
	private $online;
	private $foto;
	private $verificado;
	private $estado;
	private $cidade;
	private $cep;

	/**
	 * Contrutor da classe Usuario, possui campos opcionais, mas <b>jamais usar, sempre definir todos os atributos</b>
	 *
	*/
	public function __construct($nome='', $sobrenome='', $cpf='', $nomeUsuario='', $email='', $emailPendente='', $emailAtivado='', $cargo='', $registroData='', $registroIP='', $ultimoAcesso='', $ultimoIP='', $online='', $foto='', $estado='', $cidade='', $cep='') {
		$this->nome = $nome;
		$this->sobrenome = $sobrenome;
		$this->cpf = $cpf;
		$this->nomeUsuario = $nomeUsuario;
		$this->email = $email;
		$this->email_pendente = $emailPendente;
		$this->emailAtivado = $emailAtivado;
		$this->cargo = $cargo;
		$this->registroData = $registroData;
		$this->registroIP = $registroIP;
		$this->ultimoAcesso = $ultimoAcesso;
		$this->ultimoIP = $ultimoIP;
		$this->online = $online;
		$this->foto = $foto;
		$this->estado = $estado;
		$this->cidade = $cidade;
		$this->cep = $cep;
	}

	public function construtor($id, $nome, $sobrenome, $cpf, $nomeUsuario, $email, $emailPendente, $emailAtivado, $token, $cargo, $registroData, $registroIP, $ultimoAcesso, $ultimoIP, $online, $foto, $verificado, $estado, $cidade, $cep) {
		$this->id = $id;
		$this->nome = $nome;
		$this->sobrenome = $sobrenome;
		$this->cpf = $cpf;
		$this->nomeUsuario = $nomeUsuario;
		$this->email = $email;
		$this->email_pendente = $emailPendente;
		$this->emailAtivado = $emailAtivado;
		$this->token = $token;
		$this->cargo = $cargo;
		$this->registroData = $registroData;
		$this->registroIP = $registroIP;
		$this->ultimoAcesso = $ultimoAcesso;
		$this->ultimoIP = $ultimoIP;
		$this->online = $online;
		$this->foto = $foto;
		$this->verificado = $verificado;
		$this->estado = $estado;
		$this->cidade = $cidade;
		$this->cep = $cep;
	}

	public function perfil($id, $nome, $sobrenome, $email, $registroData, $ultimoAcesso, $online, $foto, $verificado, $cep) {
		$this->id = $id;
		$this->nome = $nome;
		$this->sobrenome = $sobrenome;
		$this->email = $email;
		$this->registroData = $registroData;
		$this->ultimoAcesso = $ultimoAcesso;
		$this->online = $online;
		$this->foto = $foto;
		$this->verificado = $verificado;
		$this->cep = $cep;
	}

	public function getId() {
		return $this->id;
	}
	public function getNome() {
		return $this->nome;
	}
	public function getSobrenome() {
		return $this->sobrenome;
	}
	public function getCPF() {
		return $this->cpf;
	}
	public function getNomeUsuario() {
		return $this->nomeUsuario;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getEmailPendente() {
		return $this->email_pendente;
	}
	public function getEmailAtivado() {
		return $this->emailAtivado;
	}
	public function getToken() {
		return $this->token;
	}
	public function getCargo() {
		return $this->cargo;
	}
	public function getRegistroData() {
		return $this->registroData;
	}
	public function getRegistroIP() {
		return $this->registroIP;
	}
	public function getUltimoAcesso() {
		return $this->ultimoAcesso;
	}
	public function getUltimoIP() {
		return $this->ultimoIP;
	}
	public function getOnline() {
		return $this->online;
	}
	public function getFoto() {
		return $this->foto;
	}
	public function getVerificado() {
		return $this->verificado;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function getCidade() {
		return $this->cidade;
	}
	public function getCep() {
		return $this->cep;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function setNome($nome) {
		$this->nome = $nome;
	}
	public function setSobrenome($sobrenome) {
		$this->sobrenome = $sobrenome;
	}
	public function setCPF($cpf) {
		$this->cpf = $cpf;
	}
	public function setNomeUsuario($nomeUsuario) {
		$this->nomeUsuario = $nomeUsuario;
	}
	public function setEmail($email) {
		$this->email = $email;
	}
	public function setEmailPendente($email_pendente) {
		$this->email_pendente = $email_pendente;
	}
	public function setEmailAtivado($emailAtivado) {
		$this->emailAtivado = $emailAtivado;
	}
	public function setSenha($senha) {
		$this->senha = $senha;
	}
	public function setCargo($cargo) {
		$this->cargo = $cargo;
	}
	public function setRegistroData($registroData) {
		$this->registroData = $registroData;
	}
	public function setRegistroIP($registroIP) {
		$this->registroIP = $registroIP;
	}
	public function setUltimoAcesso($ultimoAcesso) {
		$this->ultimoAcesso = $ultimoAcesso;
	}
	public function setUltimoIP($ultimoIP) {
		$this->ultimoIP = $ultimoIP;
	}
	public function setOnline($online) {
		$this->online = $online;
	}
	public function setFoto($foto) {
		$this->foto = $foto;
	}
	public function setEstado($estado) {
		$this->estado = $estado;
	}
	public function setCidade($cidade) {
		$this->cidade = $cidade;
	}
	public function setCep($cep) {
		$this->cep = $cep;
	}
}