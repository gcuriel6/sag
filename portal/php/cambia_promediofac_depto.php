<?php

	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	$promediofac = $_REQUEST["promediofac"];
	
	$query = "INSERT INTO facturacion_prom (fact_prom,id_depto) VALUES ('$promediofac','$id_depto')";
	if($result=mysqli_query($link, $query)){
		$query = "UPDATE contratos_cliente SET promediofac = '".$promediofac."' WHERE id_depto = ".$id_depto;
		$result=mysqli_query($link, $query);
	}
	
	if($result)
		echo 1;
	else {
		echo mysqli_error();
	}
?>