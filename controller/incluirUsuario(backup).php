<?php
require_once '../vendor/autoload.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload(["persistence", "util"], ["DaoConexao","Util"]);

use fiscalizape\persistence\DaoConexao;
use fiscalizape\util\Util;
use Respect\Validation\Validator as v;

$util = new Util();
$daoConexao = new DaoConexao();

// Limpando os inputs
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$sobrenome = filter_input(INPUT_POST, 'sobrenome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cpf = $util->somenteNumeros(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
$email = strtolower(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$senhaRepita = filter_input(INPUT_POST, 'senhaRepita', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$termos = filter_input(INPUT_POST, 'termos', FILTER_VALIDATE_INT);

setcookie("registrar[nome]", $nome, time()+60*10, "/fiscalizape/view/registrar.php");
setcookie("registrar[sobrenome]", $sobrenome, time()+60*10, "/fiscalizape/view/registrar.php");
setcookie("registrar[email]", $email, time()+60*10, "/fiscalizape/view/registrar.php");
setcookie("registrar[cpf]", $cpf, time()+60*10, "/fiscalizape/view/registrar.php");

// Gerando informações adicionais
// Pegando o ip
$ip = $util->getUserIP();
// Usuaremos esta string para redericionar o usuario para a pagina de registro e iremos contatenar com o erro
$paginaRegistro = 'Location: ../view/registrar.php';

// Verificando os campos (tamanho, validade, etc...)
if ($util->ValidarTamanhoString($nome, 4, 25)) {
	if ($util->ValidarTamanhoString($sobrenome, 4, 25)) {
		if (strlen($cpf) === 11) {
			if ($util->validarCPF($cpf)) {
				$cpfs = $daoConexao->selecionar(['usuario_cpf'], 'usuarios')->fetchAll(\PDO::FETCH_ASSOC);
				foreach ($cpfs as $cpfAtual) {
					if ($cpfAtual['usuario_cpf'] == $cpf) {
						header($paginaRegistro . '?erro[]=CPF já cadastrado.');
						exit();
					}
				}

				if ($util->validarTamanhoString($email, 4, 100) && v::email()->validate($email)) {
					// Selecinando todos os emails do banco de dados
					$emails = $daoConexao->selecionar(['usuario_email'], 'usuarios')->fetchAll(\PDO::FETCH_ASSOC);

					// Pegando uma linha por vez e comparando com o email passado
					foreach ($emails as $emailAtual) {
						// Se algum email bater, rederecionamos para a pagina de registro
						if ($emailAtual['usuario_email'] == $email) {
							header($paginaRegistro . '?erro[]=Email já cadastrado');
							exit();
						}
					}

					// Se nenhum email bateu, seguimos o registro
					if ($util->validarTamanhoString($senha, 8, 30)) {
						if ($senha === $senhaRepita) {
							// Gerando o hash da senha
							$hashSenha = $util->gerarHash($senha);
							$token = md5(uniqid(mt_rand(), true));

							// Tudo deu certo, vamos tentar incluir no banco de dados
							$daoConexao->inserir('usuarios',
									['usuario_nome, usuario_sobrenome, usuario_cpf, usuario_email, usuario_senha, usuario_token, usuario_registro_ip, usuario_ultimo_ip'],
									[$nome, $sobrenome, $cpf, $email, $hashSenha, $token, $ip, $ip]);

							// Vamos verificar se conseguimos se o registro foi incluido no banco de dados
							$resultado = $daoConexao->selecionar(['usuario_email, usuario_senha'], 'usuarios', 'usuario_email = ?', [$email])->fetch(\PDO::FETCH_ASSOC);
							if ($email === $resultado['usuario_email'] && $util->compararHash($senha, $resultado['usuario_senha'])) {
								// Se conseguimos registrar o usuario no banco de dados iniciamos a sessão dele
								session_start();
								$_SESSION ['logado'] = 1;
								$_SESSION ['email'] = $email;
								$_SESSION ['senha'] = $senha;
								header('Location: loginIniciar.php');
								exit();
							} else {
								// Por algum motivo não conseguimos cadastrar o usuario no banco
								header($paginaRegistro . '?erro[]=Houve um problema');
								exit();
							}
						} else {
							header($paginaRegistro . '?erro[]=Senhas não conferem');
							exit();
						}
					} else {
						header($paginaRegistro . '?erro[]=Senha inválida, muito pequena ou muito comprida');
						exit();
					}
				} else {
					header($paginaRegistro . '?erro[]=Email inválido');
					exit();
				}
			} else {
				header($paginaRegistro . '?erro[]=CPF inválido');
				exit();
			}
		} else {
			header($paginaRegistro . '?erro[]=CPF com tamanho inválido, muito pequeno ou muito comprido');
			exit();
		}
	} else {
		header($paginaRegistro . '?erro[]=Sobrenome inválido, muito pequeno ou muito comprido');
		exit();
	}
} else {
	header($paginaRegistro . '?erro[]=Nome inválido, muito pequeno ou muito comprido');
	exit();
}