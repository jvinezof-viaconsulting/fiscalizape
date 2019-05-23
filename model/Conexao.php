<?php
namespace fiscalizape\model;

abstract class Conexao {
    protected $pdo;

    # Conecta com o banco de dados
    protected function conectar() {
        try {
            $this->pdo = new \PDO('mysql: host=localhost;dbname=fiscalizape;charset=UTF8', 'root', '');
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (\PDOException $ex) {
            echo 'Erro: ' . $ex->getMessage();
        }
    }
}