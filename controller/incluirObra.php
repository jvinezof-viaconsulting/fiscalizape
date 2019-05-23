<?php
require_once '../vendor/autoload.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload([ 'persistence', 'util', 'model' ], [ ['Sessao', 'DaoConexao', 'DaoCidade'], 'Util', ['Erros', 'Avisos'] ]);

use Respect\Validation\Validator as v;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\util\Util;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\model\Erros;
use \fiscalizape\model\Avisos;
use \fiscalizape\persistence\DaoCidade;

/*
 * Variaveis importantes
*/

$daoConexao = new DaoConexao();
$util = new Util();
$sessao = new Sessao();
$usuario = $sessao->getSessaoUsuario();
$objErros = new Erros('novaobra', 60);
$daoCidade = new DaoCidade();
$objAvisos = new Avisos('novaobra', 60);

// Redirecionamentos
$sucesso = 'Location: ../view/obra.php?view=';
$erro = 'Location: ../view/novaobra.php?erro';

/*
 * POSTs (Obrigatorios)
*/

$tituloObra = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Removendo algumas tags da descrição
$regex = '/<img.*?src="(.*?)"[^\>]+>|<[^>]*script/';
$descricao = preg_replace($regex, '', filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

// Adicionando target _blank para os links
$reg = '/<a(.*?)>/';
$descricao = preg_replace($reg, "<a$1 target=\"_blank\">", $descricao);

$cidadeId = (int) filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_NUMBER_INT);
$verbaInicial = str_replace(',', '.', str_replace('.', '', filter_input(INPUT_POST, 'verbaInicial', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));

// Localização
$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS); // Opcional (pode ser vazio)
$rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Contribuidor
$hashId = $usuario->getId();
$result = $daoConexao->selecionar(['usuario_id'], 'usuarios', 'md5(usuario_id) = ?', [$hashId])->fetch(\PDO::FETCH_ASSOC);
$idContribuidor = $result['usuario_id'];

// Datas
$dataIncialPrevista = filter_input(INPUT_POST, 'dataInicioPrevista', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$dataFinalPrevista = filter_input(INPUT_POST, 'dataEncerramentoPrevista', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


/*
 * POSTs (Opcionais)
*/

$orgao = filter_input(INPUT_POST, 'orgaoResponsavel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$verbaUtilizada = str_replace(',', '.', str_replace('.', '', filter_input(INPUT_POST, 'verbaUtilizada', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
$situacao = filter_input(INPUT_POST, 'estadoAtual', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

// Datas
$dataInicial = filter_input(INPUT_POST, 'dataIncioReal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$dataFinal = filter_input(INPUT_POST, 'dataEncerramentoReal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

/*
 * Salvando cookies do formulario
*/
$path = '/fiscalizape/view/novaobra.php';
$time = time() + 60*10;
setcookie('form[titulo]', $tituloObra, $time, $path);
setcookie('form[descricao]', $descricao, $time, $path);
setcookie('form[cidade]', $cidadeId, $time, $path);
setcookie('form[verbaInicial]', $verbaInicial, $time, $path);
setcookie('form[cep]', $cep, $time, $path);
setcookie('form[rua]', $rua, $time, $path);
setcookie('form[bairro]', $bairro, $time, $path);
setcookie('form[dataInicialPrevista]', $dataIncialPrevista, $time, $path);
setcookie('form[dataFinalPrevista]', $dataFinalPrevista, $time, $path);
setcookie('form[orgao]', $orgao, $time, $path);
setcookie('form[verbaUtilizada]', $verbaUtilizada, $time, $path);
setcookie('form[situacao]', $situacao, $time, $path);
setcookie('form[dataInicial]', $dataInicial, $time, $path);
setcookie('form[dataFinal]', $dataFinal, $time, $path);

/*
 * Validações (Dados Obrigatórios)
*/
$arrayErros = $objErros->getCookie();
$arrayAvisos = $objAvisos->getCookie();
$deuErro = false;

// Titulo
if (strlen($tituloObra) < 5) {
	$deuErro = true;
	array_push($arrayAvisos, "Título inválido, deve conter no mínimo 5 letras.");
} else if (strlen($tituloObra) > 50) {
	$deuErro = true;
	array_push($arrayAvisos, "inválido, deve conter no máximo 50 letras.");
}

// Descrição
if (strlen($descricao) < 10) {
	$deuErro = true;
	array_push($arrayAvisos, "Descrição inválida, deve conter no mínimo 10 letras.");
} else if (strlen($descricao) > 3000) {
	$deuErro = true;
	array_push($arrayAvisos, "Descrição inválida, deve conter no máximo 3000 letras.");
}

// Cidade
if (!v::intType()->validate($cidadeId)) {
	$deuErro = true;
	array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
} else if ($cidadeId > 0) {
	$cidade = $daoCidade->procurarCidade(md5($cidadeId));
	if ($cidade == NULL) {
		$deuErro = true;
		array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
	} else if ($cidade->getNome() == NULL || $cidade->getEstado() == NULL || $cidade->getPrefeito() == NULL) {
		$deuErro = true;
		array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
	}
} else if (!$cidadeId == -1) {
	$deuErro = true;
	array_push($arrayAvisos, "Cidade Inválida, selecione uma cidade valida.");
}

// Verba Inicial
if (strlen($verbaInicial) < 1) {
	$deuErro = true;
	array_push($arrayAvisos, "Digite uma verba inicial.");
} else if (strlen($verbaInicial) > 20) {
	$deuErro = true;
	array_push($arrayAvisos, "Verba Inicial muito grande, digite um valor real.");
}

// Data Inicial Prevista & Data Final Prevista
$timeDataInicialPrevista = strtotime($dataIncialPrevista);
$timeDataFinalPrevista = strtotime($dataFinalPrevista);
$timeDataInicialPrevistaMin = strtotime('1851-01-01');
$timeFinalMax = strtotime(date('Y-m-d', $timeDataInicialPrevista+60*60*24*365*15));

if (!$util->validarData($dataIncialPrevista)) {
	$deuErro = true;
	array_push($arrayAvisos, "Data inicial prevista inválida, digite uma data real no formato dd/mm/yyyy.");
} else if (!$util->validarData($dataFinalPrevista)) {
	$deuErro = true;
	array_push($arrayAvisos, "Data final prevista inválida, digite uma data real no formato dd/mm/yyyy.");
} else if ($timeDataInicialPrevista > $timeDataFinalPrevista) {
	$deuErro = true;
	array_push($arrayAvisos, "Data final prevista não pode ser maior que a data inicial prevista.");
} else if ($timeDataInicialPrevista < $timeDataInicialPrevistaMin) {
	$deuErro = true;
	array_push($arrayAvisos, "Data inicial prevista não pode ser menor que 01/01/1851.");
} else if ($dataIncialPrevista > (time()+60*60*24*180)) {
	$deuErro = true;
	array_push($arrayAvisos, "Data inicial prevista não pode ser maior que " . date('d/m/Y', time()+60*60*24*180) . ".");
} else if ($timeDataFinalPrevista > $timeFinalMax)  {
	$deuErro = true;
	array_push($arrayAvisos, "A obra não pode durar mais de 15 anos.");
}

// Localização
if (strlen($cep) < 1 && strlen($bairro) < 1) {
	$deuErro = true;
	array_push($arrayAvisos, "Digite um CEP ou digite o nome do Bairro.");
}

// Rua
if (strlen($rua) > 60) {
	$deuErro = true;
	array_push($arrayAvisos, "Nome da rua muito grande, tente usar abreviações ou siglas.");
}

// Bairro
if (strlen($bairro) > 60) {
	$deuErro = true;
	array_push($arrayAvisos, "Nome do bairro muito grande, tente usar abreviações ou siglas.");
}

/*
 * Validações (Dados Opcionais)
*/

// Data Inicial Real & Data Final Real
$timeDataInicial = strtotime($dataInicial);
$timeDataFinal = strtotime($dataFinal);
$timeDataInicialMin = strtotime('1851-01-01');

if (v::notBlank()->validate($dataInicial) && v::notBlank()->validate($dataFinal)) {
	if (!$util->validarData($dataInicial)) {
		$deuErro = true;
		array_push($arrayAvisos, "Data inicial inválida, digite uma data real no formato dd/mm/yyyy.");
	} else if (!$util->validarData($dataFinal)) {
		$deuErro = true;
		array_push($arrayAvisos, "Data final inválida, digite uma data real no formato dd/mm/yyyy.");
	} else if ($timeDataInicial > $timeDataFinal) {
		$deuErro = true;
		array_push($arrayAvisos, "Data final não pode ser maior que a data inicial.");
	} else if ($timeDataInicial < $timeDataInicialMin) {
		$deuErro = true;
		array_push($arrayAvisos, "Data inicial não pode ser menor que 01/01/1851.");
	}
} else if (v::notBlank()->validate($dataInicial)) {
	if (!$util->validarData($dataInicial)) {
		$deuErro = true;
		array_push($arrayAvisos, "Data inicial inválida, digite uma data real no formato dd/mm/yyyy.");
	} else if ($timeDataInicial < $timeDataInicialMin) {
		$deuErro = true;
		array_push($arrayAvisos, "Data inicial não pode ser menor que 01/01/1851.");
	}
} else if (v::notBlank()->validate($dataInicial)) {
	if (!$util->validarData($dataFinal)) {
		$deuErro = true;
		array_push($arrayAvisos, "Data final inválida, digite uma data real no formato dd/mm/yyyy.");
	}
}

// Orgão Responsavel
if (v::notBlank()->validate($orgao)) {
	if (strlen($orgao) < 3) {
		$deuErro = true;
		array_push($arrayAvisos, "Orgão inválido, deve conter no mínimo de 3 letras.");
	} else if (strlen($orgao) > 50) {
		$deuErro = true;
		array_push($arrayAvisos, "Orgão inválido, deve conter no máximo 50 letras.");
	}
}

// Verba Utilizada
if (v::notBlank()->validate($verbaUtilizada)) {
	if(strlen($verbaUtilizada) > 20) {
		$deuErro = true;
		array_push($arrayAvisos, "Verba Utilizada muito grande, digite um valor real.");
	}
}

// Situação
$situacoes = ["Não Iniciada", "Parada", "Em Andamento", "Finalizada"];
if (v::notBlank()->validate($situacao)) {
	if (!in_array($situacao, $situacoes)) {
		$deuErro = true;
		array_push($arrayAvisos, "Situação Inválida.");
	}
}

/*
 * HEADER
*/
if ($deuErro) {
	$objAvisos->setAvisos($arrayAvisos);
	$objAvisos->salvarCookie();
	header($erro);
	exit;
}

/*
 * Inserindo no banco de dados
*/

if (!$deuErro) {
	$deuErro = false;

	$key = md5(uniqid(mt_rand(), true));
	$colunas = [
		'obra_key', 'obra_id_cidade', 'obra_titulo', 'obra_descricao', 'obra_data_inicio_prevista', 'obra_data_final_prevista',
		'obra_data_inicio', 'obra_data_final', 'obra_situacao', 'obra_orgao_responsavel', 'obra_orcamento_previsto', 'obra_dinheiro_gasto', 'obra_contribuidor_id', 
		'obra_cep', 'obra_rua', 'obra_bairro'
	];
	$valores = [
		$key, $cidadeId, $tituloObra, $descricao, $dataIncialPrevista, $dataFinalPrevista, $dataInicial, $dataFinal, $situacao,
		$orgao, $verbaInicial, $verbaUtilizada, $idContribuidor, $cep, $rua, $bairro
	];

	$daoConexao->inserir('obras', $colunas, $valores);

	if ($daoConexao->linhasAfetadas() > 0) {
		/*
		 * Movendo as fotos e adicionando no banco de dados
		*/

		// Imagens enviadas
		$fotos = $_FILES['imagensObra'];
		$formatosPermitidos = ['png', 'jpeg', 'jpg'];

		// Destino da imagem
		$diretorio = '../imagens/uploads/obras/';

		// Pegando id da obra
		$idObra = $daoConexao->selecionarDado('obra_id', 'obras', 'obra_key = ?', [$key]);

		// Laço que vai mover as fotos individualmente
		for ($i = 0; $i < count($fotos['error']); $i++) {
			if ($fotos['error'][$i] == 0) {
				$extensao = pathinfo($fotos['name'][$i], PATHINFO_EXTENSION);
				if (in_array($extensao, $formatosPermitidos)) {
					$arquivoTemp = $fotos['tmp_name'][$i];
					$nomeArquivo = md5($idObra) . '_' . uniqid(mt_rand(), true) . ".$extensao";

					// Inserindo imagem no banco
					$daoConexao->inserir('obras_imagens', ['obra_imagem_obra_id', 'obra_imagem_nome'], [$idObra, $nomeArquivo]);

					if ($daoConexao->linhasAfetadas() > 0) {
						// Tentando mover a imagem
						if (!move_uploaded_file($arquivoTemp, $diretorio . $nomeArquivo)) {
						// Se não conseguimos mover, removemos do banco
							$daoConexao->remover('obras_imagens', 'imagem_obra_nome = ?', $nomeArquivo);
						}
					} else {
						array_push($arrayErros, 'Não conseguimos salvar a imagem: ' . $fotos['name'][$i]);
					}
				} else {
					array_push($arrayErros, 'Imagem: ' . $fotos['name'][$i] . ' tem uma extensão inválida');
				}
			}
		}
	} else {
		$deuErro = true;
		array_push($arrayErros, "Houve algum problema, tente novamente!");
	}
}

/*
 * HEADER 2
*/
if ($deuErro) {
	$objErros->setErros($arrayErros);
	$objErros->salvarCookie();
	header($erro);
	exit;
} else {
	// Apagando cookies
	setcookie('form[titulo]', '', time()-1, $path);
	setcookie('form[descricao]', '', time()-1, $path);
	setcookie('form[cidade]', '', time()-1, $path);
	setcookie('form[verbaInicial]', '', time()-1, $path);
	setcookie('form[cep]', '', time()-1, $path);
	setcookie('form[rua]', '', time()-1,  $path);
	setcookie('form[bairro]', '', time()-1, $path);
	setcookie('form[dataInicialPrevista]', '', time()-1, $path);
	setcookie('form[dataFinalPrevista]', '', time()-1, $path);
	setcookie('form[orgao]', '', time()-1, $path);
	setcookie('form[verbaUtilizada]', '', time()-1, $path);
	setcookie('form[situacao]', '', time()-1, $path);
	setcookie('form[dataInicial]', '', time()-1, $path);
	setcookie('form[dataFinal]', '', time()-1, $path);

	// Redirecionando
	header($sucesso.$key);
	exit;
}