<?php
namespace fiscalizape;
require_once 'util/Util.php';
require_once 'util/Script.php';

use \fiscalizape\util\Util;
use \fiscalizape\util\Script;

/**
 * Classe que dar require_once nos diretorios usando caminhos absolutos.
 *
 * Obs: Recomendo apenas carregar (dar require) esta classe nos controllers e views, para evitar erros.
 *
 * @copyright (c) 2018-2019, João Vinezof, Fiscalizape.
*/
class Autoload {
	private $carregar;
	private $util;

	public function __construct($caminho='', $classe='') {
		if ($caminho <> '' && $caminho <> '') {
			$this->load($caminho, $classe);
		}

		$this->util = new Util();
	}

	public function load ($caminho, $classe){
		$root = str_replace("\\", "/", __DIR__);

        # Verificando se foi passado um array
		if (is_array($caminho) && is_array($classe)) {
            # Se sim, declaramos carregar como um array e criamos o caminho para todos
			$this->carregar = array();
			for ($i = 0; $i < count($caminho); $i++) {
				if (is_array($classe[$i])) {
					for ($j = 0; $j < count($classe[$i]); $j++) {
						$this->carregar[$i][$j] = $root . "/" . $caminho[$i] . "/" . $classe[$i][$j] . ".php";
					}
				} else {
					$this->carregar[$i] = $root . "/" . $caminho[$i] . "/" . $classe[$i] . ".php";
				}
			}

            # Agora verificamos se o arquivo existe, precisamos de um laço
            # já que vamos verificar varios arquivos
			for ($i = 0; $i < count($this->carregar); $i++) {
				if (is_array($this->carregar[$i])) {
					for ($j = 0; $j < count($this->carregar[$i]); $j++) {
						if (file_exists($this->carregar[$i][$j])) {
							require_once $this->carregar[$i][$j];
						} else {
							echo "fiscalizape autoload: " . $this->carregar[$i][$j] . "<br>";
							return false;
						}
					}
				} else {
					if (file_exists($this->carregar[$i])) {
	                    # Se existir carregamos ele
						require_once $this->carregar[$i];
					} else {
	                    # Se não, imprimimos o caminho
						echo "fiscalizape autoload: " . $this->carregar[$i];
						return false;
					}
				}

			}

		} else if (is_array($caminho) || is_array($classe)) {
            # Verificamos se apenas um é array
			return false;
		} else {
            # Se não for array carregamos o unico arquivo
			$this->carregar = $root . "/" . $caminho . "/" . $classe . ".php";
			if (file_exists($this->carregar)) {
				require_once $this->carregar;
			} else {
				echo "fiscalizape autoload: " . $this->carregar;
				return false;
			}
		}

		return true;
	}
}