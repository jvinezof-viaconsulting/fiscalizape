<?php
namespace fiscalizape\admin\persistence;

new \fiscalizape\Autoload(array("util", "persistence"), array("Util", "DaoConexao"));

use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\util\Util;

class Log {
    private $conexao;
    private $ip;
    
   public function __construct() {
        $util = new Util();
        
        $this->conexao = new DaoConexao();
        $this->ip = $util->getUserIp();
   }
   
   public function logPersonalizado($tabela, $colunas, $mensagem) {
       $this->conexao->inserir($tabela, $colunas, [$this->ip, $mensagem]);
   }
   
   public function logEmailDiferente($emailLogado, $novoEmailLogado) {
       $mensagem = "Houve uma tentativa de login na admistração com um email diferente do previamente logado. o email já logado era: " . $emailLogado
               . " o email escrito na tentativa de login foi: " . $novoEmailLogado;
       $this->conexao->inserir("admin_login_log", "ip, mensagem", array($this->ip, $mensagem));
   }
   
    public function logUsuarioSemNivelDeAcesso() {
        $mensagem = "Usuario que não é adminstrador tentou fazer login";
        $this->conexao->inserir("admin_login_log", "ip, mensagem", array($this->ip, $mensagem));
    }
    
    public function logLoginRealizado($id) {
        $this->conexao->inserir("admin_onlines", "id_usuario, ip", [$id, $this->ip]);
    }
}

