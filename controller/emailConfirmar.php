<?php
require_once '../Autoload.php';
new \fiscalizape\Autoload("persistence", "DaoUsuario");

use \fiscalizape\persistence\DaoUsuario;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\persistence\DaoConexao;

$sessao = new Sessao();
$daoUsuario = new DaoUsuario();
$conexao = new DaoConexao();
# Pagina que vamos redericionar o usuario, se algo der errado ela não vai ser mudada,
# Então por padrão deixamos ela como erro
$redirecionar = '../view/index.php?algoDeErradoNaoEstaCerto';

# Verificamos se foi passado os links no link
if (isset($_GET['ativador']) && isset($_GET['verificador'])) {
    # link enviado pelo email, ativador deve conter o id do usuario que se registrou
    $ativador = filter_input(INPUT_GET, 'ativador', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    # link tambem deve conter o email do usuario
    $emailGet = filter_input(INPUT_GET, 'verificador', FILTER_SANITIZE_EMAIL);
} else {
    header('Location: ' . $redirecionar);
    exit;
}

if($sessao->estaLogado()) {
    # Se estiver logado mudamos o redirecionamento dele
    $redirecionar = '../view/index.php?confirmouEmail';

    # Passando o objeto usuario que está logado para a varivael usuario, precisa da unserialize pq é um objeto serializado
    $usuario = $sessao->getSessaoUsuario();

    # Passamos o id e o status de ativação para estas variaveis
    $id = $usuario->getId();
    $emailUsuarioLogado = md5($usuario->getEmail());
    $emailAtivado = $usuario->getEmailAtivado();

    # Verificando se o email já está confirmado, se sim jogamos o usuario na index
    if ($emailAtivado == 1) {
        header('Location: ../view/index.php?usuarioJaConfirmado');
        exit();
    } else {
        if ($id == $ativador && $emailGet == $emailUsuarioLogado) {
            # Se o id for igual a o ativador passado no link
            # E o email do usuario logado for igual ao passado no link
            # Ativamos a conta
            $conexao->atualizar('usuarios', ['usuario_email_ativado'], [1], "md5(usuario_id) = ?", [$id]);

            # Agora vamos verificar se conseguimos atualizar
            # Primeiro retornamos a coluna usuario_email_ativado do banco de dados do usuario que tentou ativar
            $dados = $conexao->selecionar(['usuario_email_ativado'], 'usuarios', "md5(usuario_id) = ?", [$id])->fetch(\PDO::FETCH_ASSOC);
            # Em seguida comparamos se a coluna tem valor 1, se sim deu tudo certo, caso não deu algo errado.
            if ($dados['usuario_email_ativado'] == 1) {
                # Conseguimos ativar com sucesso
                $usuario->setEmailAtivado(1);
                $sessao->atualizarSessaoUsuario($usuario);
                header('Location:' . $redirecionar);
                exit;
            } else {
                # Por algum motivo não conseguimos atualizar
                header('Location: ../view/index.php?desculpeMasNaoConseguimosAtivarSeuEmail');
                exit;
            }
        }
    }
} else {
    # Se não estiver logado mudamos o redirecionamento do mesmo
    $redirecionar = '../view/login.php?EmailConfirmado';

    # Se o usuario não estiver logado, pegamos o id passado no get e verificamos de qual usuario é no banco de dados
    # Selecionamos todos os id's e status do banco e comparamos os id's do banco com o passado no link
    $arrayUsuarios = $conexao->selecionar(['usuario_id, usuario_email, usuario_email_ativado'], 'usuarios' )->fetchAll(\PDO::FETCH_ASSOC);

    # Criamos essa variavel para ver se algum id bateu ou nao
    $encontrou = 0;

    # forEach que vai pecorrer o array de retornado do banco de dados
    foreach ($arrayUsuarios as $dados) {
        if (md5($dados['usuario_id']) == $ativador && $emailGet == md5($dados['usuario_email'])) {
            $encontrou = 1;
            $id = md5($dados['usuario_id']);
            $emailBD = $dados['usuario_email'];
            $emailAtivado = $dados['usuario_email_ativado'];
            break;
        }
    }

    # Se não encontramos nada retornamos um erro
    if ($encontrou == 0) {
        header('Location: ../view/index.php?usuarioNaoExiste');
        exit();
    } else {
        # Caso tenha encontrado verificamos se esse usuario já tem o email confirmado
        if ($emailAtivado == 1) {
            header('Location: ../view/index.php?emailJaConfirmado');
            exit();
        }
    }

    # Agora que já tomamos as medidadas caso o usuario esteja online ou não,
    # Vamos atualizar o usuario no banco de dados
    $conexao->atualizar('usuarios', ['usuario_email_ativado'], [1], "md5(usuario_id) = ?", [$id]);

    # Agora vamos verificar se conseguimos atualizar
    # Primeiro retornamos a coluna usuario_email_ativado do banco de dados do usuario que tentou ativar
    $dados = $conexao->selecionar(['usuario_email_ativado'], 'usuarios', "md5(usuario_id) = ?", [$id])->fetch();
    # Em seguida comparamos se a coluna tem valor 1, se sim deu tudo certo, caso não deu algo errado.
    if ($dados['usuario_email_ativado'] == 1) {
        # Conseguimos ativar com sucesso
        header('Location:' . $redirecionar);
        exit;
    } else {
        # Por algum motivo não conseguimos atualizar
        header('Location: ../view/index.php?desculpeMasNaoConseguimosAtivarSeuEmail');
        exit;
    }
}