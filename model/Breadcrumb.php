<?php
namespace fiscalizape\model;

require_once '../Autoload.php';
new \fiscalizape\Autoload('util', 'Script');

use \fiscalizape\util\Script;

class Breadcrumb {
	/**
	 * Gerar o menu de navegação (Breadcrump)
	 *
	 * obs: ignorar a home, já vem setada.
	 * obs2: a ultima pagina do array $paginas é automaticamente setada como ativa.
	 * @param mix[] $paginas Array contendo as paginas que <b>deve ser um array:<b> texto, link, icone = null.
	*/
	public static function gerar($paginas) {
		$index = 'index.php';

	    // Caso ele já esteja na index, home não será um link.
		$active = '';
		$aria_current = '';
		if (count($paginas) == 0) {
			$active = 'active';
			$aria_current = 'aria-current="page" title="Você está aqui"';
			$home = '<i class="fas fa-home"></i> Inicio';
		} else {
			$home = '<a href="'. $index . '"><i class="fas fa-home"></i> Inicio</a>';
		}

	    // Parte inicial do Breadcrumb
		$code = '<nav aria-label="breadcrumb"> <ol class="breadcrumb"> <li class="breadcrumb-item'. $active .'"' . $aria_current . '>' . $home . '</li>';

	    // Laço que vai criar as paginas
		for ($i = 0; $i < count($paginas); $i++) {
			if (count($paginas[$i]) == 3) {
				if ($i == count($paginas)-1) {
					$code .= '<li title="Você está aqui" class="breadcrumb-item active" aria-current="page"><i class="' . $paginas[$i]["icone"] . '"></i> ' . $paginas[$i]["texto"] . '</li>';
				} else {
					$code .= '<li class="breadcrumb-item"><a href="' . $paginas[$i]["link"] . '"><i class="' . $paginas[$i]["icone"] . '"></i> ' . $paginas[$i]["texto"] . '</a></li>';
				}
			} else {
				if ($i == count($paginas)-1) {
					$code .= '<li title="Você está aqui" class="breadcrumb-item active" aria-current="page">' . $paginas[$i]["texto"] . '</li>';
				} else {
					$code .= '<li class="breadcrumb-item"><a href="' . $paginas[$i]["link"] . '">' . $paginas[$i]["texto"] . '</a></li>';
				}
			}
		}

	    // Parte final do Breadcrumb
		$code .= '</ol> </nav>';

		echo $code;
	}

	public static function login() {
		return ["texto" => "Login", "link" => "login.php", "icone" => "fas fa-user-circle"];
	}

	public static function registrar() {
		return ["texto" => "Registrar-se", "link" => "registrar.php", "icone" => "fas fa-user-plus"];
	}

	public static function obras() {
		return ["texto" => "Obras", "link" => "obras.php", "icone" => "fas fa-toolbox"];
	}

	public static function obra($titulo, $id) {
		return ["texto" => $titulo, "link" => "obra.php?view=" . $id];
	}

	public static function editarObra() {
		return ["texto" => "Editar", "link" => "#"];
	}

	public static function novaObra() {
		return ["texto" => "Nova Obra", "link" => "novaobra.php"];
	}

	public static function novaDenunciaObra() {
		return ["texto" => "Nova Denúncia", "link" => "#"];
	}

	public static function denuncias() {
		return ["texto" => "Denúncias", "link" => "denuncias.php", "icone" => "fas fa-exclamation-circle"];
	}

	public static function usuarios() {
		return ["texto" => "Usuários", "link" => "#", "icone" => "fas fa-users"];
	}

	public static function perfil($nome, $id) {
		return ["texto" => $nome, "link" => "perfil.php?p=" . $id];
	}

	public static function cidades() {
		return ["texto" => "Cidades", "link" => "#", "icone" => "fas fa-city"];
	}

	public static function cidade($nome, $id) {
		return ["texto" => $nome, "link" => "cidade.php?p=" . $id];
	}
}