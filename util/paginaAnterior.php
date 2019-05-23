<?php

$load = new \fiscalizape\Autoload('util', 'Script');

use \fiscalizape\util\Script;

$script = new Script();

$scriptAtual = $script->scriptAtual();
if (isset($_COOKIE['paginaVoltar'])) {
	if ($_COOKIE['paginaVoltar'] != $scriptAtual) {
		setcookie('paginaVoltar', $scriptAtual, time()+3600, '/');
	}
} else {
	setcookie('paginaVoltar', $scriptAtual, time()+3600, '/');
}

if ($scriptAtual != 'login.php') {
	$urli = basename($_SERVER["REQUEST_URI"]);
	setcookie('paginaVoltarx2', serialize($urli), time()+3600, '/');
}