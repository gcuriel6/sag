<?php
	session_start();			
	header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$query = 'SELECT * FROM vw_incidencias_full_quincena WHERE fecha = CURDATE() ORDER BY fecha,depto';
	if($_SESSION["id_usuario"] == 16){
		$query = 'SELECT * FROM vw_incidencias_full_quincena WHERE fecha = CURDATE() AND compania = "REAL SHINY SUCURSAL CHIHUAHUA" ORDER BY fecha,depto';
	}
	
	$resultado = mysqli_query($link,$query);
	$num = mysqli_num_rows($resultado);

	$arr = array();
	$arr[0] = $num;
	
	for($i = 1;$i<= $num ; $i++){
		$row = mysqli_fetch_array($resultado);
		$arr[$i]= array('captura'=>$row['captura'],'validado'=>$row['validado'],'registro' => $row['registro'],'depto' => $row['depto'],'fecha' => $row['fecha'],'trabajador' => $row['trab_comp'],'incidencia' => $row['incidencia'],'incidencia_aux' => $row['incidencia_aux'],'puesto' => $row['puesto'],'super_ini' => $row['super_ini'],'justificacion' => $row['justificacion'],'reemp1' => $row['reemp1'],'incidencia1' => $row['incidencia1'],'reemp2' => $row['reemp2'],'incidencia2' => $row['incidencia2'],'reemp3' => $row['reemp3'],'incidencia3' => $row['incidencia3']);
	}	
	echo json_encode($arr);
	
?>