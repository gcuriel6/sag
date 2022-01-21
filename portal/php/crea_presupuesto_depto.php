<?php		

	header('Content-Type: charset=utf-8');
	include '../../php/conectar.php';
	$link = Conectarse();
	
	$id_sucursal = $_REQUEST['id_sucursal'];
	$id_depto = $_REQUEST['id_depto'];
	$id_puesto = $_REQUEST['id_puesto'];
	$oficiales = $_REQUEST['oficiales'];
	$sueldo = $_REQUEST['sueldo'];
	$bono = $_REQUEST['bonos'];
	$extra = $_REQUEST['extras'];
	$bono_var = $_REQUEST['bono_var'];
	$observaciones = $_REQUEST['observaciones'];
	
	$query = 'INSERT presupuesto (id_sucursal,id_depto,id_puesto,oficiales,sueldo_quincena,bono_quincena,tiempos_extras,bono_variable,observaciones) VALUES 
	("'.$id_sucursal.'","'.$id_depto.'","'.$id_puesto.'","'.$oficiales.'","'.$sueldo.'","'.$bono.'","'.$extra.'","'.$bono_var.'","'.$observaciones.'") ';
	$resultado = mysqli_query($link, $query);

	if($resultado){
		echo 1;
	}
	else{
		echo mysqli_error();
	}
	
?>