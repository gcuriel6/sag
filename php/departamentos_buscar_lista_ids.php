<?php
    session_start();
	include('../models/Departamentos.php');

    $idsDepartamento=$_REQUEST['idsDepartamento'];

    $modeloUsuario = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloUsuario->buscarDepartamentosListaIds($idsDepartamento);
    }else{
        echo json_encode("sesion");
    }
 	
?>