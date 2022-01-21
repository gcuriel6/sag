<?php
    session_start();
	include('../models/Departamentos.php');

    $idDepartamento=$_REQUEST['idDepartamento'];

    $modeloDepartamento = new Departamentos();

    if (isset($_SESSION['usuario'])){

          echo $resultado = $modeloDepartamento->buscarDepartamentosId($idDepartamento);
    }else{
        echo json_encode("sesion");
    }
 	
?>