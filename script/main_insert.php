<?php


require 'insert_gramos.php';

$estadisticas = new Estadisticas();
$estadisticas->conectar();
$gramosVerificados = $estadisticas->insertarGramosVerificados();

?>