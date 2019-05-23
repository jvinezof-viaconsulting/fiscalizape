<?php
namespace fiscalizape\admin\persistence;

require_once '../../Autoload.php';
new \fiscalizape\Autoload(["persistence", "util", "admin/model", "admin/model", "admin/persistence"], ["DaoConexao", "Util", "ControleDeAcesso", "AdminOnline", "Log"]);

use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\admin\model\ControleDeAcesso;
use \fiscalizape\admin\model\AdminOnline;
use \fiscalizape\admin\persistence\Log;
use \fiscalizape\util\Util;

class DaoAdminOnline {
    private $adminOnline;
    private $conexao;
    private $controle;
    private $log;
    
    public function __construct() {
        $this->conexao = new DaoConexao();
        $this->controle = new ControleDeAcesso("../../view/index.php");
        $this->log = new Log();
    }
    
    public function getAdminOnline() {
        return serialize($this->adminOnline);
    }
    
    private function selecionarUsuarios($coluna, $email) {
        return $this->conexao->selecionar($coluna, "usuarios", "usuario_email = {$email}")->fetch(PDO::FETCH_ASSOC);
    }
    
    public function adminLogin($email, $senha) {
        $result = $this->selecionarUsuarios("usuario_email", $email);
        if (count($result) == 1) {
            $util = new Util();
            $result = $this->selecionarUsuarios("usuario_senha", $email);
            if ($util->verificarHash($senha, $result['usuario_senha'])) {
                
            }
        } else {
            // NÃO PODE RETORNAR MAIS QUE UMA LINHA
        }
    }
    
    /*
    public function inserirSessaoNoBancoDeDados($email, $senha) {
        // Verificando se o email está correto
        $resultado = $this->conexao->selecionar("usuario_email", "usuarios", "usuario_email = {$email}")->fetch(PDO::FETCH_ASSOC);
        
        // Se resultado retornou alguma linha
        if (count($resultado) == 1) {
            $resultado = $this->conexao->selecionar("usuario_senha", "usuarios", "usuario_email = {$email}")->fetch(PDO::FETCH_ASSOC);
            $util = new Util();
            
            // Verificamos a senha
            if ($util->compararHash($senha, $resultado['usuario_senha'])) {
                $resultado = $this->conexao->selecionar("id", "usuarios", "usuario_email = {$email}")->fetch(PDO::FETCH_ASSOC);
                if ($controle->acessoNivelB($resultado['usuario_id'])) {
                    // Deu tudo certo, inserimos no banco de dados que este admin está online
                    $data = $util->dateTimeRecife();
                    $this->conexao->inserir("admin_onlines", "id_usuario, data_login, ip", [$resultado['usuario_id'], $data, $util->getUserIP()]);
                    $dados = $this->conexao->selecionar("*", "admin_onlines", "data_login = {$data}")->fetch(PDO::FETCH_ASSOC);
                    if (count($verificacao) > 0) {
                        // Inserimos
                        $this->adminOnline = new AdminOnline($dados['id'], $dados['id_usuario'], $dados['data_login'], $dados['ip']);
                        return true;
                    } else {
                        // Não inserimos
                        return false;
                    }
                }
            }
        }
    }
    */
}