<?php

	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_depto= $_REQUEST["id_depto"];
	
	$arreglo = array();
	
	$query = "SELECT a.*,b.fecha,IFNULL(b.fact_prom,'0') as fact_prom  
    FROM deptos a LEFT JOIN facturacion_prom b ON a.id_depto = b.id_depto 
    WHERE a.id_depto = $id_depto ORDER BY fecha DESC LIMIT 1";
	
	$result=mysqli_query($link,  $query);
	$row = mysqli_fetch_array($result);
	
        
    $fact_prom = $row['fact_prom'];
		
		
	$arreglo = array('id_depto'=>$id_depto,'cve_dep'=>$row['cve_dep'],'des_dep'=>$row['des_dep'],'inactivo'=>$row['inactivo'],'presupuesto'=>$row['presupuesto'],'validado_presupuesto'=>$row['validado_presupuesto'],'promediofac'=>$fact_prom);
	
	echo json_encode($arreglo);
?>