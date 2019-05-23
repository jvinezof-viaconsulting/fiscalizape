<?php
namespace fiscalizape\persistence;
new \fiscalizape\Autoload(["persistence", "model", "util", "persistence"], ["DaoConexao", "Usuario", "Util", "Sessao"]);

use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\model\Usuario;
use \fiscalizape\util\Util;
use \fiscalizape\persistence\Sessao;

class DaoUsuario {
    // Variavel que vai se conectar no bd para aplicar algumas ações
    private $conexao;

    // Objeto usuario
    private $usuario;

    // Retorno da conexão
    private $dados;

    private $util;

    public function getUsuario() {
        return serialize($this->usuario);
    }

	public function __construct() {
		// Conectado com o banco de dados
		$this->conexao = new DaoConexao();
		$this->util = new Util();
	}

    private function setStatusOnline($email) {
        $tempIP = $this->util->getUserIP();
        $this->conexao->atualizar('usuarios', ['usuario_online', 'usuario_ultimo_acesso', 'usuario_ultimo_ip'], [1, $tempIP, 'CURRENT_TIMESTAMP'], "usuario_email = ?", [$email]);
    }

	public function fazerLogin($email, $senha) {
        // Pegando a linha retornada e jogando na varivavel dados
        $this->dados = $this->conexao->selecionar(['usuario_email'], 'usuarios', 'usuario_email= ?', [$email])->fetch(\PDO::FETCH_ASSOC);

        // Instaciando o objeto util para verificar a senha
        $this->util = new Util();

        // Se o email existir no banco de dados, o atributo dados vai valer true
        if (count($this->dados) > 0) {
            // Fazemos outra conexão com o banco de dados para pegar a senha do usuario
        	$this->dados = $this->conexao->selecionar(['usuario_senha'], 'usuarios', "usuario_email= ?", [$email])->fetch(\PDO::FETCH_ASSOC);

            // Se a senha do bd for igual a senha digitada no input entramos no if
            if($this->util->compararHash($senha, $this->dados['usuario_senha'])) {
                // Aqui o usuario está logado
                // Setamos ele online no banco de dados
                $this->setStatusOnline($email);

                // criamos outra conexão com o banco para pegar as outras informações do usuario
                $this->dados = $this->conexao->selecionar(['usuario_id', 'usuario_nome', 'usuario_sobrenome', 'usuario_cpf', 'usuario_nome_usuario', 'usuario_email',' usuario_email_pendente', 'usuario_email_ativado', 'usuario_cargo', 'usuario_registro_data', 'usuario_registro_ip', 'usuario_ultimo_acesso', 'usuario_ultimo_ip', 'usuario_online', 'usuario_foto', 'usuario_estado', 'usuario_cidade', 'usuario_cep'], 'usuarios', "usuario_email= ?", [$email])->fetch(\PDO::FETCH_ASSOC);

                // Intanciamos o objeto usuario com todas as informações
                $this->usuario = new Usuario($this->dados['usuario_nome'], $this->dados['usuario_sobrenome'], $this->dados['usuario_cpf'], $this->dados['usuario_nome_usuario'], $this->dados['usuario_email'], $this->dados['usuario_email_pendente'], $this->dados['usuario_email_ativado'], $this->dados['usuario_cargo'], $this->dados['usuario_registro_data'], $this->dados['usuario_registro_ip'], $this->dados['usuario_ultimo_acesso'], $this->dados['usuario_ultimo_ip'], $this->dados['usuario_online'], $this->dados['usuario_foto'], $this->dados['usuario_estado'], $this->dados['usuario_cidade'], $this->dados['usuario_cep']);

                // setamos o id do objeto usuario como o id do bd criptografado em md5 por segurança
                $this->usuario->setId(md5($this->dados['usuario_id']));
                // Retornamos true

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Passar objeto usuario como parametro, passar objeto sessao como parametro
    public function deslogar($usuario) {
        unset($usuario);
        $sessao = new Sessao();
        $sessao->destruirSessao();
    }

    public function procurarPerfil($id) {
		$dados = $this->conexao->selecionar(['usuario_id, usuario_nome, usuario_sobrenome, usuario_email, usuario_registro_data, usuario_ultimo_acesso, usuario_online, usuario_foto, usuario_verificado, usuario_cep'], 'usuarios', 'md5(usuario_id) = ?', [$id])->fetch(\PDO::FETCH_ASSOC);

        $this->usuario = new Usuario();
		$this->usuario->perfil(md5($dados['usuario_id']), $dados['usuario_nome'], $dados['usuario_sobrenome'], $dados['usuario_email'], $dados['usuario_registro_data'], $dados['usuario_ultimo_acesso'], $dados['usuario_online'], $dados['usuario_foto'], $dados['usuario_verificado'], $dados['usuario_cep']);

		return $this->usuario;
    }

	public function verificarSenha($id, $senha) {
		$this->dados = $this->conexao->selecionar(['usuario_senha'], 'usuarios', 'md5(usuario_id) = ?', [$id])->fetch(\PDO::FETCH_ASSOC);

		if (count($senha) > 0) {
			$hash = $this->dados['usuario_senha'];
			if($this->util->compararHash($senha, $hash)) {
				return true;
        	} else {
        		return false;
        	}
		} else {
			return false;
		}
    }

	public function listarUsuarios($filtros = []) {
		$where = 'true ';
	 	$valoresWhere = [];

		if (is_array($filtros)) {
			if (count($filtros) > 0) {
				for ($i = 0; $i < count($filtros); $i++) {
					if (count($filtros[$i]) == 2) {
						$where .= $filtros[$i][0] . ' ';
						array_push($valoresWhere, $filtros[$i][1]);
					} else {
						$where .= $filtros[$i] . ' ';
					}
				}
			}
		}

		$objetosUsuario = [];

		// Recuperando dados de obras
		$usuarios = $this->conexao->selecionarFetch(['usuario_id', 'usuario_nome', 'usuario_sobrenome', 'usuario_cpf', 'usuario_nome_usuario', 'usuario_email',' usuario_email_pendente', 'usuario_email_ativado', 'usuario_token', 'usuario_cargo', 'usuario_registro_data', 'usuario_registro_ip', 'usuario_ultimo_acesso', 'usuario_ultimo_ip', 'usuario_online', 'usuario_foto', 'usuario_verificado', 'usuario_estado', 'usuario_cidade', 'usuario_cep'], 'usuarios', $where, $valoresWhere, true);

		if ($usuarios != false) {
			foreach($usuarios as $d) {
				$usuario = new Usuario();
				$usuario->construtor(md5($d['usuario_id']), $d['usuario_nome'], $d['usuario_sobrenome'], $d['usuario_cpf'], $d['usuario_nome_usuario'], $d['usuario_email'], $d['usuario_email_pendente'], $d['usuario_email_ativado'], $d['usuario_token'], $d['usuario_cargo'], $d['usuario_registro_data'], $d['usuario_registro_ip'], $d['usuario_ultimo_acesso'], $d['usuario_ultimo_ip'], $d['usuario_online'], $d['usuario_foto'], $d['usuario_verificado'], $d['usuario_estado'], $d['usuario_cidade'], $d['usuario_cep']);
				array_push($objetosUsuario, $usuario);
			}

			return $objetosUsuario;
		}

		return false;
	}
}

