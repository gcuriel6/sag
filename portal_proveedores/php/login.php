<?php
	ini_set("session.cookie_lifetime","0");
	ini_set("session.gc_maxlifetime","172800");
	session_start();
	
	include 'conectar.php';
	$link = Conectarse();

	$arr_suc=array();

	//recibo los datos
	$usuario = $_REQUEST['usuario'];
	$password = $_REQUEST['password'];
	$pass_sha1 = sha1($password);
	
    $query  =  sprintf("SELECT id, nombre, password FROM proveedores WHERE rfc='%s'  AND inactivo=0",$usuario);

	$result=mysqli_query($link,$query) or die(mysqli_error());
	$num_rows = mysqli_num_rows($result);
	$row = mysqli_fetch_array($result);

	if($row){
		if($row['nombre'] != NULL){
			
			$usuarioP = $usuario;
			$idProveedor = $row['id'];
			$nombreP = $row['nombre'];
            if($pass_sha1 == $row['password'] )  //para la tabla parametros empresa
			{

                if($num_rows == 0){
                    $_SESSION['usuarioP']= $usuarioP;
                    $_SESSION['idProveedor']= $idProveedor;
					$_SESSION['nombreP']= $nombreP;
					$_SESSION['modulo']= 0;
					$_SESSION['aux'] = 0;
					$_SESSION['tipoUsuario'] = 0;

					$_SESSION["timeout"] = time();
                    
                    echo '1';
                }elseif($num_rows == 1){
                    $_SESSION['usuarioP']= $usuarioP;
                    $_SESSION['idProveedor']= $idProveedor;
					$_SESSION['nombreP']= $nombreP;
					$_SESSION['modulo']= 0;
					$_SESSION['aux'] = 0;
					$_SESSION['tipoUsuario'] = 0;

					$_SESSION["timeout"] = time();
                    echo '1';
                }else{
                    $_SESSION['usuarioP']= $usuarioP;
                    $_SESSION['idProveedor']= $idProveedor;
					$_SESSION['nombreP']= $nombreP;
					$_SESSION['modulo']= 0;
					$_SESSION['aux'] = 0;
					$_SESSION['tipoUsuario'] = 0;

					$_SESSION["timeout"] = time();

                    echo '1';
                }
			}else{
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

?>