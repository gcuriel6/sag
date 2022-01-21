<?php
    session_start();
	include('../models/Departamentos.php');

    $idDepartamento = $_REQUEST['idDepartamento'];
    $idSupervisor = $_REQUEST['idSupervisor'];
   
    $modeloDepartamentos = new Departamentos();

    if (isset($_SESSION['usuario'])){

        echo $resultado = $modeloDepartamentos->asignarSupervisorDepartamentos($idDepartamento,$idSupervisor);
    }else{
        echo json_encode("sesion");
    }
 	
?>