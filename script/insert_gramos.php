<?php

require 'conf/scripts_conf.php';
class Estadisticas {
	private $conn;
	private $dbprefix;

	function __construct() {
		$this->dbprefix = ScriptConf::$dbprefix;	
	}

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
		return $this->calcularGramos(1);		
	}

	function calcularGramos($isVerificado) {
		$gramos = 0;
		$sql = 'SELECT SUM( gramos ) as totalGramos
				FROM ' .$this->dbprefix . 'sistema_iticket
				WHERE fecha_carga = \'' . date('Y-m-d') . '\'
				AND estado = ' . $isVerificado . '';
		if($result = $this->conn->query($sql)) {
			$row = $result->fetch_assoc();
			$gramos = $row['totalGramos'];
		}
		return $gramos;
	}

	function insertarGramosVerificados() {
		$gramosVerificados = $this->calcularGramosVerificados();
		$sql = 'INSERT INTO ' . $this->dbprefix . 'sistema_est_general (fecha, gramos)
				VALUES (\''. date('Y-m-d') .'\',' . $gramosVerificados . ')';
		if ($this->conn->query($sql) === TRUE) {
			echo "Se creó un nuevo registro exitosamente";
		} else {
			echo "Error: " . $sql . "<br>" . $this->conn->error;
		}
	}

}

?>