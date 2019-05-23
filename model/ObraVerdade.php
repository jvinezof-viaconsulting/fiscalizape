<?php
namespace fiscalizape\model;

class ObraVerdade {
	private $id;
	private $usuario; // Objeto Usuario;
	private $voto; // 0 = Mentira, 1 = Verdade;
	private $criadoEm;

	public function __construct($id, $usuario, $voto, $criadoEm) {
		$this->id = $id;
		$this->usuario = $usuario;
		$this->voto = $voto;
		$this->criadoEm = $criadoEm;
	}

	/*
	 * Getters
	*/

	public function getId() {
		return $this->id;
	}

	public function getUsuario() {
		return $this->usuario;
	}

	public function getVoto() {
		return $this->voto;
	}

	public function getCriadoEm() {
		return $this->criadoEm;
	}

	/*
	 * Setters
	*/

   public function setId($id) {
	   $this->id = $id;
   }

   public function setUsuario($usuario) {
	   $this->usuario = $usuario;
   }

   public function setVoto($voto) {
	   $this->voto = $voto;
   }

   public function setCriadoEm($criadoEm) {
	   $this->criadoEm = $criadoEm;
   }

}