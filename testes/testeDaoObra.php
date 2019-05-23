<?php
require_once '../persistence/DaoObra.php';

use \fiscalizape\persistence\DaoObra;

$daoObra = new DaoObra();

echo '<pre>';
var_dump($daoObra->listarObras());
echo '</pre>';