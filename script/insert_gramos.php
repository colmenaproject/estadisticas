<?php

global $servername,
$username,
$password,
$dbname,
$dbprefix;
require 'scripts_conf.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
	die("La conexión falló: " . $conn->connect_error);
} 

function calcularGramosVerificados() {
	$gramosVerificados = 0;
	$sql = 'SELECT SUM( peso )
	FROM pzj13_sistema_iticket
	WHERE fecha_carga = ' . date('Y-m-d') . '
	AND verificado = 1';
	if($result = $conn->query($sql), MYSQLI_USE_RESULT) {
		$gramosVerificados = $result;
	}
	return "$result";
}


$gramosVerificados = calcularGramosVerificados();

$sql = 'INSERT INTO ' . $dbprefix . 'est_general (fecha, gramos) VALUES (null,' . $gramos . ')';
//usando "null" como parámetro y current_timestamp en la db

if ($conn->query($sql) === TRUE) {
	echo "Se creó un nuevo registro exitosamente";
} else {
	echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
