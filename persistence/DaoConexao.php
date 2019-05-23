<?php
namespace fiscalizape\persistence;
new \fiscalizape\Autoload("model", "Conexao");
use \fiscalizape\model\Conexao;
/**
 *
 * Classe que manipula a conexão com o banco de dados
 *
 * @copyright (c) 2018, João Vinezof FISCALIZAPE
 *
 */
class DaoConexao extends Conexao {
	// Atributo que vai receber a conexão
	private $conexao;

	// Contador que vai ser usado para dar bindValue dinamicamente em todos os valores passados
	private $contador;

	/**
	 * Metodo que vai dar prepared statement (stmt) na query
	 *
	 * @param string $sql String contendo a query que vai receber prepare
	 * @param array Array contendo os valores que vão ser adicionados a query
	 */
	private function stmt($sql, $valores) {
		try {
			// Recebendo o PDO conectado ao banco e dando prepare na query
			$this->conexao = $this->conectar()->prepare($sql);
			// Lendo quantidade de valores para darmos bindValue na query
			$this->contador = count($valores);

			// Dando bindValue em todos os valores passados
			// For iniciador por 1 porque os bindValues são numerados a partir de 1
			for ($i = 1; $i <= $this->contador; $i++) {
				$this->conexao->bindValue($i, $valores[$i-1]);
			}

			$this->conexao->execute();
		} catch (\PDOException $e) {
			echo $e->getCode(); echo ' '; echo $e->getMessage();
		}
	}

	// Metodo que gera uma string com interrogações para cada valor passado no array
	private function gerarInterrogacoes($valores) {
		$valoresTemp = '';

		for ($i = 0; $i < count($valores); $i++) {
			if ($i == count($valores)-1) {
				$valoresTemp .= '?';
			} else {
				$valoresTemp .= '?, ';
			}
		}

		return $valoresTemp;
	}

	// Metodo que gera uma string set com os campos e valores passados, limpando todas as colunas
	private function gerarSet($colunas) {
		$set = '';

		for ($i = 0; $i < count($colunas); $i++) {
			$coluna = filter_var($colunas[$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			if (count($colunas) == $i+1) {
				$set .= $coluna . ' = ?';
			} else {
				$set .= $coluna . ' = ?, ';
			}
		}

		return $set;
	}

	// Limpa todos os indeces do array e gera uma string contendo todos os indeces separados por virgula
	private function limparColunas($colunas) {
		$stringColunas = '';

		for ($i = 0; $i < count($colunas); $i++) {
			$coluna = filter_var($colunas[$i], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

			if (count($colunas) == $i+1) {
				$stringColunas .= $coluna;
			} else {
				$stringColunas .= $coluna . ', ';
			}
		}

		return $stringColunas;
	}

	/**
	 * Metodo que insere valores no banco de dados
	 *
	 * @param string $tabela Nome da tabela em que os dados vão ser inseridos
	 * @param array $colunas Nomes das colunas em que os dados serão inseridos
	 * @param array $valores Valores que serão inseridos nas colunas
	*/
	public function inserir($tabela, $colunas, $valores) {
		$tabela = filter_var($tabela, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$stringColunas = $this->limparColunas($colunas);
		$interrogacoes = $this->gerarInterrogacoes($valores);

		$sql = "INSERT INTO $tabela($stringColunas) VALUES ($interrogacoes)";
		$this->stmt($sql, $valores);

		return $this->conexao;
	}

	/**
	 * Metodo que seleciona dados no banco de dados.
	 * Uso: ser for usar condição usar interrogações ao inves de valores
	 *
	 * @example SEM where selecionar('c1, c2', 't1')
	 * @example COM where selecionar('c1, c2', 't1', 'id = ? AND email = ?', 'array(id, email)');
	 *
	 * @param array $colunas Colunas que vão ser selecionadas
	 * @param string $tabela Tabela que terá seus dados selecionados
	 * @param string $condicao String contendo a cláusula WHERE, usando interrogações (opcional)
	 * @param array $valores Array com os valores que vão substituir as interrogações da cláusula where (apenas se $condicao != null)
	*/
	public function selecionar($colunas, $tabela, $condicao = '', $valores = []) {
		$stringColunas = $this->limparColunas($colunas);
		$tabela = filter_var($tabela, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if ($condicao == '') {
			$sql = "SELECT $stringColunas FROM $tabela";
		} else {
			$sql = "SELECT $stringColunas FROM $tabela WHERE $condicao";
		}

		$this->stmt($sql, $valores);

		return $this->conexao;
	}

	/**
	 * Metodo que seleciona dados no banco de dados e <b>retorna um array associativo</b>.
	 * Uso: ser for usar condição usar interrogações ao inves de valores
	 *
	 * @example SEM where selecionar('c1, c2', 't1')
	 * @example COM where selecionar('c1, c2', 't1', 'id = ? AND email = ?', 'array(id, email)');
	 *
	 * @param array $colunas Colunas que vão ser selecionadas
	 * @param string $tabela Tabela que terá seus dados selecionados
	 * @param string $condicao String contendo a cláusula WHERE, usando interrogações (opcional)
	 * @param array $valores Array com os valores que vão substituir as interrogações da cláusula where (apenas se $condicao != null)
	 * @param bool $all Indica se vai utilizar a função fetch ($all = false (default)) ou fetchAll ($all = true)
	*/
	public function selecionarFetch($colunas, $tabela, $condicao = '', $valores = [], $all = false) {
		if ($all) {
			return $this->selecionar($colunas, $tabela, $condicao, $valores)->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $this->selecionar($colunas, $tabela, $condicao, $valores)->fetch(\PDO::FETCH_ASSOC);
	}

	/**
	 * Metodo que seleciona dados no banco de dados e <b>retorna um array associativo</b>.
	 * Uso: ser for usar condição usar interrogações ao inves de valores
	 *
	 * @example SEM where selecionar('c1, c2', 't1')
	 * @example COM where selecionar('c1, c2', 't1', 'id = ? AND email = ?', 'array(id, email)');
	 *
	 * @param array $colunas Colunas que vão ser selecionadas
	 * @param string $tabela Tabela que terá seus dados selecionados
	 * @param string $condicao String contendo a cláusula WHERE, usando interrogações (opcional)
	 * @param array $valores Array com os valores que vão substituir as interrogações da cláusula where (apenas se $condicao != null)
	 * @param string Dado que vai ser pego, deve ter o mesmo nome da coluna do banco.
	*/
	public function selecionarDado($dado, $tabela, $condicao, $valores) {
		$result = $this->selecionarFetch([$dado], $tabela, $condicao, $valores);
		return $result[$dado];
	}

	/**
	 * Metodo que atualiza dados no banco de dados
	 * quando for usar a cláusula WHERE passar interrogações ao invés do valor, os valores reais
	 * devem ser passados no array $valores
	 *
	 * @param string $tabela Tabela que tera seus dados atualizados
	 * @param array $colunas Array contendo as colunas que seram atualizadas, colunas[0] = valores[0]
	 * @param array $valores Array contendo os novos valores da coluna, valores[0] = colunas[0]
	 * @param string $condicao Cláusula WHERE
	*/
	public function atualizar($tabela, $colunas, $valores, $condicao, $valoresWhere) {
		$tabela = filter_var($tabela, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$valores = array_merge($valores, $valoresWhere); // Juntando o array $valores com o array $valoresWhere
		$set = $this->gerarSet($colunas);

		$sql = "UPDATE $tabela SET $set WHERE $condicao";
		$this->stmt($sql, $valores);

		return $this->conexao;
	}

	/**
	 * Metodo que deleta registros no banco de dados
	 * <b>Obs:</b> Só pode ser deletada uma linha por vez
	 *
	 * @param string $tabela Tabela em que o registro vai ser deletado
	 * @param string $primaryKey Identificador unico da tabela
	 * @param string $valor Valor que identifica unicamente o registro
	*/
	public function deletar($tabela, $primaryKey, $valor) {
		$tabela = filter_var($tabela, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$primaryKey = filter_var($primaryKey, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$valor = filter_var($valor, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$sql = "DELETE FROM $tabela WHERE $primaryKey = ?";
		$this->stmt($sql, [$valor]);

		return $this->conexao;
	}

	public function linhasAfetadas() {
		return $this->conexao->rowCount();
	}
}