<?php
	include '../../php/conectar.php';
	include("time.php");
	$link = Conectarse();
	
	function restaFecha($fech,$dias){
		list($ano,$mes,$dia) = explode('-',$fech);
   		return date('Y-m-d',mktime(0,0,0,$mes,$dia-$dias,$ano));
	}
	
	$id_depto = $_REQUEST["id_depto"];
	$id_puesto = $_REQUEST["id_puesto"];
	$descr = $_REQUEST["descr"];
	$cadena = $_REQUEST["cadena"];
	$horas = $_REQUEST["horas"];
	$pivote_hoy = $_REQUEST["pivote"];
	
	$query = "SELECT MAX(difvacante) as difvacante FROM horarios WHERE id_depto = $id_depto AND id_empleado = 0";
	$result=mysqli_query($link,$query);
	
	if($result){
		$row = mysqli_fetch_array($result);
		$difvacante = $row['difvacante'];
		$difvacante = $difvacante +1;
	}
	else {
		$difvacante = 1;
	}
	
	$pivote_hoy--;
	
	$hoy = obtieneDate($link);
	$fechadia1=restaFecha($hoy,$pivote_hoy); 
	//echo $hoy.'  piv:'.$pivote_hoy.'    '.$fechadia1;
	
	
	$tamano = strlen($cadena);
	
	$query = "INSERT INTO horarios (id_empleado,difvacante,id_horario,id_depto,id_puesto,horas,fec_ini,fechadia1,descr,cambio,dia1,dia2,dia3,dia4,dia5,dia6,dia7,dia8,dia9,dia10,dia11,dia12,dia13,dia14,dia15,dia16,dia17,dia18,dia19,dia20,dia21,dia22,dia23,dia24,dia25,dia26,dia27,dia28,dia29,dia30,dia31,dia32,dia33,dia34,dia35,dia36,dia37,dia38,dia39,dia40) 
		VALUES (0,'".$difvacante."','".$id_depto."','".$id_depto."','".$id_puesto."','".$horas."','".$hoy."','".$fechadia1."','".$descr."',1";
	
	for($i=1;$i<=40;$i++){
		if($i<=$tamano)
			$query = $query . ",'".$cadena[$i-1]."'";
		else 
			$query = $query . ",'".$cadena[$i-1]."'";
	}

	$query = $query.")";

	$result=mysqli_query($link,$query);
	$id_registro = mysqli_insert_id($link);
	
	
	if($result)
		echo json_encode(array('status'=>1,'id_registro'=>$id_registro));
	else {
		echo json_encode(array('status'=>0,'id_registro'=>mysqli_error($link)));
	}	 
	 
?>