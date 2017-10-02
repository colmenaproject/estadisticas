<?php


require 'insert_gramos.php';

$estadisticas = new Estadisticas();
$estadisticas->conectar();
$estados = [0, 1];
foreach($estados as $isVerificado) {
	$estadisticas->insertar($isVerificado);	
}
?>