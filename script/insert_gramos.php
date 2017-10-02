<?php

require 'conf/scripts_conf.php';
class Estadisticas {
	private $conn;

function conectar() {
	$servername = ScriptConf::$servername;
	$username = ScriptConf::$username;
	$password = ScriptConf::$password;
	$dbname = ScriptConf::$dbname;

	$this->conn = new mysqli($servername, $username, $password, $dbname);
	if ($this->conn->connect_error) {
		die("La conexión falló: " . $conn->connect_error);
	} 
}

function calcularGramosVerificados() {
	$gramosVerificados = 0;
	$dbprefix = ScriptConf::$dbprefix;

	$sql = 'SELECT SUM( gramos )
	FROM ' .$dbprefix . '_sistema_iticket
	WHERE fecha_carga = \'' . date('Y-m-d') . '\'
	AND estado = 1';
	
	if($result = $this->conn->query($sql)) {
		$gramosVerificados = $result;
	}
	
}

function insertarGramosVerificados() {
	$gramosVerificados = calcularGramosVerificados();
	$sql = 'INSERT INTO ' . $dbprefix . 'est_general (fecha, gramos) VALUES (null,' . $gramos . ')';
	//usando "null" como parámetro y current_timestamp en la db
	if ($conn->query($sql) === TRUE) {
		echo "Se creó un nuevo registro exitosamente";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

}

?>