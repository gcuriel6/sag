<?php
	session_start();
	include '../../php/conectar.php';
	$link = Conectarse();
	$user = $_SESSION['usuario'];

	// print_r($_SESSION);
	// exit();
	

	function checaBit($permiso_forma,$permiso_usuario)
	{	
		if(($permiso_forma & $permiso_usuario)==0)
			return 0;
		else 
			return 1;
	}
	
	function checaPermisoForma($forma,$usuario,$link){
		
		$query = "SELECT permiso FROM permisos WHERE pantalla = '$forma' AND usuario = '$usuario'";
		//echo $query;
		$Consulta=mysqli_query($link,$query);
		if($Consulta)
		{
			$row = mysqli_fetch_array($Consulta);
			
			return $row['permiso'];
		}
		else 
		{
			
			return 0;	
		}
	}

	$id_supervisor = $_REQUEST["id_supervisor"];
	$permisos = checaPermisoForma('ROLES_WEB', $user, $link);
	$per = '1';

	if(checaBit($permisos,(int)$per)){
		$query1 = "SELECT a.id_depto AS id_departamento, a.des_dep AS nom_depto, a.cve_dep as clave_d 
			FROM deptos a 
			LEFT JOIN contratos_clientes b ON a.id_depto = b.id_depto 
			WHERE a.id_compania IN (SELECT id_sucursal FROM accesos WHERE usuario='$user') AND a.inactivo = 0 AND a.tipo = 'O'
			GROUP BY clave_d,nom_depto";
	}
	else{
		$query1 = "SELECT a.id_depto AS id_departamento, a.des_dep AS nom_depto, a.cve_dep as clave_d  FROM deptos a LEFT JOIN contratos_clientes b ON a.id_depto = b.id_depto 
				 WHERE b.id_supervisor = $id_supervisor AND a.inactivo = 0 GROUP BY clave_d,nom_depto";
	}

	// echo $query1;
	// exit();

	$Consulta1=mysqli_query($link,$query1);
	while($row = mysqli_fetch_array($Consulta1))
			echo "<option class='o_departamento' value='".$row["id_departamento"]."'>".$row["clave_d"]." ".$row["nom_depto"]."</option>";
	mysql_close($link);

?>