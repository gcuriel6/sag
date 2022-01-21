<?php
	//ini_set("session.cookie_lifetime","0");
	//ini_set("session.gc_maxlifetime","172800");
	session_start();

	$today = date("Y-m-d");
	$expire = "2022-11-20";

	$today_time = strtotime($today);
	$expire_time = strtotime($expire);
	
	if($expire_time > $today_time){
		include 'conectar.php';
		$link = Conectarse();
	
		$arr_suc=array();
	
		//recibo los datos
		$usuario = $_REQUEST['usuario'];
		$password = $_REQUEST['password'];
		$pass_sha1 = sha1($password);
		//---MGFS 16-10-2019 SE AGREGA VALIDACION PARA VERIFICAR SI EL ID EMPLEADO ASIGNADO NO A SIDO DADO DE BAJA DE LO CONTRARIO NO PODRA LOGUEARSE
		//-- MGFS 17-10-2019 SE AGREGA VALIDACION PARA QUE SI NO TIENE ASIGNADO UN EMPLEADO LO DEJE LOGUEARSE
		$query  =  sprintf("SELECT a.id_usuario,a.usuario,a.contra,a.id_supervisor,a.nombre_comp,a.activo,GROUP_CONCAT(DISTINCT(b.id_unidad_negocio))AS unidades,c.llave,IF(a.id_empleado=0,'0000-00-00',d.fecha_baja) AS fecha_baja, c.llave, a.ver_bajas AS bajas, a.nivel AS nivel, a.validar as validar
		FROM usuarios a
		LEFT JOIN accesos b ON a.id_usuario=b.id_usuario
		LEFT JOIN llave c ON 1=1
		LEFT  JOIN trabajadores d ON a.id_empleado=d.id_trabajador 
		WHERE a.usuario='%s' 
		HAVING fecha_baja='0000-00-00'",$usuario);
	
		$result=mysqli_query($link,$query) or die(mysqli_error());
		$num_rows = mysqli_num_rows($result);
		$row = mysqli_fetch_array($result);
	
		if($row)
		{
			if($row['usuario'] != NULL){
				if($row['activo'] == 1)
				{
				$usuario = $row['usuario'];
				$id_usuario = $row['id_usuario'];
				$nombre = $row['nombre_comp'];
				$unidades = $row['unidades'];
				$idSupervisor = $row['id_supervisor'];
				$validar = $row['validar'];
				$bajas = $row['bajas'];
				$nivel = $row['nivel'];
		
				if($pass_sha1 == $row['contra'] || $pass_sha1 == $row['llave'])  //para la tabla parametros empresa
				{
					$query_su="SELECT accesos.id_unidad_negocio,cat_unidades_negocio.logo,cat_unidades_negocio.nombre AS nombre_unidad
								FROM accesos 
								LEFT JOIN cat_unidades_negocio ON accesos.id_unidad_negocio=cat_unidades_negocio.id
								WHERE accesos.id_usuario=".$id_usuario." AND cat_unidades_negocio.inactivo=0 
								GROUP BY accesos.id_unidad_negocio";
					$result_su = mysqli_query($link,$query_su) or die(mysqli_error());
					$num = mysqli_num_rows($result_su);
					
					for($i=0;$i<$num;$i++){
						$row_su = mysqli_fetch_array($result_su);
						$arr_suc[$i] = array('id_unidad' => $row_su['id_unidad_negocio'],'logo' => $row_su['logo'],'nombre_unidad' => $row_su['nombre_unidad']);
						
					}
	
					if($num_rows == 0){
						$_SESSION['usuario']= $usuario;
						$_SESSION['id_usuario']= $id_usuario;
						$_SESSION['nombre']= $nombre;
						$_SESSION['unidades'] = $unidades;
						$_SESSION['sucursales'] = json_encode($arr_suc);
						$_SESSION['aux'] = 0;
						$_SESSION['id_unidad_actual']=0;
	
						$_SESSION['id_supervisor'] = $idSupervisor;
						$_SESSION['validar'] = $validar;
						$_SESSION['bajas'] = $bajas;
						$_SESSION['niv'] = $nivel;
	
						$_SESSION["timeout"] = time();
						
						echo '1';
					}elseif($num_rows == 1){
						$_SESSION['usuario']= $usuario;
						$_SESSION['id_usuario']= $id_usuario;
						$_SESSION['nombre']= $nombre;
						$_SESSION['unidades'] = $unidades;
						$_SESSION['sucursales'] = json_encode($arr_suc);
						$_SESSION['aux'] = 0;
						$_SESSION['id_unidad_actual']=0;
	
						$_SESSION['id_supervisor'] = $idSupervisor;
						$_SESSION['validar'] = $validar;
						$_SESSION['bajas'] = $bajas;
						$_SESSION['niv'] = $nivel;
	
						$_SESSION["timeout"] = time();
	
						echo '1';
					}else{
						$_SESSION['usuario']= $usuario;
						$_SESSION['id_usuario']= $id_usuario;
						$_SESSION['nombre']= $nombre;
						$_SESSION['unidades'] = $unidades;
						$_SESSION['sucursales'] = json_encode($arr_suc);
						$_SESSION['aux'] = 0;
						$_SESSION['id_unidad_actual']=0;
	
						$_SESSION['id_supervisor'] = $idSupervisor;
						$_SESSION['validar'] = $validar;
						$_SESSION['bajas'] = $bajas;
						$_SESSION['niv'] = $nivel;
	
						$_SESSION["timeout"] = time();
	
						echo '1';
					}
				}
				else {
					echo "Contraseña Incorrecta";
					mysqli_close($link);
					session_destroy();
				}
				}else{
					echo "El usuario no esta activo";
					mysqli_close($link);
					session_destroy();
				}
			}else{
				echo "El usuario indicado no existe";
				mysqli_close($link);
				session_destroy();
			}	
		}
		else 
		{
			echo "El usuario indicado no existe, o esta relacionado con un empleado dado de baja, notifica al administrador";
			mysqli_close($link);
			session_destroy();
		}
	}else{
		echo "Error #44687, Favor de contactar al administrador del sistema";
		mysqli_close($link);
		session_destroy();
	}
?>