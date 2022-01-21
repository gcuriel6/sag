<?php
	ini_set("session.cookie_lifetime","0");
	ini_set("session.gc_maxlifetime","172800");
	session_start();
	
	include 'conectar.php';
	$link = Conectarse();

	$arr_suc=array();

	//recibo los datos
	$idUsuario = $_REQUEST['idUsuario'];
	
    $query  =  sprintf("SELECT id, nombre,rfc FROM proveedores WHERE id=$idUsuario  AND inactivo=0");

	$result=mysqli_query($link,$query) or die(mysqli_error());
	$num_rows = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);

	if($row){
		if($row['nombre'] != NULL){
			
			$usuarioP = $row['rfc'];
			$idProveedor = $row['id'];
            $nombreP = $row['nombre'];
            
            if($num_rows == 0){
                $_SESSION['usuarioP']= $usuarioP;
                $_SESSION['idProveedor']= $idProveedor;
                $_SESSION['nombreP']= $nombreP;
                $_SESSION['modulo']= 0;
                $_SESSION['aux'] = 0;
                $_SESSION['tipoUsuario'] = 1;
                
                echo '1';
            }elseif($num_rows == 1){
                $_SESSION['usuarioP']= $usuarioP;
                $_SESSION['idProveedor']= $idProveedor;
                $_SESSION['nombreP']= $nombreP;
                $_SESSION['modulo']= 0;
                $_SESSION['aux'] = 0;
                $_SESSION['tipoUsuario'] = 1;
                echo '1';
            }else{
                $_SESSION['usuarioP']= $usuarioP;
                $_SESSION['idProveedor']= $idProveedor;
                $_SESSION['nombreP']= $nombreP;
                $_SESSION['modulo']= 0;
                $_SESSION['aux'] = 0;
                $_SESSION['tipoUsuario'] = 1;

                echo '1';
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

?>