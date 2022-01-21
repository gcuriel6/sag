<?php
	include '../../php/conectar.php';
	include("time.php");
	$link = Conectarse();
	
	function restaFecha($fech,$dias){
	list($ano,$mes,$dia) = explode('-',$fech);
	return date('Y-m-d',mktime(0,0,0,$mes,$dia-$dias,$ano));
	}

	$id_registro = $_REQUEST["id_registro"];
	$id_puesto = $_REQUEST["id_puesto"];
	$descr = $_REQUEST["descr"];
	$horas = $_REQUEST["horas"];
	$cadena = $_REQUEST["cadena"];
	$pivote = $_REQUEST["pivote"];
	
	$pivote--;
	
	$hoy = obtieneDate($link);
	$fechadia1=restaFecha($hoy,$pivote); 
	
	
	$query = "UPDATE horarios SET id_puesto = '".$id_puesto."',descr = '".$descr."', cambio = 1,
	horas = $horas, fec_ini = '".$hoy."', fechadia1 = '".$fechadia1."'";
	for($i=1;$i<=40;$i++){
		if($i<=strlen($cadena))
			$cad = "'".$cadena[$i-1]."'";
		else 
			$cad = "''";
		$query = $query.", dia".$i.' = '.$cad;
	}
	$query = $query." WHERE id_registro = $id_registro";
	

	$result=mysqli_query($link,$query);
	
	if($result)
		echo 1;
	else {
		echo mysqli_error();
	}
	 
	
?>