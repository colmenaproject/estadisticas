<?php

require 'conf/scripts_conf.php';
class Estadisticas {
   private $conn;
   private $dbprefix;
   private $columnas;
   private $resultados;

   function __construct() {
      $this->dbprefix = ScriptConf::$dbprefix;
      $this->columnas = ['gramos']; 
      /*Array con los nombres de las columnas de las cuales se desea calcular e insertar un total. 
      Funciona sobre la tabla iticket. TODO: hacer que la tabla también sea parámetro*/
      $this->resultados = $this->inicializarResultados();   
   }

   function inicializarResultados() {
      foreach($this->columnas as $columna) $this->resultados[$columna] = 0;      
   }

   function conectar() {
      $servername = ScriptConf::$servername;
      $username = ScriptConf::$username;
      $password = ScriptConf::$password;
      $dbname = ScriptConf::$dbname;

      $this->conn = new mysqli($servername, $username, $password, $dbname);
      if ($this->conn->connect_error)
         die("La conexión fall&oacute;: " . $conn->connect_error);
      
   }

   function calcular($isVerificado) { 
      foreach($this->columnas as $columna){ 
         $sql = 'SELECT SUM( ' . $columna . ' ) as total
                 FROM ' .$this->dbprefix . 'sistema_iticket
                 WHERE fecha_carga = \'' . date('Y-m-d') . '\'
                 AND estado = ' . $isVerificado . '';
                 if($result = $this->conn->query($sql)) {
                    $row = $result->fetch_assoc();
                    $this->resultados[$columna] = $row['total'] ? : 0;
                 } 
      }
   }

   function insertar($isVerificado) {
      $aInsertar = $this->calcular($isVerificado);
      $sql = 'INSERT INTO ' . $this->dbprefix . 'sistema_est_general (fecha, ' ;//
      foreach($this->columnas as $columna){
         $sql .= $columna . ',';
      }
      $sql .= ' verificado) VALUES  (\''. date('Y-m-d') .'\',';
      foreach($this->columnas as $columna){
         $sql .= $this->resultados[$columna] . ',';
      }
      $sql .= $isVerificado . ')';
      if ($this->conn->query($sql) === TRUE) {
         $msgVerificado = ($isVerificado)? "verificados" : "no verificados";
         echo "Hoy " . $hoy . ", se registraron " . $this->resultados[$columna] . " $columna $msgVerificado<br/>";   
      } else {
         echo "Error: " . $sql . "<br/>" . $this->conn->error;
      }   
   }

}

?>
