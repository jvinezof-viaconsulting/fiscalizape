<?php
namespace fiscalizape\model;

class Cidade {
    private $id;
    private $nome;
    private $estado;
    private $area;
    private $populacao;
    private $prefeito;
    
    function __construct($id, $nome, $estado, $area, $populacao, $prefeito) {
        $this->id = $id;
        $this->nome = $nome;
        $this->estado = $estado;
        $this->area = $area;
        $this->populacao = $populacao;
        $this->prefeito = $prefeito;
    }

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEstado() {
        return $this->estado;
    }

    function getArea() {
        return $this->area;
    }

    function getPopulacao() {
        return $this->populacao;
    }

    function getPrefeito() {
        return $this->prefeito;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEstado($estado) {
        $this->estado = $estado;
    }

    function setArea($area) {
        $this->area = $area;
    }

    function setPopulacao($populacao) {
        $this->populacao = $populacao;
    }

    function setPrefeito($prefeito) {
        $this->prefeito = $prefeito;
    }
}