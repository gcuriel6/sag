<?php

include '../../php/conectar.php';
$link = Conectarse();

$fecha = $_REQUEST["fecha"];

$query = "SELECT CURDATE() AS hoy,DAYOFWEEK(CURDATE()) AS diasemana, DATE_SUB(CURDATE(), INTERVAL 1 DAY) AS ayer,DATE_SUB(CURDATE(), INTERVAL 2 DAY) AS anteayer";
$result = mysqli_query($link,$query);
$row = mysqli_fetch_array($result);
	$dia = $row["diasemana"];

	$hoy = $row["hoy"];
	if ($dia != 2) {
		$ayer = $row["ayer"];
		$anteayer = $row["ayer"];
	} else {

		$ayer = $row["ayer"];
		$anteayer = $row["anteayer"];
	}

	$query = "SELECT a.captura_quincena,a.fecha_limite,b.fec_ini FROM variables_app a LEFT JOIN periodos b ON b.fec_ini <= CURDATE() AND b.fec_fin >= CURDATE()";
	$result = mysqli_query($link,$query);
	$row = mysqli_fetch_array($result);

	if ($row['captura_quincena'] == 0){
		$fhasta = $anteayer;
		
	}	
	else{
		$fhasta = $row['fecha_limite'];
		
	}

	$query = "SELECT IF('".$fecha."'<'".$fhasta."',0,1) as condicion";
	$result = mysqli_query($link,$query);
	$row = mysqli_fetch_array($result);
	
	echo $row['condicion'];
	
mysqli_free_result($result);
?>