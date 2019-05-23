<?php
namespace fiscalizape\persistence;

new \fiscalizape\Autoload(['persistence', 'model'], [ ['DaoConexao', 'DaoObra'], 'Cidade']);

use \fiscalizape\model\Cidade;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\persistence\DaoObra;

class DaoCidade {
    private $conexao;
    private $listaCidades;
    private $cidade;

    public function __construct() {
        $this->conexao = new DaoConexao();
        $this->listaCidades = [];
    }

    public function listarCidades() {
        $resultado = $this->conexao->selecionar(['*'], 'cidades')->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($resultado as $l) {
            $this->cidade = new Cidade($l['cidade_id'], $l['cidade_nome'], $l['cidade_estado'], $l['cidade_area'], $l['cidade_populacao'], $l['cidade_prefeito']);
            array_push($this->listaCidades, $this->cidade);
        }
        return $this->listaCidades;
    }

    private function gerarString($array) {
        return implode(', ', $array);
    }

    public function procurarCidade($id) {
        // Buscando cidade no banco de dados
        $r = $this->conexao->selecionar(['*'], 'cidades', "md5(cidade_id) = ?", [$id])->fetch(\PDO::FETCH_ASSOC);
        $this->cidade = new Cidade(md5($r['cidade_id']), $r['cidade_nome'], $r['cidade_estado'], $r['cidade_area'], $r['cidade_populacao'], $r['cidade_prefeito']);

        return $this->cidade;
    }

    public function atualizarCidade($id, $campos, $valores) {
        $this->conexao->atualizar('cidades', $campos, $valores, 'md5(cidade_id) = ?', [$id]);
        if ($this->conexao->linhasAfetadas() > 0) {
            return true;
        }

        return false;
    }

	public function deletarCidade($id) {
		$this->conexao->deletar('cidades', 'md5(cidade_id)', $id);

		if ($this->conexao->linhasAfetadas() > 0) {
			return true;
		}

		return false;
	}

	private function getSituacoes($id) {
		return $this->conexao->selecionarFetch(['obra_situacao'], 'obras', 'md5(obra_id_cidade) = ?', [$id], true);
	}

	public function getObrasEmAndamento($id) {
		$situacoes = $this->getSituacoes($id);

		$emAndamento = 0;
		if ($situacoes != false) {
			for ($i = 0; $i < count($situacoes); $i++) {
				if ($situacoes[$i]['obra_situacao'] == 'Em Andamento') {
					$emAndamento++;
				}
			}
		}

		return $emAndamento;
	}

	public function getObrasParadas($id) {
		$situacoes = $this->getSituacoes($id);

		$paradas = 0;
		if ($situacoes != false) {
			for ($i = 0; $i < count($situacoes); $i++) {
				if ($situacoes[$i]['obra_situacao'] == 'Parada') {
					$paradas++;
				}
			}
		}

		return $paradas;
	}

	public function getNumeroObras($id) {
		$obras = $this->getSituacoes(md5($id));
		if ($obras == false) {
			return 0;
		}

		return count($obras);
	}
}

