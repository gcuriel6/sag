<?php
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto = $_REQUEST["id_depto"];
	
	$arreglo = array();
	$query = "SELECT MAX(fecha) as ultimo FROM presupuesto_historial a  WHERE a.id_depto = $id_depto AND fecha <= CURDATE()";
	$result=mysqli_query($link,$query);
	$row = mysqli_fetch_array($result);
	$ultimo = $row['ultimo'];
	
	
	$query = "SELECT a.*,b.puesto FROM presupuesto_historial a LEFT JOIN cat_puestos b ON a.id_puesto = b.id_puesto WHERE a.id_depto = ".$id_depto." AND fecha = '".$ultimo."'";
	$result=mysqli_query($link,$query);
	$num = mysqli_num_rows($result);
	$arreglo[0]= $num;
	
	while($row = mysqli_fetch_array($result))
	{
		$arreglo[] = array('registro'=>$row['registro'],'id_sucursal'=>$row['id_sucursal'],'id_depto'=>$row['id_depto'],'puesto'=>$row['puesto'],'id_puesto'=>$row['id_puesto'],'oficiales'=>$row['oficiales'],'sueldo_quincena'=>$row['sueldo_quincena'],'bono_quincena'=>$row['bono_quincena'],'tiempos_extras'=>$row['tiempos_extras'],'observaciones'=>$row['observaciones'],'validado'=>$row['validado']);
	}
	echo json_encode($arreglo);
?>