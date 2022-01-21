<?php

	include '../../php/conectar.php';
	$link = Conectarse();
	
	$sucursal = $_REQUEST["sucursal"];
	
	$arreglo = array();
	
	$query = "SELECT a.*FROM deptos a 
	WHERE a.id_compania = '".$sucursal."' AND  presupuesto = 1 GROUP BY a.id_depto  ORDER BY a.des_dep";
	

	$result=mysqli_query($link, $query);
	$num = mysqli_num_rows($result);
	
	$arreglo[0]= $num;
	
	while($row = mysqli_fetch_array($result))
	{
		$id_depto = $row['id_depto'];
		
		$query2 = "SELECT fecha,IFNULL(fact_prom,'0') as fact_prom FROM facturacion_prom 
		WHERE id_depto = ".$id_depto." AND fecha <= NOW() ORDER BY fecha DESC LIMIT 1";
		$result2=mysqli_query($link, $query2);
		if($row2 = mysqli_fetch_array($result2))
		$fact_prom = $row2['fact_prom'];
		else
		$fact_prom = 0;
		
		
		$arreglo[] = array('id_depto'=>$id_depto,'cve_dep'=>$row['cve_dep'],'des_dep'=>$row['des_dep'],'inactivo'=>$row['inactivo'],'presupuesto'=>$row['presupuesto'],'validado_presupuesto'=>$row['validado_presupuesto'],'promediofac'=>$fact_prom);
	}
	echo json_encode($arreglo);
?>