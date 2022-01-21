<?php	
	header('Content-Type: charset=utf-8');
	include 'conectar.php';
	$link = Conectarse();
	
	$des_dep = $_REQUEST['des_dep'];
	$id_compania = $_REQUEST['id_sucursal'];
	$servicio = $_REQUEST['servicio'];
	
	$query = "SELECT MAX(CAST(cve_dep AS SIGNED)) as cve_dep FROM deptos WHERE id_compania = ".$id_compania;
	
	$resultado = mysql_query($query,$link);
	$row = mysql_fetch_array($resultado);
	$cve_dep = $row['cve_dep'];
	//echo $cve_dep.'<br>';
	$cve_dep = $cve_dep+1;
	
	$cve_dep = str_pad((string)$cve_dep,5,"0",STR_PAD_LEFT);
	
	
	
	$query = 'INSERT deptos (cve_dep,des_dep,id_compania,servicio) VALUES 
	("'.$cve_dep.'","'.$des_dep.'","'.$id_compania.'","'.$servicio.'") ';
	$resultado = mysql_query($query,$link);

	if($resultado){
		echo 1;
	}
	else{
		echo mysql_error();
	}
	
?>