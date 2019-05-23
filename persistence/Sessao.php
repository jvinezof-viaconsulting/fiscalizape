<?php
namespace fiscalizape\persistence;
new \fiscalizape\Autoload("model", "Usuario");

use \fiscalizape\model\Usuario;

class Sessao {
    public function __construct() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }

    public function estaLogado() {
        if (isset($_SESSION['logado'])) {
            return true;
        } else {
            return false;
        }
    }

    public function getSessaoUsuario() {
        if ($this->estaLogado()) {
            return unserialize($_SESSION['usuario']);
        }
    }

    public function atualizarSessaoUsuario($usuario) {
        $_SESSION['usuario'] = serialize($usuario);
    }

    public function destruirSessao() {
        session_unset();
        session_destroy();
    }
}

