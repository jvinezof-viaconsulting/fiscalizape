<?php
namespace fiscalizape\util;

class Script {
	public function scriptAtual() {
		$path = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$script = explode("/", $path);
		$script = end($script);
		return $script;
	}

	public static function caminhoScript() {
		$path = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$script = explode("/", $path);
		$end = count($script) - 2;
		return $script[$end++] . '/' . $script[$end];
	}

	public static function caminho() {
		$path = filter_var($_SERVER['PHP_SELF'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$script = explode("/", $path);
		$end = count($script) - 2;
		return $script[$end];
	}
}