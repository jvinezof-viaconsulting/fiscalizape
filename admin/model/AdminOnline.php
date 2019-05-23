<?php
namespace fiscalizape\admin\model;

class AdminOnline {
    private $id;
    private $idUsuario;
    private $dataLogin;
    private $ip;

    public function __construct($id, $idUsuario, $dataLogin, $ip) {
        $this->id = $id;
        $this->idUsuario = $idUsuario;
        $this->dataLogin = $dataLogin;
        $this->ip = $ip;
    }


    public function getId() {
        return $this->id;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function getDataLogin() {
        return $this->dataLogin;
    }

    public function getIp() {
        return $this->ip;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function setDataLogin($dataLogin) {
        $this->dataLogin = $dataLogin;
    }

    public function setIp($ip) {
        $this->ip = $ip;
    }
}

