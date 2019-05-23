<?php
require_once '../vendor/autoload.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence', 'util', 'model'], [['Sessao', 'DaoConexao', 'DaoObra', 'DaoCidade'], 'Util', ['ControleDeAcesso', 'Erros', 'Avisos'] ]);

use Respect\Validation\Validator as v;
use \fiscalizape\util\Util;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\persistence\DaoObra;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\model\ControleDeAcesso;
use \fiscalizape\model\Erros;
use \fiscalizape\model\Avisos;
use \fiscalizape\persistence\DaoCidade;

/*
 * Variaveis importantes
*/
$controle = new ControleDeAcesso();
$daoConexao = new DaoConexao();
$daoCidade = new DaoCidade();
$ut = new Util();
$sessao = new Sessao();
$usuario = $sessao->getSessaoUsuario();
$objErros = new Erros('editarobra', 60);
$objAvisos = new Avisos('editarobra', 60);
$objErrosObras = new Erros('obras', 60);
$objErrosObra = new Erros('obra', 60);
$objAvisosObra = new Avisos('obra', 60);

// Variaveis gerais
$key = filter_input(INPUT_POST, 'view', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$editar = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$edicoes = ['titulo', 'descricao', 'imagens', 'local', 'informacoesOficiais', 'informacoesExtras'];
if (!in_array($editar, $edicoes)) {
	$editar = 'editar';
}

// Definindo redireciomentos
$sucesso = 'Location: ../view/obra.php?view=' . $key . '&sucesso';
$lerro = 'Location: ../view/editarobra.php?view=' . $key;
$erro = $lerro;
$aviso = "Location: ../view/editarobra.php?view=$key&editar=$editar";

$daoObra = new DaoObra();
$obra = $daoObra->procurarObra($key);

if ($obra instanceof Obra) {
	$objErrosObras->adicionarErro("Você tentou editar uma obra inválida!");
	$ut->h('location: ../view/obras.php?erro=404');
}

/*
 * Verificando acesso permitido
 * apenas usuarios logados e que usuarios que criaram a obra podem editar.
*/

// permitirUsuario() possui um header, então se passar por ela o usuario está logado.
$controle->permitirUsuario('editarobra.php?view=' . $key . '&editar=' . $editar);
// Se o usuario não for administrador ou não criou a obra o if entra.
if ( !( $controle->acessoNivelA($usuario->getId()) || $controle->acessoNivelB($usuario->getId()) ) && $usuario->getId() != $obra->getContribuidor()->getId() ) {
	$objErrosObra->adicionarErro("Acesso negado!");
	$ut->h('Location: ../view/obra.php?view=' . $key);
}

/*
 * Filtrando variaveis
*/

$titulo = (isset($_POST['titulo'])) ? filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getTitulo();
$descricao = (isset($_POST['descricao'])) ? filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDescricao();
$cidadeId = (isset($_POST['cidadeId'])) ? (int) filter_input(INPUT_POST, 'cidadeId', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getCidade()->getId();
$cidadeNome = (isset($_POST['cidadeNome'])) ? filter_input(INPUT_POST, 'cidadeNome', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getCidade()->getNome();
$verbaInicial = (isset($_POST['verbaInicial'])) ? str_replace(',', '.', str_replace('.', '', filter_input(INPUT_POST, 'verbaInicial', FILTER_SANITIZE_FULL_SPECIAL_CHARS))) : $obra->getOrcamentoPrevisto();
$dataInicioPrevista = (isset($_POST['dataInicioPrevista'])) ? filter_input(INPUT_POST, 'dataInicioPrevista', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataInicioPrevista();
$dataFinalPrevista = (isset($_POST['dataEncerramentoPrevista'])) ? filter_input(INPUT_POST, 'dataEncerramentoPrevista', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataFinalPrevista();
$dataInicial = (isset($_POST['dataIncioReal'])) ? filter_input(INPUT_POST, 'dataIncioReal', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataInicio();
$dataFinal = (isset($_POST['dataEncerramentoReal'])) ? filter_input(INPUT_POST, 'dataEncerramentoReal', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getDataFinal();
$orgaoResponsavel = (isset($_POST['orgaoResponsavel'])) ? filter_input(INPUT_POST, 'orgaoResponsavel', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getOrgaoResponsavel();
$dinheiroGasto = (isset($_POST['verbaUtilizada'])) ? str_replace(',', '.', str_replace('.', '', filter_input(INPUT_POST, 'verbaUtilizada', FILTER_SANITIZE_FULL_SPECIAL_CHARS))) : $obra->getDinheiroGasto();
$situacao = (isset($_POST['estadoAtual'])) ? filter_input(INPUT_POST, 'estadoAtual', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getSituacao();
$rua = (isset($_POST['rua'])) ? filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getRua();
$bairro = (isset($_POST['bairro'])) ? filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getBairro();
$cep = (isset($_POST['cep'])) ? filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS) : $obra->getCep();

/*
 * Salvando cookies do formulario
*/

$path = '/fiscalizape/view/editarobra.php';
$time = time() + 60*10;
setcookie('form[titulo]', $titulo, $time, $path);
setcookie('form[descricao]', $descricao, $time, $path);
setcookie('form[cidadeId]', $cidadeId, $time, $path);
setcookie('form[cidadeNome]', $cidadeNome, $time, $path);
setcookie('form[verbaInicial]', $verbaInicial, $time, $path);
setcookie('form[dataInicioPrevista]', $dataInicioPrevista, $time, $path);
setcookie('form[dataEncerramentoPrevista]', $dataFinalPrevista, $time, $path);
setcookie('form[dataIncioReal]', $dataInicial, $time, $path);
setcookie('form[dataEncerramentoReal]', $dataFinal, $time, $path);
setcookie('form[orgaoResponsavel]', $orgaoResponsavel, $time, $path);
setcookie('form[verbaUtilizada]', $dinheiroGasto, $time, $path);
setcookie('form[situacao]', $situacao, $time, $path);
setcookie('form[rua]', $rua, $time, $path);
setcookie('form[bairro]', $bairro, $time, $path);
setcookie('form[cep]', $cep, $time, $path);



/*
 * Dados Editados
*/
$deuErro = false;
$erroLocal = false;
$arrayErros = [];
$arrayAvisos = [];

// Array que vai guardar dados modificados.
$modificados = [];

// Titulo
$erroLocal = false;
if ($titulo != $obra->getTitulo()) {
	if (strlen($titulo) < 5) {
		$erroLocal = true;
		$deuErro = true;
		array_push($arrayAvisos, "Título inválido, deve conter no mínimo 5 letras.");
	} else if (strlen($titulo) > 50) {
		$erroLocal = true;
		$deuErro = true;
		array_push($arrayAvisos, "inválido, deve conter no máximo 50 letras.");
	}

	if ($deuErro && $editar == 'titulo') {
		$objAvisos->setAvisos($arrayAvisos);
		$ut->h($aviso);
	}

	if (!$erroLocal) {
		array_push($modificados, ['obra_titulo', $titulo]);
	}
}


// Descrição
$erroLocal = false;

// Removendo as tags <img> e <script>
$regex = '/<img.*?src="(.*?)"[^\>]+>|<[^>]*script/';
$descricao = preg_replace($regex, '', $descricao);

// Adicionando target _blank para os links
$reg = '/<a(.*?)>/';
$descricao = preg_replace($reg, "<a$1 target=\"_blank\">", $descricao);

if ($descricao != $obra->getDescricao()) {
	if (strlen($descricao) < 10) {
		$erroLocal = true;
		$deuErro = true;
		array_push($arrayAvisos, "Descrição inválida, deve conter no mínimo 10 letras.");
	} else if (strlen($descricao) > 3000) {
		$erroLocal = true;
		$deuErro = true;
		array_push($arrayAvisos, "Descrição inválida, deve conter no máximo 3000 letras.");
	}

	if ($deuErro && $editar == 'descricao') {
		$objAvisos->setAvisos($arrayAvisos);
		$ut->h($aviso);
	}

	if (!$erroLocal) {
		array_push($modificados, ['obra_descricao', $descricao]);
	}
}


// Cidade ID
$erroLocal = false;
if ($cidadeId != $obra->getCidade()->getId()) {
	if (!v::intType()->validate($cidadeId)) {
		$erroLocal = true;
		$deuErro = true;
		array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
	} else if ($cidadeId > 0) {
		$cidade = $daoCidade->procurarCidade(md5($cidadeId));
		if ($cidade == NULL) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
		} else if ($cidade->getNome() == NULL || $cidade->getEstado() == NULL || $cidade->getPrefeito() == NULL) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
		}
	} else if (!$cidadeId == -1) {
		$erroLocal = true;
		$deuErro = true;
		array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
	}

	if (!$erroLocal) {
		array_push($modificados, ['obra_id_cidade', $cidadeId]);
	}
}


// Imagens
if ($editar == 'imagens' || $editar == 'editar') {
    /*
	 * Excluindo imagens
	*/

	// Pegando imagens excluidas
    $imagensExcluidas = (isset($_POST['imagensApagadas'])) ? $_POST['imagensApagadas'] : false;

    if ($imagensExcluidas != false) {
		// Limpando indeces do array
    	for ($i = 0; $i < count($imagensExcluidas); $i++) {
    		$imagensExcluidas[$i] = filter_var($imagensExcluidas[$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    	}

		// Apagando imagens na pasta e no banco de dados
    	for ($i = 0; $i < count($imagensExcluidas); $i++) {
    		$caminho = '../imagens/uploads/obras/' . $imagensExcluidas[$i];
    		$novoCaminho = '../imagens/sistema/lixeira/obras/' . $imagensExcluidas[$i];
    		if (file_exists($caminho)) {
    			$excluida = $daoConexao->selecionarDado('obra_imagem_excluida', 'obras_imagens', 'obra_imagem_nome = ?', [$imagensExcluidas[$i]]);
    			if ($excluida == 0) {
    				$daoConexao->atualizar('obras_imagens', ['obra_imagem_excluida'], [1], 'obra_imagem_nome = ?', [$imagensExcluidas[$i]]);

    				if ($daoConexao->linhasAfetadas() > 0) {
    					rename($caminho, $novoCaminho);
    				} else {
    					$deuErro = true;
    					array_push($arrayErros, "Não conseguimos excluir a imagem: " . $imagensExcluidas[$i]);
    				}
    			}
    		} else {
    			$deuErro = true;
    			array_push($arrayAvisos, "Imagem: " . $imagensExcluidas[$i] . " não encontrada.");
    		}
    	}
    }

    /*
	 * Adicionando novas imagens
	*/
    $errosImagens = [];

	// Imagens enviadas
    $fotos = $_FILES['imagensObra'];
    $formatosPermitidos = ['png', 'jpeg', 'jpg'];

	// Destino da imagem
    $diretorio = '../imagens/uploads/obras/';

	// Pegando id da obra
    $idObra = $obra->getId();

	// Laço que vai mover as fotos individualmente
	for ($i = 0; $i < count($fotos['error']); $i++) {
		if ($fotos['error'][$i] == 0) {
			$extensao = pathinfo($fotos['name'][$i], PATHINFO_EXTENSION);
			if (in_array($extensao, $formatosPermitidos)) {
    			$arquivoTemp = $fotos['tmp_name'][$i];
    			$nomeArquivo = md5($idObra) . '_' . uniqid(mt_rand(), true) . ".$extensao";

				// Inserindo no banco
    			$daoConexao->inserir('obras_imagens', ['obra_imagem_obra_id', 'obra_imagem_nome'], [$idObra, $nomeArquivo]);
    			if ($daoConexao->linhasAfetadas() > 0) {
					// Tentando mover a imagem
    				if (!move_uploaded_file($arquivoTemp, $diretorio . $nomeArquivo)) {
						// Se não conseguimos mover, removemos do banco
    					$daoConexao->remover('obras_imagens', 'imagem_obra_nome = ?', $nomeArquivo);
    				}
    			} else {
    				$deuErro = true;
    				array_push($arrayErros, 'Não conseguimos salvar a imagem: ' . $fotos['name'][$i] . '.');
    			}
    		} else {
    			$deuErro = true;
    			array_push($arrayAvisos, 'Extensão inválida: ' . $fotos['name'][$i] . '.');
    		}
    	}
    }

    if ($deuErro && $editar == 'imagens') {
    	$objErros->setErros($arrayErros);
    	$objAvisos->setAvisos($arrayAvisos);
    	$ut->h($aviso);
    }
}


// Informações Oficiais
if ($editar == 'informacoesOficiais' || $editar == 'editar') {
    // Verba Inicial
	$erroLocal = false;
	if ($verbaInicial != $obra->getOrcamentoPrevisto()) {
		if (strlen($verbaInicial) < 1) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Verba Inicial muito <strong>pequena<strong>, digite um valor real.");
		} else if (strlen($verbaInicial) > 20) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Verba Inicial muito <strong>grande</strong>, digite um valor real.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_orcamento_previsto', $verbaInicial]);
		}
	}

    // Data Inicial Prevista & Data Final Prevista
	$erroLocal = false;
	$timeDataInicialPrevista = strtotime($dataIncialPrevista);
	$timeDataFinalPrevista = strtotime($dataFinalPrevista);
	$timeDataInicialPrevistaMin = strtotime('1851-01-01');
	$timeFinalMax = strtotime(date('Y-m-d', $timeDataInicialPrevista+60*60*24*365*15));
	if ($dataInicioPrevista != $obra->getDataInicioPrevista() || $dataFinalPrevista != $obra->getDataFinalPrevista()) {
		if (!$ut->validarData($dataIncialPrevista)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data inicial prevista inválida, digite uma data real no formato dd/mm/yyyy.");
		} else if (!$ut->validarData($dataFinalPrevista)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data final prevista inválida, digite uma data real no formato dd/mm/yyyy.");
		} else if ($timeDataInicialPrevista > $timeDataFinalPrevista) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data final prevista não pode ser maior que a data inicial prevista.");
		} else if ($timeDataInicialPrevista < $timeDataInicialPrevistaMin) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data inicial prevista não pode ser menor que 01/01/1851.");
		} else if ($dataIncialPrevista > (time()+60*60*24*180)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data inicial prevista não pode ser maior que " . date('d/m/Y', time()+60*60*24*180) . ".");
		} else if ($timeDataFinalPrevista > $timeFinalMax)  {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "A obra não pode durar mais de 15 anos.");
		}

		if ($deuErro && $editar == 'informacoesOficiais') {
			$objAvisos->setAvisos($arrayAvisos);
			$objErros->setErros($arrayErros);
			$ut->h($aviso);
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_data_inicio_prevista', $dataInicioPrevista], ['obra_data_final_prevista', $dataFinalPrevista]);
		}
	}
}

// Informações Extras
if ($editar == 'informacoesExtras' || $editar == 'editar') {
    // Data Inicial Real & Data Final Real
	$erroLocal = false;
	$timeDataInicial = strtotime($dataInicial);
	$timeDataFinal = strtotime($dataFinal);
	$timeDataInicialMin = strtotime('1851-01-01');
	if (empty($dataInicial) && empty($dataFinal)) {
		if (!$ut->validarData($dataInicial)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data inicial inválida, digite uma data real no formato dd/mm/yyyy.");
		} else if (!$ut->validarData($dataFinal)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data final inválida, digite uma data real no formato dd/mm/yyyy.");
		} else if ($timeDataInicial > $timeDataFinal) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data final não pode ser maior que a data inicial.");
		} else if ($timeDataInicial < $timeDataInicialMin) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data inicial não pode ser menor que 01/01/1851.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_data_inicio', $dataInicial], ['obra_data_final', $dataFinal]);
		}
	} else if (empty($dataInicial)) {
		if (!$ut->validarData($dataInicial)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data inicial inválida, digite uma data real no formato dd/mm/yyyy.");
		} else if ($timeDataInicial < $timeDataInicialMin) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data inicial não pode ser menor que 01/01/1851.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_data_inicio', $dataInicial]);
		}
	} else if (empty($dataInicial)) {
		if (!$ut->validarData($dataFinal)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Data final inválida, digite uma data real no formato dd/mm/yyyy.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_data_final', $dataFinal]);
		}
	}

    // Orgão Reponsável
	$erroLocal = false;
	if ($orgaoResponsavel != $obra->getOrgaoResponsavel()) {
		if (strlen($orgao) < 3) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Orgão inválido, deve conter no mínimo de 3 letras.");
		} else if (strlen($orgao) > 50) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Orgão inválido, deve conter no máximo 50 letras.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_orgao_responsavel', $orgaoResponsavel]);
		}
	}

    // Verba utilizada (dinheiro gasto)
	$erroLocal = false;
	if ($dinheiroGasto != $obra->getDinheiroGasto()) {
		if(strlen($verbaUtilizada) > 20) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Verba Utilizada muito grande, digite um valor real.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_dinheiro_gasto', $dinheiroGasto]);
		}
	}

	// Situação
	$erroLocal = false;
	$situacoes = ["Não Iniciada", "Parada", "Em Andamento", "Finalizada"];
	if ($situacao != $obra->getSituacao()) {
		if (!in_array($situacao, $situacoes)) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Situação Inválida.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_situacao', $situacao]);
		}
	}
}


// Local
if ($editar == 'local' || $editar == 'editar') {
	// Rua
	$erroLocal = false;
	if ($rua != $obra->getRua()) {
		if (strlen($rua) > 60) {
			$erroLocal = true;
			$deuErro = true;
			array_push($arrayAvisos, "Nome da rua muito grande, tente usar abreviações ou siglas.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_rua', $rua]);
		}
	}

    // Bairro
	$erroLocal = false;
	if ($bairro != $obra->getBairro()) {
		if (strlen($bairro) > 60) {
			$deuErro = true;
			array_push($arrayAvisos, "Nome do bairro muito grande, tente usar abreviações ou siglas.");
		}

		if (!$erroLocal) {
			array_push($modificados, ['obra_bairro', $bairro]);
		}
	}
}

if (count($modificados) > 0) {
    /*
     * Separando os nomes das colunas dos valores.
    */
    $colunas = [];
    $valores = [];

    for ($i = 0; $i < count($modificados); $i++) {
    	array_push($colunas, $modificados[$i][0]);
    	array_push($valores, $modificados[$i][1]);
    }

	/*
	 * Inserindo no banco de dados
	*/
	$daoConexao->atualizar('obras', $colunas, $valores, 'obra_key = ?', [$key]);
	if ($daoConexao->linhasAfetadas() == 0) {
		$deuErro = true;
		array_push($arrayErros, "Não conseguimos atualizar a obra no banco de dados, tente novamente.");
	}
}


if ($deuErro) {
	$objErros->setErros($arrayErros);
	$objAvisos->setAvisos($arrayAvisos);
	$ut->h($aviso);
} else {
	$ut->h($sucesso);
}