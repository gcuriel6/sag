<?php

session_start();
include '../../php/conectar.php';
$link = Conectarse();
$user = $_SESSION['usuario'];

#echo $user;

$registro = $_REQUEST['registro'];

$query1 = "SELECT id_empleado,id_depto,incidencia_aux,reem1,incidencia1,reem2,incidencia2,reem3,incidencia3 FROM incidencias2 WHERE registro =".$registro;

$resultado1 = mysqli_query($link,$query1);
$row = mysqli_fetch_array($resultado1);


$org_emp = $row['id_empleado'];
$org_dep = $row['id_depto'];
$org_aux = $row['incidencia_aux'];
$org_rm1 = $row['reem1'];
$org_in1 = $row['incidencia1'];
$org_rm2 = $row['reem2'];
$org_in2 = $row['incidencia2'];
$org_rm3 = $row['reem3'];
$org_in3 = $row['incidencia3'];


$motivo = $_REQUEST['motivo'];
$justificacion = $_REQUEST['justificacion'];
$tipo = $_REQUEST['tipo'];
$cobro = $_REQUEST['cobro'];
$reem1 = isset($_REQUEST['reem1']) ? $_REQUEST['reem1'] : 0;
$incidencia1 = isset($_REQUEST['incidencia1'])?$_REQUEST['incidencia1']:'';
$reem2 = isset($_REQUEST['reem2']) ? $_REQUEST['reem2'] : 0;
$incidencia2 = isset($_REQUEST['incidencia2'])?$_REQUEST['incidencia2']:'';
$reem3 = isset($_REQUEST['reem3']) ? $_REQUEST['reem3'] : 0;
$incidencia3 = isset($_REQUEST['incidencia3'])?$_REQUEST['incidencia3']:'';


$query = "UPDATE incidencias2 SET validado='0',captura='0',fecha_modificacion = NOW(), incidencia_aux='".$motivo."', justificacion='".$justificacion."', reem1='".$reem1."', incidencia1 = '".$incidencia1."', reem2='".$reem2."', incidencia2='".$incidencia2."', reem3='".$reem3."', incidencia3='".$incidencia3."',evento='".$tipo."',facturable='".$cobro."' WHERE registro =".$registro;

$result = mysqli_query( $link,$query);

#$verifica = '';
if($result){

# cambiar que se inserta y hacer el cambio para que se inserte el caso del reemplaso o modificar toda la bitacora (mas facil)
	#VERIFICAR SI ES MEJOR CREAR EL CAMPO REEM_ORIGINAL, REEM_NUEVO EN LA BITACORA PARA QUE SEA IDENTIFICABLE EL CAMBIO

	if ($org_aux <> $motivo)
	{
		
		$query2 = 'INSERT bitacora_incidencias (usuario,id_empleado,id_depto,inc_original,inc_nueva,reemplazo) VALUES 
			("'.$user.'","'.$org_emp.'","'.$org_dep.'","'.$org_aux.'","'.$motivo.'",0) ';
		$resultado = mysqli_query($link,$query2);

		#$verifica .= ' ** ' . $query2;
		
	}


	if ($org_rm1 <> $reem1 and $reem1<>0) 
	{
		//$verifica .= '2';
		$query2 = 'INSERT bitacora_incidencias (usuario,id_empleado,id_empleado_nuevo,id_depto,inc_original,inc_nueva, reemplazo) VALUES ("'.$user.'","'.$org_emp.'","'.$reem1.'","'.$org_dep.'","'.$org_in1.'","'.$incidencia1.'","1") ';
		$resultado = mysqli_query($link,$query2);
		#echo 'uno'."\n";
		#$verifica .= ' ** ' . $query2;
	}
	else 
	{
		if ($org_in1<> $incidencia1) 
		{
			
			$query2 = 'INSERT bitacora_incidencias (usuario,id_empleado,id_empleado_nuevo,id_depto,inc_original,inc_nueva, reemplazo) VALUES ("'.$user.'","'.$org_emp.'","'.$reem1.'","'.$org_dep.'","'.$org_in1.'","'.$incidencia1.'","1") ';
			$resultado = mysqli_query($link,$query2);
			#echo 'dos'."\n";
			#$verifica .= ' ** ' . $query2;
		}
	}
	

	if ($org_rm2 <> $reem2 and $reem2<>0) 
	{
		
		$query2 = 'INSERT bitacora_incidencias (usuario,id_empleado,id_empleado_nuevo,id_depto,inc_original,inc_nueva, reemplazo) VALUES ("'.$user.'","'.$org_emp.'","'.$reem2.'","'.$org_dep.'","'.$org_in2.'","'.$incidencia2.'","1") ';
		$resultado = mysqli_query($link,$query2);
		#$verifica .= ' ** ' . $query2;
		#echo 'tres'."\n";
	}
	else 
	{
		if ($org_in2<> $incidencia2) 
		{
			$query2 = 'INSERT bitacora_incidencias (usuario,id_empleado,id_empleado_nuevo,id_depto,inc_original,inc_nueva, reemplazo) VALUES ("'.$user.'","'.$org_emp.'","'.$reem2.'","'.$org_dep.'","'.$org_in2.'","'.$incidencia2.'","1") ';
			$resultado = mysqli_query($link,$query2);
			#echo 'cuatro'."\n";
			#$verifica .= ' ** ' . $query2;
		}
	}


	if ($org_rm3 <> $reem3 and $reem3<>0) 
	{
		$query2 = 'INSERT bitacora_incidencias (usuario,id_empleado,id_empleado_nuevo,id_depto,inc_original,inc_nueva, reemplazo) VALUES ("'.$user.'","'.$org_emp.'","'.$reem3.'","'.$org_dep.'","'.$org_in3.'","'.$incidencia3.'","1") ';
		$resultado = mysqli_query($link,$query2);
		#$verifica .= ' ** ' . $query2;
		#echo 'cinco'."\n";
	}
	else
	{
		if ($org_in3<> $incidencia3) 
		{
			
			$query2 = 'INSERT bitacora_incidencias (usuario,id_empleado,id_empleado_nuevo,id_depto,inc_original,inc_nueva, reemplazo) VALUES ("'.$user.'","'.$org_emp.'","'.$reem3.'","'.$org_dep.'","'.$org_in3.'","'.$incidencia3.'","1") ';				
			$resultado = mysqli_query($link,$query2);
			#$verifica .= ' ** ' . $query2;
			#echo 'seis'."\n";
		}
	}




/*
	echo 'ante '.$org_aux.' incidencia '.$motivo."\n";
	echo 'reem1 '.$org_rm1.' incidencia '.$org_in1."\n";

	echo 'reem1 '.$reem1.' incidencia '.$incidencia1."\n";
*/
	echo 1;



}else{
	echo mysqli_error();
}


mysqli_free_result($result);
?>
