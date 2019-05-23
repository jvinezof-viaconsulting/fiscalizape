<?php
namespace fiscalizape\persistence;

new \fiscalizape\Autoload(['model', 'persistence'], [ ['Obra', 'ObraImagem', 'ObraVerdade'], ['DaoConexao', 'DaoUsuario', 'DaoCidade', 'DaoUsuario'] ]);

use \fiscalizape\model\Obra;
use \fiscalizape\model\ObraImagem;
use \fiscalizape\model\ObraVerdade;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\persistence\DaoCidade;
use \fiscalizape\persistence\DaoUsuario;

/**
 *
 * Classe que manipula os dados das obras.
 *
 * @param array $imagens Array de objetos ObraImagem;
 * @param array $verdades Array de objetos ObraVerdade;
 *
 * @copyright (c) 2018, FiscalizaPE
 *
 */
class DaoObra {
	// Objetos Externos
	private $conexao;
	private $daoUsuario;
	private $daoCidade;

	// Atributos internos da classe
	private $obras;
	private $imagens;
	private $verdades;

	public function __construct() {
		// Instanciando classes
		$this->conexao = new DaoConexao();
		$this->daoUsuario = new DaoUsuario();
		$this->daoCidade = new DaoCidade();

		// Inicializando arrays
		$this->imagens = [];
		$this->verdades = [];
		$this->obras = [];
	}

	private function listarImagens($id, $tudo = false) {
		if ($tudo == true) {
			$excluidas = 'AND obra_imagem_excluida = 0 AND obra_imagem_excluida = 1';
		} else {
			$excluidas = 'AND obra_imagem_excluida = 0';
		}

		// Pegando todas as imagens da obra
		$imagensObra = $this->conexao->selecionarFetch(['obra_imagem_id', 'obra_imagem_nome'], 'obras_imagens', "obra_imagem_obra_id = ? $excluidas", [$id], true);

		// Se não existir nada na tabela retorna false, precisamos do if para evitar erros
		if ($imagensObra != false) {
			// Instanciando objetos e guardando no array imagens
			foreach ($imagensObra as $imagem) {
				array_push($this->imagens, new ObraImagem($imagem['obra_imagem_id'], $imagem['obra_imagem_nome']));
			}

			return $this->imagens;
		}

		return false;
	}

	private function listarVerdades($id, $excluidos = false) {
		// Definindo se vamos listar votos excluidos
		if ($excluidos) {
			$votos = 'obra_verdade_excluido = 1';
		} else if ($excluidos == false) {
			$votos = 'obra_verdade_excluido = 0';
		} else {
			$votos = 'obra_verdade_excluido = 0 AND obra_verdade_excluido = 1';
		}

		// Pegando todas as avaliações (verdades) da obra
		$verdadesObra = $this->conexao->selecionarFetch(['obra_verdade_id', 'obra_verdade_usuario_id', 'obra_verdade_voto', 'obra_verdade_data_criacao'], 'obras_verdades', "obra_verdade_obra_id = ? AND $votos", [$id], true);

		// Se não existir nada na tabela retorna false, precisamos do if para evitar erros
		if ($verdadesObra != false) {
			// Instanciando objetos e guardando no array imagens
			foreach ($verdadesObra as $verdade) {
				// Pegando usuario que votou
				$usuario = $this->daoUsuario->procurarPerfil(md5($verdade['obra_verdade_usuario_id']));

				array_push($this->verdades, new ObraVerdade($verdade['obra_verdade_id'], $usuario, $verdade['obra_verdade_voto'], $verdade['obra_verdade_data_criacao']));
			}

			return $this->verdades;
		}

		return false;
	}

	public function listarObras($filtros = []) {
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

		// Recuperando dados de obras
		$obras = $this->conexao->selecionarFetch(['*'], 'obras', $where, $valoresWhere, true);

		if ($obras != false) {
			foreach ($obras as $obra) {
				// Listando imagens da obra
				$this->imagens = $this->listarImagens($obra['obra_id']);

				// Listando verdades da obra
				$this->verdades = $this->listarVerdades($obra['obra_id']);

				// Pegando perfil do contribuidor
				$contribuidor = $this->daoUsuario->procurarPerfil(md5($obra['obra_contribuidor_id']));

				// Pegando cidade
				$cidade = $this->daoCidade->procurarCidade(md5($obra['obra_id_cidade']));

				// Instanciando o objeto
				array_push($this->obras, new Obra($obra['obra_id'], $obra['obra_key'], $obra['obra_titulo'], $obra['obra_descricao'], $this->imagens, $obra['obra_data_inicio_prevista'], $obra['obra_data_final_prevista'], $obra['obra_orcamento_previsto'], $contribuidor, $obra['obra_rua'], $obra['obra_bairro'], $cidade, $obra['obra_data_criacao'], $obra['obra_data_inicio'], $obra['obra_data_final'], $obra['obra_situacao'], $obra['obra_orgao_responsavel'],  $obra['obra_empresa_responsavel'], $obra['obra_dinheiro_gasto'], $this->verdades, $obra['obra_cep']));

				// Limpando arrays
				$this->imagens = [];
				$this->verdades = [];
			}

			// Retornando array de obras
			return $this->obras;
		}

		return false;
	}

	public function procurarObra($key, $filtros = []) {
		$where = 'obra_key = ? ';
		$valoresWhere = [$key];

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

		// Pegando obra
		$obra = $this->conexao->selecionarFetch(['*'], 'obras', $where, $valoresWhere);

		if ($obra != false) {
			// Pegando imagens
			$this->listarImagens($obra['obra_id']);

			// Pegando verdades
			$this->listarVerdades($obra['obra_id']);

				// Pegando perfil do contribuidor
				$contribuidor = $this->daoUsuario->procurarPerfil(md5($obra['obra_contribuidor_id']));

				// Pegando cidade
				$cidade = $this->daoCidade->procurarCidade(md5($obra['obra_id_cidade']));

				// Instanciando o objeto
				$objetoObra = new Obra($obra['obra_id'], $obra['obra_key'], $obra['obra_titulo'], $obra['obra_descricao'], $this->imagens, $obra['obra_data_inicio_prevista'], $obra['obra_data_final_prevista'], $obra['obra_orcamento_previsto'], $contribuidor, $obra['obra_rua'], $obra['obra_bairro'], $cidade, $obra['obra_data_criacao'], $obra['obra_data_inicio'], $obra['obra_data_final'], $obra['obra_situacao'], $obra['obra_orgao_responsavel'],  $obra['obra_empresa_responsavel'], $obra['obra_dinheiro_gasto'], $this->verdades, $obra['obra_cep']);

				// Limpando arrays
				$this->imagens = [];
				$this->verdades = [];

				// Retornando objeto Obra
				return $objetoObra;
		}

		return false;
	}

	public function numeroVerdades($verdades) {
		$numVerdades = 0;
		if ($verdades != false && is_array($verdades)) {
			foreach ($verdades as $v) {
				if ($v instanceof ObraVerdade) {
					if ($v->getVoto() == 1) {
						$numVerdades++;
					}
				}
			}
		}

		return $numVerdades;
	}

	public function numeroMentiras($verdades) {
		$numMentiras = 0;
		if ($verdades != false && is_array($verdades)) {
			foreach ($verdades as $v) {
				if ($v instanceof ObraVerdade) {
					if ($v->getVoto() == 0) {
						$numMentiras++;
					}
				}
			}
		}

		return $numMentiras;
	}

	public function jaVotei($idUsuario, $verdades = false, $idObra = '') {
		if ($verdades == false || !is_array($verdades)) {
			$verdades = $this->listarVerdades($idObra);
		}

		if ($verdades != false && is_array($verdades)) {
			foreach ($verdades as $v) {
				if ($v instanceof ObraVerdade) {
					if ($v->getUsuario()->getId() == $idUsuario) {
						return $v;
					}
				}
			}
		}

		return false;
	}

	public function votosExcluidos($idObra) {
		$votos = [];
		$votosExcluidos = $this->listarVerdades($idObra, true);
		if ($votosExcluidos != false) {
			foreach ($votosExcluidos as $voto) {
				array_push($votos, $voto);
			}
		}

		return $votos;
	}

	public function meuVotoExcluido($idObra, $idUsuario) {
		$votos = $this->votosExcluidos($idObra);
		foreach ($votos as $voto) {
			if ($voto->getUsuario()->getId() == $idUsuario) {
				return $voto;
			}
		}

		return false;
	}

	public function adicionarVerdade($idUsuario, $idObra, $voto, $acao) {
		$idUsuarioInt = $this->conexao->selecionarDado('usuario_id', 'usuarios', 'md5(usuario_id) = ?', [$idUsuario]);
		$idObraInt = $this->conexao->selecionarDado('obra_id', 'obras', 'md5(obra_id) = ?', [$idObra]);
		$votoAtual = $this->jaVotei($idUsuario, false, $idObraInt);

		// Verificando se o usuario já votou
		if ($votoAtual != false) {
			// Verificando a acao
			if ($acao == '+') {
				// Atualizando no banco
				$this->conexao->atualizar('obras_verdades', ['obra_verdade_voto'], [$voto], 'obra_verdade_obra_id = ? AND obra_verdade_usuario_id = ?', [$idObraInt, $idUsuarioInt]);

				if ($this->conexao->linhasAfetadas() > 0) {
					return true;
				}

				return false;
			} else {
				// Removendo voto do usuario
				$this->conexao->atualizar('obras_verdades', ['obra_verdade_voto', 'obra_verdade_excluido'], [$voto, 0], 'obra_verdade_id = ?', [$votoAtual->getId()]);

				if ($this->conexao->linhasAfetadas() > 0) {
					return true;
				}

				return false;
			}
		} else {
			$votoExcluido = $this->meuVotoExcluido($idObraInt, $idUsuario);
			if ($votoExcluido != false) {
				$this->conexao->atualizar('obras_verdades', ['obra_verdade_voto', 'obra_verdade_excluido'], [$voto, 0], 'obra_verdade_obra_id = ? AND obra_verdade_usuario_id = ?', [$idObraInt, $idUsuarioInt]);

				return true;
			}

			$this->conexao->inserir('obras_verdades', ['obra_verdade_usuario_id', 'obra_verdade_obra_id', 'obra_verdade_voto'], [$idUsuarioInt, $idObraInt, $voto]);

			if ($this->conexao->linhasAfetadas() > 0) {
				return true;
			}
		}

		return false;
	}
}