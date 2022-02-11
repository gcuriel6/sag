<?php
	session_start();
	include 'conectar.php';
	$link = Conectarse();

	if(isset($_SESSION["menuCargado"])){
		// $_SESSION["menuCargado"] = $arraP;
		echo json_encode($_SESSION["menuCargado"]);
	}else{
		$idUsuario = $_SESSION['id_usuario'];	
		$idUnidadNegocio =  $_SESSION['id_unidad_actual'];
		
		$arr=array();
		$cont=0;

		$arraF=array();
		$contF=0;
		
		/** PRIMERO BUSCO LAS SUCURSALES ALAS QUE TIENE PERMISO EL USUARIO DE UN UNAIDAD DE NEGOCIO */
		$buscaSucursales="SELECT DISTINCT(id_sucursal) as id_sucursal FROM permisos WHERE id_usuario=".$idUsuario." AND id_unidad_negocio=".$idUnidadNegocio;
		$resultS=mysqli_query($link,$buscaSucursales) or die(mysqli_error());	
		$numS=mysqli_num_rows($resultS);
		if($numS > 0){

			while($rowS=mysqli_fetch_array($resultS)){
				$idSucursal = $rowS['id_sucursal'];
				/***OBTNENGO TODO EL MENU */
				$raiz = "GINTHERCORP";
				$query="SELECT * FROM menus";
				$result=mysqli_query($link, $query);
				$num=mysqli_num_rows($result);

				$arra2=[];
				$cont2=0;
				while($row=mysqli_fetch_array($result)) {
					$sistema = $row['sistema'];
					/***BERIFICO LOS PERMISOS DE USUSRIO EN LA UNIDAD DE NEGOCIO POR CADA SUCURSAL */
					$query2 = "SELECT permiso 
					FROM permisos 
					WHERE id_usuario = ".$idUsuario." AND pantalla = '$sistema' AND  id_unidad_negocio=".$idUnidadNegocio." AND id_sucursal=".$idSucursal;
					$result2=mysqli_query($link, $query2);
					$row2=mysqli_fetch_array($result2);
					if(isset($row2['permiso'])){
						$per_usuario = $row2['permiso'];
						/** VERIFICO A QUE OPCIONES TIENE DEL MENU SEGUN LA SECURSAL Y LO AGREGO AL ARREGLO */
						$aux = (int)$row['comando'] & (int)$per_usuario;
						if($aux > 0 && search($arr, 'hijo',$row['menuid'])==false){
							$arr[$cont++]=array('padre'=>$row['sistema'],'hijo'=>$row['menuid'],'permiso'=>$per_usuario,'alt'=>$row['alt'],'icono'=>$row['icono']);
						}
					}
				}
			}
		}


		/******* EL ARREGLO $arr contiene todos los permisos de todas las sucursales  */

		//var_dump($arr);

		/** VERIFICO SOLO LAS OPCIONES QUE SON TIPO M O QUE PERTENEECEN A GINTHERCORP */
		$queryP="SELECT * FROM menus WHERE tipo='M'";
		$resultP=mysqli_query($link, $queryP);
		$numP=mysqli_num_rows($resultP);

		$arraP=[];
		$contP=0;

		for($x=0; $x < $numP ; $x++) {
			$rowP=mysqli_fetch_array($resultP);
			$padre = $rowP['menuid'];
			$arraH=[];
			$contH=0;
			//--- recorro los permisos de todas las sucursales
			foreach ($arr as $value) {
		
				if($value['padre']==$padre){
					//--- SOMPARO SI EL HIJO YA ESTA EN EL ARREGLO YA QUE $arr contitne todos los permisos de todas las suscursales
					//-- si 2 o 3 sucursales tu¿ienen permiso a CORPORATIVO- USUARIOS ESTARA 3 VECES EN EL ARRGLO--- 
					if(search($arraH, 'hijo',$value['hijo'])==false){
				
						$arraH[$contH]=array('hijo'=> $value['hijo'],'permiso'=>$value['permiso'],'alt'=>$value['alt'],'icono'=>$value['icono']);
						$contH++;
					}
				
				}
			}

			//--- AQUI VAN TODOS LOS HIJOS DE GHINEHERCORP QUE TIENEN SUBMENU
			if(count($arraH)>0){
			
				$arraP[$contP]=array('hijo'=>$padre,'alt'=>$rowP['alt'],'icono'=>$rowP['icono'],'hijos'=>$arraH);
				$contP++;
			}
			
			//--- AQUI VA LOS HIJOS DE GINTHERCORP QUE NO TIENEN SUBMENU
			if($padre=='PORTAL_PROVEEDORES' && (search($arr, 'hijo','PORTAL_PROVEEDORES')==true)){
			
				$arraP[$contP]=array('hijo'=>'PORTAL_PROVEEDORES','alt'=>$rowP['alt'],'icono'=>$rowP['icono'],'hijos'=>$arraH);
				$contP++;
			}
					
			
		}//--fin for de menus


		$_SESSION["menuCargado"] = $arraP;
		echo json_encode($arraP);
	}

	function search($array, $key, $value) 
	{ 
		$results = array(); 

		if (is_array($array)) 
		{ 
			if (isset($array[$key]) && $array[$key] == $value) 
				$results[] = $array; 

			foreach ($array as $subarray) 
				$results = array_merge($results, search($subarray, $key, $value)); 
		} 

		return $results; 
	} 
	
?>