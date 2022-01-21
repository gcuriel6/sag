<?php

	//header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$registro = $_REQUEST['registro'];
	$id_puesto = $_REQUEST['id_puesto'];
	$oficiales = $_REQUEST['oficiales'];
	$sueldo = $_REQUEST['sueldo'];
	$bono = $_REQUEST['bonos'];
	$extra = $_REQUEST['extras'];
	$bono_var = $_REQUEST['bono_var'];
	$observaciones = $_REQUEST['observaciones'];
	
	$query = 'UPDATE presupuesto 
	SET id_puesto = '.$id_puesto.',oficiales = '.$oficiales.',sueldo_quincena = '.$sueldo.',bono_quincena = '.$bono.',bono_variable = '.$bono_var.',tiempos_extras = '.$extra.',observaciones = "'.$observaciones.'" WHERE registro = '.$registro;
	$resultado = mysqli_query($link, $query);

	if($resultado){
		echo 1;
	}
	else{
		echo $resultado;
	}
	
?>