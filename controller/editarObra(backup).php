<?php
require_once '../vendor/autoload.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence', 'util', 'model'], [['Sessao', 'DaoConexao', 'DaoObra'], 'Util', ['ControleDeAcesso', 'Erros', 'Avisos'] ]);

use Respect\Validation\Validator as v;
use \fiscalizape\util\Util;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\persistence\DaoObra;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\model\ControleDeAcesso;
use \fiscalizape\model\Erros;
use \fiscalizape\model\Avisos;

/*
 * Variaveis importantes
*/
$controle = new ControleDeAcesso();
$daoConexao = new DaoConexao();
$ut = new Util();
$sessao = new Sessao();
$usuario = $sessao->getSessaoUsuario();
$objErros = new Erros('editarobra', 60);
$objAvisos = new Avisos('editarobra', 60);
$objErrosObras = new Erros('obras', 60);
$objErrosObra = new Erros('obra', 60);

// Variaveis gerais
$key = filter_input(INPUT_POST, 'view', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$editar = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

$edicoes = ['titulo', 'descricao', 'imagens', 'local', 'informacoesOficiais', 'informacoesExtras'];
if (!in_array($editar, $edicoes)) {
	$editar = 'editar';
}

/*
 * Variaveis importantes 2
*/

// Definindo redireciomentos
$sucesso = 'Location: ../view/obra.php?view=' . $key . '&sucesso=ObraEditadaComSucesso';
$lerro = 'Location: ../view/editarobra.php?view=' . $key;
$erro = $lerro;

$edicoes = ['titulo', 'descricao', 'imagens', 'local', 'informacoesOficiais', 'informacoesExtras'];
if (!in_array($editar, $edicoes)) {
	$editar = 'editar';
}

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
$controle->permitirUsuario('editarobra.php?view=' . $view . '&editar=' . $editar);
// Se o usuario não for administrador ou não criou a obra o if entra.
if ( !( $controle->acessoNivelA($usuario->getId()) || $controle->acessoNivelB($usuario->getId()) ) || $usuario->getId() != $obra->getContribuidor()->getId() ) {
	$objErrosObra->adicionarErro("Acesso negado!");
	$ut->h('Location: ../view/obra.php?view=' . $key);
}


/*
 * Dados Editados
*/
$deuErro = false;
$arrayErros = [];

// TITULO
if ($editar == 'titulo' || $editar == 'editar') {
	$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	if ($obra->getTitulo() != $titulo) {
		if (v::stringType()->length(5, 50)->validate($titulo)) {
			$daoConexao->atualizar('obras', ['obra_titulo'], [$titulo], 'obra_key = ?', [$key]);
			if ($daoConexao->linhasAfetadas() == 0) {
				$erro .= '&titulo=ocorreuUmErro';
			}
		} else {
			$erro .= '&erro=tituloInvalido';
		}
	} else {
		$erro .= '&erro=tituloIgual';
	}
}


// DESCRIÇÃO
if ($editar == 'descricao' || $editar == 'editar') {
	// Removendo algumas tags html
	$regex = '/<img.*?src="(.*?)"[^\>]+>|<[^>]*script/';
	$descricao = preg_replace($regex, '', $_POST['descricao']);

	// Adicionando target _blank para os links
	$reg = '/<a(.*?)>/';
	$descricao = preg_replace($reg, "<a$1 target=\"_blank\">", $descricao);

	if ($obra->getDescricao() != $descricao) {
		if (v::stringType()->length(10, 3000)->validate($descricao)) {
			$daoConexao->atualizar('obras', ['obra_descricao'], [$descricao], 'obra_key = ?', [$key]);
			if ($daoConexao->linhasAfetadas() == 0) {
				$erro .= '&descricao=ocorreuUmErro';
			}
		} else {
			$erro .= '&erro=descricaoInvalida';
		}
	} else {
		$erro .= '&erro=descricaoIgual';
	}
}


// IMAGENS
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
						$erro .= '&erro=naoConseguimosExcluirUmaImagem';
					}
				}
			} else {
				$erro .= '&erro=imagemInvalida';
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
					array_push($errosImagens, 'NaoConseguimosSalvarAhImagem=' . $fotos['name'][$i]);
				}
			} else {
				array_push($errosImagens, 'ExtensaoInvalida=' . $fotos['name'][$i]);
			}
		}
	}

	if (count($errosImagens) > 0) {
		$stringErrosImagem = implode("&", $errosImagens);
		$erro .= '&' . $stringErrosImagem;
	}
}


// LOCAL
if ($editar == 'local' || $editar == 'editar') {
	$rua = filter_input(INPUT_POST, 'rua', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cidadeId = (int) filter_input(INPUT_POST, 'cidadeNome', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// Verificando quais mudaram
	$modificados = [];
	$mValores = [];

	if ($rua != $obra->getRua()) {
		array_push($modificados, 'obra_rua');
		array_push($mValores, $rua);
	}

	if ($bairro != $obra->getBairro()) {
		array_push($modificados, 'obra_bairro');
		array_push($mValores, $bairro);
	}

	if (md5($cidadeId) != $obra->getCidade()->getId()) {
		array_push($modificados, 'obra_id_cidade');
		array_push($mValores, $cidadeId);
	}

	if ($cep != $obra->getCep()) {
		array_push($modificados, 'obra_cep');
		array_push($mValores, $cep);
	}

	// Atualizando no banco
	if (count($modificados) > 0 && count($modificados) == count($mValores)) {
		$daoConexao->atualizar('obras', $modificados, $mValores, 'obra_key = ?', [$key]);
		if ($daoConexao->linhasAfetadas() == 0) {
			$erro .= '&erro=NaoConseguimosSalvarOhLocal';
		}
	} else {
		$erro .= '&local=dadosInvalidos';
	}
}


// INFORMAÇÕES OFICIAIS
if ($editar == 'informacoesOficiais' || $editar == 'editar') {
	// Verificando se já existe o id da cidade, pode acontecer se o usuario editar o local e isto.
	if (!isset($cidadeId)) {
		$cidadeId = (int) filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	}

	$verbaInicial = str_replace(',', '.', str_replace('.', '', filter_input(INPUT_POST, 'verbaInicial', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
	$dataInicioPrevista = filter_input(INPUT_POST, 'dataInicioPrevista', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$dataFinalPrevista = filter_input(INPUT_POST, 'dataEncerramentoPrevista', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// Verificando quais mudaram
	$modificados = [];
	$mValores = [];

	if (md5($cidadeId) != $obra->getCidade()->getId()) {
		if (v::intType()->validate($cidadeId)) {
			array_push($modificados, 'obra_id_cidade');
			array_push($mValores, $cidadeId);
		}
	}

	if ($verbaInicial != $obra->getOrcamentoPrevisto()) {
		if (v::stringType()->length(1, 20)->validate($verbaInicial)) {
			array_push($modificados, 'obra_orcamento_previsto');
			array_push($mValores, $verbaInicial);
		}
	}

	if ($dataInicioPrevista != $obra->getDataInicioPrevista()) {
		if ($ut->validarData($dataInicioPrevista)) {
			array_push($modificados, 'obra_data_inicio_prevista');
			array_push($mValores, $dataInicioPrevista);
		}
	}

	if ($dataFinalPrevista != $obra->getDataFinalPrevista()) {
		if ($ut->validarData($dataFinalPrevista)) {
			array_push($modificados, 'obra_data_final_prevista');
			array_push($mValores, $dataFinalPrevista);
		}
	}

	// Atualizando no banco
	if (count($modificados) > 0 && count($modificados) == count($mValores)) {
		$daoConexao->atualizar('obras', $modificados, $mValores, 'obra_key = ?', [$key]);
		if ($daoConexao->linhasAfetadas() == 0) {
			$erro .= '&erro=NaoConseguimosSalvarAsInformacoesOficiais';
		}
	} else {
		$erro .= '&informacoesOficiais=dadosInvalidos';
	}
}


// INFORMAÇÕES EXTRAS
if ($editar == 'informacoesExtras' || $editar == 'editar') {
	$dataInicial = filter_input(INPUT_POST, 'dataIncioReal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$dataFinal = filter_input(INPUT_POST, 'dataEncerramentoReal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$orgaoResponsavel = filter_input(INPUT_POST, 'orgaoResponsavel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$dinheiroGasto = str_replace(',', '.', str_replace('.', '', filter_input(INPUT_POST, 'verbaUtilizada', FILTER_SANITIZE_FULL_SPECIAL_CHARS)));
	$situacao = filter_input(INPUT_POST, 'estadoAtual', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	// Verificando quais mudaram
	$modificados = [];
	$mValores = [];

	if ($dataInicial != $obra->getDataInicio()) {
		if ($ut->validarData($dataInicial)) {
			array_push($modificados, 'obra_data_inicio');
			array_push($mValores, $dataInicial);
		}
	}

	if ($dataFinal != $obra->getDataFinal()) {
		if ($ut->validarData($dataFinal)) {
			array_push($modificados, 'obra_data_final');
			array_push($mValores, $dataFinal);
		}
	}

	if ($orgaoResponsavel != $obra->getOrgaoResponsavel()) {
		if (v::stringType()->length(3, 50)->validate($orgaoResponsavel)) {
			array_push($modificados, 'obra_orgao_responsavel');
			array_push($mValores, $orgaoResponsavel);
		}
	}

	if ($dinheiroGasto != $obra->getDinheiroGasto()) {
		if (v::stringType()->notBlank()->validate($dinheiroGasto)) {
			array_push($modificados, 'obra_dinheiro_gasto');
			array_push($mValores, $dinheiroGasto);
		}
	}

	if ($situacao != $obra->getSituacao()) {
		if (v::stringType()->notBlank()->validate($situacao)) {
			array_push($modificados, 'obra_situacao');
			array_push($mValores, $situacao);
		}
	}

	// Atualizando no banco
	if (count($modificados) > 0 && count($modificados) == count($mValores)) {
		$daoConexao->atualizar('obras', $modificados, $mValores, 'obra_key = ?', [$key]);
		if ($daoConexao->linhasAfetadas() == 0) {
			$erro .= '&erro=NaoConseguimosSalvarAsInformacoesOficiais';
		}
	} else {
		$erro .= '&informacoesExtras=dadosInvalidos';
	}
}

if ($erro != $lerro) {
	$ut->h($erro . '&editar=' . $editar);
}

$ut->h($sucesso);