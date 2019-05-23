<?php
require_once '../vendor/autoload.php';
require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence', 'util'], [['Sessao', 'DaoConexao'], 'Util']);

use Respect\Validation\Validator as v;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\util\Util;
use \fiscalizape\persistence\DaoConexao;

/*
 * Variaveis importantes
*/

$daoConexao = new DaoConexao();
$util = new Util();
$sessao = new Sessao();
$usuario = $sessao->getSessaoUsuario();

// Redirecionamentos
$sucesso = 'Location: ../view/obra.php?view=';
$erro = 'Location: ../view/novaobra.php?erro=';

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
 * Validações
*/

// Titulo
if (v::stringType()->length(5, 50)->validate($tituloObra)) {
	// Descrição
	if (v::stringType()->length(10, 3000)->validate($descricao)) {
		// Cidade ID
		if (v::intType()->validate($cidadeId)) {
			// Verba Inicial
			if (v::stringType()->length(1, 20)->validate($verbaInicial)) {
				// Validação da data inicial prevista
				if ($util->validarData($dataIncialPrevista)) {
					// Validação para a data final prevista
					if ($util->validarData($dataFinalPrevista)) {
						// Verificando se a data final é maior que a inicial, do contrario não faz sentido
						if ($dataFinalPrevista > $dataIncialPrevista) {
							/*
							 * Inserindo dados obrigatorios no banco
							 * dados opcionais é em seguida
							*/

							$key = md5(uniqid(mt_rand(), true));
							$colunas = ['obra_key', 'obra_id_cidade', 'obra_titulo', 'obra_descricao', 'obra_data_inicio_prevista', 'obra_data_final_prevista', 'obra_orcamento_previsto', 'obra_contribuidor_id', 'obra_rua', 'obra_bairro'];
							$valores = [$key, $cidadeId, $tituloObra, $descricao, $dataIncialPrevista, $dataFinalPrevista, $verbaInicial, $idContribuidor, $rua, $bairro];
							$daoConexao->inserir('obras', $colunas, $valores);

							if ($daoConexao->linhasAfetadas() > 0) {
								/*
								 * Verificando dados opcionais preenchidos
								 * e inserindo no banco de dados
								*/

								$erros = [];

								// Data Inicial
								if (v::notBlank()->validate($dataInicial)) {
									if ($util->validarData($dataInicial)) {
										$daoConexao->atualizar('obras', ['obra_data_inicio'], [$dataInicial], 'obra_key = ?', [$key]);

										if ($daoConexao->linhasAfetadas() == 0) {
											array_push($erros, 'dataInicialInvalida');
										}
									}
								}

								// Data Final, a data final, obviamente, deve ser maior que a data inicial
								if (v::notBlank()->validate($dataFinal)) {
									if ($util->validarData($dataFinal)) {
										if ($dataInicial != "" && $dataFinal < $dataInicioReal) {
											array_push($erros, 'dataFinalInvalida');
										} else {
											$daoConexao->atualizar('obras', ['obra_data_final'], [$dataFinal], 'obra_key = ?', [$key]);

											if ($daoConexao->linhasAfetadas() == 0) {
												array_push($erros, 'dataFinalInvalida');
											}
										}
									}
								}

								// Orgão Responsavel
								if (v::stringType()->length(3, 50)->validate($orgao)) {
									$daoConexao->atualizar('obras', ['obra_orgao_responsavel'], [$orgao], 'obra_key = ?', [$key]);

									if ($daoConexao->linhasAfetadas() == 0) {
										array_push($erros, 'orgaoResponsavelInvalido');
									}
								}

								if (v::stringType()->notBlank()->validate($verbaUtilizada)) {
									$daoConexao->atualizar('obras', ['obra_dinheiro_gasto'], [$verbaUtilizada], 'obra_key = ?', [$key]);

									if ($daoConexao->linhasAfetadas() == 0) {
										array_push($erros, 'verbaUtilizadaInvalida');
									}
								}

								if (v::stringType()->notBlank()->validate($situacao)) {
									$daoConexao->atualizar('obras', ['obra_situacao'], [$situacao], 'obra_key = ?', [$key]);

									if ($daoConexao->linhasAfetadas() == 0) {
										array_push($erros, 'situacaoInvalida');
									}
								}

								/*
								 * Movendo as fotos e adicionando no banco de dados
								*/
								$errosImagens = [];

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
												array_push($errosImagens, 'Não conseguimos salvar a imagem: ' . $fotos['name'][$i]);
											}
										} else {
											array_push($errosImagens, 'Imagem: ' . $fotos['name'][$i] . ' tem uma extensão inválida');
										}
									}
								}

								/*
								 * Ocorreu tudo bem! vamos redirecionar para algum lugar
								*/

								$stringErros = implode("&", $erros);
								$stringErrosImagem = implode("&", $errosImagens);
								$util->h($sucesso.$key . '&erros='.$stringErros . '&errosImagens='.$stringErrosImagem);

							} else {
								//$util->h($erro . 'naoConseguimosCadastrarSuaObra');
							}
						} else {
							$util->h($erro . 'datasInvalidas');
						}
					} else {
						$util->h($erro . 'dataPrevistaEncerramentoInvalida');
					}
				} else {
					$util->h($erro . 'dataPrevistaInicialInvalida');
				}
			} else {
				$util->h($erro . 'VerbaInicialInvalida');
			}
		} else {
			$util->h($erro . 'cidadeInvalida');
		}
	} else {
		$util->h($erro . 'descricaoInvalida?dica=MuitoGrandeOuMuitoPequena');
	}
} else {
	$util->h($erro . 'tituloInvalido');
}