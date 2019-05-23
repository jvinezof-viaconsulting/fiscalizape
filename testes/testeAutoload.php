<?php
require_once '../Autoload.php';
new \fiscalizape\Autoload(['persistence', 'model', 'util'], [['DaoCidade', 'DaoConexao', 'Sessao'], 'Email', 'Script']);

use \fiscalizape\persistence\DaoCidade;
use \fiscalizape\persistence\DaoConexao;
use \fiscalizape\persistence\Sessao;
use \fiscalizape\model\Email;
use \fiscalizape\util\Script;

$script = new Script();
$c = new DaoCidade();
$con = new DaoConexao();
$s = new Sessao();
$e = new Email();

var_dump($c); echo '<br><br>';
var_dump($con); echo '<br><br>';
var_dump($s); echo '<br><br>';
var_dump($e); echo '<br><br>';
var_dump($script->scriptAtual());