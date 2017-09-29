<h1>insert gramos</h1>
<form action="self" method="POST">
<input type="submit" value="Enviar"></input>
</form>
<?php
/*
include 'scripts_conf.php';
/* include for:
$servername
$username
$password
$dbname
$dbprefix
*/

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
} 

$gramos = calcularGramos();

$sql = 'INSERT INTO' . $dbprefix . 'est_general (fecha, gramos) VALUES (null,' . $gramos . ')';
//usando "null" como parámetro y current_timestamp en la db

if ($conn->query($sql) === TRUE) {
    echo "Se creó un nuevo registro exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

function calcularGramos() {
	return 100;
}

?>
