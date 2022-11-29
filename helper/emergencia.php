<?php

// $servername = "ginthersoft.com";
$servername = "gintestcorp.com";
$username = "pruebagi_sistemas";
$password = "Pass123#$%.";
$dbname = "pruebagi_ginthercorp3";


// $servername = "gintestcorp.com";
// $servername = "localhost";
// $username = "pruebagi_sistemas";
// $password = "Pass123#$%.";
// $dbname = "pruebagi_ginthercorp";

$html='';

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "CALL calcular_nomina(8,2022,17,'2022-04-14','2022-04-28',1);";

$resultado = $conn->query($query);

if($resultado){
    // print_r($resultado);
    while($registro = mysqli_fetch_array($resultado)){
        var_dump($registro);
    }
}